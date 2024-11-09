<div class="p-6 bg-white border-b border-gray-200 rounded-lg shadow">
    <form wire:submit.prevent="getRecommendation">
        <div class="mb-4">
            <label for="demand" class="block text-gray-700">Demand (0-100)</label>
            <input wire:model="demand" id="demand" type="number" min="0" max="100" class="w-full border-gray-300 rounded-lg focus:ring focus:ring-opacity-50 focus:ring-blue-200">
            @error('demand') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="stock" class="block text-gray-700">Stock (0-100)</label>
            <input wire:model="stock" id="stock" type="number" min="0" max="100" class="w-full border-gray-300 rounded-lg focus:ring focus:ring-opacity-50 focus:ring-blue-200">
            @error('stock') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-700">Get Recommendation</button>
    </form>

    @if($recommendedScore)
        <div class="mt-4 p-4 bg-green-100 border border-green-300 rounded-lg">
            <p class="text-green-700">Recommended Score: {{ $recommendedScore }}</p>
        </div>
    @endif
</div>

