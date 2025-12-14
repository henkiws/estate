@php
    $currentStep = $step ?? 8;
@endphp

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
                            onclick="removeStep8Reference({{ $index }})"
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
        onclick="addStep8Reference()"
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
            <span class="text-lg font-bold text-green-600" id="step8-reference-count">{{ count($references) }}</span>
        </div>
        <p class="text-xs text-gray-600 mt-1">
            <span id="step8-reference-message">
                @if(count($references) >= 2)
                    ✓ You have enough references
                @else
                    You need at least {{ 2 - count($references) }} more reference(s)
                @endif
            </span>
        </p>
    </div>
    
</x-form-section-card>

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
// Use unique variable name
var step8ReferenceIndex = {{ count($references) }};

console.log('👥 Step 8 References - referenceIndex:', step8ReferenceIndex);

// UNIQUE function: updateStep8ReferenceCount
function updateStep8ReferenceCount() {
    const count = document.querySelectorAll('.reference-item').length;
    const countDisplay = document.getElementById('step8-reference-count');
    const message = document.getElementById('step8-reference-message');
    
    if (!countDisplay || !message) {
        console.error('❌ Count display elements not found');
        return;
    }
    
    countDisplay.textContent = count;
    
    if (count >= 2) {
        countDisplay.className = 'text-lg font-bold text-green-600';
        message.textContent = '✓ You have enough references';
        console.log('✅ Sufficient references:', count);
    } else {
        countDisplay.className = 'text-lg font-bold text-orange-600';
        message.textContent = `You need at least ${2 - count} more reference(s)`;
        console.log('⚠️ Need more references. Current:', count);
    }
}

// UNIQUE function: addStep8Reference
function addStep8Reference() {
    console.log('👥 Adding reference. Current index:', step8ReferenceIndex);
    
    const container = document.getElementById('references-container');
    
    if (!container) {
        console.error('❌ Container not found!');
        return;
    }
    
    const newReferenceHtml = `
        <div class="reference-item p-4 border-2 border-gray-200 rounded-lg mb-4" data-index="${step8ReferenceIndex}">
            <div class="flex items-center justify-between mb-4">
                <h4 class="font-semibold text-gray-900">Reference ${step8ReferenceIndex + 1}</h4>
                <button type="button" onclick="removeStep8Reference(${step8ReferenceIndex})" class="text-red-600 hover:text-red-700 text-sm font-medium">
                    Remove
                </button>
            </div>
            
            <div class="grid md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="text-sm font-medium text-gray-700 mb-2 block">Full Name <span class="text-red-500">*</span></label>
                    <input type="text" name="references[${step8ReferenceIndex}][full_name]" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500" placeholder="John Smith">
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-700 mb-2 block">Relationship <span class="text-red-500">*</span></label>
                    <input type="text" name="references[${step8ReferenceIndex}][relationship]" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500" placeholder="Previous Landlord">
                </div>
            </div>
            
            <div class="grid md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="text-sm font-medium text-gray-700 mb-2 block">Country Code <span class="text-red-500">*</span></label>
                    <select name="references[${step8ReferenceIndex}][mobile_country_code]" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">
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
                    <input type="tel" name="references[${step8ReferenceIndex}][mobile_number]" required pattern="[0-9\s]+" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500" placeholder="400 000 000">
                </div>
            </div>
            
            <div>
                <label class="text-sm font-medium text-gray-700 mb-2 block">Email Address <span class="text-red-500">*</span></label>
                <input type="email" name="references[${step8ReferenceIndex}][email]" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500" placeholder="reference@email.com">
            </div>
        </div>
    `;
    
    container.insertAdjacentHTML('beforeend', newReferenceHtml);
    
    console.log('✅ Reference added with index:', step8ReferenceIndex);
    
    step8ReferenceIndex++;
    updateStep8ReferenceCount();
}

// UNIQUE function: removeStep8Reference
function removeStep8Reference(index) {
    console.log('🗑️ Attempting to remove reference:', index);
    
    const items = document.querySelectorAll('.reference-item');
    
    // Don't allow removing if only 2 references left
    if (items.length <= 2) {
        alert('You must have at least 2 references');
        console.log('⚠️ Cannot remove - minimum 2 required');
        return;
    }
    
    const item = document.querySelector(`.reference-item[data-index="${index}"]`);
    
    if (item) {
        item.remove();
        console.log('✅ Reference removed');
        updateStep8ReferenceCount();
    } else {
        console.error('❌ Reference item not found with index:', index);
    }
}

// Initialize count on page load
document.addEventListener('DOMContentLoaded', function() {
    console.log('📄 Step 8 DOM loaded - initializing reference count...');
    updateStep8ReferenceCount();
});

console.log('🎯 Step 8 references script loaded');
</script>