@php
    $profileCompletion = $profileCompletion ?? 0;
    $showDetails = $showDetails ?? false;
@endphp

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
    <div class="flex items-start justify-between">
        <div class="flex items-center gap-4">
            <!-- Icon -->
            <div class="flex-shrink-0">
                <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </div>
            
            <!-- Text -->
            <div>
                <h3 class="font-semibold text-gray-900">Profile completion</h3>
                <p class="text-sm text-gray-600">Get the most out of Sorted</p>
            </div>
        </div>
        
        <!-- Circular Progress -->
        <div class="relative flex items-center justify-center">
            <svg class="transform -rotate-90 w-16 h-16">
                <circle 
                    cx="32" 
                    cy="32" 
                    r="28" 
                    stroke="currentColor" 
                    stroke-width="4" 
                    fill="transparent"
                    class="text-gray-200"
                />
                <circle 
                    cx="32" 
                    cy="32" 
                    r="28" 
                    stroke="currentColor" 
                    stroke-width="4" 
                    fill="transparent"
                    stroke-dasharray="{{ 2 * pi() * 28 }}"
                    stroke-dashoffset="{{ 2 * pi() * 28 * (1 - $profileCompletion / 100) }}"
                    class="text-teal-500 transition-all duration-500"
                    stroke-linecap="round"
                />
            </svg>
            <span class="absolute text-sm font-bold text-gray-900">{{ $profileCompletion }}%</span>
        </div>
    </div>
    
    <!-- Show Progress Toggle -->
    <div class="mt-4">
        <button 
            onclick="toggleProfileDetails()"
            class="flex items-center gap-2 text-sm font-medium text-teal-600 hover:text-teal-700 transition"
        >
            <span id="toggle-text">Show progress</span>
            <svg id="toggle-icon" class="w-4 h-4 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </button>
    </div>
    
    <!-- Expandable Details -->
    <div id="profile-details" class="hidden mt-4 pt-4 border-t border-gray-100 space-y-3">
        
        <!-- Personal Details -->
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-2">
                @if($steps['personal'] ?? false)
                    <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                @else
                    <svg class="w-5 h-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm0-2a6 6 0 100-12 6 6 0 000 12z" clip-rule="evenodd"/>
                    </svg>
                @endif
                <span class="text-sm text-gray-700">Personal details</span>
            </div>
            @if(!($steps['personal'] ?? false))
                <a href="{{ route('user.profile.complete') }}" class="text-sm text-teal-600 hover:text-teal-700">Complete</a>
            @endif
        </div>
        
        <!-- Income Details -->
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-2">
                @if($steps['income'] ?? false)
                    <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                @else
                    <svg class="w-5 h-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm0-2a6 6 0 100-12 6 6 0 000 12z" clip-rule="evenodd"/>
                    </svg>
                @endif
                <span class="text-sm text-gray-700">Income details</span>
            </div>
            @if(!($steps['income'] ?? false))
                <a href="{{ route('user.profile.complete') }}" class="text-sm text-teal-600 hover:text-teal-700">Complete</a>
            @endif
        </div>
        
        <!-- Employment History -->
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-2">
                @if($steps['employment'] ?? false)
                    <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                @else
                    <svg class="w-5 h-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm0-2a6 6 0 100-12 6 6 0 000 12z" clip-rule="evenodd"/>
                    </svg>
                @endif
                <span class="text-sm text-gray-700">Employment history</span>
            </div>
            @if(!($steps['employment'] ?? false))
                <a href="{{ route('user.profile.complete') }}" class="text-sm text-teal-600 hover:text-teal-700">Complete</a>
            @endif
        </div>
        
        <!-- Identification -->
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-2">
                @if($steps['identification'] ?? false)
                    <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                @else
                    <svg class="w-5 h-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm0-2a6 6 0 100-12 6 6 0 000 12z" clip-rule="evenodd"/>
                    </svg>
                @endif
                <span class="text-sm text-gray-700">Identification ({{ $idPoints ?? 0 }}/80 points)</span>
            </div>
            @if(!($steps['identification'] ?? false))
                <a href="{{ route('user.profile.complete') }}" class="text-sm text-teal-600 hover:text-teal-700">Complete</a>
            @endif
        </div>
        
    </div>
</div>

<script>
function toggleProfileDetails() {
    const details = document.getElementById('profile-details');
    const icon = document.getElementById('toggle-icon');
    const text = document.getElementById('toggle-text');
    
    if (details.classList.contains('hidden')) {
        details.classList.remove('hidden');
        icon.classList.add('rotate-180');
        text.textContent = 'Hide progress';
    } else {
        details.classList.add('hidden');
        icon.classList.remove('rotate-180');
        text.textContent = 'Show progress';
    }
}
</script>