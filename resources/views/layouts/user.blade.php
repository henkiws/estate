<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/images/ico-yellow.png') }}">
    <title>{{ config('app.name', 'plyform') }} - @yield('title', 'Dashboard')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800" rel="stylesheet" />
    
    <!-- Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @include('user.profile.shared-assets-styles')
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        
        /* plyform Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #E6FF4B;
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #d4ed3a;
        }
    </style>
    
    @stack('styles')
</head>
<body class="bg-gray-50 min-h-screen">
    
    <!-- Mobile Menu Overlay -->
    <div id="mobile-menu-overlay" class="hidden fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden"></div>
    
    <!-- Sidebar -->
    <aside id="sidebar" class="fixed top-0 left-0 w-64 h-full bg-white border-r border-gray-200 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out z-50">
        @include('user.partials.sidebar')
    </aside>
    
    <!-- Main Content -->
    <div class="lg:ml-64 min-h-screen flex flex-col">
        
        <!-- Top Header -->
        <header class="bg-white border-b border-gray-200 sticky top-0 z-30">
            <div class="px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
                
                <!-- Mobile Menu Button -->
                <button id="mobile-menu-button" class="lg:hidden p-2 rounded-lg text-gray-600 hover:bg-plyform-mint/30 hover:text-plyform-dark transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
                
                <!-- Search Bar -->
                <div class="flex-1 max-w-2xl mx-4">
                    <div class="relative">
                        <input 
                            type="text" 
                            placeholder="Search properties, applications..." 
                            class="w-full pl-10 pr-4 py-2 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-4 focus:ring-plyform-yellow/10 focus:border-plyform-yellow transition-all"
                        >
                        <svg class="absolute left-3 top-2.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                </div>
                
                <!-- Notifications & User Menu -->
                <div class="flex items-center gap-3">
                    <!-- Notifications -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="relative p-2 rounded-lg text-gray-600 hover:bg-plyform-mint/30 hover:text-plyform-dark transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                            </svg>
                            <!-- Notification Badge -->
                            <span class="absolute top-1 right-1 w-2 h-2 bg-plyform-orange rounded-full"></span>
                        </button>
                        
                        <!-- Notifications Dropdown -->
                        <div 
                            x-show="open" 
                            @click.away="open = false"
                            x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95"
                            class="absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-lg border border-gray-200 py-2"
                            style="display: none;"
                        >
                            <div class="px-4 py-2 border-b border-gray-200">
                                <h3 class="font-semibold text-plyform-dark">Notifications</h3>
                            </div>
                            <div class="max-h-96 overflow-y-auto">
                                <!-- Sample Notification -->
                                <a href="#" class="block px-4 py-3 hover:bg-plyform-mint/20 transition-colors">
                                    <div class="flex gap-3">
                                        <div class="w-10 h-10 rounded-full bg-plyform-yellow flex items-center justify-center flex-shrink-0">
                                            <svg class="w-5 h-5 text-plyform-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-plyform-dark">Application Approved</p>
                                            <p class="text-xs text-gray-600 mt-1">Your application for 123 Main St has been approved</p>
                                            <p class="text-xs text-gray-400 mt-1">2 hours ago</p>
                                        </div>
                                    </div>
                                </a>
                                <!-- Empty State -->
                                <div class="px-4 py-8 text-center text-gray-500 text-sm hidden">
                                    <svg class="w-12 h-12 mx-auto mb-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                                    </svg>
                                    No new notifications
                                </div>
                            </div>
                            <div class="px-4 py-2 border-t border-gray-200">
                                <a href="#" class="text-sm text-plyform-purple hover:text-plyform-dark font-semibold">View all notifications</a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- User Menu -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center gap-2 text-gray-700 hover:text-plyform-dark transition-colors">
                            <div class="w-8 h-8 rounded-full bg-plyform-yellow flex items-center justify-center">
                                <span class="text-sm font-semibold text-plyform-dark">{{ substr(auth()->user()->name ?? 'U', 0, 1) }}</span>
                            </div>
                            <span class="hidden sm:inline font-medium">{{ auth()->user()->name ?? 'You' }}</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        
                        <!-- Dropdown Menu -->
                        <div 
                            x-show="open" 
                            @click.away="open = false"
                            x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95"
                            class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-lg border border-gray-200 py-2"
                            style="display: none;"
                        >
                            <!-- User Info -->
                            <div class="px-4 py-3 border-b border-gray-200">
                                <p class="text-sm font-semibold text-plyform-dark">{{ auth()->user()->name ?? 'User' }}</p>
                                <p class="text-xs text-gray-600 mt-1">{{ auth()->user()->email ?? 'user@example.com' }}</p>
                            </div>
                            
                            <!-- Menu Items -->
                            <a href="{{ route('user.profile.overview') }}" class="flex items-center gap-2 px-4 py-2 text-gray-700 hover:bg-plyform-mint/20 hover:text-plyform-dark transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                My Profile
                            </a>
                            <a href="{{ route('user.support.index') }}" class="flex items-center gap-2 px-4 py-2 text-gray-700 hover:bg-plyform-mint/20 hover:text-plyform-dark transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Help & Support
                            </a>
                            
                            <hr class="my-2">
                            
                            <!-- Logout -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full flex items-center gap-2 px-4 py-2 text-plyform-orange hover:bg-plyform-orange/10 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                    </svg>
                                    Log out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        
        <!-- Main Content Area -->
        <main class="flex-1">
            @yield('content')
        </main>
        
        <!-- Footer -->
        <footer class="bg-white border-t border-gray-200 py-6 mt-auto">
            <div class="px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                    <div class="text-sm text-gray-600">
                        © {{ date('Y') }} <span class="font-semibold text-plyform-dark">plyform</span>. All rights reserved.
                    </div>
                    <div class="flex items-center gap-4 text-sm">
                        <a href="#" class="text-gray-600 hover:text-plyform-purple transition-colors">Privacy Policy</a>
                        <span class="text-gray-300">•</span>
                        <a href="#" class="text-gray-600 hover:text-plyform-purple transition-colors">Terms of Service</a>
                        <span class="text-gray-300">•</span>
                        <a href="#" class="text-gray-600 hover:text-plyform-purple transition-colors">Contact Support</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    
    <!-- Alpine.js for dropdowns -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Mobile Menu Toggle Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('mobile-menu-overlay');
            
            if (mobileMenuButton) {
                mobileMenuButton.addEventListener('click', function() {
                    sidebar.classList.toggle('-translate-x-full');
                    overlay.classList.toggle('hidden');
                });
                
                overlay.addEventListener('click', function() {
                    sidebar.classList.add('-translate-x-full');
                    overlay.classList.add('hidden');
                });
            }
        });
    </script>
    
    @include('user.profile.shared-assets-scripts')
    @stack('scripts')
</body>
</html>