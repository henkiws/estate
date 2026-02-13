<div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden section-card mb-4" data-section="household">
    <button type="button" onclick="toggleSection('household')" class="w-full px-6 py-4 flex items-center justify-between hover:bg-gray-50 transition">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-full bg-teal-100 flex items-center justify-center section-status" id="status_household">
                <svg class="w-5 h-5 text-teal-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                </svg>
            </div>
            <div class="text-left">
                <span class="font-semibold text-gray-900">Household</span>
                <p class="text-xs text-gray-500" id="household-summary">1 person (you)</p>
            </div>
        </div>
        <svg class="w-5 h-5 text-gray-400 section-chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
    </button>
    
    <div class="section-content hidden px-6 pb-6">
        
        <!-- Household Section -->
        <div class="bg-gray-50 rounded-lg p-6 space-y-4">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h4 class="text-base font-semibold text-plyform-dark">Household Information</h4>
                    <p class="text-sm text-gray-600 mt-1">Who will be living in this property?</p>
                </div>
                <span class="text-plyform-orange text-sm font-medium">* Required</span>
            </div>
            
            <!-- Number of Occupants -->
            <div>
                <label class="flex items-center gap-2 text-sm font-medium text-plyform-dark mb-2">
                    Number of Occupants <span class="text-plyform-orange">*</span>
                    <span class="text-xs text-gray-500 font-normal">(Including yourself)</span>
                </label>
                <input 
                    type="number" 
                    name="number_of_occupants" 
                    value="{{ old('number_of_occupants', 1) }}"
                    min="1"
                    max="10"
                    required
                    onkeyup="validateOccupantsInput(this)"
                    onchange="validateOccupantsInput(this)"
                    oninput="validateOccupantsInput(this)"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all @error('number_of_occupants') border-red-500 @enderror"
                >
                @error('number_of_occupants')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="text-xs text-gray-500 mt-1">Minimum 1 person (yourself). Maximum 10 people.</p>
            </div>
            
            <!-- Occupants Details Section -->
            <div id="occupants-section" class="hidden">
                <div class="mt-6 p-4 bg-white rounded-lg border-2 border-gray-200">
                    <h5 class="text-sm font-semibold text-plyform-dark mb-4">Occupants Details</h5>
                    <p class="text-sm text-gray-600 mb-4">Provide details about all people who will be living in the property</p>
                    <div id="occupants-container"></div>
                </div>
            </div>
            
        </div>
        
    </div>
</div>  

<script>
// Update occupants summary
    function updateOccupantsSummary(additionalCount) {
        const total = parseInt(additionalCount) + 1;
        const summaries = document.querySelectorAll('#occupants-summary, #household-summary');
        summaries.forEach(summary => {
            summary.textContent = `Summary: ${total} person${total > 1 ? 's' : ''} (1 leaseholder${additionalCount > 0 ? ', ' + additionalCount + ' additional' : ''})`;
        });
    }

    // Household/Occupants functions
    // Validate and update occupants input
    function validateOccupantsInput(input) {
        let value = parseInt(input.value);
        
        // Prevent negative numbers and 0
        if (value < 1 || isNaN(value)) {
            input.value = 1;
            value = 1;
        }
        
        // Prevent more than 10
        if (value > 10) {
            input.value = 10;
            value = 10;
        }
        
        // Update the occupants fields
        updateOccupantsFields(value);
    }

    // Update occupants fields function (keep existing, just update the call)
    function updateOccupantsFields(count) {
        const container = document.getElementById('occupants-container');
        const section = document.getElementById('occupants-section');
        const summary = document.getElementById('household-summary');
        
        // Convert to number and validate
        count = parseInt(count) || 1; // Default to 1 instead of 0
        
        // Ensure minimum of 1
        if (count < 1) {
            count = 1;
        }
        
        // Ensure maximum of 10
        if (count > 10) {
            count = 10;
        }
        
        // Update summary
        if (summary) {
            if (count === 1) {
                summary.textContent = '1 person (you)';
            } else {
                summary.textContent = `${count} people (including you)`;
            }
        }
        
        // Always show section (since minimum is 1)
        section.classList.remove('hidden');
        
        // Clear existing
        container.innerHTML = '';
        
        // Create fields for ALL occupants (including yourself as Occupant 1)
        for (let i = 0; i < count; i++) {
            const occupantNumber = i + 1;
            const isPrimary = i === 0;
            
            const occupantFields = `
                <div class="p-4 border-2 ${isPrimary ? 'border-plyform-mint bg-plyform-mint/10' : 'border-gray-200 bg-white'} rounded-lg mb-4">
                    <div class="flex items-center gap-2 mb-3">
                        <h4 class="font-semibold text-plyform-dark">
                            ${isPrimary ? '👤 Primary Applicant (You)' : `Occupant ${occupantNumber}`}
                        </h4>
                        ${isPrimary ? '<span class="text-xs bg-plyform-green text-plyform-dark px-2 py-1 rounded-full font-semibold">Primary</span>' : ''}
                    </div>
                    
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label class="text-sm font-medium text-plyform-dark mb-2 block">
                                First Name <span class="text-plyform-orange">*</span>
                            </label>
                            <input 
                                type="text" 
                                name="occupants_details[${i}][first_name]" 
                                value="${getOldValue('occupants_details.' + i + '.first_name', isPrimary ? '{{ auth()->user()->profile->first_name ?? "" }}' : '')}"
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all"
                                placeholder="${isPrimary ? 'Your first name' : 'First name'}"
                            >
                        </div>
                        
                        <div>
                            <label class="text-sm font-medium text-plyform-dark mb-2 block">
                                Last Name <span class="text-plyform-orange">*</span>
                            </label>
                            <input 
                                type="text" 
                                name="occupants_details[${i}][last_name]" 
                                value="${getOldValue('occupants_details.' + i + '.last_name', isPrimary ? '{{ auth()->user()->profile->last_name ?? "" }}' : '')}"
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all"
                                placeholder="${isPrimary ? 'Your last name' : 'Last name'}"
                            >
                        </div>
                        
                        <div>
                            <label class="text-sm font-medium text-plyform-dark mb-2 block">
                                Relationship <span class="text-plyform-orange">*</span>
                            </label>
                            <input 
                                type="text" 
                                name="occupants_details[${i}][relationship]" 
                                value="${isPrimary ? 'Primary Applicant' : getOldValue('occupants_details.' + i + '.relationship')}"
                                ${isPrimary ? 'readonly' : 'required'}
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all ${isPrimary ? 'bg-gray-100' : ''}"
                                placeholder="${isPrimary ? 'Primary Applicant' : 'e.g., Partner, Child, Roommate'}"
                            >
                        </div>
                        
                        <div>
                            <label class="text-sm font-medium text-plyform-dark mb-2 block">
                                Age ${isPrimary ? '<span class="text-plyform-orange">*</span>' : '(Optional)'}
                            </label>
                            <input 
                                type="number" 
                                name="occupants_details[${i}][age]" 
                                value="${getOldValue('occupants_details.' + i + '.age')}"
                                min="${isPrimary ? '18' : '0'}"
                                max="120"
                                ${isPrimary ? 'required' : ''}
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all"
                                placeholder="${isPrimary ? 'Your age (must be 18+)' : 'Age'}"
                            >
                            ${isPrimary ? '<p class="text-xs text-gray-500 mt-1">Primary applicant must be 18 or older</p>' : ''}
                        </div>
                        
                        ${isPrimary ? `
                        <div class="md:col-span-2">
                            <label class="text-sm font-medium text-plyform-dark mb-2 block">
                                Email <span class="text-plyform-orange">*</span>
                            </label>
                            <input 
                                type="email" 
                                name="occupants_details[${i}][email]" 
                                value="{{ auth()->user()->email }}"
                                readonly
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-100"
                            >
                            <p class="text-xs text-gray-500 mt-1">From your account</p>
                        </div>
                        ` : ''}
                    </div>
                </div>
            `;
            
            container.insertAdjacentHTML('beforeend', occupantFields);
        }
    }

    // Helper function to get old values (for form repopulation after validation errors)
    function getOldValue(key, defaultValue = '') {
        // This is a simple implementation - you may need to enhance it based on your needs
        return defaultValue;
    }

    // Initialize occupants fields on page load
    document.addEventListener('DOMContentLoaded', function() {
        const occupantsInput = document.querySelector('input[name="number_of_occupants"]');
        if (occupantsInput && occupantsInput.value) {
            updateOccupantsFields(occupantsInput.value);
        }
    });
</script>