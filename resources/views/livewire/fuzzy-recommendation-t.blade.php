<div class="p-6 bg-white border-b border-gray-200 rounded-lg shadow">
    <h2 class="text-lg font-bold mb-4">Purchase Recommendation</h2>

    <form wire:submit.prevent="getRecommendation">
        <!-- Barra Deslizante para Demanda -->
        <div class="mb-4">
            <label for="demand" class="block text-gray-700">Demanda (0-100): <span class="font-bold">{{ $demand }}</span></label>
            <input wire:model="demand" id="demand" type="range" min="0" max="100" step="1" class="w-full">
            @error('demand') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>

        <!-- Barra Deslizante para Costo de Importación -->
        <div class="mb-4">
            <label for="importCost" class="block text-gray-700">Costo de Importacion (0-100): <span class="font-bold">{{ $importCost }}</span></label>
            <input wire:model="importCost" id="importCost" type="range" min="0" max="100" step="1" class="w-full">
            @error('importCost') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>

        <!-- Barra Deslizante para Margen de Ganancia Esperado -->
        <div class="mb-4">
            <label for="expectedProfitMargin" class="block text-gray-700">Margen Ganancia (0-100): <span class="font-bold">{{ $expectedProfitMargin }}</span></label>
            <input wire:model="expectedProfitMargin" id="expectedProfitMargin" type="range" min="0" max="100" step="1" class="w-full">
            @error('expectedProfitMargin') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>

        <!-- Botón para Enviar el Formulario -->
        <x-button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-700">Obtener recomendación</x-button>
    </form>

    <!-- Mostrar el Resultado -->
    @if($recommendedScore)
        <div class="mt-4 p-4 bg-green-100 border border-green-300 rounded-lg">
            <p class="text-green-700">Puntación: {{ round($recommendedScore * 100,2) }}%</p>
            <p class="text-green-700">Recomendado: {{ $recommendedScore >= .5 ? 'SI' : 'NO' }}</p>
        </div>
    @endif
</div>
