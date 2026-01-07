@extends('layouts.user')

@section('title', 'Notification')

@section('content')
<div class="py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('user.notifications.index') }}" 
               class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-900 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Back to Notifications
            </a>
        </div>

        <!-- Notification Card -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-teal-500 to-teal-600 px-6 py-8 text-white">
                <div class="flex items-start justify-between gap-4 mb-4">
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-3">
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-white/20 backdrop-blur">
                                {{ ucfirst($notification->category) }}
                            </span>
                            <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $notification->priority === 'high' ? 'bg-red-500' : ($notification->priority === 'medium' ? 'bg-yellow-500' : 'bg-green-500') }}">
                                {{ ucfirst($notification->priority) }} Priority
                            </span>
                            @if($notification->type === 'broadcast')
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-purple-500">
                                    Broadcast
                                </span>
                            @endif
                        </div>
                        <h1 class="text-3xl font-bold mb-2">{{ $notification->title }}</h1>
                        <div class="flex items-center gap-4 text-sm opacity-90">
                            <span class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                {{ $notification->created_at->format('F d, Y \a\t g:i A') }}
                            </span>
                            <span>•</span>
                            <span>{{ $notification->created_at->diffForHumans() }}</span>
                        </div>
                    </div>

                    <!-- Icon -->
                    <div class="w-16 h-16 bg-white/20 backdrop-blur rounded-full flex items-center justify-center flex-shrink-0">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $notification->category_icon }}"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="p-6">
                <div class="prose max-w-none">
                    <p class="text-lg text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $notification->message }}</p>
                </div>

                <!-- Action Button (if action_url exists) -->
                @if($notification->action_url)
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <a href="{{ $notification->action_url }}" 
                           target="_blank"
                           class="inline-flex items-center gap-2 px-6 py-3 bg-teal-600 text-white font-semibold rounded-lg hover:bg-teal-700 transition shadow-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                            </svg>
                            {{ $notification->action_text ?? 'Take Action' }}
                        </a>
                    </div>
                @endif

                <!-- Metadata -->
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-3">Notification Details</h3>
                            <dl class="space-y-2">
                                <div class="flex justify-between">
                                    <dt class="text-sm text-gray-600">Received:</dt>
                                    <dd class="text-sm font-medium text-gray-900">{{ $notification->created_at->format('M d, Y g:i A') }}</dd>
                                </div>
                                @if($notification->sent_at)
                                <div class="flex justify-between">
                                    <dt class="text-sm text-gray-600">Sent:</dt>
                                    <dd class="text-sm font-medium text-gray-900">{{ $notification->sent_at->format('M d, Y g:i A') }}</dd>
                                </div>
                                @endif
                                @if($notification->read_at)
                                <div class="flex justify-between">
                                    <dt class="text-sm text-gray-600">Read:</dt>
                                    <dd class="text-sm font-medium text-gray-900">{{ $notification->read_at->format('M d, Y g:i A') }}</dd>
                                </div>
                                @endif
                                <div class="flex justify-between">
                                    <dt class="text-sm text-gray-600">Type:</dt>
                                    <dd class="text-sm font-medium text-gray-900">{{ ucfirst($notification->type) }}</dd>
                                </div>
                            </dl>
                        </div>

                        <div>
                            <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-3">Status</h3>
                            <div class="space-y-3">
                                <div class="flex items-center gap-2">
                                    @if($notification->isRead())
                                        <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                        <span class="text-sm font-medium text-green-600">Read</span>
                                    @else
                                        <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM7 9a1 1 0 000 2h6a1 1 0 100-2H7z" clip-rule="evenodd"/>
                                        </svg>
                                        <span class="text-sm font-medium text-gray-600">Unread</span>
                                    @endif
                                </div>

                                <div class="flex items-center gap-2">
                                    <div class="w-5 h-5 rounded-full {{ $notification->priority === 'high' ? 'bg-red-500' : ($notification->priority === 'medium' ? 'bg-yellow-500' : 'bg-green-500') }}"></div>
                                    <span class="text-sm font-medium text-gray-900">{{ ucfirst($notification->priority) }} Priority</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                <div class="flex items-center justify-between">
                    @if($previous)
                        <a href="{{ route('user.notifications.show', $previous) }}" 
                           class="inline-flex items-center gap-2 px-4 py-2 text-gray-700 hover:text-gray-900 hover:bg-white rounded-lg transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                            <span class="hidden sm:inline">Previous</span>
                        </a>
                    @else
                        <div></div>
                    @endif

                    <a href="{{ route('user.notifications.index') }}" 
                       class="px-4 py-2 text-gray-700 hover:text-gray-900 hover:bg-white rounded-lg transition font-medium">
                        All Notifications
                    </a>

                    @if($next)
                        <a href="{{ route('user.notifications.show', $next) }}" 
                           class="inline-flex items-center gap-2 px-4 py-2 text-gray-700 hover:text-gray-900 hover:bg-white rounded-lg transition">
                            <span class="hidden sm:inline">Next</span>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    @else
                        <div></div>
                    @endif
                </div>
            </div>
        </div>

    </div>
</div>
@endsection