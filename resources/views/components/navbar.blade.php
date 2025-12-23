<nav id="navbar" class="fixed top-0 left-0 right-0 z-50 transition-all duration-300 bg-white/95 backdrop-blur-lg shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">
            <!-- Logo -->
            <a href="{{ route('homepage') }}" class="flex items-center space-x-2 z-50 relative group">
                <img src="{{ asset('assets/images/logo-yellow.png') }}" alt="plyform" class="h-10 w-auto transition-transform duration-300 group-hover:scale-105">
            </a>
            
            <!-- Desktop Navigation -->
            <div class="hidden lg:flex items-center space-x-1">
                <a href="#for-tenants" class="px-4 py-2 text-sm font-medium text-plyform-dark hover:text-plyform-purple hover:bg-plyform-mint/50 rounded-lg transition-all">For Tenants</a>
                <a href="#for-landlords" class="px-4 py-2 text-sm font-medium text-plyform-dark hover:text-plyform-purple hover:bg-plyform-mint/50 rounded-lg transition-all">For Landlords</a>
                <a href="#for-agents" class="px-4 py-2 text-sm font-medium text-plyform-dark hover:text-plyform-purple hover:bg-plyform-mint/50 rounded-lg transition-all">For Agents</a>
                <a href="#how-it-works" class="px-4 py-2 text-sm font-medium text-plyform-dark hover:text-plyform-purple hover:bg-plyform-mint/50 rounded-lg transition-all">How it Works</a>
                <a href="#about" class="px-4 py-2 text-sm font-medium text-plyform-dark hover:text-plyform-purple hover:bg-plyform-mint/50 rounded-lg transition-all">About</a>
            </div>
            
            <!-- Desktop Actions -->
            <div class="hidden lg:flex items-center space-x-3">
                @auth
                    <!-- Logged In User -->
                    <div class="flex items-center gap-3">
                        <!-- Dashboard Link based on Role -->
                        @if(Auth::user()->hasRole('admin'))
                            <a href="{{ route('admin.dashboard') }}" class="px-5 py-2.5 text-sm font-semibold text-plyform-dark hover:text-plyform-purple transition-colors">
                                Admin Dashboard
                            </a>
                        @elseif(Auth::user()->hasRole('agency'))
                            <a href="{{ route('agency.dashboard') }}" class="px-5 py-2.5 text-sm font-semibold text-plyform-dark hover:text-plyform-purple transition-colors">
                                Agency Dashboard
                            </a>
                        @elseif(Auth::user()->hasRole('agent'))
                            <a href="{{ route('agent.dashboard') }}" class="px-5 py-2.5 text-sm font-semibold text-plyform-dark hover:text-plyform-purple transition-colors">
                                Agent Dashboard
                            </a>
                        @elseif(Auth::user()->hasRole('user'))
                            <a href="{{ route('user.dashboard') }}" class="px-5 py-2.5 text-sm font-semibold text-plyform-dark hover:text-plyform-purple transition-colors">
                                My Dashboard
                            </a>
                        @endif

                        <!-- User Dropdown -->
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" class="flex items-center gap-2 px-4 py-2 rounded-full hover:bg-plyform-mint transition-colors">
                                <div class="w-8 h-8 rounded-full bg-plyform-yellow flex items-center justify-center text-plyform-dark font-bold text-sm">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                                <span class="text-sm font-medium text-plyform-dark">{{ Auth::user()->name }}</span>
                                <svg class="w-4 h-4 text-plyform-dark transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>

                            <!-- Dropdown Menu -->
                            <div x-show="open" 
                                 @click.away="open = false"
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 scale-95"
                                 x-transition:enter-end="opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-150"
                                 x-transition:leave-start="opacity-100 scale-100"
                                 x-transition:leave-end="opacity-0 scale-95"
                                 class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-plyform-lg border border-gray-100 py-2 z-50"
                                 style="display: none;">
                                
                                <!-- Role-specific menu items -->
                                @if(Auth::user()->hasRole('admin'))
                                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-plyform-dark hover:bg-plyform-mint transition-colors">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                                        </svg>
                                        Admin Dashboard
                                    </a>
                                @elseif(Auth::user()->hasRole('agency'))
                                    <a href="{{ route('agency.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-plyform-dark hover:bg-plyform-mint transition-colors">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                        </svg>
                                        Agency Dashboard
                                    </a>
                                    <a href="{{ route('agency.properties.index') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-plyform-dark hover:bg-plyform-mint transition-colors">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                        </svg>
                                        My Properties
                                    </a>
                                    <a href="{{ route('agency.subscription.success') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-plyform-dark hover:bg-plyform-mint transition-colors">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                        </svg>
                                        Subscription
                                    </a>
                                @elseif(Auth::user()->hasRole('agent'))
                                    <a href="{{ route('agent.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-plyform-dark hover:bg-plyform-mint transition-colors">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                                        </svg>
                                        Agent Dashboard
                                    </a>
                                    <a href="{{ route('agent.properties') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-plyform-dark hover:bg-plyform-mint transition-colors">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                        </svg>
                                        My Properties
                                    </a>
                                @elseif(Auth::user()->hasRole('user'))
                                    <a href="{{ route('user.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-plyform-dark hover:bg-plyform-mint transition-colors">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                                        </svg>
                                        My Dashboard
                                    </a>
                                    <a href="{{ route('user.saved-properties.index') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-plyform-dark hover:bg-plyform-mint transition-colors">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                        </svg>
                                        Saved Properties
                                    </a>
                                    <a href="{{ route('user.applications.index') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-plyform-dark hover:bg-plyform-mint transition-colors">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        My Applications
                                    </a>
                                    <a href="{{ route('user.enquiries.index') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-plyform-dark hover:bg-plyform-mint transition-colors">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                        </svg>
                                        My Enquiries
                                    </a>
                                @endif

                                <div class="my-2 border-t border-gray-200"></div>

                                <!-- Browse Properties (for all logged in users) -->
                                <a href="{{ route('properties.index') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-plyform-dark hover:bg-plyform-mint transition-colors">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                    </svg>
                                    Browse Properties
                                </a>

                                <div class="my-2 border-t border-gray-200"></div>

                                <!-- Logout -->
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="flex items-center gap-3 px-4 py-2.5 text-sm text-plyform-orange hover:bg-red-50 transition-colors w-full text-left rounded-lg">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                        </svg>
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Not Logged In -->
                    <a href="{{ route('login') }}" class="px-5 py-2.5 text-sm font-semibold text-plyform-dark hover:text-plyform-purple transition-colors">Log In</a>
                    <a href="{{ route('register') }}" class="px-6 py-2.5 text-sm font-semibold text-plyform-dark bg-plyform-yellow hover:bg-plyform-yellow/90 rounded-full shadow-lg shadow-plyform-yellow/25 hover:shadow-xl hover:shadow-plyform-yellow/35 hover:-translate-y-0.5 transition-all">Sign Up</a>
                @endauth
            </div>
            
            <!-- Mobile Menu Toggle -->
            <button id="mobile-menu-toggle" class="lg:hidden flex flex-col justify-center items-center w-10 h-10 z-50 relative" aria-label="Toggle menu">
                <span class="w-6 h-0.5 bg-plyform-dark transition-all duration-300 rounded mb-1.5"></span>
                <span class="w-6 h-0.5 bg-plyform-dark transition-all duration-300 rounded mb-1.5"></span>
                <span class="w-6 h-0.5 bg-plyform-dark transition-all duration-300 rounded"></span>
            </button>

            <!-- Mobile Menu -->
            <div id="nav-menu" class="fixed lg:hidden top-0 right-0 w-full max-w-sm h-screen bg-white shadow-2xl transition-transform duration-300 translate-x-full overflow-y-auto">
                <div class="flex flex-col h-full pt-24 px-6 pb-8">
                    <nav class="flex-1">
                        <ul class="space-y-2">
                            <li><a href="#for-tenants" class="block px-4 py-3 text-base font-medium text-plyform-dark hover:text-plyform-purple hover:bg-plyform-mint/50 rounded-lg transition-all">For Tenants</a></li>
                            <li><a href="#for-landlords" class="block px-4 py-3 text-base font-medium text-plyform-dark hover:text-plyform-purple hover:bg-plyform-mint/50 rounded-lg transition-all">For Landlords</a></li>
                            <li><a href="#for-agents" class="block px-4 py-3 text-base font-medium text-plyform-dark hover:text-plyform-purple hover:bg-plyform-mint/50 rounded-lg transition-all">For Agents</a></li>
                            <li><a href="#how-it-works" class="block px-4 py-3 text-base font-medium text-plyform-dark hover:text-plyform-purple hover:bg-plyform-mint/50 rounded-lg transition-all">How it Works</a></li>
                            <li><a href="#about" class="block px-4 py-3 text-base font-medium text-plyform-dark hover:text-plyform-purple hover:bg-plyform-mint/50 rounded-lg transition-all">About</a></li>
                        </ul>
                    </nav>
                    <div class="space-y-3 pt-6 border-t border-gray-200">
                        @auth
                            <!-- Mobile Logged In Menu -->
                            @if(Auth::user()->hasRole('admin'))
                                <a href="{{ route('admin.dashboard') }}" class="block w-full px-6 py-3 text-center text-base font-semibold text-plyform-dark bg-plyform-yellow hover:bg-plyform-yellow/90 rounded-full transition-all">Admin Dashboard</a>
                            @elseif(Auth::user()->hasRole('agency'))
                                <a href="{{ route('agency.dashboard') }}" class="block w-full px-6 py-3 text-center text-base font-semibold text-plyform-dark bg-plyform-yellow hover:bg-plyform-yellow/90 rounded-full transition-all">Agency Dashboard</a>
                            @elseif(Auth::user()->hasRole('agent'))
                                <a href="{{ route('agent.dashboard') }}" class="block w-full px-6 py-3 text-center text-base font-semibold text-plyform-dark bg-plyform-yellow hover:bg-plyform-yellow/90 rounded-full transition-all">Agent Dashboard</a>
                            @elseif(Auth::user()->hasRole('user'))
                                <a href="{{ route('user.dashboard') }}" class="block w-full px-6 py-3 text-center text-base font-semibold text-plyform-dark bg-plyform-yellow hover:bg-plyform-yellow/90 rounded-full transition-all">My Dashboard</a>
                            @endif
                            
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full px-6 py-3 text-center text-base font-semibold text-plyform-orange hover:bg-red-50 rounded-full transition-all">Logout</button>
                            </form>
                        @else
                            <!-- Mobile Not Logged In -->
                            <a href="{{ route('login') }}" class="block w-full px-6 py-3 text-center text-base font-semibold text-plyform-dark hover:text-plyform-purple hover:bg-plyform-mint/50 rounded-full transition-all">Log In</a>
                            <a href="{{ route('register') }}" class="block w-full px-6 py-3 text-center text-base font-semibold text-plyform-dark bg-plyform-yellow hover:bg-plyform-yellow/90 rounded-full shadow-lg shadow-plyform-yellow/25 transition-all">Sign Up</a>
                        @endauth
                    </div>

                    <!-- Decorative Element -->
                    <div class="mt-8 flex justify-center">
                        <div class="plyform-star plyform-star-lg opacity-20"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>

<!-- Alpine.js for dropdown -->
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endpush