<div class="flex flex-col h-full">
    <!-- Logo -->
    <div class="p-6 border-b border-gray-200">
        <a href="{{ route('user.dashboard') }}" class="flex items-center">
            <span class="text-2xl font-bold">
                <span class="text-gray-900">s</span><span class="text-teal-500">o</span><span class="text-gray-900">rted</span>
            </span>
        </a>
    </div>
    
    <!-- Navigation Menu -->
    <nav class="flex-1 p-4 space-y-1">
        
        <!-- For you -->
        <a href="{{ route('user.dashboard') }}" 
           class="flex items-center gap-3 px-4 py-3 text-gray-700 rounded-lg transition {{ request()->routeIs('user.dashboard') ? 'bg-gray-100 font-semibold border-b-2 border-teal-500' : 'hover:bg-gray-50' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            <span>For you</span>
        </a>
        
        <!-- Your profile -->
        <a href="{{ route('user.profile.show') }}" 
           class="flex items-center gap-3 px-4 py-3 text-gray-700 rounded-lg transition {{ request()->routeIs('user.profile.*') ? 'bg-gray-100 font-semibold' : 'hover:bg-gray-50' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
            <span>Your profile</span>
        </a>
        
        <!-- Your applications -->
        <a href="{{ route('user.applications.index') }}" 
           class="flex items-center gap-3 px-4 py-3 text-gray-700 rounded-lg transition {{ request()->routeIs('user.applications.*') ? 'bg-gray-100 font-semibold' : 'hover:bg-gray-50' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <span>Your applications</span>
        </a>
        
        <!-- Your groups -->
        <a href="#" 
           class="flex items-center gap-3 px-4 py-3 text-gray-700 rounded-lg transition hover:bg-gray-50">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
            </svg>
            <span>Your groups</span>
        </a>
        
    </nav>
    
    <!-- Bottom Help Section (Optional) -->
    <div class="p-4 border-t border-gray-200">
        <a href="#" class="flex items-center gap-3 px-4 py-3 text-gray-600 rounded-lg hover:bg-gray-50 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span class="text-sm">Help & Support</span>
        </a>
    </div>
</div>