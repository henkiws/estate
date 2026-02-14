{{-- resources/views/user/partials/profile-completion-widget.blade.php --}}

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <!-- Header -->
    <div class="p-6 border-b border-gray-100">
        <div class="flex items-center justify-between mb-1">
            <div class="flex items-center gap-3">
                <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                <div>
                    <h3 class="text-lg font-bold text-gray-900">Profile completion</h3>
                    <p class="text-xs text-gray-500">Get the most out of Sorted</p>
                </div>
            </div>
            
            <!-- Circular Progress -->
            <div class="relative w-14 h-14">
                <svg class="transform -rotate-90 w-14 h-14">
                    <circle cx="28" cy="28" r="24" stroke="#e5e7eb" stroke-width="4" fill="none"/>
                    <circle 
                        cx="28" 
                        cy="28" 
                        r="24" 
                        stroke="#14b8a6" 
                        stroke-width="4" 
                        fill="none"
                        stroke-dasharray="{{ 2 * 3.14159 * 24 }}"
                        stroke-dashoffset="{{ 2 * 3.14159 * 24 * (1 - $profileCompletion / 100) }}"
                        stroke-linecap="round"
                        class="transition-all duration-500"
                    />
                </svg>
                <div class="absolute inset-0 flex items-center justify-center">
                    <span class="text-sm font-bold text-teal-600">{{ $profileCompletion }}%</span>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Collapsible Progress List -->
    <div id="progress-list" class="border-b border-gray-100">
        
        <!-- Personal Details -->
        <a href="{{ route('user.profile.complete') }}#personal-details" class="flex items-center justify-between p-4 hover:bg-gray-50 transition border-b border-gray-100 group">
            <div class="flex items-center gap-3 flex-1">
                @if($steps['personal'] ?? false)
                    <svg class="w-6 h-6 text-teal-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                @else
                    <svg class="w-6 h-6 text-gray-300 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v3.586L7.707 9.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 10.586V7z" clip-rule="evenodd"/>
                    </svg>
                @endif
                <span class="text-sm font-medium {{ ($steps['personal'] ?? false) ? 'text-gray-900' : 'text-gray-500' }}">Personal Details</span>
            </div>
            <svg class="w-5 h-5 text-teal-600 flex-shrink-0 opacity-0 group-hover:opacity-100 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </a>
        
        <!-- Introduction -->
        <a href="{{ route('user.profile.complete') }}#introduction" class="flex items-center justify-between p-4 hover:bg-gray-50 transition border-b border-gray-100 group">
            <div class="flex items-center gap-3 flex-1">
                @php
                    $introComplete = auth()->user()->profile && auth()->user()->profile->introduction;
                @endphp
                @if($introComplete)
                    <svg class="w-6 h-6 text-teal-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                @else
                    <svg class="w-6 h-6 text-gray-300 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v3.586L7.707 9.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 10.586V7z" clip-rule="evenodd"/>
                    </svg>
                @endif
                <span class="text-sm font-medium {{ $introComplete ? 'text-gray-900' : 'text-gray-500' }}">Introduction</span>
            </div>
            <svg class="w-5 h-5 text-teal-600 flex-shrink-0 opacity-0 group-hover:opacity-100 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </a>
        
        <!-- Current Income -->
        <a href="{{ route('user.profile.complete') }}#income" class="flex items-center justify-between p-4 hover:bg-gray-50 transition border-b border-gray-100 group">
            <div class="flex items-center gap-3 flex-1">
                @if($steps['income'] ?? false)
                    <svg class="w-6 h-6 text-teal-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                @else
                    <svg class="w-6 h-6 text-gray-300 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v3.586L7.707 9.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 10.586V7z" clip-rule="evenodd"/>
                    </svg>
                @endif
                <span class="text-sm font-medium {{ ($steps['income'] ?? false) ? 'text-gray-900' : 'text-gray-500' }}">Current Income</span>
            </div>
            <svg class="w-5 h-5 text-teal-600 flex-shrink-0 opacity-0 group-hover:opacity-100 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </a>
        
        <!-- Employment -->
        <a href="{{ route('user.profile.complete') }}#employment" class="flex items-center justify-between p-4 hover:bg-gray-50 transition border-b border-gray-100 group">
            <div class="flex items-center gap-3 flex-1">
                @if($steps['employment'] ?? false)
                    <svg class="w-6 h-6 text-teal-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                @else
                    <svg class="w-6 h-6 text-gray-300 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v3.586L7.707 9.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 10.586V7z" clip-rule="evenodd"/>
                    </svg>
                @endif
                <span class="text-sm font-medium {{ ($steps['employment'] ?? false) ? 'text-gray-900' : 'text-gray-500' }}">Employment</span>
            </div>
            <svg class="w-5 h-5 text-teal-600 flex-shrink-0 opacity-0 group-hover:opacity-100 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </a>
        
        <!-- Pets -->
        <a href="{{ route('user.profile.complete') }}#pets" class="flex items-center justify-between p-4 hover:bg-gray-50 transition border-b border-gray-100 group">
            <div class="flex items-center gap-3 flex-1">
                @php
                    $petsComplete = auth()->user()->pets && auth()->user()->pets->count() > 0;
                @endphp
                @if($petsComplete)
                    <svg class="w-6 h-6 text-teal-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                @else
                    <svg class="w-6 h-6 text-gray-300 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v3.586L7.707 9.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 10.586V7z" clip-rule="evenodd"/>
                    </svg>
                @endif
                <span class="text-sm font-medium {{ $petsComplete ? 'text-gray-900' : 'text-gray-500' }}">Pets</span>
            </div>
            <svg class="w-5 h-5 text-teal-600 flex-shrink-0 opacity-0 group-hover:opacity-100 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </a>
        
        <!-- Vehicles -->
        <a href="{{ route('user.profile.complete') }}#vehicles" class="flex items-center justify-between p-4 hover:bg-gray-50 transition border-b border-gray-100 group">
            <div class="flex items-center gap-3 flex-1">
                @php
                    $vehiclesComplete = auth()->user()->vehicles && auth()->user()->vehicles->count() > 0;
                @endphp
                @if($vehiclesComplete)
                    <svg class="w-6 h-6 text-teal-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                @else
                    <svg class="w-6 h-6 text-gray-300 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v3.586L7.707 9.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 10.586V7z" clip-rule="evenodd"/>
                    </svg>
                @endif
                <span class="text-sm font-medium {{ $vehiclesComplete ? 'text-gray-900' : 'text-gray-500' }}">Vehicles</span>
            </div>
            <svg class="w-5 h-5 text-teal-600 flex-shrink-0 opacity-0 group-hover:opacity-100 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </a>
        
        <!-- Address -->
        <a href="{{ route('user.profile.complete') }}#address-history" class="flex items-center justify-between p-4 hover:bg-gray-50 transition border-b border-gray-100 group">
            <div class="flex items-center gap-3 flex-1">
                @php
                    $addressComplete = auth()->user()->addresses && auth()->user()->addresses->count() > 0;
                @endphp
                @if($addressComplete)
                    <svg class="w-6 h-6 text-teal-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                @else
                    <svg class="w-6 h-6 text-gray-300 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v3.586L7.707 9.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 10.586V7z" clip-rule="evenodd"/>
                    </svg>
                @endif
                <span class="text-sm font-medium {{ $addressComplete ? 'text-gray-900' : 'text-gray-500' }}">Address</span>
            </div>
            <svg class="w-5 h-5 text-teal-600 flex-shrink-0 opacity-0 group-hover:opacity-100 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </a>
        
        <!-- Reference -->
        <a href="{{ route('user.profile.complete') }}#references" class="flex items-center justify-between p-4 hover:bg-gray-50 transition border-b border-gray-100 group">
            <div class="flex items-center gap-3 flex-1">
                @php
                    $referencesComplete = auth()->user()->references && auth()->user()->references->count() >= 2;
                @endphp
                @if($referencesComplete)
                    <svg class="w-6 h-6 text-teal-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                @else
                    <svg class="w-6 h-6 text-gray-300 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v3.586L7.707 9.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 10.586V7z" clip-rule="evenodd"/>
                    </svg>
                @endif
                <span class="text-sm font-medium {{ $referencesComplete ? 'text-gray-900' : 'text-gray-500' }}">Reference</span>
            </div>
            <svg class="w-5 h-5 text-teal-600 flex-shrink-0 opacity-0 group-hover:opacity-100 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </a>
        
        <!-- Identification -->
        <a href="{{ route('user.profile.complete') }}#identification" class="flex items-center justify-between p-4 hover:bg-gray-50 transition border-b border-gray-100 group">
            <div class="flex items-center gap-3 flex-1">
                @if($steps['identification'] ?? false)
                    <svg class="w-6 h-6 text-teal-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                @else
                    <svg class="w-6 h-6 text-gray-300 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v3.586L7.707 9.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 10.586V7z" clip-rule="evenodd"/>
                    </svg>
                @endif
                <span class="text-sm font-medium {{ ($steps['identification'] ?? false) ? 'text-gray-900' : 'text-gray-500' }}">Identification</span>
            </div>
            <svg class="w-5 h-5 text-teal-600 flex-shrink-0 opacity-0 group-hover:opacity-100 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </a>
        
        <!-- Terms & Conditions -->
        <a href="{{ route('user.profile.complete') }}#terms" class="flex items-center justify-between p-4 hover:bg-gray-50 transition group">
            <div class="flex items-center gap-3 flex-1">
                @php
                    $termsComplete = auth()->user()->profile && auth()->user()->profile->terms_accepted;
                @endphp
                @if($termsComplete)
                    <svg class="w-6 h-6 text-teal-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                @else
                    <svg class="w-6 h-6 text-gray-300 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v3.586L7.707 9.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 10.586V7z" clip-rule="evenodd"/>
                    </svg>
                @endif
                <span class="text-sm font-medium {{ $termsComplete ? 'text-gray-900' : 'text-gray-500' }}">Terms & Conditions</span>
            </div>
            <svg class="w-5 h-5 text-teal-600 flex-shrink-0 opacity-0 group-hover:opacity-100 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </a>
        
    </div>
    
    <!-- Show Progress Toggle Button -->
    <button 
        type="button"
        onclick="toggleProgressList()"
        class="w-full p-4 text-sm font-medium text-teal-600 hover:bg-gray-50 transition flex items-center justify-center gap-2"
        id="toggle-progress-btn"
    >
        <span id="toggle-progress-text">Show progress</span>
        <svg id="toggle-progress-icon" class="w-4 h-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
        </svg>
    </button>
</div>

<script>
function toggleProgressList() {
    const progressList = document.getElementById('progress-list');
    const toggleText = document.getElementById('toggle-progress-text');
    const toggleIcon = document.getElementById('toggle-progress-icon');
    
    if (progressList.classList.contains('hidden')) {
        // Show
        progressList.classList.remove('hidden');
        toggleText.textContent = 'Hide progress';
        toggleIcon.style.transform = 'rotate(180deg)';
    } else {
        // Hide
        progressList.classList.add('hidden');
        toggleText.textContent = 'Show progress';
        toggleIcon.style.transform = 'rotate(0deg)';
    }
}

// Hide progress list by default on page load
document.addEventListener('DOMContentLoaded', function() {
    const progressList = document.getElementById('progress-list');
    progressList.classList.add('hidden');
});
</script>