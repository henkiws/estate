<x-form-section-card 
    title="References" 
    description="Provide at least 2 references who can vouch for your character and rental history"
    required>
    
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
                            onclick="removeReference({{ $index }})"
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
                            <x-profile-help-text text="e.g., Previous Landlord, Employer, Friend, Colleague" />
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
                            <option value="+61" {{ ($reference['mobile_country_code'] ?? '+61') == '+61' ? 'selected' : '' }}>+61 (Australia)</option>
                            <option value="+1" {{ ($reference['mobile_country_code'] ?? '') == '+1' ? 'selected' : '' }}>+1 (USA/Canada)</option>
                            <option value="+44" {{ ($reference['mobile_country_code'] ?? '') == '+44' ? 'selected' : '' }}>+44 (UK)</option>
                            <option value="+64" {{ ($reference['mobile_country_code'] ?? '') == '+64' ? 'selected' : '' }}>+64 (New Zealand)</option>
                            <option value="+86" {{ ($reference['mobile_country_code'] ?? '') == '+86' ? 'selected' : '' }}>+86 (China)</option>
                            <option value="+91" {{ ($reference['mobile_country_code'] ?? '') == '+91' ? 'selected' : '' }}>+91 (India)</option>
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
        onclick="addReference()"
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
            <span class="text-lg font-bold" :class="referenceCount >= 2 ? 'text-green-600' : 'text-orange-600'" id="reference-count">{{ count($references) }}</span>
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
    
</x-form-section-card>

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
        id="submit-btn"
        class="px-8 py-3 bg-teal-600 text-white font-semibold rounded-lg hover:bg-teal-700 transition shadow-sm flex items-center gap-2"
    >
        Save & Continue
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
    </button>
</div>

<script>
let referenceIndex = {{ count($references) }};

function updateReferenceCount() {
    const count = document.querySelectorAll('.reference-item').length;
    const countDisplay = document.getElementById('reference-count');
    const message = document.getElementById('reference-message');
    const submitBtn = document.getElementById('submit-btn');
    
    countDisplay.textContent = count;
    
    if (count >= 2) {
        countDisplay.className = 'text-lg font-bold text-green-600';
        message.textContent = '✓ You have enough references';
        submitBtn.disabled = false;
    } else {
        countDisplay.className = 'text-lg font-bold text-orange-600';
        message.textContent = `You need at least ${2 - count} more reference(s)`;
        submitBtn.disabled = true;
    }
}

function addReference() {
    const container = document.getElementById('references-container');
    
    const newReference = `
        <div class="reference-item p-4 border-2 border-gray-200 rounded-lg mb-4" data-index="${referenceIndex}">
            <div class="flex items-center justify-between mb-4">
                <h4 class="font-semibold text-gray-900">Reference ${referenceIndex + 1}</h4>
                <button type="button" onclick="removeReference(${referenceIndex})" class="text-red-600 hover:text-red-700 text-sm font-medium">
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
                        <option value="+61" selected>+61 (Australia)</option>
                        <option value="+1">+1 (USA/Canada)</option>
                        <option value="+44">+44 (UK)</option>
                        <option value="+64">+64 (New Zealand)</option>
                        <option value="+86">+86 (China)</option>
                        <option value="+91">+91 (India)</option>
                    </select>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-700 mb-2 block">Mobile Number <span class="text-red-500">*</span></label>
                    <input type="tel" name="references[${referenceIndex}][mobile_number]" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500" placeholder="400 000 000">
                </div>
            </div>
            
            <div>
                <label class="text-sm font-medium text-gray-700 mb-2 block">Email Address <span class="text-red-500">*</span></label>
                <input type="email" name="references[${referenceIndex}][email]" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500" placeholder="reference@email.com">
            </div>
        </div>
    `;
    
    container.insertAdjacentHTML('beforeend', newReference);
    referenceIndex++;
    updateReferenceCount();
}

function removeReference(index) {
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
    }
}

// Initialize count on page load
document.addEventListener('DOMContentLoaded', function() {
    updateReferenceCount();
});
</script>