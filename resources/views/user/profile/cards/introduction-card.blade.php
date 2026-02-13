<!-- Introduction Card -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden section-card mb-4" id="introduction-card">
    
    <!-- Card Header - Collapsible Button (Always Visible) -->
    <button type="button" onclick="toggleIntroduction()" class="w-full px-6 py-4 flex items-center justify-between hover:bg-gray-50 transition">
        <div class="flex items-center gap-3">
            <!-- Status Icon -->
            <div class="w-8 h-8 rounded-full {{ $profile && $profile->introduction ? 'bg-teal-100' : 'bg-gray-100' }} flex items-center justify-center section-status" id="status_introduction">
                @if($profile && $profile->introduction)
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
                <span class="font-semibold text-gray-900">Introduction</span>
                <span class="text-xs bg-gray-200 text-gray-600 px-2 py-0.5 rounded-full font-medium">Optional</span>
                @if($profile && $profile->introduction)
                    <span class="text-xs bg-green-200 text-green-600 px-2 py-0.5 rounded-full font-medium">Completed</span>
                @endif
                <p class="text-xs text-gray-500" id="introduction-summary">
                    @if($profile && $profile->introduction)
                        {{ Str::limit($profile->introduction, 60) }}
                    @else
                        Not completed yet
                    @endif
                </p>
            </div>
        </div>
        
        <!-- Right Side: Percentage + Chevron -->
        <div class="flex items-center gap-4">
            <!-- Completion Percentage Circle -->
            <div class="flex items-center justify-center w-12 h-12 rounded-full border-3 {{ $profile && $profile->introduction ? 'border-teal-600 bg-teal-50' : 'border-gray-300 bg-gray-50' }}" id="introduction-percentage-circle">
                <span class="text-xs font-bold {{ $profile && $profile->introduction ? 'text-teal-600' : 'text-gray-400' }}" id="introduction-percentage">
                    @if($profile && $profile->introduction)
                        100%
                    @else
                        0%
                    @endif
                </span>
            </div>
            
            <!-- Chevron Icon -->
            <svg class="w-5 h-5 text-gray-400 section-chevron transition-transform" id="introduction-chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </div>
    </button>
    
    <!-- Expandable Form Content (Hidden by Default) -->
    <div class="section-content hidden px-6 pb-6" id="introduction-form">
        <form method="POST" action="{{ route('user.profile.update-step') }}" class="space-y-6">
            @csrf
            <input type="hidden" name="current_step" value="2">
            <input type="hidden" name="mode" value="{{ $mode }}">
            
            <!-- Introduction Section -->
            <div class="bg-white rounded-lg space-y-4">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h4 class="text-base font-semibold text-plyform-dark">Tell Us About Yourself</h4>
                        <p class="text-sm text-gray-600 mt-1">Share a brief introduction to help property managers get to know you better</p>
                    </div>
                </div>
                
                <!-- Introduction Textarea -->
                <div>
                    <label class="flex items-center gap-2 text-sm font-medium text-plyform-dark mb-2">
                        Introduction
                    </label>
                    <textarea 
                        name="introduction" 
                        rows="6"
                        maxlength="1000"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all resize-none @error('introduction') border-red-500 @enderror"
                        placeholder="Tell us about yourself, your hobbies, lifestyle, work, and what kind of tenant you'd be..."
                    >{{ old('introduction', $profile->introduction ?? '') }}</textarea>
                    
                    <div class="flex items-center justify-between mt-2">
                        <p class="text-xs text-gray-500">Maximum 1000 characters</p>
                        <span class="text-xs text-gray-500 font-medium" id="intro-char-count">0 / 1000</span>
                    </div>
                    
                    @error('introduction')
                        <p class="mt-1 text-sm text-red-600 flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
                
                <!-- Example -->
                <div class="p-4 bg-plyform-green/10 border border-plyform-green/30 rounded-lg">
                    <div class="flex gap-3">
                        <svg class="w-5 h-5 text-plyform-dark flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                        </svg>
                        <div class="flex-1">
                            <h4 class="font-semibold text-plyform-dark mb-2 text-sm">Example:</h4>
                            <p class="text-sm text-gray-700 leading-relaxed">
                                "I'm a professional working in IT, and I value a clean, peaceful living environment. 
                                In my free time, I enjoy reading, cooking, and staying active. I'm a responsible tenant 
                                who takes pride in maintaining my home and building positive relationships with neighbors. 
                                I'm looking for a long-term rental where I can settle down."
                            </p>
                        </div>
                    </div>
                </div>
                
            </div>
            
            <!-- Form Actions -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200">
                <button 
                    type="button" 
                    onclick="toggleIntroduction()"
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
function toggleIntroduction() {
    const formDiv = document.getElementById('introduction-form');
    const chevron = document.getElementById('introduction-chevron');
    
    if (formDiv.classList.contains('hidden')) {
        // Expand
        formDiv.classList.remove('hidden');
        chevron.style.transform = 'rotate(90deg)';
        
        // Scroll to card
        setTimeout(() => {
            document.getElementById('introduction-card')?.scrollIntoView({ 
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

// Character counter
document.addEventListener('DOMContentLoaded', function() {
    const textarea = document.querySelector('textarea[name="introduction"]');
    const charCount = document.getElementById('intro-char-count');
    
    if (textarea && charCount) {
        function updateCount() {
            const count = textarea.value.length;
            charCount.textContent = count + ' / 1000';
            
            if (count > 900) {
                charCount.classList.add('text-plyform-orange', 'font-semibold');
                charCount.classList.remove('text-gray-500', 'font-medium');
            } else if (count > 0) {
                charCount.classList.add('text-plyform-dark', 'font-semibold');
                charCount.classList.remove('text-gray-500', 'font-medium');
            } else {
                charCount.classList.remove('text-plyform-orange', 'text-plyform-dark', 'font-semibold');
                charCount.classList.add('text-gray-500', 'font-medium');
            }
        }
        
        textarea.addEventListener('input', updateCount);
        updateCount(); // Initial count
    }
});
</script>