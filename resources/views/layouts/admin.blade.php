<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/images/ico-yellow.png') }}">
    <title>@yield('title', 'Dashboard') - Plyform</title>

    {{-- Tailwind --}}
    @vite(['resources/css/app.css','resources/js/app.js'])

    <style>
        @keyframes slideIn {
            from { transform: translateX(-100%); }
            to { transform: translateX(0); }
        }

        .animate-slideIn {
            animation: slideIn 0.3s ease-out;
        }

        /* Custom Scrollbar - Plyform Yellow */
        ::-webkit-scrollbar {
            width: 10px;
            height: 10px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 5px;
        }

        ::-webkit-scrollbar-thumb {
            background: #E6FF4B;
            border-radius: 5px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #d4ed39;
        }
    </style>
</head>
<body class="bg-gray-50">

    {{-- Dynamic Sidebar Based on Role --}}
    @if(auth()->user()->hasRole('admin'))
        @include('layouts.partials.sidebar-admin')
    @elseif(auth()->user()->hasRole('agency'))
        @include('layouts.partials.sidebar-agency')
    @elseif(auth()->user()->hasRole('agent'))
        @include('layouts.partials.sidebar-agent')
    @endif

    {{-- Mobile Overlay --}}
    <div id="sidebarOverlay" class="fixed inset-0 bg-plyform-dark/70 z-30 lg:hidden hidden transition-opacity duration-300"></div>

    {{-- Main Wrapper --}}
    <div class="lg:ml-64">

        {{-- Top Navigation --}}
        @include('layouts.partials.topbar')

        {{-- Main Content --}}
        <main class="p-4 sm:p-6 lg:p-8">
            {{-- Success/Error Messages --}}
            @if(session('success'))
                <div class="mb-6 bg-plyform-mint/20 border-l-4 border-plyform-mint p-4 rounded-lg animate-slideIn">
                    <div class="flex">
                        <svg class="w-5 h-5 text-plyform-dark mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <p class="text-plyform-dark font-semibold">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 bg-plyform-orange/10 border-l-4 border-plyform-orange p-4 rounded-lg animate-slideIn">
                    <div class="flex">
                        <svg class="w-5 h-5 text-plyform-orange mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        <p class="text-plyform-orange font-semibold">{{ session('error') }}</p>
                    </div>
                </div>
            @endif

            @if(session('warning'))
                <div class="mb-6 bg-plyform-yellow/20 border-l-4 border-plyform-yellow p-4 rounded-lg animate-slideIn">
                    <div class="flex">
                        <svg class="w-5 h-5 text-plyform-dark mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        <p class="text-plyform-dark font-semibold">{{ session('warning') }}</p>
                    </div>
                </div>
            @endif

            @if(session('info'))
                <div class="mb-6 bg-plyform-purple/10 border-l-4 border-plyform-purple p-4 rounded-lg animate-slideIn">
                    <div class="flex">
                        <svg class="w-5 h-5 text-plyform-purple mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                        <p class="text-plyform-purple font-semibold">{{ session('info') }}</p>
                    </div>
                </div>
            @endif

            @yield('content')
        </main>

        {{-- Footer --}}
        <footer class="bg-white border-t border-gray-200 py-6 px-4 sm:px-6 lg:px-8 mt-8">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <div class="text-sm text-gray-600">
                    © {{ date('Y') }} <span class="font-semibold text-plyform-dark">Plyform</span>. All rights reserved.
                </div>
                <div class="flex gap-6 text-sm">
                    <a href="#" class="text-plyform-purple hover:text-plyform-dark transition-colors">Privacy Policy</a>
                    <a href="#" class="text-plyform-purple hover:text-plyform-dark transition-colors">Terms of Service</a>
                    <a href="#" class="text-plyform-purple hover:text-plyform-dark transition-colors">Support</a>
                </div>
            </div>
        </footer>
    </div>

    <script src="//unpkg.com/alpinejs" defer></script>
    
    <script>
        // Sidebar Toggle for Mobile
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        
        function toggleSidebar() {
            sidebar.classList.toggle('-translate-x-full');
            sidebarOverlay.classList.toggle('hidden');
        }
        
        if (sidebarToggle && sidebar && sidebarOverlay) {
            sidebarToggle.addEventListener('click', toggleSidebar);
            sidebarOverlay.addEventListener('click', toggleSidebar);
            
            // Close sidebar when clicking a link on mobile
            const sidebarLinks = sidebar.querySelectorAll('a');
            sidebarLinks.forEach(link => {
                link.addEventListener('click', () => {
                    if (window.innerWidth < 1024) {
                        toggleSidebar();
                    }
                });
            });
        }
        
        // Handle window resize
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 1024 && sidebar) {
                sidebar.classList.remove('-translate-x-full');
                if (sidebarOverlay) {
                    sidebarOverlay.classList.add('hidden');
                }
            }
        });
        
        // Notifications Dropdown
        const notificationsBtn = document.getElementById('notificationsBtn');
        const notificationsDropdown = document.getElementById('notificationsDropdown');
        const userMenuBtn = document.getElementById('userMenuBtn');
        const userDropdown = document.getElementById('userDropdown');
        const mobileSearchToggle = document.getElementById('mobileSearchToggle');
        const mobileSearchBar = document.getElementById('mobileSearchBar');
        
        if (notificationsBtn && notificationsDropdown) {
            notificationsBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                notificationsDropdown.classList.toggle('hidden');
                if (userDropdown) userDropdown.classList.add('hidden');
                if (mobileSearchBar) mobileSearchBar.classList.add('hidden');
            });
        }
        
        // User Profile Dropdown
        if (userMenuBtn && userDropdown) {
            userMenuBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                userDropdown.classList.toggle('hidden');
                if (notificationsDropdown) notificationsDropdown.classList.add('hidden');
                if (mobileSearchBar) mobileSearchBar.classList.add('hidden');
            });
        }
        
        // Mobile Search Toggle
        if (mobileSearchToggle && mobileSearchBar) {
            mobileSearchToggle.addEventListener('click', (e) => {
                e.stopPropagation();
                mobileSearchBar.classList.toggle('hidden');
                if (notificationsDropdown) notificationsDropdown.classList.add('hidden');
                if (userDropdown) userDropdown.classList.add('hidden');
            });
        }
        
        // Close dropdowns when clicking outside
        document.addEventListener('click', (e) => {
            if (notificationsBtn && notificationsDropdown && 
                !notificationsBtn.contains(e.target) && !notificationsDropdown.contains(e.target)) {
                notificationsDropdown.classList.add('hidden');
            }
            if (userMenuBtn && userDropdown && 
                !userMenuBtn.contains(e.target) && !userDropdown.contains(e.target)) {
                userDropdown.classList.add('hidden');
            }
        });
        
        // Close dropdowns on Escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                if (notificationsDropdown) notificationsDropdown.classList.add('hidden');
                if (userDropdown) userDropdown.classList.add('hidden');
                if (mobileSearchBar) mobileSearchBar.classList.add('hidden');
            }
        });
        
        // Mark notification as read
        if (notificationsDropdown) {
            const notificationItems = notificationsDropdown.querySelectorAll('[data-notification]');
            notificationItems.forEach(item => {
                item.addEventListener('click', function() {
                    const badge = this.querySelector('.w-2.h-2.bg-plyform-orange, .w-2.h-2.bg-plyform-yellow');
                    if (badge) {
                        badge.classList.add('opacity-0');
                        setTimeout(() => badge.remove(), 300);
                    }
                });
            });
        }
        
        // Auto-hide flash messages after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const flashMessages = document.querySelectorAll('[class*="border-l-4"]');
            flashMessages.forEach(message => {
                setTimeout(() => {
                    message.style.opacity = '0';
                    message.style.transform = 'translateX(100%)';
                    message.style.transition = 'all 0.5s ease-out';
                    setTimeout(() => message.remove(), 500);
                }, 5000);
            });
        });
    </script>

    @stack('scripts')

</body>
</html>