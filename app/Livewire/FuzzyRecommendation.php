<?php

namespace App\Http\Livewire;

use Livewire\Component;
use ketili\Feature;
use ketili\membership\polygon\Trimf;
use ketili\membership\polygon\Trapmf;
use ketili\Analyzer;
use ketili\Item;
use ketili\aggregation\ArithmeticMean;
use Livewire\Attributes\Layout;

class FuzzyRecommendation extends Component
{
    public $demand;
    public $stock;
    public $recommendedScore;

    protected $rules = [
        'demand' => 'required|numeric|min:0|max:100',
        'stock' => 'required|numeric|min:0|max:100',
    ];

    public function __construct()
    {
        $this->recommendedScore = 2;
    }

    public function getRecommendation()
    {
        $this->validate();

        // Crear las características usando funciones de membresía borrosa
        $demandFeature = new Feature('demand', new Trapmf(0, 20, 80, 100));
        $stockFeature = new Feature('stock', new Trimf(0, 50, 100));

        // Agregar las características al array de características
        $features = [$demandFeature, $stockFeature];

        // Crear el ítem con los valores de demanda y stock
        $item = new Item('purchase_recommendation', [
            'demand' => $this->demand,
            'stock' => $this->stock,
        ]);

        // Crear el analizador y calcular la recomendación
        $analyzer = new Analyzer($features, [$item], new ArithmeticMean());
        $analyzer->analyze();

        // Obtener y guardar el puntaje recomendado
        $sorted = $analyzer->sort();
        $this->recommendedScore = $sorted[0]->score;
    }

    public function render()
    {
        dd('asd');
        return view('livewire.fuzzy-recommendation');
    }
}
