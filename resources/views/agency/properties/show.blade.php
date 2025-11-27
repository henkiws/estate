@extends('layouts.admin')

@section('title', $property->short_address)

@section('content')
<div class="space-y-6">
    {{-- Header with Actions --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center gap-4">
            <a href="{{ route('agency.properties.index') }}" 
               class="w-10 h-10 flex items-center justify-center bg-white border border-gray-200 rounded-xl hover:bg-gray-50">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900">{{ $property->short_address }}</h1>
                    @if($property->is_featured)
                        <span class="inline-flex items-center gap-1 px-2 py-1 bg-yellow-400 text-yellow-900 text-xs font-bold rounded-full">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            Featured
                        </span>
                    @endif
                </div>
                <p class="text-sm text-gray-600">{{ $property->property_code }}</p>
            </div>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('agency.properties.edit', $property) }}" 
               class="px-4 py-2 bg-primary hover:bg-primary-dark text-white font-medium rounded-xl transition-colors">
                Edit Property
            </a>
            
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" 
                        class="w-10 h-10 flex items-center justify-center bg-white border border-gray-200 rounded-xl hover:bg-gray-50">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"/>
                    </svg>
                </button>
                
                <div x-show="open" @click.away="open = false" 
                     class="absolute right-0 mt-2 w-64 bg-white rounded-xl shadow-lg border border-gray-200 py-2 z-10">
                    
                    @if(!$property->is_published)
                        <form action="{{ route('agency.properties.publish', $property) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full px-4 py-2 text-left text-sm text-gray-700 hover:bg-gray-50 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Publish Property
                            </button>
                        </form>
                    @else
                        <form action="{{ route('agency.properties.unpublish', $property) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full px-4 py-2 text-left text-sm text-gray-700 hover:bg-gray-50 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                                </svg>
                                Unpublish Property
                            </button>
                        </form>
                    @endif

                    <form action="{{ route('agency.properties.toggle-featured', $property) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full px-4 py-2 text-left text-sm text-gray-700 hover:bg-gray-50 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                            </svg>
                            {{ $property->is_featured ? 'Remove Featured' : 'Mark as Featured' }}
                        </button>
                    </form>

                    @if($property->status === 'active' && $property->listing_type === 'sale')
                        <hr class="my-2">
                        <button onclick="document.getElementById('sold-modal').classList.remove('hidden')" 
                                class="w-full px-4 py-2 text-left text-sm text-gray-700 hover:bg-gray-50 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Mark as Sold
                        </button>
                    @endif

                    <hr class="my-2">
                    <form action="{{ route('agency.properties.destroy', $property) }}" method="POST" 
                          onsubmit="return confirm('Are you sure you want to delete this property? This action cannot be undone.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full px-4 py-2 text-left text-sm text-red-600 hover:bg-red-50 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Delete Property
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Status & Price Banner --}}
    <div class="bg-gradient-to-r from-primary to-primary-dark rounded-2xl p-6 text-white">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <p class="text-3xl md:text-4xl font-bold">{{ $property->display_price }}</p>
                <p class="mt-1 text-primary-light">{{ $property->full_address }}</p>
            </div>
            <div class="flex flex-wrap gap-2">
                @php
                    $statusBadges = [
                        'active' => 'bg-green-500',
                        'under_contract' => 'bg-orange-500',
                        'sold' => 'bg-gray-500',
                        'leased' => 'bg-teal-500',
                        'draft' => 'bg-gray-400',
                    ];
                @endphp
                <span class="px-4 py-2 {{ $statusBadges[$property->status] ?? 'bg-gray-500' }} text-white text-sm font-semibold rounded-full">
                    {{ ucwords(str_replace('_', ' ', $property->status)) }}
                </span>
                <span class="px-4 py-2 bg-white text-primary text-sm font-semibold rounded-full">
                    {{ ucfirst($property->listing_type) }}
                </span>
            </div>
        </div>
    </div>

    {{-- Main Content Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Left Column --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Property Details Card --}}
            <div class="bg-white rounded-2xl border border-gray-200 p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Property Details</h2>
                
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    @if($property->bedrooms)
                        <div class="text-center">
                            <div class="w-12 h-12 bg-primary-light rounded-xl flex items-center justify-center mx-auto mb-2">
                                <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                </svg>
                            </div>
                            <p class="text-2xl font-bold text-gray-900">{{ $property->bedrooms }}</p>
                            <p class="text-sm text-gray-600">Bedrooms</p>
                        </div>
                    @endif

                    @if($property->bathrooms)
                        <div class="text-center">
                            <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mx-auto mb-2">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"/>
                                </svg>
                            </div>
                            <p class="text-2xl font-bold text-gray-900">{{ $property->bathrooms }}</p>
                            <p class="text-sm text-gray-600">Bathrooms</p>
                        </div>
                    @endif

                    @if($property->parking_spaces)
                        <div class="text-center">
                            <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center mx-auto mb-2">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"/>
                                </svg>
                            </div>
                            <p class="text-2xl font-bold text-gray-900">{{ $property->parking_spaces }}</p>
                            <p class="text-sm text-gray-600">Parking</p>
                        </div>
                    @endif

                    @if($property->land_area)
                        <div class="text-center">
                            <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center mx-auto mb-2">
                                <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/>
                                </svg>
                            </div>
                            <p class="text-2xl font-bold text-gray-900">{{ number_format($property->land_area) }}</p>
                            <p class="text-sm text-gray-600">Land m²</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Description --}}
            @if($property->headline || $property->description)
                <div class="bg-white rounded-2xl border border-gray-200 p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">About This Property</h2>
                    
                    @if($property->headline)
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">{{ $property->headline }}</h3>
                    @endif
                    
                    @if($property->description)
                        <p class="text-gray-700 leading-relaxed whitespace-pre-line">{{ $property->description }}</p>
                    @endif
                </div>
            @endif

            {{-- Features --}}
            @if($property->features && count($property->features) > 0)
                <div class="bg-white rounded-2xl border border-gray-200 p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">Features & Amenities</h2>
                    
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                        @foreach($property->features as $feature)
                            <div class="flex items-center gap-2 text-gray-700">
                                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span class="text-sm">{{ $feature }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Property Images Gallery --}}
            <div class="bg-white rounded-2xl border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-bold text-gray-900">
                        Images ({{ $property->images->count() }})
                    </h2>
                    <button onclick="document.getElementById('upload-modal').classList.remove('hidden')"
                            class="px-4 py-2 bg-primary hover:bg-primary-dark text-white text-sm font-medium rounded-xl transition-colors">
                        Upload Images
                    </button>
                </div>

                @if($property->images->count() > 0)
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        @foreach($property->images as $image)
                            <div class="relative group">
                                <img src="{{ $image->url }}" alt="{{ $property->short_address }}"
                                     class="w-full h-32 object-cover rounded-xl">
                                
                                @if($image->is_featured)
                                    <div class="absolute top-2 left-2">
                                        <span class="px-2 py-1 bg-yellow-400 text-yellow-900 text-xs font-bold rounded-full">Featured</span>
                                    </div>
                                @endif

                                <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 rounded-xl transition-all flex items-center justify-center gap-2 opacity-0 group-hover:opacity-100">
                                    @if(!$image->is_featured)
                                        <form action="{{ route('agency.properties.set-featured-image', [$property, $image]) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="p-2 bg-white rounded-lg hover:bg-gray-100">
                                                <svg class="w-4 h-4 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                    
                                    <form action="{{ route('agency.properties.delete-image', [$property, $image]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Delete this image?')" 
                                                class="p-2 bg-white rounded-lg hover:bg-red-50">
                                            <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12 text-gray-500">
                        <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <p>No images uploaded yet</p>
                        <button onclick="document.getElementById('upload-modal').classList.remove('hidden')"
                                class="mt-4 text-primary hover:underline">
                            Upload images
                        </button>
                    </div>
                @endif
            </div>
        </div>

        {{-- Right Column --}}
        <div class="space-y-6">
            {{-- Stats Card --}}
            <div class="bg-white rounded-2xl border border-gray-200 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Property Stats</h3>
                
                <div class="space-y-3">
                    <div class="flex items-center justify-between py-2 border-b border-gray-100">
                        <span class="text-sm text-gray-600">Views</span>
                        <span class="text-sm font-semibold text-gray-900">{{ number_format($property->view_count) }}</span>
                    </div>
                    <div class="flex items-center justify-between py-2 border-b border-gray-100">
                        <span class="text-sm text-gray-600">Enquiries</span>
                        <span class="text-sm font-semibold text-gray-900">{{ number_format($property->enquiry_count) }}</span>
                    </div>
                    <div class="flex items-center justify-between py-2">
                        <span class="text-sm text-gray-600">Inspections</span>
                        <span class="text-sm font-semibold text-gray-900">{{ number_format($property->inspection_count) }}</span>
                    </div>
                </div>
            </div>

            {{-- Agent Card --}}
            @if($property->listingAgent)
                <div class="bg-white rounded-2xl border border-gray-200 p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Listing Agent</h3>
                    
                    <div class="flex items-center gap-4 mb-4">
                        @if($property->listingAgent->photo)
                            <img src="{{ $property->listingAgent->photo_url }}" alt="{{ $property->listingAgent->full_name }}"
                                 class="w-16 h-16 rounded-full object-cover">
                        @else
                            <div class="w-16 h-16 bg-primary-light rounded-full flex items-center justify-center text-primary text-xl font-bold">
                                {{ $property->listingAgent->initials }}
                            </div>
                        @endif
                        <div class="flex-1">
                            <p class="font-bold text-gray-900">{{ $property->listingAgent->full_name }}</p>
                            <p class="text-sm text-gray-600">{{ $property->listingAgent->position }}</p>
                        </div>
                    </div>
                    
                    <div class="space-y-2">
                        @if($property->listingAgent->email)
                            <a href="mailto:{{ $property->listingAgent->email }}" 
                               class="flex items-center gap-2 text-sm text-gray-600 hover:text-primary">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                {{ $property->listingAgent->email }}
                            </a>
                        @endif
                        @if($property->listingAgent->mobile)
                            <a href="tel:{{ $property->listingAgent->mobile }}" 
                               class="flex items-center gap-2 text-sm text-gray-600 hover:text-primary">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                                {{ $property->listingAgent->mobile }}
                            </a>
                        @endif
                    </div>
                    
                    <a href="{{ route('agency.agents.show', $property->listingAgent) }}" 
                       class="mt-4 block w-full px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-xl text-center transition-colors">
                        View Agent Profile
                    </a>
                </div>
            @endif

            {{-- Property Info Card --}}
            <div class="bg-white rounded-2xl border border-gray-200 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Property Information</h3>
                
                <div class="space-y-3 text-sm">
                    <div>
                        <p class="text-gray-600">Property Type</p>
                        <p class="font-semibold text-gray-900">{{ ucfirst($property->property_type) }}</p>
                    </div>
                    
                    @if($property->year_built)
                        <div>
                            <p class="text-gray-600">Year Built</p>
                            <p class="font-semibold text-gray-900">{{ $property->year_built }}</p>
                        </div>
                    @endif
                    
                    @if($property->floor_area)
                        <div>
                            <p class="text-gray-600">Floor Area</p>
                            <p class="font-semibold text-gray-900">{{ number_format($property->floor_area) }} m²</p>
                        </div>
                    @endif
                    
                    @if($property->listed_at)
                        <div>
                            <p class="text-gray-600">Listed Date</p>
                            <p class="font-semibold text-gray-900">{{ $property->listed_at->format('d M Y') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Upload Images Modal --}}
<div id="upload-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-2xl max-w-lg w-full p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-xl font-bold text-gray-900">Upload Images</h3>
            <button onclick="document.getElementById('upload-modal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        
        <form action="{{ route('agency.properties.upload-images', $property) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <input type="file" name="images[]" multiple accept="image/*" required
                       class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent">
                <p class="mt-2 text-xs text-gray-500">You can upload up to 20 images. Max 5MB per image.</p>
            </div>
            
            <div class="flex gap-3">
                <button type="button" onclick="document.getElementById('upload-modal').classList.add('hidden')"
                        class="flex-1 px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-xl transition-colors">
                    Cancel
                </button>
                <button type="submit"
                        class="flex-1 px-4 py-2.5 bg-primary hover:bg-primary-dark text-white font-semibold rounded-xl transition-colors">
                    Upload
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Mark as Sold Modal --}}
<div id="sold-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-2xl max-w-lg w-full p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-xl font-bold text-gray-900">Mark as Sold</h3>
            <button onclick="document.getElementById('sold-modal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        
        <form action="{{ route('agency.properties.mark-sold', $property) }}" method="POST">
            @csrf
            <div class="space-y-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Sale Price ($)</label>
                    <input type="number" name="sale_price" step="0.01" value="{{ $property->price }}"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Sale Date</label>
                    <input type="date" name="sale_date" value="{{ date('Y-m-d') }}"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent">
                </div>
            </div>
            
            <div class="flex gap-3">
                <button type="button" onclick="document.getElementById('sold-modal').classList.add('hidden')"
                        class="flex-1 px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-xl transition-colors">
                    Cancel
                </button>
                <button type="submit"
                        class="flex-1 px-4 py-2.5 bg-primary hover:bg-primary-dark text-white font-semibold rounded-xl transition-colors">
                    Mark as Sold
                </button>
            </div>
        </form>
    </div>
</div>
@endsection