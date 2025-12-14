<x-form-section-card 
    title="Tell Us About Yourself" 
    description="Share a brief introduction to help property managers get to know you better">
    
    <!-- Introduction -->
    <div>
        <label class="flex items-center gap-2 text-sm font-medium text-gray-700 mb-2">
            Introduction
            <x-profile-help-text>
                Write a brief description about yourself, your lifestyle, and what kind of tenant you are. 
                This helps property managers understand who you are beyond the paperwork.
            </x-profile-help-text>
        </label>
        <textarea 
            name="introduction" 
            rows="6"
            maxlength="1000"
            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition @error('introduction') border-red-500 @enderror"
            placeholder="Tell us about yourself, your hobbies, lifestyle, work, and what kind of tenant you'd be..."
        >{{ old('introduction', $profile->introduction ?? '') }}</textarea>
        
        <div class="flex items-center justify-between mt-2">
            <p class="text-xs text-gray-500">Maximum 1000 characters</p>
            <span class="text-xs text-gray-500" id="char-count">0 / 1000</span>
        </div>
        
        @error('introduction')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>
    
    <!-- Example -->
    <div class="p-4 bg-blue-50 border border-blue-200 rounded-lg">
        <h4 class="font-semibold text-blue-900 mb-2 text-sm">Example:</h4>
        <p class="text-sm text-blue-800">
            "I'm a professional working in IT, and I value a clean, peaceful living environment. 
            In my free time, I enjoy reading, cooking, and staying active. I'm a responsible tenant 
            who takes pride in maintaining my home and building positive relationships with neighbors. 
            I'm looking for a long-term rental where I can settle down."
        </p>
    </div>
    
</x-form-section-card>

<!-- Navigation Buttons -->
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
    
    <div class="flex items-center gap-3">
        <a href="{{ route('user.dashboard') }}" class="px-6 py-3 text-gray-600 hover:text-gray-900 font-medium">
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
// Character counter
document.addEventListener('DOMContentLoaded', function() {
    const textarea = document.querySelector('textarea[name="introduction"]');
    const charCount = document.getElementById('char-count');
    
    if (textarea && charCount) {
        function updateCount() {
            const count = textarea.value.length;
            charCount.textContent = count + ' / 1000';
            
            if (count > 900) {
                charCount.classList.add('text-orange-600');
            } else {
                charCount.classList.remove('text-orange-600');
            }
        }
        
        textarea.addEventListener('input', updateCount);
        updateCount(); // Initial count
    }
});
</script>