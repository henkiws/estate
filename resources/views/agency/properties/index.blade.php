@extends('layouts.admin')

@section('title', 'Properties')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-8 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-plyform-dark">Properties</h1>
            <p class="text-gray-600 mt-1">Manage your property listings</p>
        </div>
        <a href="{{ route('agency.properties.create') }}" class="w-full sm:w-auto px-6 py-3 bg-gradient-to-r from-plyform-yellow to-plyform-mint text-plyform-dark rounded-xl hover:from-plyform-yellow/90 hover:to-plyform-mint/90 transition font-semibold shadow-lg hover:shadow-xl flex items-center justify-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Add New Property
        </a>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6 mb-8">
        <!-- Total Properties -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 lg:p-6 hover:shadow-lg transition-shadow">
            <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-3">
                <div>
                    <p class="text-xs lg:text-sm font-medium text-gray-600">Total Properties</p>
                    <p class="text-2xl lg:text-3xl font-bold text-plyform-dark mt-1 lg:mt-2">{{ $stats['total'] }}</p>
                </div>
                <div class="w-10 h-10 lg:w-12 lg:h-12 bg-plyform-purple/10 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 lg:w-6 lg:h-6 text-plyform-purple" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Active Listings -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 lg:p-6 hover:shadow-lg transition-shadow">
            <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-3">
                <div>
                    <p class="text-xs lg:text-sm font-medium text-gray-600">Active Listings</p>
                    <p class="text-2xl lg:text-3xl font-bold text-plyform-dark mt-1 lg:mt-2">{{ $stats['active'] }}</p>
                </div>
                <div class="w-10 h-10 lg:w-12 lg:h-12 bg-plyform-mint/30 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 lg:w-6 lg:h-6 text-plyform-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- For Rent -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 lg:p-6 hover:shadow-lg transition-shadow">
            <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-3">
                <div>
                    <p class="text-xs lg:text-sm font-medium text-gray-600">For Rent</p>
                    <p class="text-2xl lg:text-3xl font-bold text-plyform-dark mt-1 lg:mt-2">{{ $stats['for_rent'] }}</p>
                </div>
                <div class="w-10 h-10 lg:w-12 lg:h-12 bg-plyform-yellow/30 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 lg:w-6 lg:h-6 text-plyform-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- For Sale -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 lg:p-6 hover:shadow-lg transition-shadow">
            <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-3">
                <div>
                    <p class="text-xs lg:text-sm font-medium text-gray-600">For Sale</p>
                    <p class="text-2xl lg:text-3xl font-bold text-plyform-orange mt-1 lg:mt-2">{{ $stats['for_sale'] }}</p>
                </div>
                <div class="w-10 h-10 lg:w-12 lg:h-12 bg-plyform-orange/10 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 lg:w-6 lg:h-6 text-plyform-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters and View Toggle -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 lg:p-6 mb-6">
        <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4 mb-4">
            <h3 class="text-lg font-semibold text-plyform-dark">Filters</h3>
            
            <!-- View Toggle -->
            <div class="flex items-center gap-2 bg-gray-100 p-1 rounded-lg">
                <button onclick="setView('grid')" id="gridViewBtn" class="px-4 py-2 rounded-md transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                    </svg>
                    <span class="hidden sm:inline">Grid</span>
                </button>
                <button onclick="setView('list')" id="listViewBtn" class="px-4 py-2 rounded-md transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                    <span class="hidden sm:inline">List</span>
                </button>
            </div>
        </div>

        <form method="GET" action="{{ route('agency.properties.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Search -->
            <div class="sm:col-span-2 lg:col-span-1">
                <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Address, code..."
                       class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-plyform-purple/20 focus:border-plyform-purple outline-none">
            </div>

            <!-- Status Filter -->
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select name="status" id="status" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-plyform-purple/20 focus:border-plyform-purple outline-none">
                    <option value="">All Status</option>
                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="sold" {{ request('status') == 'sold' ? 'selected' : '' }}>Sold</option>
                    <option value="leased" {{ request('status') == 'leased' ? 'selected' : '' }}>Leased</option>
                </select>
            </div>

            <!-- Listing Type Filter -->
            <div>
                <label for="listing_type" class="block text-sm font-medium text-gray-700 mb-2">Listing Type</label>
                <select name="listing_type" id="listing_type" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-plyform-purple/20 focus:border-plyform-purple outline-none">
                    <option value="">All Types</option>
                    <option value="rent" {{ request('listing_type') == 'rent' ? 'selected' : '' }}>For Rent</option>
                    <option value="sale" {{ request('listing_type') == 'sale' ? 'selected' : '' }}>For Sale</option>
                </select>
            </div>

            <!-- Property Type Filter -->
            <div>
                <label for="property_type" class="block text-sm font-medium text-gray-700 mb-2">Property Type</label>
                <select name="property_type" id="property_type" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-plyform-purple/20 focus:border-plyform-purple outline-none">
                    <option value="">All Properties</option>
                    <option value="house" {{ request('property_type') == 'house' ? 'selected' : '' }}>House</option>
                    <option value="apartment" {{ request('property_type') == 'apartment' ? 'selected' : '' }}>Apartment</option>
                    <option value="townhouse" {{ request('property_type') == 'townhouse' ? 'selected' : '' }}>Townhouse</option>
                    <option value="unit" {{ request('property_type') == 'unit' ? 'selected' : '' }}>Unit</option>
                    <option value="villa" {{ request('property_type') == 'villa' ? 'selected' : '' }}>Villa</option>
                </select>
            </div>

            <!-- Filter Buttons -->
            <div class="sm:col-span-2 lg:col-span-4 flex flex-col sm:flex-row gap-3">
                <button type="submit" class="px-6 py-2 bg-gradient-to-r from-plyform-purple to-plyform-dark text-white rounded-xl hover:from-plyform-purple/90 hover:to-plyform-dark/90 transition font-medium">
                    Apply Filters
                </button>
                <a href="{{ route('agency.properties.index') }}" class="px-6 py-2 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition font-medium text-center">
                    Clear Filters
                </a>
            </div>
        </form>
    </div>

    <!-- Properties Grid/List -->
    @if($properties->count() > 0)
        <!-- Grid View -->
        <div id="gridView" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 lg:gap-6 mb-8">
            @foreach($properties as $property)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition-all hover:border-plyform-purple/30 group">
                    <!-- Property Image -->
                    <div class="relative h-48 bg-gray-200">
                        @if($property->images->count() > 0)
                            <img src="{{ Storage::url($property->images->first()->file_path) }}" alt="{{ $property->full_address }}" class="w-full h-full object-cover">
                        @elseif($property->floorplan_path && !str_ends_with($property->floorplan_path, '.pdf'))
                            <img src="{{ Storage::url($property->floorplan_path) }}" alt="{{ $property->full_address }} - Floorplan" class="w-full h-full object-contain bg-white p-2">
                            <div class="absolute bottom-2 left-2 px-2 py-1 bg-plyform-purple text-white text-xs rounded">Floorplan</div>
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-plyform-purple to-plyform-dark">
                                <svg class="w-16 h-16 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                </svg>
                            </div>
                        @endif
                        
                        <!-- Status Badge -->
                        <div class="absolute top-3 right-3">
                            @if($property->status == 'active')
                                <span class="px-2 lg:px-3 py-1 bg-plyform-mint text-plyform-dark text-xs font-semibold rounded-full">Active</span>
                            @elseif($property->status == 'draft')
                                <span class="px-2 lg:px-3 py-1 bg-gray-100 text-gray-800 text-xs font-semibold rounded-full">Draft</span>
                            @elseif($property->status == 'sold')
                                <span class="px-2 lg:px-3 py-1 bg-plyform-purple/20 text-plyform-purple text-xs font-semibold rounded-full">Sold</span>
                            @elseif($property->status == 'leased')
                                <span class="px-2 lg:px-3 py-1 bg-plyform-yellow/30 text-plyform-dark text-xs font-semibold rounded-full">Leased</span>
                            @endif
                        </div>

                        <!-- Featured Badge -->
                        @if($property->is_featured)
                            <div class="absolute top-3 left-3">
                                <span class="px-2 lg:px-3 py-1 bg-plyform-yellow text-plyform-dark text-xs font-semibold rounded-full flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                    <span class="hidden sm:inline">Featured</span>
                                </span>
                            </div>
                        @endif
                    </div>

                    <!-- Property Details -->
                    <div class="p-4 lg:p-5">
                        <!-- Property Code -->
                        <div class="text-xs text-gray-500 mb-2">{{ $property->property_code }}</div>

                        <!-- Price -->
                        <div class="mb-3">
                            @if($property->listing_type == 'rent')
                                <span class="text-xl lg:text-2xl font-bold text-plyform-dark">${{ number_format($property->rent_per_week, 0) }}</span>
                                <span class="text-sm text-gray-600">per week</span>
                            @else
                                <span class="text-xl lg:text-2xl font-bold text-plyform-dark">${{ number_format($property->price, 0) }}</span>
                            @endif
                        </div>

                        <!-- Address -->
                        <h3 class="font-semibold text-plyform-dark mb-2 line-clamp-2">{{ $property->full_address }}</h3>

                        <!-- Property Features -->
                        <div class="flex items-center gap-3 lg:gap-4 text-sm text-gray-600 mb-4">
                            @if($property->bedrooms)
                                <div class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                    </svg>
                                    {{ $property->bedrooms }}
                                </div>
                            @endif
                            @if($property->bathrooms)
                                <div class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    {{ $property->bathrooms }}
                                </div>
                            @endif
                            @if($property->parking_spaces)
                                <div class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    {{ $property->parking_spaces }}
                                </div>
                            @endif
                        </div>

                        <!-- Stats -->
                        <div class="flex items-center justify-between gap-3 lg:gap-4 text-xs text-gray-500 mb-4 pb-4 border-t border-gray-200">
                            <div class="flex items-center gap-3 lg:gap-4">
                                <div class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    <span class="hidden sm:inline">{{ $property->view_count }} views</span>
                                    <span class="sm:hidden">{{ $property->view_count }}</span>
                                </div>
                                <div class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <span class="hidden sm:inline">{{ $property->applications->count() }} booking(s)</span>
                                    <span class="sm:hidden">{{ $property->applications->count() }}</span>
                                </div>
                            </div>
                            
                            <!-- Listed Date - Right Aligned -->
                            <div class="flex items-center gap-1 ml-auto">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <span class="hidden sm:inline">Listed {{ $property->created_at->diffForHumans() }}</span>
                                <span class="sm:hidden">{{ $property->created_at->diffInDays() }}d</span>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="grid grid-cols-2 gap-2">
                            <a href="{{ route('agency.properties.show', $property) }}" 
                               class="px-4 py-2 bg-gradient-to-r from-plyform-purple to-plyform-dark text-white text-sm rounded-xl hover:from-plyform-purple/90 hover:to-plyform-dark/90 transition text-center font-medium">
                                View
                            </a>
                            <a href="{{ route('agency.properties.edit', $property) }}" 
                               class="px-4 py-2 bg-gray-100 text-gray-700 text-sm rounded-xl hover:bg-gray-200 transition text-center font-medium">
                                Edit
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- List View -->
        <div id="listView" class="hidden space-y-4 mb-8">
            @foreach($properties as $property)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition-all hover:border-plyform-purple/30">
                    <div class="flex flex-col sm:flex-row">
                        <!-- Property Image -->
                        <div class="relative w-full sm:w-64 h-48 sm:h-auto bg-gray-200 flex-shrink-0">
                            @if($property->images->count() > 0)
                                <img src="{{ Storage::url($property->images->first()->file_path) }}" alt="{{ $property->full_address }}" class="w-full h-full object-cover">
                            @elseif($property->floorplan_path && !str_ends_with($property->floorplan_path, '.pdf'))
                                <img src="{{ Storage::url($property->floorplan_path) }}" alt="{{ $property->full_address }} - Floorplan" class="w-full h-full object-contain bg-white p-2">
                                <div class="absolute bottom-2 left-2 px-2 py-1 bg-plyform-purple text-white text-xs rounded">Floorplan</div>
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-plyform-purple to-plyform-dark">
                                    <svg class="w-16 h-16 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                    </svg>
                                </div>
                            @endif
                            
                            <!-- Badges -->
                            <div class="absolute top-3 right-3 flex gap-2">
                                @if($property->is_featured)
                                    <span class="px-2 py-1 bg-plyform-yellow text-plyform-dark text-xs font-semibold rounded-full">★</span>
                                @endif
                                @if($property->status == 'active')
                                    <span class="px-2 py-1 bg-plyform-mint text-plyform-dark text-xs font-semibold rounded-full">Active</span>
                                @elseif($property->status == 'draft')
                                    <span class="px-2 py-1 bg-gray-100 text-gray-800 text-xs font-semibold rounded-full">Draft</span>
                                @endif
                            </div>
                        </div>

                        <!-- Property Details -->
                        <div class="flex-1 p-4 lg:p-6">
                            <div class="flex flex-col h-full">
                                <!-- Header -->
                                <div class="flex-1">
                                    <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-2 mb-3">
                                        <div class="flex-1">
                                            <div class="text-xs text-gray-500 mb-1">{{ $property->property_code }}</div>
                                            <h3 class="font-semibold text-lg text-plyform-dark mb-2">{{ $property->full_address }}</h3>
                                        </div>
                                        <div class="text-left sm:text-right">
                                            @if($property->listing_type == 'rent')
                                                <div class="text-2xl font-bold text-plyform-purple">${{ number_format($property->rent_per_week, 0) }}</div>
                                                <div class="text-sm text-gray-600">per week</div>
                                            @else
                                                <div class="text-2xl font-bold text-plyform-purple">${{ number_format($property->price, 0) }}</div>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Features -->
                                    <div class="flex flex-wrap items-center gap-4 text-sm text-gray-600 mb-4">
                                        @if($property->bedrooms)
                                            <div class="flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                                </svg>
                                                {{ $property->bedrooms }} Bed
                                            </div>
                                        @endif
                                        @if($property->bathrooms)
                                            <div class="flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                                {{ $property->bathrooms }} Bath
                                            </div>
                                        @endif
                                        @if($property->parking_spaces)
                                            <div class="flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                </svg>
                                                {{ $property->parking_spaces }} Park
                                            </div>
                                        @endif
                                        <div class="flex items-center gap-1 text-gray-500">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            {{ $property->view_count }}
                                        </div>
                                        <div class="flex items-center gap-1 text-gray-500">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                            {{ $property->applications->count() }}
                                        </div>
                                    </div>
                                </div>

                                <!-- Actions -->
                                <div class="flex flex-col sm:flex-row gap-2 pt-4 border-t border-gray-200">
                                    <a href="{{ route('agency.properties.show', $property) }}" 
                                       class="flex-1 px-4 py-2 bg-gradient-to-r from-plyform-purple to-plyform-dark text-white text-sm rounded-xl hover:from-plyform-purple/90 hover:to-plyform-dark/90 transition text-center font-medium">
                                        View Details
                                    </a>
                                    <a href="{{ route('agency.properties.edit', $property) }}" 
                                       class="flex-1 px-4 py-2 bg-gray-100 text-gray-700 text-sm rounded-xl hover:bg-gray-200 transition text-center font-medium">
                                        Edit Property
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $properties->links() }}
        </div>
    @else
        <!-- Empty State -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 lg:p-12 text-center">
            <div class="w-20 h-20 bg-plyform-mint/20 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-10 h-10 text-plyform-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-plyform-dark mb-2">No Properties Found</h3>
            <p class="text-gray-600 mb-6">Get started by adding your first property listing.</p>
            <a href="{{ route('agency.properties.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-plyform-yellow to-plyform-mint text-plyform-dark rounded-xl hover:from-plyform-yellow/90 hover:to-plyform-mint/90 transition font-semibold shadow-lg hover:shadow-xl">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Add Your First Property
            </a>
        </div>
    @endif
</div>

<script>
// View toggle functionality
function setView(view) {
    const gridView = document.getElementById('gridView');
    const listView = document.getElementById('listView');
    const gridBtn = document.getElementById('gridViewBtn');
    const listBtn = document.getElementById('listViewBtn');
    
    if (view === 'grid') {
        gridView.classList.remove('hidden');
        listView.classList.add('hidden');
        gridBtn.classList.add('bg-white', 'text-plyform-purple', 'shadow-sm');
        gridBtn.classList.remove('text-gray-600');
        listBtn.classList.remove('bg-white', 'text-plyform-purple', 'shadow-sm');
        listBtn.classList.add('text-gray-600');
        localStorage.setItem('propertyView', 'grid');
    } else {
        gridView.classList.add('hidden');
        listView.classList.remove('hidden');
        listBtn.classList.add('bg-white', 'text-plyform-purple', 'shadow-sm');
        listBtn.classList.remove('text-gray-600');
        gridBtn.classList.remove('bg-white', 'text-plyform-purple', 'shadow-sm');
        gridBtn.classList.add('text-gray-600');
        localStorage.setItem('propertyView', 'list');
    }
}

// Load saved view preference on page load
document.addEventListener('DOMContentLoaded', function() {
    const savedView = localStorage.getItem('propertyView') || 'grid';
    setView(savedView);
});
</script>
@endsection