@props(['property', 'viewMode' => 'grid', 'isFavorited' => false])

@if($viewMode === 'grid')
    <!-- Grid View -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 hover:shadow-lg transition-all duration-300 overflow-hidden group">
        <!-- Image -->
        <div class="relative h-56 bg-gray-200 overflow-hidden">
            @if($property->images->count() > 0)
                <img 
                    src="{{ Storage::url($property->images->first()->image_path) }}" 
                    alt="{{ $property->address }}"
                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                >
            @else
                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-gray-100 to-gray-200">
                    <svg class="w-20 h-20 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                </div>
            @endif
            
            <!-- Badges -->
            <div class="absolute top-3 left-3 flex gap-2">
                @if($property->featured)
                    <span class="px-3 py-1 bg-yellow-500 text-white text-xs font-bold rounded-full shadow-lg">
                        ⭐ Featured
                    </span>
                @endif
                @if($property->pet_friendly)
                    <span class="px-3 py-1 bg-green-500 text-white text-xs font-bold rounded-full shadow-lg">
                        🐾 Pet Friendly
                    </span>
                @endif
            </div>
            
            <!-- Favorite Button -->
            @auth
                <button 
                    onclick="toggleFavorite({{ $property->id }}, this)"
                    data-property-id="{{ $property->id }}"
                    class="favorite-btn absolute top-3 right-3 w-10 h-10 rounded-full bg-white shadow-lg flex items-center justify-center hover:scale-110 transition-transform"
                >
                    <svg class="w-6 h-6 {{ $isFavorited ? 'text-red-500 fill-current' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                </button>
            @endauth
        </div>
        
        <!-- Content -->
        <div class="p-5">
            <!-- Price -->
            <div class="flex items-baseline justify-between mb-2">
                <h3 class="text-2xl font-bold text-teal-600">
                    ${{ number_format($property->price_per_week) }}
                </h3>
                <span class="text-sm text-gray-500">/week</span>
            </div>
            
            <!-- Address -->
            <p class="text-gray-900 font-medium mb-1 line-clamp-1">{{ $property->address }}</p>
            <p class="text-sm text-gray-600 mb-4">{{ $property->suburb }}, {{ $property->state }}</p>
            
            <!-- Features -->
            <div class="flex items-center gap-4 text-sm text-gray-600 mb-4 pb-4 border-b border-gray-100">
                <span class="flex items-center gap-1">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                    </svg>
                    {{ $property->bedrooms }}
                </span>
                <span class="flex items-center gap-1">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5 2a1 1 0 011 1v1h1a1 1 0 010 2H6v1a1 1 0 01-2 0V6H3a1 1 0 010-2h1V3a1 1 0 011-1zm0 10a1 1 0 011 1v1h1a1 1 0 110 2H6v1a1 1 0 11-2 0v-1H3a1 1 0 110-2h1v-1a1 1 0 011-1zM12 2a1 1 0 01.967.744L14.146 7.2 17.5 9.134a1 1 0 010 1.732l-3.354 1.935-1.18 4.455a1 1 0 01-1.933 0L9.854 12.8 6.5 10.866a1 1 0 010-1.732l3.354-1.935 1.18-4.455A1 1 0 0112 2z" clip-rule="evenodd"/>
                    </svg>
                    {{ $property->bathrooms }}
                </span>
                <span class="flex items-center gap-1">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                        <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z"/>
                    </svg>
                    {{ $property->parking_spaces }}
                </span>
            </div>
            
            <!-- CTA -->
            <a 
                href="{{ route('properties.show', $property) }}" 
                class="block w-full py-3 bg-teal-600 text-white text-center font-semibold rounded-lg hover:bg-teal-700 transition"
            >
                View Details
            </a>
        </div>
    </div>
@else
    <!-- List View -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition-all duration-300 overflow-hidden">
        <div class="flex">
            <!-- Image -->
            <div class="w-64 h-48 bg-gray-200 flex-shrink-0 overflow-hidden relative">
                @if($property->images->count() > 0)
                    <img 
                        src="{{ Storage::url($property->images->first()->image_path) }}" 
                        alt="{{ $property->address }}"
                        class="w-full h-full object-cover"
                    >
                @else
                    <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-gray-100 to-gray-200">
                        <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                    </div>
                @endif
                
                @auth
                    <button 
                        onclick="toggleFavorite({{ $property->id }}, this)"
                        class="favorite-btn absolute top-3 right-3 w-10 h-10 rounded-full bg-white shadow-lg flex items-center justify-center"
                    >
                        <svg class="w-6 h-6 {{ $isFavorited ? 'text-red-500 fill-current' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                    </button>
                @endauth
            </div>
            
            <!-- Content -->
            <div class="flex-1 p-6 flex flex-col justify-between">
                <div>
                    <div class="flex items-start justify-between mb-3">
                        <div>
                            <h3 class="text-2xl font-bold text-teal-600 mb-1">
                                ${{ number_format($property->price_per_week) }}<span class="text-sm text-gray-500">/week</span>
                            </h3>
                            <p class="text-gray-900 font-medium">{{ $property->address }}</p>
                            <p class="text-sm text-gray-600">{{ $property->suburb }}, {{ $property->state }}</p>
                        </div>
                        
                        <!-- Badges -->
                        <div class="flex flex-col gap-2">
                            @if($property->featured)
                                <span class="px-3 py-1 bg-yellow-500 text-white text-xs font-bold rounded-full">
                                    ⭐ Featured
                                </span>
                            @endif
                            @if($property->pet_friendly)
                                <span class="px-3 py-1 bg-green-500 text-white text-xs font-bold rounded-full">
                                    🐾 Pet Friendly
                                </span>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Features -->
                    <div class="flex items-center gap-6 text-gray-600 mb-4">
                        <span class="flex items-center gap-2">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                            </svg>
                            {{ $property->bedrooms }} Bedrooms
                        </span>
                        <span class="flex items-center gap-2">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5 2a1 1 0 011 1v1h1a1 1 0 010 2H6v1a1 1 0 01-2 0V6H3a1 1 0 010-2h1V3a1 1 0 011-1zm0 10a1 1 0 011 1v1h1a1 1 0 110 2H6v1a1 1 0 11-2 0v-1H3a1 1 0 110-2h1v-1a1 1 0 011-1zM12 2a1 1 0 01.967.744L14.146 7.2 17.5 9.134a1 1 0 010 1.732l-3.354 1.935-1.18 4.455a1 1 0 01-1.933 0L9.854 12.8 6.5 10.866a1 1 0 010-1.732l3.354-1.935 1.18-4.455A1 1 0 0112 2z" clip-rule="evenodd"/>
                            </svg>
                            {{ $property->bathrooms }} Bathrooms
                        </span>
                        <span class="flex items-center gap-2">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                                <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z"/>
                            </svg>
                            {{ $property->parking_spaces }} Parking
                        </span>
                    </div>
                </div>
                
                <!-- CTA -->
                <div>
                    <a 
                        href="{{ route('properties.show', $property) }}" 
                        class="inline-block px-8 py-3 bg-teal-600 text-white font-semibold rounded-lg hover:bg-teal-700 transition"
                    >
                        View Details →
                    </a>
                </div>
            </div>
        </div>
    </div>
@endif

@auth
<script>
function toggleFavorite(propertyId, button) {
    const svg = button.querySelector('svg');
    const wasFavorited = svg.classList.contains('text-red-500');
    
    // Optimistic UI update
    if (wasFavorited) {
        svg.classList.remove('text-red-500', 'fill-current');
        svg.classList.add('text-gray-400');
    } else {
        svg.classList.remove('text-gray-400');
        svg.classList.add('text-red-500', 'fill-current');
    }
    
    fetch('{{ route("user.favorites.toggle") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ property_id: propertyId })
    })
    .then(response => response.json())
    .then(data => {
        if (!data.success) {
            // Revert on error
            if (wasFavorited) {
                svg.classList.remove('text-gray-400');
                svg.classList.add('text-red-500', 'fill-current');
            } else {
                svg.classList.remove('text-red-500', 'fill-current');
                svg.classList.add('text-gray-400');
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        // Revert on error
        if (wasFavorited) {
            svg.classList.remove('text-gray-400');
            svg.classList.add('text-red-500', 'fill-current');
        } else {
            svg.classList.remove('text-red-500', 'fill-current');
            svg.classList.add('text-gray-400');
        }
    });
}
</script>
@endauth