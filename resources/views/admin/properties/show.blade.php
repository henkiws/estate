@extends('layouts.admin')

@section('title', 'Property Details')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <a href="{{ route('admin.properties.index') }}" class="text-blue-600 hover:text-blue-800 mb-2 inline-block">
                ← Back to Properties
            </a>
            <h1 class="text-3xl font-bold text-gray-900">{{ $property->title }}</h1>
            <p class="text-gray-600 mt-1">Property ID: {{ $property->property_id }}</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.properties.edit', $property) }}" 
               class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit Property
            </a>
            <form action="{{ route('admin.properties.destroy', $property) }}" 
                  method="POST" 
                  onsubmit="return confirm('Are you sure you want to delete this property?');">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    Delete
                </button>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Images -->
            @if($property->images->count() > 0)
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h2 class="text-xl font-bold mb-4">Property Images</h2>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        @foreach($property->images as $image)
                            <div class="relative group">
                                <img src="{{ Storage::url($image->image_path) }}" 
                                     alt="Property image"
                                     class="w-full h-48 object-cover rounded-lg">
                                @if($image->is_primary)
                                    <span class="absolute top-2 left-2 bg-yellow-500 text-white text-xs px-2 py-1 rounded">
                                        Primary
                                    </span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Property Details -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-xl font-bold mb-4">Property Details</h2>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-600">Listing Type</p>
                        <p class="font-semibold">{{ ucfirst($property->listing_type) }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Property Type</p>
                        <p class="font-semibold">{{ $property->property_type }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Bedrooms</p>
                        <p class="font-semibold">{{ $property->bedrooms ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Bathrooms</p>
                        <p class="font-semibold">{{ $property->bathrooms ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Parking Spaces</p>
                        <p class="font-semibold">{{ $property->parking_spaces ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Land Size</p>
                        <p class="font-semibold">{{ $property->land_size ? number_format($property->land_size) . ' sqm' : 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Floor Size</p>
                        <p class="font-semibold">{{ $property->floor_size ? number_format($property->floor_size) . ' sqm' : 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Year Built</p>
                        <p class="font-semibold">{{ $property->year_built ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>

            <!-- Location -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-xl font-bold mb-4">Location</h2>
                <div class="space-y-2">
                    <p><strong>Address:</strong> {{ $property->street_address }}</p>
                    <p><strong>Suburb:</strong> {{ $property->suburb }}</p>
                    <p><strong>State:</strong> {{ $property->state }}</p>
                    <p><strong>Postcode:</strong> {{ $property->postcode }}</p>
                    <p><strong>Country:</strong> {{ $property->country }}</p>
                </div>
            </div>

            <!-- Description -->
            @if($property->description)
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h2 class="text-xl font-bold mb-4">Description</h2>
                    <p class="text-gray-700 whitespace-pre-line">{{ $property->description }}</p>
                </div>
            @endif

            <!-- Features -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-xl font-bold mb-4">Features & Amenities</h2>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                    @if($property->has_air_conditioning)
                        <div class="flex items-center text-green-600">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            Air Conditioning
                        </div>
                    @endif
                    @if($property->has_heating)
                        <div class="flex items-center text-green-600">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            Heating
                        </div>
                    @endif
                    @if($property->has_pool)
                        <div class="flex items-center text-green-600">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            Pool
                        </div>
                    @endif
                    @if($property->has_garage)
                        <div class="flex items-center text-green-600">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            Garage
                        </div>
                    @endif
                    @if($property->has_balcony)
                        <div class="flex items-center text-green-600">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            Balcony
                        </div>
                    @endif
                    @if($property->has_garden)
                        <div class="flex items-center text-green-600">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            Garden
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Agency Information -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-xl font-bold mb-4">Agency Information</h2>
                <div class="space-y-3">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                            <span class="text-blue-600 font-semibold">
                                {{ substr($property->agency->business_name ?? 'N/A', 0, 2) }}
                            </span>
                        </div>
                        <div>
                            <p class="font-semibold">{{ $property->agency->business_name ?? 'N/A' }}</p>
                            <p class="text-sm text-gray-500">{{ $property->agency->business_email ?? 'N/A' }}</p>
                        </div>
                    </div>
                    @if($property->agency)
                        <div class="pt-3 border-t">
                            <p class="text-sm text-gray-600">Phone:</p>
                            <p class="font-medium">{{ $property->agency->business_phone ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Address:</p>
                            <p class="font-medium">{{ $property->agency->street_address ?? 'N/A' }}</p>
                            <p class="font-medium">{{ $property->agency->suburb ?? '' }}, {{ $property->agency->state ?? '' }}</p>
                        </div>
                        <a href="{{ route('admin.agencies.show', $property->agency) }}" 
                           class="block text-center px-4 py-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition">
                            View Agency Profile
                        </a>
                    @endif
                </div>
            </div>

            <!-- Price Information -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-xl font-bold mb-4">Price Information</h2>
                @if($property->listing_type === 'sale')
                    <div class="space-y-2">
                        <p class="text-3xl font-bold text-blue-600">
                            ${{ number_format($property->sale_price) }}
                        </p>
                        @if($property->price_display)
                            <p class="text-sm text-gray-600">Display: {{ $property->price_display }}</p>
                        @endif
                        @if($property->is_price_negotiable)
                            <span class="inline-block px-2 py-1 bg-yellow-100 text-yellow-800 text-xs rounded">
                                Negotiable
                            </span>
                        @endif
                    </div>
                @else
                    <div class="space-y-2">
                        <p class="text-3xl font-bold text-blue-600">
                            ${{ number_format($property->rent_amount) }}
                        </p>
                        <p class="text-sm text-gray-600">per {{ $property->rent_period }}</p>
                        @if($property->bond_amount)
                            <p class="text-sm">Bond: ${{ number_format($property->bond_amount) }}</p>
                        @endif
                        @if($property->available_from)
                            <p class="text-sm">Available: {{ date('d M Y', strtotime($property->available_from)) }}</p>
                        @endif
                    </div>
                @endif
            </div>

            <!-- Status & Markers -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-xl font-bold mb-4">Status & Markers</h2>
                <div class="space-y-3">
                    <div>
                        <p class="text-sm text-gray-600 mb-2">Current Status:</p>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                            @if($property->status === 'active') bg-green-100 text-green-800
                            @elseif($property->status === 'pending') bg-yellow-100 text-yellow-800
                            @elseif($property->status === 'sold' || $property->status === 'rented') bg-purple-100 text-purple-800
                            @else bg-gray-100 text-gray-800
                            @endif">
                            {{ ucfirst($property->status) }}
                        </span>
                    </div>
                    
                    <div class="flex gap-2">
                        <form action="{{ route('admin.properties.toggle-featured', $property) }}" method="POST">
                            @csrf
                            <button type="submit" class="px-3 py-2 rounded-lg text-sm font-medium
                                {{ $property->featured ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-600' }}
                                hover:bg-yellow-200 transition">
                                {{ $property->featured ? '⭐ Featured' : 'Mark as Featured' }}
                            </button>
                        </form>
                    </div>
                    
                    <div class="flex gap-2">
                        <form action="{{ route('admin.properties.toggle-verified', $property) }}" method="POST">
                            @csrf
                            <button type="submit" class="px-3 py-2 rounded-lg text-sm font-medium
                                {{ $property->verified ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-600' }}
                                hover:bg-blue-200 transition">
                                {{ $property->verified ? '✓ Verified' : 'Mark as Verified' }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Metadata -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-xl font-bold mb-4">Metadata</h2>
                <div class="space-y-2 text-sm">
                    <p><strong>Created:</strong> {{ $property->created_at->format('d M Y, H:i') }}</p>
                    <p><strong>Updated:</strong> {{ $property->updated_at->format('d M Y, H:i') }}</p>
                    <p><strong>Views:</strong> {{ $property->view_count ?? 0 }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection