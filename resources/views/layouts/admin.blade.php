<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - Sorted Services</title>

    {{-- Tailwind --}}
    @vite(['resources/css/app.css','resources/js/app.js'])

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            DEFAULT: '#0066FF',
                            dark: '#0052CC',
                            light: '#E8F5FF',
                        },
                        secondary: '#FF9500',
                        success: '#00CC66',
                        danger: '#FF3366',
                    },
                }
            }
        }
    </script>

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

    {{-- Sidebar --}}
    @include('layouts.partials.sidebar')

    {{-- Mobile Overlay --}}
    <div id="sidebarOverlay" class="fixed inset-0 bg-gray-900/50 z-30 lg:hidden hidden"></div>

    {{-- Main Wrapper --}}
    <div class="lg:ml-64">

        {{-- Top Navigation --}}
        @include('layouts.partials.topbar')

        {{-- Main Content --}}
        <main class="p-4 sm:p-6 lg:p-8">
            @yield('content')
        </main>
    </div>

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
        
        // Logout Function
        function handleLogout() {
            if (confirm('Are you sure you want to log out?')) {
                // Here you would typically make an API call to logout
                console.log('Logging out...');
                
                // Redirect to login page
                window.location.href = 'login.html';
            }
        }
        
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
