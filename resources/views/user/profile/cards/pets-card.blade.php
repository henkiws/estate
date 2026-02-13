<!-- Pets Card -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden section-card mb-4" id="pets-card">
    
    <!-- Card Header - Collapsible Button (Always Visible) -->
    <button type="button" onclick="togglePets()" class="w-full px-6 py-4 flex items-center justify-between hover:bg-gray-50 transition">
        <div class="flex items-center gap-3">
            <!-- Status Icon -->
            <div class="w-8 h-8 rounded-full bg-teal-100 flex items-center justify-center section-status" id="status_pets">
                <svg class="w-5 h-5 text-teal-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                </svg>
            </div>
            
            <!-- Title and Summary -->
            <div class="text-left">
                <span class="font-semibold text-gray-900">Pets</span>
                <span class="text-xs bg-gray-200 text-gray-600 px-2 py-0.5 rounded-full font-medium">Optional</span>
                @if($user->pets && $user->pets->count() > 0)
                    <span class="text-xs bg-green-200 text-green-600 px-2 py-0.5 rounded-full font-medium">Completed</span>
                @endif
                <p class="text-xs text-gray-500" id="pets-summary">
                    @if($user->pets && $user->pets->count() > 0)
                        {{ $user->pets->count() }} {{ Str::plural('pet', $user->pets->count()) }} 
                    @else
                        None
                    @endif
                </p>
            </div>
        </div>
        
        <!-- Right Side: Percentage + Chevron -->
        <div class="flex items-center gap-4">
            <!-- Completion Percentage Circle -->
            <div class="flex items-center justify-center w-12 h-12 rounded-full border-3 border-teal-600 bg-teal-50" id="pets-percentage-circle">
                <span class="text-xs font-bold text-teal-600" id="pets-percentage">100%</span>
            </div>
            
            <!-- Chevron Icon -->
            <svg class="w-5 h-5 text-gray-400 section-chevron transition-transform" id="pets-chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </div>
    </button>
    
    <!-- Expandable Form Content (Hidden by Default) -->
    <div class="section-content hidden px-6 pb-6" id="pets-form">
        <form method="POST" action="{{ route('user.profile.update-step') }}" enctype="multipart/form-data" class="space-y-6">
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

                                <!-- Pet Photos - MULTIPLE UPLOAD -->
                                <div class="mt-4">
                                    <label class="text-sm font-medium text-plyform-dark mb-2 block">
                                        Pet Photos <span class="text-plyform-orange">*</span>
                                    </label>
                                    <div class="space-y-3">
                                        <!-- Hidden File Input (Multiple) -->
                                        <input 
                                            type="file" 
                                            name="pets[{{ $index }}][photos][]" 
                                            id="pet_photos_{{ $index }}"
                                            accept="image/jpeg,image/png,image/jpg,image/gif"
                                            multiple
                                            {{ empty($pet['photo_paths']) ? 'required' : '' }}
                                            onchange="previewPetPhotos({{ $index }})"
                                            class="hidden"
                                        >
                                        
                                        <!-- Preview Container -->
                                        <div id="pet_photos_preview_{{ $index }}" class="space-y-2">
                                            @if(!empty($pet['photo_paths']))
                                                <!-- EXISTING PHOTOS GRID -->
                                                @foreach($pet['photo_paths'] as $photoIndex => $photoPath)
                                                    @if(Storage::disk('public')->exists($photoPath))
                                                        <div class="relative bg-gray-50 border-2 border-gray-200 rounded-lg p-3 existing-photo" data-photo-index="{{ $photoIndex }}">
                                                            <div class="flex items-center gap-3">
                                                                <!-- Thumbnail Preview -->
                                                                <img src="{{ Storage::url($photoPath) }}" alt="Pet photo {{ $photoIndex + 1 }}" class="w-16 h-16 object-cover rounded-lg border-2 border-gray-300">
                                                                
                                                                <!-- File Info -->
                                                                <div class="flex-1 min-w-0">
                                                                    <p class="text-sm font-medium text-gray-900 truncate">{{ basename($photoPath) }}</p>
                                                                    <p class="text-xs text-gray-500">Uploaded photo {{ $photoIndex + 1 }}</p>
                                                                </div>

                                                                <!-- View Button -->
                                                                <a 
                                                                    href="{{ Storage::url($photoPath) }}" 
                                                                    target="_blank"
                                                                    class="flex-shrink-0 text-blue-600 hover:text-blue-800 transition p-2 hover:bg-blue-50 rounded-lg"
                                                                    title="View document"
                                                                >
                                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                                    </svg>
                                                                </a>
                                                                
                                                                <!-- Remove Button -->
                                                                <button 
                                                                    type="button" 
                                                                    onclick="removeExistingPetPhoto({{ $index }}, {{ $photoIndex }})"
                                                                    class="flex-shrink-0 text-red-600 hover:text-red-800 transition p-2 hover:bg-red-50 rounded-lg"
                                                                    title="Remove photo"
                                                                >
                                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                                    </svg>
                                                                </button>
                                                            </div>
                                                            <!-- Hidden input to track existing photo -->
                                                            <input type="hidden" name="pets[{{ $index }}][existing_photos][]" value="{{ $photoPath }}">
                                                        </div>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </div>
                                        
                                        <!-- Upload Button -->
                                        <button 
                                            type="button" 
                                            onclick="document.getElementById('pet_photos_{{ $index }}').click()"
                                            class="w-full px-4 py-3 border-2 border-dashed border-gray-300 rounded-lg hover:border-plyform-orange transition-colors text-center cursor-pointer"
                                        >
                                            <svg class="w-8 h-8 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                            <span class="text-sm text-gray-600">Click to upload pet photos</span>
                                            <span class="text-xs text-gray-500 block mt-1">JPEG, PNG, GIF (Max 10MB each) - Select multiple files</span>
                                        </button>
                                    </div>
                                    <p class="mt-1 text-xs text-gray-500">Upload at least 1 photo. You can select multiple photos at once.</p>
                                </div>
                                
                                <!-- Pet Registration Documents - MULTIPLE UPLOAD (MATCHING UI) -->
                                <div class="mt-4">
                                    <label class="text-sm font-medium text-plyform-dark mb-2 block">
                                        Pet Registration Documents (Optional)
                                    </label>
                                    <div class="space-y-3">
                                        <!-- Hidden File Input (Multiple) -->
                                        <input 
                                            type="file" 
                                            name="pets[{{ $index }}][documents][]" 
                                            id="pet_documents_{{ $index }}"
                                            accept=".pdf,.jpg,.jpeg,.png"
                                            multiple
                                            onchange="previewPetDocuments({{ $index }})"
                                            class="hidden"
                                        >
                                        
                                        <!-- Preview Container -->
                                        <div id="pet_documents_preview_{{ $index }}" class="space-y-2">
                                            @if(!empty($pet['document_paths']))
                                                <!-- EXISTING DOCUMENTS LIST -->
                                                @foreach($pet['document_paths'] as $docIndex => $docPath)
                                                    @if(Storage::disk('public')->exists($docPath))
                                                        <div class="relative bg-gray-50 border-2 border-gray-200 rounded-lg p-3 existing-document" data-doc-index="{{ $docIndex }}">
                                                            <div class="flex items-center gap-3">
                                                                <!-- File Icon or Thumbnail -->
                                                                @if(in_array(pathinfo($docPath, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png']))
                                                                    <img src="{{ Storage::url($docPath) }}" alt="Document {{ $docIndex + 1 }}" class="w-16 h-16 object-cover rounded-lg border-2 border-gray-300">
                                                                @else
                                                                    <div class="w-16 h-16 rounded-lg border-2 border-gray-300 flex items-center justify-center bg-red-50">
                                                                        <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                                                        </svg>
                                                                    </div>
                                                                @endif
                                                                
                                                                <!-- File Info -->
                                                                <div class="flex-1 min-w-0">
                                                                    <p class="text-sm font-medium text-gray-900 truncate">{{ basename($docPath) }}</p>
                                                                    <p class="text-xs text-gray-500">Document {{ $docIndex + 1 }}</p>
                                                                </div>
                                                                
                                                                <!-- View Button -->
                                                                <a 
                                                                    href="{{ Storage::url($docPath) }}" 
                                                                    target="_blank"
                                                                    class="flex-shrink-0 text-blue-600 hover:text-blue-800 transition p-2 hover:bg-blue-50 rounded-lg"
                                                                    title="View document"
                                                                >
                                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                                    </svg>
                                                                </a>
                                                                
                                                                <!-- Remove Button -->
                                                                <button 
                                                                    type="button" 
                                                                    onclick="removeExistingPetDocument({{ $index }}, {{ $docIndex }})"
                                                                    class="flex-shrink-0 text-red-600 hover:text-red-800 transition p-2 hover:bg-red-50 rounded-lg"
                                                                    title="Remove document"
                                                                >
                                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                                    </svg>
                                                                </button>
                                                            </div>
                                                            <!-- Hidden input to track existing document -->
                                                            <input type="hidden" name="pets[{{ $index }}][existing_documents][]" value="{{ $docPath }}">
                                                        </div>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </div>
                                        
                                        <!-- Upload Button -->
                                        <button 
                                            type="button" 
                                            onclick="document.getElementById('pet_documents_{{ $index }}').click()"
                                            class="w-full px-4 py-3 border-2 border-dashed border-gray-300 rounded-lg hover:border-plyform-orange transition-colors text-center cursor-pointer"
                                        >
                                            <svg class="w-8 h-8 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                            </svg>
                                            <span class="text-sm text-gray-600">Click to upload registration documents</span>
                                            <span class="text-xs text-gray-500 block mt-1">PDF, JPG, PNG (Max 10MB each) - Select multiple files</span>
                                        </button>
                                    </div>
                                    <p class="mt-1 text-xs text-gray-500">Upload registration certificates if available. You can select multiple files at once.</p>
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
    
    if (formDiv.classList.contains('hidden')) {
        // Expand
        formDiv.classList.remove('hidden');
        chevron.style.transform = 'rotate(90deg)';
        
        // Scroll to card
        setTimeout(() => {
            document.getElementById('pets-card')?.scrollIntoView({ 
                behavior: 'smooth', 
                block: 'start' 
            });
        }, 100);
    } else {
        // Collapse
        formDiv.classList.add('hidden');
        chevron.style.transform = 'rotate(0deg)';
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

            <!-- Pet Photos - MULTIPLE UPLOAD -->
            <div class="mt-4">
                <label class="text-sm font-medium text-plyform-dark mb-2 block">
                    Pet Photos <span class="text-plyform-orange">*</span>
                </label>
                <div class="space-y-3">
                    <input 
                        type="file" 
                        name="pets[${petIndex}][photos][]" 
                        id="pet_photos_${petIndex}"
                        accept="image/jpeg,image/png,image/jpg,image/gif"
                        multiple
                        required
                        onchange="previewPetPhotos(${petIndex})"
                        class="hidden"
                    >
                    
                    <div id="pet_photos_preview_${petIndex}" class="space-y-2"></div>
                    
                    <button 
                        type="button" 
                        onclick="document.getElementById('pet_photos_${petIndex}').click()"
                        class="w-full px-4 py-3 border-2 border-dashed border-gray-300 rounded-lg hover:border-plyform-orange transition-colors text-center cursor-pointer"
                    >
                        <svg class="w-8 h-8 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span class="text-sm text-gray-600">Click to upload pet photos</span>
                        <span class="text-xs text-gray-500 block mt-1">JPEG, PNG, GIF (Max 10MB each) - Select multiple files</span>
                    </button>
                </div>
                <p class="mt-1 text-xs text-gray-500">Upload at least 1 photo. You can select multiple photos at once.</p>
            </div>
            
            <!-- Pet Registration Documents - MULTIPLE UPLOAD -->
            <div class="mt-4">
                <label class="text-sm font-medium text-plyform-dark mb-2 block">
                    Pet Registration Documents (Optional)
                </label>
                <div class="space-y-3">
                    <input 
                        type="file" 
                        name="pets[${petIndex}][documents][]" 
                        id="pet_documents_${petIndex}"
                        accept=".pdf,.jpg,.jpeg,.png"
                        multiple
                        onchange="previewPetDocuments(${petIndex})"
                        class="hidden"
                    >
                    
                    <div id="pet_documents_preview_${petIndex}" class="space-y-2"></div>
                    
                    <button 
                        type="button" 
                        onclick="document.getElementById('pet_documents_${petIndex}').click()"
                        class="w-full px-4 py-3 border-2 border-dashed border-gray-300 rounded-lg hover:border-plyform-orange transition-colors text-center cursor-pointer"
                    >
                        <svg class="w-8 h-8 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                        </svg>
                        <span class="text-sm text-gray-600">Click to upload registration documents</span>
                        <span class="text-xs text-gray-500 block mt-1">PDF, JPG, PNG (Max 10MB each) - Select multiple files</span>
                    </button>
                </div>
                <p class="mt-1 text-xs text-gray-500">Upload registration certificates if available. You can select multiple files at once.</p>
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

// Remove pet item
function removePetItem(index) {
    const item = document.querySelector(`.pet-item[data-index="${index}"]`);
    if (item) {
        item.remove();
    }
}

// Preview multiple pet photos
function previewPetPhotos(index) {
    const input = document.getElementById(`pet_photos_${index}`);
    const previewContainer = document.getElementById(`pet_photos_preview_${index}`);
    
    if (!input || !input.files || input.files.length === 0) {
        return;
    }
    
    // Clear new previews (keep existing ones)
    const newPreviews = previewContainer.querySelectorAll('.new-photo');
    newPreviews.forEach(el => el.remove());
    
    // Process each file
    Array.from(input.files).forEach((file, fileIndex) => {
        // Validate file size (10MB)
        if (file.size > 10 * 1024 * 1024) {
            alert(`File "${file.name}" is too large. Maximum size is 10MB.`);
            return;
        }
        
        // Validate file type
        if (!file.type.match('image.*')) {
            alert(`File "${file.name}" is not an image.`);
            return;
        }
        
        const reader = new FileReader();
        
        reader.onload = function(e) {
            const previewHtml = `
                <div class="relative bg-gray-50 border-2 border-green-200 rounded-lg p-3 new-photo">
                    <div class="flex items-center gap-3">
                        <img src="${e.target.result}" alt="New photo ${fileIndex + 1}" class="w-16 h-16 object-cover rounded-lg border-2 border-gray-300">
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate">${file.name}</p>
                            <p class="text-xs text-gray-500">${(file.size / 1024).toFixed(2)} KB</p>
                        </div>
                        <span class="flex-shrink-0 text-xs text-green-600 font-medium bg-green-100 px-2 py-1 rounded">New</span>
                    </div>
                </div>
            `;
            previewContainer.insertAdjacentHTML('beforeend', previewHtml);
        };
        
        reader.readAsDataURL(file);
    });
}

// Preview multiple pet documents
function previewPetDocuments(index) {
    const input = document.getElementById(`pet_documents_${index}`);
    const previewContainer = document.getElementById(`pet_documents_preview_${index}`);
    
    if (!input || !input.files || input.files.length === 0) {
        return;
    }
    
    // Clear new previews (keep existing ones)
    const newPreviews = previewContainer.querySelectorAll('.new-document');
    newPreviews.forEach(el => el.remove());
    
    // Process each file
    Array.from(input.files).forEach((file, fileIndex) => {
        // Validate file size (10MB)
        if (file.size > 10 * 1024 * 1024) {
            alert(`File "${file.name}" is too large. Maximum size is 10MB.`);
            return;
        }
        
        // Check if it's an image or PDF
        const isImage = file.type.match('image.*');
        const isPDF = file.type === 'application/pdf';
        
        if (!isImage && !isPDF) {
            alert(`File "${file.name}" must be PDF, JPG, or PNG.`);
            return;
        }
        
        const reader = new FileReader();
        
        reader.onload = function(e) {
            let thumbnailHtml = '';
            if (isImage) {
                thumbnailHtml = `<img src="${e.target.result}" alt="New document ${fileIndex + 1}" class="w-16 h-16 object-cover rounded-lg border-2 border-gray-300">`;
            } else {
                thumbnailHtml = `
                    <div class="w-16 h-16 rounded-lg border-2 border-gray-300 flex items-center justify-center bg-red-50">
                        <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                        </svg>
                    </div>
                `;
            }
            
            const previewHtml = `
                <div class="relative bg-gray-50 border-2 border-green-200 rounded-lg p-3 new-document">
                    <div class="flex items-center gap-3">
                        ${thumbnailHtml}
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate">${file.name}</p>
                            <p class="text-xs text-gray-500">${(file.size / 1024).toFixed(2)} KB</p>
                        </div>
                        <span class="flex-shrink-0 text-xs text-green-600 font-medium bg-green-100 px-2 py-1 rounded">New</span>
                    </div>
                </div>
            `;
            previewContainer.insertAdjacentHTML('beforeend', previewHtml);
        };
        
        reader.readAsDataURL(file);
    });
}

// Remove existing pet photo
function removeExistingPetPhoto(petIndex, photoIndex) {
    if (confirm('Remove this photo?')) {
        const photoDiv = document.querySelector(`#pet_photos_preview_${petIndex} .existing-photo[data-photo-index="${photoIndex}"]`);
        if (photoDiv) {
            photoDiv.remove();
        }
    }
}

// Remove existing pet document
function removeExistingPetDocument(petIndex, docIndex) {
    if (confirm('Remove this document?')) {
        const docDiv = document.querySelector(`#pet_documents_preview_${petIndex} .existing-document[data-doc-index="${docIndex}"]`);
        if (docDiv) {
            docDiv.remove();
        }
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    togglePetsSection();
});
</script>