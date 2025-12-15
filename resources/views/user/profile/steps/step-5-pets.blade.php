@php
    $currentStep = $step ?? 5;
@endphp

<!-- Has Pets Toggle -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
    <label class="flex items-center gap-3 cursor-pointer">
        <input 
            type="checkbox" 
            name="has_pets" 
            id="has-pets"
            value="1"
            onchange="togglePetsSection()"
            {{ old('has_pets', $user->pets->count() > 0) ? 'checked' : '' }}
            class="w-5 h-5 text-teal-600 border-gray-300 rounded focus:ring-2 focus:ring-teal-500"
        >
        <span class="font-medium text-gray-900">I have pets</span>
    </label>
    <p class="text-sm text-gray-600 mt-2 ml-8">Check this if you have any pets that will be living with you</p>
</div>

<div id="pets-section" style="display: {{ old('has_pets', $user->pets->count() > 0) ? 'block' : 'none' }};">
    <x-form-section-card 
        title="Pet Information" 
        description="Provide details about your pets"
        required>
        
        <div id="pets-container">
            @php
                $pets = old('pets', $user->pets->toArray() ?: [['type' => '']]);
            @endphp
            
            @foreach($pets as $index => $pet)
                <div class="pet-item p-4 border-2 border-gray-200 rounded-lg mb-4" data-index="{{ $index }}">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="font-semibold text-gray-900">Pet {{ $index + 1 }}</h4>
                        @if($index > 0)
                            <button type="button" onclick="removePetItem({{ $index }})" class="text-red-600 hover:text-red-700 text-sm font-medium">Remove</button>
                        @endif
                    </div>
                    
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label class="text-sm font-medium text-gray-700 mb-2 block">Pet Type <span class="text-red-500">*</span></label>
                            <select name="pets[{{ $index }}][type]" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">
                                <option value="">Select type</option>
                                <option value="dog" {{ ($pet['type'] ?? '') == 'dog' ? 'selected' : '' }}>Dog</option>
                                <option value="cat" {{ ($pet['type'] ?? '') == 'cat' ? 'selected' : '' }}>Cat</option>
                                <option value="bird" {{ ($pet['type'] ?? '') == 'bird' ? 'selected' : '' }}>Bird</option>
                                <option value="fish" {{ ($pet['type'] ?? '') == 'fish' ? 'selected' : '' }}>Fish</option>
                                <option value="rabbit" {{ ($pet['type'] ?? '') == 'rabbit' ? 'selected' : '' }}>Rabbit</option>
                                <option value="other" {{ ($pet['type'] ?? '') == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>
                        
                        <div>
                            <label class="text-sm font-medium text-gray-700 mb-2 block">Breed <span class="text-red-500">*</span></label>
                            <input type="text" name="pets[{{ $index }}][breed]" value="{{ $pet['breed'] ?? '' }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500" placeholder="e.g., Golden Retriever">
                        </div>
                        
                        <div>
                            <label class="text-sm font-medium text-gray-700 mb-2 block">Desexed <span class="text-red-500">*</span></label>
                            <select name="pets[{{ $index }}][desexed]" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">
                                <option value="">Select</option>
                                <option value="1" {{ ($pet['desexed'] ?? '') == '1' ? 'selected' : '' }}>Yes</option>
                                <option value="0" {{ ($pet['desexed'] ?? '') == '0' ? 'selected' : '' }}>No</option>
                            </select>
                        </div>
                        
                        <div>
                            <label class="text-sm font-medium text-gray-700 mb-2 block">Size <span class="text-red-500">*</span></label>
                            <select name="pets[{{ $index }}][size]" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">
                                <option value="">Select size</option>
                                <option value="small" {{ ($pet['size'] ?? '') == 'small' ? 'selected' : '' }}>Small (under 10kg)</option>
                                <option value="medium" {{ ($pet['size'] ?? '') == 'medium' ? 'selected' : '' }}>Medium (10-25kg)</option>
                                <option value="large" {{ ($pet['size'] ?? '') == 'large' ? 'selected' : '' }}>Large (over 25kg)</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <label class="text-sm font-medium text-gray-700 mb-2 block">Registration Number (Optional)</label>
                        <input type="text" name="pets[{{ $index }}][registration_number]" value="{{ $pet['registration_number'] ?? '' }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500" placeholder="e.g., 123456">
                        <p class="mt-1 text-xs text-gray-500">Council registration number if applicable</p>
                    </div>
                    
                    <div class="mt-4">
                        <label class="text-sm font-medium text-gray-700 mb-2 block">Pet Registration Document (Optional)</label>
                        <input type="file" name="pets[{{ $index }}][document]" accept=".pdf,.jpg,.jpeg,.png" class="w-full px-4 py-3 border border-gray-300 rounded-lg file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100">
                        <p class="mt-1 text-xs text-gray-500">Upload registration certificate if available (PDF, JPG, PNG - Max 10MB)</p>
                    </div>
                </div>
            @endforeach
        </div>
        
        <button type="button" onclick="addAnotherPet()" class="w-full py-3 border-2 border-dashed border-gray-300 rounded-lg text-gray-600 hover:border-teal-500 hover:text-teal-600 transition flex items-center justify-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            Add Another Pet
        </button>
        
    </x-form-section-card>
</div>

@php
    $previousStep = max(1, $currentStep - 1);
@endphp

<!-- Navigation Buttons -->
<div class="flex items-center justify-between mt-6">
    @if($currentStep > 1)
        <!-- Back Button (Steps 2-10) -->
        <a href="{{ route('user.profile.complete') }}?step={{ $previousStep }}" 
           class="px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 transition flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Back
        </a>
    @else
        <!-- Cancel Button (Step 1 only) -->
        <a href="{{ route('user.dashboard') }}" 
           class="px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 transition flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Cancel
        </a>
    @endif
    
    <div class="flex items-center gap-3">
        <button type="submit" class="px-8 py-3 bg-teal-600 text-white font-semibold rounded-lg hover:bg-teal-700 transition shadow-sm flex items-center gap-2">
            Save & Continue
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </button>
    </div>
</div>

<script>
// Initialize pet index - MUST be a number, not array count
var petIndex = {{ count($pets) }};

console.log('🐾 Pet form initialized with petIndex:', petIndex);

// Toggle pets section visibility
function togglePetsSection() {
    const checkbox = document.getElementById('has-pets');
    const section = document.getElementById('pets-section');
    
    console.log('Toggle called. Checkbox:', checkbox, 'Checked:', checkbox?.checked);
    
    if (checkbox && section) {
        if (checkbox.checked) {
            section.style.display = 'block';
            console.log('✅ Showing pets section');
        } else {
            section.style.display = 'none';
            console.log('❌ Hiding pets section');
        }
    }
}

// Add new pet
function addAnotherPet() {
    console.log('🐾 Adding new pet. Current petIndex:', petIndex);
    
    const container = document.getElementById('pets-container');
    
    if (!container) {
        console.error('❌ Container not found!');
        return;
    }
    
    console.log('✅ Container found, creating new pet form...');
    
    const newPetHtml = `
        <div class="pet-item p-4 border-2 border-gray-200 rounded-lg mb-4" data-index="${petIndex}">
            <div class="flex items-center justify-between mb-4">
                <h4 class="font-semibold text-gray-900">Pet ${petIndex + 1}</h4>
                <button type="button" onclick="removePetItem(${petIndex})" class="text-red-600 hover:text-red-700 text-sm font-medium">
                    Remove
                </button>
            </div>
            
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="text-sm font-medium text-gray-700 mb-2 block">Pet Type <span class="text-red-500">*</span></label>
                    <select name="pets[${petIndex}][type]" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">
                        <option value="">Select type</option>
                        <option value="dog">Dog</option>
                        <option value="cat">Cat</option>
                        <option value="bird">Bird</option>
                        <option value="fish">Fish</option>
                        <option value="rabbit">Rabbit</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                
                <div>
                    <label class="text-sm font-medium text-gray-700 mb-2 block">Breed <span class="text-red-500">*</span></label>
                    <input type="text" name="pets[${petIndex}][breed]" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500" placeholder="e.g., Golden Retriever">
                </div>
                
                <div>
                    <label class="text-sm font-medium text-gray-700 mb-2 block">Desexed <span class="text-red-500">*</span></label>
                    <select name="pets[${petIndex}][desexed]" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">
                        <option value="">Select</option>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                </div>
                
                <div>
                    <label class="text-sm font-medium text-gray-700 mb-2 block">Size <span class="text-red-500">*</span></label>
                    <select name="pets[${petIndex}][size]" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">
                        <option value="">Select size</option>
                        <option value="small">Small (under 10kg)</option>
                        <option value="medium">Medium (10-25kg)</option>
                        <option value="large">Large (over 25kg)</option>
                    </select>
                </div>
            </div>
            
            <div class="mt-4">
                <label class="text-sm font-medium text-gray-700 mb-2 block">Registration Number (Optional)</label>
                <input type="text" name="pets[${petIndex}][registration_number]" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500" placeholder="e.g., 123456">
                <p class="mt-1 text-xs text-gray-500">Council registration number if applicable</p>
            </div>
            
            <div class="mt-4">
                <label class="text-sm font-medium text-gray-700 mb-2 block">Pet Registration Document (Optional)</label>
                <input type="file" name="pets[${petIndex}][document]" accept=".pdf,.jpg,.jpeg,.png" class="w-full px-4 py-3 border border-gray-300 rounded-lg file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100">
                <p class="mt-1 text-xs text-gray-500">Upload registration certificate if available (PDF, JPG, PNG - Max 10MB)</p>
            </div>
        </div>
    `;
    
    container.insertAdjacentHTML('beforeend', newPetHtml);
    
    console.log('✅ New pet form added with index:', petIndex);
    
    petIndex++;
    
    console.log('📊 Updated petIndex to:', petIndex);
}

// Remove pet
function removePetItem(index) {
    console.log('🗑️ Removing pet with index:', index);
    
    const item = document.querySelector(`.pet-item[data-index="${index}"]`);
    
    if (item) {
        item.remove();
        console.log('✅ Pet removed');
    } else {
        console.error('❌ Pet item not found with index:', index);
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    console.log('📄 DOM loaded, initializing pets section...');
    togglePetsSection();
});

console.log('🎯 Pet form script loaded successfully!');
</script>