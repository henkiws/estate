<!-- Personal Details Card -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden section-card mb-4" id="personal-details-card">
    
    <!-- Card Header - Collapsible Button (Always Visible) -->
    <button type="button" onclick="togglePersonalDetails()" class="w-full px-6 py-4 flex items-center justify-between hover:bg-gray-50 transition">
        <div class="flex items-center gap-3">
            <!-- Status Icon -->
            <div class="w-8 h-8 rounded-full {{ $profile && $profile->first_name ? 'bg-teal-100' : 'bg-gray-100' }} flex items-center justify-center section-status" id="status_personal_details">
                @if($profile && $profile->first_name)
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
                <span class="font-semibold text-gray-900">Personal Details</span>
                @if($profile && $profile->first_name)
                    <span class="text-xs bg-green-200 text-green-600 px-2 py-0.5 rounded-full font-medium">Completed</span>
                @endif
                <p class="text-xs text-gray-500" id="personal-details-summary">
                    @if($profile && $profile->first_name)
                        {{ $profile->title }} {{ $profile->first_name }} {{ $profile->last_name }}
                    @else
                        Not completed yet
                    @endif
                </p>
            </div>
        </div>
        
        <!-- Right Side: Percentage + Chevron -->
        <div class="flex items-center gap-4">
            <!-- Completion Percentage Circle -->
            <div class="flex items-center justify-center w-12 h-12 rounded-full border-3 {{ $profile && $profile->first_name ? 'border-teal-600 bg-teal-50' : 'border-gray-300 bg-gray-50' }}" id="personal-details-percentage-circle">
                <span class="text-xs font-bold {{ $profile && $profile->first_name ? 'text-teal-600' : 'text-gray-400' }}" id="personal-details-percentage">
                    @if($profile && $profile->first_name)
                        100%
                    @else
                        0%
                    @endif
                </span>
            </div>
            
            <!-- Chevron Icon -->
            <svg class="w-5 h-5 text-gray-400 section-chevron transition-transform" id="personal-details-chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </div>
    </button>
    
    <!-- Expandable Form Content (Hidden by Default) -->
    <div class="section-content hidden px-6 pb-6" id="personal-details-form">
        <form method="POST" action="{{ route('user.profile.update-step') }}" class="space-y-6">
            @csrf
            <input type="hidden" name="current_step" value="1">
            <input type="hidden" name="mode" value="{{ $mode }}">
            
            <!-- Personal Details Section -->
            <div class="bg-white rounded-lg space-y-4">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h4 class="text-base font-semibold text-plyform-dark">Personal Details</h4>
                        <p class="text-sm text-gray-600 mt-1">Your legal name as it appears on official documents</p>
                    </div>
                    <span class="text-plyform-orange text-sm font-medium">* Required</span>
                </div>
                
                <div class="grid md:grid-cols-3 gap-4">
                    
                    <!-- Title -->
                    <div>
                        <label class="flex items-center gap-2 text-sm font-medium text-plyform-dark mb-2">
                            Title <span class="text-plyform-orange">*</span>
                        </label>
                        <select 
                            name="title" 
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all @error('title') border-red-500 @enderror"
                        >
                            <option value="">Select title</option>
                            <option value="Mr" {{ old('title', $profile->title ?? '') == 'Mr' ? 'selected' : '' }}>Mr</option>
                            <option value="Mrs" {{ old('title', $profile->title ?? '') == 'Mrs' ? 'selected' : '' }}>Mrs</option>
                            <option value="Ms" {{ old('title', $profile->title ?? '') == 'Ms' ? 'selected' : '' }}>Ms</option>
                            <option value="Miss" {{ old('title', $profile->title ?? '') == 'Miss' ? 'selected' : '' }}>Miss</option>
                            <option value="Dr" {{ old('title', $profile->title ?? '') == 'Dr' ? 'selected' : '' }}>Dr</option>
                            <option value="Prof" {{ old('title', $profile->title ?? '') == 'Prof' ? 'selected' : '' }}>Prof</option>
                            <option value="Other" {{ old('title', $profile->title ?? '') == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- First Name -->
                    <div class="md:col-span-2">
                        <label class="flex items-center gap-2 text-sm font-medium text-plyform-dark mb-2">
                            First Name <span class="text-plyform-orange">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="first_name" 
                            value="{{ old('first_name', $profile->first_name ?? '') }}"
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all @error('first_name') border-red-500 @enderror"
                            placeholder="Enter your first name"
                        >
                        @error('first_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                </div>
                
                <div class="grid md:grid-cols-2 gap-4">
                    
                    <!-- Middle Name -->
                    <div>
                        <label class="flex items-center gap-2 text-sm font-medium text-plyform-dark mb-2">
                            Middle Name
                        </label>
                        <input 
                            type="text" 
                            name="middle_name" 
                            value="{{ old('middle_name', $profile->middle_name ?? '') }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all @error('middle_name') border-red-500 @enderror"
                            placeholder="Enter your middle name (optional)"
                        >
                        @error('middle_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Last Name -->
                    <div>
                        <label class="flex items-center gap-2 text-sm font-medium text-plyform-dark mb-2">
                            Last Name <span class="text-plyform-orange">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="last_name" 
                            value="{{ old('last_name', $profile->last_name ?? '') }}"
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all @error('last_name') border-red-500 @enderror"
                            placeholder="Enter your last name"
                        >
                        @error('last_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                </div>
                
                <div class="grid md:grid-cols-2 gap-4">
                    
                    <!-- Surname -->
                    <div class="hidden">
                        <label class="flex items-center gap-2 text-sm font-medium text-plyform-dark mb-2">
                            Surname
                        </label>
                        <input 
                            type="text" 
                            name="surname" 
                            value="{{ old('surname', $profile->surname ?? '') }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all @error('surname') border-red-500 @enderror"
                            placeholder="Enter surname (if applicable)"
                        >
                        @error('surname')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Date of Birth -->
                    <div>
                        <label class="flex items-center gap-2 text-sm font-medium text-plyform-dark mb-2">
                            Date of Birth <span class="text-plyform-orange">*</span>
                        </label>
                        <input 
                            type="date" 
                            name="date_of_birth" 
                            value="{{ old('date_of_birth', $profile->date_of_birth ? $profile->date_of_birth->format('Y-m-d') : '') }}"
                            required
                            max="{{ now()->subYears(18)->format('Y-m-d') }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all @error('date_of_birth') border-red-500 @enderror"
                        >
                        @error('date_of_birth')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                </div>
                
            </div>
            
            <!-- Contact Information Section -->
            <div class="bg-white rounded-lg space-y-4">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h4 class="text-base font-semibold text-plyform-dark">Contact Information</h4>
                        <p class="text-sm text-gray-600 mt-1">How property managers can reach you</p>
                    </div>
                    <span class="text-plyform-orange text-sm font-medium">* Required</span>
                </div>
                
                <!-- Email Address -->
                <div>
                    <label class="flex items-center gap-2 text-sm font-medium text-plyform-dark mb-2">
                        Email Address <span class="text-plyform-orange">*</span>
                    </label>
                    <input 
                        type="email" 
                        name="email" 
                        value="{{ old('email', $profile->email ?? auth()->user()->email) }}"
                        required
                        readonly
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50 text-gray-600 cursor-not-allowed @error('email') border-red-500 @enderror"
                        placeholder="your.email@example.com"
                    >
                    <p class="mt-1 text-xs text-gray-500">Email cannot be changed here. Contact support if you need to update it.</p>
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Mobile Number -->
                <div>
                    <label class="flex items-center gap-2 text-sm font-medium text-plyform-dark mb-2">
                        Mobile Number <span class="text-plyform-orange">*</span>
                    </label>
                    
                    <input 
                        type="tel" 
                        id="mobile_number" 
                        name="mobile_number_display"
                        value="{{ old('mobile_number', $profile->mobile_number ?? '') }}"
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all @error('mobile_number') border-red-500 @enderror"
                        placeholder="Enter phone number"
                    >
                    
                    <!-- Hidden fields for country code and number -->
                    <input type="hidden" id="mobile_country_code" name="mobile_country_code" value="{{ old('mobile_country_code', $profile->mobile_country_code ?? '+61') }}">
                    <input type="hidden" id="mobile_number_clean" name="mobile_number" value="{{ old('mobile_number', $profile->mobile_number ?? '') }}">
                    
                    @error('mobile_country_code')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    @error('mobile_number')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Select your country and enter your mobile number</p>
                </div>
                
            </div>
            
            <!-- Emergency Contact Section -->
            <div class="bg-white rounded-lg space-y-4">
                <div class="mb-4">
                    <h4 class="text-base font-semibold text-plyform-dark">Emergency Contact</h4>
                    <p class="text-sm text-gray-600 mt-1">Someone we can contact in case of emergency</p>
                </div>
                
                <!-- Has Emergency Contact Toggle -->
                <div class="mb-4">
                    <label class="flex items-center gap-3 cursor-pointer p-3 rounded-lg hover:bg-plyform-mint/10 transition-colors">
                        <div class="relative">
                            <input 
                                type="checkbox" 
                                name="has_emergency_contact" 
                                id="has_emergency_contact"
                                value="1"
                                {{ old('has_emergency_contact', $profile->has_emergency_contact ?? false) ? 'checked' : '' }}
                                onchange="toggleEmergencyContact()"
                                class="sr-only peer"
                            >
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-plyform-green/20 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-plyform-green"></div>
                        </div>
                        <span class="text-sm font-medium text-plyform-dark">I have an emergency contact</span>
                    </label>
                </div>

                <div id="emergency-contact-fields" style="display: {{ old('has_emergency_contact', $profile->has_emergency_contact ?? false) ? 'block' : 'none' }};">
                    <div class="grid md:grid-cols-2 gap-4">
                        
                        <!-- Emergency Contact Name -->
                        <div>
                            <label class="flex items-center gap-2 text-sm font-medium text-plyform-dark mb-2">
                                Full Name <span class="text-plyform-orange">*</span>
                            </label>
                            <input 
                                type="text" 
                                name="emergency_contact_name" 
                                value="{{ old('emergency_contact_name', $profile->emergency_contact_name ?? '') }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all @error('emergency_contact_name') border-red-500 @enderror"
                                placeholder="Emergency contact name"
                            >
                            @error('emergency_contact_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Relationship -->
                        <div>
                            <label class="flex items-center gap-2 text-sm font-medium text-plyform-dark mb-2">
                                Relationship <span class="text-plyform-orange">*</span>
                            </label>
                            <select 
                                name="emergency_contact_relationship" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all @error('emergency_contact_relationship') border-red-500 @enderror"
                            >
                                <option value="">Select relationship</option>
                                <option value="parent" {{ old('emergency_contact_relationship', $profile->emergency_contact_relationship ?? '') == 'parent' ? 'selected' : '' }}>Parent</option>
                                <option value="sibling" {{ old('emergency_contact_relationship', $profile->emergency_contact_relationship ?? '') == 'sibling' ? 'selected' : '' }}>Sibling</option>
                                <option value="partner" {{ old('emergency_contact_relationship', $profile->emergency_contact_relationship ?? '') == 'partner' ? 'selected' : '' }}>Partner</option>
                                <option value="spouse" {{ old('emergency_contact_relationship', $profile->emergency_contact_relationship ?? '') == 'spouse' ? 'selected' : '' }}>Spouse</option>
                                <option value="friend" {{ old('emergency_contact_relationship', $profile->emergency_contact_relationship ?? '') == 'friend' ? 'selected' : '' }}>Friend</option>
                                <option value="other" {{ old('emergency_contact_relationship', $profile->emergency_contact_relationship ?? '') == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('emergency_contact_relationship')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                    </div>
                    
                    <div class="grid md:grid-cols-2 gap-4 mt-4">
                        
                        <!-- Emergency Contact Phone -->
                        <div>
                            <label class="flex items-center gap-2 text-sm font-medium text-plyform-dark mb-2">
                                Phone Number <span class="text-plyform-orange">*</span>
                            </label>
                            
                            <input 
                                type="tel" 
                                id="emergency_contact_phone" 
                                name="emergency_contact_number_display"
                                value="{{ old('emergency_contact_number', $profile->emergency_contact_number ?? '') }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all @error('emergency_contact_number') border-red-500 @enderror"
                                placeholder="Enter phone number"
                            >
                            
                            <!-- Hidden fields for country code and number -->
                            <input type="hidden" id="emergency_contact_country_code" name="emergency_contact_country_code" value="{{ old('emergency_contact_country_code', $profile->emergency_contact_country_code ?? '+61') }}">
                            <input type="hidden" id="emergency_contact_number_clean" name="emergency_contact_number" value="{{ old('emergency_contact_number', $profile->emergency_contact_number ?? '') }}">
                            
                            @error('emergency_contact_country_code')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            @error('emergency_contact_number')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">Select country and enter emergency contact number</p>
                        </div>
                        
                        <!-- Emergency Contact Email -->
                        <div>
                            <label class="flex items-center gap-2 text-sm font-medium text-plyform-dark mb-2">
                                Email Address <span class="text-plyform-orange">*</span>
                            </label>
                            <input 
                                type="email" 
                                name="emergency_contact_email" 
                                value="{{ old('emergency_contact_email', $profile->emergency_contact_email ?? '') }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all @error('emergency_contact_email') border-red-500 @enderror"
                                placeholder="emergency@example.com"
                            >
                            @error('emergency_contact_email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                    </div>
                </div>
                
            </div>
            
            <!-- Guarantor Section -->
            <div class="bg-white rounded-lg space-y-4">
                <div class="mb-4">
                    <h4 class="text-base font-semibold text-plyform-dark">Guarantor</h4>
                    <p class="text-sm text-gray-600 mt-1">Optional - A guarantor who will co-sign your rental agreement</p>
                </div>
                
                <!-- Has Guarantor Toggle -->
                <div class="mb-4">
                    <label class="flex items-center gap-3 cursor-pointer p-3 rounded-lg hover:bg-plyform-mint/10 transition-colors">
                        <div class="relative">
                            <input 
                                type="checkbox" 
                                name="has_guarantor" 
                                id="has_guarantor"
                                value="1"
                                {{ old('has_guarantor', $profile->has_guarantor ?? false) ? 'checked' : '' }}
                                onchange="toggleGuarantor()"
                                class="sr-only peer"
                            >
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-plyform-green/20 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-plyform-green"></div>
                        </div>
                        <div>
                            <span class="text-sm font-medium text-plyform-dark block">I have a guarantor</span>
                            <span class="text-xs text-gray-500">A guarantor is someone who agrees to pay your rent if you can't</span>
                        </div>
                    </label>
                </div>

                <div id="guarantor-fields" style="display: {{ old('has_guarantor', $profile->has_guarantor ?? false) ? 'block' : 'none' }};">
                    <div class="grid md:grid-cols-2 gap-4">
                        
                        <!-- Guarantor Name -->
                        <div>
                            <label class="flex items-center gap-2 text-sm font-medium text-plyform-dark mb-2">
                                Full Name <span class="text-plyform-orange">*</span>
                            </label>
                            <input 
                                type="text" 
                                name="guarantor_name" 
                                value="{{ old('guarantor_name', $profile->guarantor_name ?? '') }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all @error('guarantor_name') border-red-500 @enderror"
                                placeholder="Guarantor's full name"
                            >
                            @error('guarantor_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Guarantor Phone -->
                        <div>
                            <label class="flex items-center gap-2 text-sm font-medium text-plyform-dark mb-2">
                                Phone Number <span class="text-plyform-orange">*</span>
                            </label>
                            
                            <input 
                                type="tel" 
                                id="guarantor_phone" 
                                name="guarantor_number_display"
                                value="{{ old('guarantor_number', $profile->guarantor_number ?? '') }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all @error('guarantor_number') border-red-500 @enderror"
                                placeholder="Enter phone number"
                            >
                            
                            <!-- Hidden fields for country code and number -->
                            <input type="hidden" id="guarantor_country_code" name="guarantor_country_code" value="{{ old('guarantor_country_code', $profile->guarantor_country_code ?? '+61') }}">
                            <input type="hidden" id="guarantor_number_clean" name="guarantor_number" value="{{ old('guarantor_number', $profile->guarantor_number ?? '') }}">
                            
                            @error('guarantor_country_code')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            @error('guarantor_number')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">Select country and enter guarantor phone number</p>
                        </div>
                        
                    </div>
                    
                    <!-- Guarantor Email -->
                    <div class="mt-4">
                        <label class="flex items-center gap-2 text-sm font-medium text-plyform-dark mb-2">
                            Email Address <span class="text-plyform-orange">*</span>
                        </label>
                        <input 
                            type="email" 
                            name="guarantor_email" 
                            value="{{ old('guarantor_email', $profile->guarantor_email ?? '') }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all @error('guarantor_email') border-red-500 @enderror"
                            placeholder="guarantor@example.com"
                        >
                        @error('guarantor_email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
            </div>
            
            <!-- Form Actions -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200">
                <button 
                    type="button" 
                    onclick="togglePersonalDetails()"
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
function togglePersonalDetails() {
    const formDiv = document.getElementById('personal-details-form');
    const chevron = document.getElementById('personal-details-chevron');
    
    if (formDiv.classList.contains('hidden')) {
        // Expand
        formDiv.classList.remove('hidden');
        chevron.style.transform = 'rotate(90deg)';
    } else {
        // Collapse
        formDiv.classList.add('hidden');
        chevron.style.transform = 'rotate(0deg)';
    }
}

function toggleEmergencyContact() {
    const checkbox = document.getElementById('has_emergency_contact');
    const fields = document.getElementById('emergency-contact-fields');
    fields.style.display = checkbox.checked ? 'block' : 'none';
}

function toggleGuarantor() {
    const checkbox = document.getElementById('has_guarantor');
    const fields = document.getElementById('guarantor-fields');
    fields.style.display = checkbox.checked ? 'block' : 'none';
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    toggleEmergencyContact();
    toggleGuarantor();
});
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        
        // ========================================
        // MOBILE NUMBER - intl-tel-input
        // ========================================
        const phoneInput = document.querySelector("#mobile_number");
        if (phoneInput) {
            const iti = window.intlTelInput(phoneInput, {
                initialCountry: "au",
                preferredCountries: ["au", "us", "gb", "nz", "sg", "my", "id", "ph"],
                separateDialCode: true,
                nationalMode: false,
                autoPlaceholder: "polite",
                formatOnDisplay: false,
                customPlaceholder: function(selectedCountryPlaceholder, selectedCountryData) {
                    return "e.g. " + selectedCountryPlaceholder;
                },
                utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@19.5.6/build/js/utils.js"
            });

            // Set initial value if exists
            const existingCountryCode = document.getElementById('mobile_country_code').value;
            const existingNumber = document.getElementById('mobile_number_clean').value;
            
            if (existingCountryCode && existingNumber) {
                const countryCode = existingCountryCode.replace('+', '');
                // Use window.intlTelInputGlobals instead of iti instance
                const allCountries = window.intlTelInputGlobals.getCountryData();
                const countryData = allCountries.find(country => country.dialCode === countryCode);
                if (countryData) {
                    iti.setCountry(countryData.iso2);
                }
                phoneInput.value = existingNumber;
            }

            phoneInput.addEventListener('blur', function() {
                updatePhoneFields();
            });

            phoneInput.addEventListener('countrychange', function() {
                updatePhoneFields();
            });

            function updatePhoneFields() {
                const countryData = iti.getSelectedCountryData();
                document.getElementById('mobile_country_code').value = '+' + countryData.dialCode;
                const fullNumber = iti.getNumber();
                const numberWithoutCode = fullNumber.replace('+' + countryData.dialCode, '').trim();
                document.getElementById('mobile_number_clean').value = numberWithoutCode;
            }

            // Validate on form submit
            const form = document.getElementById('application-form');
            if (form) {
                form.addEventListener('submit', function(e) {
                    updatePhoneFields();
                    
                    // Validate phone number
                    if (phoneInput.value && !iti.isValidNumber()) {
                        e.preventDefault();
                        phoneInput.classList.add('border-red-500');
                        
                        let errorMsg = phoneInput.parentElement.querySelector('.phone-error');
                        if (!errorMsg) {
                            errorMsg = document.createElement('p');
                            errorMsg.className = 'phone-error mt-1 text-sm text-red-600';
                            phoneInput.parentElement.appendChild(errorMsg);
                        }
                        errorMsg.textContent = 'Please enter a valid phone number for the selected country.';
                        
                        phoneInput.focus();
                        return false;
                    } else {
                        phoneInput.classList.remove('border-red-500');
                        const errorMsg = phoneInput.parentElement.querySelector('.phone-error');
                        if (errorMsg) {
                            errorMsg.remove();
                        }
                    }
                });
            }
        }

        // ========================================
        // EMERGENCY CONTACT PHONE - intl-tel-input
        // ========================================
        const emergencyPhoneInput = document.querySelector("#emergency_contact_phone");
        if (emergencyPhoneInput) {
            const emergencyIti = window.intlTelInput(emergencyPhoneInput, {
                initialCountry: "au",
                preferredCountries: ["au", "us", "gb", "nz", "sg", "my", "id", "ph"],
                separateDialCode: true,
                nationalMode: false,
                autoPlaceholder: "polite",
                formatOnDisplay: false,
                customPlaceholder: function(selectedCountryPlaceholder, selectedCountryData) {
                    return "e.g. " + selectedCountryPlaceholder;
                },
                utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@19.5.6/build/js/utils.js"
            });

            const existingEmergencyCountryCode = document.getElementById('emergency_contact_country_code').value;
            const existingEmergencyNumber = document.getElementById('emergency_contact_number_clean').value;
            
            if (existingEmergencyCountryCode && existingEmergencyNumber) {
                const countryCode = existingEmergencyCountryCode.replace('+', '');
                // Use window.intlTelInputGlobals instead of emergencyIti instance
                const allCountries = window.intlTelInputGlobals.getCountryData();
                const countryData = allCountries.find(country => country.dialCode === countryCode);
                if (countryData) {
                    emergencyIti.setCountry(countryData.iso2);
                }
                emergencyPhoneInput.value = existingEmergencyNumber;
            }

            emergencyPhoneInput.addEventListener('blur', function() {
                updateEmergencyPhoneFields();
            });

            emergencyPhoneInput.addEventListener('countrychange', function() {
                updateEmergencyPhoneFields();
            });

            function updateEmergencyPhoneFields() {
                const countryData = emergencyIti.getSelectedCountryData();
                document.getElementById('emergency_contact_country_code').value = '+' + countryData.dialCode;
                const fullNumber = emergencyIti.getNumber();
                const numberWithoutCode = fullNumber.replace('+' + countryData.dialCode, '').trim();
                document.getElementById('emergency_contact_number_clean').value = numberWithoutCode;
            }

            // Validate emergency contact phone on form submission
            const form = document.getElementById('application-form');
            if (form) {
                form.addEventListener('submit', function(e) {
                    const hasEmergencyContact = document.getElementById('has_emergency_contact');
                    
                    if (hasEmergencyContact && hasEmergencyContact.checked) {
                        updateEmergencyPhoneFields();
                        
                        if (emergencyPhoneInput.value && !emergencyIti.isValidNumber()) {
                            e.preventDefault();
                            emergencyPhoneInput.classList.add('border-red-500');
                            
                            let errorMsg = emergencyPhoneInput.parentElement.querySelector('.emergency-phone-error');
                            if (!errorMsg) {
                                errorMsg = document.createElement('p');
                                errorMsg.className = 'emergency-phone-error mt-1 text-sm text-red-600';
                                emergencyPhoneInput.parentElement.appendChild(errorMsg);
                            }
                            errorMsg.textContent = 'Please enter a valid emergency contact phone number.';
                            
                            emergencyPhoneInput.focus();
                            return false;
                        } else {
                            emergencyPhoneInput.classList.remove('border-red-500');
                            const errorMsg = emergencyPhoneInput.parentElement.querySelector('.emergency-phone-error');
                            if (errorMsg) {
                                errorMsg.remove();
                            }
                        }
                    }
                });
            }
        }

        // ========================================
        // GUARANTOR PHONE - intl-tel-input
        // ========================================
        const guarantorPhoneInput = document.querySelector("#guarantor_phone");
        if (guarantorPhoneInput) {
            const guarantorIti = window.intlTelInput(guarantorPhoneInput, {
                initialCountry: "au",
                preferredCountries: ["au", "us", "gb", "nz", "sg", "my", "id", "ph"],
                separateDialCode: true,
                nationalMode: false,
                autoPlaceholder: "polite",
                formatOnDisplay: false,
                customPlaceholder: function(selectedCountryPlaceholder, selectedCountryData) {
                    return "e.g. " + selectedCountryPlaceholder;
                },
                utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@19.5.6/build/js/utils.js"
            });

            const existingGuarantorCountryCode = document.getElementById('guarantor_country_code').value;
            const existingGuarantorNumber = document.getElementById('guarantor_number_clean').value;
            
            if (existingGuarantorCountryCode && existingGuarantorNumber) {
                const countryCode = existingGuarantorCountryCode.replace('+', '');
                const allCountries = window.intlTelInputGlobals.getCountryData();
                const countryData = allCountries.find(country => country.dialCode === countryCode);
                if (countryData) {
                    guarantorIti.setCountry(countryData.iso2);
                }
                guarantorPhoneInput.value = existingGuarantorNumber;
            }

            guarantorPhoneInput.addEventListener('blur', function() {
                updateGuarantorPhoneFields();
            });

            guarantorPhoneInput.addEventListener('countrychange', function() {
                updateGuarantorPhoneFields();
            });

            function updateGuarantorPhoneFields() {
                const countryData = guarantorIti.getSelectedCountryData();
                document.getElementById('guarantor_country_code').value = '+' + countryData.dialCode;
                const fullNumber = guarantorIti.getNumber();
                const numberWithoutCode = fullNumber.replace('+' + countryData.dialCode, '').trim();
                document.getElementById('guarantor_number_clean').value = numberWithoutCode;
            }

            // Validate guarantor phone on form submission
            const form = document.getElementById('application-form');
            if (form) {
                form.addEventListener('submit', function(e) {
                    const hasGuarantor = document.getElementById('has_guarantor');
                    
                    if (hasGuarantor && hasGuarantor.checked) {
                        updateGuarantorPhoneFields();
                        
                        if (guarantorPhoneInput.value && !guarantorIti.isValidNumber()) {
                            e.preventDefault();
                            guarantorPhoneInput.classList.add('border-red-500');
                            
                            let errorMsg = guarantorPhoneInput.parentElement.querySelector('.guarantor-phone-error');
                            if (!errorMsg) {
                                errorMsg = document.createElement('p');
                                errorMsg.className = 'guarantor-phone-error mt-1 text-sm text-red-600';
                                guarantorPhoneInput.parentElement.appendChild(errorMsg);
                            }
                            errorMsg.textContent = 'Please enter a valid guarantor phone number.';
                            
                            guarantorPhoneInput.focus();
                            return false;
                        } else {
                            guarantorPhoneInput.classList.remove('border-red-500');
                            const errorMsg = guarantorPhoneInput.parentElement.querySelector('.guarantor-phone-error');
                            if (errorMsg) {
                                errorMsg.remove();
                            }
                        }
                    }
                });
            }
        }
        
    });
</script>