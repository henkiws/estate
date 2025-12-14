@extends('layouts.app')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto px-4">
        <!-- Header -->
        <h1 class="text-3xl font-bold mb-6">Find Your Perfect Home</h1>
        
        <!-- Search Bar -->
        <form method="GET" class="mb-6">
            <div class="flex gap-4">
                <input type="text" name="search" placeholder="Search by address or suburb..." 
                    value="{{ request('search') }}"
                    class="flex-1 px-4 py-3 border rounded-lg">
                <button type="submit" class="px-8 py-3 bg-teal-600 text-white rounded-lg hover:bg-teal-700">
                    Search
                </button>
            </div>
        </form>
        
        <div class="flex gap-6">
            <!-- Filters Sidebar -->
            <div class="w-64 flex-shrink-0">
                @include('components.property-filters')
            </div>
            
            <!-- Results -->
            <div class="flex-1">
                <!-- View Toggle & Sort -->
                <div class="flex justify-between mb-6">
                    <div class="flex gap-2">
                        <a href="?view=grid" class="px-4 py-2 {{ $viewMode === 'grid' ? 'bg-teal-600 text-white' : 'bg-gray-100' }} rounded-lg">
                            Grid
                        </a>
                        <a href="?view=list" class="px-4 py-2 {{ $viewMode === 'list' ? 'bg-teal-600 text-white' : 'bg-gray-100' }} rounded-lg">
                            List
                        </a>
                    </div>
                    
                    <select name="sort" onchange="this.form.submit()" class="px-4 py-2 border rounded-lg">
                        <option value="newest">Newest First</option>
                        <option value="price_low">Price: Low to High</option>
                        <option value="price_high">Price: High to Low</option>
                    </select>
                </div>
                
                <!-- Property Grid/List -->
                @if($properties->count() > 0)
                    <div class="{{ $viewMode === 'grid' ? 'grid grid-cols-3 gap-6' : 'space-y-4' }}">
                        @foreach($properties as $property)
                            <x-property-card 
                                :property="$property" 
                                :viewMode="$viewMode"
                                :isFavorited="in_array($property->id, $favoriteIds)"
                            />
                        @endforeach
                    </div>
                    
                    <div class="mt-8">
                        {{ $properties->links() }}
                    </div>
                @else
                    <div class="text-center py-12">
                        <p class="text-gray-500">No properties found</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection