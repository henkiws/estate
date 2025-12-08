<x-user-layout title="Saved Properties">
    <!-- Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Saved Properties</h1>
            <p class="mt-2 text-gray-600">Properties you've saved for later</p>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-2xl border border-gray-200 p-6 mb-8">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- Listing Type -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Listing Type</label>
                <select name="listing_type" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent">
                    <option value="">All Types</option>
                    <option value="sale" {{ request('listing_type') === 'sale' ? 'selected' : '' }}>For Sale</option>
                    <option value="rent" {{ request('listing_type') === 'rent' ? 'selected' : '' }}>For Rent</option>
                </select>
            </div>

            <!-- Property Type -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Property Type</label>
                <select name="property_type" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent">
                    <option value="">All Properties</option>
                    <option value="house" {{ request('property_type') === 'house' ? 'selected' : '' }}>House</option>
                    <option value="apartment" {{ request('property_type') === 'apartment' ? 'selected' : '' }}>Apartment</option>
                    <option value="unit" {{ request('property_type') === 'unit' ? 'selected' : '' }}>Unit</option>
                    <option value="townhouse" {{ request('property_type') === 'townhouse' ? 'selected' : '' }}>Townhouse</option>
                    <option value="villa" {{ request('property_type') === 'villa' ? 'selected' : '' }}>Villa</option>
                </select>
            </div>

            <!-- Sort -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Sort By</label>
                <select name="sort" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent">
                    <option value="saved_properties.created_at" {{ request('sort') === 'saved_properties.created_at' ? 'selected' : '' }}>Recently Saved</option>
                    <option value="price" {{ request('sort') === 'price' ? 'selected' : '' }}>Price</option>
                    <option value="bedrooms" {{ request('sort') === 'bedrooms' ? 'selected' : '' }}>Bedrooms</option>
                </select>
            </div>

            <!-- Filter Button -->
            <div class="flex items-end">
                <button type="submit" class="w-full px-6 py-2 bg-primary hover:bg-primary-dark text-white font-semibold rounded-xl transition-colors">
                    Apply Filters
                </button>
            </div>
        </form>
    </div>

    @if($savedProperties->count() > 0)
        <!-- Properties Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            @foreach($savedProperties as $property)
                <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden hover:shadow-lg transition-shadow group">
                    <!-- Property Image -->
                    <a href="{{ route('properties.show', $property->property_code) }}" class="block relative h-48 bg-gray-100 overflow-hidden">
                        @if($property->featuredImage)
                            <img src="{{ Storage::disk('public')->url($property->featuredImage->file_path) }}" 
                                 alt="{{ $property->short_address }}"
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                </svg>
                            </div>
                        @endif

                        <!-- Featured Badge -->
                        @if($property->is_featured)
                            <span class="absolute top-3 left-3 px-3 py-1 bg-yellow-400 text-yellow-900 text-xs font-bold rounded-full">
                                Featured
                            </span>
                        @endif

                        <!-- Listing Type Badge -->
                        <span class="absolute top-3 right-3 px-3 py-1 bg-white/90 backdrop-blur-sm text-gray-900 text-xs font-semibold rounded-full">
                            {{ ucfirst($property->listing_type) }}
                        </span>
                    </a>

                    <!-- Property Details -->
                    <div class="p-4">
                        <div class="flex items-start justify-between mb-2">
                            <div class="flex-1">
                                <p class="text-xl font-bold text-primary mb-1">{{ $property->display_price }}</p>
                                <a href="{{ route('properties.show', $property->property_code) }}" class="font-semibold text-gray-900 hover:text-primary line-clamp-1">
                                    {{ $property->short_address }}
                                </a>
                                <p class="text-sm text-gray-600">{{ $property->suburb }}, {{ $property->state }}</p>
                            </div>
                        </div>

                        <!-- Features -->
                        <div class="flex items-center gap-4 text-sm text-gray-600 mb-4">
                            @if($property->bedrooms)
                                <span class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                    </svg>
                                    {{ $property->bedrooms }}
                                </span>
                            @endif
                            @if($property->bathrooms)
                                <span class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"/>
                                    </svg>
                                    {{ $property->bathrooms }}
                                </span>
                            @endif
                            @if($property->parking_spaces)
                                <span class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                                    </svg>
                                    {{ $property->parking_spaces }}
                                </span>
                            @endif
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center gap-2">
                            <a href="{{ route('properties.show', $property->property_code) }}" 
                               class="flex-1 px-4 py-2 bg-primary hover:bg-primary-dark text-white text-center font-medium rounded-xl transition-colors">
                                View Details
                            </a>
                            
                            <!-- Remove from Saved -->
                            <form action="{{ route('user.saved-properties.destroy', $property->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        onclick="return confirm('Remove this property from saved?')"
                                        class="px-4 py-2 border border-red-300 text-red-600 hover:bg-red-50 rounded-xl transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $savedProperties->links() }}
        </div>
    @else
        <!-- Empty State -->
        <div class="bg-white rounded-2xl border border-gray-200 p-12 text-center">
            <svg class="w-20 h-20 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
            </svg>
            <h3 class="text-xl font-bold text-gray-900 mb-2">No saved properties yet</h3>
            <p class="text-gray-600 mb-6">Start saving properties to keep track of your favorites</p>
            <a href="{{ route('properties.index') }}" class="inline-block px-6 py-3 bg-primary hover:bg-primary-dark text-white font-semibold rounded-xl transition-colors">
                Browse Properties
            </a>
        </div>
    @endif
</x-user-layout>