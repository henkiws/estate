<x-form-section-card title="Personal Details" required>
    
    <div class="grid md:grid-cols-3 gap-4">
        
        <!-- Title -->
        <div>
            <label class="flex items-center gap-2 text-sm font-medium text-gray-700 mb-2">
                Title <span class="text-red-500">*</span>
                <x-profile-help-text text="Select your preferred title" />
            </label>
            <select 
                name="title" 
                required
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition @error('title') border-red-500 @enderror"
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
            <label class="flex items-center gap-2 text-sm font-medium text-gray-700 mb-2">
                First Name <span class="text-red-500">*</span>
                <x-profile-help-text text="Your legal first name as it appears on your ID" />
            </label>
            <input 
                type="text" 
                name="first_name" 
                value="{{ old('first_name', $profile->first_name ?? '') }}"
                required
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition @error('first_name') border-red-500 @enderror"
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
            <label class="flex items-center gap-2 text-sm font-medium text-gray-700 mb-2">
                Middle Name
                <x-profile-help-text text="Optional - your middle name if you have one" />
            </label>
            <input 
                type="text" 
                name="middle_name" 
                value="{{ old('middle_name', $profile->middle_name ?? '') }}"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition @error('middle_name') border-red-500 @enderror"
                placeholder="Enter your middle name (optional)"
            >
            @error('middle_name')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        
        <!-- Last Name -->
        <div>
            <label class="flex items-center gap-2 text-sm font-medium text-gray-700 mb-2">
                Last Name <span class="text-red-500">*</span>
                <x-profile-help-text text="Your legal last name as it appears on your ID" />
            </label>
            <input 
                type="text" 
                name="last_name" 
                value="{{ old('last_name', $profile->last_name ?? '') }}"
                required
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition @error('last_name') border-red-500 @enderror"
                placeholder="Enter your last name"
            >
            @error('last_name')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        
    </div>
    
    <div class="grid md:grid-cols-2 gap-4">
        
        <!-- Surname -->
        <div>
            <label class="flex items-center gap-2 text-sm font-medium text-gray-700 mb-2">
                Surname
                <x-profile-help-text text="If different from last name (e.g., maiden name)" />
            </label>
            <input 
                type="text" 
                name="surname" 
                value="{{ old('surname', $profile->surname ?? '') }}"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition @error('surname') border-red-500 @enderror"
                placeholder="Enter surname (if applicable)"
            >
            @error('surname')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        
        <!-- Date of Birth -->
        <div>
            <label class="flex items-center gap-2 text-sm font-medium text-gray-700 mb-2">
                Date of Birth <span class="text-red-500">*</span>
                <x-profile-help-text text="You must be 18 years or older to apply" />
            </label>
            <input 
                type="date" 
                name="date_of_birth" 
                value="{{ old('date_of_birth', $profile->date_of_birth ? $profile->date_of_birth->format('Y-m-d') : '') }}"
                required
                max="{{ now()->subYears(18)->format('Y-m-d') }}"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition @error('date_of_birth') border-red-500 @enderror"
            >
            @error('date_of_birth')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        
    </div>
    
</x-form-section-card>

<x-form-section-card title="Contact Information" required>
    
    <!-- Email Address -->
    <div>
        <label class="flex items-center gap-2 text-sm font-medium text-gray-700 mb-2">
            Email Address <span class="text-red-500">*</span>
            <x-profile-help-text text="Your primary email address for correspondence" />
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
        <label class="flex items-center gap-2 text-sm font-medium text-gray-700 mb-2">
            Mobile Number <span class="text-red-500">*</span>
            <x-profile-help-text text="Your primary mobile contact number" />
        </label>
        <div class="flex gap-2">
            <!-- Country Code Dropdown -->
            <select 
                name="mobile_country_code" 
                required
                class="w-32 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition @error('mobile_country_code') border-red-500 @enderror"
            >
                <option value="+61" {{ old('mobile_country_code', $profile->mobile_country_code ?? '+61') == '+61' ? 'selected' : '' }}>🇦🇺 +61</option>
                <option value="+1" {{ old('mobile_country_code', $profile->mobile_country_code ?? '') == '+1' ? 'selected' : '' }}>🇺🇸 +1</option>
                <option value="+44" {{ old('mobile_country_code', $profile->mobile_country_code ?? '') == '+44' ? 'selected' : '' }}>🇬🇧 +44</option>
                <option value="+64" {{ old('mobile_country_code', $profile->mobile_country_code ?? '') == '+64' ? 'selected' : '' }}>🇳🇿 +64</option>
                <option value="+86" {{ old('mobile_country_code', $profile->mobile_country_code ?? '') == '+86' ? 'selected' : '' }}>🇨🇳 +86</option>
                <option value="+81" {{ old('mobile_country_code', $profile->mobile_country_code ?? '') == '+81' ? 'selected' : '' }}>🇯🇵 +81</option>
                <option value="+82" {{ old('mobile_country_code', $profile->mobile_country_code ?? '') == '+82' ? 'selected' : '' }}>🇰🇷 +82</option>
                <option value="+65" {{ old('mobile_country_code', $profile->mobile_country_code ?? '') == '+65' ? 'selected' : '' }}>🇸🇬 +65</option>
                <option value="+60" {{ old('mobile_country_code', $profile->mobile_country_code ?? '') == '+60' ? 'selected' : '' }}>🇲🇾 +60</option>
                <option value="+62" {{ old('mobile_country_code', $profile->mobile_country_code ?? '') == '+62' ? 'selected' : '' }}>🇮🇩 +62</option>
                <option value="+63" {{ old('mobile_country_code', $profile->mobile_country_code ?? '') == '+63' ? 'selected' : '' }}>🇵🇭 +63</option>
                <option value="+66" {{ old('mobile_country_code', $profile->mobile_country_code ?? '') == '+66' ? 'selected' : '' }}>🇹🇭 +66</option>
                <option value="+84" {{ old('mobile_country_code', $profile->mobile_country_code ?? '') == '+84' ? 'selected' : '' }}>🇻🇳 +84</option>
                <option value="+91" {{ old('mobile_country_code', $profile->mobile_country_code ?? '') == '+91' ? 'selected' : '' }}>🇮🇳 +91</option>
            </select>
            
            <!-- Mobile Number Input -->
            <input 
                type="tel" 
                name="mobile_number" 
                value="{{ old('mobile_number', $profile->mobile_number ?? '') }}"
                required
                pattern="[0-9]{8,15}"
                class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition @error('mobile_number') border-red-500 @enderror"
                placeholder="412345678"
            >
        </div>
        @error('mobile_country_code')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
        @error('mobile_number')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
        <p class="mt-1 text-xs text-gray-500">Enter your mobile number without spaces or leading zero (e.g., 412345678 for Australian numbers)</p>
    </div>
    
</x-form-section-card>

<x-form-section-card title="Emergency Contact" description="Someone we can contact in case of emergency">
    
    <!-- Has Emergency Contact Toggle -->
    <div class="mb-4">
        <label class="flex items-center gap-3 cursor-pointer">
            <div class="relative">
                <input 
                    type="checkbox" 
                    name="has_emergency_contact" 
                    id="has_emergency_contact"
                    value="1"
                    {{ old('has_emergency_contact', isset($profile->emergency_contact_name) && $profile->emergency_contact_name ? '1' : '0') ? 'checked' : '' }}
                    onchange="toggleEmergencyContact()"
                    class="sr-only peer"
                >
                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-teal-300 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-teal-600"></div>
            </div>
            <span class="text-sm font-medium text-gray-700">I have an emergency contact</span>
        </label>
    </div>

    <div id="emergency-contact-fields" style="display: {{ old('has_emergency_contact', isset($profile->emergency_contact_name) && $profile->emergency_contact_name ? '1' : '0') ? 'block' : 'none' }};">
        <div class="grid md:grid-cols-2 gap-4">
            
            <!-- Emergency Contact Name -->
            <div>
                <label class="flex items-center gap-2 text-sm font-medium text-gray-700 mb-2">
                    Full Name <span class="text-red-500">*</span>
                </label>
                <input 
                    type="text" 
                    name="emergency_contact_name" 
                    value="{{ old('emergency_contact_name', $profile->emergency_contact_name ?? '') }}"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition @error('emergency_contact_name') border-red-500 @enderror"
                    placeholder="Emergency contact name"
                >
                @error('emergency_contact_name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Relationship -->
            <div>
                <label class="flex items-center gap-2 text-sm font-medium text-gray-700 mb-2">
                    Relationship <span class="text-red-500">*</span>
                </label>
                <select 
                    name="emergency_contact_relationship" 
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition @error('emergency_contact_relationship') border-red-500 @enderror"
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
                <label class="flex items-center gap-2 text-sm font-medium text-gray-700 mb-2">
                    Phone Number <span class="text-red-500">*</span>
                </label>
                <div class="flex gap-2">
                    <select 
                        name="emergency_contact_country_code" 
                        class="w-32 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition @error('emergency_contact_country_code') border-red-500 @enderror"
                    >
                        <option value="+61" {{ old('emergency_contact_country_code', $profile->emergency_contact_country_code ?? '+61') == '+61' ? 'selected' : '' }}>🇦🇺 +61</option>
                        <option value="+1" {{ old('emergency_contact_country_code', $profile->emergency_contact_country_code ?? '') == '+1' ? 'selected' : '' }}>🇺🇸 +1</option>
                        <option value="+44" {{ old('emergency_contact_country_code', $profile->emergency_contact_country_code ?? '') == '+44' ? 'selected' : '' }}>🇬🇧 +44</option>
                        <option value="+64" {{ old('emergency_contact_country_code', $profile->emergency_contact_country_code ?? '') == '+64' ? 'selected' : '' }}>🇳🇿 +64</option>
                    </select>
                    <input 
                        type="tel" 
                        name="emergency_contact_number" 
                        value="{{ old('emergency_contact_number', $profile->emergency_contact_number ?? '') }}"
                        pattern="[0-9]{8,15}"
                        class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition @error('emergency_contact_number') border-red-500 @enderror"
                        placeholder="412345678"
                    >
                </div>
                @error('emergency_contact_country_code')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                @error('emergency_contact_number')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Emergency Contact Email -->
            <div>
                <label class="flex items-center gap-2 text-sm font-medium text-gray-700 mb-2">
                    Email Address <span class="text-red-500">*</span>
                </label>
                <input 
                    type="email" 
                    name="emergency_contact_email" 
                    value="{{ old('emergency_contact_email', $profile->emergency_contact_email ?? '') }}"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition @error('emergency_contact_email') border-red-500 @enderror"
                    placeholder="emergency@example.com"
                >
                @error('emergency_contact_email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
        </div>
    </div>
    
</x-form-section-card>

<x-form-section-card title="Guarantor" description="Optional - A guarantor who will co-sign your rental agreement">
    
    <!-- Has Guarantor Toggle -->
    <div class="mb-4">
        <label class="flex items-center gap-3 cursor-pointer">
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
                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-teal-300 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-teal-600"></div>
            </div>
            <span class="text-sm font-medium text-gray-700">I have a guarantor</span>
        </label>
        <p class="mt-1 ml-14 text-xs text-gray-500">A guarantor is someone who agrees to pay your rent if you can't</p>
    </div>

    <div id="guarantor-fields" style="display: {{ old('has_guarantor', $profile->has_guarantor ?? false) ? 'block' : 'none' }};">
        <div class="grid md:grid-cols-2 gap-4">
            
            <!-- Guarantor Name -->
            <div>
                <label class="flex items-center gap-2 text-sm font-medium text-gray-700 mb-2">
                    Full Name <span class="text-red-500">*</span>
                </label>
                <input 
                    type="text" 
                    name="guarantor_name" 
                    value="{{ old('guarantor_name', $profile->guarantor_name ?? '') }}"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition @error('guarantor_name') border-red-500 @enderror"
                    placeholder="Guarantor's full name"
                >
                @error('guarantor_name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Guarantor Phone -->
            <div>
                <label class="flex items-center gap-2 text-sm font-medium text-gray-700 mb-2">
                    Phone Number <span class="text-red-500">*</span>
                </label>
                <div class="flex gap-2">
                    <select 
                        name="guarantor_country_code" 
                        class="w-32 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition @error('guarantor_country_code') border-red-500 @enderror"
                    >
                        <option value="+61" {{ old('guarantor_country_code', $profile->guarantor_country_code ?? '+61') == '+61' ? 'selected' : '' }}>🇦🇺 +61</option>
                        <option value="+1" {{ old('guarantor_country_code', $profile->guarantor_country_code ?? '') == '+1' ? 'selected' : '' }}>🇺🇸 +1</option>
                        <option value="+44" {{ old('guarantor_country_code', $profile->guarantor_country_code ?? '') == '+44' ? 'selected' : '' }}>🇬🇧 +44</option>
                        <option value="+64" {{ old('guarantor_country_code', $profile->guarantor_country_code ?? '') == '+64' ? 'selected' : '' }}>🇳🇿 +64</option>
                    </select>
                    <input 
                        type="tel" 
                        name="guarantor_number" 
                        value="{{ old('guarantor_number', $profile->guarantor_number ?? '') }}"
                        pattern="[0-9]{8,15}"
                        class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition @error('guarantor_number') border-red-500 @enderror"
                        placeholder="412345678"
                    >
                </div>
                @error('guarantor_country_code')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                @error('guarantor_number')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
        </div>
        
        <!-- Guarantor Email -->
        <div class="mt-4">
            <label class="flex items-center gap-2 text-sm font-medium text-gray-700 mb-2">
                Email Address <span class="text-red-500">*</span>
            </label>
            <input 
                type="email" 
                name="guarantor_email" 
                value="{{ old('guarantor_email', $profile->guarantor_email ?? '') }}"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition @error('guarantor_email') border-red-500 @enderror"
                placeholder="guarantor@example.com"
            >
            @error('guarantor_email')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>
    
</x-form-section-card>

<script>
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

<!-- Navigation Buttons -->
<div class="flex items-center justify-between mt-6">
    <a href="{{ route('user.dashboard') }}" class="px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 transition">
        Save & Exit
    </a>
    
    <button type="submit" class="px-8 py-3 bg-teal-600 text-white font-semibold rounded-lg hover:bg-teal-700 transition shadow-sm flex items-center gap-2">
        Save & Continue
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
    </button>
</div>