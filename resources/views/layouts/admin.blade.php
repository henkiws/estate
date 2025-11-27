<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - Sorted Services</title>

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
    @else
        @include('layouts.partials.sidebar-admin')
    @endif

    {{-- Mobile Overlay --}}
    <div id="sidebarOverlay" class="fixed inset-0 bg-gray-900/50 z-30 lg:hidden hidden"></div>

    {{-- Main Wrapper --}}
    <div class="lg:ml-64">

        {{-- Top Navigation --}}
        @include('layouts.partials.topbar')

        {{-- Main Content --}}
        <main class="p-4 sm:p-6 lg:p-8">
            {{-- Success/Error Messages --}}
            @if(session('success'))
                <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg">
                    <div class="flex">
                        <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <p class="text-green-700 font-medium">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg">
                    <div class="flex">
                        <svg class="w-5 h-5 text-red-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        <p class="text-red-700 font-medium">{{ session('error') }}</p>
                    </div>
                </div>
            @endif

            @if(session('warning'))
                <div class="mb-6 bg-yellow-50 border-l-4 border-yellow-500 p-4 rounded-lg">
                    <div class="flex">
                        <svg class="w-5 h-5 text-yellow-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        <p class="text-yellow-700 font-medium">{{ session('warning') }}</p>
                    </div>
                </div>
            @endif

            @if(session('info'))
                <div class="mb-6 bg-blue-50 border-l-4 border-blue-500 p-4 rounded-lg">
                    <div class="flex">
                        <svg class="w-5 h-5 text-blue-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                        <p class="text-blue-700 font-medium">{{ session('info') }}</p>
                    </div>
                </div>
            @endif

            @yield('content')
        </main>
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
        
        // Handle window resize
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 1024) {
                sidebar.classList.remove('-translate-x-full');
                sidebarOverlay.classList.add('hidden');
            }
        });
        
        // Notifications Dropdown
        const notificationsBtn = document.getElementById('notificationsBtn');
        const notificationsDropdown = document.getElementById('notificationsDropdown');
        
        notificationsBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            notificationsDropdown.classList.toggle('hidden');
            userDropdown.classList.add('hidden'); // Close user dropdown
            mobileSearchBar.classList.add('hidden'); // Close mobile search
        });
        
        // User Profile Dropdown
        const userMenuBtn = document.getElementById('userMenuBtn');
        const userDropdown = document.getElementById('userDropdown');
        
        userMenuBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            userDropdown.classList.toggle('hidden');
            notificationsDropdown.classList.add('hidden'); // Close notifications dropdown
            mobileSearchBar.classList.add('hidden'); // Close mobile search
        });
        
        // Mobile Search Toggle
        const mobileSearchToggle = document.getElementById('mobileSearchToggle');
        const mobileSearchBar = document.getElementById('mobileSearchBar');
        
        mobileSearchToggle.addEventListener('click', (e) => {
            e.stopPropagation();
            mobileSearchBar.classList.toggle('hidden');
            notificationsDropdown.classList.add('hidden'); // Close notifications
            userDropdown.classList.add('hidden'); // Close user dropdown
        });
        
        // Close dropdowns when clicking outside
        document.addEventListener('click', (e) => {
            if (!notificationsBtn.contains(e.target) && !notificationsDropdown.contains(e.target)) {
                notificationsDropdown.classList.add('hidden');
            }
            if (!userMenuBtn.contains(e.target) && !userDropdown.contains(e.target)) {
                userDropdown.classList.add('hidden');
            }
        });
        
        // Close dropdowns on Escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                notificationsDropdown.classList.add('hidden');
                userDropdown.classList.add('hidden');
                mobileSearchBar.classList.add('hidden');
            }
        });
        
        // Mark notification as read (example)
        const notificationItems = document.querySelectorAll('#notificationsDropdown > div:nth-child(2) > div');
        notificationItems.forEach(item => {
            item.addEventListener('click', function() {
                const badge = this.querySelector('.w-2.h-2.bg-primary');
                if (badge) {
                    badge.remove();
                }
            });
        });
    </script>

</body>
</html>