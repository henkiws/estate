<!-- Vehicles Card -->
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-4 hover:shadow-md transition-shadow" id="vehicles-card">
    
    <!-- Card Header (Always Visible) -->
    <div class="p-6">
        <div class="flex items-start justify-between">
            
            <!-- Left: Icon + Content -->
            <div class="flex items-start gap-4 flex-1">
                <!-- Icon -->
                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-plyform-green/20 to-plyform-mint/30 flex items-center justify-center text-plyform-dark flex-shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"/>
                    </svg>
                </div>
                
                <!-- Content -->
                <div class="flex-1">
                    <h3 class="text-lg font-semibold text-plyform-dark">Vehicles</h3>
                    <p class="text-sm text-gray-600 mt-1" id="vehicles-summary">
                        @if($user->vehicles && $user->vehicles->count() > 0)
                            {{ $user->vehicles->count() }} {{ Str::plural('vehicle', $user->vehicles->count()) }}
                        @else
                            None
                        @endif
                    </p>
                    
                    <!-- Status Badge -->
                    <div class="mt-3">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-plyform-mint text-plyform-dark border border-plyform-mint" id="vehicles-status">
                            Complete
                        </span>
                    </div>
                </div>
            </div>
            
            <!-- Right: Completion % + Edit Button -->
            <div class="flex items-start gap-4 ml-4">
                <!-- Completion Percentage -->
                <div class="flex items-center justify-center w-14 h-14 rounded-full border-4 border-[#5E17EB] bg-white">
                    <span class="text-xs font-bold text-[#5E17EB]" id="vehicles-percentage">100%</span>
                </div>
                
                <!-- Edit Button -->
                <button 
                    type="button" 
                    onclick="toggleVehicles()"
                    class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-plyform-purple hover:text-plyform-dark hover:bg-plyform-purple/10 rounded-lg transition"
                    id="vehicles-edit-btn"
                >
                    <span>Edit</span>
                    <svg class="w-4 h-4 transition-transform" id="vehicles-chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
            </div>
            
        </div>
    </div>
    
    <!-- Expandable Form Content (Hidden by Default) -->
    <div class="border-t border-gray-200 bg-gray-50 hidden" id="vehicles-form">
        <form method="POST" action="{{ route('user.profile.update-step') }}" class="p-6 space-y-6">
            @csrf
            <input type="hidden" name="current_step" value="6">
            
            <!-- Has Vehicles Toggle -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <label class="flex items-center gap-3 cursor-pointer">
                    <input 
                        type="checkbox" 
                        name="has_vehicles" 
                        id="has-vehicles"
                        value="1"
                        onchange="toggleVehiclesSection()"
                        {{ old('has_vehicles', $user->vehicles->count() > 0) ? 'checked' : '' }}
                        class="w-5 h-5 text-plyform-green border-gray-300 rounded focus:ring-2 focus:ring-plyform-green/20"
                    >
                    <span class="font-medium text-plyform-dark">I have vehicles</span>
                </label>
                <p class="text-sm text-gray-600 mt-2 ml-8">Check this if you have any vehicles that will be parked at the property</p>
            </div>

            <div id="vehicles-section" style="display: {{ old('has_vehicles', $user->vehicles->count() > 0) ? 'block' : 'none' }};">
                <!-- Vehicle Information Section -->
                <div class="bg-white rounded-lg p-6 space-y-4">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h4 class="text-base font-semibold text-plyform-dark">Vehicle Information</h4>
                            <p class="text-sm text-gray-600 mt-1">Provide details about your vehicles</p>
                        </div>
                        <span class="text-plyform-orange text-sm font-medium">* Required</span>
                    </div>
                    
                    <div id="vehicles-container">
                        @php
                            $vehicles = old('vehicles', $user->vehicles->toArray() ?: [['vehicle_type' => '']]);
                        @endphp
                        
                        @foreach($vehicles as $index => $vehicle)
                            <div class="vehicle-item p-4 border-2 border-gray-200 rounded-lg mb-4 hover:border-plyform-mint/50 transition-colors" data-index="{{ $index }}">
                                <div class="flex items-center justify-between mb-4">
                                    <h4 class="font-semibold text-plyform-dark">Vehicle {{ $index + 1 }}</h4>
                                    @if($index > 0)
                                        <button 
                                            type="button" 
                                            onclick="removeVehicleItem({{ $index }})"
                                            class="text-plyform-orange hover:text-red-700 text-sm font-medium hover:bg-plyform-orange/10 px-3 py-1 rounded-lg transition-colors"
                                        >
                                            Remove
                                        </button>
                                    @endif
                                </div>
                                
                                <div class="grid md:grid-cols-2 gap-4 mb-4">
                                    <!-- Vehicle Type -->
                                    <div>
                                        <label class="flex items-center gap-2 text-sm font-medium text-plyform-dark mb-2">
                                            Vehicle Type <span class="text-plyform-orange">*</span>
                                        </label>
                                        <select 
                                            name="vehicles[{{ $index }}][vehicle_type]" 
                                            required
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all"
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
                                        <label class="flex items-center gap-2 text-sm font-medium text-plyform-dark mb-2">
                                            Year <span class="text-plyform-orange">*</span>
                                        </label>
                                        <input 
                                            type="number" 
                                            name="vehicles[{{ $index }}][year]" 
                                            value="{{ $vehicle['year'] ?? '' }}"
                                            required
                                            min="1900"
                                            max="{{ date('Y') + 1 }}"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all"
                                            placeholder="2020"
                                        >
                                    </div>
                                </div>
                                
                                <div class="grid md:grid-cols-2 gap-4 mb-4">
                                    <!-- Make -->
                                    <div>
                                        <label class="flex items-center gap-2 text-sm font-medium text-plyform-dark mb-2">
                                            Make <span class="text-plyform-orange">*</span>
                                        </label>
                                        <input 
                                            type="text" 
                                            name="vehicles[{{ $index }}][make]" 
                                            value="{{ $vehicle['make'] ?? '' }}"
                                            required
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all"
                                            placeholder="Toyota"
                                        >
                                    </div>
                                    
                                    <!-- Model -->
                                    <div>
                                        <label class="flex items-center gap-2 text-sm font-medium text-plyform-dark mb-2">
                                            Model <span class="text-plyform-orange">*</span>
                                        </label>
                                        <input 
                                            type="text" 
                                            name="vehicles[{{ $index }}][model]" 
                                            value="{{ $vehicle['model'] ?? '' }}"
                                            required
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all"
                                            placeholder="Camry"
                                        >
                                    </div>
                                </div>
                                
                                <div class="grid md:grid-cols-2 gap-4">
                                    <!-- State -->
                                    <div>
                                        <label class="flex items-center gap-2 text-sm font-medium text-plyform-dark mb-2">
                                            Registered State <span class="text-plyform-orange">*</span>
                                        </label>
                                        <select 
                                            name="vehicles[{{ $index }}][state]" 
                                            required
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all"
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
                                        <label class="flex items-center gap-2 text-sm font-medium text-plyform-dark mb-2">
                                            Registration Number <span class="text-plyform-orange">*</span>
                                        </label>
                                        <input 
                                            type="text" 
                                            name="vehicles[{{ $index }}][registration_number]" 
                                            value="{{ $vehicle['registration_number'] ?? '' }}"
                                            required
                                            oninput="this.value = this.value.toUpperCase()"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all uppercase"
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
                        onclick="addVehicleItem()"
                        class="w-full py-3 border-2 border-dashed border-gray-300 rounded-lg text-gray-600 hover:border-plyform-green hover:text-plyform-dark hover:bg-plyform-green/5 transition flex items-center justify-center gap-2 font-medium"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Add Another Vehicle
                    </button>
                    
                </div>
            </div>
            
            <!-- Form Actions -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200">
                <button 
                    type="button" 
                    onclick="toggleVehicles()"
                    class="px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 transition"
                >
                    Cancel
                </button>
                
                <button 
                    type="submit" 
                    class="px-8 py-3 bg-gradient-to-r from-plyform-green to-plyform-green text-white font-semibold rounded-lg hover:from-plyform-green/90 hover:to-plyform-green/90 transition shadow-sm flex items-center gap-2"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Save Changes
                </button>
            </div>
            
        </form>
    </div>
    
</div>

<script>
// Initialize vehicle index
var vehicleIndex = {{ count($vehicles ?? []) }};

function toggleVehicles() {
    const formDiv = document.getElementById('vehicles-form');
    const chevron = document.getElementById('vehicles-chevron');
    const editBtn = document.getElementById('vehicles-edit-btn');
    
    if (formDiv.classList.contains('hidden')) {
        // Expand
        formDiv.classList.remove('hidden');
        chevron.style.transform = 'rotate(180deg)';
        editBtn.querySelector('span').textContent = 'Close';
        
        // Scroll to card
        setTimeout(() => {
            document.getElementById('vehicles-card').scrollIntoView({ 
                behavior: 'smooth', 
                block: 'start' 
            });
        }, 100);
    } else {
        // Collapse
        formDiv.classList.add('hidden');
        chevron.style.transform = 'rotate(0deg)';
        editBtn.querySelector('span').textContent = 'Edit';
    }
}

// Toggle vehicles section visibility
function toggleVehiclesSection() {
    const checkbox = document.getElementById('has-vehicles');
    const section = document.getElementById('vehicles-section');
    
    if (checkbox && section) {
        if (checkbox.checked) {
            section.style.display = 'block';
        } else {
            section.style.display = 'none';
        }
    }
}

// Add new vehicle
function addVehicleItem() {
    const container = document.getElementById('vehicles-container');
    
    if (!container) {
        console.error('Container not found!');
        return;
    }
    
    const currentYear = new Date().getFullYear();
    
    const newVehicleHtml = `
        <div class="vehicle-item p-4 border-2 border-gray-200 rounded-lg mb-4 hover:border-plyform-mint/50 transition-colors" data-index="${vehicleIndex}">
            <div class="flex items-center justify-between mb-4">
                <h4 class="font-semibold text-plyform-dark">Vehicle ${vehicleIndex + 1}</h4>
                <button type="button" onclick="removeVehicleItem(${vehicleIndex})" class="text-plyform-orange hover:text-red-700 text-sm font-medium hover:bg-plyform-orange/10 px-3 py-1 rounded-lg transition-colors">Remove</button>
            </div>
            <div class="grid md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="text-sm font-medium text-plyform-dark mb-2 block">Vehicle Type <span class="text-plyform-orange">*</span></label>
                    <select name="vehicles[${vehicleIndex}][vehicle_type]" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all">
                        <option value="">Select type</option>
                        <option value="car">Car</option>
                        <option value="motorcycle">Motorcycle</option>
                        <option value="truck">Truck</option>
                        <option value="van">Van</option>
                    </select>
                </div>
                <div>
                    <label class="text-sm font-medium text-plyform-dark mb-2 block">Year <span class="text-plyform-orange">*</span></label>
                    <input type="number" name="vehicles[${vehicleIndex}][year]" required min="1900" max="${currentYear + 1}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all" placeholder="2020">
                </div>
            </div>
            <div class="grid md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="text-sm font-medium text-plyform-dark mb-2 block">Make <span class="text-plyform-orange">*</span></label>
                    <input type="text" name="vehicles[${vehicleIndex}][make]" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all" placeholder="Toyota">
                </div>
                <div>
                    <label class="text-sm font-medium text-plyform-dark mb-2 block">Model <span class="text-plyform-orange">*</span></label>
                    <input type="text" name="vehicles[${vehicleIndex}][model]" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all" placeholder="Camry">
                </div>
            </div>
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="text-sm font-medium text-plyform-dark mb-2 block">State <span class="text-plyform-orange">*</span></label>
                    <select name="vehicles[${vehicleIndex}][state]" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all">
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
                    <label class="text-sm font-medium text-plyform-dark mb-2 block">Registration <span class="text-plyform-orange">*</span></label>
                    <input type="text" name="vehicles[${vehicleIndex}][registration_number]" required oninput="this.value = this.value.toUpperCase()" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all uppercase" placeholder="ABC123">
                </div>
            </div>
        </div>
    `;
    
    container.insertAdjacentHTML('beforeend', newVehicleHtml);

    const newElement = container.lastElementChild;
    if (typeof reinitializePlugins === 'function') {
        reinitializePlugins(newElement);
    }

    vehicleIndex++;
}

// Remove vehicle
function removeVehicleItem(index) {
    const item = document.querySelector(`.vehicle-item[data-index="${index}"]`);
    if (item) {
        item.remove();
        // Renumber remaining vehicles
        document.querySelectorAll('.vehicle-item').forEach((el, idx) => {
            el.querySelector('h4').textContent = `Vehicle ${idx + 1}`;
        });
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    toggleVehiclesSection();
});
</script>