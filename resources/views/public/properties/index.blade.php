<x-public-layout title="Browse Properties">
    <!-- Hero Search Section -->
    <div class="bg-gradient-to-br from-primary to-primary-dark text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-8">
                <h1 class="text-4xl md:text-5xl font-bold mb-4">Find Your Dream Property</h1>
                <p class="text-xl text-primary-light">Browse thousands of properties from trusted agencies</p>
            </div>

            <!-- Search Form -->
            <form method="GET" action="{{ route('properties.index') }}" class="max-w-4xl mx-auto">
                <div class="bg-white rounded-2xl shadow-xl p-6">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                        <!-- Listing Type -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Type</label>
                            <select name="listing_type" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent text-gray-900">
                                <option value="">All Types</option>
                                <option value="sale" {{ request('listing_type') === 'sale' ? 'selected' : '' }}>For Sale</option>
                                <option value="rent" {{ request('listing_type') === 'rent' ? 'selected' : '' }}>For Rent</option>
                            </select>
                        </div>

                        <!-- Property Type -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Property</label>
                            <select name="property_type" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent text-gray-900">
                                <option value="">All Properties</option>
                                <option value="house" {{ request('property_type') === 'house' ? 'selected' : '' }}>House</option>
                                <option value="apartment" {{ request('property_type') === 'apartment' ? 'selected' : '' }}>Apartment</option>
                                <option value="unit" {{ request('property_type') === 'unit' ? 'selected' : '' }}>Unit</option>
                                <option value="townhouse" {{ request('property_type') === 'townhouse' ? 'selected' : '' }}>Townhouse</option>
                                <option value="land" {{ request('property_type') === 'land' ? 'selected' : '' }}>Land</option>
                            </select>
                        </div>

                        <!-- Bedrooms -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Bedrooms</label>
                            <select name="bedrooms" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent text-gray-900">
                                <option value="">Any</option>
                                <option value="1" {{ request('bedrooms') === '1' ? 'selected' : '' }}>1+</option>
                                <option value="2" {{ request('bedrooms') === '2' ? 'selected' : '' }}>2+</option>
                                <option value="3" {{ request('bedrooms') === '3' ? 'selected' : '' }}>3+</option>
                                <option value="4" {{ request('bedrooms') === '4' ? 'selected' : '' }}>4+</option>
                                <option value="5" {{ request('bedrooms') === '5' ? 'selected' : '' }}>5+</option>
                            </select>
                        </div>

                        <!-- Location Search -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Location</label>
                            <input type="text" 
                                   name="suburb" 
                                   value="{{ request('suburb') }}"
                                   placeholder="Suburb or postcode"
                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent text-gray-900">
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="text-sm text-gray-600">
                            {{ $properties->total() }} properties found
                        </div>
                        <button type="submit" class="px-8 py-3 bg-primary hover:bg-primary-dark text-white font-semibold rounded-xl transition-colors">
                            Search Properties
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        
        <!-- Featured Properties -->
        @if($featuredProperties->count() > 0 && !request()->hasAny(['search', 'listing_type', 'property_type', 'bedrooms', 'suburb']))
            <div class="mb-12">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-3xl font-bold text-gray-900">Featured Properties</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($featuredProperties as $property)
                        <a href="{{ route('properties.show', $property->property_code) }}" class="group">
                            <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden hover:shadow-xl transition-shadow">
                                <!-- Image -->
                                <div class="relative h-56 overflow-hidden">
                                    <img src="{{ $property->featured_image_url }}" 
                                         alt="{{ $property->full_address }}"
                                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                    
                                    <div class="absolute top-3 left-3">
                                        <span class="px-3 py-1 bg-yellow-500 text-white text-xs font-bold rounded-full">
                                            ⭐ FEATURED
                                        </span>
                                    </div>

                                    <div class="absolute top-3 right-3">
                                        <span class="px-3 py-1 bg-primary text-white text-xs font-semibold rounded-full">
                                            {{ ucfirst($property->listing_type) }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Content -->
                                <div class="p-5">
                                    <p class="text-2xl font-bold text-primary mb-2">{{ $property->display_price }}</p>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $property->short_address }}</h3>
                                    <p class="text-sm text-gray-600 mb-4">{{ $property->suburb }}, {{ $property->state }}</p>

                                    <!-- Features -->
                                    <div class="flex items-center gap-4 text-sm text-gray-700 mb-4">
                                        @if($property->bedrooms)
                                            <div class="flex items-center gap-1">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                                </svg>
                                                <span>{{ $property->bedrooms }}</span>
                                            </div>
                                        @endif

                                        @if($property->bathrooms)
                                            <div class="flex items-center gap-1">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"/>
                                                </svg>
                                                <span>{{ $property->bathrooms }}</span>
                                            </div>
                                        @endif

                                        @if($property->parking_spaces)
                                            <div class="flex items-center gap-1">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                                                </svg>
                                                <span>{{ $property->parking_spaces }}</span>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Agency -->
                                    <div class="pt-4 border-t border-gray-200">
                                        <p class="text-xs text-gray-500">Listed by</p>
                                        <p class="text-sm font-medium text-gray-900">{{ $property->agency->agency_name }}</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- All Properties -->
        <div>
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-3xl font-bold text-gray-900">
                    {{ request()->hasAny(['search', 'listing_type', 'property_type', 'bedrooms', 'suburb']) ? 'Search Results' : 'All Properties' }}
                </h2>
                
                <!-- Sort -->
                <div class="flex items-center gap-2">
                    <label class="text-sm text-gray-600">Sort by:</label>
                    <select onchange="window.location.href=this.value" class="px-4 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary focus:border-transparent">
                        <option value="{{ route('properties.index', array_merge(request()->except(['sort', 'direction']), ['sort' => 'created_at', 'direction' => 'desc'])) }}" {{ request('sort') === 'created_at' || !request('sort') ? 'selected' : '' }}>
                            Newest First
                        </option>
                        <option value="{{ route('properties.index', array_merge(request()->except(['sort', 'direction']), ['sort' => 'price', 'direction' => 'asc'])) }}" {{ request('sort') === 'price' && request('direction') === 'asc' ? 'selected' : '' }}>
                            Price: Low to High
                        </option>
                        <option value="{{ route('properties.index', array_merge(request()->except(['sort', 'direction']), ['sort' => 'price', 'direction' => 'desc'])) }}" {{ request('sort') === 'price' && request('direction') === 'desc' ? 'selected' : '' }}>
                            Price: High to Low
                        </option>
                        <option value="{{ route('properties.index', array_merge(request()->except(['sort', 'direction']), ['sort' => 'bedrooms', 'direction' => 'desc'])) }}" {{ request('sort') === 'bedrooms' ? 'selected' : '' }}>
                            Most Bedrooms
                        </option>
                    </select>
                </div>
            </div>

            @if($properties->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($properties as $property)
                        <a href="{{ route('properties.show', $property->property_code) }}" class="group">
                            <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden hover:shadow-xl transition-shadow">
                                <!-- Image -->
                                <div class="relative h-56 overflow-hidden">
                                    <img src="{{ $property->featured_image_url }}" 
                                         alt="{{ $property->full_address }}"
                                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                    
                                    <div class="absolute top-3 right-3">
                                        <span class="px-3 py-1 bg-primary text-white text-xs font-semibold rounded-full">
                                            {{ ucfirst($property->listing_type) }}
                                        </span>
                                    </div>

                                    @if($property->is_featured)
                                        <div class="absolute top-3 left-3">
                                            <span class="px-3 py-1 bg-yellow-500 text-white text-xs font-bold rounded-full">
                                                ⭐ FEATURED
                                            </span>
                                        </div>
                                    @endif
                                </div>

                                <!-- Content -->
                                <div class="p-5">
                                    <p class="text-2xl font-bold text-primary mb-2">{{ $property->display_price }}</p>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2 line-clamp-1">{{ $property->short_address }}</h3>
                                    <p class="text-sm text-gray-600 mb-4">{{ $property->suburb }}, {{ $property->state }}</p>

                                    <!-- Features -->
                                    <div class="flex items-center gap-4 text-sm text-gray-700 mb-4">
                                        @if($property->bedrooms)
                                            <div class="flex items-center gap-1">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                                </svg>
                                                <span>{{ $property->bedrooms }}</span>
                                            </div>
                                        @endif

                                        @if($property->bathrooms)
                                            <div class="flex items-center gap-1">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"/>
                                                </svg>
                                                <span>{{ $property->bathrooms }}</span>
                                            </div>
                                        @endif

                                        @if($property->parking_spaces)
                                            <div class="flex items-center gap-1">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                                                </svg>
                                                <span>{{ $property->parking_spaces }}</span>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Agency -->
                                    <div class="pt-4 border-t border-gray-200">
                                        <p class="text-xs text-gray-500">Listed by</p>
                                        <p class="text-sm font-medium text-gray-900">{{ $property->agency->agency_name }}</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $properties->links() }}
                </div>
            @else
                <!-- No Results -->
                <div class="text-center py-12">
                    <svg class="w-24 h-24 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">No properties found</h3>
                    <p class="text-gray-600 mb-6">Try adjusting your search filters</p>
                    <a href="{{ route('properties.index') }}" class="inline-block px-6 py-3 bg-primary hover:bg-primary-dark text-white font-semibold rounded-xl transition-colors">
                        View All Properties
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-public-layout>