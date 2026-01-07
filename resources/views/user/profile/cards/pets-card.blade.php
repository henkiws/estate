<!-- Pets Card -->
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-4 hover:shadow-md transition-shadow" id="pets-card">
    
    <!-- Card Header (Always Visible) -->
    <div class="p-6">
        <div class="flex items-start justify-between">
            
            <!-- Left: Icon + Content -->
            <div class="flex items-start gap-4 flex-1">
                <!-- Icon -->
                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-plyform-yellow/20 to-plyform-mint/30 flex items-center justify-center text-plyform-dark flex-shrink-0">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 3.5a1.5 1.5 0 013 0V4a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-.5a1.5 1.5 0 000 3h.5a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-.5a1.5 1.5 0 00-3 0v.5a1 1 0 01-1 1H6a1 1 0 01-1-1v-3a1 1 0 00-1-1h-.5a1.5 1.5 0 010-3H4a1 1 0 001-1V6a1 1 0 011-1h3a1 1 0 001-1v-.5z"/>
                    </svg>
                </div>
                
                <!-- Content -->
                <div class="flex-1">
                    <h3 class="text-lg font-semibold text-plyform-dark">Pets</h3>
                    <p class="text-sm text-gray-600 mt-1" id="pets-summary">
                        @if($user->pets && $user->pets->count() > 0)
                            {{ $user->pets->count() }} {{ Str::plural('pet', $user->pets->count()) }}
                        @else
                            None
                        @endif
                    </p>
                    
                    <!-- Status Badge -->
                    <div class="mt-3">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-plyform-mint text-plyform-dark border border-plyform-mint" id="pets-status">
                            Complete
                        </span>
                    </div>
                </div>
            </div>
            
            <!-- Right: Completion % + Edit Button -->
            <div class="flex items-start gap-4 ml-4">
                <!-- Completion Percentage -->
                <div class="flex items-center justify-center w-14 h-14 rounded-full border-4 border-[#5E17EB] bg-white">
                    <span class="text-xs font-bold text-[#5E17EB]" id="pets-percentage">100%</span>
                </div>
                
                <!-- Edit Button -->
                <button 
                    type="button" 
                    onclick="togglePets()"
                    class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-plyform-purple hover:text-plyform-dark hover:bg-plyform-purple/10 rounded-lg transition"
                    id="pets-edit-btn"
                >
                    <span>Edit</span>
                    <svg class="w-4 h-4 transition-transform" id="pets-chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
            </div>
            
        </div>
    </div>
    
    <!-- Expandable Form Content (Hidden by Default) -->
    <div class="border-t border-gray-200 bg-gray-50 hidden" id="pets-form">
        <form method="POST" action="{{ route('user.profile.update-step') }}" enctype="multipart/form-data" class="p-6 space-y-6">
            @csrf
            <input type="hidden" name="current_step" value="5">
            
            <!-- Has Pets Toggle -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <label class="flex items-center gap-3 cursor-pointer">
                    <input 
                        type="checkbox" 
                        name="has_pets" 
                        id="has-pets"
                        value="1"
                        onchange="togglePetsSection()"
                        {{ old('has_pets', $user->pets->count() > 0) ? 'checked' : '' }}
                        class="w-5 h-5 text-plyform-yellow border-gray-300 rounded focus:ring-2 focus:ring-plyform-yellow/20"
                    >
                    <span class="font-medium text-plyform-dark">I have pets</span>
                </label>
                <p class="text-sm text-gray-600 mt-2 ml-8">Check this if you have any pets that will be living with you</p>
            </div>

            <div id="pets-section" style="display: {{ old('has_pets', $user->pets->count() > 0) ? 'block' : 'none' }};">
                <!-- Pet Information Section -->
                <div class="bg-white rounded-lg p-6 space-y-4">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h4 class="text-base font-semibold text-plyform-dark">Pet Information</h4>
                            <p class="text-sm text-gray-600 mt-1">Provide details about your pets</p>
                        </div>
                        <span class="text-plyform-orange text-sm font-medium">* Required</span>
                    </div>
                    
                    <div id="pets-container">
                        @php
                            $pets = old('pets', $user->pets->toArray() ?: [['type' => '']]);
                        @endphp
                        
                        @foreach($pets as $index => $pet)
                            <div class="pet-item p-4 border-2 border-gray-200 rounded-lg mb-4 hover:border-plyform-orange/30 transition-colors" data-index="{{ $index }}">
                                <div class="flex items-center justify-between mb-4">
                                    <h4 class="font-semibold text-plyform-dark">Pet {{ $index + 1 }}</h4>
                                    @if($index > 0)
                                        <button type="button" onclick="removePetItem({{ $index }})" class="text-plyform-orange hover:text-red-700 text-sm font-medium hover:bg-plyform-orange/10 px-3 py-1 rounded-lg transition-colors">Remove</button>
                                    @endif
                                </div>
                                
                                <div class="grid md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="text-sm font-medium text-plyform-dark mb-2 block">Pet Type <span class="text-plyform-orange">*</span></label>
                                        <select name="pets[{{ $index }}][type]" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-yellow/20 focus:border-plyform-yellow outline-none transition-all">
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
                                        <label class="text-sm font-medium text-plyform-dark mb-2 block">Breed <span class="text-plyform-orange">*</span></label>
                                        <input type="text" name="pets[{{ $index }}][breed]" value="{{ $pet['breed'] ?? '' }}" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-yellow/20 focus:border-plyform-yellow outline-none transition-all" placeholder="e.g., Golden Retriever">
                                    </div>
                                    
                                    <div>
                                        <label class="text-sm font-medium text-plyform-dark mb-2 block">Desexed <span class="text-plyform-orange">*</span></label>
                                        <select name="pets[{{ $index }}][desexed]" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-yellow/20 focus:border-plyform-yellow outline-none transition-all">
                                            <option value="">Select</option>
                                            <option value="1" {{ ($pet['desexed'] ?? '') == '1' ? 'selected' : '' }}>Yes</option>
                                            <option value="0" {{ ($pet['desexed'] ?? '') == '0' ? 'selected' : '' }}>No</option>
                                        </select>
                                    </div>
                                    
                                    <div>
                                        <label class="text-sm font-medium text-plyform-dark mb-2 block">Size <span class="text-plyform-orange">*</span></label>
                                        <select name="pets[{{ $index }}][size]" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-yellow/20 focus:border-plyform-yellow outline-none transition-all">
                                            <option value="">Select size</option>
                                            <option value="small" {{ ($pet['size'] ?? '') == 'small' ? 'selected' : '' }}>Small (under 10kg)</option>
                                            <option value="medium" {{ ($pet['size'] ?? '') == 'medium' ? 'selected' : '' }}>Medium (10-25kg)</option>
                                            <option value="large" {{ ($pet['size'] ?? '') == 'large' ? 'selected' : '' }}>Large (over 25kg)</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="mt-4">
                                    <label class="text-sm font-medium text-plyform-dark mb-2 block">Registration Number (Optional)</label>
                                    <input type="text" name="pets[{{ $index }}][registration_number]" value="{{ $pet['registration_number'] ?? '' }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-yellow/20 focus:border-plyform-yellow outline-none transition-all" placeholder="e.g., 123456">
                                    <p class="mt-1 text-xs text-gray-500">Council registration number if applicable</p>
                                </div>
                                
                                <div class="mt-4">
                                    <label class="text-sm font-medium text-plyform-dark mb-2 block">Pet Registration Document (Optional)</label>
                                    <input type="file" name="pets[{{ $index }}][document]" accept=".pdf,.jpg,.jpeg,.png" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-yellow/20 focus:border-plyform-yellow outline-none transition-all file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-plyform-yellow/20 file:text-plyform-dark hover:file:bg-plyform-yellow/30">
                                    <p class="mt-1 text-xs text-gray-500">Upload registration certificate if available (PDF, JPG, PNG - Max 10MB)</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <button type="button" onclick="addAnotherPet()" class="w-full py-3 border-2 border-dashed border-gray-300 rounded-lg text-gray-600 hover:border-plyform-yellow hover:text-plyform-dark hover:bg-plyform-yellow/5 transition flex items-center justify-center gap-2 font-medium">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Add Another Pet
                    </button>
                    
                </div>
            </div>
            
            <!-- Form Actions -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200">
                <button 
                    type="button" 
                    onclick="togglePets()"
                    class="px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 transition"
                >
                    Cancel
                </button>
                
                <button 
                    type="submit" 
                    class="px-8 py-3 bg-gradient-to-r from-plyform-yellow to-plyform-mint text-plyform-dark font-semibold rounded-lg hover:from-plyform-yellow/90 hover:to-plyform-mint/90 transition shadow-sm flex items-center gap-2"
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
// Initialize pet index
var petIndex = {{ count($pets ?? []) }};

function togglePets() {
    const formDiv = document.getElementById('pets-form');
    const chevron = document.getElementById('pets-chevron');
    const editBtn = document.getElementById('pets-edit-btn');
    
    if (formDiv.classList.contains('hidden')) {
        // Expand
        formDiv.classList.remove('hidden');
        chevron.style.transform = 'rotate(180deg)';
        editBtn.querySelector('span').textContent = 'Close';
        
        // Scroll to card
        setTimeout(() => {
            document.getElementById('pets-card').scrollIntoView({ 
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

// Toggle pets section visibility
function togglePetsSection() {
    const checkbox = document.getElementById('has-pets');
    const section = document.getElementById('pets-section');
    
    if (checkbox && section) {
        if (checkbox.checked) {
            section.style.display = 'block';
        } else {
            section.style.display = 'none';
        }
    }
}

// Add new pet
function addAnotherPet() {
    const container = document.getElementById('pets-container');
    
    if (!container) {
        console.error('Container not found!');
        return;
    }
    
    const newPetHtml = `
        <div class="pet-item p-4 border-2 border-gray-200 rounded-lg mb-4 hover:border-plyform-orange/30 transition-colors" data-index="${petIndex}">
            <div class="flex items-center justify-between mb-4">
                <h4 class="font-semibold text-plyform-dark">Pet ${petIndex + 1}</h4>
                <button type="button" onclick="removePetItem(${petIndex})" class="text-plyform-orange hover:text-red-700 text-sm font-medium hover:bg-plyform-orange/10 px-3 py-1 rounded-lg transition-colors">
                    Remove
                </button>
            </div>
            
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="text-sm font-medium text-plyform-dark mb-2 block">Pet Type <span class="text-plyform-orange">*</span></label>
                    <select name="pets[${petIndex}][type]" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-yellow/20 focus:border-plyform-yellow outline-none transition-all">
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
                    <label class="text-sm font-medium text-plyform-dark mb-2 block">Breed <span class="text-plyform-orange">*</span></label>
                    <input type="text" name="pets[${petIndex}][breed]" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-yellow/20 focus:border-plyform-yellow outline-none transition-all" placeholder="e.g., Golden Retriever">
                </div>
                
                <div>
                    <label class="text-sm font-medium text-plyform-dark mb-2 block">Desexed <span class="text-plyform-orange">*</span></label>
                    <select name="pets[${petIndex}][desexed]" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-yellow/20 focus:border-plyform-yellow outline-none transition-all">
                        <option value="">Select</option>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                </div>
                
                <div>
                    <label class="text-sm font-medium text-plyform-dark mb-2 block">Size <span class="text-plyform-orange">*</span></label>
                    <select name="pets[${petIndex}][size]" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-yellow/20 focus:border-plyform-yellow outline-none transition-all">
                        <option value="">Select size</option>
                        <option value="small">Small (under 10kg)</option>
                        <option value="medium">Medium (10-25kg)</option>
                        <option value="large">Large (over 25kg)</option>
                    </select>
                </div>
            </div>
            
            <div class="mt-4">
                <label class="text-sm font-medium text-plyform-dark mb-2 block">Registration Number (Optional)</label>
                <input type="text" name="pets[${petIndex}][registration_number]" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-yellow/20 focus:border-plyform-yellow outline-none transition-all" placeholder="e.g., 123456">
                <p class="mt-1 text-xs text-gray-500">Council registration number if applicable</p>
            </div>
            
            <div class="mt-4">
                <label class="text-sm font-medium text-plyform-dark mb-2 block">Pet Registration Document (Optional)</label>
                <input type="file" name="pets[${petIndex}][document]" accept=".pdf,.jpg,.jpeg,.png" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-yellow/20 focus:border-plyform-yellow outline-none transition-all file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-plyform-yellow/20 file:text-plyform-dark hover:file:bg-plyform-yellow/30">
                <p class="mt-1 text-xs text-gray-500">Upload registration certificate if available (PDF, JPG, PNG - Max 10MB)</p>
            </div>
        </div>
    `;
    
    container.insertAdjacentHTML('beforeend', newPetHtml);

    const newElement = container.lastElementChild;
    if (typeof reinitializePlugins === 'function') {
        reinitializePlugins(newElement);
    }
    
    petIndex++;
}

// Remove pet
function removePetItem(index) {
    const item = document.querySelector(`.pet-item[data-index="${index}"]`);
    if (item) {
        item.remove();
        // Renumber remaining pets
        document.querySelectorAll('.pet-item').forEach((el, idx) => {
            el.querySelector('h4').textContent = `Pet ${idx + 1}`;
        });
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    togglePetsSection();
});
</script>