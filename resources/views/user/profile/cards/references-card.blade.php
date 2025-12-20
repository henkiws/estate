<!-- References Card -->
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-4" id="references-card">
    
    <!-- Card Header (Always Visible) -->
    <div class="p-6">
        <div class="flex items-start justify-between">
            
            <!-- Left: Icon + Content -->
            <div class="flex items-start gap-4 flex-1">
                <!-- Icon -->
                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-500 to-teal-500 flex items-center justify-center text-white flex-shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                
                <!-- Content -->
                <div class="flex-1">
                    <h3 class="text-lg font-semibold text-gray-900">References</h3>
                    <p class="text-sm text-gray-500 mt-1" id="references-summary">
                        @if($user->references && $user->references->count() > 0)
                            {{ $user->references->count() }} {{ Str::plural('reference', $user->references->count()) }}
                        @else
                            Not completed yet
                        @endif
                    </p>
                    
                    <!-- Status Badge -->
                    <div class="mt-3">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $user->references && $user->references->count() >= 2 ? 'bg-teal-50 text-teal-700 border border-teal-200' : 'bg-gray-50 text-gray-700 border border-gray-200' }}" id="references-status">
                            @if($user->references && $user->references->count() >= 2)
                                Complete
                            @else
                                Incomplete
                            @endif
                        </span>
                    </div>
                </div>
            </div>
            
            <!-- Right: Completion % + Edit Button -->
            <div class="flex items-start gap-4 ml-4">
                <!-- Completion Percentage -->
                <div class="flex items-center justify-center w-14 h-14 rounded-full border-4 {{ $user->references && $user->references->count() >= 2 ? 'border-teal-500' : 'border-gray-300' }} bg-white">
                    <span class="text-sm font-bold {{ $user->references && $user->references->count() >= 2 ? 'text-teal-600' : 'text-gray-400' }}" id="references-percentage">
                        @if($user->references && $user->references->count() >= 2)
                            100%
                        @else
                            0%
                        @endif
                    </span>
                </div>
                
                <!-- Edit Button -->
                <button 
                    type="button" 
                    onclick="toggleReferences()"
                    class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-teal-600 hover:text-teal-700 hover:bg-teal-50 rounded-lg transition"
                    id="references-edit-btn"
                >
                    <span>Edit</span>
                    <svg class="w-4 h-4 transition-transform" id="references-chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
            </div>
            
        </div>
    </div>
    
    <!-- Expandable Form Content (Hidden by Default) -->
    <div class="border-t border-gray-200 bg-gray-50 hidden" id="references-form">
        <form method="POST" action="{{ route('user.profile.update-step') }}" class="p-6 space-y-6">
            @csrf
            <input type="hidden" name="current_step" value="8">
            
            <!-- References Section -->
            <div class="bg-white rounded-lg p-6 space-y-4">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h4 class="text-base font-semibold text-gray-900">References</h4>
                        <p class="text-sm text-gray-500 mt-1">Provide at least 2 references who can vouch for your character and rental history</p>
                    </div>
                    <span class="text-red-500 text-sm font-medium">* Required</span>
                </div>
                
                <!-- Info Box -->
                <div class="p-4 bg-blue-50 border border-blue-200 rounded-lg mb-6">
                    <h4 class="font-semibold text-blue-900 mb-2">About References:</h4>
                    <ul class="text-sm text-blue-800 space-y-1">
                        <li>• Minimum 2 references required</li>
                        <li>• Can be previous landlords, employers, or personal references</li>
                        <li>• Should not be family members</li>
                        <li>• Should have known you for at least 6 months</li>
                    </ul>
                </div>
                
                <div id="references-container">
                    @php
                        $references = old('references', $user->references->toArray() ?: [
                            ['full_name' => '', 'relationship' => ''],
                            ['full_name' => '', 'relationship' => '']
                        ]);
                    @endphp
                    
                    @foreach($references as $index => $reference)
                        <div class="reference-item p-4 border-2 border-gray-200 rounded-lg mb-4" data-index="{{ $index }}">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center gap-2">
                                    <h4 class="font-semibold text-gray-900">Reference {{ $index + 1 }}</h4>
                                    @if($index < 2)
                                        <span class="px-2 py-1 bg-teal-100 text-teal-700 text-xs font-semibold rounded">Required</span>
                                    @endif
                                </div>
                                @if($index >= 2)
                                    <button 
                                        type="button" 
                                        onclick="removeReferenceItem({{ $index }})"
                                        class="text-red-600 hover:text-red-700 text-sm font-medium"
                                    >
                                        Remove
                                    </button>
                                @endif
                            </div>
                            
                            <div class="grid md:grid-cols-2 gap-4 mb-4">
                                <!-- Full Name -->
                                <div>
                                    <label class="flex items-center gap-2 text-sm font-medium text-gray-700 mb-2">
                                        Full Name <span class="text-red-500">*</span>
                                    </label>
                                    <input 
                                        type="text" 
                                        name="references[{{ $index }}][full_name]" 
                                        value="{{ $reference['full_name'] ?? '' }}"
                                        required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500"
                                        placeholder="John Smith"
                                    >
                                </div>
                                
                                <!-- Relationship -->
                                <div>
                                    <label class="flex items-center gap-2 text-sm font-medium text-gray-700 mb-2">
                                        Relationship <span class="text-red-500">*</span>
                                    </label>
                                    <input 
                                        type="text" 
                                        name="references[{{ $index }}][relationship]" 
                                        value="{{ $reference['relationship'] ?? '' }}"
                                        required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500"
                                        placeholder="Previous Landlord"
                                    >
                                </div>
                            </div>
                            
                            <div class="grid md:grid-cols-2 gap-4 mb-4">
                                <!-- Mobile Country Code -->
                                <div>
                                    <label class="flex items-center gap-2 text-sm font-medium text-gray-700 mb-2">
                                        Country Code <span class="text-red-500">*</span>
                                    </label>
                                    <select 
                                        name="references[{{ $index }}][mobile_country_code]" 
                                        required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500"
                                    >
                                        <option value="+61" {{ ($reference['mobile_country_code'] ?? '+61') == '+61' ? 'selected' : '' }}>🇦🇺 +61 (Australia)</option>
                                        <option value="+1" {{ ($reference['mobile_country_code'] ?? '') == '+1' ? 'selected' : '' }}>🇺🇸 +1 (USA/Canada)</option>
                                        <option value="+44" {{ ($reference['mobile_country_code'] ?? '') == '+44' ? 'selected' : '' }}>🇬🇧 +44 (UK)</option>
                                        <option value="+64" {{ ($reference['mobile_country_code'] ?? '') == '+64' ? 'selected' : '' }}>🇳🇿 +64 (New Zealand)</option>
                                        <option value="+86" {{ ($reference['mobile_country_code'] ?? '') == '+86' ? 'selected' : '' }}>🇨🇳 +86 (China)</option>
                                        <option value="+91" {{ ($reference['mobile_country_code'] ?? '') == '+91' ? 'selected' : '' }}>🇮🇳 +91 (India)</option>
                                    </select>
                                </div>
                                
                                <!-- Mobile Number -->
                                <div>
                                    <label class="flex items-center gap-2 text-sm font-medium text-gray-700 mb-2">
                                        Mobile Number <span class="text-red-500">*</span>
                                    </label>
                                    <input 
                                        type="tel" 
                                        name="references[{{ $index }}][mobile_number]" 
                                        value="{{ $reference['mobile_number'] ?? '' }}"
                                        required
                                        pattern="[0-9\s]+"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500"
                                        placeholder="400 000 000"
                                    >
                                </div>
                            </div>
                            
                            <!-- Email -->
                            <div>
                                <label class="flex items-center gap-2 text-sm font-medium text-gray-700 mb-2">
                                    Email Address <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="email" 
                                    name="references[{{ $index }}][email]" 
                                    value="{{ $reference['email'] ?? '' }}"
                                    required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500"
                                    placeholder="reference@email.com"
                                >
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Add Reference Button -->
                <button 
                    type="button" 
                    onclick="addReferenceItem()"
                    class="w-full py-3 border-2 border-dashed border-gray-300 rounded-lg text-gray-600 hover:border-teal-500 hover:text-teal-600 transition flex items-center justify-center gap-2"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Add Another Reference
                </button>
                
                <!-- Reference Count Display -->
                <div class="mt-4 p-3 bg-gray-50 border border-gray-200 rounded-lg">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-700">Total References:</span>
                        <span class="text-lg font-bold text-green-600" id="reference-count">{{ count($references) }}</span>
                    </div>
                    <p class="text-xs text-gray-600 mt-1">
                        <span id="reference-message">
                            @if(count($references) >= 2)
                                ✓ You have enough references
                            @else
                                You need at least {{ 2 - count($references) }} more reference(s)
                            @endif
                        </span>
                    </p>
                </div>
                
            </div>
            
            <!-- Form Actions -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200">
                <button 
                    type="button" 
                    onclick="toggleReferences()"
                    class="px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 transition"
                >
                    Cancel
                </button>
                
                <button 
                    type="submit" 
                    class="px-8 py-3 bg-gradient-to-r from-blue-600 to-teal-600 text-white font-semibold rounded-lg hover:from-blue-700 hover:to-teal-700 transition shadow-sm flex items-center gap-2"
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
// Initialize reference index
var referenceIndex = {{ count($references ?? []) }};

function toggleReferences() {
    const formDiv = document.getElementById('references-form');
    const chevron = document.getElementById('references-chevron');
    const editBtn = document.getElementById('references-edit-btn');
    
    if (formDiv.classList.contains('hidden')) {
        // Expand
        formDiv.classList.remove('hidden');
        chevron.style.transform = 'rotate(180deg)';
        editBtn.querySelector('span').textContent = 'Close';
        
        // Scroll to card
        setTimeout(() => {
            document.getElementById('references-card').scrollIntoView({ 
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

// Update reference count display
function updateReferenceCount() {
    const count = document.querySelectorAll('.reference-item').length;
    const countDisplay = document.getElementById('reference-count');
    const message = document.getElementById('reference-message');
    
    if (!countDisplay || !message) {
        return;
    }
    
    countDisplay.textContent = count;
    
    if (count >= 2) {
        countDisplay.className = 'text-lg font-bold text-green-600';
        message.textContent = '✓ You have enough references';
    } else {
        countDisplay.className = 'text-lg font-bold text-orange-600';
        message.textContent = `You need at least ${2 - count} more reference(s)`;
    }
}

// Add new reference
function addReferenceItem() {
    const container = document.getElementById('references-container');
    
    if (!container) {
        console.error('Container not found!');
        return;
    }
    
    const newReferenceHtml = `
        <div class="reference-item p-4 border-2 border-gray-200 rounded-lg mb-4" data-index="${referenceIndex}">
            <div class="flex items-center justify-between mb-4">
                <h4 class="font-semibold text-gray-900">Reference ${referenceIndex + 1}</h4>
                <button type="button" onclick="removeReferenceItem(${referenceIndex})" class="text-red-600 hover:text-red-700 text-sm font-medium">
                    Remove
                </button>
            </div>
            
            <div class="grid md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="text-sm font-medium text-gray-700 mb-2 block">Full Name <span class="text-red-500">*</span></label>
                    <input type="text" name="references[${referenceIndex}][full_name]" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500" placeholder="John Smith">
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-700 mb-2 block">Relationship <span class="text-red-500">*</span></label>
                    <input type="text" name="references[${referenceIndex}][relationship]" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500" placeholder="Previous Landlord">
                </div>
            </div>
            
            <div class="grid md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="text-sm font-medium text-gray-700 mb-2 block">Country Code <span class="text-red-500">*</span></label>
                    <select name="references[${referenceIndex}][mobile_country_code]" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">
                        <option value="+61" selected>🇦🇺 +61 (Australia)</option>
                        <option value="+1">🇺🇸 +1 (USA/Canada)</option>
                        <option value="+44">🇬🇧 +44 (UK)</option>
                        <option value="+64">🇳🇿 +64 (New Zealand)</option>
                        <option value="+86">🇨🇳 +86 (China)</option>
                        <option value="+91">🇮🇳 +91 (India)</option>
                    </select>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-700 mb-2 block">Mobile Number <span class="text-red-500">*</span></label>
                    <input type="tel" name="references[${referenceIndex}][mobile_number]" required pattern="[0-9\s]+" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500" placeholder="400 000 000">
                </div>
            </div>
            
            <div>
                <label class="text-sm font-medium text-gray-700 mb-2 block">Email Address <span class="text-red-500">*</span></label>
                <input type="email" name="references[${referenceIndex}][email]" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500" placeholder="reference@email.com">
            </div>
        </div>
    `;
    
    container.insertAdjacentHTML('beforeend', newReferenceHtml);
    referenceIndex++;

    const newElement = container.lastElementChild;
    reinitializePlugins(newElement);
    
    updateReferenceCount();
}

// Remove reference
function removeReferenceItem(index) {
    const items = document.querySelectorAll('.reference-item');
    
    // Don't allow removing if only 2 references left
    if (items.length <= 2) {
        alert('You must have at least 2 references');
        return;
    }
    
    const item = document.querySelector(`.reference-item[data-index="${index}"]`);
    
    if (item) {
        item.remove();
        updateReferenceCount();
        // Renumber remaining references
        document.querySelectorAll('.reference-item').forEach((el, idx) => {
            const heading = el.querySelector('h4');
            if (idx < 2) {
                heading.innerHTML = `Reference ${idx + 1} <span class="px-2 py-1 bg-teal-100 text-teal-700 text-xs font-semibold rounded ml-2">Required</span>`;
            } else {
                heading.textContent = `Reference ${idx + 1}`;
            }
        });
    }
}

// Initialize count on page load
document.addEventListener('DOMContentLoaded', function() {
    updateReferenceCount();
});
</script>