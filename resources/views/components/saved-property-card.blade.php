@props(['property', 'savedAt', 'hasApplied' => false, 'viewMode' => 'grid'])

@php
    $primaryImage = $property->images->first();
    $hasValidImage = false;
    $imageUrl = '';
    
    if ($primaryImage && Storage::disk('public')->exists($primaryImage->file_path)) {
        $hasValidImage = true;
        $imageUrl = asset('storage/' . $primaryImage->file_path);
    }
@endphp

@if($viewMode === 'grid')
    <!-- Grid View Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition group">
        <!-- Image -->
        <div class="relative aspect-[4/3] overflow-hidden bg-gray-100">
            @if($hasValidImage)
                <img 
                    src="{{ $imageUrl }}" 
                    alt="{{ $property->address }}"
                    class="w-full h-full object-cover group-hover:scale-105 transition duration-300"
                    onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'w-full h-full flex items-center justify-center bg-gradient-to-br from-gray-100 to-gray-200\'><div class=\'text-center p-4\'><svg class=\'w-16 h-16 mx-auto text-gray-400 mb-3\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'1.5\' d=\'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z\'></path></svg><p class=\'text-sm font-semibold text-gray-500\'>No Image Available</p></div></div>';"
                >
            @else
                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-gray-100 to-gray-200">
                    <div class="text-center p-4">
                        <svg class="w-16 h-16 mx-auto text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <p class="text-sm font-semibold text-gray-500">No Image Available</p>
                    </div>
                </div>
            @endif
            
            <!-- Remove Button -->
            <button 
                onclick="removeSavedProperty({{ $property->id }}, this)"
                class="absolute top-3 right-3 p-2 bg-white/90 backdrop-blur-sm rounded-full hover:bg-white transition text-red-500 hover:text-red-600"
                title="Remove from saved"
            >
                <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                    <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
                </svg>
            </button>
            
            <!-- Applied Badge -->
            @if($hasApplied)
                <div class="absolute top-3 left-3">
                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                        Applied
                    </span>
                </div>
            @endif
            
            <!-- Price Badge -->
            <div class="absolute bottom-3 left-3">
                <span class="px-3 py-1 bg-teal-600 text-white text-sm font-bold rounded-lg">
                    ${{ number_format($property->price_per_week) }}/week
                </span>
            </div>
        </div>
        
        <!-- Content -->
        <div class="p-4">
            <!-- Saved Date -->
            <p class="text-xs text-gray-500 mb-2">Saved {{ $savedAt->diffForHumans() }}</p>
            
            <!-- Property Code -->
            <p class="text-xs text-gray-500 font-medium mb-1">{{ $property->property_code }}</p>
            
            <!-- Address -->
            <h3 class="text-lg font-bold text-gray-900 mb-1 line-clamp-1">
                {{ $property->address }}
            </h3>
            <p class="text-sm text-gray-600 mb-3">{{ $property->suburb }}, {{ $property->state }} {{ $property->postcode }}</p>
            
            <!-- Features -->
            <div class="flex items-center gap-4 mb-4 text-sm text-gray-600">
                <div class="flex items-center gap-1">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                    </svg>
                    <span>{{ $property->bedrooms }} bed</span>
                </div>
                <div class="flex items-center gap-1">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd"/>
                    </svg>
                    <span>{{ $property->bathrooms }} bath</span>
                </div>
                @if($property->parking_spaces > 0)
                    <div class="flex items-center gap-1">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                            <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z"/>
                        </svg>
                        <span>{{ $property->parking_spaces }} car</span>
                    </div>
                @endif
            </div>
            
            <!-- Property Type & Features -->
            <div class="flex flex-wrap gap-2 mb-4">
                <span class="px-2 py-1 bg-gray-100 text-gray-700 text-xs font-medium rounded">
                    {{ ucfirst($property->property_type) }}
                </span>
                @if($property->pet_friendly)
                    <span class="px-2 py-1 bg-green-100 text-green-700 text-xs font-medium rounded">Pet Friendly</span>
                @endif
                @if($property->furnished)
                    <span class="px-2 py-1 bg-blue-100 text-blue-700 text-xs font-medium rounded">Furnished</span>
                @endif
            </div>
            
            <!-- Actions -->
            <div class="flex gap-2">
                @if(!$hasApplied)
                    <a 
                        href="{{ route('user.applications.create', ['property_id' => $property->id]) }}"
                        class="flex-1 px-4 py-2 bg-teal-600 text-white text-center font-semibold rounded-lg hover:bg-teal-700 transition"
                    >
                        Apply Now
                    </a>
                @else
                    <a 
                        href="{{ route('user.applications.index') }}"
                        class="flex-1 px-4 py-2 bg-blue-600 text-white text-center font-semibold rounded-lg hover:bg-blue-700 transition"
                    >
                        View Application
                    </a>
                @endif
                <a 
                    href="{{ route('properties.show', $property->public_url_code) }}"
                    target="_blank"
                    class="px-4 py-2 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 transition"
                >
                    View
                </a>
            </div>
        </div>
    </div>

@else
    <!-- List View Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition">
        <div class="flex flex-col md:flex-row">
            <!-- Image -->
            <div class="relative md:w-80 aspect-[4/3] md:aspect-auto overflow-hidden bg-gray-100 flex-shrink-0">
                @if($hasValidImage)
                    <img 
                        src="{{ $imageUrl }}" 
                        alt="{{ $property->address }}"
                        class="w-full h-full object-cover"
                        onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'w-full h-full flex items-center justify-center bg-gradient-to-br from-gray-100 to-gray-200\'><div class=\'text-center p-4\'><svg class=\'w-16 h-16 mx-auto text-gray-400 mb-3\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'1.5\' d=\'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z\'></path></svg><p class=\'text-sm font-semibold text-gray-500\'>No Image Available</p></div></div>';"
                    >
                @else
                    <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-gray-100 to-gray-200">
                        <div class="text-center p-4">
                            <svg class="w-16 h-16 mx-auto text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <p class="text-sm font-semibold text-gray-500">No Image Available</p>
                        </div>
                    </div>
                @endif
                
                <!-- Remove Button -->
                <button 
                    onclick="removeSavedProperty({{ $property->id }}, this)"
                    class="absolute top-3 right-3 p-2 bg-white/90 backdrop-blur-sm rounded-full hover:bg-white transition text-red-500 hover:text-red-600"
                    title="Remove from saved"
                >
                    <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                        <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
                    </svg>
                </button>
                
                <!-- Price Badge -->
                <div class="absolute bottom-3 left-3">
                    <span class="px-3 py-1 bg-teal-600 text-white text-sm font-bold rounded-lg">
                        ${{ number_format($property->price_per_week) }}/week
                    </span>
                </div>
            </div>
            
            <!-- Content -->
            <div class="flex-1 p-6">
                <div class="flex items-start justify-between mb-3">
                    <div class="flex-1">
                        <!-- Saved Date -->
                        <p class="text-xs text-gray-500 mb-2">Saved {{ $savedAt->diffForHumans() }}</p>
                        
                        <!-- Property Code -->
                        <p class="text-xs text-gray-500 font-medium mb-1">{{ $property->property_code }}</p>
                        
                        <!-- Address -->
                        <h3 class="text-xl font-bold text-gray-900 mb-1">
                            {{ $property->address }}
                        </h3>
                        <p class="text-sm text-gray-600">{{ $property->suburb }}, {{ $property->state }} {{ $property->postcode }}</p>
                    </div>
                    
                    <!-- Applied Badge -->
                    @if($hasApplied)
                        <div>
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                Applied
                            </span>
                        </div>
                    @endif
                </div>
                
                <!-- Features -->
                <div class="flex items-center gap-6 mb-4 text-gray-600">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                        </svg>
                        <span class="font-medium">{{ $property->bedrooms }} Bedrooms</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd"/>
                        </svg>
                        <span class="font-medium">{{ $property->bathrooms }} Bathrooms</span>
                    </div>
                    @if($property->parking_spaces > 0)
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                                <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z"/>
                            </svg>
                            <span class="font-medium">{{ $property->parking_spaces }} Parking</span>
                        </div>
                    @endif
                </div>
                
                <!-- Property Type & Features -->
                <div class="flex flex-wrap gap-2 mb-4">
                    <span class="px-3 py-1 bg-gray-100 text-gray-700 text-sm font-medium rounded">
                        {{ ucfirst($property->property_type) }}
                    </span>
                    @if($property->pet_friendly)
                        <span class="px-3 py-1 bg-green-100 text-green-700 text-sm font-medium rounded">Pet Friendly</span>
                    @endif
                    @if($property->furnished)
                        <span class="px-3 py-1 bg-blue-100 text-blue-700 text-sm font-medium rounded">Furnished</span>
                    @endif
                </div>
                
                <!-- Actions -->
                <div class="flex gap-3">
                    @if(!$hasApplied)
                        <a 
                            href="{{ route('user.applications.create', ['property_id' => $property->id]) }}"
                            class="px-6 py-2 bg-teal-600 text-white text-center font-semibold rounded-lg hover:bg-teal-700 transition"
                        >
                            Apply Now
                        </a>
                    @else
                        <a 
                            href="{{ route('user.applications.index') }}"
                            class="px-6 py-2 bg-blue-600 text-white text-center font-semibold rounded-lg hover:bg-blue-700 transition"
                        >
                            View Application
                        </a>
                    @endif
                    <a 
                        href="{{ route('properties.show', $property->public_url_code) }}"
                        target="_blank"
                        class="px-6 py-2 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 transition"
                    >
                        View Details
                    </a>
                </div>
            </div>
        </div>
    </div>
@endif

@once
@push('scripts')
<script>
function removeSavedProperty(propertyId, button) {
    if (!confirm('Remove this property from your saved list?')) {
        return;
    }
    
    fetch(`/user/saved-properties/${propertyId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Remove the card from view
            const card = button.closest('.group, .bg-white');
            card.style.opacity = '0';
            setTimeout(() => {
                card.remove();
                // Reload if no more properties
                if (document.querySelectorAll('.group, .bg-white').length === 0) {
                    location.reload();
                }
            }, 300);
        }
    })
    .catch(error => console.error('Error:', error));
}
</script>
@endpush
@endonce