@extends('layouts.admin')

@section('title', 'Properties')

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Properties</h1>
            <p class="mt-1 text-gray-600">Manage your {{ $stats['total'] }} property listings</p>
        </div>
        <a href="{{ route('agency.properties.create') }}" 
           class="inline-flex items-center gap-2 px-6 py-3 bg-primary hover:bg-primary-dark text-white font-semibold rounded-xl transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Add New Property
        </a>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-4">
        <div class="bg-white rounded-xl p-4 border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-600">Total</p>
                    <p class="mt-1 text-2xl font-bold text-gray-900">{{ $stats['total'] }}</p>
                </div>
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl p-4 border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-600">Active</p>
                    <p class="mt-1 text-2xl font-bold text-green-600">{{ $stats['active'] }}</p>
                </div>
                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl p-4 border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-600">For Sale</p>
                    <p class="mt-1 text-2xl font-bold text-purple-600">{{ $stats['for_sale'] }}</p>
                </div>
                <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl p-4 border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-600">For Rent</p>
                    <p class="mt-1 text-2xl font-bold text-orange-600">{{ $stats['for_rent'] }}</p>
                </div>
                <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl p-4 border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-600">Sold</p>
                    <p class="mt-1 text-2xl font-bold text-gray-900">{{ $stats['sold'] }}</p>
                </div>
                <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl p-4 border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-600">Leased</p>
                    <p class="mt-1 text-2xl font-bold text-teal-600">{{ $stats['leased'] }}</p>
                </div>
                <div class="w-10 h-10 bg-teal-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    {{-- Search & Filters --}}
    <div class="bg-white rounded-2xl border border-gray-200 p-6">
        <form method="GET" action="{{ route('agency.properties.index') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                {{-- Search --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                    <div class="relative">
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}"
                               placeholder="Search by address, suburb, or code..."
                               class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent">
                        <svg class="absolute left-3 top-3 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                </div>

                {{-- Status Filter --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <select name="status" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent">
                        <option value="">All Statuses</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="under_contract" {{ request('status') === 'under_contract' ? 'selected' : '' }}>Under Contract</option>
                        <option value="sold" {{ request('status') === 'sold' ? 'selected' : '' }}>Sold</option>
                        <option value="leased" {{ request('status') === 'leased' ? 'selected' : '' }}>Leased</option>
                        <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="withdrawn" {{ request('status') === 'withdrawn' ? 'selected' : '' }}>Withdrawn</option>
                    </select>
                </div>

                {{-- Listing Type Filter --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Listing Type</label>
                    <select name="listing_type" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent">
                        <option value="">All Types</option>
                        <option value="sale" {{ request('listing_type') === 'sale' ? 'selected' : '' }}>For Sale</option>
                        <option value="rent" {{ request('listing_type') === 'rent' ? 'selected' : '' }}>For Rent</option>
                        <option value="lease" {{ request('listing_type') === 'lease' ? 'selected' : '' }}>For Lease</option>
                    </select>
                </div>

                {{-- Agent Filter --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Agent</label>
                    <select name="agent_id" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent">
                        <option value="">All Agents</option>
                        @foreach($agents as $agent)
                            <option value="{{ $agent->id }}" {{ request('agent_id') == $agent->id ? 'selected' : '' }}>
                                {{ $agent->full_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <button type="submit" class="px-6 py-2.5 bg-primary hover:bg-primary-dark text-white font-medium rounded-xl transition-colors">
                    Apply Filters
                </button>
                <a href="{{ route('agency.properties.index') }}" class="px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-xl transition-colors">
                    Clear
                </a>
            </div>
        </form>
    </div>

    {{-- Properties Grid --}}
    @if($properties->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($properties as $property)
                <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden hover:shadow-lg transition-shadow">
                    {{-- Property Image --}}
                    <div class="relative h-48 bg-gray-200">
                        <img src="{{ $property->featured_image_url }}" 
                             alt="{{ $property->short_address }}"
                             class="w-full h-full object-cover">
                        
                        {{-- Badges --}}
                        <div class="absolute top-3 left-3 flex flex-col gap-2">
                            @if($property->is_featured)
                                <span class="inline-flex items-center gap-1 px-3 py-1 bg-yellow-400 text-yellow-900 text-xs font-bold rounded-full">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                    Featured
                                </span>
                            @endif
                            
                            @php
                                $listingTypeBadges = [
                                    'sale' => 'bg-blue-500 text-white',
                                    'rent' => 'bg-green-500 text-white',
                                    'lease' => 'bg-purple-500 text-white',
                                ];
                            @endphp
                            <span class="px-3 py-1 text-xs font-bold rounded-full {{ $listingTypeBadges[$property->listing_type] ?? 'bg-gray-500 text-white' }}">
                                {{ ucfirst($property->listing_type) }}
                            </span>
                        </div>

                        {{-- Status Badge --}}
                        <div class="absolute top-3 right-3">
                            @php
                                $statusBadges = [
                                    'active' => 'bg-green-100 text-green-800',
                                    'under_contract' => 'bg-orange-100 text-orange-800',
                                    'sold' => 'bg-gray-100 text-gray-800',
                                    'leased' => 'bg-teal-100 text-teal-800',
                                    'draft' => 'bg-gray-100 text-gray-600',
                                    'withdrawn' => 'bg-red-100 text-red-800',
                                ];
                            @endphp
                            <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $statusBadges[$property->status] ?? 'bg-gray-100 text-gray-800' }}">
                                {{ ucwords(str_replace('_', ' ', $property->status)) }}
                            </span>
                        </div>
                    </div>

                    {{-- Property Details --}}
                    <div class="p-5">
                        <div class="mb-3">
                            <p class="text-2xl font-bold text-primary">{{ $property->display_price }}</p>
                            <p class="text-xs text-gray-500 mt-1">{{ $property->property_code }}</p>
                        </div>

                        <h3 class="text-lg font-bold text-gray-900 mb-2 line-clamp-2 min-h-[3.5rem]">
                            {{ $property->headline ?? $property->short_address }}
                        </h3>

                        <p class="text-sm text-gray-600 mb-4 flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            {{ $property->suburb }}, {{ $property->state }}
                        </p>

                        {{-- Property Features --}}
                        <div class="flex items-center gap-4 mb-4 text-sm text-gray-600">
                            @if($property->bedrooms)
                                <div class="flex items-center gap-1">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                    </svg>
                                    <span class="font-medium">{{ $property->bedrooms }}</span>
                                </div>
                            @endif
                            
                            @if($property->bathrooms)
                                <div class="flex items-center gap-1">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"/>
                                    </svg>
                                    <span class="font-medium">{{ $property->bathrooms }}</span>
                                </div>
                            @endif
                            
                            @if($property->parking_spaces)
                                <div class="flex items-center gap-1">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"/>
                                    </svg>
                                    <span class="font-medium">{{ $property->parking_spaces }}</span>
                                </div>
                            @endif
                        </div>

                        {{-- Agent Info --}}
                        @if($property->listingAgent)
                            <div class="flex items-center gap-2 py-3 border-t border-gray-200">
                                <div class="w-8 h-8 bg-primary-light rounded-full flex items-center justify-center text-primary text-xs font-bold">
                                    {{ $property->listingAgent->initials }}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs text-gray-600">Listed by</p>
                                    <p class="text-sm font-medium text-gray-900 truncate">{{ $property->listingAgent->full_name }}</p>
                                </div>
                            </div>
                        @endif

                        {{-- Actions --}}
                        <div class="flex items-center gap-2 mt-4">
                            <a href="{{ route('agency.properties.show', $property->id) }}" 
                               class="flex-1 px-4 py-2 bg-primary hover:bg-primary-dark text-white text-sm font-medium rounded-xl text-center transition-colors">
                                View Details
                            </a>
                            <a href="{{ route('agency.properties.edit', $property->id) }}" 
                               class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-xl transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-6">
            {{ $properties->links() }}
        </div>
    @else
        {{-- Empty State --}}
        <div class="bg-white rounded-2xl border border-gray-200 p-12 text-center">
            <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">No properties found</h3>
            <p class="text-gray-600 mb-6">
                @if(request()->hasAny(['search', 'status', 'listing_type', 'agent_id']))
                    No properties match your search criteria. Try adjusting your filters.
                @else
                    Get started by adding your first property listing.
                @endif
            </p>
            @if(!request()->hasAny(['search', 'status', 'listing_type', 'agent_id']))
                <a href="{{ route('agency.properties.create') }}" 
                   class="inline-flex items-center gap-2 px-6 py-3 bg-primary hover:bg-primary-dark text-white font-semibold rounded-xl transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Add Your First Property
                </a>
            @endif
        </div>
    @endif
</div>
@endsection