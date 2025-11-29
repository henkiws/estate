@extends('layouts.admin')

@section('title', 'Account Settings')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-8 flex items-center gap-4">
        <a href="{{ route('admin.profile.show') }}" class="text-gray-600 hover:text-gray-900">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
        </a>
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Account Settings</h1>
            <p class="text-gray-600">Manage your preferences and notification settings</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- General Preferences -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-6">General Preferences</h2>
                
                <form method="POST" action="{{ route('admin.profile.settings.update') }}">
                    @csrf
                    @method('PUT')

                    <div class="space-y-6">
                        <!-- Timezone -->
                        <div>
                            <label for="timezone" class="block text-sm font-medium text-gray-700 mb-2">Timezone</label>
                            <select name="timezone" id="timezone" 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="Australia/Sydney" {{ (old('timezone', $user->settings['timezone'] ?? '') == 'Australia/Sydney') ? 'selected' : '' }}>Australia/Sydney (AEDT)</option>
                                <option value="Australia/Melbourne" {{ (old('timezone', $user->settings['timezone'] ?? '') == 'Australia/Melbourne') ? 'selected' : '' }}>Australia/Melbourne (AEDT)</option>
                                <option value="Australia/Brisbane" {{ (old('timezone', $user->settings['timezone'] ?? '') == 'Australia/Brisbane') ? 'selected' : '' }}>Australia/Brisbane (AEST)</option>
                                <option value="Australia/Adelaide" {{ (old('timezone', $user->settings['timezone'] ?? '') == 'Australia/Adelaide') ? 'selected' : '' }}>Australia/Adelaide (ACDT)</option>
                                <option value="Australia/Perth" {{ (old('timezone', $user->settings['timezone'] ?? '') == 'Australia/Perth') ? 'selected' : '' }}>Australia/Perth (AWST)</option>
                                <option value="Pacific/Auckland" {{ (old('timezone', $user->settings['timezone'] ?? '') == 'Pacific/Auckland') ? 'selected' : '' }}>New Zealand (NZDT)</option>
                                <option value="UTC" {{ (old('timezone', $user->settings['timezone'] ?? '') == 'UTC') ? 'selected' : '' }}>UTC (Universal Time)</option>
                            </select>
                            <p class="mt-1 text-sm text-gray-500">Used for displaying dates and times</p>
                        </div>

                        <!-- Language -->
                        <div>
                            <label for="language" class="block text-sm font-medium text-gray-700 mb-2">Language</label>
                            <select name="language" id="language" 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="en" {{ (old('language', $user->settings['language'] ?? 'en') == 'en') ? 'selected' : '' }}>English</option>
                                <option value="es" {{ (old('language', $user->settings['language'] ?? '') == 'es') ? 'selected' : '' }}>Spanish</option>
                                <option value="fr" {{ (old('language', $user->settings['language'] ?? '') == 'fr') ? 'selected' : '' }}>French</option>
                                <option value="de" {{ (old('language', $user->settings['language'] ?? '') == 'de') ? 'selected' : '' }}>German</option>
                            </select>
                            <p class="mt-1 text-sm text-gray-500">Interface language preference</p>
                        </div>

                        <!-- Date Format -->
                        <div>
                            <label for="date_format" class="block text-sm font-medium text-gray-700 mb-2">Date Format</label>
                            <select name="date_format" id="date_format" 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="d/m/Y" {{ (old('date_format', $user->settings['date_format'] ?? 'd/m/Y') == 'd/m/Y') ? 'selected' : '' }}>DD/MM/YYYY ({{ now()->format('d/m/Y') }})</option>
                                <option value="m/d/Y" {{ (old('date_format', $user->settings['date_format'] ?? '') == 'm/d/Y') ? 'selected' : '' }}>MM/DD/YYYY ({{ now()->format('m/d/Y') }})</option>
                                <option value="Y-m-d" {{ (old('date_format', $user->settings['date_format'] ?? '') == 'Y-m-d') ? 'selected' : '' }}>YYYY-MM-DD ({{ now()->format('Y-m-d') }})</option>
                                <option value="F j, Y" {{ (old('date_format', $user->settings['date_format'] ?? '') == 'F j, Y') ? 'selected' : '' }}>Month DD, YYYY ({{ now()->format('F j, Y') }})</option>
                            </select>
                        </div>

                        <!-- Time Format -->
                        <div>
                            <label for="time_format" class="block text-sm font-medium text-gray-700 mb-2">Time Format</label>
                            <select name="time_format" id="time_format" 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="H:i" {{ (old('time_format', $user->settings['time_format'] ?? 'H:i') == 'H:i') ? 'selected' : '' }}>24-hour ({{ now()->format('H:i') }})</option>
                                <option value="h:i A" {{ (old('time_format', $user->settings['time_format'] ?? '') == 'h:i A') ? 'selected' : '' }}>12-hour ({{ now()->format('h:i A') }})</option>
                            </select>
                        </div>
                    </div>

                    <div class="mt-6 flex items-center gap-3">
                        <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium">
                            Save Preferences
                        </button>
                        <a href="{{ route('admin.profile.show') }}" class="px-6 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition font-medium">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>

            <!-- Notification Settings -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-6">Notification Preferences</h2>
                
                <form method="POST" action="{{ route('admin.profile.settings.update') }}">
                    @csrf
                    @method('PUT')

                    <div class="space-y-6">
                        <!-- Email Notifications -->
                        <div class="flex items-start gap-4">
                            <div class="flex items-center h-5 mt-1">
                                <input type="checkbox" name="notifications_email" id="notifications_email" value="1"
                                       {{ old('notifications_email', $user->settings['notifications_email'] ?? true) ? 'checked' : '' }}
                                       class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div class="flex-1">
                                <label for="notifications_email" class="block font-medium text-gray-900 cursor-pointer">
                                    Email Notifications
                                </label>
                                <p class="text-sm text-gray-600 mt-1">
                                    Receive email notifications for important updates, new agencies, payment alerts, and system notifications.
                                </p>
                            </div>
                        </div>

                        <!-- Browser Notifications -->
                        <div class="flex items-start gap-4">
                            <div class="flex items-center h-5 mt-1">
                                <input type="checkbox" name="notifications_browser" id="notifications_browser" value="1"
                                       {{ old('notifications_browser', $user->settings['notifications_browser'] ?? false) ? 'checked' : '' }}
                                       class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div class="flex-1">
                                <label for="notifications_browser" class="block font-medium text-gray-900 cursor-pointer">
                                    Browser Notifications
                                </label>
                                <p class="text-sm text-gray-600 mt-1">
                                    Get instant browser notifications for real-time updates while you're online.
                                </p>
                            </div>
                        </div>

                        <!-- Desktop Notifications -->
                        <div class="flex items-start gap-4">
                            <div class="flex items-center h-5 mt-1">
                                <input type="checkbox" name="notifications_desktop" id="notifications_desktop" value="1"
                                       {{ old('notifications_desktop', $user->settings['notifications_desktop'] ?? false) ? 'checked' : '' }}
                                       class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div class="flex-1">
                                <label for="notifications_desktop" class="block font-medium text-gray-900 cursor-pointer">
                                    Desktop Notifications
                                </label>
                                <p class="text-sm text-gray-600 mt-1">
                                    Allow desktop notifications even when the browser is not active.
                                </p>
                            </div>
                        </div>

                        <div class="border-t border-gray-200 pt-6">
                            <h3 class="font-semibold text-gray-900 mb-4">Notification Types</h3>
                            <div class="space-y-3">
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="notify_agency_pending" id="notify_agency_pending" value="1"
                                           {{ old('notify_agency_pending', $user->settings['notify_agency_pending'] ?? true) ? 'checked' : '' }}
                                           class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-2 focus:ring-blue-500">
                                    <label for="notify_agency_pending" class="text-sm text-gray-700 cursor-pointer">
                                        New agency registrations pending approval
                                    </label>
                                </div>

                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="notify_payment_failed" id="notify_payment_failed" value="1"
                                           {{ old('notify_payment_failed', $user->settings['notify_payment_failed'] ?? true) ? 'checked' : '' }}
                                           class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-2 focus:ring-blue-500">
                                    <label for="notify_payment_failed" class="text-sm text-gray-700 cursor-pointer">
                                        Failed payment transactions
                                    </label>
                                </div>

                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="notify_new_subscription" id="notify_new_subscription" value="1"
                                           {{ old('notify_new_subscription', $user->settings['notify_new_subscription'] ?? true) ? 'checked' : '' }}
                                           class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-2 focus:ring-blue-500">
                                    <label for="notify_new_subscription" class="text-sm text-gray-700 cursor-pointer">
                                        New subscription activations
                                    </label>
                                </div>

                                <div class="flex items-center gap-3">
                                    <input type="checkbox" name="notify_system_updates" id="notify_system_updates" value="1"
                                           {{ old('notify_system_updates', $user->settings['notify_system_updates'] ?? false) ? 'checked' : '' }}
                                           class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-2 focus:ring-blue-500">
                                    <label for="notify_system_updates" class="text-sm text-gray-700 cursor-pointer">
                                        System updates and maintenance notices
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6">
                        <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium">
                            Save Notification Settings
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Current Settings Summary -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Current Settings</h3>
                <div class="space-y-3 text-sm">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-gray-600">Timezone:</span>
                        <span class="font-semibold text-gray-900">{{ $user->settings['timezone'] ?? 'Australia/Sydney' }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"></path>
                        </svg>
                        <span class="text-gray-600">Language:</span>
                        <span class="font-semibold text-gray-900">{{ strtoupper($user->settings['language'] ?? 'EN') }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span class="text-gray-600">Date:</span>
                        <span class="font-semibold text-gray-900">{{ now()->format($user->settings['date_format'] ?? 'd/m/Y') }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-gray-600">Time:</span>
                        <span class="font-semibold text-gray-900">{{ now()->format($user->settings['time_format'] ?? 'H:i') }}</span>
                    </div>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Quick Links</h3>
                <div class="space-y-2">
                    <a href="{{ route('admin.profile.show') }}" 
                       class="flex items-center gap-3 p-3 text-gray-700 hover:bg-gray-50 rounded-lg transition">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <span class="font-medium">View Profile</span>
                    </a>

                    <a href="{{ route('admin.profile.edit') }}" 
                       class="flex items-center gap-3 p-3 text-gray-700 hover:bg-gray-50 rounded-lg transition">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        <span class="font-medium">Edit Profile</span>
                    </a>

                    <a href="{{ route('admin.profile.security') }}" 
                       class="flex items-center gap-3 p-3 text-gray-700 hover:bg-gray-50 rounded-lg transition">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                        <span class="font-medium">Security</span>
                    </a>

                    <a href="{{ route('admin.profile.activity') }}" 
                       class="flex items-center gap-3 p-3 text-gray-700 hover:bg-gray-50 rounded-lg transition">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        <span class="font-medium">Activity Log</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection