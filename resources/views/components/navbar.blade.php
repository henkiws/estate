<nav id="navbar" class="fixed top-0 left-0 right-0 z-50 transition-all duration-300 bg-white/98 backdrop-blur-lg navbar-blur shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <!-- Logo -->
                <a href="#" class="flex items-center space-x-2 z-50 relative">
                    <div class="w-10 h-10 bg-gradient-to-br from-primary to-primary-dark rounded-lg flex items-center justify-center">
                        <span class="text-white font-bold text-xl">S</span>
                    </div>
                    <span class="text-2xl font-bold text-gray-900 hidden sm:inline">Sorted</span>
                </a>
                
                <!-- Desktop Navigation -->
                <div class="hidden lg:flex items-center space-x-1">
                    <a href="#for-tenants" class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-primary hover:bg-primary-light/50 rounded-lg transition-all">For Tenants</a>
                    <a href="#for-landlords" class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-primary hover:bg-primary-light/50 rounded-lg transition-all">For Landlords</a>
                    <a href="#for-agents" class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-primary hover:bg-primary-light/50 rounded-lg transition-all">For Agents</a>
                    <a href="#how-it-works" class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-primary hover:bg-primary-light/50 rounded-lg transition-all">How it Works</a>
                    <a href="#about" class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-primary hover:bg-primary-light/50 rounded-lg transition-all">About</a>
                </div>
                
                <!-- Desktop Actions -->
                <div class="hidden lg:flex items-center space-x-3">
                    <a href="{{ route('login') }}" class="px-5 py-2.5 text-sm font-semibold text-gray-700 hover:text-primary transition-colors">Log In</a>
                    <a href="{{ route('register') }}" class="px-6 py-2.5 text-sm font-semibold text-white bg-primary hover:bg-primary-dark rounded-full shadow-lg shadow-primary/25 hover:shadow-xl hover:shadow-primary/35 hover:-translate-y-0.5 transition-all">Sign Up</a>
                </div>
                
                <!-- Mobile Menu Toggle -->
                <button id="mobileMenuToggle" class="lg:hidden flex flex-col justify-center items-center w-10 h-10 z-50 relative" aria-label="Toggle menu">
                    <span class="w-6 h-0.5 bg-gray-900 transition-all duration-300 rounded mb-1.5"></span>
                    <span class="w-6 h-0.5 bg-gray-900 transition-all duration-300 rounded mb-1.5"></span>
                    <span class="w-6 h-0.5 bg-gray-900 transition-all duration-300 rounded"></span>
                </button>

                <!-- Mobile Menu -->
                <div id="navMenu" class="fixed lg:hidden top-0 right-0 w-full max-w-sm h-screen bg-white shadow-2xl transition-transform duration-300 translate-x-full overflow-y-auto">
                    <div class="flex flex-col h-full pt-24 px-6 pb-8">
                        <nav class="flex-1">
                            <ul class="space-y-2">
                                <li><a href="#for-tenants" class="block px-4 py-3 text-base font-medium text-gray-700 hover:text-primary hover:bg-primary-light/50 rounded-lg transition-all">For Tenants</a></li>
                                <li><a href="#for-landlords" class="block px-4 py-3 text-base font-medium text-gray-700 hover:text-primary hover:bg-primary-light/50 rounded-lg transition-all">For Landlords</a></li>
                                <li><a href="#for-agents" class="block px-4 py-3 text-base font-medium text-gray-700 hover:text-primary hover:bg-primary-light/50 rounded-lg transition-all">For Agents</a></li>
                                <li><a href="#how-it-works" class="block px-4 py-3 text-base font-medium text-gray-700 hover:text-primary hover:bg-primary-light/50 rounded-lg transition-all">How it Works</a></li>
                                <li><a href="#about" class="block px-4 py-3 text-base font-medium text-gray-700 hover:text-primary hover:bg-primary-light/50 rounded-lg transition-all">About</a></li>
                            </ul>
                        </nav>
                        <div class="space-y-3 pt-6 border-t border-gray-200">
                            <a href="{{ route('login') }}" class="block w-full px-6 py-3 text-center text-base font-semibold text-gray-700 hover:text-primary hover:bg-primary-light/50 rounded-full transition-all">Log In</a>
                            <a href="{{ route('register') }}" class="block w-full px-6 py-3 text-center text-base font-semibold text-white bg-primary hover:bg-primary-dark rounded-full shadow-lg shadow-primary/25 transition-all">Sign Up</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>