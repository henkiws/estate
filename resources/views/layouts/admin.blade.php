<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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

    <script>
        // Notification System
        document.addEventListener('DOMContentLoaded', function() {
            const notificationsBtn = document.getElementById('notificationsBtn');
            const notificationsDropdown = document.getElementById('notificationsDropdown');
            const notificationsList = document.getElementById('notificationsList');
            const unreadBadge = document.getElementById('unreadBadge');
            const unreadCount = document.getElementById('unreadCount');
            const newNotifBadge = document.getElementById('newNotifBadge');
            const markAllReadBtn = document.getElementById('markAllReadBtn');
            const loadingNotifications = document.getElementById('loadingNotifications');
            const emptyNotifications = document.getElementById('emptyNotifications');
            
            let isDropdownOpen = false;
            let notifications = [];
            let unreadCountValue = 0;
            
            // Toggle dropdown
            notificationsBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                isDropdownOpen = !isDropdownOpen;
                
                if (isDropdownOpen) {
                    notificationsDropdown.classList.remove('hidden');
                    loadNotifications();
                } else {
                    notificationsDropdown.classList.add('hidden');
                }
            });
            
            // Close dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (isDropdownOpen && !notificationsDropdown.contains(e.target)) {
                    notificationsDropdown.classList.add('hidden');
                    isDropdownOpen = false;
                }
            });
            
            // Prevent dropdown from closing when clicking inside
            notificationsDropdown.addEventListener('click', function(e) {
                e.stopPropagation();
            });
            
            // Load notifications from API
            function loadNotifications() {
                fetch('{{ route("api.notifications.get") }}')
                    .then(response => response.json())
                    .then(data => {
                        notifications = data.notifications;
                        unreadCountValue = data.unread_count;
                        
                        updateBadges();
                        renderNotifications();
                    })
                    .catch(error => {
                        console.error('Error loading notifications:', error);
                        showError();
                    });
            }
            
            // Update badge indicators
            function updateBadges() {
                if (unreadCountValue > 0) {
                    unreadBadge.classList.remove('hidden');
                    unreadCount.classList.remove('hidden');
                    unreadCount.textContent = unreadCountValue > 9 ? '9+' : unreadCountValue;
                    newNotifBadge.classList.remove('hidden');
                    newNotifBadge.textContent = `${unreadCountValue} New`;
                    markAllReadBtn.classList.remove('hidden');
                } else {
                    unreadBadge.classList.add('hidden');
                    unreadCount.classList.add('hidden');
                    newNotifBadge.classList.add('hidden');
                    markAllReadBtn.classList.add('hidden');
                }
            }
            
            // Render notifications
            function renderNotifications() {
                loadingNotifications.classList.add('hidden');
                
                if (notifications.length === 0) {
                    emptyNotifications.classList.remove('hidden');
                    notificationsList.innerHTML = '';
                    return;
                }
                
                emptyNotifications.classList.add('hidden');
                
                notificationsList.innerHTML = notifications.map(notif => {
                    const isUnread = !notif.read_at;
                    
                    // Priority colors for badges
                    const priorityColors = {
                        high: 'bg-red-100 text-red-800',
                        medium: 'bg-yellow-100 text-yellow-800',
                        low: 'bg-green-100 text-green-800'
                    };
                    
                    // Priority dot colors (for unread indicator)
                    const priorityDotColors = {
                        high: 'bg-red-500',
                        medium: 'bg-yellow-500',
                        low: 'bg-green-500'
                    };
                    
                    const categoryIcons = {
                        payment: 'M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z',
                        approval: 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
                        document: 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z',
                        support: 'M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
                        subscription: 'M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z',
                        maintenance: 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z',
                        general: 'M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9'
                    };
                    
                    const categoryBgColors = {
                        payment: 'bg-plyform-mint/30',
                        approval: 'bg-green-100',
                        document: 'bg-blue-100',
                        support: 'bg-purple-100',
                        subscription: 'bg-yellow-100',
                        maintenance: 'bg-plyform-orange/20',
                        general: 'bg-gray-100'
                    };
                    
                    return `
                        <div class="notification-item p-4 hover:bg-plyform-mint/10 transition-colors cursor-pointer border-b border-gray-50 ${isUnread ? 'bg-blue-50/30' : ''}" 
                            data-notification-id="${notif.id}"
                            onclick="handleNotificationClick(${notif.id}, ${notif.action_url ? `'${notif.action_url}'` : 'null'})">
                            <div class="flex gap-3">
                                <div class="w-10 h-10 ${categoryBgColors[notif.category] || 'bg-gray-100'} rounded-full flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-plyform-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="${categoryIcons[notif.category] || categoryIcons.general}"></path>
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-start justify-between gap-2 mb-1">
                                        <p class="text-sm font-semibold text-plyform-dark">${notif.title}</p>
                                        ${notif.priority !== 'medium' ? `
                                            <span class="text-xs px-2 py-0.5 ${priorityColors[notif.priority]} rounded-full font-semibold whitespace-nowrap">
                                                ${notif.priority}
                                            </span>
                                        ` : ''}
                                    </div>
                                    <p class="text-xs text-gray-600 line-clamp-2">${notif.message}</p>
                                    <p class="text-xs text-gray-400 mt-2">${notif.time_ago || 'Just now'}</p>
                                </div>
                                ${isUnread ? `
                                    <div class="w-2 h-2 ${priorityDotColors[notif.priority] || 'bg-plyform-orange'} rounded-full flex-shrink-0 mt-2"></div>
                                ` : ''}
                            </div>
                        </div>
                    `;
                }).join('');
            }
            
            // Handle notification click
            window.handleNotificationClick = function(notificationId, actionUrl) {
                // Mark as read
                fetch(`/api/notifications/${notificationId}/read`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update UI
                        const notifElement = document.querySelector(`[data-notification-id="${notificationId}"]`);
                        if (notifElement) {
                            notifElement.classList.remove('bg-blue-50/30');
                            const dot = notifElement.querySelector('.bg-plyform-orange.rounded-full');
                            if (dot) dot.remove();
                        }
                        
                        // Update counts
                        unreadCountValue = Math.max(0, unreadCountValue - 1);
                        updateBadges();
                        
                        // Navigate to action URL if provided
                        if (actionUrl) {
                            window.location.href = actionUrl;
                        }
                    }
                })
                .catch(error => {
                    console.error('Error marking notification as read:', error);
                });
            };
            
            // Mark all as read
            markAllReadBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                
                if (!confirm('Mark all notifications as read?')) {
                    return;
                }
                
                fetch('{{ route("api.notifications.read-all") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update UI
                        document.querySelectorAll('.notification-item').forEach(item => {
                            item.classList.remove('bg-blue-50/30');
                            const dot = item.querySelector('.bg-plyform-orange.rounded-full');
                            if (dot) dot.remove();
                        });
                        
                        unreadCountValue = 0;
                        updateBadges();
                    }
                })
                .catch(error => {
                    console.error('Error marking all as read:', error);
                });
            });
            
            // Show error state
            function showError() {
                loadingNotifications.classList.add('hidden');
                notificationsList.innerHTML = `
                    <div class="p-8 text-center">
                        <svg class="w-16 h-16 text-red-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <h3 class="text-sm font-medium text-gray-900 mb-1">Failed to load</h3>
                        <p class="text-xs text-gray-600">Please try again later</p>
                    </div>
                `;
            }
            
            // Load notifications on page load
            loadNotifications();
            
            // Refresh notifications every 60 seconds
            setInterval(function() {
                if (!isDropdownOpen) {
                    loadNotifications();
                }
            }, 60000);
        });
        </script>

    @stack('scripts')

</body>
</html>