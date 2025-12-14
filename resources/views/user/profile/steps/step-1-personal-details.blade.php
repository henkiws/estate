<x-form-section-card title="Personal Information" required>
    
    <div class="grid md:grid-cols-2 gap-4">
        
        <!-- First Name -->
        <div>
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
        
        <!-- Phone Number -->
        <div>
            <label class="flex items-center gap-2 text-sm font-medium text-gray-700 mb-2">
                Phone Number <span class="text-red-500">*</span>
                <x-profile-help-text text="Your primary contact number" />
            </label>
            <input 
                type="tel" 
                name="phone" 
                value="{{ old('phone', $profile->phone ?? '') }}"
                required
                pattern="[0-9]{10}"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition @error('phone') border-red-500 @enderror"
                placeholder="0400 000 000"
            >
            @error('phone')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
            <p class="mt-1 text-xs text-gray-500">Format: 10 digits without spaces</p>
        </div>
        
    </div>
    
</x-form-section-card>

<x-form-section-card title="Emergency Contact" description="Someone we can contact in case of emergency">
    
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
                required
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition @error('emergency_contact_name') border-red-500 @enderror"
                placeholder="Emergency contact name"
            >
            @error('emergency_contact_name')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        
        <!-- Emergency Contact Phone -->
        <div>
            <label class="flex items-center gap-2 text-sm font-medium text-gray-700 mb-2">
                Phone Number <span class="text-red-500">*</span>
            </label>
            <input 
                type="tel" 
                name="emergency_contact_phone" 
                value="{{ old('emergency_contact_phone', $profile->emergency_contact_phone ?? '') }}"
                required
                pattern="[0-9]{10}"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition @error('emergency_contact_phone') border-red-500 @enderror"
                placeholder="0400 000 000"
            >
            @error('emergency_contact_phone')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        
    </div>
    
    <!-- Relationship -->
    <div>
        <label class="flex items-center gap-2 text-sm font-medium text-gray-700 mb-2">
            Relationship <span class="text-red-500">*</span>
        </label>
        <select 
            name="emergency_contact_relationship" 
            required
            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition @error('emergency_contact_relationship') border-red-500 @enderror"
        >
            <option value="">Select relationship</option>
            <option value="parent" {{ old('emergency_contact_relationship', $profile->emergency_contact_relationship ?? '') == 'parent' ? 'selected' : '' }}>Parent</option>
            <option value="sibling" {{ old('emergency_contact_relationship', $profile->emergency_contact_relationship ?? '') == 'sibling' ? 'selected' : '' }}>Sibling</option>
            <option value="partner" {{ old('emergency_contact_relationship', $profile->emergency_contact_relationship ?? '') == 'partner' ? 'selected' : '' }}>Partner</option>
            <option value="friend" {{ old('emergency_contact_relationship', $profile->emergency_contact_relationship ?? '') == 'friend' ? 'selected' : '' }}>Friend</option>
            <option value="other" {{ old('emergency_contact_relationship', $profile->emergency_contact_relationship ?? '') == 'other' ? 'selected' : '' }}>Other</option>
        </select>
        @error('emergency_contact_relationship')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>
    
</x-form-section-card>

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