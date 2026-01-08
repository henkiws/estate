<aside id="sidebar" class="fixed left-0 top-0 z-40 h-screen w-64 bg-white border-r border-gray-200 transition-transform duration-300 -translate-x-full lg:translate-x-0">
    <div class="flex flex-col h-full">
        <!-- Logo -->
        <div class="flex items-center gap-3 p-6 border-b border-gray-200">
            <div class="w-10 h-10 bg-gradient-to-br from-plyform-yellow to-plyform-mint rounded-xl flex items-center justify-center flex-shrink-0">
                <span class="text-plyform-dark font-bold text-xl">P</span>
            </div>
            <span class="text-2xl font-bold text-plyform-dark">Plyform</span>
        </div>
        
        {{-- Agency Status Banner --}}
        @if(auth()->user()->agency && auth()->user()->agency->status === 'pending')
        <div class="mx-4 mt-4 p-3 bg-plyform-yellow/20 border border-plyform-yellow rounded-lg">
            <div class="flex items-start gap-2">
                <svg class="w-5 h-5 text-plyform-dark mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                <div>
                    <p class="text-xs font-semibold text-plyform-dark">Pending Approval</p>
                    <p class="text-xs text-gray-700 mt-1">Your agency is under review</p>
                </div>
            </div>
        </div>
        @endif
        
        <!-- Navigation -->
        <nav class="flex-1 overflow-y-auto p-4 space-y-1">
            <a href="{{ route('agency.dashboard') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('agency.dashboard') ? 'text-plyform-dark bg-gradient-to-r from-plyform-yellow to-plyform-mint font-semibold' : 'text-gray-700 hover:bg-plyform-mint/10' }} rounded-xl font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Dashboard
            </a>
            
            <a href="{{ route('agency.agents.index') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('agency.agents.*') ? 'text-plyform-dark bg-gradient-to-r from-plyform-yellow to-plyform-mint font-semibold' : 'text-gray-700 hover:bg-plyform-mint/10' }} rounded-xl font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                My Agents
                @php
                    $agentCount = auth()->user()->agency ? auth()->user()->agency->agents()->count() : 0;
                @endphp
                @if($agentCount > 0)
                    <span class="ml-auto bg-plyform-mint/30 text-plyform-dark text-xs font-bold px-2 py-1 rounded-full">{{ $agentCount }}</span>
                @endif
            </a>
            
            <a href="{{ route('agency.properties.index') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('agency.properties.*') ? 'text-plyform-dark bg-gradient-to-r from-plyform-yellow to-plyform-mint font-semibold' : 'text-gray-700 hover:bg-plyform-mint/10' }} rounded-xl font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
                Properties
            </a>

            <a href="{{ route('agency.applications.index') }}" class="flex items-center justify-between gap-3 px-4 py-3 {{ request()->routeIs('agency.applications.*') ? 'text-plyform-dark bg-gradient-to-r from-plyform-yellow to-plyform-mint font-semibold' : 'text-gray-700 hover:bg-plyform-mint/10' }} rounded-xl font-medium transition-colors">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Applications
                </div>
                @php
                    $pendingApplications = \App\Models\PropertyApplication::where('agency_id', auth()->user()->agency_id)
                        ->where('status', 'pending')
                        ->count();
                @endphp
                @if($pendingApplications > 0)
                    <span class="bg-plyform-orange text-white text-xs font-bold px-2 py-1 rounded-full animate-pulse">
                        {{ $pendingApplications }}
                    </span>
                @endif
            </a>
            
            <a href="{{ route('agency.tenants.index') }}" class="flex items-center justify-between gap-3 px-4 py-3 {{ request()->routeIs('agency.tenants.*') ? 'text-plyform-dark bg-gradient-to-r from-plyform-yellow to-plyform-mint font-semibold' : 'text-gray-700 hover:bg-plyform-mint/10' }} rounded-xl font-medium transition-colors">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    Tenants
                </div>
                @php
                    $activeTenants = \App\Models\Tenant::where('agency_id', auth()->user()->agency_id)
                        ->where('status', 'active')
                        ->count();
                @endphp
                @if($activeTenants > 0)
                    <span class="bg-plyform-mint/30 text-plyform-dark text-xs font-bold px-2 py-1 rounded-full">
                        {{ $activeTenants }}
                    </span>
                @endif
            </a>
            
            <a href="{{ route('agency.billing.index') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('agency.billing.*') ? 'text-plyform-dark bg-gradient-to-r from-plyform-yellow to-plyform-mint font-semibold' : 'text-gray-700 hover:bg-plyform-mint/10' }} rounded-xl font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                Billing & Payments
            </a>
            
            <a href="#" class="flex items-center gap-3 px-4 py-3 text-gray-700 hover:bg-plyform-mint/10 rounded-xl font-medium transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                Reports
            </a>
            
            <div class="pt-4 mt-4 border-t border-gray-200">
                <a href="{{ route('agency.profile.edit') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('agency.profile.edit') ? 'text-plyform-dark bg-gradient-to-r from-plyform-yellow to-plyform-mint font-semibold' : 'text-gray-700 hover:bg-plyform-mint/10' }} rounded-xl font-medium transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    Agency Profile
                </a>
                
                <a href="{{ route('agency.settings') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('agency.settings') ? 'text-plyform-dark bg-gradient-to-r from-plyform-yellow to-plyform-mint font-semibold' : 'text-gray-700 hover:bg-plyform-mint/10' }} rounded-xl font-medium transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    Settings
                </a>
                
                <a href="{{ route('agency.support.index') }}" class="flex items-center gap-3 px-4 py-3 text-gray-700 hover:bg-plyform-mint/10 rounded-xl font-medium transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Help & Support
                </a>
            </div>
        </nav>
        
        <!-- User Profile -->
        <div class="p-4 border-t border-gray-200">
            <div class="flex items-center gap-3 px-4 py-3 bg-gradient-to-r from-plyform-yellow/10 to-plyform-mint/10 rounded-xl border border-plyform-yellow/30">
                <div class="w-10 h-10 bg-gradient-to-br from-plyform-yellow to-plyform-mint rounded-full flex items-center justify-center text-plyform-dark font-bold flex-shrink-0">
                    {{ strtoupper(substr(Auth::user()->name,0,2)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <div class="font-semibold text-plyform-dark text-sm truncate">{{ Auth::user()->name }}</div>
                    <div class="text-xs text-gray-600 truncate">
                        @if(auth()->user()->agency)
                            {{ auth()->user()->agency->agency_name }}
                        @else
                            Agency Owner
                        @endif
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-plyform-orange hover:text-red-700 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                </button>
                </form>
            </div>
        </div>
    </div>
</aside>