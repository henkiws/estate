<!-- Has Vehicles Toggle -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
    <label class="flex items-center gap-3 cursor-pointer">
        <input 
            type="checkbox" 
            name="has_vehicles" 
            id="has-vehicles"
            value="1"
            onchange="toggleVehiclesSection()"
            {{ old('has_vehicles', $user->vehicles->count() > 0) ? 'checked' : '' }}
            class="w-5 h-5 text-teal-600 border-gray-300 rounded focus:ring-2 focus:ring-teal-500"
        >
        <span class="font-medium text-gray-900">I have vehicles</span>
    </label>
    <p class="text-sm text-gray-600 mt-2 ml-8">Check this if you have any vehicles that will be parked at the property</p>
</div>

<div id="vehicles-section" class="{{ old('has_vehicles', $user->vehicles->count() > 0) ? '' : 'hidden' }}">
    <x-form-section-card 
        title="Vehicle Information" 
        description="Provide details about your vehicles"
        required>
        
        <div id="vehicles-container">
            @php
                $vehicles = old('vehicles', $user->vehicles->toArray() ?: [['vehicle_type' => '']]);
            @endphp
            
            @foreach($vehicles as $index => $vehicle)
                <div class="vehicle-item p-4 border-2 border-gray-200 rounded-lg mb-4" data-index="{{ $index }}">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="font-semibold text-gray-900">Vehicle {{ $index + 1 }}</h4>
                        @if($index > 0)
                            <button 
                                type="button" 
                                onclick="removeVehicle({{ $index }})"
                                class="text-red-600 hover:text-red-700 text-sm font-medium"
                            >
                                Remove
                            </button>
                        @endif
                    </div>
                    
                    <div class="grid md:grid-cols-2 gap-4 mb-4">
                        <!-- Vehicle Type -->
                        <div>
                            <label class="flex items-center gap-2 text-sm font-medium text-gray-700 mb-2">
                                Vehicle Type <span class="text-red-500">*</span>
                                <x-profile-help-text text="Type of vehicle you own" />
                            </label>
                            <select 
                                name="vehicles[{{ $index }}][vehicle_type]" 
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500"
                            >
                                <option value="">Select type</option>
                                <option value="car" {{ ($vehicle['vehicle_type'] ?? '') == 'car' ? 'selected' : '' }}>Car</option>
                                <option value="motorcycle" {{ ($vehicle['vehicle_type'] ?? '') == 'motorcycle' ? 'selected' : '' }}>Motorcycle</option>
                            </select>
                        </div>
                        
                        <!-- Year -->
                        <div>
                            <label class="flex items-center gap-2 text-sm font-medium text-gray-700 mb-2">
                                Year <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="number" 
                                name="vehicles[{{ $index }}][year]" 
                                value="{{ $vehicle['year'] ?? '' }}"
                                required
                                min="1900"
                                max="{{ date('Y') + 1 }}"
                                maxlength="4"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500"
                                placeholder="2020"
                            >
                        </div>
                    </div>
                    
                    <div class="grid md:grid-cols-2 gap-4 mb-4">
                        <!-- Make -->
                        <div>
                            <label class="flex items-center gap-2 text-sm font-medium text-gray-700 mb-2">
                                Make <span class="text-red-500">*</span>
                                <x-profile-help-text text="Vehicle manufacturer (e.g., Toyota, Honda, Ford)" />
                            </label>
                            <input 
                                type="text" 
                                name="vehicles[{{ $index }}][make]" 
                                value="{{ $vehicle['make'] ?? '' }}"
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500"
                                placeholder="Toyota"
                            >
                        </div>
                        
                        <!-- Model -->
                        <div>
                            <label class="flex items-center gap-2 text-sm font-medium text-gray-700 mb-2">
                                Model <span class="text-red-500">*</span>
                                <x-profile-help-text text="Vehicle model (e.g., Camry, Civic, Ranger)" />
                            </label>
                            <input 
                                type="text" 
                                name="vehicles[{{ $index }}][model]" 
                                value="{{ $vehicle['model'] ?? '' }}"
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500"
                                placeholder="Camry"
                            >
                        </div>
                    </div>
                    
                    <div class="grid md:grid-cols-2 gap-4">
                        <!-- State -->
                        <div>
                            <label class="flex items-center gap-2 text-sm font-medium text-gray-700 mb-2">
                                Registered State <span class="text-red-500">*</span>
                            </label>
                            <select 
                                name="vehicles[{{ $index }}][state]" 
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500"
                            >
                                <option value="">Select state</option>
                                <option value="NSW" {{ ($vehicle['state'] ?? '') == 'NSW' ? 'selected' : '' }}>NSW</option>
                                <option value="VIC" {{ ($vehicle['state'] ?? '') == 'VIC' ? 'selected' : '' }}>VIC</option>
                                <option value="QLD" {{ ($vehicle['state'] ?? '') == 'QLD' ? 'selected' : '' }}>QLD</option>
                                <option value="SA" {{ ($vehicle['state'] ?? '') == 'SA' ? 'selected' : '' }}>SA</option>
                                <option value="WA" {{ ($vehicle['state'] ?? '') == 'WA' ? 'selected' : '' }}>WA</option>
                                <option value="TAS" {{ ($vehicle['state'] ?? '') == 'TAS' ? 'selected' : '' }}>TAS</option>
                                <option value="NT" {{ ($vehicle['state'] ?? '') == 'NT' ? 'selected' : '' }}>NT</option>
                                <option value="ACT" {{ ($vehicle['state'] ?? '') == 'ACT' ? 'selected' : '' }}>ACT</option>
                            </select>
                        </div>
                        
                        <!-- Registration Number -->
                        <div>
                            <label class="flex items-center gap-2 text-sm font-medium text-gray-700 mb-2">
                                Registration Number <span class="text-red-500">*</span>
                                <x-profile-help-text text="Vehicle registration plate number" />
                            </label>
                            <input 
                                type="text" 
                                name="vehicles[{{ $index }}][registration_number]" 
                                value="{{ $vehicle['registration_number'] ?? '' }}"
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 uppercase"
                                placeholder="ABC123"
                                style="text-transform: uppercase;"
                            >
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Add Vehicle Button -->
        <button 
            type="button" 
            onclick="addVehicle()"
            class="w-full py-3 border-2 border-dashed border-gray-300 rounded-lg text-gray-600 hover:border-teal-500 hover:text-teal-600 transition flex items-center justify-center gap-2"
        >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            Add Another Vehicle
        </button>
        
    </x-form-section-card>
</div>

<!-- Navigation -->
<div class="flex items-center justify-between mt-6">
    <button 
        type="button" 
        onclick="window.history.back()"
        class="px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 transition flex items-center gap-2"
    >
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Back
    </button>
    
    <button 
        type="submit" 
        class="px-8 py-3 bg-teal-600 text-white font-semibold rounded-lg hover:bg-teal-700 transition shadow-sm flex items-center gap-2"
    >
        Save & Continue
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
    </button>
</div>

<script>
let vehicleIndex = {{ count($vehicles) }};

function toggleVehiclesSection() {
    const checkbox = document.getElementById('has-vehicles');
    const section = document.getElementById('vehicles-section');
    
    if (checkbox.checked) {
        section.classList.remove('hidden');
    } else {
        section.classList.add('hidden');
    }
}

function addVehicle() {
    const container = document.getElementById('vehicles-container');
    const currentYear = new Date().getFullYear();
    
    const newVehicle = `
        <div class="vehicle-item p-4 border-2 border-gray-200 rounded-lg mb-4" data-index="${vehicleIndex}">
            <div class="flex items-center justify-between mb-4">
                <h4 class="font-semibold text-gray-900">Vehicle ${vehicleIndex + 1}</h4>
                <button type="button" onclick="removeVehicle(${vehicleIndex})" class="text-red-600 hover:text-red-700 text-sm font-medium">
                    Remove
                </button>
            </div>
            
            <div class="grid md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="text-sm font-medium text-gray-700 mb-2 block">Vehicle Type <span class="text-red-500">*</span></label>
                    <select name="vehicles[${vehicleIndex}][vehicle_type]" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">
                        <option value="">Select type</option>
                        <option value="car">Car</option>
                        <option value="motorcycle">Motorcycle</option>
                    </select>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-700 mb-2 block">Year <span class="text-red-500">*</span></label>
                    <input type="number" name="vehicles[${vehicleIndex}][year]" required min="1900" max="${currentYear + 1}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500" placeholder="2020">
                </div>
            </div>
            
            <div class="grid md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="text-sm font-medium text-gray-700 mb-2 block">Make <span class="text-red-500">*</span></label>
                    <input type="text" name="vehicles[${vehicleIndex}][make]" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500" placeholder="Toyota">
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-700 mb-2 block">Model <span class="text-red-500">*</span></label>
                    <input type="text" name="vehicles[${vehicleIndex}][model]" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500" placeholder="Camry">
                </div>
            </div>
            
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="text-sm font-medium text-gray-700 mb-2 block">State <span class="text-red-500">*</span></label>
                    <select name="vehicles[${vehicleIndex}][state]" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">
                        <option value="">Select state</option>
                        <option value="NSW">NSW</option>
                        <option value="VIC">VIC</option>
                        <option value="QLD">QLD</option>
                        <option value="SA">SA</option>
                        <option value="WA">WA</option>
                        <option value="TAS">TAS</option>
                        <option value="NT">NT</option>
                        <option value="ACT">ACT</option>
                    </select>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-700 mb-2 block">Registration Number <span class="text-red-500">*</span></label>
                    <input type="text" name="vehicles[${vehicleIndex}][registration_number]" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 uppercase" placeholder="ABC123" style="text-transform: uppercase;">
                </div>
            </div>
        </div>
    `;
    
    container.insertAdjacentHTML('beforeend', newVehicle);
    vehicleIndex++;
}

function removeVehicle(index) {
    const item = document.querySelector(`.vehicle-item[data-index="${index}"]`);
    if (item) {
        item.remove();
    }
}
</script>