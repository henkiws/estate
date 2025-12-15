@php
    $currentStep = $step ?? 6;
@endphp

<!-- Has Vehicles Toggle -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
    <label class="flex items-center gap-3 cursor-pointer">
        <input 
            type="checkbox" 
            name="has_vehicles" 
            id="has-vehicles"
            value="1"
            onchange="toggleStep6Vehicles()"
            {{ old('has_vehicles', $user->vehicles->count() > 0) ? 'checked' : '' }}
            class="w-5 h-5 text-teal-600 border-gray-300 rounded focus:ring-2 focus:ring-teal-500"
        >
        <span class="font-medium text-gray-900">I have vehicles</span>
    </label>
    <p class="text-sm text-gray-600 mt-2 ml-8">Check this if you have any vehicles that will be parked at the property</p>
</div>

<div id="vehicles-section" style="display: {{ old('has_vehicles', $user->vehicles->count() > 0) ? 'block' : 'none' }};">
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
                                onclick="removeStep6Vehicle({{ $index }})"
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
                                
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500"
                            >
                                <option value="">Select type</option>
                                <option value="car" {{ ($vehicle['vehicle_type'] ?? '') == 'car' ? 'selected' : '' }}>Car</option>
                                <option value="motorcycle" {{ ($vehicle['vehicle_type'] ?? '') == 'motorcycle' ? 'selected' : '' }}>Motorcycle</option>
                                <option value="truck" {{ ($vehicle['vehicle_type'] ?? '') == 'truck' ? 'selected' : '' }}>Truck</option>
                                <option value="van" {{ ($vehicle['vehicle_type'] ?? '') == 'van' ? 'selected' : '' }}>Van</option>
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
                                
                                min="1900"
                                max="{{ date('Y') + 1 }}"
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
                                
                                oninput="this.value = this.value.toUpperCase()"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 uppercase"
                                placeholder="ABC123"
                            >
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Add Vehicle Button -->
        <button 
            type="button" 
            onclick="addStep6Vehicle()"
            class="w-full py-3 border-2 border-dashed border-gray-300 rounded-lg text-gray-600 hover:border-teal-500 hover:text-teal-600 transition flex items-center justify-center gap-2"
        >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            Add Another Vehicle
        </button>
        
    </x-form-section-card>
</div>

@php
    $previousStep = max(1, $currentStep - 1);
@endphp

<!-- Navigation Buttons -->
<div class="flex items-center justify-between mt-6">
    @if($currentStep > 1)
        <a href="{{ route('user.profile.complete') }}?step={{ $previousStep }}" 
           class="px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 transition flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Back
        </a>
    @else
        <a href="{{ route('user.dashboard') }}" 
           class="px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 transition flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Cancel
        </a>
    @endif
    
    <div class="flex items-center gap-3">
        <a href="{{ route('user.dashboard') }}" class="px-6 py-3 text-gray-600 hover:text-gray-900 font-medium transition">
            Save & Exit
        </a>
        
        <button type="submit" class="px-8 py-3 bg-teal-600 text-white font-semibold rounded-lg hover:bg-teal-700 transition shadow-sm flex items-center gap-2">
            Save & Continue
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </button>
    </div>
</div>

<script>
// Use unique variable name to avoid conflicts
var step6VehicleIndex = {{ count($vehicles) }};

console.log('🚗 Step 6 Vehicle form - vehicleIndex:', step6VehicleIndex);

// UNIQUE function name: toggleStep6Vehicles
function toggleStep6Vehicles() {
    console.log('🔍 toggleStep6Vehicles() called!');
    
    const checkbox = document.getElementById('has-vehicles');
    const section = document.getElementById('vehicles-section');
    
    console.log('Checkbox:', checkbox, 'Checked:', checkbox?.checked);
    console.log('Section:', section, 'Display:', section?.style.display);
    
    if (checkbox && section) {
        if (checkbox.checked) {
            section.style.display = 'block';
            console.log('✅ Showing vehicles section');
        } else {
            section.style.display = 'none';
            console.log('❌ Hiding vehicles section');
        }
    } else {
        console.error('❌ Elements not found!');
    }
}

// UNIQUE function name: addStep6Vehicle
function addStep6Vehicle() {
    console.log('🚗 Adding vehicle. Index:', step6VehicleIndex);
    
    const container = document.getElementById('vehicles-container');
    if (!container) {
        console.error('❌ Container not found!');
        return;
    }
    
    const currentYear = new Date().getFullYear();
    
    const newVehicleHtml = `
        <div class="vehicle-item p-4 border-2 border-gray-200 rounded-lg mb-4" data-index="${step6VehicleIndex}">
            <div class="flex items-center justify-between mb-4">
                <h4 class="font-semibold text-gray-900">Vehicle ${step6VehicleIndex + 1}</h4>
                <button type="button" onclick="removeStep6Vehicle(${step6VehicleIndex})" class="text-red-600 hover:text-red-700 text-sm font-medium">Remove</button>
            </div>
            <div class="grid md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="text-sm font-medium text-gray-700 mb-2 block">Vehicle Type <span class="text-red-500">*</span></label>
                    <select name="vehicles[${step6VehicleIndex}][vehicle_type]" class="w-full px-4 py-3 border border-gray-300 rounded-lg">
                        <option value="">Select type</option>
                        <option value="car">Car</option>
                        <option value="motorcycle">Motorcycle</option>
                        <option value="truck">Truck</option>
                        <option value="van">Van</option>
                    </select>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-700 mb-2 block">Year <span class="text-red-500">*</span></label>
                    <input type="number" name="vehicles[${step6VehicleIndex}][year]" min="1900" max="${currentYear + 1}" class="w-full px-4 py-3 border border-gray-300 rounded-lg" placeholder="2020">
                </div>
            </div>
            <div class="grid md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="text-sm font-medium text-gray-700 mb-2 block">Make <span class="text-red-500">*</span></label>
                    <input type="text" name="vehicles[${step6VehicleIndex}][make]" class="w-full px-4 py-3 border border-gray-300 rounded-lg" placeholder="Toyota">
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-700 mb-2 block">Model <span class="text-red-500">*</span></label>
                    <input type="text" name="vehicles[${step6VehicleIndex}][model]" class="w-full px-4 py-3 border border-gray-300 rounded-lg" placeholder="Camry">
                </div>
            </div>
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="text-sm font-medium text-gray-700 mb-2 block">State <span class="text-red-500">*</span></label>
                    <select name="vehicles[${step6VehicleIndex}][state]" class="w-full px-4 py-3 border border-gray-300 rounded-lg">
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
                    <label class="text-sm font-medium text-gray-700 mb-2 block">Registration <span class="text-red-500">*</span></label>
                    <input type="text" name="vehicles[${step6VehicleIndex}][registration_number]" required oninput="this.value = this.value.toUpperCase()" class="w-full px-4 py-3 border border-gray-300 rounded-lg uppercase" placeholder="ABC123">
                </div>
            </div>
        </div>
    `;
    
    container.insertAdjacentHTML('beforeend', newVehicleHtml);
    console.log('✅ Vehicle added');
    step6VehicleIndex++;
}

// UNIQUE function name: removeStep6Vehicle
function removeStep6Vehicle(index) {
    console.log('🗑️ Removing vehicle:', index);
    const item = document.querySelector(`.vehicle-item[data-index="${index}"]`);
    if (item) {
        item.remove();
        console.log('✅ Removed');
    }
}

// Initialize on load
document.addEventListener('DOMContentLoaded', function() {
    console.log('📄 Step 6 DOM loaded - initializing...');
    toggleStep6Vehicles();
});

console.log('🎯 Step 6 vehicle script loaded');
</script>