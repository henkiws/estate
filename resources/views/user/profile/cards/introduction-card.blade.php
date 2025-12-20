<!-- Introduction Card -->
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-4" id="introduction-card">
    
    <!-- Card Header (Always Visible) -->
    <div class="p-6">
        <div class="flex items-start justify-between">
            
            <!-- Left: Icon + Content -->
            <div class="flex items-start gap-4 flex-1">
                <!-- Icon -->
                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-500 to-teal-500 flex items-center justify-center text-white flex-shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                </div>
                
                <!-- Content -->
                <div class="flex-1">
                    <h3 class="text-lg font-semibold text-gray-900">Introduction</h3>
                    <p class="text-sm text-gray-500 mt-1" id="introduction-summary">
                        @if($profile && $profile->introduction)
                            {{ Str::limit($profile->introduction, 100) }}
                        @else
                            Not completed yet
                        @endif
                    </p>
                    
                    <!-- Status Badge -->
                    <div class="mt-3">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $profile && $profile->introduction ? 'bg-teal-50 text-teal-700 border border-teal-200' : 'bg-gray-50 text-gray-700 border border-gray-200' }}" id="introduction-status">
                            @if($profile && $profile->introduction)
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
                <div class="flex items-center justify-center w-14 h-14 rounded-full border-4 {{ $profile && $profile->introduction ? 'border-teal-500' : 'border-gray-300' }} bg-white">
                    <span class="text-sm font-bold {{ $profile && $profile->introduction ? 'text-teal-600' : 'text-gray-400' }}" id="introduction-percentage">
                        @if($profile && $profile->introduction)
                            100%
                        @else
                            0%
                        @endif
                    </span>
                </div>
                
                <!-- Edit Button -->
                <button 
                    type="button" 
                    onclick="toggleIntroduction()"
                    class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-teal-600 hover:text-teal-700 hover:bg-teal-50 rounded-lg transition"
                    id="introduction-edit-btn"
                >
                    <span>Edit</span>
                    <svg class="w-4 h-4 transition-transform" id="introduction-chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
            </div>
            
        </div>
    </div>
    
    <!-- Expandable Form Content (Hidden by Default) -->
    <div class="border-t border-gray-200 bg-gray-50 hidden" id="introduction-form">
        <form method="POST" action="{{ route('user.profile.update-step') }}" class="p-6 space-y-6">
            @csrf
            <input type="hidden" name="current_step" value="2">
            
            <!-- Introduction Section -->
            <div class="bg-white rounded-lg p-6 space-y-4">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h4 class="text-base font-semibold text-gray-900">Tell Us About Yourself</h4>
                        <p class="text-sm text-gray-500 mt-1">Share a brief introduction to help property managers get to know you better</p>
                    </div>
                </div>
                
                <!-- Introduction Textarea -->
                <div>
                    <label class="flex items-center gap-2 text-sm font-medium text-gray-700 mb-2">
                        Introduction
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
                        <span class="text-xs text-gray-500" id="intro-char-count">0 / 1000</span>
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
                    class="px-8 py-3 bg-gradient-to-r from-blue-600 to-teal-600 text-white font-semibold rounded-lg hover:from-blue-700 hover:to-teal-700 transition shadow-sm flex items-center gap-2"
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
function toggleIntroduction() {
    const formDiv = document.getElementById('introduction-form');
    const chevron = document.getElementById('introduction-chevron');
    const editBtn = document.getElementById('introduction-edit-btn');
    
    if (formDiv.classList.contains('hidden')) {
        // Expand
        formDiv.classList.remove('hidden');
        chevron.style.transform = 'rotate(180deg)';
        editBtn.querySelector('span').textContent = 'Close';
        
        // Scroll to card
        setTimeout(() => {
            document.getElementById('introduction-card').scrollIntoView({ 
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

// Character counter
document.addEventListener('DOMContentLoaded', function() {
    const textarea = document.querySelector('textarea[name="introduction"]');
    const charCount = document.getElementById('intro-char-count');
    
    if (textarea && charCount) {
        function updateCount() {
            const count = textarea.value.length;
            charCount.textContent = count + ' / 1000';
            
            if (count > 900) {
                charCount.classList.add('text-orange-600');
                charCount.classList.remove('text-gray-500');
            } else {
                charCount.classList.remove('text-orange-600');
                charCount.classList.add('text-gray-500');
            }
        }
        
        textarea.addEventListener('input', updateCount);
        updateCount(); // Initial count
    }
});
</script>