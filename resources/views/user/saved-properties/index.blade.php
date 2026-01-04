@extends('layouts.user')

@section('title', 'Saved Properties')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Page Header -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Saved Properties</h1>
                <p class="mt-2 text-gray-600">You have {{ number_format($totalCount) }} saved {{ Str::plural('property', $totalCount) }}</p>
            </div>
            
            <!-- View Toggle -->
            <div class="flex items-center gap-2 bg-gray-100 rounded-lg p-1">
                <a 
                    href="{{ route('user.saved-properties.index', array_merge(request()->except('view'), ['view' => 'grid'])) }}"
                    class="px-4 py-2 rounded-md text-sm font-medium transition {{ $viewMode === 'grid' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-600 hover:text-gray-900' }}"
                >
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                    </svg>
                </a>
                <a 
                    href="{{ route('user.saved-properties.index', array_merge(request()->except('view'), ['view' => 'list'])) }}"
                    class="px-4 py-2 rounded-md text-sm font-medium transition {{ $viewMode === 'list' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-600 hover:text-gray-900' }}"
                >
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"/>
                    </svg>
                </a>
            </div>
        </div>
        
        <!-- Filters & Search -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 mb-6">
            <form method="GET" action="{{ route('user.saved-properties.index') }}" class="flex flex-wrap gap-4">
                <input type="hidden" name="view" value="{{ $viewMode }}">
                
                <!-- Search -->
                <div class="flex-1 min-w-[200px]">
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ request('search') }}"
                        placeholder="Search by address, suburb..."
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent"
                    >
                </div>
                
                <!-- Property Type Filter -->
                <div class="min-w-[180px]">
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
                <div class="min-w-[150px]">
                    <select 
                        name="sort" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent"
                    >
                        <option value="recent" {{ request('sort') === 'recent' || !request('sort') ? 'selected' : '' }}>Recently Saved</option>
                        <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Oldest First</option>
                        <option value="price_low" {{ request('sort') === 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                        <option value="price_high" {{ request('sort') === 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                    </select>
                </div>
                
                <!-- Search Button -->
                <button 
                    type="submit" 
                    class="px-6 py-2 bg-teal-600 text-white font-semibold rounded-lg hover:bg-teal-700 transition"
                >
                    Apply
                </button>
                
                <!-- Clear Filters -->
                @if(request()->hasAny(['search', 'property_type', 'sort']))
                    <a 
                        href="{{ route('user.saved-properties.index', ['view' => $viewMode]) }}" 
                        class="px-6 py-2 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 transition"
                    >
                        Clear
                    </a>
                @endif
            </form>
        </div>
        
        <!-- Saved Properties Grid/List -->
        @if($savedProperties->count() > 0)
            @if($viewMode === 'grid')
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                    @foreach($savedProperties as $saved)
                        <x-saved-property-card 
                            :property="$saved->property" 
                            :savedAt="$saved->created_at"
                            :hasApplied="in_array($saved->property->id, $appliedPropertyIds)"
                            view-mode="grid" 
                        />
                    @endforeach
                </div>
            @else
                <div class="space-y-4 mb-8">
                    @foreach($savedProperties as $saved)
                        <x-saved-property-card 
                            :property="$saved->property" 
                            :savedAt="$saved->created_at"
                            :hasApplied="in_array($saved->property->id, $appliedPropertyIds)"
                            view-mode="list" 
                        />
                    @endforeach
                </div>
            @endif
            
            <!-- Pagination -->
            <div class="mt-6">
                {{ $savedProperties->appends(request()->except('page'))->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center">
                <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No Saved Properties</h3>
                <p class="text-gray-600 mb-6">You haven't saved any properties yet. Start browsing to find your dream home!</p>
                <a 
                    href="{{ route('user.applications.browse') }}" 
                    class="inline-flex items-center px-6 py-3 bg-teal-600 text-white font-semibold rounded-lg hover:bg-teal-700 transition"
                >
                    Browse Properties
                </a>
            </div>
        @endif
        
    </div>
</div>
@endsection