@extends('layouts.admin')

@section('title', 'Property Details')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-8 flex items-center justify-between">
        <div>
            <div class="flex items-center gap-3 mb-2 flex-wrap">
                <h1 class="text-3xl font-bold text-plyform-dark">{{ $property->full_address }}</h1>
                @if($property->status == 'active')
                    <span class="px-3 py-1 bg-plyform-mint text-plyform-dark text-sm font-semibold rounded-full">Active</span>
                @elseif($property->status == 'draft')
                    <span class="px-3 py-1 bg-gray-100 text-gray-800 text-sm font-semibold rounded-full">Draft</span>
                @elseif($property->status == 'sold')
                    <span class="px-3 py-1 bg-plyform-purple/20 text-plyform-purple text-sm font-semibold rounded-full">Sold</span>
                @elseif($property->status == 'leased')
                    <span class="px-3 py-1 bg-plyform-yellow/30 text-plyform-dark text-sm font-semibold rounded-full">Leased</span>
                @endif
                @if($property->is_featured)
                    <span class="px-3 py-1 bg-plyform-yellow text-plyform-dark text-sm font-semibold rounded-full flex items-center gap-1">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        Featured
                    </span>
                @endif
            </div>
            <p class="text-gray-600">Property Code: {{ $property->property_code }}</p>
        </div>
        <a href="{{ route('agency.properties.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition">
            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Properties
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Image Gallery -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                @if($property->images->count() > 0)
                    <!-- Main Image -->
                    <div class="relative h-96 bg-gray-200">
                        <img id="mainImage" src="{{ Storage::url($property->images->first()->file_path) }}" alt="{{ $property->full_address }}" class="w-full h-full object-cover">
                        <div class="absolute bottom-4 right-4 px-3 py-2 bg-black bg-opacity-60 text-white text-sm rounded-lg">
                            {{ $property->images->count() }} Photos
                        </div>
                    </div>
                    <!-- Thumbnail Grid -->
                    <div class="grid grid-cols-5 gap-2 p-4 bg-plyform-mint/10">
                        @foreach($property->images->take(5) as $image)
                            <img src="{{ Storage::url($image->file_path) }}" alt="Thumbnail" 
                                 onclick="changeMainImage('{{ Storage::url($image->file_path) }}')"
                                 class="w-full h-20 object-cover rounded-lg cursor-pointer hover:opacity-75 transition border-2 border-transparent hover:border-plyform-purple">
                        @endforeach
                    </div>
                @else
                    <div class="h-96 flex items-center justify-center bg-gradient-to-br from-plyform-purple to-plyform-dark">
                        <svg class="w-24 h-24 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                @endif
            </div>

            <!-- Property Details -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-2xl font-bold text-plyform-dark mb-6">Property Details</h2>
                
                <!-- Price -->
                <div class="mb-6 pb-6 border-b border-gray-200">
                    @if($property->listing_type == 'rent')
                        <div class="flex items-baseline gap-2">
                            <span class="text-4xl font-bold text-plyform-purple">${{ number_format($property->rent_per_week, 0) }}</span>
                            <span class="text-xl text-gray-600">per week</span>
                        </div>
                        @if($property->bond_amount)
                            <div class="mt-2 text-gray-600">
                                Bond: <span class="font-semibold text-plyform-dark">${{ number_format($property->bond_amount, 0) }}</span>
                                <span class="text-sm text-gray-500">({{ $property->bond_weeks }} weeks)</span>
                            </div>
                        @endif
                    @else
                        <div class="text-4xl font-bold text-plyform-purple">${{ number_format($property->price, 0) }}</div>
                        @if($property->price_text)
                            <div class="mt-1 text-gray-600">{{ $property->price_text }}</div>
                        @endif
                    @endif
                </div>

                <!-- Specifications -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                    @if($property->bedrooms)
                        <div class="text-center p-4 bg-plyform-purple/10 rounded-xl">
                            <div class="text-3xl font-bold text-plyform-dark">{{ $property->bedrooms }}</div>
                            <div class="text-sm text-gray-600 mt-1">Bedrooms</div>
                        </div>
                    @endif
                    @if($property->bathrooms)
                        <div class="text-center p-4 bg-plyform-mint/30 rounded-xl">
                            <div class="text-3xl font-bold text-plyform-dark">{{ $property->bathrooms }}</div>
                            <div class="text-sm text-gray-600 mt-1">Bathrooms</div>
                        </div>
                    @endif
                    @if($property->parking_spaces)
                        <div class="text-center p-4 bg-plyform-yellow/30 rounded-xl">
                            <div class="text-3xl font-bold text-plyform-dark">{{ $property->parking_spaces }}</div>
                            <div class="text-sm text-gray-600 mt-1">Parking</div>
                        </div>
                    @endif
                    @if($property->land_size)
                        <div class="text-center p-4 bg-plyform-orange/10 rounded-xl">
                            <div class="text-3xl font-bold text-plyform-orange">{{ number_format($property->land_size) }}</div>
                            <div class="text-sm text-gray-600 mt-1">Land (sqm)</div>
                        </div>
                    @endif
                    @if($property->building_size)
                        <div class="text-center p-4 bg-plyform-purple/10 rounded-xl">
                            <div class="text-3xl font-bold text-plyform-dark">{{ number_format($property->building_size) }}</div>
                            <div class="text-sm text-gray-600 mt-1">Unit (sqm)</div>
                        </div>
                    @endif
                </div>

                <!-- Floorplan -->
                @if($property->floorplan_path)
                    <div class="border-t border-gray-200 pt-6 mt-6">
                        <h4 class="font-semibold text-plyform-dark mb-3">Floorplan</h4>
                        <a href="{{ Storage::url($property->floorplan_path) }}" target="_blank" class="inline-block">
                            @if(str_ends_with($property->floorplan_path, '.pdf'))
                                <div class="flex items-center gap-3 p-4 bg-plyform-orange/10 border-2 border-plyform-orange rounded-xl hover:bg-plyform-orange/20 transition">
                                    <svg class="w-12 h-12 text-plyform-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                    </svg>
                                    <div>
                                        <div class="font-medium text-plyform-dark">View Floorplan PDF</div>
                                        <div class="text-sm text-gray-600">Click to open</div>
                                    </div>
                                </div>
                            @else
                                <img src="{{ Storage::url($property->floorplan_path) }}" alt="Floorplan" class="max-w-full h-auto rounded-xl border-2 border-plyform-purple">
                            @endif
                        </a>
                    </div>
                @endif
            </div>

            <!-- Assigned Agents -->
            @if($property->agents->count() > 0)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h2 class="text-2xl font-bold text-plyform-dark mb-6">Assigned Agents</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($property->agents as $agent)
                            <div class="flex items-center gap-4 p-4 bg-plyform-mint/10 rounded-xl border border-plyform-mint/30">
                                <div class="w-16 h-16 bg-gradient-to-br from-plyform-purple to-plyform-dark rounded-full flex items-center justify-center text-white font-bold text-xl">
                                    {{ substr($agent->first_name, 0, 1) }}{{ substr($agent->last_name, 0, 1) }}
                                </div>
                                <div>
                                    <div class="font-semibold text-plyform-dark">{{ $agent->first_name }} {{ $agent->last_name }}</div>
                                    <div class="text-sm text-gray-600">{{ ucfirst(str_replace('_', ' ', $agent->pivot->role)) }}</div>
                                    @if($agent->email)
                                        <div class="text-sm text-plyform-purple">{{ $agent->email }}</div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Quick Actions -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-bold text-plyform-dark mb-4">Quick Actions</h3>
                <div class="space-y-2">
                    <a href="{{ route('agency.properties.edit', $property) }}" 
                       class="w-full px-4 py-2 bg-gradient-to-r from-plyform-purple to-plyform-dark text-white rounded-xl hover:from-plyform-purple/90 hover:to-plyform-dark/90 transition text-center font-medium flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit Property
                    </a>

                    @if($property->status == 'draft')
                        <form action="{{ route('agency.properties.publish', $property) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full px-4 py-2 bg-plyform-mint text-plyform-dark rounded-xl hover:bg-plyform-mint/90 transition text-center font-medium flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Publish Property
                            </button>
                        </form>
                    @elseif($property->status == 'active')
                        <form action="{{ route('agency.properties.unpublish', $property) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full px-4 py-2 bg-gray-600 text-white rounded-xl hover:bg-gray-700 transition text-center font-medium flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                                </svg>
                                Unpublish
                            </button>
                        </form>
                    @endif

                    <form action="{{ route('agency.properties.toggle-featured', $property) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full px-4 py-2 bg-plyform-yellow text-plyform-dark rounded-xl hover:bg-plyform-yellow/90 transition text-center font-medium flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            {{ $property->is_featured ? 'Remove Featured' : 'Mark Featured' }}
                        </button>
                    </form>

                    <form action="{{ route('agency.properties.destroy', $property) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this property?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full px-4 py-2 bg-plyform-orange text-white rounded-xl hover:bg-plyform-orange/90 transition text-center font-medium flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Delete Property
                        </button>
                    </form>
                </div>
            </div>

            <!-- Public Link -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-bold text-plyform-dark mb-4">Public Listing Link</h3>
                <div class="space-y-3">
                    <div class="p-3 bg-plyform-mint/10 border border-plyform-mint rounded-xl">
                        <input type="text" value="{{ $property->public_url }}" readonly id="publicUrl"
                               class="w-full bg-transparent text-sm font-mono text-gray-700 focus:outline-none">
                    </div>
                    <button onclick="copyPublicUrl()" class="w-full px-4 py-2 bg-gradient-to-r from-plyform-purple to-plyform-dark text-white rounded-xl hover:from-plyform-purple/90 hover:to-plyform-dark/90 transition flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                        </svg>
                        <span id="copyBtnText">Copy Link</span>
                    </button>
                    <a href="{{ $property->public_url }}" target="_blank" class="w-full px-4 py-2 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                        </svg>
                        View Public Page
                    </a>
                </div>
            </div>

            <!-- Statistics -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-bold text-plyform-dark mb-4">Statistics</h3>
                <div class="space-y-3">
                    <div class="flex items-center justify-between p-3 bg-plyform-purple/10 rounded-lg">
                        <span class="text-sm text-gray-600">Views</span>
                        <span class="font-semibold text-plyform-dark">{{ number_format($property->view_count) }}</span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-plyform-mint/30 rounded-lg">
                        <span class="text-sm text-gray-600">Applications</span>
                        <span class="font-semibold text-plyform-dark">{{ $property->applications->count() }}</span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-plyform-yellow/30 rounded-lg">
                        <span class="text-sm text-gray-600">Images</span>
                        <span class="font-semibold text-plyform-dark">{{ $property->images->count() }}</span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-plyform-orange/10 rounded-lg">
                        <span class="text-sm text-gray-600">Listed</span>
                        <span class="font-semibold text-gray-700">{{ $property->created_at->diffForHumans() }}</span>
                    </div>
                </div>
            </div>

            <!-- Property Info -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-bold text-plyform-dark mb-4">Property Information</h3>
                <div class="space-y-3 text-sm">
                    <div class="flex items-center justify-between p-3 bg-plyform-mint/10 rounded-lg">
                        <span class="text-gray-600">Property Type</span>
                        <span class="font-medium text-plyform-dark">{{ ucfirst($property->property_type) }}</span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-plyform-purple/10 rounded-lg">
                        <span class="text-gray-600">Listing Type</span>
                        <span class="font-medium text-plyform-dark">For {{ ucfirst($property->listing_type) }}</span>
                    </div>
                    @if($property->available_from)
                        <div class="flex items-center justify-between p-3 bg-plyform-yellow/30 rounded-lg">
                            <span class="text-gray-600">Available From</span>
                            <span class="font-medium text-plyform-dark">{{ $property->available_from->format('d M Y') }}</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function changeMainImage(url) {
    document.getElementById('mainImage').src = url;
}

function copyPublicUrl() {
    const input = document.getElementById('publicUrl');
    input.select();
    input.setSelectionRange(0, 99999); // For mobile devices
    
    // Modern clipboard API
    navigator.clipboard.writeText(input.value).then(() => {
        const btnText = document.getElementById('copyBtnText');
        btnText.textContent = '✓ Copied!';
        setTimeout(() => {
            btnText.textContent = 'Copy Link';
        }, 2000);
    }).catch(() => {
        // Fallback for older browsers
        document.execCommand('copy');
        const btnText = document.getElementById('copyBtnText');
        btnText.textContent = '✓ Copied!';
        setTimeout(() => {
            btnText.textContent = 'Copy Link';
        }, 2000);
    });
}
</script>
@endsection