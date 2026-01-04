<!-- Address History Card -->
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-4 hover:shadow-md transition-shadow" id="address-history-card">
    
    <!-- Card Header (Always Visible) -->
    <div class="p-6">
        <div class="flex items-start justify-between">
            
            <!-- Left: Icon + Content -->
            <div class="flex items-start gap-4 flex-1">
                <!-- Icon -->
                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-plyform-yellow/20 to-plyform-mint/30 flex items-center justify-center text-plyform-dark flex-shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                </div>
                
                <!-- Content -->
                <div class="flex-1">
                    <h3 class="text-lg font-semibold text-plyform-dark">Address History</h3>
                    <p class="text-sm text-gray-600 mt-1" id="address-history-summary">
                        @if($user->addresses && $user->addresses->count() > 0)
                            {{ $user->addresses->count() }} {{ Str::plural('address', $user->addresses->count()) }}
                        @else
                            Not completed yet
                        @endif
                    </p>
                    
                    <!-- Status Badge -->
                    <div class="mt-3">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $user->addresses && $user->addresses->count() > 0 ? 'bg-plyform-mint text-plyform-dark border border-plyform-mint' : 'bg-gray-100 text-gray-600 border border-gray-200' }}" id="address-history-status">
                            @if($user->addresses && $user->addresses->count() > 0)
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
                <div class="flex items-center justify-center w-14 h-14 rounded-full border-4 {{ $user->addresses && $user->addresses->count() > 0 ? 'border-[#5E17EB]' : 'border-gray-300' }} bg-white">
                    <span class="text-sm font-bold {{ $user->addresses && $user->addresses->count() > 0 ? 'text-[#5E17EB]' : 'text-gray-400' }}" id="address-history-percentage">
                        @if($user->addresses && $user->addresses->count() > 0)
                            100%
                        @else
                            0%
                        @endif
                    </span>
                </div>
                
                <!-- Edit Button -->
                <button 
                    type="button" 
                    onclick="toggleAddressHistory()"
                    class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-plyform-purple hover:text-plyform-dark hover:bg-plyform-purple/10 rounded-lg transition"
                    id="address-history-edit-btn"
                >
                    <span>Edit</span>
                    <svg class="w-4 h-4 transition-transform" id="address-history-chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
            </div>
            
        </div>
    </div>
    
    <!-- Expandable Form Content (Hidden by Default) -->
    <div class="border-t border-gray-200 bg-gray-50 hidden" id="address-history-form">
        <form method="POST" action="{{ route('user.profile.update-step') }}" class="p-6 space-y-6">
            @csrf
            <input type="hidden" name="current_step" value="7">
            
            <!-- Address History Section -->
            <div class="bg-white rounded-lg p-6 space-y-4">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h4 class="text-base font-semibold text-plyform-dark">Address History</h4>
                        <p class="text-sm text-gray-600 mt-1">Provide details of your residential history for the past 3 years</p>
                    </div>
                    <span class="text-plyform-orange text-sm font-medium">* Required</span>
                </div>
                
                <!-- Info Box -->
                <div class="p-4 bg-plyform-yellow/10 border border-plyform-yellow/30 rounded-lg mb-6">
                    <div class="flex gap-3">
                        <svg class="w-5 h-5 text-plyform-dark flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-sm text-plyform-dark">
                            <strong>Note:</strong> Please provide at least 3 years of address history. Include your current address and previous addresses.
                        </p>
                    </div>
                </div>
                
                <div id="addresses-container">
                    @php
                        $addresses = old('addresses', $user->addresses->toArray() ?: [['living_arrangement' => '']]);
                    @endphp
                    
                    @foreach($addresses as $index => $address)
                        <div class="address-item p-4 border-2 border-gray-200 rounded-lg mb-4 hover:border-plyform-mint/50 transition-colors" data-index="{{ $index }}">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center gap-2">
                                    <h4 class="font-semibold text-plyform-dark">Address {{ $index + 1 }}</h4>
                                    @if($index === 0)
                                        <span class="px-2 py-1 bg-plyform-mint text-plyform-dark text-xs font-semibold rounded">Current</span>
                                    @endif
                                </div>
                                @if($index > 0)
                                    <button 
                                        type="button" 
                                        onclick="removeAddressItem({{ $index }})"
                                        class="text-plyform-orange hover:text-red-700 text-sm font-medium hover:bg-plyform-orange/10 px-3 py-1 rounded-lg transition-colors"
                                    >
                                        Remove
                                    </button>
                                @endif
                            </div>
                            
                            <!-- Living Arrangement -->
                            <div class="mb-4">
                                <label class="flex items-center gap-2 text-sm font-medium text-plyform-dark mb-2">
                                    Living Arrangement <span class="text-plyform-orange">*</span>
                                </label>
                                <select 
                                    name="addresses[{{ $index }}][living_arrangement]" 
                                    required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-yellow/20 focus:border-plyform-yellow outline-none transition-all"
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
                                <label class="flex items-center gap-2 text-sm font-medium text-plyform-dark mb-2">
                                    Full Address <span class="text-plyform-orange">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    name="addresses[{{ $index }}][address]" 
                                    value="{{ $address['address'] ?? '' }}"
                                    required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-yellow/20 focus:border-plyform-yellow outline-none transition-all"
                                    placeholder="123 Main Street, Sydney NSW 2000"
                                >
                            </div>
                            
                            <!-- Duration -->
                            <div class="grid md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label class="flex items-center gap-2 text-sm font-medium text-plyform-dark mb-2">
                                        Years Lived <span class="text-plyform-orange">*</span>
                                    </label>
                                    <select 
                                        name="addresses[{{ $index }}][years_lived]" 
                                        required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-yellow/20 focus:border-plyform-yellow outline-none transition-all"
                                    >
                                        @for($i = 0; $i <= 20; $i++)
                                            <option value="{{ $i }}" {{ ($address['years_lived'] ?? 0) == $i ? 'selected' : '' }}>{{ $i }} {{ $i === 1 ? 'year' : 'years' }}</option>
                                        @endfor
                                    </select>
                                </div>
                                
                                <div>
                                    <label class="flex items-center gap-2 text-sm font-medium text-plyform-dark mb-2">
                                        Months Lived <span class="text-plyform-orange">*</span>
                                    </label>
                                    <select 
                                        name="addresses[{{ $index }}][months_lived]" 
                                        required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-yellow/20 focus:border-plyform-yellow outline-none transition-all"
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
                                    <label class="flex items-center gap-2 text-sm font-medium text-plyform-dark mb-2">
                                        Reason for Leaving
                                    </label>
                                    <textarea 
                                        name="addresses[{{ $index }}][reason_for_leaving]" 
                                        rows="3"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-yellow/20 focus:border-plyform-yellow outline-none transition-all resize-none"
                                        placeholder="e.g., End of lease, relocated for work, purchased property..."
                                    >{{ $address['reason_for_leaving'] ?? '' }}</textarea>
                                </div>
                            @endif
                            
                            <!-- Different Postal Address -->
                            <div class="mb-4">
                                <label class="flex items-center gap-3 cursor-pointer p-3 rounded-lg hover:bg-plyform-mint/10 transition-colors">
                                    <input 
                                        type="checkbox" 
                                        name="addresses[{{ $index }}][different_postal_address]" 
                                        value="1"
                                        onchange="togglePostalAddress({{ $index }})"
                                        {{ ($address['different_postal_address'] ?? false) ? 'checked' : '' }}
                                        class="w-5 h-5 text-plyform-yellow border-gray-300 rounded focus:ring-plyform-yellow/20"
                                    >
                                    <span class="text-sm text-gray-700 font-medium">My postal address is different from this address</span>
                                </label>
                            </div>
                            
                            <div class="postal-address-field {{ ($address['different_postal_address'] ?? false) ? '' : 'hidden' }}" data-index="{{ $index }}">
                                <label class="text-sm font-medium text-plyform-dark mb-2 block">
                                    Postal Address <span class="text-plyform-orange">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    name="addresses[{{ $index }}][postal_code]" 
                                    value="{{ $address['postal_code'] ?? '' }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-yellow/20 focus:border-plyform-yellow outline-none transition-all"
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
                    onclick="addAddressItem()"
                    class="w-full py-3 border-2 border-dashed border-gray-300 rounded-lg text-gray-600 hover:border-plyform-yellow hover:text-plyform-dark hover:bg-plyform-yellow/5 transition flex items-center justify-center gap-2 font-medium"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Add Previous Address
                </button>
                
            </div>
            
            <!-- Form Actions -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200">
                <button 
                    type="button" 
                    onclick="toggleAddressHistory()"
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
// Initialize address index
var addressIndex = {{ count($addresses ?? []) }};

function toggleAddressHistory() {
    const formDiv = document.getElementById('address-history-form');
    const chevron = document.getElementById('address-history-chevron');
    const editBtn = document.getElementById('address-history-edit-btn');
    
    if (formDiv.classList.contains('hidden')) {
        // Expand
        formDiv.classList.remove('hidden');
        chevron.style.transform = 'rotate(180deg)';
        editBtn.querySelector('span').textContent = 'Close';
        
        // Scroll to card
        setTimeout(() => {
            document.getElementById('address-history-card').scrollIntoView({ 
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

// Toggle postal address field
function togglePostalAddress(index) {
    const checkbox = document.querySelector(`input[name="addresses[${index}][different_postal_address]"]`);
    const postalField = document.querySelector(`.postal-address-field[data-index="${index}"]`);
    
    if (!checkbox || !postalField) {
        return;
    }
    
    const postalInput = postalField.querySelector('input');
    
    if (checkbox.checked) {
        postalField.classList.remove('hidden');
        if (postalInput) postalInput.required = true;
    } else {
        postalField.classList.add('hidden');
        if (postalInput) {
            postalInput.required = false;
            postalInput.value = '';
        }
    }
}

// Add new address
function addAddressItem() {
    const container = document.getElementById('addresses-container');
    
    if (!container) {
        console.error('Container not found!');
        return;
    }
    
    const newAddressHtml = `
        <div class="address-item p-4 border-2 border-gray-200 rounded-lg mb-4 hover:border-plyform-mint/50 transition-colors" data-index="${addressIndex}">
            <div class="flex items-center justify-between mb-4">
                <h4 class="font-semibold text-plyform-dark">Address ${addressIndex + 1}</h4>
                <button type="button" onclick="removeAddressItem(${addressIndex})" class="text-plyform-orange hover:text-red-700 text-sm font-medium hover:bg-plyform-orange/10 px-3 py-1 rounded-lg transition-colors">
                    Remove
                </button>
            </div>
            
            <div class="mb-4">
                <label class="text-sm font-medium text-plyform-dark mb-2 block">Living Arrangement <span class="text-plyform-orange">*</span></label>
                <select name="addresses[${addressIndex}][living_arrangement]" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-yellow/20 focus:border-plyform-yellow outline-none transition-all">
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
                <label class="text-sm font-medium text-plyform-dark mb-2 block">Full Address <span class="text-plyform-orange">*</span></label>
                <input type="text" name="addresses[${addressIndex}][address]" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-yellow/20 focus:border-plyform-yellow outline-none transition-all" placeholder="123 Main Street, Sydney NSW 2000">
            </div>
            
            <div class="grid md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="text-sm font-medium text-plyform-dark mb-2 block">Years Lived <span class="text-plyform-orange">*</span></label>
                    <select name="addresses[${addressIndex}][years_lived]" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-yellow/20 focus:border-plyform-yellow outline-none transition-all">
                        ${Array.from({length: 21}, (_, i) => `<option value="${i}">${i} ${i === 1 ? 'year' : 'years'}</option>`).join('')}
                    </select>
                </div>
                <div>
                    <label class="text-sm font-medium text-plyform-dark mb-2 block">Months Lived <span class="text-plyform-orange">*</span></label>
                    <select name="addresses[${addressIndex}][months_lived]" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-yellow/20 focus:border-plyform-yellow outline-none transition-all">
                        ${Array.from({length: 12}, (_, i) => `<option value="${i}">${i} ${i === 1 ? 'month' : 'months'}</option>`).join('')}
                    </select>
                </div>
            </div>
            
            <div class="mb-4">
                <label class="text-sm font-medium text-plyform-dark mb-2 block">Reason for Leaving</label>
                <textarea name="addresses[${addressIndex}][reason_for_leaving]" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-yellow/20 focus:border-plyform-yellow outline-none transition-all resize-none" placeholder="e.g., End of lease, relocated for work, purchased property..."></textarea>
            </div>
            
            <div class="mb-4">
                <label class="flex items-center gap-3 cursor-pointer p-3 rounded-lg hover:bg-plyform-mint/10 transition-colors">
                    <input type="checkbox" name="addresses[${addressIndex}][different_postal_address]" value="1" onchange="togglePostalAddress(${addressIndex})" class="w-5 h-5 text-plyform-yellow rounded focus:ring-plyform-yellow/20">
                    <span class="text-sm text-gray-700 font-medium">My postal address is different from this address</span>
                </label>
            </div>
            
            <div class="postal-address-field hidden" data-index="${addressIndex}">
                <label class="text-sm font-medium text-plyform-dark mb-2 block">Postal Address <span class="text-plyform-orange">*</span></label>
                <input type="text" name="addresses[${addressIndex}][postal_code]" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-yellow/20 focus:border-plyform-yellow outline-none transition-all" placeholder="PO Box 123, Sydney NSW 2000">
            </div>
        </div>
    `;
    
    container.insertAdjacentHTML('beforeend', newAddressHtml);

    const newElement = container.lastElementChild;
    if (typeof reinitializePlugins === 'function') {
        reinitializePlugins(newElement);
    }
    
    addressIndex++;
}

// Remove address
function removeAddressItem(index) {
    const item = document.querySelector(`.address-item[data-index="${index}"]`);
    if (item) {
        item.remove();
        // Renumber remaining addresses
        document.querySelectorAll('.address-item').forEach((el, idx) => {
            const heading = el.querySelector('h4');
            if (idx === 0) {
                heading.innerHTML = 'Address 1 <span class="px-2 py-1 bg-plyform-mint text-plyform-dark text-xs font-semibold rounded ml-2">Current</span>';
            } else {
                heading.textContent = `Address ${idx + 1}`;
            }
        });
    }
}

// Initialize postal address fields on page load
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('input[name^="addresses"][name$="[different_postal_address]"]').forEach((checkbox) => {
        const match = checkbox.name.match(/addresses\[(\d+)\]/);
        if (match && checkbox.checked) {
            const index = parseInt(match[1]);
            togglePostalAddress(index);
        }
    });
});
</script>