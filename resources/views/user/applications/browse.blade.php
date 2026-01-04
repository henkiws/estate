@extends('layouts.user')

@section('title', 'Browse Properties')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Breadcrumb -->
        <nav class="flex mb-4" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('user.applications.index') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-teal-600">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                        </svg>
                        My Applications
                    </a>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Browse Properties</span>
                    </div>
                </li>
            </ol>
        </nav>
        
        <!-- Page Header -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Browse Properties</h1>
                <p class="mt-2 text-gray-600">Find your next home from {{ number_format($totalCount) }} available properties</p>
            </div>
            
            <!-- View Toggle -->
            <div class="flex items-center gap-2 bg-gray-100 rounded-lg p-1">
                <a 
                    href="{{ route('user.applications.browse', array_merge(request()->except('view'), ['view' => 'grid'])) }}"
                    class="px-4 py-2 rounded-md text-sm font-medium transition {{ $viewMode === 'grid' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-600 hover:text-gray-900' }}"
                >
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                    </svg>
                </a>
                <a 
                    href="{{ route('user.applications.browse', array_merge(request()->except('view'), ['view' => 'list'])) }}"
                    class="px-4 py-2 rounded-md text-sm font-medium transition {{ $viewMode === 'list' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-600 hover:text-gray-900' }}"
                >
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"/>
                    </svg>
                </a>
            </div>
        </div>
        
        <!-- Filters & Search -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
            <form method="GET" action="{{ route('user.applications.browse') }}">
                <input type="hidden" name="view" value="{{ $viewMode }}">
                
                <!-- Row 1: Search and Basic Filters -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                    <!-- Search -->
                    <div class="lg:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                        <input 
                            type="text" 
                            name="search" 
                            value="{{ request('search') }}"
                            placeholder="Address, suburb, or property code..."
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent"
                        >
                    </div>
                    
                    <!-- Property Type -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Property Type</label>
                        <select 
                            name="property_type" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent"
                        >
                            <option value="">All Types</option>
                            <option value="house" {{ request('property_type') === 'house' ? 'selected' : '' }}>House</option>
                            <option value="apartment" {{ request('property_type') === 'apartment' ? 'selected' : '' }}>Apartment</option>
                            <option value="unit" {{ request('property_type') === 'unit' ? 'selected' : '' }}>Unit</option>
                            <option value="townhouse" {{ request('property_type') === 'townhouse' ? 'selected' : '' }}>Townhouse</option>
                            <option value="studio" {{ request('property_type') === 'studio' ? 'selected' : '' }}>Studio</option>
                        </select>
                    </div>
                    
                    <!-- Sort -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Sort By</label>
                        <select 
                            name="sort" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent"
                        >
                            <option value="newest" {{ request('sort') === 'newest' || !request('sort') ? 'selected' : '' }}>Newest First</option>
                            <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Oldest First</option>
                            <option value="price_low" {{ request('sort') === 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                            <option value="price_high" {{ request('sort') === 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                            <option value="bedrooms_high" {{ request('sort') === 'bedrooms_high' ? 'selected' : '' }}>Most Bedrooms</option>
                            <option value="bedrooms_low" {{ request('sort') === 'bedrooms_low' ? 'selected' : '' }}>Least Bedrooms</option>
                        </select>
                    </div>
                </div>
                
                <!-- Row 2: Room Filters -->
                <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-4">
                    <!-- Bedrooms -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Bedrooms</label>
                        <select 
                            name="bedrooms" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent"
                        >
                            <option value="">Any</option>
                            <option value="1" {{ request('bedrooms') === '1' ? 'selected' : '' }}>1+</option>
                            <option value="2" {{ request('bedrooms') === '2' ? 'selected' : '' }}>2+</option>
                            <option value="3" {{ request('bedrooms') === '3' ? 'selected' : '' }}>3+</option>
                            <option value="4" {{ request('bedrooms') === '4' ? 'selected' : '' }}>4+</option>
                            <option value="5+" {{ request('bedrooms') === '5+' ? 'selected' : '' }}>5+</option>
                        </select>
                    </div>
                    
                    <!-- Bathrooms -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Bathrooms</label>
                        <select 
                            name="bathrooms" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent"
                        >
                            <option value="">Any</option>
                            <option value="1" {{ request('bathrooms') === '1' ? 'selected' : '' }}>1+</option>
                            <option value="2" {{ request('bathrooms') === '2' ? 'selected' : '' }}>2+</option>
                            <option value="3+" {{ request('bathrooms') === '3+' ? 'selected' : '' }}>3+</option>
                        </select>
                    </div>
                    
                    <!-- Parking -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Parking</label>
                        <select 
                            name="parking" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent"
                        >
                            <option value="">Any</option>
                            <option value="1" {{ request('parking') === '1' ? 'selected' : '' }}>1+</option>
                            <option value="2+" {{ request('parking') === '2+' ? 'selected' : '' }}>2+</option>
                        </select>
                    </div>
                    
                    <!-- Price Min -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Min Price/Week</label>
                        <input 
                            type="number" 
                            name="price_min" 
                            value="{{ request('price_min') }}"
                            placeholder="$0"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent"
                        >
                    </div>
                    
                    <!-- Price Max -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Max Price/Week</label>
                        <input 
                            type="number" 
                            name="price_max" 
                            value="{{ request('price_max') }}"
                            placeholder="Any"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent"
                        >
                    </div>
                </div>
                
                <!-- Row 3: Checkboxes and Actions -->
                <div class="flex flex-wrap items-end gap-4">
                    <!-- Pet Friendly -->
                    <div class="flex items-center">
                        <input 
                            type="checkbox" 
                            id="pet_friendly" 
                            name="pet_friendly" 
                            value="1"
                            {{ request('pet_friendly') ? 'checked' : '' }}
                            class="w-4 h-4 text-teal-600 border-gray-300 rounded focus:ring-teal-500"
                        >
                        <label for="pet_friendly" class="ml-2 text-sm font-medium text-gray-700">Pet Friendly</label>
                    </div>
                    
                    <!-- Furnished -->
                    <div class="flex items-center">
                        <input 
                            type="checkbox" 
                            id="furnished" 
                            name="furnished" 
                            value="1"
                            {{ request('furnished') ? 'checked' : '' }}
                            class="w-4 h-4 text-teal-600 border-gray-300 rounded focus:ring-teal-500"
                        >
                        <label for="furnished" class="ml-2 text-sm font-medium text-gray-700">Furnished</label>
                    </div>
                    
                    <div class="flex-1"></div>
                    
                    <!-- Search Button -->
                    <button 
                        type="submit" 
                        class="px-6 py-2 bg-teal-600 text-white font-semibold rounded-lg hover:bg-teal-700 transition"
                    >
                        Apply Filters
                    </button>
                    
                    <!-- Clear Filters -->
                    @if(request()->hasAny(['search', 'property_type', 'bedrooms', 'bathrooms', 'parking', 'price_min', 'price_max', 'pet_friendly', 'furnished', 'sort']))
                        <a 
                            href="{{ route('user.applications.browse', ['view' => $viewMode]) }}" 
                            class="px-6 py-2 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 transition"
                        >
                            Clear All
                        </a>
                    @endif
                </div>
            </form>
        </div>
        
        <!-- Properties Grid/List -->
        @if($properties->count() > 0)
            @if($viewMode === 'grid')
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                    @foreach($properties as $property)
                        <x-application-property-card 
                            :property="$property" 
                            :isFavorited="in_array($property->id, $favoriteIds)"
                            :applicationStatuses="$appliedProperties[$property->id] ?? []"
                            view-mode="grid" 
                        />
                    @endforeach
                </div>
            @else
                <div class="space-y-4 mb-8">
                    @foreach($properties as $property)
                        <x-application-property-card 
                            :property="$property" 
                            :isFavorited="in_array($property->id, $favoriteIds)"
                            :applicationStatuses="$appliedProperties[$property->id] ?? []"
                            view-mode="list" 
                        />
                    @endforeach
                </div>
            @endif
            
            <!-- Pagination -->
            <div class="mt-6">
                {{ $properties->appends(request()->except('page'))->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
                <h3 class="mt-4 text-lg font-medium text-gray-900">No Properties Found</h3>
                <p class="mt-2 text-gray-600">Try adjusting your filters to see more results</p>
                <a 
                    href="{{ route('user.applications.browse', ['view' => $viewMode]) }}" 
                    class="mt-6 inline-flex items-center px-6 py-3 bg-teal-600 text-white font-semibold rounded-lg hover:bg-teal-700 transition"
                >
                    Clear Filters
                </a>
            </div>
        @endif
        
    </div>
</div>
@endsection