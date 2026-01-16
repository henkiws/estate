<!-- Pets Card -->
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-4 hover:shadow-md transition-shadow" id="pets-card">
    
    <!-- Card Header (Always Visible) -->
    <div class="p-6">
        <div class="flex items-start justify-between">
            
            <!-- Left: Icon + Content -->
            <div class="flex items-start gap-4 flex-1">
                <!-- Icon -->
                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-plyform-green/20 to-plyform-mint/30 flex items-center justify-center text-plyform-dark flex-shrink-0">
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
                        class="w-5 h-5 text-plyform-green border-gray-300 rounded focus:ring-2 focus:ring-plyform-green/20"
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
                                        <select name="pets[{{ $index }}][type]" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all">
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
                                        <input type="text" name="pets[{{ $index }}][breed]" value="{{ $pet['breed'] ?? '' }}" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all" placeholder="e.g., Golden Retriever">
                                    </div>
                                    
                                    <div>
                                        <label class="text-sm font-medium text-plyform-dark mb-2 block">Desexed <span class="text-plyform-orange">*</span></label>
                                        <select name="pets[{{ $index }}][desexed]" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all">
                                            <option value="">Select</option>
                                            <option value="1" {{ ($pet['desexed'] ?? '') == '1' ? 'selected' : '' }}>Yes</option>
                                            <option value="0" {{ ($pet['desexed'] ?? '') == '0' ? 'selected' : '' }}>No</option>
                                        </select>
                                    </div>
                                    
                                    <div>
                                        <label class="text-sm font-medium text-plyform-dark mb-2 block">Size <span class="text-plyform-orange">*</span></label>
                                        <select name="pets[{{ $index }}][size]" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all">
                                            <option value="">Select size</option>
                                            <option value="small" {{ ($pet['size'] ?? '') == 'small' ? 'selected' : '' }}>Small (under 10kg)</option>
                                            <option value="medium" {{ ($pet['size'] ?? '') == 'medium' ? 'selected' : '' }}>Medium (10-25kg)</option>
                                            <option value="large" {{ ($pet['size'] ?? '') == 'large' ? 'selected' : '' }}>Large (over 25kg)</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="mt-4">
                                    <label class="text-sm font-medium text-plyform-dark mb-2 block">Registration Number (Optional)</label>
                                    <input type="text" name="pets[{{ $index }}][registration_number]" value="{{ $pet['registration_number'] ?? '' }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all" placeholder="e.g., 123456">
                                    <p class="mt-1 text-xs text-gray-500">Council registration number if applicable</p>
                                </div>

                                <!-- Pet Photo - WITH EXISTING PHOTO DISPLAY -->
                                <div class="mt-4">
                                    <label class="text-sm font-medium text-plyform-dark mb-2 block">
                                        Pet Photo <span class="text-plyform-orange">*</span>
                                    </label>
                                    <div class="space-y-3">
                                        <!-- File Input -->
                                        <input 
                                            type="file" 
                                            name="pets[{{ $index }}][photo]" 
                                            id="pet_photo_{{ $index }}"
                                            accept="image/jpeg,image/png,image/jpg,image/gif"
                                            {{ empty($pet['photo_path']) ? 'required' : '' }}
                                            onchange="previewPetPhoto({{ $index }})"
                                            class="hidden"
                                        >
                                        
                                        <!-- Upload Button/Preview Container -->
                                        <div id="pet_photo_preview_{{ $index }}" class="space-y-2">
                                            @if(!empty($pet['photo_path']) && Storage::disk('public')->exists($pet['photo_path']))
                                                <!-- EXISTING PHOTO PREVIEW -->
                                                <div class="relative bg-gray-50 border-2 border-gray-200 rounded-lg p-3">
                                                    <div class="flex items-center gap-3">
                                                        <!-- Thumbnail Preview -->
                                                        <img src="{{ Storage::url($pet['photo_path']) }}" alt="Pet photo" class="w-16 h-16 object-cover rounded-lg border-2 border-gray-300">
                                                        
                                                        <!-- File Info -->
                                                        <div class="flex-1 min-w-0">
                                                            <p class="text-sm font-medium text-gray-900 truncate">{{ basename($pet['photo_path']) }}</p>
                                                            <p class="text-xs text-gray-500">Uploaded photo</p>
                                                        </div>
                                                        
                                                        <!-- Remove Button -->
                                                        <button 
                                                            type="button" 
                                                            onclick="removePetPhoto({{ $index }})"
                                                            class="flex-shrink-0 text-red-600 hover:text-red-800 transition p-2 hover:bg-red-50 rounded-lg"
                                                            title="Remove photo"
                                                        >
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                            </svg>
                                                        </button>
                                                        
                                                        <!-- Re-upload Button -->
                                                        <button 
                                                            type="button" 
                                                            onclick="document.getElementById('pet_photo_{{ $index }}').click()"
                                                            class="flex-shrink-0 text-gray-600 hover:text-gray-800 transition p-2 hover:bg-gray-100 rounded-lg"
                                                            title="Change photo"
                                                        >
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </div>
                                                <!-- Hidden input to track existing photo -->
                                                <input type="hidden" name="pets[{{ $index }}][existing_photo]" value="{{ $pet['photo_path'] }}">
                                            @else
                                                <!-- NO PHOTO YET - UPLOAD BUTTON -->
                                                <button 
                                                    type="button" 
                                                    onclick="document.getElementById('pet_photo_{{ $index }}').click()"
                                                    class="w-full px-4 py-3 border-2 border-dashed border-gray-300 rounded-lg hover:border-plyform-orange transition-colors text-center cursor-pointer"
                                                >
                                                    <svg class="w-8 h-8 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                    </svg>
                                                    <span class="text-sm text-gray-600">Click to upload pet photo</span>
                                                    <span class="text-xs text-gray-500 block mt-1">JPEG, PNG, GIF (Max 10MB)</span>
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                    <p class="mt-1 text-xs text-gray-500">Please upload at least 1 photo (JPEG, PNG, GIF - Max 10MB each)</p>
                                </div>
                                
                                <div class="mt-4">
                                    <label class="text-sm font-medium text-plyform-dark mb-2 block">Pet Registration Document (Optional)</label>
                                    
                                    @if(!empty($pet['document_path']) && Storage::disk('public')->exists($pet['document_path']))
                                        <!-- Show existing document -->
                                        <div class="mb-2 p-3 bg-green-50 border border-green-200 rounded-lg">
                                            <div class="flex items-center gap-2">
                                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                                <span class="text-sm text-green-800 flex-1">Document uploaded: {{ basename($pet['document_path']) }}</span>
                                                <a href="{{ Storage::url($pet['document_path']) }}" target="_blank" class="text-green-600 hover:text-green-800 text-sm font-medium">View</a>
                                            </div>
                                        </div>
                                    @endif
                                    
                                    <input type="file" name="pets[{{ $index }}][document]" accept=".pdf,.jpg,.jpeg,.png" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-plyform-green/20 file:text-plyform-dark hover:file:bg-plyform-green/30">
                                    <p class="mt-1 text-xs text-gray-500">
                                        @if(!empty($pet['document_path']))
                                            Upload a new document to replace the existing one
                                        @else
                                            Upload registration certificate if available (PDF, JPG, PNG - Max 10MB)
                                        @endif
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <button type="button" onclick="addAnotherPet()" class="w-full py-3 border-2 border-dashed border-gray-300 rounded-lg text-gray-600 hover:border-plyform-green hover:text-plyform-dark hover:bg-plyform-green/5 transition flex items-center justify-center gap-2 font-medium">
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
                    class="px-8 py-3 bg-gradient-to-r from-plyform-green to-plyform-green text-white font-semibold rounded-lg hover:from-plyform-green/90 hover:to-plyform-green/90 transition shadow-sm flex items-center gap-2"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Save And Next
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
                    <select name="pets[${petIndex}][type]" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all">
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
                    <input type="text" name="pets[${petIndex}][breed]" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all" placeholder="e.g., Golden Retriever">
                </div>
                
                <div>
                    <label class="text-sm font-medium text-plyform-dark mb-2 block">Desexed <span class="text-plyform-orange">*</span></label>
                    <select name="pets[${petIndex}][desexed]" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all">
                        <option value="">Select</option>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                </div>
                
                <div>
                    <label class="text-sm font-medium text-plyform-dark mb-2 block">Size <span class="text-plyform-orange">*</span></label>
                    <select name="pets[${petIndex}][size]" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all">
                        <option value="">Select size</option>
                        <option value="small">Small (under 10kg)</option>
                        <option value="medium">Medium (10-25kg)</option>
                        <option value="large">Large (over 25kg)</option>
                    </select>
                </div>
            </div>
            
            <div class="mt-4">
                <label class="text-sm font-medium text-plyform-dark mb-2 block">Registration Number (Optional)</label>
                <input type="text" name="pets[${petIndex}][registration_number]" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all" placeholder="e.g., 123456">
                <p class="mt-1 text-xs text-gray-500">Council registration number if applicable</p>
            </div>

            <!-- Pet Photo - NEW REQUIRED FIELD -->
            <div class="mt-4">
                <label class="text-sm font-medium text-plyform-dark mb-2 block">
                    Pet Photo <span class="text-plyform-orange">*</span>
                </label>
                <div class="space-y-3">
                    <input 
                        type="file" 
                        name="pets[${petIndex}][photo]" 
                        id="pet_photo_${petIndex}"
                        accept="image/jpeg,image/png,image/jpg,image/gif"
                        required
                        onchange="previewPetPhoto(${petIndex})"
                        class="hidden"
                    >
                    
                    <div id="pet_photo_preview_${petIndex}" class="space-y-2">
                        <button 
                            type="button" 
                            onclick="document.getElementById('pet_photo_${petIndex}').click()"
                            class="w-full px-4 py-3 border-2 border-dashed border-gray-300 rounded-lg hover:border-plyform-orange transition-colors text-center cursor-pointer"
                        >
                            <svg class="w-8 h-8 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span class="text-sm text-gray-600">Click to upload pet photo</span>
                            <span class="text-xs text-gray-500 block mt-1">JPEG, PNG, GIF (Max 10MB)</span>
                        </button>
                    </div>
                </div>
                <p class="mt-1 text-xs text-gray-500">Please upload at least 1 photo (JPEG, PNG, GIF - Max 10MB each)</p>
            </div>
            
            <div class="mt-4">
                <label class="text-sm font-medium text-plyform-dark mb-2 block">Pet Registration Document (Optional)</label>
                <input type="file" name="pets[${petIndex}][document]" accept=".pdf,.jpg,.jpeg,.png" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-plyform-green/20 file:text-plyform-dark hover:file:bg-plyform-green/30">
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

// Preview pet photo with multiple image display like in the screenshot
function previewPetPhoto(index) {
    const input = document.getElementById(`pet_photo_${index}`);
    const previewContainer = document.getElementById(`pet_photo_preview_${index}`);
    
    if (!input || !input.files || input.files.length === 0) {
        return;
    }
    
    const file = input.files[0];
    
    // Validate file size (10MB)
    if (file.size > 10 * 1024 * 1024) {
        alert('File size must be less than 10MB');
        input.value = '';
        return;
    }
    
    // Validate file type
    if (!file.type.match('image.*')) {
        alert('Please select an image file (JPEG, PNG, GIF)');
        input.value = '';
        return;
    }
    
    const reader = new FileReader();
    
    reader.onload = function(e) {
        previewContainer.innerHTML = `
            <div class="relative bg-gray-50 border-2 border-gray-200 rounded-lg p-3">
                <div class="flex items-center gap-3">
                    <!-- Thumbnail Preview -->
                    <img src="${e.target.result}" alt="Pet photo" class="w-16 h-16 object-cover rounded-lg border-2 border-gray-300">
                    
                    <!-- File Info -->
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate">${file.name}</p>
                        <p class="text-xs text-gray-500">${(file.size / 1024).toFixed(2)} KB</p>
                    </div>
                    
                    <!-- Remove Button -->
                    <button 
                        type="button" 
                        onclick="removePetPhoto(${index})"
                        class="flex-shrink-0 text-red-600 hover:text-red-800 transition p-2 hover:bg-red-50 rounded-lg"
                        title="Remove photo"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                    
                    <!-- Re-upload Button -->
                    <button 
                        type="button" 
                        onclick="document.getElementById('pet_photo_${index}').click()"
                        class="flex-shrink-0 text-gray-600 hover:text-gray-800 transition p-2 hover:bg-gray-100 rounded-lg"
                        title="Change photo"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                    </button>
                </div>
            </div>
        `;
    };
    
    reader.readAsDataURL(file);
}

// Remove pet photo
function removePetPhoto(index) {
    const input = document.getElementById(`pet_photo_${index}`);
    const previewContainer = document.getElementById(`pet_photo_preview_${index}`);
    
    if (input) {
        input.value = '';
    }
    
    if (previewContainer) {
        previewContainer.innerHTML = `
            <button 
                type="button" 
                onclick="document.getElementById('pet_photo_${index}').click()"
                class="w-full px-4 py-3 border-2 border-dashed border-gray-300 rounded-lg hover:border-plyform-orange transition-colors text-center cursor-pointer"
            >
                <svg class="w-8 h-8 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <span class="text-sm text-gray-600">Click to upload pet photo</span>
                <span class="text-xs text-gray-500 block mt-1">JPEG, PNG, GIF (Max 10MB)</span>
            </button>
        `;
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    togglePetsSection();
});
</script>