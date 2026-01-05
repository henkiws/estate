<aside id="sidebar" class="fixed left-0 top-0 z-40 h-screen w-64 bg-white border-r border-gray-100 transition-transform duration-300 -translate-x-full lg:translate-x-0">
    <div class="flex flex-col h-full">
        <!-- Logo -->
        <div class="flex items-center gap-3 p-6 border-b border-gray-100">
            <div class="w-10 h-10 bg-gradient-to-br from-[#DDEECD] to-[#4ADE80] rounded-xl flex items-center justify-center flex-shrink-0">
                <span class="text-gray-700 font-bold text-xl">P</span>
            </div>
            <span class="text-2xl font-bold text-gray-800">Plyform</span>
        </div>
        
        <!-- Navigation -->
        <nav class="flex-1 overflow-y-auto p-4 space-y-1">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('admin.dashboard') ? 'text-gray-800 bg-[#DDEECD] font-semibold' : 'text-gray-600 hover:bg-[#DDEECD]/50 hover:text-gray-800' }} rounded-xl transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Dashboard
            </a>
            
            <a href="{{ route('admin.agencies.index') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('admin.agencies.*') ? 'text-gray-800 bg-[#DDEECD] font-semibold' : 'text-gray-600 hover:bg-[#DDEECD]/50 hover:text-gray-800' }} rounded-xl transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
                Agencies
                @php
                    $pendingCount = \App\Models\Agency::where('status', 'pending')->count();
                @endphp
                @if($pendingCount > 0)
                    <span class="ml-auto bg-[#E6FF4B] text-gray-800 text-xs font-bold px-2 py-1 rounded-full">{{ $pendingCount }}</span>
                @endif
            </a>
            
            <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('admin.users.*') ? 'text-gray-800 bg-[#DDEECD] font-semibold' : 'text-gray-600 hover:bg-[#DDEECD]/50 hover:text-gray-800' }} rounded-xl transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                Users
            </a>
            
            {{-- <a href="{{ route('admin.properties.index') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('admin.properties.*') ? 'text-gray-800 bg-[#DDEECD] font-semibold' : 'text-gray-600 hover:bg-[#DDEECD]/50 hover:text-gray-800' }} rounded-xl transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Properties
            </a> --}}
            
            <a href="{{ route('admin.payments.index') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('admin.payments.*') ? 'text-gray-800 bg-[#DDEECD] font-semibold' : 'text-gray-600 hover:bg-[#DDEECD]/50 hover:text-gray-800' }} rounded-xl transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                Payments
            </a>
            
            <a href="{{ route('admin.reports.index') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('admin.reports.*') ? 'text-gray-800 bg-[#DDEECD] font-semibold' : 'text-gray-600 hover:bg-[#DDEECD]/50 hover:text-gray-800' }} rounded-xl transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                Reports
            </a>
            
            <div class="pt-4 mt-4 border-t border-gray-100">
                <a href="#" class="flex items-center gap-3 px-4 py-3 text-gray-600 hover:bg-[#DDEECD]/50 hover:text-gray-800 rounded-xl transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    Settings
                </a>
                
                <a href="{{ route('admin.support.tickets.index') }}" class="flex items-center gap-3 px-4 py-3 text-gray-600 hover:bg-[#DDEECD]/50 hover:text-gray-800 rounded-xl transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Help & Support
                </a>

                <a href="{{ route('admin.notifications.index') }}" 
                    class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('admin.notifications.*') ? 'text-gray-800 bg-[#DDEECD] font-semibold' : 'text-gray-600 hover:bg-[#DDEECD]/50 hover:text-gray-800' }} rounded-xl transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                        Notifications
                        @php
                            $pendingNotifications = \App\Models\Notification::where('type', 'broadcast')->pending()->count();
                        @endphp
                        @if($pendingNotifications > 0)
                            <span class="ml-auto bg-[#E6FF4B] text-gray-800 text-xs font-bold px-2 py-1 rounded-full">{{ $pendingNotifications }}</span>
                        @endif
                </a>
            </div>
        </nav>
        
        <!-- User Profile -->
        <div class="p-4 border-t border-gray-100">
            <div class="flex items-center gap-3 px-4 py-3 bg-[#DDEECD]/40 rounded-xl">
                <div class="w-10 h-10 bg-gradient-to-br from-[#E6FF4B] to-[#DDEECD] rounded-full flex items-center justify-center text-gray-700 font-bold flex-shrink-0">
                    {{ strtoupper(substr(Auth::user()->name,0,2)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <div class="font-semibold text-gray-800 text-sm truncate">{{ Auth::user()->name }}</div>
                    <div class="text-xs text-gray-600 truncate">Admin</div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-gray-400 hover:text-gray-700 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                </button>
                </form>
            </div>
        </div>
    </div>
</aside>