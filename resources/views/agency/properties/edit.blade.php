@extends('layouts.admin')

@section('title', 'Edit Property')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Edit Property</h1>
            <p class="text-gray-600 mt-1">{{ $property->full_address }}</p>
        </div>
        <a href="{{ route('agency.properties.show', $property) }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Details
        </a>
    </div>

    <!-- Form -->
    <form id="propertyForm" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PATCH')

        <!-- 1. Property Type & Listing Type -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-6">1. Property Type & Listing Type</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Property Type -->
                <div>
                    <label for="property_type" class="block text-sm font-medium text-gray-700 mb-2">Property Type *</label>
                    <select name="property_type" id="property_type" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Select type...</option>
                        <option value="house" {{ $property->property_type == 'house' ? 'selected' : '' }}>House</option>
                        <option value="apartment" {{ $property->property_type == 'apartment' ? 'selected' : '' }}>Apartment</option>
                        <option value="unit" {{ $property->property_type == 'unit' ? 'selected' : '' }}>Unit</option>
                        <option value="townhouse" {{ $property->property_type == 'townhouse' ? 'selected' : '' }}>Townhouse</option>
                        <option value="villa" {{ $property->property_type == 'villa' ? 'selected' : '' }}>Villa</option>
                        <option value="land" {{ $property->property_type == 'land' ? 'selected' : '' }}>Land</option>
                        <option value="studio" {{ $property->property_type == 'studio' ? 'selected' : '' }}>Studio</option>
                        <option value="duplex" {{ $property->property_type == 'duplex' ? 'selected' : '' }}>Duplex</option>
                        <option value="farm" {{ $property->property_type == 'farm' ? 'selected' : '' }}>Farm</option>
                    </select>
                </div>

                <!-- Listing Type -->
                <div>
                    <label for="listing_type" class="block text-sm font-medium text-gray-700 mb-2">Listing Type *</label>
                    <select name="listing_type" id="listing_type" required onchange="togglePricing()"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Select type...</option>
                        <option value="rent" {{ $property->listing_type == 'rent' ? 'selected' : '' }}>For Rent</option>
                        <option value="sale" {{ $property->listing_type == 'sale' ? 'selected' : '' }}>For Sale</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- 2. Property Address -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-6">2. Property Address</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="unit_number" class="block text-sm font-medium text-gray-700 mb-2">Unit/Apartment Number</label>
                    <input type="text" name="unit_number" id="unit_number" value="{{ old('unit_number', $property->unit_number) }}" placeholder="e.g., Unit 5"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <div>
                    <label for="street_number" class="block text-sm font-medium text-gray-700 mb-2">Street Number</label>
                    <input type="text" name="street_number" id="street_number" value="{{ old('street_number', $property->street_number) }}" placeholder="e.g., 123"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <div>
                    <label for="street_name" class="block text-sm font-medium text-gray-700 mb-2">Street Name *</label>
                    <input type="text" name="street_name" id="street_name" value="{{ old('street_name', $property->street_name) }}" required placeholder="e.g., Main Street"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <div>
                    <label for="suburb" class="block text-sm font-medium text-gray-700 mb-2">Suburb/City *</label>
                    <input type="text" name="suburb" id="suburb" value="{{ old('suburb', $property->suburb) }}" required placeholder="e.g., Sydney"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <div>
                    <label for="state" class="block text-sm font-medium text-gray-700 mb-2">State *</label>
                    <select name="state" id="state" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Select state...</option>
                        <option value="NSW" {{ $property->state == 'NSW' ? 'selected' : '' }}>New South Wales</option>
                        <option value="VIC" {{ $property->state == 'VIC' ? 'selected' : '' }}>Victoria</option>
                        <option value="QLD" {{ $property->state == 'QLD' ? 'selected' : '' }}>Queensland</option>
                        <option value="SA" {{ $property->state == 'SA' ? 'selected' : '' }}>South Australia</option>
                        <option value="WA" {{ $property->state == 'WA' ? 'selected' : '' }}>Western Australia</option>
                        <option value="TAS" {{ $property->state == 'TAS' ? 'selected' : '' }}>Tasmania</option>
                        <option value="NT" {{ $property->state == 'NT' ? 'selected' : '' }}>Northern Territory</option>
                        <option value="ACT" {{ $property->state == 'ACT' ? 'selected' : '' }}>Australian Capital Territory</option>
                    </select>
                </div>

                <div>
                    <label for="postcode" class="block text-sm font-medium text-gray-700 mb-2">Postcode *</label>
                    <input type="text" name="postcode" id="postcode" value="{{ old('postcode', $property->postcode) }}" required placeholder="e.g., 2000" maxlength="4"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
            </div>
        </div>

        <!-- 3. Property Details -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-6">3. Property Details</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="bedrooms" class="block text-sm font-medium text-gray-700 mb-2">Bedrooms</label>
                    <input type="number" name="bedrooms" id="bedrooms" value="{{ old('bedrooms', $property->bedrooms) }}" min="0" placeholder="0"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <div>
                    <label for="bathrooms" class="block text-sm font-medium text-gray-700 mb-2">Bathrooms</label>
                    <input type="number" name="bathrooms" id="bathrooms" value="{{ old('bathrooms', $property->bathrooms) }}" min="0" placeholder="0"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <div>
                    <label for="parking_spaces" class="block text-sm font-medium text-gray-700 mb-2">Parking Spaces</label>
                    <input type="number" name="parking_spaces" id="parking_spaces" value="{{ old('parking_spaces', $property->parking_spaces) }}" min="0" placeholder="0"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <div>
                    <label for="land_size" class="block text-sm font-medium text-gray-700 mb-2">Land Size (sqm)</label>
                    <input type="number" name="land_size" id="land_size" value="{{ old('land_size', $property->land_size) }}" min="0" step="0.01" placeholder="0"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <div>
                    <label for="unit_size" class="block text-sm font-medium text-gray-700 mb-2">Unit Size (sqm)</label>
                    <input type="number" name="unit_size" id="unit_size" value="{{ old('unit_size', $property->building_size) }}" min="0" step="0.01" placeholder="0"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
            </div>
        </div>

        <!-- 4. Pricing -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-6">4. Pricing</h2>
            
            <!-- For Rent -->
            <div id="rentPricing" class="{{ $property->listing_type == 'rent' ? '' : 'hidden' }}">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="rent_per_week" class="block text-sm font-medium text-gray-700 mb-2">Rent per Week *</label>
                        <div class="relative">
                            <span class="absolute left-4 top-2.5 text-gray-600">$</span>
                            <input type="number" name="rent_per_week" id="rent_per_week" value="{{ old('rent_per_week', $property->rent_per_week) }}" min="0" step="0.01" placeholder="500" oninput="calculateBond()"
                                   class="w-full pl-8 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                    </div>

                    <div>
                        <label for="bond_weeks" class="block text-sm font-medium text-gray-700 mb-2">Bond (Weeks of Rent)</label>
                        <input type="number" name="bond_weeks" id="bond_weeks" value="{{ old('bond_weeks', $property->bond_weeks ?? 4) }}" min="1" max="52" oninput="calculateBond()"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <p class="mt-1 text-sm text-gray-500">Default: 4 weeks</p>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Bond Amount (Auto-calculated)</label>
                        <div class="flex items-center gap-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <div class="text-2xl font-bold text-blue-900" id="bondDisplay">${{ number_format($property->bond_amount ?? 0, 0) }}</div>
                                <div class="text-sm text-blue-700">Calculated: Rent × Bond Weeks</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- For Sale -->
            <div id="salePricing" class="{{ $property->listing_type == 'sale' ? '' : 'hidden' }}">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700 mb-2">Sale Price *</label>
                        <div class="relative">
                            <span class="absolute left-4 top-2.5 text-gray-600">$</span>
                            <input type="number" name="price" id="price" value="{{ old('price', $property->price) }}" min="0" step="1000" placeholder="850000"
                                   class="w-full pl-8 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                    </div>

                    <div>
                        <label for="price_text" class="block text-sm font-medium text-gray-700 mb-2">Price Text (Optional)</label>
                        <input type="text" name="price_text" id="price_text" value="{{ old('price_text', $property->price_text) }}" placeholder="e.g., Offers Over $850,000"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                </div>
            </div>
        </div>

        <!-- 5. Existing Images & Floorplan -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-6">5. Manage Images & Floorplan</h2>
            
            <!-- Existing Floorplan -->
            @if($property->floorplan_path)
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Current Floorplan</label>
                    <div class="flex items-center gap-3 p-4 bg-gray-50 border border-gray-200 rounded-lg">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <div class="flex-1">
                            <div class="font-medium text-sm text-gray-900">Floorplan exists</div>
                            <a href="{{ Storage::url($property->floorplan_path) }}" target="_blank" class="text-xs text-blue-600 hover:underline">View current floorplan</a>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Upload New Floorplan -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">{{ $property->floorplan_path ? 'Replace' : 'Upload' }} Floorplan (JPG, PNG, PDF)</label>
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-blue-400 transition">
                    <input type="file" name="floorplan" id="floorplan" accept=".jpg,.jpeg,.png,.pdf" class="hidden" onchange="previewFloorplan(this)">
                    <label for="floorplan" class="cursor-pointer">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                        </svg>
                        <p class="mt-2 text-sm text-gray-600">Click to {{ $property->floorplan_path ? 'replace' : 'upload' }} floorplan</p>
                        <p class="text-xs text-gray-500">Max 5MB</p>
                    </label>
                </div>
                <div id="floorplanPreview" class="mt-2 hidden"></div>
            </div>

            <!-- Existing Property Images -->
            @if($property->images->count() > 0)
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-3">Current Images ({{ $property->images->count() }})</label>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4" id="existingImages">
                        @foreach($property->images as $image)
                            <div class="relative group" id="image-{{ $image->id }}">
                                <img src="{{ Storage::url($image->file_path) }}" alt="Property" class="w-full h-32 object-cover rounded-lg border-2 border-gray-200">
                                @if($image->is_featured)
                                    <div class="absolute top-2 left-2 px-2 py-1 bg-blue-600 text-white text-xs rounded">Featured</div>
                                @endif
                                <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-60 transition rounded-lg flex items-center justify-center opacity-0 group-hover:opacity-100">
                                    <button type="button" onclick="deleteImage({{ $property->id }}, {{ $image->id }})" class="px-3 py-1 bg-red-600 text-white text-sm rounded hover:bg-red-700">
                                        Delete
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Add New Property Images -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Add More Images (Multiple)</label>
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-blue-400 transition">
                    <input type="file" name="images[]" id="images" accept=".jpg,.jpeg,.png" multiple class="hidden" onchange="previewImages(this)">
                    <label for="images" class="cursor-pointer">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <p class="mt-2 text-sm text-gray-600">Click to upload additional images</p>
                        <p class="text-xs text-gray-500">JPG or PNG, Max 5MB each</p>
                    </label>
                </div>
                <div id="imagesPreview" class="mt-4 grid grid-cols-2 md:grid-cols-4 gap-4"></div>
            </div>
        </div>

        <!-- 6. Availability & Agent Assignment -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-6">6. Availability & Agent Assignment</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Availability -->
                <div>
                    <label for="available_from" class="block text-sm font-medium text-gray-700 mb-2">Available From</label>
                    <input type="date" name="available_from" id="available_from" value="{{ old('available_from', $property->available_from?->format('Y-m-d')) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status *</label>
                    <select name="status" id="status" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="draft" {{ $property->status == 'draft' ? 'selected' : '' }}>Draft (not visible to public)</option>
                        <option value="active" {{ $property->status == 'active' ? 'selected' : '' }}>Active (visible to public)</option>
                    </select>
                </div>

                <!-- Agent Assignment -->
                <div class="md:col-span-2">
                    <label for="agents" class="block text-sm font-medium text-gray-700 mb-2">Assign Agents</label>
                    @php
                        $assignedAgentIds = $property->agents->pluck('id')->toArray();
                    @endphp
                    <select name="agents[]" id="agents" multiple
                            class="w-full select2-agents">
                        @foreach($agents as $agent)
                            <option value="{{ $agent->id }}" {{ in_array($agent->id, $assignedAgentIds) ? 'selected' : '' }}>
                                {{ $agent->first_name }} {{ $agent->last_name }} - {{ $agent->position }}
                            </option>
                        @endforeach
                    </select>
                    <p class="mt-1 text-xs text-gray-500">You can select multiple agents. First selected will be the listing agent.</p>
                </div>
            </div>
        </div>

        <!-- Submit Buttons -->
        <div class="flex items-center gap-4">
            <button type="submit" id="submitBtn"
                    class="px-8 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-semibold text-lg shadow-lg hover:shadow-xl">
                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Update Property
            </button>
            <a href="{{ route('agency.properties.show', $property) }}" class="px-6 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition font-medium">
                Cancel
            </a>
        </div>
    </form>
</div>

<!-- Success Modal -->
<div id="successModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full p-8 transform transition-all scale-95" id="modalContent">
        <!-- Success Icon -->
        <div class="flex justify-center mb-6">
            <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center animate-bounce">
                <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
        </div>

        <!-- Title -->
        <h2 class="text-3xl font-bold text-center text-gray-900 mb-2">✨ Successfully Updated!</h2>
        <p class="text-center text-gray-600 mb-8 text-lg">Your property has been successfully updated</p>

        <!-- Share Section Title -->
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Share your property listing</h3>

        <!-- Copy Link Section -->
        <div class="bg-gray-50 rounded-xl border border-gray-200 p-4 mb-6">
            <div class="flex items-center gap-3">
                <button onclick="copyUrl()" id="copyBtn"
                        class="px-5 py-2.5 bg-gray-800 text-white rounded-lg hover:bg-gray-900 transition flex items-center gap-2 font-medium shadow-sm flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                    </svg>
                    <span id="copyText">Copy link</span>
                </button>

                <input type="text" id="propertyUrl" readonly
                       class="flex-1 px-4 py-2.5 bg-white border border-gray-300 rounded-lg text-sm font-mono text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 cursor-pointer"
                       onclick="this.select(); copyUrl();">

                <a href="#" id="viewPropertyBtn" target="_blank"
                   class="px-4 py-2.5 text-gray-600 hover:text-gray-900 transition flex items-center gap-2 flex-shrink-0">
                    <span class="text-sm font-medium">Edit</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                </a>
            </div>
        </div>

        <!-- Link Preview Card -->
        <div class="bg-white border border-gray-200 rounded-lg p-4 mb-6 hover:border-gray-300 transition">
            <div class="flex items-start gap-4">
                <!-- Preview Icon/Image -->
                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                </div>
                
                <!-- Preview Info -->
                <div class="flex-1 min-w-0">
                    <h4 class="font-semibold text-gray-900 text-sm mb-1">Property Listing</h4>
                    <p class="text-xs text-gray-500 truncate" id="previewUrl">Loading...</p>
                </div>

                <!-- Preview Button -->
                <a href="#" id="viewPropertyBtn2" target="_blank"
                   class="px-3 py-1.5 text-xs font-medium text-blue-600 hover:text-blue-700 hover:bg-blue-50 rounded transition flex items-center gap-1 flex-shrink-0">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    Preview
                </a>
            </div>
        </div>

        <!-- Info Message -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 mb-6">
            <p class="text-sm text-blue-800 text-center flex items-center justify-center gap-2">
                <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                </svg>
                <span>Share this link with potential tenants or buyers to view the property details</span>
            </p>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-3">
            <a href="#" id="viewPropertyBtnMain" target="_blank"
               class="flex-1 px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg hover:from-blue-700 hover:to-indigo-700 transition text-center font-semibold shadow-md hover:shadow-lg flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                </svg>
                View Property Page
            </a>
            <button onclick="closeModal()" 
                    class="flex-1 px-6 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition font-semibold">
                Done
            </button>
        </div>

        <div class="mt-4 text-center">
            <a href="{{ route('agency.properties.show', $property) }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium inline-flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Property Details
            </a>
        </div>
    </div>
</div>

<!-- Add Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<!-- Add jQuery and Select2 JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
// Initialize Select2 for agents
$(document).ready(function() {
    $('.select2-agents').select2({
        placeholder: 'Select agents...',
        allowClear: true,
        width: '100%',
        theme: 'default'
    });
});

// Toggle pricing section based on listing type
function togglePricing() {
    const listingType = document.getElementById('listing_type').value;
    const rentPricing = document.getElementById('rentPricing');
    const salePricing = document.getElementById('salePricing');
    
    if (listingType === 'rent') {
        rentPricing.classList.remove('hidden');
        salePricing.classList.add('hidden');
        document.getElementById('rent_per_week').required = true;
        document.getElementById('price').required = false;
    } else if (listingType === 'sale') {
        rentPricing.classList.add('hidden');
        salePricing.classList.remove('hidden');
        document.getElementById('rent_per_week').required = false;
        document.getElementById('price').required = true;
    } else {
        rentPricing.classList.add('hidden');
        salePricing.classList.add('hidden');
    }
}

// Calculate bond amount
function calculateBond() {
    const rentPerWeek = parseFloat(document.getElementById('rent_per_week').value) || 0;
    const bondWeeks = parseInt(document.getElementById('bond_weeks').value) || 4;
    const bondAmount = rentPerWeek * bondWeeks;
    
    document.getElementById('bondDisplay').textContent = '$' + bondAmount.toLocaleString('en-AU', {
        minimumFractionDigits: 0,
        maximumFractionDigits: 0
    });
}

// Preview floorplan
function previewFloorplan(input) {
    const preview = document.getElementById('floorplanPreview');
    preview.innerHTML = '';
    
    if (input.files && input.files[0]) {
        const file = input.files[0];
        const div = document.createElement('div');
        div.className = 'flex items-center gap-3 p-3 bg-blue-50 border border-blue-200 rounded-lg';
        div.innerHTML = `
            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <div class="flex-1">
                <div class="font-medium text-sm text-gray-900">${file.name}</div>
                <div class="text-xs text-gray-600">${(file.size / 1024 / 1024).toFixed(2)} MB</div>
            </div>
        `;
        preview.appendChild(div);
        preview.classList.remove('hidden');
    }
}

// Preview property images
function previewImages(input) {
    const preview = document.getElementById('imagesPreview');
    preview.innerHTML = '';
    
    if (input.files) {
        Array.from(input.files).forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const div = document.createElement('div');
                div.className = 'relative group';
                div.innerHTML = `
                    <img src="${e.target.result}" class="w-full h-32 object-cover rounded-lg border-2 border-gray-200">
                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition rounded-lg"></div>
                `;
                preview.appendChild(div);
            };
            reader.readAsDataURL(file);
        });
    }
}

// Delete existing image
async function deleteImage(propertyId, imageId) {
    if (!confirm('Are you sure you want to delete this image?')) {
        return;
    }
    
    try {
        const csrfToken = document.querySelector('input[name="_token"]').value;
        
        const response = await fetch(`/agency/properties/${propertyId}/images/${imageId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            }
        });
        
        if (response.ok) {
            document.getElementById(`image-${imageId}`).remove();
        } else {
            alert('Failed to delete image');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Failed to delete image');
    }
}

// Form submission with AJAX
document.getElementById('propertyForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const submitBtn = document.getElementById('submitBtn');
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<svg class="animate-spin h-5 w-5 inline mr-2" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Updating Property...';
    
    const formData = new FormData(this);
    
    try {
        // Get CSRF token from the form
        const csrfToken = document.querySelector('input[name="_token"]').value;
        
        const response = await fetch('{{ route("agency.properties.update", $property) }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            }
        });
        
        const data = await response.json();
        
        if (data.success) {
            // Populate all URL fields in the modal
            document.getElementById('propertyUrl').value = data.public_url;
            document.getElementById('previewUrl').textContent = data.public_url;
            document.getElementById('viewPropertyBtn').href = data.public_url;
            document.getElementById('viewPropertyBtn2').href = data.public_url;
            document.getElementById('viewPropertyBtnMain').href = data.public_url;
            
            // Show success modal
            document.getElementById('successModal').classList.remove('hidden');
            setTimeout(() => {
                document.getElementById('modalContent').classList.remove('scale-95');
                document.getElementById('modalContent').classList.add('scale-100');
            }, 10);
        } else {
            alert('Error: ' + (data.message || 'Something went wrong'));
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>Update Property';
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Failed to update property. Please try again.');
        submitBtn.disabled = false;
        submitBtn.innerHTML = '<svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>Update Property';
    }
});

// Copy URL to clipboard
function copyUrl() {
    const input = document.getElementById('propertyUrl');
    input.select();
    input.setSelectionRange(0, 99999); // For mobile devices
    
    // Modern clipboard API
    navigator.clipboard.writeText(input.value).then(() => {
        const copyBtn = document.getElementById('copyBtn');
        const copyText = document.getElementById('copyText');
        
        copyText.textContent = '✓ Copied!';
        copyBtn.classList.add('bg-green-600', 'hover:bg-green-700');
        copyBtn.classList.remove('bg-blue-600', 'hover:bg-blue-700');
        
        setTimeout(() => {
            copyText.textContent = 'Copy';
            copyBtn.classList.remove('bg-green-600', 'hover:bg-green-700');
            copyBtn.classList.add('bg-blue-600', 'hover:bg-blue-700');
        }, 2000);
    }).catch(() => {
        // Fallback for older browsers
        document.execCommand('copy');
        const copyText = document.getElementById('copyText');
        copyText.textContent = '✓ Copied!';
        setTimeout(() => {
            copyText.textContent = 'Copy';
        }, 2000);
    });
}

// Close modal
function closeModal() {
    document.getElementById('successModal').classList.add('hidden');
    window.location.href = '{{ route("agency.properties.show", $property) }}';
}

// Close modal on backdrop click
document.getElementById('successModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeModal();
    }
});

// Prevent modal close on content click
document.getElementById('modalContent').addEventListener('click', function(e) {
    e.stopPropagation();
});

// Initialize bond calculation on page load
document.addEventListener('DOMContentLoaded', function() {
    calculateBond();
});
</script>

<style>
/* Custom Select2 styling to match your design */
.select2-container--default .select2-selection--multiple {
    border: 1px solid #d1d5db !important;
    border-radius: 0.5rem !important;
    padding: 0.375rem !important;
    min-height: 42px !important;
}

.select2-container--default.select2-container--focus .select2-selection--multiple {
    border-color: #3b82f6 !important;
    box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.5) !important;
}

.select2-container--default .select2-selection--multiple .select2-selection__choice {
    background-color: #3b82f6 !important;
    border: none !important;
    border-radius: 0.375rem !important;
    padding: 0.25rem 0.5rem !important;
    color: white !important;
}

.select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
    color: white !important;
    margin-right: 0.25rem !important;
}

.select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover {
    color: #dbeafe !important;
}

.select2-dropdown {
    border: 1px solid #d1d5db !important;
    border-radius: 0.5rem !important;
}

.select2-container--default .select2-results__option--highlighted[aria-selected] {
    background-color: #3b82f6 !important;
}

/* Animation for modal */
@keyframes modalFadeIn {
    from {
        opacity: 0;
        transform: scale(0.95);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}

#modalContent {
    animation: modalFadeIn 0.3s ease-out;
}
</style>
@endsection