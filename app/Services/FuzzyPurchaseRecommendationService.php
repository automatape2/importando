<?php

namespace App\Services;

use FuzzyDM\Feature;
use FuzzyDM\Trimf; // Triangular Membership Function
use FuzzyDM\Trapmf; // Trapezoidal Membership Function
use FuzzyDM\Analyzer;
use FuzzyDM\Item;
use FuzzyDM\Aggregates\ArithmeticMean;

class FuzzyPurchaseRecommendationService
{
    protected $features;
    protected $items;

    public function __construct()
    {
        // Definir la característica de Demanda con una función trapezoidal
        $demand = new Feature('demand', new Trapmf(0, 20, 80, 100));

        // Definir la característica de Stock con una función triangular
        $stock = new Feature('stock', new Trimf(0, 50, 100));

        // Guardar las características
        $this->features = [$demand, $stock];
    }

    public function getRecommendation($demandValue, $stockValue)
    {
        // Crear un ítem representando la situación actual de la mype
        $item = new Item('purchase_recommendation', [
            'demand' => $demandValue,
            'stock' => $stockValue
        ]);

        // Analizar los datos usando el promedio aritmético como método de agregación
        $analyzer = new Analyzer($this->features, [$item], new ArithmeticMean());
        $analyzer->analyze();

        // Obtener la recomendación ordenada
        $sorted = $analyzer->sort();

        // Retornar el puntaje del ítem (recomendación)
        return $sorted[0]->score;
    }
}
