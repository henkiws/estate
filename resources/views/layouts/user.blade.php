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
                    <div class="relative hidden">
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
                    <div class="relative">
                        <button id="notificationsBtn" class="relative p-2 rounded-lg text-gray-600 hover:bg-plyform-mint/30 hover:text-plyform-dark transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                            </svg>
                            <!-- Notification Badges -->
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
                                <a href="{{ route('user.notifications.index') }}" class="block w-full py-2 text-sm font-semibold text-plyform-purple hover:bg-plyform-purple/10 rounded-lg transition-colors text-center">
                                    View All Notifications
                                </a>
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

    <!-- Notification System Script -->
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
            if (notificationsBtn) {
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
            }
            
            // Close dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (isDropdownOpen && !notificationsDropdown.contains(e.target)) {
                    notificationsDropdown.classList.add('hidden');
                    isDropdownOpen = false;
                }
            });
            
            // Prevent dropdown from closing when clicking inside
            if (notificationsDropdown) {
                notificationsDropdown.addEventListener('click', function(e) {
                    e.stopPropagation();
                });
            }
            
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
                    
                    const priorityColors = {
                        high: 'bg-red-100 text-red-800',
                        medium: 'bg-yellow-100 text-yellow-800',
                        low: 'bg-green-100 text-green-800'
                    };
                    
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
                            onclick="handleNotificationClick(${notif.id})">
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
                                                ${notif.priority.toUpperCase()}
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
            
            // Handle notification click - Navigate to detail page
            window.handleNotificationClick = function(notificationId) {
                window.location.href = `/user/notifications/${notificationId}`;
            };
            
            // Mark all as read
            if (markAllReadBtn) {
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
                            // Reload to update the badge
                            window.location.reload();
                        }
                    })
                    .catch(error => {
                        console.error('Error marking all as read:', error);
                    });
                });
            }
            
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
            
            // Load notifications on page load (only if elements exist)
            if (notificationsBtn) {
                loadNotifications();
                
                // Refresh notifications every 60 seconds
                setInterval(function() {
                    if (!isDropdownOpen) {
                        loadNotifications();
                    }
                }, 60000);
            }
        });
    </script>

    @include('user.profile.shared-assets-scripts')
    <!-- intl-tel-input JS -->
    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@19.5.6/build/js/intlTelInput.min.js"></script>

    @stack('scripts')
</body>
</html>