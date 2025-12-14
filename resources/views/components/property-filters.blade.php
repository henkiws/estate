<div class="bg-white rounded-xl shadow-sm border p-6 sticky top-4">
    <h3 class="font-bold text-lg mb-4">Filters</h3>
    
    <form method="GET" action="{{ route('properties.index') }}">
        <!-- Price Range -->
        <div class="mb-6">
            <label class="font-medium text-sm mb-2 block">Price Range</label>
            <div class="grid grid-cols-2 gap-2">
                <input type="number" name="price_min" placeholder="Min" class="px-3 py-2 border rounded-lg">
                <input type="number" name="price_max" placeholder="Max" class="px-3 py-2 border rounded-lg">
            </div>
        </div>
        
        <!-- Bedrooms -->
        <div class="mb-6">
            <label class="font-medium text-sm mb-2 block">Bedrooms</label>
            <div class="grid grid-cols-5 gap-2">
                @foreach(['1', '2', '3', '4', '5+'] as $bed)
                    <button type="submit" name="bedrooms" value="{{ $bed }}" 
                        class="px-3 py-2 border rounded-lg hover:border-teal-500 {{ request('bedrooms') == $bed ? 'border-teal-500 bg-teal-50' : '' }}">
                        {{ $bed }}
                    </button>
                @endforeach
            </div>
        </div>
        
        <!-- Property Type -->
        <div class="mb-6">
            <label class="font-medium text-sm mb-2 block">Property Type</label>
            <select name="property_type" class="w-full px-3 py-2 border rounded-lg">
                <option value="">All Types</option>
                <option value="house">House</option>
                <option value="apartment">Apartment</option>
                <option value="townhouse">Townhouse</option>
                <option value="studio">Studio</option>
            </select>
        </div>
        
        <!-- Checkboxes -->
        <div class="space-y-2 mb-6">
            <label class="flex items-center gap-2">
                <input type="checkbox" name="pet_friendly" value="1" class="rounded">
                <span class="text-sm">Pet Friendly</span>
            </label>
            <label class="flex items-center gap-2">
                <input type="checkbox" name="furnished" value="1" class="rounded">
                <span class="text-sm">Furnished</span>
            </label>
        </div>
        
        <button type="submit" class="w-full py-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700">
            Apply Filters
        </button>
    </form>
</div>