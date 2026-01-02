@extends('layouts.app')

@section('title', $property->title . ' - plyform')

@section('content')
<div class="min-h-screen bg-[#DDEECD]">
    
    <!-- Property Gallery Hero -->
    <div class="relative">
        {{-- <x-property-gallery :images="$property->floorplan_path" /> --}}
        <div class="relative bg-white rounded-xl overflow-hidden" style="height: 500px;">
            @if($property->floorplan_path && Storage::disk('public')->exists($property->floorplan_path))
                <img 
                    id="main-gallery-image"
                    src="{{ Storage::url($property->floorplan_path) }}" 
                    alt="{{ $property->title ?? 'Property Image' }}"
                    class="w-full h-full object-contain"
                    onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'w-full h-full flex items-center justify-center bg-gradient-to-br from-gray-100 to-gray-200\'><div class=\'text-center\'><svg class=\'w-32 h-32 mx-auto text-gray-400 mb-4\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'1.5\' d=\'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z\'></path></svg><p class=\'text-xl font-semibold text-gray-500\'>Image Not Found</p></div></div>';"
                >
            @else
                <!-- Default Placeholder -->
                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-gray-100 to-gray-200">
                    <div class="text-center">
                        <svg class="w-32 h-32 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                        <p class="text-xl font-semibold text-gray-500">No Image Available</p>
                        <p class="text-sm text-gray-400 mt-2">Property floorplan coming soon</p>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Main Content Container -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-20 relative z-10 pb-16">
        
        <!-- Property Card -->
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden">
            
            <!-- Header Section -->
            <div class="p-6 sm:p-10 lg:p-12 bg-gradient-to-br from-white to-gray-50">
                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-8">
                    
                    <!-- Property Info -->
                    <div class="flex-1">
                        <div class="flex items-start gap-4 mb-6">
                            <div class="flex-1">
                                <h1 class="text-4xl lg:text-5xl font-bold text-[#1E1C1C] mb-3 leading-tight">
                                    {{ $property->title ?? $property->street_address }}
                                </h1>
                                <p class="text-xl text-gray-600 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-[#5E17EB]" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $property->suburb }}, {{ $property->state }} {{ $property->postcode }}
                                </p>
                            </div>
                            
                            <!-- Price Badge - Mobile -->
                            <div class="lg:hidden bg-gradient-to-br from-[#5E17EB] to-[#7c3aed] text-white px-6 py-4 rounded-2xl shadow-xl text-right">
                                @if($property->listing_type === 'sale')
                                    <p class="text-3xl font-bold">${{ number_format($property->sale_price) }}</p>
                                    <p class="text-sm opacity-90">For Sale</p>
                                @else
                                    <p class="text-3xl font-bold">${{ number_format($property->rent_amount) }}</p>
                                    <p class="text-sm opacity-90">/{{ $property->rent_period }}</p>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Property Type Badge -->
                        <div class="mb-4">
                            <span class="inline-flex items-center px-4 py-2 bg-[#E6FF4B] text-[#1E1C1C] rounded-full text-sm font-bold">
                                {{ ucfirst($property->property_type) }} • {{ ucfirst($property->listing_type) }}
                            </span>
                        </div>
                        
                        <!-- Property Features Pills -->
                        <div class="flex flex-wrap gap-3">
                            @if($property->bedrooms)
                            <div class="flex items-center gap-3 bg-white px-5 py-3 rounded-full shadow-md border-2 border-[#E6FF4B]">
                                <svg class="w-6 h-6 text-[#1E1C1C]" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                                </svg>
                                <span class="font-bold text-lg">{{ $property->bedrooms }}</span>
                                <span class="text-gray-600">Bedrooms</span>
                            </div>
                            @endif
                            
                            @if($property->bathrooms)
                            <div class="flex items-center gap-3 bg-white px-5 py-3 rounded-full shadow-md border-2 border-[#E6FF4B]">
                                <svg class="w-6 h-6 text-[#1E1C1C]" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3 5a2 2 0 012-2h10a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V5zm11 1H6v8l.01.01h7.99V6z" clip-rule="evenodd"/>
                                </svg>
                                <span class="font-bold text-lg">{{ $property->bathrooms }}</span>
                                <span class="text-gray-600">Bathrooms</span>
                            </div>
                            @endif
                            
                            @if($property->car_spaces)
                            <div class="flex items-center gap-3 bg-white px-5 py-3 rounded-full shadow-md border-2 border-[#E6FF4B]">
                                <svg class="w-6 h-6 text-[#1E1C1C]" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                                    <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z"/>
                                </svg>
                                <span class="font-bold text-lg">{{ $property->car_spaces }}</span>
                                <span class="text-gray-600">Parking</span>
                            </div>
                            @endif
                            
                            @if($property->land_size)
                            <div class="flex items-center gap-3 bg-white px-5 py-3 rounded-full shadow-md border-2 border-[#E6FF4B]">
                                <svg class="w-6 h-6 text-[#1E1C1C]" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11 4a1 1 0 10-2 0v4a1 1 0 102 0V7zm-3 1a1 1 0 10-2 0v3a1 1 0 102 0V8zM8 9a1 1 0 00-2 0v2a1 1 0 102 0V9z" clip-rule="evenodd"/>
                                </svg>
                                <span class="font-bold text-lg">{{ $property->land_size }}</span>
                                <span class="text-gray-600">m²</span>
                            </div>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Action Card - Desktop -->
                    <div class="hidden lg:block flex-shrink-0 w-80">
                        <div class="bg-gradient-to-br from-[#5E17EB] to-[#7c3aed] text-white p-8 rounded-2xl shadow-2xl">
                            <p class="text-sm opacity-90 mb-2">
                                @if($property->listing_type === 'sale')
                                    Sale Price
                                @else
                                    {{ ucfirst($property->rent_period) }}ly Rent
                                @endif
                            </p>
                            <p class="text-6xl font-bold mb-6">
                                @if($property->listing_type === 'sale')
                                    ${{ number_format($property->sale_price) }}
                                @else
                                    ${{ number_format($property->rent_amount) }}
                                @endif
                            </p>
                            
                            @auth
                                <a href="{{ route('user.applications.create', ['property_id' => $property->id]) }}" 
                                    class="block w-full py-4 bg-[#E6FF4B] text-[#1E1C1C] text-center font-bold rounded-xl hover:bg-[#d4f039] transition-all shadow-lg text-lg mb-3">
                                    Apply Now
                                </a>
                                
                                <button onclick="toggleFavorite({{ $property->id }}, this)"
                                    class="w-full py-4 bg-white/10 backdrop-blur text-white border-2 border-white/30 rounded-xl hover:bg-white/20 transition-all font-semibold {{ $isFavorited ? 'bg-white/20' : '' }}">
                                    {{ $isFavorited ? '♥ Saved' : '♡ Save Property' }}
                                </button>
                            @else
                                <a href="{{ route('login', ['redirect' => url()->current()]) }}" 
                                    class="block w-full py-4 bg-[#E6FF4B] text-[#1E1C1C] text-center font-bold rounded-xl hover:bg-[#d4f039] transition-all shadow-lg text-lg">
                                    Login to Apply
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
                
                <!-- Mobile CTA Buttons -->
                <div class="lg:hidden mt-8 space-y-3">
                    @auth
                        <a href="{{ route('user.applications.create', ['property_id' => $property->id]) }}" 
                            class="block w-full py-4 btn-primary text-center font-bold rounded-xl text-lg shadow-lg">
                            Apply Now
                        </a>
                        
                        <button onclick="toggleFavorite({{ $property->id }}, this)"
                            class="w-full py-4 border-2 rounded-xl font-bold transition-all {{ $isFavorited ? 'border-red-500 text-red-500 bg-red-50' : 'border-gray-300 text-gray-700 hover:border-red-500 hover:text-red-500' }}">
                            {{ $isFavorited ? '♥ Saved' : '♡ Save Property' }}
                        </button>
                    @else
                        <a href="{{ route('login', ['redirect' => url()->current()]) }}" 
                            class="block w-full py-4 btn-primary text-center font-bold rounded-xl text-lg shadow-lg">
                            Login to Apply
                        </a>
                    @endauth
                </div>
            </div>
            
            <!-- Agency Info Section -->
            <div class="border-t border-gray-200"></div>
            @if($property->agency)
            <div class="p-6 sm:p-8 lg:p-10 bg-gradient-to-br from-gray-50 to-white border-t-2 border-gray-200">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6">
                    <div>
                        <p class="text-sm text-gray-500 uppercase tracking-wider mb-3 font-semibold">Property Managed By</p>
                        <div class="flex items-center gap-4 mb-3">
                            @if($property->agency->branding && $property->agency->branding->logo_path && Storage::disk('public')->exists($property->agency->branding->logo_path))
                                <img src="{{ Storage::url($property->agency->branding->logo_path) }}" 
                                     alt="{{ $property->agency->agency_name }}"
                                     class="h-14 object-contain"
                                     onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                                <p class="text-2xl font-bold text-[#1E1C1C]" style="display: none;">{{ $property->agency->agency_name }}</p>
                            @else
                                <p class="text-2xl font-bold text-[#1E1C1C]">{{ $property->agency->agency_name }}</p>
                            @endif
                        </div>
                    </div>
                    
                    <div class="flex flex-col sm:items-end gap-3">
                        @if($property->agency->business_phone)
                        <a href="tel:{{ $property->agency->business_phone }}" 
                           class="inline-flex items-center gap-3 px-6 py-3 bg-[#E6FF4B] text-[#1E1C1C] rounded-xl font-bold hover:bg-[#d4f039] transition-all shadow-md">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            {{ $property->agency->business_phone }}
                        </a>
                        @endif
                        @if($property->agency->business_email)
                        <a href="mailto:{{ $property->agency->business_email }}" 
                           class="text-gray-600 hover:text-[#5E17EB] transition-colors font-medium">
                            {{ $property->agency->business_email }}
                        </a>
                        @endif
                    </div>
                </div>
            </div>
            @endif
        </div>
        
        <!-- Similar Properties -->
        @if($similarProperties && $similarProperties->count() > 0)
        <div class="mt-16">
            <h2 class="text-3xl font-bold text-[#1E1C1C] mb-8 flex items-center gap-3">
                <span class="w-3 h-10 bg-gradient-to-b from-[#E6FF4B] to-[#5E17EB] rounded-full"></span>
                Similar Properties
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($similarProperties as $similar)
                    <x-property-card :property="$similar" viewMode="grid" />
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
function toggleFavorite(propertyId, button) {
    fetch(`/api/favorites/${propertyId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            if (data.favorited) {
                // Property was saved
                button.classList.add('border-red-500', 'text-red-500', 'bg-red-50');
                button.classList.remove('border-gray-300', 'text-gray-700', 'border-white/30', 'bg-white/10');
                button.innerHTML = '♥ Saved';
            } else {
                // Property was unsaved
                button.classList.remove('border-red-500', 'text-red-500', 'bg-red-50', 'bg-white/20');
                
                // Check if it's the desktop purple button or mobile button
                if (button.classList.contains('backdrop-blur')) {
                    // Desktop button - restore purple styling
                    button.classList.add('border-white/30', 'bg-white/10');
                } else {
                    // Mobile button - restore gray styling
                    button.classList.add('border-gray-300', 'text-gray-700');
                }
                button.innerHTML = '♡ Save Property';
            }
            
            // Show toast message if available
            if (window.showToast) {
                window.showToast(data.message, 'success');
            } else {
                // Fallback alert
                alert(data.message);
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        if (window.showToast) {
            window.showToast('Failed to update favorite', 'error');
        } else {
            alert('Failed to update favorite. Please try again.');
        }
    });
}
</script>
@endpush
@endsection