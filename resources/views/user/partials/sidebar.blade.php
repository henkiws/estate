<div class="flex flex-col h-full">
    <!-- Logo -->
    <div class="p-6 border-b border-gray-200">
        <a href="{{ route('user.dashboard') }}" class="flex items-center group">
            <img src="{{ asset('assets/images/logo-yellow.png') }}" alt="plyform" class="h-8 w-auto transition-transform duration-300 group-hover:scale-105">
        </a>
    </div>
    
    <!-- Navigation Menu -->
    <nav class="flex-1 p-4 space-y-1">
        
        <!-- For you / Dashboard -->
        <a href="{{ route('user.dashboard') }}" 
           class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all group {{ request()->routeIs('user.dashboard') ? 'bg-gradient-to-r from-plyform-yellow to-plyform-yellow/80 text-plyform-dark font-semibold shadow-md' : 'text-gray-700 hover:bg-plyform-mint/20 hover:text-plyform-dark' }}">
            <svg class="w-5 h-5 {{ request()->routeIs('user.dashboard') ? 'text-plyform-dark' : 'text-gray-400 group-hover:text-plyform-dark' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            <span>For you</span>
        </a>
        
        <!-- Your profile -->
        <a href="{{ route('user.profile.overview') }}" 
           class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all group {{ request()->routeIs('user.profile.*') ? 'bg-gradient-to-r from-plyform-yellow to-plyform-yellow/80 text-plyform-dark font-semibold shadow-md' : 'text-gray-700 hover:bg-plyform-mint/20 hover:text-plyform-dark' }}">
            <svg class="w-5 h-5 {{ request()->routeIs('user.profile.*') ? 'text-plyform-purple' : 'text-gray-400 group-hover:text-plyform-dark' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
            <span>Your profile</span>
            @if(auth()->user()->userProfile && auth()->user()->userProfile->status === 'draft')
                <span class="ml-auto flex items-center justify-center w-6 h-6 bg-plyform-orange text-white text-xs font-bold rounded-full">
                    !
                </span>
            @endif
        </a>

        <a href="{{ route('user.notifications.index') }}"  class="flex items-center justify-between gap-3 px-4 py-3 {{ request()->routeIs('user.notifications.*') ? 'text-teal-700 bg-teal-50 font-semibold' : 'text-gray-700 hover:bg-plyform-mint/20 hover:text-plyform-dark' }} rounded-xl transition-colors">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
                Notifications
            </div>
            @php
                $unreadNotifications = \App\Models\Notification::where('recipient_id', auth()->id())
                    ->unread()
                    ->count();
            @endphp
            @if($unreadNotifications > 0)
                <span class="bg-plyform-orange text-white text-xs font-bold px-2 py-1 rounded-full">
                    {{ $unreadNotifications > 9 ? '9+' : $unreadNotifications }}
                </span>
            @endif
        </a>
        
        <!-- Your applications -->
        <a href="{{ route('user.applications.index') }}" 
           class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all group {{ request()->routeIs('user.applications.*') ? 'bg-gradient-to-r from-plyform-yellow to-plyform-yellow/80 text-plyform-dark font-semibold shadow-md' : 'text-gray-700 hover:bg-plyform-mint/20 hover:text-plyform-dark' }}">
            <svg class="w-5 h-5 {{ request()->routeIs('user.applications.*') ? 'text-plyform-dark' : 'text-gray-400 group-hover:text-plyform-dark' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <span>Your applications</span>
        </a>
        
        <!-- Your groups -->
        <a href="#" 
           class="flex items-center gap-3 px-4 py-3 text-gray-700 rounded-xl transition-all group hover:bg-plyform-mint/20 hover:text-plyform-dark">
            <svg class="w-5 h-5 text-gray-400 group-hover:text-plyform-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
            </svg>
            <span>Your groups</span>
        </a>

        <!-- Divider -->
        <div class="pt-4 pb-2">
            <div class="border-t border-gray-200"></div>
        </div>

        <!-- Saved Properties -->
        <a href="{{ route('user.saved-properties.index') }}" 
        class="flex items-center gap-3 px-4 py-3 text-gray-700 rounded-xl transition-all group hover:bg-plyform-mint/20 hover:text-plyform-dark {{ request()->routeIs('user.saved-properties.*') ? 'bg-gradient-to-r from-plyform-yellow to-plyform-yellow/80 text-plyform-dark font-semibold shadow-md' : 'text-gray-700 hover:bg-plyform-mint/20 hover:text-plyform-dark' }}">
            <svg class="w-5 h-5 text-gray-400 group-hover:text-plyform-dark {{ request()->routeIs('user.saved-properties.*') ? 'text-plyform-dark' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
            </svg>
            <span>Saved Properties</span>
        </a>
        
    </nav>
    
    <!-- Profile Completion Card (if profile incomplete) -->
    @if(auth()->user()->userProfile && auth()->user()->userProfile->status === 'draft')
    <div class="mx-4 mb-4 p-4 bg-gradient-to-br from-plyform-yellow/20 to-plyform-mint/30 border-2 border-plyform-yellow/50 rounded-xl">
        <div class="flex items-start gap-3">
            <div class="flex-shrink-0 w-8 h-8 bg-plyform-yellow rounded-full flex items-center justify-center">
                <svg class="w-4 h-4 text-plyform-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-semibold text-plyform-dark mb-1">Complete your profile</p>
                <p class="text-xs text-gray-600 mb-2">Fill in all required information to apply for properties</p>
                <a href="{{ route('user.profile.view') }}" class="inline-flex items-center gap-1 text-xs font-semibold text-plyform-purple hover:text-plyform-dark transition-colors">
                    Continue
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>
    @endif
    
    <!-- Bottom Help Section -->
    <div class="p-4 border-t border-gray-200">
        <a href="{{ route('user.support.index') }}" class="flex items-center gap-3 px-4 py-3 text-gray-600 rounded-xl hover:bg-plyform-mint/20 hover:text-plyform-dark transition-all group">
            <svg class="w-5 h-5 text-gray-400 group-hover:text-plyform-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span class="text-sm font-medium">Help & Support</span>
        </a>
    </div>
</div>