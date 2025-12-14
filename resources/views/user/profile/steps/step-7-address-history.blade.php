@php
    $currentStep = $step ?? 7;
@endphp

<x-form-section-card 
    title="Address History" 
    description="Provide details of your residential history for the past 3 years"
    required>
    
    <!-- Info Box -->
    <div class="p-4 bg-blue-50 border border-blue-200 rounded-lg mb-6">
        <p class="text-sm text-blue-800">
            <strong>Note:</strong> Please provide at least 3 years of address history. Include your current address and previous addresses.
        </p>
    </div>
    
    <div id="addresses-container">
        @php
            $addresses = old('addresses', $user->addresses->toArray() ?: [['living_arrangement' => '']]);
        @endphp
        
        @foreach($addresses as $index => $address)
            <div class="address-item p-4 border-2 border-gray-200 rounded-lg mb-4" data-index="{{ $index }}">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-2">
                        <h4 class="font-semibold text-gray-900">Address {{ $index + 1 }}</h4>
                        @if($index === 0)
                            <span class="px-2 py-1 bg-teal-100 text-teal-700 text-xs font-semibold rounded">Current</span>
                        @endif
                    </div>
                    @if($index > 0)
                        <button 
                            type="button" 
                            onclick="removeStep7Address({{ $index }})"
                            class="text-red-600 hover:text-red-700 text-sm font-medium"
                        >
                            Remove
                        </button>
                    @endif
                </div>
                
                <!-- Living Arrangement -->
                <div class="mb-4">
                    <label class="flex items-center gap-2 text-sm font-medium text-gray-700 mb-2">
                        Living Arrangement <span class="text-red-500">*</span>
                        <x-profile-help-text text="Your living situation at this address" />
                    </label>
                    <select 
                        name="addresses[{{ $index }}][living_arrangement]" 
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500"
                    >
                        <option value="">Select arrangement</option>
                        <option value="owner" {{ ($address['living_arrangement'] ?? '') == 'owner' ? 'selected' : '' }}>Owner</option>
                        <option value="renting_agent" {{ ($address['living_arrangement'] ?? '') == 'renting_agent' ? 'selected' : '' }}>Renting through Agent</option>
                        <option value="renting_privately" {{ ($address['living_arrangement'] ?? '') == 'renting_privately' ? 'selected' : '' }}>Renting Privately</option>
                        <option value="with_parents" {{ ($address['living_arrangement'] ?? '') == 'with_parents' ? 'selected' : '' }}>Living with Parents</option>
                        <option value="sharing" {{ ($address['living_arrangement'] ?? '') == 'sharing' ? 'selected' : '' }}>Sharing</option>
                        <option value="other" {{ ($address['living_arrangement'] ?? '') == 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>
                
                <!-- Full Address -->
                <div class="mb-4">
                    <label class="flex items-center gap-2 text-sm font-medium text-gray-700 mb-2">
                        Full Address <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="addresses[{{ $index }}][address]" 
                        value="{{ $address['address'] ?? '' }}"
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500"
                        placeholder="123 Main Street, Sydney NSW 2000"
                    >
                </div>
                
                <!-- Duration -->
                <div class="grid md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="flex items-center gap-2 text-sm font-medium text-gray-700 mb-2">
                            Years Lived <span class="text-red-500">*</span>
                        </label>
                        <select 
                            name="addresses[{{ $index }}][years_lived]" 
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500"
                        >
                            @for($i = 0; $i <= 20; $i++)
                                <option value="{{ $i }}" {{ ($address['years_lived'] ?? 0) == $i ? 'selected' : '' }}>{{ $i }} {{ $i === 1 ? 'year' : 'years' }}</option>
                            @endfor
                        </select>
                    </div>
                    
                    <div>
                        <label class="flex items-center gap-2 text-sm font-medium text-gray-700 mb-2">
                            Months Lived <span class="text-red-500">*</span>
                        </label>
                        <select 
                            name="addresses[{{ $index }}][months_lived]" 
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500"
                        >
                            @for($i = 0; $i <= 11; $i++)
                                <option value="{{ $i }}" {{ ($address['months_lived'] ?? 0) == $i ? 'selected' : '' }}>{{ $i }} {{ $i === 1 ? 'month' : 'months' }}</option>
                            @endfor
                        </select>
                    </div>
                </div>
                
                <!-- Reason for Leaving -->
                @if($index > 0)
                    <div class="mb-4">
                        <label class="flex items-center gap-2 text-sm font-medium text-gray-700 mb-2">
                            Reason for Leaving
                            <x-profile-help-text text="Brief explanation of why you left this address" />
                        </label>
                        <textarea 
                            name="addresses[{{ $index }}][reason_for_leaving]" 
                            rows="3"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500"
                            placeholder="e.g., End of lease, relocated for work, purchased property..."
                        >{{ $address['reason_for_leaving'] ?? '' }}</textarea>
                    </div>
                @endif
                
                <!-- Different Postal Address -->
                <div class="mb-4">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input 
                            type="checkbox" 
                            name="addresses[{{ $index }}][different_postal_address]" 
                            value="1"
                            onchange="toggleStep7PostalAddress({{ $index }})"
                            {{ ($address['different_postal_address'] ?? false) ? 'checked' : '' }}
                            class="w-5 h-5 text-teal-600 border-gray-300 rounded"
                        >
                        <span class="text-sm text-gray-700">My postal address is different from this address</span>
                    </label>
                </div>
                
                <div class="postal-address-field hidden" data-index="{{ $index }}">
                    <label class="text-sm font-medium text-gray-700 mb-2 block">
                        Postal Address <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="addresses[{{ $index }}][postal_code]" 
                        value="{{ $address['postal_code'] ?? '' }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500"
                        placeholder="PO Box 123, Sydney NSW 2000"
                    >
                </div>
                
                <!-- Is Current Address -->
                @if($index === 0)
                    <input type="hidden" name="addresses[{{ $index }}][is_current]" value="1">
                @endif
            </div>
        @endforeach
    </div>
    
    <!-- Add Address Button -->
    <button 
        type="button" 
        onclick="addStep7Address()"
        class="w-full py-3 border-2 border-dashed border-gray-300 rounded-lg text-gray-600 hover:border-teal-500 hover:text-teal-600 transition flex items-center justify-center gap-2"
    >
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
        </svg>
        Add Previous Address
    </button>
    
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
var step7AddressIndex = {{ count($addresses) }};

console.log('🏠 Step 7 Address form - addressIndex:', step7AddressIndex);

// UNIQUE function name: toggleStep7PostalAddress
function toggleStep7PostalAddress(index) {
    console.log('📬 Toggling postal address for index:', index);
    
    const checkbox = document.querySelector(`input[name="addresses[${index}][different_postal_address]"]`);
    const postalField = document.querySelector(`.postal-address-field[data-index="${index}"]`);
    
    if (!checkbox || !postalField) {
        console.error('❌ Elements not found for index:', index);
        return;
    }
    
    const postalInput = postalField.querySelector('input');
    
    if (checkbox.checked) {
        postalField.classList.remove('hidden');
        if (postalInput) postalInput.required = true;
        console.log('✅ Showing postal address field');
    } else {
        postalField.classList.add('hidden');
        if (postalInput) {
            postalInput.required = false;
            postalInput.value = '';
        }
        console.log('❌ Hiding postal address field');
    }
}

// UNIQUE function name: addStep7Address
function addStep7Address() {
    console.log('🏠 Adding address. Current index:', step7AddressIndex);
    
    const container = document.getElementById('addresses-container');
    
    if (!container) {
        console.error('❌ Container not found!');
        return;
    }
    
    const newAddressHtml = `
        <div class="address-item p-4 border-2 border-gray-200 rounded-lg mb-4" data-index="${step7AddressIndex}">
            <div class="flex items-center justify-between mb-4">
                <h4 class="font-semibold text-gray-900">Address ${step7AddressIndex + 1}</h4>
                <button type="button" onclick="removeStep7Address(${step7AddressIndex})" class="text-red-600 hover:text-red-700 text-sm font-medium">
                    Remove
                </button>
            </div>
            
            <div class="mb-4">
                <label class="text-sm font-medium text-gray-700 mb-2 block">Living Arrangement <span class="text-red-500">*</span></label>
                <select name="addresses[${step7AddressIndex}][living_arrangement]" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">
                    <option value="">Select arrangement</option>
                    <option value="owner">Owner</option>
                    <option value="renting_agent">Renting through Agent</option>
                    <option value="renting_privately">Renting Privately</option>
                    <option value="with_parents">Living with Parents</option>
                    <option value="sharing">Sharing</option>
                    <option value="other">Other</option>
                </select>
            </div>
            
            <div class="mb-4">
                <label class="text-sm font-medium text-gray-700 mb-2 block">Full Address <span class="text-red-500">*</span></label>
                <input type="text" name="addresses[${step7AddressIndex}][address]" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500" placeholder="123 Main Street, Sydney NSW 2000">
            </div>
            
            <div class="grid md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="text-sm font-medium text-gray-700 mb-2 block">Years Lived <span class="text-red-500">*</span></label>
                    <select name="addresses[${step7AddressIndex}][years_lived]" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">
                        ${Array.from({length: 21}, (_, i) => `<option value="${i}">${i} ${i === 1 ? 'year' : 'years'}</option>`).join('')}
                    </select>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-700 mb-2 block">Months Lived <span class="text-red-500">*</span></label>
                    <select name="addresses[${step7AddressIndex}][months_lived]" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">
                        ${Array.from({length: 12}, (_, i) => `<option value="${i}">${i} ${i === 1 ? 'month' : 'months'}</option>`).join('')}
                    </select>
                </div>
            </div>
            
            <div class="mb-4">
                <label class="text-sm font-medium text-gray-700 mb-2 block">Reason for Leaving</label>
                <textarea name="addresses[${step7AddressIndex}][reason_for_leaving]" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500" placeholder="e.g., End of lease, relocated for work, purchased property..."></textarea>
            </div>
            
            <div class="mb-4">
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="addresses[${step7AddressIndex}][different_postal_address]" value="1" onchange="toggleStep7PostalAddress(${step7AddressIndex})" class="w-5 h-5 text-teal-600 rounded">
                    <span class="text-sm text-gray-700">My postal address is different from this address</span>
                </label>
            </div>
            
            <div class="postal-address-field hidden" data-index="${step7AddressIndex}">
                <label class="text-sm font-medium text-gray-700 mb-2 block">Postal Address <span class="text-red-500">*</span></label>
                <input type="text" name="addresses[${step7AddressIndex}][postal_code]" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500" placeholder="PO Box 123, Sydney NSW 2000">
            </div>
        </div>
    `;
    
    container.insertAdjacentHTML('beforeend', newAddressHtml);
    
    console.log('✅ Address added with index:', step7AddressIndex);
    
    step7AddressIndex++;
}

// UNIQUE function name: removeStep7Address
function removeStep7Address(index) {
    console.log('🗑️ Removing address with index:', index);
    
    const item = document.querySelector(`.address-item[data-index="${index}"]`);
    
    if (item) {
        item.remove();
        console.log('✅ Address removed');
    } else {
        console.error('❌ Address item not found with index:', index);
    }
}

// Initialize postal address fields on page load
document.addEventListener('DOMContentLoaded', function() {
    console.log('📄 Step 7 DOM loaded - initializing postal address fields...');
    
    document.querySelectorAll('input[name^="addresses"][name$="[different_postal_address]"]').forEach((checkbox) => {
        // Extract index from name attribute
        const match = checkbox.name.match(/addresses\[(\d+)\]/);
        if (match && checkbox.checked) {
            const index = parseInt(match[1]);
            toggleStep7PostalAddress(index);
            console.log('✅ Initialized postal address for index:', index);
        }
    });
});

console.log('🎯 Step 7 address script loaded');
</script>