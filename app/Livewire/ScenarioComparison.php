<?php
namespace App\Livewire;

use Livewire\Component;
use ketili\Feature;
use ketili\membership\polygon\Trimf;
use ketili\membership\polygon\Trapmf;
use ketili\Analyzer;
use ketili\Item;
use ketili\aggregation\ArithmeticMean;

class ScenarioComparison extends Component
{
    public $scenarios = [];
    public $results = [];

    public function mount()
    {
        // Inicializar 3 escenarios vacíos
        $this->scenarios = [
            ['demand' => null, 'importCost' => null, 'expectedProfitMargin' => null],
            ['demand' => null, 'importCost' => null, 'expectedProfitMargin' => null],
            ['demand' => null, 'importCost' => null, 'expectedProfitMargin' => null]
        ];
    }

    public function compareScenarios()
    {
        $this->results = []; // Limpiar resultados previos

        // Definir características y funciones de membresía
        $demandFeature = new Feature('demand', new Trapmf(70, 85, 95, 100));
        $importCostFeature = new Feature('importCost', new Trimf(0, 10, 20));
        $expectedProfitMarginFeature = new Feature('expectedProfitMargin', new Trimf(80, 90, 100));
        $features = [$demandFeature, $importCostFeature, $expectedProfitMarginFeature];

        foreach ($this->scenarios as $index => $scenario) {
            // Validación básica de datos
            if (is_numeric($scenario['demand']) && is_numeric($scenario['importCost']) && is_numeric($scenario['expectedProfitMargin'])) {
                $item = new Item('scenario_' . ($index + 1), [
                    'demand' => $scenario['demand'],
                    'importCost' => $scenario['importCost'],
                    'expectedProfitMargin' => $scenario['expectedProfitMargin'],
                ]);

                $analyzer = new Analyzer($features, [$item], new ArithmeticMean());
                $analyzer->analyze();
                $sorted = $analyzer->sort();
                $this->results[] = [
                    'scenario' => $index + 1,
                    'score' => $sorted[0]->score,
                ];
            } else {
                $this->results[] = [
                    'scenario' => $index + 1,
                    'score' => 'Invalid input'
                ];
            }
        }

        // Ordenar resultados por puntuación de mayor a menor
        usort($this->results, fn($a, $b) => $b['score'] <=> $a['score']);
    }

    public function render()
    {
        return view('livewire.scenario-comparison');
    }
}
