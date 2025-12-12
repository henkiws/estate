<div class="space-y-6">
    <!-- Step Header with Icon -->
    <div class="flex items-center mb-6">
        <div class="bg-blue-100 rounded-full p-3 mr-4">
            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
        </div>
        <div>
            <h2 class="text-xl sm:text-2xl font-bold text-gray-900">Personal Details</h2>
            <p class="text-sm text-gray-600 mt-1">Tell us about yourself</p>
        </div>
    </div>
    
    <!-- Title and Names -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2 required-field">Title</label>
            <select name="title" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <option value="">Select Title</option>
                <option value="Mr" {{ old('title', $profile->title) == 'Mr' ? 'selected' : '' }}>Mr</option>
                <option value="Mrs" {{ old('title', $profile->title) == 'Mrs' ? 'selected' : '' }}>Mrs</option>
                <option value="Ms" {{ old('title', $profile->title) == 'Ms' ? 'selected' : '' }}>Ms</option>
                <option value="Miss" {{ old('title', $profile->title) == 'Miss' ? 'selected' : '' }}>Miss</option>
                <option value="Dr" {{ old('title', $profile->title) == 'Dr' ? 'selected' : '' }}>Dr</option>
                <option value="Prof" {{ old('title', $profile->title) == 'Prof' ? 'selected' : '' }}>Prof</option>
            </select>
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2 required-field">First Name</label>
            <input type="text" name="first_name" value="{{ old('first_name', $profile->first_name) }}" required 
                   placeholder="Enter your first name"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Middle Name</label>
            <input type="text" name="middle_name" value="{{ old('middle_name', $profile->middle_name) }}" 
                   placeholder="Optional"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2 required-field">Last Name</label>
            <input type="text" name="last_name" value="{{ old('last_name', $profile->last_name) }}" required 
                   placeholder="Enter your last name"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Surname</label>
            <input type="text" name="surname" value="{{ old('surname', $profile->surname) }}" 
                   placeholder="Optional"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2 required-field">Date of Birth</label>
            <input type="text" name="date_of_birth" value="{{ old('date_of_birth', $profile->date_of_birth?->format('Y-m-d')) }}" required 
                   class="datepicker w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                   placeholder="Select your date of birth">
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2 required-field">Email Address</label>
            <input type="email" name="email" value="{{ old('email', $profile->email ?? auth()->user()->email) }}" required 
                   placeholder="your.email@example.com"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2 required-field">Mobile Number</label>
            <div class="flex gap-2">
                <select name="mobile_country_code" required class="w-24 sm:w-32 px-2 sm:px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="+61" {{ old('mobile_country_code', $profile->mobile_country_code) == '+61' ? 'selected' : '' }}>🇦🇺 +61</option>
                    <option value="+1" {{ old('mobile_country_code', $profile->mobile_country_code) == '+1' ? 'selected' : '' }}>🇺🇸 +1</option>
                    <option value="+44" {{ old('mobile_country_code', $profile->mobile_country_code) == '+44' ? 'selected' : '' }}>🇬🇧 +44</option>
                    <option value="+86" {{ old('mobile_country_code', $profile->mobile_country_code) == '+86' ? 'selected' : '' }}>🇨🇳 +86</option>
                    <option value="+62" {{ old('mobile_country_code', $profile->mobile_country_code) == '+62' ? 'selected' : '' }}>🇮🇩 +62</option>
                </select>
                <input type="text" name="mobile_number" value="{{ old('mobile_number', $profile->mobile_number) }}" required 
                       placeholder="Enter your mobile number"
                       class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
        </div>
    </div>

    <!-- Emergency Contact -->
    <div class="border-t pt-6 mt-6">
        <div class="flex items-center mb-4">
            <div class="bg-red-100 rounded-full p-2 mr-3">
                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900">Emergency Contact</h3>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2 required-field">Full Name</label>
                <input type="text" name="emergency_contact_name" value="{{ old('emergency_contact_name', $profile->emergency_contact_name) }}" required 
                       placeholder="Emergency contact full name"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2 required-field">Relationship to You</label>
                <input type="text" name="emergency_contact_relationship" value="{{ old('emergency_contact_relationship', $profile->emergency_contact_relationship) }}" required 
                       placeholder="e.g., Parent, Sibling, Partner"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2 required-field">Mobile Number</label>
                <div class="flex gap-2">
                    <select name="emergency_contact_country_code" required class="w-24 sm:w-32 px-2 sm:px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="+61" {{ old('emergency_contact_country_code', $profile->emergency_contact_country_code) == '+61' ? 'selected' : '' }}>🇦🇺 +61</option>
                        <option value="+1" {{ old('emergency_contact_country_code', $profile->emergency_contact_country_code) == '+1' ? 'selected' : '' }}>🇺🇸 +1</option>
                        <option value="+44" {{ old('emergency_contact_country_code', $profile->emergency_contact_country_code) == '+44' ? 'selected' : '' }}>🇬🇧 +44</option>
                        <option value="+86" {{ old('emergency_contact_country_code', $profile->emergency_contact_country_code) == '+86' ? 'selected' : '' }}>🇨🇳 +86</option>
                        <option value="+62" {{ old('emergency_contact_country_code', $profile->emergency_contact_country_code) == '+62' ? 'selected' : '' }}>🇮🇩 +62</option>
                    </select>
                    <input type="text" name="emergency_contact_number" value="{{ old('emergency_contact_number', $profile->emergency_contact_number) }}" required 
                           placeholder="Emergency contact number"
                           class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2 required-field">Email Address</label>
                <input type="email" name="emergency_contact_email" value="{{ old('emergency_contact_email', $profile->emergency_contact_email) }}" required 
                       placeholder="emergency@example.com"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
        </div>
    </div>

    <!-- Guarantor -->
    <div class="border-t pt-6 mt-6">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center">
                <div class="bg-purple-100 rounded-full p-2 mr-3">
                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900">Do you have a guarantor?</h3>
            </div>
            <label class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" name="has_guarantor" value="1" id="hasGuarantorToggle" 
                       {{ old('has_guarantor', $profile->has_guarantor) ? 'checked' : '' }}
                       class="sr-only peer">
                <div class="w-14 h-7 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-blue-600"></div>
            </label>
        </div>

        <div id="guarantorFields" style="{{ old('has_guarantor', $profile->has_guarantor) ? '' : 'display:none;' }}" class="space-y-4 bg-purple-50 rounded-lg p-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Guarantor Name</label>
                <input type="text" name="guarantor_name" value="{{ old('guarantor_name', $profile->guarantor_name) }}" 
                       placeholder="Full name of guarantor"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Mobile Number</label>
                    <div class="flex gap-2">
                        <select name="guarantor_country_code" class="w-24 sm:w-32 px-2 sm:px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white">
                            <option value="+61" {{ old('guarantor_country_code', $profile->guarantor_country_code) == '+61' ? 'selected' : '' }}>🇦🇺 +61</option>
                            <option value="+1" {{ old('guarantor_country_code', $profile->guarantor_country_code) == '+1' ? 'selected' : '' }}>🇺🇸 +1</option>
                            <option value="+44" {{ old('guarantor_country_code', $profile->guarantor_country_code) == '+44' ? 'selected' : '' }}>🇬🇧 +44</option>
                            <option value="+86" {{ old('guarantor_country_code', $profile->guarantor_country_code) == '+86' ? 'selected' : '' }}>🇨🇳 +86</option>
                            <option value="+62" {{ old('guarantor_country_code', $profile->guarantor_country_code) == '+62' ? 'selected' : '' }}>🇮🇩 +62</option>
                        </select>
                        <input type="text" name="guarantor_number" value="{{ old('guarantor_number', $profile->guarantor_number) }}" 
                               placeholder="Guarantor mobile"
                               class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white">
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                    <input type="email" name="guarantor_email" value="{{ old('guarantor_email', $profile->guarantor_email) }}" 
                           placeholder="guarantor@example.com"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white">
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('hasGuarantorToggle').addEventListener('change', function() {
    const fields = document.getElementById('guarantorFields');
    if (this.checked) {
        fields.style.display = 'block';
        fields.style.animation = 'slideDown 0.3s ease-out';
    } else {
        fields.style.display = 'none';
    }
});
</script>