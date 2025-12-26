@extends('layouts.admin')

@section('title', 'All Properties Management')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">All Properties</h1>
            <p class="text-gray-600 mt-1">Manage properties across all agencies</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.properties.statistics') }}" 
               class="inline-flex items-center px-4 py-2 bg-[#DDEECD] text-gray-800 rounded-lg hover:bg-[#DDEECD]/80 transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
                Statistics
            </a>
            <button onclick="exportProperties()" 
                    class="inline-flex items-center px-4 py-2 bg-[#E6FF4B] text-gray-800 rounded-lg hover:bg-[#E6FF4B]/80 transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Export CSV
            </button>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="mb-6 bg-[#DDEECD]/30 border border-[#DDEECD] text-gray-800 px-4 py-3 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <form method="GET" action="{{ route('admin.properties.index') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Search -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}"
                           placeholder="Title, address, ID..."
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#DDEECD] focus:border-[#DDEECD] hover:border-[#DDEECD]/50 transition-colors">
                </div>

                <!-- Agency Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Agency</label>
                    <select name="agency_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#DDEECD] focus:border-[#DDEECD] hover:border-[#DDEECD]/50 bg-white transition-colors">
                        <option value="">All Agencies</option>
                        @foreach($agencies as $agency)
                            <option value="{{ $agency->id }}" {{ request('agency_id') == $agency->id ? 'selected' : '' }}>
                                {{ $agency->agency_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Listing Type -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Listing Type</label>
                    <select name="listing_type" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#DDEECD] focus:border-[#DDEECD] hover:border-[#DDEECD]/50 bg-white transition-colors">
                        <option value="">All Types</option>
                        <option value="sale" {{ request('listing_type') == 'sale' ? 'selected' : '' }}>For Sale</option>
                        <option value="rent" {{ request('listing_type') == 'rent' ? 'selected' : '' }}>For Rent</option>
                    </select>
                </div>

                <!-- Status -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#DDEECD] focus:border-[#DDEECD] hover:border-[#DDEECD]/50 bg-white transition-colors">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="sold" {{ request('status') == 'sold' ? 'selected' : '' }}>Sold</option>
                        <option value="rented" {{ request('status') == 'rented' ? 'selected' : '' }}>Rented</option>
                        <option value="withdrawn" {{ request('status') == 'withdrawn' ? 'selected' : '' }}>Withdrawn</option>
                    </select>
                </div>

                <!-- Property Type -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Property Type</label>
                    <select name="property_type" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#DDEECD] focus:border-[#DDEECD] hover:border-[#DDEECD]/50 bg-white transition-colors">
                        <option value="">All Types</option>
                        <option value="House" {{ request('property_type') == 'House' ? 'selected' : '' }}>House</option>
                        <option value="Apartment" {{ request('property_type') == 'Apartment' ? 'selected' : '' }}>Apartment</option>
                        <option value="Townhouse" {{ request('property_type') == 'Townhouse' ? 'selected' : '' }}>Townhouse</option>
                        <option value="Villa" {{ request('property_type') == 'Villa' ? 'selected' : '' }}>Villa</option>
                        <option value="Land" {{ request('property_type') == 'Land' ? 'selected' : '' }}>Land</option>
                        <option value="Commercial" {{ request('property_type') == 'Commercial' ? 'selected' : '' }}>Commercial</option>
                    </select>
                </div>

                <!-- Min Price -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Min Price</label>
                    <input type="number" 
                           name="min_price" 
                           value="{{ request('min_price') }}"
                           placeholder="0"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#DDEECD] focus:border-[#DDEECD] hover:border-[#DDEECD]/50 transition-colors">
                </div>

                <!-- Max Price -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Max Price</label>
                    <input type="number" 
                           name="max_price" 
                           value="{{ request('max_price') }}"
                           placeholder="999999999"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#DDEECD] focus:border-[#DDEECD] hover:border-[#DDEECD]/50 transition-colors">
                </div>

                <!-- Bedrooms -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Min Bedrooms</label>
                    <select name="bedrooms" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#DDEECD] focus:border-[#DDEECD] hover:border-[#DDEECD]/50 bg-white transition-colors">
                        <option value="">Any</option>
                        @for($i = 1; $i <= 6; $i++)
                            <option value="{{ $i }}" {{ request('bedrooms') == $i ? 'selected' : '' }}>{{ $i }}+</option>
                        @endfor
                    </select>
                </div>
            </div>

            <div class="flex gap-3">
                <button type="submit" class="px-6 py-2 bg-[#DDEECD] text-gray-800 rounded-lg hover:bg-[#DDEECD]/80 transition font-semibold">
                    Apply Filters
                </button>
                <a href="{{ route('admin.properties.index') }}" class="px-6 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition font-semibold">
                    Clear Filters
                </a>
            </div>
        </form>
    </div>

    <!-- Bulk Actions -->
    <form id="bulkActionForm" method="POST" action="{{ route('admin.properties.bulk-update') }}">
        @csrf
        <div class="bg-white rounded-lg shadow-sm p-4 mb-6 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <input type="checkbox" id="selectAll" class="w-5 h-5 text-gray-700 rounded border-gray-300 focus:ring-2 focus:ring-[#DDEECD]">
                <label for="selectAll" class="text-sm font-medium text-gray-700">Select All</label>
                <span id="selectedCount" class="text-sm text-gray-500">0 selected</span>
            </div>
            <div class="flex gap-2">
                <select name="action" class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#DDEECD] focus:border-[#DDEECD] hover:border-[#DDEECD]/50 bg-white transition-colors">
                    <option value="">Bulk Actions</option>
                    <option value="activate">Activate</option>
                    <option value="deactivate">Deactivate</option>
                    <option value="feature">Mark as Featured</option>
                    <option value="unfeature">Remove Featured</option>
                    <option value="verify">Mark as Verified</option>
                    <option value="unverify">Remove Verified</option>
                    <option value="delete">Delete</option>
                </select>
                <button type="submit" class="px-4 py-2 bg-[#E6FF4B] text-gray-800 rounded-lg hover:bg-[#E6FF4B]/80 transition font-semibold">
                    Apply
                </button>
            </div>
        </div>

        <!-- Properties Table -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-[#DDEECD]/30">
                        <tr>
                            <th class="px-6 py-3 text-left">
                                <input type="checkbox" class="w-5 h-5 text-gray-700 rounded">
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Property</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Agency</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Details</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Price</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Markers</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($properties as $property)
                            <tr class="hover:bg-[#DDEECD]/20 transition-colors">
                                <td class="px-6 py-4">
                                    <input type="checkbox" name="property_ids[]" value="{{ $property->id }}" class="property-checkbox w-5 h-5 text-gray-700 rounded">
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-start">
                                        @if($property->images->first())
                                            <img src="{{ Storage::url($property->images->first()->image_path) }}" 
                                                 alt="{{ $property->title }}"
                                                 class="w-16 h-16 rounded object-cover mr-4">
                                        @else
                                            <div class="w-16 h-16 bg-gray-200 rounded mr-4 flex items-center justify-center">
                                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                                </svg>
                                            </div>
                                        @endif
                                        <div>
                                            <p class="font-semibold text-gray-800">{{ Str::limit($property->title, 40) }}</p>
                                            <p class="text-sm text-gray-500">ID: {{ $property->id }}</p>
                                            <p class="text-sm text-gray-500">{{ $property->street_address }}, {{ $property->suburb }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-[#DDEECD] rounded-full flex items-center justify-center mr-3">
                                            <span class="text-gray-700 font-semibold text-sm">
                                                {{ substr($property->agency->agency_name ?? 'N/A', 0, 2) }}
                                            </span>
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-800">{{ Str::limit($property->agency->agency_name ?? 'N/A', 20) }}</p>
                                            <p class="text-sm text-gray-500">{{ $property->agency->suburb ?? '' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                        {{ $property->listing_type === 'sale' ? 'bg-[#DDEECD] text-gray-700' : 'bg-[#E6FF4B] text-gray-800' }}">
                                        {{ ucfirst($property->listing_type) }}
                                    </span>
                                    <p class="text-sm text-gray-600 mt-1">{{ $property->property_type }}</p>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    <div class="space-y-1">
                                        <p>🛏️ {{ $property->bedrooms ?? 0 }} bed</p>
                                        <p>🚿 {{ $property->bathrooms ?? 0 }} bath</p>
                                        <p>🚗 {{ $property->parking_spaces ?? 0 }} park</p>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="font-semibold text-gray-800">
                                        @if($property->listing_type === 'sale')
                                            ${{ number_format($property->sale_price) }}
                                        @else
                                            ${{ number_format($property->rent_amount) }}/{{ $property->rent_period }}
                                        @endif
                                    </p>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($property->status === 'active') bg-[#DDEECD] text-gray-700
                                        @elseif($property->status === 'pending') bg-[#E6FF4B] text-gray-800
                                        @elseif($property->status === 'sold' || $property->status === 'rented') bg-gray-700 text-white
                                        @else bg-gray-100 text-gray-600
                                        @endif">
                                        {{ ucfirst($property->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-col gap-2">
                                        <form action="{{ route('admin.properties.toggle-featured', $property) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="inline-flex items-center px-2 py-1 text-xs rounded
                                                {{ $property->featured ? 'bg-[#E6FF4B] text-gray-800' : 'bg-gray-100 text-gray-600' }}
                                                hover:bg-[#E6FF4B]/80 transition">
                                                ⭐ {{ $property->featured ? 'Featured' : 'Feature' }}
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.properties.toggle-verified', $property) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="inline-flex items-center px-2 py-1 text-xs rounded
                                                {{ $property->verified ? 'bg-[#DDEECD] text-gray-700' : 'bg-gray-100 text-gray-600' }}
                                                hover:bg-[#DDEECD]/80 transition">
                                                ✓ {{ $property->verified ? 'Verified' : 'Verify' }}
                                            </button>
                                        </form>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex gap-2">
                                        <a href="{{ route('admin.properties.show', $property) }}" 
                                           class="text-gray-700 hover:text-gray-800 hover:bg-[#DDEECD] p-1 rounded transition"
                                           title="View">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </a>
                                        <a href="{{ route('admin.properties.edit', $property) }}" 
                                           class="text-gray-700 hover:text-gray-800 hover:bg-[#E6FF4B] p-1 rounded transition"
                                           title="Edit">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </a>
                                        <form action="{{ route('admin.properties.destroy', $property) }}" 
                                              method="POST" 
                                              onsubmit="return confirm('Are you sure you want to delete this property?');"
                                              class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="text-gray-600 hover:text-gray-700 hover:bg-gray-100 p-1 rounded transition"
                                                    title="Delete">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="px-6 py-12 text-center text-gray-500">
                                    <div class="w-16 h-16 bg-[#DDEECD]/30 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <svg class="w-8 h-8 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                        </svg>
                                    </div>
                                    <p class="text-lg font-medium mb-2 text-gray-700">No properties found</p>
                                    <p>Try adjusting your filters or search criteria</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </form>

    <!-- Pagination -->
    @if($properties->hasPages())
        <div class="mt-6">
            {{ $properties->links() }}
        </div>
    @endif
</div>

<script>
// Select All Functionality
document.getElementById('selectAll').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.property-checkbox');
    checkboxes.forEach(cb => cb.checked = this.checked);
    updateSelectedCount();
});

// Update selected count
document.querySelectorAll('.property-checkbox').forEach(checkbox => {
    checkbox.addEventListener('change', updateSelectedCount);
});

function updateSelectedCount() {
    const checked = document.querySelectorAll('.property-checkbox:checked').length;
    document.getElementById('selectedCount').textContent = `${checked} selected`;
}

// Export properties with current filters
function exportProperties() {
    const urlParams = new URLSearchParams(window.location.search);
    window.location.href = '{{ route("admin.properties.export") }}?' + urlParams.toString();
}

// Confirm bulk actions
document.getElementById('bulkActionForm').addEventListener('submit', function(e) {
    const checked = document.querySelectorAll('.property-checkbox:checked').length;
    if (checked === 0) {
        e.preventDefault();
        alert('Please select at least one property');
        return false;
    }
    
    const action = this.querySelector('[name="action"]').value;
    if (!action) {
        e.preventDefault();
        alert('Please select an action');
        return false;
    }
    
    if (action === 'delete') {
        if (!confirm(`Are you sure you want to delete ${checked} propert${checked > 1 ? 'ies' : 'y'}?`)) {
            e.preventDefault();
            return false;
        }
    }
});
</script>
@endsection