<div class="p-6 bg-white border-b border-gray-200 rounded-lg shadow">
    <h2 class="text-lg font-bold mb-4">Scenario Comparison</h2>

    @foreach($scenarios as $index => $scenario)
        <div class="mb-4">
            <h3 class="text-md font-semibold mb-2">Scenario {{ $index + 1 }}</h3>

            <label for="demand_{{ $index }}" class="block text-gray-700">Demand (0-100): <span class="font-bold">{{ $scenario['demand'] }}</span></label>
            <input wire:model="scenarios.{{ $index }}.demand" id="demand_{{ $index }}" type="range" min="0" max="100" step="1" class="w-full">

            <label for="importCost_{{ $index }}" class="block text-gray-700 mt-2">Import Cost (0-100): <span class="font-bold">{{ $scenario['importCost'] }}</span></label>
            <input wire:model="scenarios.{{ $index }}.importCost" id="importCost_{{ $index }}" type="range" min="0" max="100" step="1" class="w-full">

            <label for="expectedProfitMargin_{{ $index }}" class="block text-gray-700 mt-2">Expected Profit Margin (0-100): <span class="font-bold">{{ $scenario['expectedProfitMargin'] }}</span></label>
            <input wire:model="scenarios.{{ $index }}.expectedProfitMargin" id="expectedProfitMargin_{{ $index }}" type="range" min="0" max="100" step="1" class="w-full">
        </div>
    @endforeach

    <button wire:click="compareScenarios" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-700">Compare Scenarios</button>

    @if($results)
        <div class="mt-4">
            <h3 class="text-lg font-bold">Comparison Results</h3>
            <ul>
                @foreach($results as $result)
                    <li>Scenario {{ $result['scenario'] }} - Recommended Score: {{ $result['score'] }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</div>
