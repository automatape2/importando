<?php
namespace App\Livewire;

use Livewire\Component;
use ketili\Feature;
use ketili\membership\polygon\Trimf;
use ketili\membership\polygon\Trapmf;
use ketili\Analyzer;
use ketili\Item;
use ketili\aggregation\ArithmeticMean;

class FuzzyRecommendationT extends Component
{
    public $demand;
    public $importCost;
    public $expectedProfitMargin;
    public $recommendedScore;

    protected $rules = [
        'demand' => 'required|numeric|min:0|max:100',
        'importCost' => 'required|numeric|min:0|max:100',
        'expectedProfitMargin' => 'required|numeric|min:0|max:100',
    ];

    public function getRecommendation()
    {
        $this->validate();

        $demandFeature = new Feature('demand', new Trapmf(0, 80, 95, 100));
        $importCostFeature = new Feature('importCost', new Trimf(0, 0, 100));
        $expectedProfitMarginFeature = new Feature('expectedProfitMargin', new Trimf(0, 100, 100));

        // Agregar las características al array de características
        $features = [
            $demandFeature,
            $importCostFeature,
            $expectedProfitMarginFeature
        ];

        // Crear el ítem con los valores proporcionados
        $item = new Item('purchase_recommendation', [
            'demand' => $this->demand,
            'importCost' => $this->importCost,
            'expectedProfitMargin' => $this->expectedProfitMargin,
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
        return view('livewire.fuzzy-recommendation-t');
    }
}
