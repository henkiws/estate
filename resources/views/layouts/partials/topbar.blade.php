<header class="sticky top-0 z-20 bg-white border-b border-gray-200 shadow-sm">
    <div class="flex items-center justify-between px-4 sm:px-6 py-4">
        <div class="flex items-center gap-3">
            <!-- Mobile Menu Button -->
            <button id="sidebarToggle" class="lg:hidden p-2 text-gray-600 hover:bg-plyform-yellow/10 rounded-lg transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
            
            <!-- Mobile Logo -->
            <div class="flex lg:hidden items-center gap-2">
                <img src="{{ asset('assets/images/logo-yellow.png') }}" alt="Plyform" class="h-8 w-auto">
                <span class="text-lg font-bold text-plyform-dark">Plyform</span>
            </div>
            
            <!-- Search (Desktop) -->
            <div class="hidden sm:block relative">
                <input 
                    type="search" 
                    placeholder="Search properties, tenants..." 
                    class="pl-10 pr-4 py-2.5 w-64 lg:w-80 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-plyform-yellow/20 focus:border-plyform-yellow transition-all"
                >
                <svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
        </div>
        
        <div class="flex items-center gap-2 sm:gap-3">
            <!-- Mobile Search Button -->
            <button id="mobileSearchToggle" class="sm:hidden p-2 text-gray-600 hover:bg-plyform-yellow/10 rounded-lg transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </button>
            
            <!-- Notifications Dropdown -->
            <div class="relative">
                <button id="notificationsBtn" class="relative p-2 text-gray-600 hover:bg-plyform-yellow/10 rounded-lg transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                    <span id="unreadBadge" class="absolute top-1 right-1 w-2 h-2 bg-plyform-orange rounded-full animate-pulse hidden"></span>
                    <span id="unreadCount" class="absolute -top-1 -right-1 bg-plyform-orange text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center hidden"></span>
                </button>
                
                <!-- Notifications Dropdown Menu -->
                <div id="notificationsDropdown" class="hidden absolute right-0 mt-2 w-80 sm:w-96 bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden z-50">
                    <div class="p-4 border-b border-gray-100 flex items-center justify-between">
                        <h3 class="font-bold text-plyform-dark">Notifications</h3>
                        <div class="flex items-center gap-2">
                            <span id="newNotifBadge" class="text-xs font-semibold text-plyform-dark bg-plyform-yellow px-2 py-1 rounded-full hidden"></span>
                            <button id="markAllReadBtn" class="text-xs font-semibold text-plyform-purple hover:text-plyform-dark transition hidden">
                                Mark all read
                            </button>
                        </div>
                    </div>
                    
                    <div id="notificationsContainer" class="max-h-96 overflow-y-auto custom-scrollbar">
                        <!-- Loading state -->
                        <div id="loadingNotifications" class="p-8 text-center">
                            <svg class="animate-spin h-8 w-8 text-plyform-purple mx-auto mb-2" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <p class="text-sm text-gray-600">Loading notifications...</p>
                        </div>
                        
                        <!-- Empty state -->
                        <div id="emptyNotifications" class="p-8 text-center hidden">
                            <svg class="w-16 h-16 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                            </svg>
                            <h3 class="text-sm font-medium text-gray-900 mb-1">No notifications</h3>
                            <p class="text-xs text-gray-600">You're all caught up!</p>
                        </div>
                        
                        <!-- Notifications will be dynamically inserted here -->
                        <div id="notificationsList"></div>
                    </div>
                    
                    <div class="p-3 border-t border-gray-100">
                        <button class="w-full py-2 text-sm font-semibold text-plyform-purple hover:bg-plyform-purple/10 rounded-lg transition-colors">
                            View All Notifications
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- User Profile Dropdown -->
            <div class="relative">
                <button id="userMenuBtn" class="flex items-center gap-2 p-1 hover:bg-plyform-yellow/10 rounded-lg transition-colors">
                    <div class="w-10 h-10 bg-gradient-to-br from-plyform-yellow to-plyform-mint rounded-full flex items-center justify-center text-plyform-dark font-bold text-sm border-2 border-plyform-yellow/30">
                        {{ strtoupper(substr(Auth::user()->name,0,2)) }}
                    </div>
                    <svg class="hidden sm:block w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                
                <!-- User Dropdown Menu -->
                <div id="userDropdown" class="hidden absolute right-0 mt-2 w-64 bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden z-50">
                    <div class="p-4 border-b border-gray-100">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-gradient-to-br from-plyform-yellow to-plyform-mint rounded-full flex items-center justify-center text-plyform-dark font-bold border-2 border-plyform-yellow/30">
                                {{ strtoupper(substr(Auth::user()->name,0,2)) }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-semibold text-plyform-dark truncate">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="p-2">
                        @if(auth()->user()->hasRole('admin'))
                            <a href="{{ route('admin.profile.show') }}" class="flex items-center gap-3 px-3 py-2.5 text-gray-700 hover:bg-plyform-mint/10 hover:text-plyform-dark rounded-lg transition-colors">
                                <svg class="w-5 h-5 text-plyform-purple" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                <span class="text-sm font-medium">My Profile</span>
                            </a>
                        @elseif(auth()->user()->hasRole('agency'))
                            <a href="{{ route('agency.profile.edit') }}" class="flex items-center gap-3 px-3 py-2.5 text-gray-700 hover:bg-plyform-mint/10 hover:text-plyform-dark rounded-lg transition-colors">
                                <svg class="w-5 h-5 text-plyform-purple" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                <span class="text-sm font-medium">My Profile</span>
                            </a>
                        @elseif(auth()->user()->hasRole('agent'))
                            <a href="#profile" class="flex items-center gap-3 px-3 py-2.5 text-gray-700 hover:bg-plyform-mint/10 hover:text-plyform-dark rounded-lg transition-colors">
                                <svg class="w-5 h-5 text-plyform-purple" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                <span class="text-sm font-medium">My Profile</span>
                            </a>
                        @else
                            <a href="#profile" class="flex items-center gap-3 px-3 py-2.5 text-gray-700 hover:bg-plyform-mint/10 hover:text-plyform-dark rounded-lg transition-colors">
                                <svg class="w-5 h-5 text-plyform-purple" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                <span class="text-sm font-medium">My Profile</span>
                            </a>
                        @endif
                        
                        <a href="#settings" class="flex items-center gap-3 px-3 py-2.5 text-gray-700 hover:bg-plyform-mint/10 hover:text-plyform-dark rounded-lg transition-colors">
                            <svg class="w-5 h-5 text-plyform-purple" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span class="text-sm font-medium">Settings</span>
                        </a>
                        
                        <a href="#billing" class="flex items-center gap-3 px-3 py-2.5 text-gray-700 hover:bg-plyform-mint/10 hover:text-plyform-dark rounded-lg transition-colors">
                            <svg class="w-5 h-5 text-plyform-purple" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                            </svg>
                            <span class="text-sm font-medium">Billing</span>
                        </a>
                        
                        <a href="#help" class="flex items-center gap-3 px-3 py-2.5 text-gray-700 hover:bg-plyform-mint/10 hover:text-plyform-dark rounded-lg transition-colors">
                            <svg class="w-5 h-5 text-plyform-purple" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="text-sm font-medium">Help & Support</span>
                        </a>
                    </div>
                    
                    <div class="p-2 border-t border-gray-100">
                        <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex items-center gap-3 w-full px-3 py-2.5 text-plyform-orange hover:bg-plyform-orange/10 rounded-lg transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            <span class="text-sm font-medium">Log Out</span>
                        </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Mobile Search Bar (Expandable) -->
    <div id="mobileSearchBar" class="hidden sm:hidden px-4 pb-4">
        <div class="relative">
            <input 
                type="search" 
                placeholder="Search properties, tenants..." 
                class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-plyform-yellow/20 focus:border-plyform-yellow"
            >
            <svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
        </div>
    </div>
</header>

<style>
    /* Custom Scrollbar for Notifications */
    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
    }

    .custom-scrollbar::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 3px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #E6FF4B;
        border-radius: 3px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #d4ed39;
    }
</style>