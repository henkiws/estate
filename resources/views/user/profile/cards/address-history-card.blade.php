<!-- Address History Card -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden section-card mb-4" id="address-history-card">
    
    <!-- Card Header - Collapsible Button (Always Visible) -->
    <button type="button" onclick="toggleAddressHistory()" class="w-full px-6 py-4 flex items-center justify-between hover:bg-gray-50 transition">
        <div class="flex items-center gap-3">
            <!-- Status Icon -->
            <div class="w-8 h-8 rounded-full {{ $user->addresses && $user->addresses->count() > 0 ? 'bg-teal-100' : 'bg-gray-100' }} flex items-center justify-center section-status" id="status_address_history">
                @if($user->addresses && $user->addresses->count() > 0)
                    <svg class="w-5 h-5 text-teal-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    </svg>
                @else
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                @endif
            </div>
            
            <!-- Title and Summary -->
            <div class="text-left">
                <span class="font-semibold text-gray-900">Address History</span>
                @if($user->addresses && $user->addresses->count() > 0)
                    <span class="text-xs bg-green-200 text-green-600 px-2 py-0.5 rounded-full font-medium">Completed</span>
                @endif
                <p class="text-xs text-gray-500" id="address-history-summary">
                    @if($user->addresses && $user->addresses->count() > 0)
                        {{ $user->addresses->count() }} {{ Str::plural('address', $user->addresses->count()) }}
                    @else
                        Not completed yet
                    @endif
                </p>
            </div>
        </div>
        
        <!-- Right Side: Percentage + Chevron -->
        <div class="flex items-center gap-4">
            <!-- Completion Percentage Circle -->
            <div class="flex items-center justify-center w-12 h-12 rounded-full border-3 {{ $user->addresses && $user->addresses->count() > 0 ? 'border-teal-600 bg-teal-50' : 'border-gray-300 bg-gray-50' }}" id="address-history-percentage-circle">
                <span class="text-xs font-bold {{ $user->addresses && $user->addresses->count() > 0 ? 'text-teal-600' : 'text-gray-400' }}" id="address-history-percentage">
                    @if($user->addresses && $user->addresses->count() > 0)
                        100%
                    @else
                        0%
                    @endif
                </span>
            </div>
            
            <!-- Chevron Icon -->
            <svg class="w-5 h-5 text-gray-400 section-chevron transition-transform" id="address-history-chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </div>
    </button>
    
    <!-- Expandable Form Content (Hidden by Default) -->
    <div class="section-content hidden px-6 pb-6" id="address-history-form">
        <form method="POST" action="{{ route('user.profile.update-step') }}" class="space-y-6">
            @csrf
            <input type="hidden" name="current_step" value="7">
            <input type="hidden" name="mode" value="{{ $mode }}">
            
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
                <div class="p-4 bg-plyform-green/10 border border-plyform-green/30 rounded-lg mb-6">
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
                        $addresses = old('addresses', $user->addresses->toArray() ?: [['owned_property' => '1']]);
                    @endphp
                    
                    @foreach($addresses as $index => $address)
                        <div class="address-item p-4 border-2 border-gray-200 rounded-lg mb-4 hover:border-plyform-mint/50 transition-colors bg-white" data-index="{{ $index }}">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center gap-3">
                                    <h4 class="font-semibold text-plyform-dark">Address {{ $index + 1 }}</h4>
                                    
                                    @if($index === 0)
                                        <span class="px-2 py-1 bg-plyform-mint text-plyform-dark text-xs font-semibold rounded">Current</span>
                                    @endif
                                    
                                    <!-- ✅ ADD: Reference Status Badge (only for non-owned properties) -->
                                    @if(!($address['owned_property'] ?? true) && !empty($address['reference_status']))
                                        @if($address['reference_status'] === 'verified')
                                            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-green-100 text-green-800">
                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                </svg>
                                                Verified
                                            </span>
                                        @elseif($address['reference_status'] === 'pending')
                                            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-yellow-100 text-yellow-800">
                                                <svg class="w-3 h-3 mr-1 animate-pulse" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                                </svg>
                                                Pending
                                            </span>
                                        @endif
                                    @endif
                                </div>
                                
                                <!-- ✅ UPDATE: Conditional Action Buttons Based on Reference Status -->
                                @php
                                    $isOwned = $address['owned_property'] ?? true;
                                    $isVerified = !$isOwned && ($address['reference_status'] ?? '') === 'verified';
                                    $isPending = !$isOwned && ($address['reference_status'] ?? '') === 'pending';
                                @endphp
                                
                                <div class="flex items-center gap-2 ml-auto">
                                    @if(!$isOwned && $isVerified)
                                        <button type="button" onclick="deleteVerifiedAddress({{ $index }})"
                                            class="text-red-600 hover:text-red-800 text-sm font-medium hover:bg-red-50 px-3 py-1 rounded-lg transition-colors">
                                            Delete
                                        </button>

                                    @elseif(!$isOwned && $isPending)
                                        <button type="button" onclick="confirmEditPendingAddress({{ $index }})"
                                            class="text-blue-600 hover:text-blue-800 text-sm font-medium hover:bg-blue-50 px-3 py-1 rounded-lg transition-colors">
                                            Edit
                                        </button>
                                        @if($index > 0)
                                            <button type="button" onclick="deleteAddress({{ $index }})"
                                                class="text-red-600 hover:text-red-800 text-sm font-medium hover:bg-red-50 px-3 py-1 rounded-lg transition-colors">
                                                Delete
                                            </button>
                                        @endif

                                    @else
                                        @if($index > 0)
                                            <button type="button" onclick="removeAddressItem({{ $index }})"
                                                class="text-plyform-orange hover:text-red-700 text-sm font-medium hover:bg-plyform-orange/10 px-3 py-1 rounded-lg transition-colors">
                                                Remove
                                            </button>
                                        @endif
                                    @endif
                                </div>
                            </div>
                            
                            <!-- ✅ ADD: Hidden ID field -->
                            <input type="hidden" name="addresses[{{ $index }}][id]" value="{{ $address['id'] ?? '' }}">
                            
                            <!-- ✅ ADD: Make fields readonly if verified -->
                            @php
                                $readonlyAttr = ($isVerified || $isPending) ? 'readonly' : '';
                                $disabledAttr = ($isVerified || $isPending) ? 'disabled' : '';
                                $disabledClass = ($isVerified || $isPending) ? 'bg-gray-100 cursor-not-allowed' : '';
                            @endphp
                            
                            <!-- Full Address -->
                            <div class="mb-4">
                                <label class="flex items-center gap-2 text-sm font-medium text-plyform-dark mb-2">
                                    Address <span class="text-plyform-orange">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    name="addresses[{{ $index }}][address]" 
                                    value="{{ $address['address'] ?? '' }}"
                                    {{ $readonlyAttr }}
                                    required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all {{ $disabledClass }}"
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
                                        {{ $disabledAttr }}
                                        required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all {{ $disabledClass }}"
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
                                        {{ $disabledAttr }}
                                        required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all {{ $disabledClass }}"
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
                                        {{ $readonlyAttr }}
                                        rows="3"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all resize-none {{ $disabledClass }}"
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
                                        {{ $disabledAttr }}
                                        onchange="togglePostalAddress({{ $index }})"
                                        {{ ($address['different_postal_address'] ?? false) ? 'checked' : '' }}
                                        class="w-5 h-5 text-plyform-green border-gray-300 rounded focus:ring-plyform-green/20 {{ $isVerified ? 'cursor-not-allowed' : '' }}"
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
                                    {{ $readonlyAttr }}
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all {{ $disabledClass }}"
                                    placeholder="PO Box 123, Sydney NSW 2000"
                                >
                            </div>
                            
                            <!-- Is Current Address -->
                            @if($index === 0)
                                <input type="hidden" name="addresses[{{ $index }}][is_current]" value="1">
                            @endif

                            <!-- Did you own the property? -->
                            <div class="mb-4">
                                <label class="text-sm font-medium text-plyform-dark mb-3 block">
                                    Did you own the property? <span class="text-plyform-orange">*</span>
                                </label>
                                <div class="flex gap-0 bg-gray-100 rounded-lg p-1 w-fit {{ $isVerified ? 'opacity-50 pointer-events-none' : '' }}">
                                    <label class="relative cursor-pointer">
                                        <input 
                                            type="radio" 
                                            name="addresses[{{ $index }}][owned_property]" 
                                            value="1"
                                            {{ $disabledAttr }}
                                            onchange="toggleOwnership({{ $index }}, true)"
                                            {{ ($address['owned_property'] ?? '1') == '1' ? 'checked' : '' }}
                                            class="sr-only peer"
                                        >
                                        <div class="px-6 py-2 rounded-md text-sm font-semibold transition-all
                                            peer-checked:bg-white peer-checked:text-plyform-dark peer-checked:shadow-sm
                                            text-gray-600">
                                            Yes
                                        </div>
                                    </label>
                                    <label class="relative cursor-pointer">
                                        <input 
                                            type="radio" 
                                            name="addresses[{{ $index }}][owned_property]" 
                                            value="0"
                                            {{ $disabledAttr }}
                                            onchange="toggleOwnership({{ $index }}, false)"
                                            {{ ($address['owned_property'] ?? '1') == '0' ? 'checked' : '' }}
                                            class="sr-only peer"
                                        >
                                        <div class="px-6 py-2 rounded-md text-sm font-semibold transition-all
                                            peer-checked:bg-gray-700 peer-checked:text-white peer-checked:shadow-sm
                                            text-gray-600">
                                            No
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <!-- Address Reference Section (shown when owned_property = 0) -->
                            <div class="address-reference-section {{ ($address['owned_property'] ?? '1') == '0' ? '' : 'hidden' }}" data-index="{{ $index }}">
                                <div class="bg-gray-50 rounded-lg p-4 space-y-4 border border-gray-200">
                                    <div class="flex items-start gap-2 mb-3">
                                        <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <div>
                                            <h5 class="text-sm font-semibold text-plyform-dark">Address reference</h5>
                                            <p class="text-xs text-gray-600 mt-1">You must have this person's consent to provide their personal information and be contacted by us and/or the relevant agency during business hours.</p>
                                            <p class="text-xs text-blue-700 mt-2">
                                                <strong>📧 After saving,</strong> your address reference will get an email and SMS to confirm your address history and add their answers to your Renter Profile. If you prefer they don't know your plans, add these details later.
                                            </p>
                                        </div>
                                    </div>

                                    <!-- Reference Type -->
                                    <div>
                                        <label class="text-sm font-medium text-plyform-dark mb-2 block">
                                            Reference type <span class="text-plyform-orange">*</span>
                                        </label>
                                        <select 
                                            name="addresses[{{ $index }}][living_arrangement]" 
                                            {{ $disabledAttr }}
                                            class="address-reference-input w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all {{ $disabledClass }}"
                                            {{ ($address['owned_property'] ?? '1') == '0' ? 'required' : '' }}
                                        >
                                            <option value="">Please select</option>
                                            <option value="property_manager" {{ ($address['living_arrangement'] ?? '') == 'property_manager' ? 'selected' : '' }}>Property Manager</option>
                                            <option value="private_landlord" {{ ($address['living_arrangement'] ?? '') == 'private_landlord' ? 'selected' : '' }}>Private Landlord</option>
                                            <option value="parents" {{ ($address['living_arrangement'] ?? '') == 'parents' ? 'selected' : '' }}>Parents</option>
                                            <option value="other" {{ ($address['living_arrangement'] ?? '') == 'other' ? 'selected' : '' }}>Other</option>
                                        </select>
                                    </div>

                                    <!-- Full Name -->
                                    <div>
                                        <label class="text-sm font-medium text-plyform-dark mb-2 block">
                                            Full name <span class="text-plyform-orange">*</span>
                                        </label>
                                        <input 
                                            type="text" 
                                            name="addresses[{{ $index }}][reference_full_name]" 
                                            value="{{ $address['reference_full_name'] ?? '' }}"
                                            {{ $readonlyAttr }}
                                            class="address-reference-input w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all {{ $disabledClass }}"
                                            placeholder="First and last name"
                                            {{ ($address['owned_property'] ?? '1') == '0' ? 'required' : '' }}
                                        >
                                    </div>

                                    <!-- Email -->
                                    <div>
                                        <label class="text-sm font-medium text-plyform-dark mb-2 flex items-center gap-2">
                                            Email 
                                            <span class="text-plyform-orange">*</span>
                                            <svg class="w-4 h-4 text-gray-400 cursor-help" fill="none" stroke="currentColor" viewBox="0 0 24 24" title="We'll send an email to confirm address history">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                        </label>
                                        <input 
                                            type="email" 
                                            name="addresses[{{ $index }}][reference_email]" 
                                            value="{{ $address['reference_email'] ?? '' }}"
                                            {{ $readonlyAttr }}
                                            class="address-reference-input w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all {{ $disabledClass }}"
                                            placeholder="email@example.com"
                                            {{ ($address['owned_property'] ?? '1') == '0' ? 'required' : '' }}
                                        >
                                    </div>

                                    <!-- Phone Number -->
                                    <div>
                                        <label class="text-sm font-medium text-plyform-dark mb-2 block">
                                            Phone number <span class="text-plyform-orange">*</span>
                                        </label>
                                        <input 
                                            type="tel" 
                                            id="address_reference_phone_{{ $index }}" 
                                            name="addresses[{{ $index }}][reference_phone_display]"
                                            value="{{ $address['reference_phone'] ?? '' }}"
                                            {{ $readonlyAttr }}
                                            class="address-reference-input address-reference-phone w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all {{ $disabledClass }}"
                                            placeholder="Mobile or Landline"
                                            {{ ($address['owned_property'] ?? '1') == '0' ? 'required' : '' }}
                                        >
                                        <input type="hidden" id="address_reference_country_code_{{ $index }}" name="addresses[{{ $index }}][reference_country_code]" value="{{ $address['reference_country_code'] ?? '+61' }}">
                                        <input type="hidden" id="address_reference_phone_clean_{{ $index }}" name="addresses[{{ $index }}][reference_phone]" value="{{ $address['reference_phone'] ?? '' }}">
                                        <p class="text-xs text-gray-500 mt-1">To confirm your address history, we'll send your referee a SMS & email.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Add Address Button -->
                <button 
                    type="button" 
                    onclick="addAddressItem()"
                    class="w-full py-3 border-2 border-dashed border-gray-300 rounded-lg text-gray-600 hover:border-plyform-green hover:text-plyform-dark hover:bg-plyform-green/5 transition flex items-center justify-center gap-2 font-medium"
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

<!-- ===================== ADDRESS HISTORY CONFIRM MODALS ===================== -->

<!-- 1. Delete Verified Address Modal (strongest warning) -->
<div id="modal-delete-verified-address" class="fixed inset-0 z-50 flex items-center justify-center hidden" role="dialog" aria-modal="true">
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" onclick="closeModal('modal-delete-verified-address')"></div>
    <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-sm mx-4 overflow-hidden animate-modal-in">
        <div class="h-1.5 w-full bg-gradient-to-r from-red-500 to-rose-600"></div>
        <div class="p-7">
            <div class="flex items-center justify-center mb-4">
                <div class="w-14 h-14 rounded-full bg-red-50 flex items-center justify-center">
                    <svg class="w-7 h-7 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                    </svg>
                </div>
            </div>
            <h3 class="text-lg font-bold text-center text-gray-900 mb-2">Delete Verified Address?</h3>
            <p class="text-sm text-center text-gray-500 mb-4">This address has been <span class="font-semibold text-green-700">✓ verified</span>. Deleting it is permanent and irreversible.</p>
            <div class="bg-red-50 border border-red-200 rounded-lg px-4 py-3 mb-6 text-xs text-red-700 space-y-1">
                <p class="font-semibold">⚠️ Warning — this will permanently:</p>
                <p>• Remove the verified address record</p>
                <p>• Lose the reference verification permanently</p>
            </div>
            <div class="flex gap-3">
                <button type="button" onclick="closeModal('modal-delete-verified-address')" class="flex-1 px-4 py-2.5 rounded-xl border-2 border-gray-200 text-gray-700 font-semibold text-sm hover:bg-gray-50 transition">Keep It</button>
                <button type="button" onclick="fireModalCallback('modal-delete-verified-address')" class="flex-1 px-4 py-2.5 rounded-xl bg-red-600 hover:bg-red-700 text-white font-semibold text-sm transition shadow-sm">Yes, Delete</button>
            </div>
        </div>
    </div>
</div>

<!-- 2. Delete Pending Address Modal -->
<div id="modal-delete-pending-address" class="fixed inset-0 z-50 flex items-center justify-center hidden" role="dialog" aria-modal="true">
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" onclick="closeModal('modal-delete-pending-address')"></div>
    <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-sm mx-4 overflow-hidden animate-modal-in">
        <div class="h-1.5 w-full bg-gradient-to-r from-yellow-400 to-orange-400"></div>
        <div class="p-7">
            <div class="flex items-center justify-center mb-4">
                <div class="w-14 h-14 rounded-full bg-yellow-50 flex items-center justify-center">
                    <svg class="w-7 h-7 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>
            <h3 class="text-lg font-bold text-center text-gray-900 mb-2">Delete Pending Address?</h3>
            <p class="text-sm text-center text-gray-500 mb-4">The pending reference request will be <strong class="text-gray-700">cancelled</strong> and cannot be recovered.</p>
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg px-4 py-3 mb-6 text-xs text-yellow-800 text-center">
                ⏱ The reference request email will be expired immediately.
            </div>
            <div class="flex gap-3">
                <button type="button" onclick="closeModal('modal-delete-pending-address')" class="flex-1 px-4 py-2.5 rounded-xl border-2 border-gray-200 text-gray-700 font-semibold text-sm hover:bg-gray-50 transition">Cancel</button>
                <button type="button" onclick="fireModalCallback('modal-delete-pending-address')" class="flex-1 px-4 py-2.5 rounded-xl bg-red-500 hover:bg-red-600 text-white font-semibold text-sm transition shadow-sm">Delete</button>
            </div>
        </div>
    </div>
</div>

<!-- 3. Edit Pending Address Modal (resend warning) -->
<div id="modal-edit-pending-address" class="fixed inset-0 z-50 flex items-center justify-center hidden" role="dialog" aria-modal="true">
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" onclick="closeModal('modal-edit-pending-address')"></div>
    <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-sm mx-4 overflow-hidden animate-modal-in">
        <div class="h-1.5 w-full bg-gradient-to-r from-blue-500 to-indigo-500"></div>
        <div class="p-7">
            <div class="flex items-center justify-center mb-4">
                <div class="w-14 h-14 rounded-full bg-blue-50 flex items-center justify-center">
                    <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
            </div>
            <h3 class="text-lg font-bold text-center text-gray-900 mb-2">Edit & Resend Reference?</h3>
            <p class="text-sm text-center text-gray-500 mb-4">Making any changes will trigger a <strong class="text-gray-700">new reference request</strong> to be sent.</p>
            <div class="bg-blue-50 border border-blue-200 rounded-lg px-4 py-3 mb-6 text-xs text-blue-800 space-y-1">
                <p class="font-semibold">📧 What happens next:</p>
                <p>• The previous reference link will expire</p>
                <p>• A new email & SMS will be sent to your referee</p>
                <p>• Status resets to "Pending" until re-verified</p>
            </div>
            <div class="flex gap-3">
                <button type="button" onclick="closeModal('modal-edit-pending-address')" class="flex-1 px-4 py-2.5 rounded-xl border-2 border-gray-200 text-gray-700 font-semibold text-sm hover:bg-gray-50 transition">Cancel</button>
                <button type="button" onclick="fireModalCallback('modal-edit-pending-address')" class="flex-1 px-4 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm transition shadow-sm flex items-center justify-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    Yes, Edit
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ===================== END MODALS ===================== -->

<script>
// Initialize address index
var addressIndex = {{ count($addresses ?? []) }};

function toggleAddressHistory() {
    const formDiv = document.getElementById('address-history-form');
    const chevron = document.getElementById('address-history-chevron');
    
    if (formDiv.classList.contains('hidden')) {
        // Expand
        formDiv.classList.remove('hidden');
        chevron.style.transform = 'rotate(90deg)';
        
        // Scroll to card
        setTimeout(() => {
            document.getElementById('address-history-card')?.scrollIntoView({ 
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

// Toggle ownership function
function toggleOwnership(index, isOwned) {
    const referenceSection = document.querySelector(`.address-reference-section[data-index="${index}"]`);
    const referenceInputs = referenceSection.querySelectorAll('.address-reference-input');
    
    if (isOwned) {
        // If owned = YES, hide reference section and remove required
        referenceSection.classList.add('hidden');
        referenceInputs.forEach(input => {
            input.required = false;
        });
    } else {
        // If owned = NO, show reference section and add required
        referenceSection.classList.remove('hidden');
        referenceInputs.forEach(input => {
            input.required = true;
        });
        
        // Initialize phone input for this address if not already initialized
        initializeAddressReferencePhone(index);
    }
}

// Initialize address reference phone inputs
function initializeAddressReferencePhone(index) {
    const phoneInput = document.getElementById('address_reference_phone_' + index);
    
    if (phoneInput && !phoneInput._iti) {
        const iti = window.intlTelInput(phoneInput, {
            initialCountry: "au",
            preferredCountries: ["au", "us", "gb", "nz", "sg", "my", "id", "ph"],
            separateDialCode: true,
            nationalMode: false,
            autoPlaceholder: "polite",
            formatOnDisplay: true,
            customPlaceholder: function(selectedCountryPlaceholder, selectedCountryData) {
                return "e.g. " + selectedCountryPlaceholder;
            },
            utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@19.5.6/build/js/utils.js"
        });
        
        phoneInput._iti = iti;
        
        // Set initial value if exists
        const existingCountryCode = document.getElementById('address_reference_country_code_' + index).value;
        const existingNumber = document.getElementById('address_reference_phone_clean_' + index).value;
        
        if (existingCountryCode && existingNumber) {
            const countryCode = existingCountryCode.replace('+', '');
            const allCountries = window.intlTelInputGlobals.getCountryData();
            const countryData = allCountries.find(country => country.dialCode === countryCode);
            if (countryData) {
                iti.setCountry(countryData.iso2);
            }
            phoneInput.value = existingNumber;
        }
        
        phoneInput.addEventListener('blur', function() {
            updateAddressReferencePhone(index);
        });
        
        phoneInput.addEventListener('countrychange', function() {
            updateAddressReferencePhone(index);
        });
    }
}

function updateAddressReferencePhone(index) {
    const phoneInput = document.getElementById('address_reference_phone_' + index);
    if (!phoneInput || !phoneInput._iti) return;
    
    const iti = phoneInput._iti;
    const countryData = iti.getSelectedCountryData();
    document.getElementById('address_reference_country_code_' + index).value = '+' + countryData.dialCode;
    const fullNumber = iti.getNumber();
    const numberWithoutCode = fullNumber.replace('+' + countryData.dialCode, '').trim();
    document.getElementById('address_reference_phone_clean_' + index).value = numberWithoutCode;
}

// Add new address
function addAddressItem() {
    const container = document.getElementById('addresses-container');
    
    if (!container) {
        console.error('Container not found!');
        return;
    }
    
    const newAddressHtml = `
        <div class="address-item p-4 border-2 border-gray-200 rounded-lg mb-4 hover:border-plyform-mint/50 transition-colors bg-white" data-index="${addressIndex}">
            <div class="flex items-center justify-between mb-4">
                <h4 class="font-semibold text-plyform-dark">Address ${addressIndex + 1}</h4>
                <button type="button" onclick="removeAddressItem(${addressIndex})" class="text-plyform-orange hover:text-red-700 text-sm font-medium hover:bg-plyform-orange/10 px-3 py-1 rounded-lg transition-colors">
                    Remove
                </button>
            </div>
            
            <div class="mb-4">
                <label class="text-sm font-medium text-plyform-dark mb-2 block">Address <span class="text-plyform-orange">*</span></label>
                <input type="text" name="addresses[${addressIndex}][address]" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all" placeholder="123 Main Street, Sydney NSW 2000">
            </div>
            
            <div class="grid md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="text-sm font-medium text-plyform-dark mb-2 block">Years Lived <span class="text-plyform-orange">*</span></label>
                    <select name="addresses[${addressIndex}][years_lived]" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all">
                        ${Array.from({length: 21}, (_, i) => `<option value="${i}">${i} ${i === 1 ? 'year' : 'years'}</option>`).join('')}
                    </select>
                </div>
                <div>
                    <label class="text-sm font-medium text-plyform-dark mb-2 block">Months Lived <span class="text-plyform-orange">*</span></label>
                    <select name="addresses[${addressIndex}][months_lived]" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all">
                        ${Array.from({length: 12}, (_, i) => `<option value="${i}">${i} ${i === 1 ? 'month' : 'months'}</option>`).join('')}
                    </select>
                </div>
            </div>
            
            <div class="mb-4">
                <label class="text-sm font-medium text-plyform-dark mb-2 block">Reason for Leaving</label>
                <textarea name="addresses[${addressIndex}][reason_for_leaving]" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all resize-none" placeholder="e.g., End of lease, relocated for work, purchased property..."></textarea>
            </div>
            
            <div class="mb-4">
                <label class="flex items-center gap-3 cursor-pointer p-3 rounded-lg hover:bg-plyform-mint/10 transition-colors">
                    <input type="checkbox" name="addresses[${addressIndex}][different_postal_address]" value="1" onchange="togglePostalAddress(${addressIndex})" class="w-5 h-5 text-plyform-green rounded focus:ring-plyform-green/20">
                    <span class="text-sm text-gray-700 font-medium">My postal address is different from this address</span>
                </label>
            </div>
            
            <div class="postal-address-field hidden" data-index="${addressIndex}">
                <label class="text-sm font-medium text-plyform-dark mb-2 block">Postal Address <span class="text-plyform-orange">*</span></label>
                <input type="text" name="addresses[${addressIndex}][postal_code]" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all" placeholder="PO Box 123, Sydney NSW 2000">
            </div>
            
            <div class="mb-4">
                <label class="text-sm font-medium text-plyform-dark mb-3 block">Did you own the property? <span class="text-plyform-orange">*</span></label>
                <div class="flex gap-0 bg-gray-100 rounded-lg p-1 w-fit">
                    <label class="relative cursor-pointer">
                        <input type="radio" name="addresses[${addressIndex}][owned_property]" value="1" checked onchange="toggleOwnership(${addressIndex}, true)" class="sr-only peer">
                        <div class="px-6 py-2 rounded-md text-sm font-semibold transition-all peer-checked:bg-white peer-checked:text-plyform-dark peer-checked:shadow-sm text-gray-600">Yes</div>
                    </label>
                    <label class="relative cursor-pointer">
                        <input type="radio" name="addresses[${addressIndex}][owned_property]" value="0" onchange="toggleOwnership(${addressIndex}, false)" class="sr-only peer">
                        <div class="px-6 py-2 rounded-md text-sm font-semibold transition-all peer-checked:bg-gray-700 peer-checked:text-white peer-checked:shadow-sm text-gray-600">No</div>
                    </label>
                </div>
            </div>

            <div class="address-reference-section hidden" data-index="${addressIndex}">
                <div class="bg-gray-50 rounded-lg p-4 space-y-4 border border-gray-200">
                    <div class="flex items-start gap-2 mb-3">
                        <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div>
                            <h5 class="text-sm font-semibold text-plyform-dark">Address reference</h5>
                            <p class="text-xs text-gray-600 mt-1">You must have this person's consent to provide their personal information and be contacted by us and/or the relevant agency during business hours.</p>
                            <p class="text-xs text-blue-700 mt-2"><strong>📧 After saving,</strong> your address reference will get an email and SMS to confirm your address history and add their answers to your Renter Profile. If you prefer they don't know your plans, add these details later.</p>
                        </div>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-plyform-dark mb-2 block">Reference type <span class="text-plyform-orange">*</span></label>
                        <select name="addresses[${addressIndex}][living_arrangement]" class="address-reference-input w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all">
                            <option value="">Please select</option>
                            <option value="property_manager">Property Manager</option>
                            <option value="private_landlord">Private Landlord</option>
                            <option value="parents">Parents</option>
                            <option value="other">Other</option>
                        </select>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-plyform-dark mb-2 block">Full name <span class="text-plyform-orange">*</span></label>
                        <input type="text" name="addresses[${addressIndex}][reference_full_name]" class="address-reference-input w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all" placeholder="First and last name">
                    </div>

                    <div>
                        <label class="text-sm font-medium text-plyform-dark mb-2 flex items-center gap-2">Email <span class="text-plyform-orange">*</span>
                            <svg class="w-4 h-4 text-gray-400 cursor-help" fill="none" stroke="currentColor" viewBox="0 0 24 24" title="We'll send an email to confirm address history">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </label>
                        <input type="email" name="addresses[${addressIndex}][reference_email]" class="address-reference-input w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all" placeholder="email@example.com">
                    </div>

                    <div>
                        <label class="text-sm font-medium text-plyform-dark mb-2 block">Phone number <span class="text-plyform-orange">*</span></label>
                        <input type="tel" id="address_reference_phone_${addressIndex}" name="addresses[${addressIndex}][reference_phone_display]" class="address-reference-input address-reference-phone w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all" placeholder="Mobile or Landline">
                        <input type="hidden" id="address_reference_country_code_${addressIndex}" name="addresses[${addressIndex}][reference_country_code]" value="+61">
                        <input type="hidden" id="address_reference_phone_clean_${addressIndex}" name="addresses[${addressIndex}][reference_phone]">
                        <p class="text-xs text-gray-500 mt-1">To confirm your address history, we'll send your referee a SMS & email.</p>
                    </div>
                </div>
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

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    // Initialize postal address fields
    document.querySelectorAll('input[name^="addresses"][name$="[different_postal_address]"]').forEach((checkbox) => {
        const match = checkbox.name.match(/addresses\[(\d+)\]/);
        if (match && checkbox.checked) {
            const index = parseInt(match[1]);
            togglePostalAddress(index);
        }
    });

    // Initialize all address reference phones on page load
    document.querySelectorAll('.address-reference-phone').forEach(function(phoneInput) {
        const match = phoneInput.id.match(/address_reference_phone_(\d+)/);
        if (match) {
            const index = match[1];
            const ownershipNo = document.querySelector(`input[name="addresses[${index}][owned_property]"][value="0"]`);
            if (ownershipNo && ownershipNo.checked) {
                initializeAddressReferencePhone(index);
            }
        }
    });
});

// ── Helper: remove address item and renumber ───────────────────────────────
function _removeAddressAndRenumber(index) {
    const item = document.querySelector(`.address-item[data-index="${index}"]`);
    if (item) {
        item.remove();
        document.querySelectorAll('.address-item').forEach((el, idx) => {
            const heading = el.querySelector('h4');
            if (heading) {
                if (idx === 0) {
                    heading.innerHTML = 'Address 1 <span class="px-2 py-1 bg-plyform-mint text-plyform-dark text-xs font-semibold rounded ml-2">Current</span>';
                } else {
                    heading.textContent = `Address ${idx + 1}`;
                }
            }
        });
    }
}

function deleteVerifiedAddress(index) {
    openModal('modal-delete-verified-address', () => {
        _removeAddressAndRenumber(index);
    });
}

function deleteAddress(index) {
    openModal('modal-delete-pending-address', () => {
        _removeAddressAndRenumber(index);
    });
}

function confirmEditPendingAddress(index) {
    openModal('modal-edit-pending-address', () => {
        const item = document.querySelector(`.address-item[data-index="${index}"]`);
        if (!item) return;

        // Remove readonly from all inputs/textareas/selects
        item.querySelectorAll('input[readonly], textarea[readonly], select[readonly]').forEach(field => {
            field.removeAttribute('readonly');
            field.classList.remove('bg-gray-100', 'cursor-not-allowed');
        });

        // Re-enable disabled fields
        item.querySelectorAll('input[disabled], select[disabled], textarea[disabled]').forEach(field => {
            field.removeAttribute('disabled');
            field.classList.remove('bg-gray-100', 'cursor-not-allowed', 'opacity-50', 'pointer-events-none');
        });

        // Re-enable ownership toggle wrapper
        const ownershipWrapper = item.querySelector('.pointer-events-none');
        if (ownershipWrapper) {
            ownershipWrapper.classList.remove('opacity-50', 'pointer-events-none');
        }

        // Show notification if available
        if (typeof showNotification === 'function') {
            showNotification('Fields are now editable. A new reference email & SMS will be sent when you save.', 'warning');
        }

        // Disable the edit button to prevent double-click
        const editBtn = item.querySelector('button[onclick*="confirmEditPendingAddress"]');
        if (editBtn) {
            editBtn.textContent = 'Editing...';
            editBtn.classList.add('opacity-50', 'cursor-not-allowed');
            editBtn.disabled = true;
        }
    });
}
</script>