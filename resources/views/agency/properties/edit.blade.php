@extends('layouts.admin')

@section('title', 'Edit Property')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Edit Property</h1>
            <p class="mt-1 text-gray-600">{{ $property->short_address }}</p>
        </div>
        <a href="{{ route('agency.properties.show', $property) }}" class="text-gray-600 hover:text-gray-900">
            ← Back to Property
        </a>
    </div>

    {{-- Form --}}
    <form action="{{ route('agency.properties.update', $property) }}" method="POST" class="space-y-6">
        @csrf
        @method('PATCH')

        {{-- Property Type & Listing Type --}}
        <div class="bg-white rounded-2xl border border-gray-200 p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Property Type</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Property Type <span class="text-red-500">*</span>
                    </label>
                    <select name="property_type" required 
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent @error('property_type') border-red-500 @enderror">
                        <option value="">Select Type</option>
                        @foreach(['house', 'apartment', 'unit', 'townhouse', 'villa', 'land', 'studio', 'duplex', 'farm', 'commercial', 'industrial'] as $type)
                            <option value="{{ $type }}" {{ old('property_type', $property->property_type) === $type ? 'selected' : '' }}>
                                {{ ucfirst($type) }}
                            </option>
                        @endforeach
                    </select>
                    @error('property_type')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Listing Type <span class="text-red-500">*</span>
                    </label>
                    <select name="listing_type" id="listing_type" required 
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent @error('listing_type') border-red-500 @enderror">
                        <option value="">Select Type</option>
                        <option value="sale" {{ old('listing_type', $property->listing_type) === 'sale' ? 'selected' : '' }}>For Sale</option>
                        <option value="rent" {{ old('listing_type', $property->listing_type) === 'rent' ? 'selected' : '' }}>For Rent</option>
                        <option value="lease" {{ old('listing_type', $property->listing_type) === 'lease' ? 'selected' : '' }}>For Lease</option>
                    </select>
                    @error('listing_type')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Status <span class="text-red-500">*</span>
                    </label>
                    <select name="status" required 
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent @error('status') border-red-500 @enderror">
                        <option value="draft" {{ old('status', $property->status) === 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="active" {{ old('status', $property->status) === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="under_contract" {{ old('status', $property->status) === 'under_contract' ? 'selected' : '' }}>Under Contract</option>
                        <option value="sold" {{ old('status', $property->status) === 'sold' ? 'selected' : '' }}>Sold</option>
                        <option value="leased" {{ old('status', $property->status) === 'leased' ? 'selected' : '' }}>Leased</option>
                        <option value="withdrawn" {{ old('status', $property->status) === 'withdrawn' ? 'selected' : '' }}>Withdrawn</option>
                        <option value="off_market" {{ old('status', $property->status) === 'off_market' ? 'selected' : '' }}>Off Market</option>
                        <option value="expired" {{ old('status', $property->status) === 'expired' ? 'selected' : '' }}>Expired</option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Address --}}
        <div class="bg-white rounded-2xl border border-gray-200 p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Address</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Unit Number (Optional)</label>
                    <input type="text" name="unit_number" value="{{ old('unit_number', $property->unit_number) }}"
                           placeholder="5"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Street Number <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="street_number" value="{{ old('street_number', $property->street_number) }}"
                           placeholder="123" required
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent @error('street_number') border-red-500 @enderror">
                    @error('street_number')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Street Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="street_name" value="{{ old('street_name', $property->street_name) }}"
                           placeholder="Main" required
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent @error('street_name') border-red-500 @enderror">
                    @error('street_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Street Type</label>
                    <input type="text" name="street_type" value="{{ old('street_type', $property->street_type) }}"
                           placeholder="Street, Road, Avenue..."
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Suburb <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="suburb" value="{{ old('suburb', $property->suburb) }}"
                           placeholder="Sydney" required
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent @error('suburb') border-red-500 @enderror">
                    @error('suburb')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        State <span class="text-red-500">*</span>
                    </label>
                    <select name="state" required
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent @error('state') border-red-500 @enderror">
                        <option value="">Select State</option>
                        @foreach(['NSW', 'VIC', 'QLD', 'WA', 'SA', 'TAS', 'ACT', 'NT'] as $state)
                            <option value="{{ $state }}" {{ old('state', $property->state) === $state ? 'selected' : '' }}>
                                {{ $state }}
                            </option>
                        @endforeach
                    </select>
                    @error('state')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Postcode <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="postcode" value="{{ old('postcode', $property->postcode) }}"
                           placeholder="2000" required
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent @error('postcode') border-red-500 @enderror">
                    @error('postcode')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Property Details --}}
        <div class="bg-white rounded-2xl border border-gray-200 p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Property Details</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Bedrooms</label>
                    <input type="number" name="bedrooms" value="{{ old('bedrooms', $property->bedrooms) }}" min="0" max="20"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Bathrooms</label>
                    <input type="number" name="bathrooms" value="{{ old('bathrooms', $property->bathrooms) }}" min="0" max="20"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Parking Spaces</label>
                    <input type="number" name="parking_spaces" value="{{ old('parking_spaces', $property->parking_spaces) }}" min="0" max="20"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Garages</label>
                    <input type="number" name="garages" value="{{ old('garages', $property->garages) }}" min="0" max="20"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Land Area (m²)</label>
                    <input type="number" name="land_area" value="{{ old('land_area', $property->land_area) }}" step="0.01" min="0"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Floor Area (m²)</label>
                    <input type="number" name="floor_area" value="{{ old('floor_area', $property->floor_area) }}" step="0.01" min="0"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Year Built</label>
                    <input type="number" name="year_built" value="{{ old('year_built', $property->year_built) }}" min="1800" max="{{ date('Y') + 2 }}"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent">
                </div>
            </div>
        </div>

        {{-- Pricing --}}
        <div class="bg-white rounded-2xl border border-gray-200 p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Pricing</h2>
            
            {{-- Sale Price --}}
            <div id="sale-pricing">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Sale Price ($)</label>
                        <input type="number" name="price" value="{{ old('price', $property->price) }}" step="0.01" min="0"
                               placeholder="850000"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Price Text (Optional)</label>
                        <input type="text" name="price_text" value="{{ old('price_text', $property->price_text) }}"
                               placeholder="POA, Offers Over, Contact Agent..."
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent">
                    </div>

                    <div class="md:col-span-2">
                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="price_display" value="1" {{ old('price_display', $property->price_display) ? 'checked' : '' }}
                                   class="w-4 h-4 text-primary border-gray-300 rounded focus:ring-primary">
                            <span class="text-sm text-gray-700">Display price publicly</span>
                        </label>
                    </div>
                </div>
            </div>

            {{-- Rental Price --}}
            <div id="rental-pricing">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Rent Per Week ($)</label>
                        <input type="number" name="rent_per_week" value="{{ old('rent_per_week', $property->rent_per_week) }}" step="0.01" min="0"
                               placeholder="450"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Bond Amount ($)</label>
                        <input type="number" name="bond_amount" value="{{ old('bond_amount', $property->bond_amount) }}" step="0.01" min="0"
                               placeholder="1800"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Available From</label>
                        <input type="date" name="available_from" value="{{ old('available_from', $property->available_from ? $property->available_from->format('Y-m-d') : '') }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent">
                    </div>
                </div>
            </div>
        </div>

        {{-- Description --}}
        <div class="bg-white rounded-2xl border border-gray-200 p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Description & Marketing</h2>
            
            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Headline</label>
                    <input type="text" name="headline" value="{{ old('headline', $property->headline) }}" maxlength="255"
                           placeholder="Stunning 4 Bedroom Family Home in Prime Location"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent">
                    <p class="mt-1 text-xs text-gray-500">Catchy title for the property listing</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                    <textarea name="description" rows="6"
                              placeholder="Describe the property features, location benefits, and unique selling points..."
                              class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent">{{ old('description', $property->description) }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-3">Features</label>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                        @php
                            $allFeatures = [
                                'Air Conditioning', 'Built-in Wardrobes', 'Dishwasher', 'Gas Cooking',
                                'Swimming Pool', 'Alarm System', 'Balcony', 'Deck',
                                'Courtyard', 'Garden', 'Study', 'Ensuite',
                                'Walk-in Wardrobe', 'Ducted Heating', 'Floorboards', 'Remote Garage',
                            ];
                            $selectedFeatures = old('features', $property->features ?? []);
                        @endphp
                        @foreach($allFeatures as $feature)
                            <label class="flex items-center gap-2 p-3 border border-gray-200 rounded-xl hover:bg-gray-50 cursor-pointer">
                                <input type="checkbox" name="features[]" value="{{ $feature }}"
                                       {{ in_array($feature, $selectedFeatures) ? 'checked' : '' }}
                                       class="w-4 h-4 text-primary border-gray-300 rounded focus:ring-primary">
                                <span class="text-sm text-gray-700">{{ $feature }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- Agent Assignment --}}
        <div class="bg-white rounded-2xl border border-gray-200 p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Agent Assignment</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Listing Agent</label>
                    <select name="listing_agent_id"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent">
                        <option value="">Select Agent (Optional)</option>
                        @foreach($agents as $agent)
                            <option value="{{ $agent->id }}" {{ old('listing_agent_id', $property->listing_agent_id) == $agent->id ? 'selected' : '' }}>
                                {{ $agent->full_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Property Manager (For Rentals)</label>
                    <select name="property_manager_id"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent">
                        <option value="">Select Property Manager (Optional)</option>
                        @foreach($agents as $agent)
                            <option value="{{ $agent->id }}" {{ old('property_manager_id', $property->property_manager_id) == $agent->id ? 'selected' : '' }}>
                                {{ $agent->full_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        {{-- Settings --}}
        <div class="bg-white rounded-2xl border border-gray-200 p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Settings</h2>
            
            <div class="space-y-3">
                <label class="flex items-center gap-2">
                    <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $property->is_featured) ? 'checked' : '' }}
                           class="w-4 h-4 text-primary border-gray-300 rounded focus:ring-primary">
                    <span class="text-sm text-gray-700">Feature this property (highlighted in listings)</span>
                </label>
            </div>
        </div>

        {{-- Actions --}}
        <div class="flex items-center justify-end gap-4 pb-6">
            <a href="{{ route('agency.properties.show', $property) }}" 
               class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-xl transition-colors">
                Cancel
            </a>
            <button type="submit"
                    class="px-8 py-3 bg-primary hover:bg-primary-dark text-white font-semibold rounded-xl transition-colors">
                Update Property
            </button>
        </div>
    </form>
</div>

<script>
// Toggle pricing fields based on listing type
document.addEventListener('DOMContentLoaded', function() {
    const listingType = document.getElementById('listing_type');
    const salePricing = document.getElementById('sale-pricing');
    const rentalPricing = document.getElementById('rental-pricing');
    
    function togglePricing() {
        const value = listingType.value;
        // Show both by default in edit mode, or toggle based on type
        // This allows editing all fields regardless of current type
    }
    
    listingType.addEventListener('change', togglePricing);
    togglePricing(); // Initial call
});
</script>
@endsection