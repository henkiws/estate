/**
 * Profile Form Interactions - FIXED VERSION
 * Handles dynamic form elements for the 10-step profile completion wizard
 */

// ============================================================================
// STEP 1: TOGGLE FUNCTIONS
// ============================================================================

function toggleEmergencyContact() {
    const checkbox = document.getElementById('has_emergency_contact');
    const fields = document.getElementById('emergency-contact-fields');
    if (fields) {
        fields.style.display = checkbox && checkbox.checked ? 'block' : 'none';
    }
}

function toggleGuarantor() {
    const checkbox = document.getElementById('has_guarantor');
    const fields = document.getElementById('guarantor-fields');
    if (fields) {
        fields.style.display = checkbox && checkbox.checked ? 'block' : 'none';
    }
}

// ============================================================================
// STEP 3: INCOME - Add/Remove Income Sources
// ============================================================================

function addIncomeSource() {
    const container = document.getElementById('income-sources-container') || document.getElementById('income-container');
    if (!container) return;
    
    const count = container.querySelectorAll('.income-source-item').length;
    
    const newSource = document.createElement('div');
    newSource.className = 'income-source-item bg-gray-50 p-4 rounded-lg border border-gray-200 mb-4';
    newSource.innerHTML = `
        <div class="flex justify-between items-start mb-3">
            <h4 class="font-medium text-gray-700">Income Source #${count + 1}</h4>
            <button type="button" onclick="removeIncomeSource(this)" class="text-red-600 hover:text-red-700">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Income Source *</label>
                <select name="incomes[${count}][income_source]" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                    <option value="">Select source</option>
                    <option value="full_time_employment">Full-time Employment</option>
                    <option value="part_time_employment">Part-time Employment</option>
                    <option value="casual_employment">Casual Employment</option>
                    <option value="self_employed">Self-employed</option>
                    <option value="government_benefits">Government Benefits</option>
                    <option value="investment_income">Investment Income</option>
                    <option value="other">Other</option>
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Net Weekly Amount (AUD) *</label>
                <input type="number" name="incomes[${count}][net_weekly_amount]" step="0.01" min="0" required 
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent"
                    placeholder="e.g., 1500.00">
            </div>
        </div>
    `;
    
    container.appendChild(newSource);
    updateTotalIncome();
}

function removeIncomeSource(button) {
    const container = document.getElementById('income-sources-container') || document.getElementById('income-container');
    if (!container) return;
    
    const items = container.querySelectorAll('.income-source-item');
    
    if (items.length > 1) {
        button.closest('.income-source-item').remove();
        updateIncomeNumbers();
        updateTotalIncome();
    }
}

function updateIncomeNumbers() {
    const items = document.querySelectorAll('.income-source-item');
    items.forEach((item, index) => {
        const title = item.querySelector('h4');
        if (title) {
            title.textContent = `Income Source #${index + 1}`;
        }
    });
}

function updateTotalIncome() {
    const inputs = document.querySelectorAll('input[name*="net_weekly_amount"]');
    let total = 0;
    
    inputs.forEach(input => {
        const value = parseFloat(input.value) || 0;
        total += value;
    });
    
    const totalElement = document.getElementById('total-income');
    if (totalElement) {
        totalElement.textContent = `$${total.toFixed(2)}`;
    }
}

// ============================================================================
// STEP 4: EMPLOYMENT - Add/Remove Employment History
// ============================================================================

// Note: The Step 4 form uses its own inline JavaScript
// These functions are kept for backward compatibility

function toggleEmploymentSection() {
    const checkbox = document.getElementById('has-employment');
    const section = document.getElementById('employment-section');
    
    if (checkbox && section) {
        if (checkbox.checked) {
            section.classList.remove('hidden');
        } else {
            section.classList.add('hidden');
        }
    }
}

// ============================================================================
// STEP 5: PETS - Add/Remove Pets
// ============================================================================

function togglePetsSection() {
    const checkbox = document.getElementById('has-pets');
    const section = document.getElementById('pets-section');
    
    if (checkbox && section) {
        if (checkbox.checked) {
            section.style.display = 'block';  // Show
        } else {
            section.style.display = 'none';   // Hide
        }
    }
}

function addPet() {
    const container = document.getElementById('pets-list');
    if (!container) return;
    
    const count = container.querySelectorAll('.pet-item').length;
    
    const newPet = document.createElement('div');
    newPet.className = 'pet-item bg-gray-50 p-4 rounded-lg border border-gray-200 mb-4';
    newPet.innerHTML = `
        <div class="flex justify-between items-start mb-3">
            <h4 class="font-medium text-gray-700">Pet #${count + 1}</h4>
            <button type="button" onclick="removePet(this)" class="text-red-600 hover:text-red-700">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Pet Type *</label>
                <select name="pets[${count}][pet_type]" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                    <option value="">Select type</option>
                    <option value="dog">Dog</option>
                    <option value="cat">Cat</option>
                    <option value="bird">Bird</option>
                    <option value="fish">Fish</option>
                    <option value="other">Other</option>
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Breed</label>
                <input type="text" name="pets[${count}][breed]" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Size</label>
                <select name="pets[${count}][size]" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                    <option value="">Select size</option>
                    <option value="small">Small</option>
                    <option value="medium">Medium</option>
                    <option value="large">Large</option>
                </select>
            </div>
            
            <div>
                <label class="flex items-center gap-2 mt-8">
                    <input type="checkbox" name="pets[${count}][desexed]" value="1" 
                        class="rounded border-gray-300 text-teal-600 focus:ring-teal-500">
                    <span class="text-sm text-gray-700">Desexed</span>
                </label>
            </div>
        </div>
    `;
    
    container.appendChild(newPet);
}

function removePet(button) {
    button.closest('.pet-item').remove();
    updatePetNumbers();
}

function updatePetNumbers() {
    const items = document.querySelectorAll('.pet-item');
    items.forEach((item, index) => {
        const title = item.querySelector('h4');
        if (title) {
            title.textContent = `Pet #${index + 1}`;
        }
    });
}

// ============================================================================
// STEP 6: VEHICLES - Add/Remove Vehicles
// ============================================================================

function toggleVehiclesSection() {
    const hasVehicles = document.querySelector('input[name="has_vehicles"]:checked')?.value === '1';
    const vehiclesContainer = document.getElementById('vehicles-container');
    
    if (vehiclesContainer) {
        vehiclesContainer.style.display = hasVehicles ? 'block' : 'none';
    }
}

function addVehicle() {
    const container = document.getElementById('vehicles-list');
    if (!container) return;
    
    const count = container.querySelectorAll('.vehicle-item').length;
    const currentYear = new Date().getFullYear();
    
    const newVehicle = document.createElement('div');
    newVehicle.className = 'vehicle-item bg-gray-50 p-4 rounded-lg border border-gray-200 mb-4';
    newVehicle.innerHTML = `
        <div class="flex justify-between items-start mb-3">
            <h4 class="font-medium text-gray-700">Vehicle #${count + 1}</h4>
            <button type="button" onclick="removeVehicle(this)" class="text-red-600 hover:text-red-700">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Vehicle Type *</label>
                <select name="vehicles[${count}][vehicle_type]" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                    <option value="">Select type</option>
                    <option value="car">Car</option>
                    <option value="motorcycle">Motorcycle</option>
                    <option value="truck">Truck</option>
                    <option value="van">Van</option>
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Year *</label>
                <input type="number" name="vehicles[${count}][year]" min="1900" max="${currentYear + 1}" required 
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Make *</label>
                <input type="text" name="vehicles[${count}][make]" required 
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Model *</label>
                <input type="text" name="vehicles[${count}][model]" required 
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">State *</label>
                <select name="vehicles[${count}][state]" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent">
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
                <label class="block text-sm font-medium text-gray-700 mb-1">Registration Number *</label>
                <input type="text" name="vehicles[${count}][registration_number]" required 
                    oninput="this.value = this.value.toUpperCase()"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent uppercase">
            </div>
        </div>
    `;
    
    container.appendChild(newVehicle);
}

function removeVehicle(button) {
    button.closest('.vehicle-item').remove();
    updateVehicleNumbers();
}

function updateVehicleNumbers() {
    const items = document.querySelectorAll('.vehicle-item');
    items.forEach((item, index) => {
        const title = item.querySelector('h4');
        if (title) {
            title.textContent = `Vehicle #${index + 1}`;
        }
    });
}

// ============================================================================
// STEP 7: ADDRESS HISTORY - Add/Remove Addresses
// ============================================================================

function togglePostalAddress(checkbox, index) {
    const postalDiv = document.getElementById(`postal-address-${index}`);
    if (postalDiv) {
        postalDiv.style.display = checkbox.checked ? 'block' : 'none';
    }
}

function addAddress() {
    const container = document.getElementById('addresses-list');
    if (!container) return;
    
    const count = container.querySelectorAll('.address-item').length;
    
    const newAddress = document.createElement('div');
    newAddress.className = 'address-item bg-gray-50 p-4 rounded-lg border border-gray-200 mb-4';
    newAddress.innerHTML = `
        <div class="flex justify-between items-start mb-3">
            <h4 class="font-medium text-gray-700">Address #${count + 1}</h4>
            <button type="button" onclick="removeAddress(this)" class="text-red-600 hover:text-red-700">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Living Arrangement *</label>
                <select name="addresses[${count}][living_arrangement]" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                    <option value="">Select arrangement</option>
                    <option value="owner">Owner</option>
                    <option value="renting_agent">Renting (via Agent)</option>
                    <option value="renting_privately">Renting (Privately)</option>
                    <option value="with_parents">Living with Parents</option>
                    <option value="sharing">Sharing</option>
                    <option value="other">Other</option>
                </select>
            </div>
            
            <div class="col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Full Address *</label>
                <input type="text" name="addresses[${count}][address]" required 
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent"
                    placeholder="123 Main Street, Sydney NSW 2000">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Years Lived *</label>
                <input type="number" name="addresses[${count}][years_lived]" min="0" max="20" required 
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Months Lived *</label>
                <input type="number" name="addresses[${count}][months_lived]" min="0" max="11" required 
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent">
            </div>
            
            <div class="col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Reason for Leaving</label>
                <textarea name="addresses[${count}][reason_for_leaving]" rows="2" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent"></textarea>
            </div>
        </div>
    `;
    
    container.appendChild(newAddress);
}

function removeAddress(button) {
    const container = document.getElementById('addresses-list');
    if (!container) return;
    
    const items = container.querySelectorAll('.address-item');
    
    // Don't allow removal of the first address (current)
    if (items.length > 1 && !button.closest('.address-item').classList.contains('current-address')) {
        button.closest('.address-item').remove();
        updateAddressNumbers();
    }
}

function updateAddressNumbers() {
    const items = document.querySelectorAll('.address-item');
    items.forEach((item, index) => {
        const title = item.querySelector('h4');
        if (title && !item.classList.contains('current-address')) {
            title.textContent = `Address #${index + 1}`;
        }
    });
}

// ============================================================================
// STEP 8: REFERENCES - Add/Remove References
// ============================================================================

function addReference() {
    const container = document.getElementById('references-list');
    if (!container) return;
    
    const count = container.querySelectorAll('.reference-item').length;
    
    const newReference = document.createElement('div');
    newReference.className = 'reference-item bg-gray-50 p-4 rounded-lg border border-gray-200 mb-4';
    newReference.innerHTML = `
        <div class="flex justify-between items-start mb-3">
            <h4 class="font-medium text-gray-700">Reference #${count + 1}</h4>
            <button type="button" onclick="removeReference(this)" class="text-red-600 hover:text-red-700">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Full Name *</label>
                <input type="text" name="references[${count}][full_name]" required 
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Relationship *</label>
                <input type="text" name="references[${count}][relationship]" required 
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent"
                    placeholder="e.g., Previous Landlord">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Mobile Number *</label>
                <div class="flex gap-2">
                    <select name="references[${count}][mobile_country_code]" required class="w-24 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                        <option value="+61">+61</option>
                        <option value="+1">+1</option>
                        <option value="+44">+44</option>
                        <option value="+64">+64</option>
                    </select>
                    <input type="tel" name="references[${count}][mobile_number]" required 
                        class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent"
                        placeholder="412345678">
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                <input type="email" name="references[${count}][email]" required 
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent">
            </div>
        </div>
    `;
    
    container.appendChild(newReference);
    updateReferenceCount();
}

function removeReference(button) {
    const container = document.getElementById('references-list');
    if (!container) return;
    
    const items = container.querySelectorAll('.reference-item');
    
    // Minimum 2 references required
    if (items.length > 2) {
        button.closest('.reference-item').remove();
        updateReferenceNumbers();
        updateReferenceCount();
    }
}

function updateReferenceNumbers() {
    const items = document.querySelectorAll('.reference-item');
    items.forEach((item, index) => {
        const title = item.querySelector('h4');
        if (title) {
            title.textContent = `Reference #${index + 1}`;
        }
    });
}

function updateReferenceCount() {
    const count = document.querySelectorAll('.reference-item').length;
    const counter = document.getElementById('reference-counter');
    const submitBtn = document.querySelector('button[type="submit"]');
    
    if (counter) {
        counter.textContent = count;
        
        if (count >= 2) {
            counter.parentElement.classList.remove('bg-orange-100', 'text-orange-700');
            counter.parentElement.classList.add('bg-green-100', 'text-green-700');
            if (submitBtn) submitBtn.disabled = false;
        } else {
            counter.parentElement.classList.remove('bg-green-100', 'text-green-700');
            counter.parentElement.classList.add('bg-orange-100', 'text-orange-700');
            if (submitBtn) submitBtn.disabled = true;
        }
    }
}

// ============================================================================
// STEP 9: IDENTIFICATION - Calculate Points
// ============================================================================

function updateIdentificationPoints() {
    const checkboxes = document.querySelectorAll('input[name="identification_documents[]"]:checked');
    let totalPoints = 0;
    
    const pointValues = {
        'birth_certificate': 70,
        'citizenship_certificate': 70,
        'passport': 70,
        'drivers_licence': 40,
        'proof_of_age_card': 40,
        'government_issued_id': 40,
        'medicare_card': 25,
        'credit_card': 25,
        'rates_notice': 25,
        'utility_bill': 25
    };
    
    checkboxes.forEach(checkbox => {
        totalPoints += pointValues[checkbox.value] || 0;
    });
    
    const pointsDisplay = document.getElementById('total-points');
    const submitBtn = document.querySelector('button[type="submit"]');
    
    if (pointsDisplay) {
        pointsDisplay.textContent = totalPoints;
        
        if (totalPoints >= 80) {
            pointsDisplay.parentElement.classList.remove('bg-orange-100', 'text-orange-700');
            pointsDisplay.parentElement.classList.add('bg-green-100', 'text-green-700');
            if (submitBtn) submitBtn.disabled = false;
        } else {
            pointsDisplay.parentElement.classList.remove('bg-green-100', 'text-green-700');
            pointsDisplay.parentElement.classList.add('bg-orange-100', 'text-orange-700');
            if (submitBtn) submitBtn.disabled = true;
        }
    }
}

// ============================================================================
// CHARACTER COUNTERS
// ============================================================================

function updateCharacterCount(textarea, counterId, maxLength) {
    const counter = document.getElementById(counterId);
    if (counter) {
        const remaining = maxLength - textarea.value.length;
        counter.textContent = remaining;
        
        if (remaining < 50) {
            counter.classList.add('text-orange-600');
        } else {
            counter.classList.remove('text-orange-600');
        }
    }
}

// ============================================================================
// INITIALIZE ON PAGE LOAD
// ============================================================================

document.addEventListener('DOMContentLoaded', function() {
    togglePetsSection()
    // Initialize toggle buttons
    if (typeof toggleEmergencyContact === 'function') toggleEmergencyContact();
    if (typeof toggleGuarantor === 'function') toggleGuarantor();
    
    // Initialize reference count
    if (document.getElementById('references-list')) {
        updateReferenceCount();
    }
    
    // Initialize identification points
    const idCheckboxes = document.querySelectorAll('input[name="identification_documents[]"]');
    if (idCheckboxes.length > 0) {
        idCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', updateIdentificationPoints);
        });
        updateIdentificationPoints();
    }
    
    // Initialize total income
    const incomeInputs = document.querySelectorAll('input[name*="net_weekly_amount"]');
    if (incomeInputs.length > 0) {
        incomeInputs.forEach(input => {
            input.addEventListener('input', updateTotalIncome);
        });
        updateTotalIncome();
    }
    
    console.log('✅ Profile form interactions loaded');
});