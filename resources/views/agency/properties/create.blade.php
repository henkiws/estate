@extends('layouts.admin')

@section('title', 'Add New Property')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Add New Property</h1>
            <p class="text-gray-600 mt-1">List a new property for rent or sale</p>
        </div>
        <a href="{{ route('agency.properties.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Properties
        </a>
    </div>

    <!-- Form -->
    <form id="propertyForm" enctype="multipart/form-data" class="space-y-6">
        @csrf

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
                        <option value="house">House</option>
                        <option value="apartment">Apartment</option>
                        <option value="unit">Unit</option>
                        <option value="townhouse">Townhouse</option>
                        <option value="villa">Villa</option>
                        <option value="land">Land</option>
                        <option value="studio">Studio</option>
                        <option value="duplex">Duplex</option>
                        <option value="farm">Farm</option>
                    </select>
                </div>

                <!-- Listing Type -->
                <div>
                    <label for="listing_type" class="block text-sm font-medium text-gray-700 mb-2">Listing Type *</label>
                    <select name="listing_type" id="listing_type" required onchange="togglePricing()"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Select type...</option>
                        <option value="rent">For Rent</option>
                        <option value="sale">For Sale</option>
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
                    <input type="text" name="unit_number" id="unit_number" placeholder="e.g., Unit 5"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <div>
                    <label for="street_number" class="block text-sm font-medium text-gray-700 mb-2">Street Number</label>
                    <input type="text" name="street_number" id="street_number" placeholder="e.g., 123"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <div>
                    <label for="street_name" class="block text-sm font-medium text-gray-700 mb-2">Street Name *</label>
                    <input type="text" name="street_name" id="street_name" required placeholder="e.g., Main"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <div>
                    <label for="street_type" class="block text-sm font-medium text-gray-700 mb-2">Street Type</label>
                    <select name="street_type" id="street_type"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Select...</option>
                        <option value="Street">Street</option>
                        <option value="Road">Road</option>
                        <option value="Avenue">Avenue</option>
                        <option value="Drive">Drive</option>
                        <option value="Court">Court</option>
                        <option value="Lane">Lane</option>
                        <option value="Place">Place</option>
                    </select>
                </div>

                <div>
                    <label for="suburb" class="block text-sm font-medium text-gray-700 mb-2">Suburb/City *</label>
                    <input type="text" name="suburb" id="suburb" required placeholder="e.g., Sydney"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <div>
                    <label for="state" class="block text-sm font-medium text-gray-700 mb-2">State *</label>
                    <select name="state" id="state" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Select state...</option>
                        <option value="NSW">New South Wales</option>
                        <option value="VIC">Victoria</option>
                        <option value="QLD">Queensland</option>
                        <option value="SA">South Australia</option>
                        <option value="WA">Western Australia</option>
                        <option value="TAS">Tasmania</option>
                        <option value="NT">Northern Territory</option>
                        <option value="ACT">Australian Capital Territory</option>
                    </select>
                </div>

                <div>
                    <label for="postcode" class="block text-sm font-medium text-gray-700 mb-2">Postcode *</label>
                    <input type="text" name="postcode" id="postcode" required placeholder="e.g., 2000" maxlength="4"
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
                    <input type="number" name="bedrooms" id="bedrooms" min="0" placeholder="0"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <div>
                    <label for="bathrooms" class="block text-sm font-medium text-gray-700 mb-2">Bathrooms</label>
                    <input type="number" name="bathrooms" id="bathrooms" min="0" placeholder="0"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <div>
                    <label for="parking_spaces" class="block text-sm font-medium text-gray-700 mb-2">Parking Spaces</label>
                    <input type="number" name="parking_spaces" id="parking_spaces" min="0" placeholder="0"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <div>
                    <label for="land_size" class="block text-sm font-medium text-gray-700 mb-2">Land Size (sqm)</label>
                    <input type="number" name="land_size" id="land_size" min="0" step="0.01" placeholder="0"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <div>
                    <label for="building_size" class="block text-sm font-medium text-gray-700 mb-2">Building Size (sqm)</label>
                    <input type="number" name="building_size" id="building_size" min="0" step="0.01" placeholder="0"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
            </div>

            <!-- Description -->
            <div class="mt-6">
                <label for="headline" class="block text-sm font-medium text-gray-700 mb-2">Property Headline</label>
                <input type="text" name="headline" id="headline" placeholder="e.g., Modern 3BR Home in Prime Location" maxlength="255"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>

            <div class="mt-4">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Property Description</label>
                <textarea name="description" id="description" rows="6" placeholder="Describe the property features, location, and benefits..."
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"></textarea>
            </div>
        </div>

        <!-- 4. Pricing -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-6">4. Pricing</h2>
            
            <!-- For Rent -->
            <div id="rentPricing" class="hidden">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="rent_per_week" class="block text-sm font-medium text-gray-700 mb-2">Rent per Week *</label>
                        <div class="relative">
                            <span class="absolute left-4 top-2.5 text-gray-600">$</span>
                            <input type="number" name="rent_per_week" id="rent_per_week" min="0" step="0.01" placeholder="500" oninput="calculateBond()"
                                   class="w-full pl-8 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                    </div>

                    <div>
                        <label for="bond_weeks" class="block text-sm font-medium text-gray-700 mb-2">Bond (Weeks of Rent)</label>
                        <input type="number" name="bond_weeks" id="bond_weeks" value="4" min="1" max="52" oninput="calculateBond()"
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
                                <div class="text-2xl font-bold text-blue-900" id="bondDisplay">$0</div>
                                <div class="text-sm text-blue-700">Calculated: Rent × Bond Weeks</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- For Sale -->
            <div id="salePricing" class="hidden">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700 mb-2">Sale Price *</label>
                        <div class="relative">
                            <span class="absolute left-4 top-2.5 text-gray-600">$</span>
                            <input type="number" name="price" id="price" min="0" step="1000" placeholder="850000"
                                   class="w-full pl-8 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                    </div>

                    <div>
                        <label for="price_text" class="block text-sm font-medium text-gray-700 mb-2">Price Text (Optional)</label>
                        <input type="text" name="price_text" id="price_text" placeholder="e.g., Offers Over $850,000"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                </div>
            </div>
        </div>

        <!-- 5. Floorplan & Images -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-6">5. Floorplan & Property Images</h2>
            
            <!-- Floorplan -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Floorplan (JPG, PNG, PDF)</label>
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-blue-400 transition">
                    <input type="file" name="floorplan" id="floorplan" accept=".jpg,.jpeg,.png,.pdf" class="hidden" onchange="previewFloorplan(this)">
                    <label for="floorplan" class="cursor-pointer">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                        </svg>
                        <p class="mt-2 text-sm text-gray-600">Click to upload floorplan</p>
                        <p class="text-xs text-gray-500">Max 5MB</p>
                    </label>
                </div>
                <div id="floorplanPreview" class="mt-2 hidden"></div>
            </div>

            <!-- Property Images -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Property Images (Multiple)</label>
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-blue-400 transition">
                    <input type="file" name="images[]" id="images" accept=".jpg,.jpeg,.png" multiple class="hidden" onchange="previewImages(this)">
                    <label for="images" class="cursor-pointer">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <p class="mt-2 text-sm text-gray-600">Click to upload property images</p>
                        <p class="text-xs text-gray-500">JPG or PNG, Max 5MB each, Up to 20 images</p>
                    </label>
                </div>
                <div id="imagesPreview" class="mt-4 grid grid-cols-2 md:grid-cols-4 gap-4"></div>
            </div>
        </div>

        <!-- 6. Features -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-6">6. Property Features</h2>
            
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="features[]" value="Air Conditioning" class="w-4 h-4 text-blue-600 border-gray-300 rounded">
                    <span class="text-sm text-gray-700">Air Conditioning</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="features[]" value="Heating" class="w-4 h-4 text-blue-600 border-gray-300 rounded">
                    <span class="text-sm text-gray-700">Heating</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="features[]" value="Built-in Wardrobes" class="w-4 h-4 text-blue-600 border-gray-300 rounded">
                    <span class="text-sm text-gray-700">Built-in Wardrobes</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="features[]" value="Dishwasher" class="w-4 h-4 text-blue-600 border-gray-300 rounded">
                    <span class="text-sm text-gray-700">Dishwasher</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="features[]" value="Swimming Pool" class="w-4 h-4 text-blue-600 border-gray-300 rounded">
                    <span class="text-sm text-gray-700">Swimming Pool</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="features[]" value="Garage" class="w-4 h-4 text-blue-600 border-gray-300 rounded">
                    <span class="text-sm text-gray-700">Garage</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="features[]" value="Balcony/Deck" class="w-4 h-4 text-blue-600 border-gray-300 rounded">
                    <span class="text-sm text-gray-700">Balcony/Deck</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="features[]" value="Pet Friendly" class="w-4 h-4 text-blue-600 border-gray-300 rounded">
                    <span class="text-sm text-gray-700">Pet Friendly</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="features[]" value="Fully Furnished" class="w-4 h-4 text-blue-600 border-gray-300 rounded">
                    <span class="text-sm text-gray-700">Fully Furnished</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="features[]" value="Alarm System" class="w-4 h-4 text-blue-600 border-gray-300 rounded">
                    <span class="text-sm text-gray-700">Alarm System</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="features[]" value="Broadband Internet" class="w-4 h-4 text-blue-600 border-gray-300 rounded">
                    <span class="text-sm text-gray-700">Broadband Internet</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="features[]" value="Garden/Yard" class="w-4 h-4 text-blue-600 border-gray-300 rounded">
                    <span class="text-sm text-gray-700">Garden/Yard</span>
                </label>
            </div>

            <!-- Custom Features -->
            <div class="mt-6">
                <label for="custom_features" class="block text-sm font-medium text-gray-700 mb-2">Custom Features (comma-separated)</label>
                <input type="text" name="custom_features" id="custom_features" placeholder="e.g., Solar panels, Rainwater tank, EV charging"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <p class="mt-1 text-xs text-gray-500">Add additional features separated by commas</p>
            </div>
        </div>

        <!-- 7. Availability & Agent Assignment -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-6">7. Availability & Agent Assignment</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Availability -->
                <div>
                    <label for="available_from" class="block text-sm font-medium text-gray-700 mb-2">Available From</label>
                    <input type="date" name="available_from" id="available_from"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status *</label>
                    <select name="status" id="status" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="draft">Draft (not visible to public)</option>
                        <option value="active">Active (visible to public)</option>
                    </select>
                </div>

                <!-- Agent Assignment -->
                <div class="md:col-span-2">
                    <label for="agents" class="block text-sm font-medium text-gray-700 mb-2">Assign Agents</label>
                    <select name="agents[]" id="agents" multiple size="5"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        @foreach($agents as $agent)
                            <option value="{{ $agent->id }}">{{ $agent->first_name }} {{ $agent->last_name }} - {{ $agent->position }}</option>
                        @endforeach
                    </select>
                    <p class="mt-1 text-xs text-gray-500">Hold Ctrl/Cmd to select multiple agents. First selected will be the listing agent.</p>
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
                Add Property
            </button>
            <a href="{{ route('agency.properties.index') }}" class="px-6 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition font-medium">
                Cancel
            </a>
        </div>
    </form>
</div>

<!-- Success Modal -->
<div id="successModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-8 transform transition-all scale-95" id="modalContent">
        <!-- Success Icon -->
        <div class="flex justify-center mb-6">
            <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center">
                <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
        </div>

        <!-- Title -->
        <h2 class="text-2xl font-bold text-center text-gray-900 mb-2">Property Added Successfully!</h2>
        <p class="text-center text-gray-600 mb-6">Your property listing is now live</p>

        <!-- URL Display -->
        <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 mb-4">
            <label class="block text-xs font-medium text-gray-700 mb-2">Property Link:</label>
            <div class="flex items-center gap-2">
                <input type="text" id="propertyUrl" readonly
                       class="flex-1 px-3 py-2 bg-white border border-gray-300 rounded text-sm font-mono focus:outline-none focus:ring-2 focus:ring-blue-500">
                <button onclick="copyUrl()" id="copyBtn"
                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                    </svg>
                    <span id="copyText">Copy</span>
                </button>
            </div>
        </div>

        <p class="text-sm text-gray-600 text-center mb-6">
            Share this link with potential tenants/buyers. They can view property details and submit applications directly.
        </p>

        <!-- Action Buttons -->
        <div class="flex gap-3">
            <a href="#" id="viewPropertyBtn" target="_blank"
               class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-center font-medium">
                View Property
            </a>
            <button onclick="closeModal()" 
                    class="flex-1 px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition font-medium">
                Close
            </button>
        </div>
    </div>
</div>

<script>
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
                    ${index === 0 ? '<div class="absolute top-2 left-2 px-2 py-1 bg-blue-600 text-white text-xs rounded">Featured</div>' : ''}
                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition rounded-lg"></div>
                `;
                preview.appendChild(div);
            };
            reader.readAsDataURL(file);
        });
    }
}

// Form submission with AJAX
document.getElementById('propertyForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const submitBtn = document.getElementById('submitBtn');
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<svg class="animate-spin h-5 w-5 inline mr-2" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Creating Property...';
    
    const formData = new FormData(this);
    
    try {
        const response = await fetch('{{ route("agency.properties.store") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });
        
        const data = await response.json();
        
        if (data.success) {
            // Show success modal
            document.getElementById('propertyUrl').value = data.public_url;
            document.getElementById('viewPropertyBtn').href = data.public_url;
            document.getElementById('successModal').classList.remove('hidden');
            setTimeout(() => {
                document.getElementById('modalContent').classList.remove('scale-95');
                document.getElementById('modalContent').classList.add('scale-100');
            }, 10);
        } else {
            alert('Error: ' + (data.message || 'Something went wrong'));
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>Add Property';
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Failed to create property. Please try again.');
        submitBtn.disabled = false;
        submitBtn.innerHTML = '<svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>Add Property';
    }
});

// Copy URL to clipboard
function copyUrl() {
    const input = document.getElementById('propertyUrl');
    input.select();
    document.execCommand('copy');
    
    const copyBtn = document.getElementById('copyBtn');
    const copyText = document.getElementById('copyText');
    copyText.textContent = 'Copied!';
    copyBtn.classList.add('bg-green-600');
    copyBtn.classList.remove('bg-blue-600');
    
    setTimeout(() => {
        copyText.textContent = 'Copy';
        copyBtn.classList.remove('bg-green-600');
        copyBtn.classList.add('bg-blue-600');
    }, 2000);
}

// Close modal
function closeModal() {
    document.getElementById('successModal').classList.add('hidden');
    window.location.href = '{{ route("agency.properties.index") }}';
}

// Close modal on backdrop click
document.getElementById('successModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeModal();
    }
});
</script>
@endsection