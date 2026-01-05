@extends('layouts.admin')

@section('title', 'Notification Details')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="flex items-center gap-4 mb-8">
            <a href="{{ route('admin.notifications.index') }}" 
               class="p-2 hover:bg-[#DDEECD] rounded-lg transition-colors">
                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div class="flex-1">
                <h1 class="text-3xl font-bold text-gray-900">Notification Details</h1>
                <p class="mt-2 text-gray-600">View notification delivery status and statistics</p>
            </div>
            
            @if(!$notification->isSent() || $notification->isScheduled())
            <form action="{{ route('admin.notifications.destroy', $notification) }}" 
                  method="POST" 
                  onsubmit="return confirm('Are you sure you want to delete this notification and all its recipients?');">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        class="px-6 py-3 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    Delete Notification
                </button>
            </form>
            @endif
        </div>
        
        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-blue-100 rounded-lg">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                </div>
                <p class="text-sm text-gray-600 mb-1">Total Recipients</p>
                <p class="text-3xl font-bold text-gray-900">{{ number_format($stats['total_sent']) }}</p>
            </div>
            
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-green-100 rounded-lg">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <p class="text-sm text-gray-600 mb-1">Read</p>
                <p class="text-3xl font-bold text-gray-900">{{ number_format($stats['read_count']) }}</p>
            </div>
            
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-gray-100 rounded-lg">
                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                </div>
                <p class="text-sm text-gray-600 mb-1">Unread</p>
                <p class="text-3xl font-bold text-gray-900">{{ number_format($stats['unread_count']) }}</p>
            </div>
            
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-purple-100 rounded-lg">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                </div>
                <p class="text-sm text-gray-600 mb-1">Read Rate</p>
                <p class="text-3xl font-bold text-gray-900">{{ $stats['read_percentage'] }}%</p>
            </div>
        </div>
        
        <div class="grid lg:grid-cols-3 gap-6">
            <!-- Notification Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Main Content -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <div class="flex items-start justify-between mb-6">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900 mb-2">{{ $notification->title }}</h2>
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $notification->priority_color }}">
                                    {{ ucfirst($notification->priority) }} Priority
                                </span>
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-700">
                                    {{ ucfirst($notification->category) }}
                                </span>
                                @if($notification->isScheduled())
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        Scheduled
                                    </span>
                                @elseif($notification->isSent())
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                        Sent
                                    </span>
                                @else
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-700">
                                        Pending
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <div class="prose max-w-none">
                        <p class="text-gray-700 whitespace-pre-wrap">{{ $notification->message }}</p>
                    </div>
                    
                    @if($notification->action_url)
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <p class="text-sm font-semibold text-gray-700 mb-2">Action Link:</p>
                        <a href="{{ $notification->action_url }}" 
                           target="_blank"
                           class="inline-flex items-center gap-2 px-4 py-2 bg-[#5E17EB] text-white font-semibold rounded-lg hover:bg-[#4c12bc] transition">
                            {{ $notification->action_text ?? 'View Details' }}
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                            </svg>
                        </a>
                    </div>
                    @endif
                </div>
                
                <!-- Recipients List -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                        <h3 class="text-lg font-bold text-gray-900">Recipients ({{ $relatedNotifications->count() }})</h3>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Read At</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($relatedNotifications as $notif)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="text-sm font-medium text-gray-900">{{ $notif->recipient->name }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="text-sm text-gray-600">{{ $notif->recipient->email }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($notif->isRead())
                                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                    Read
                                                </span>
                                            @else
                                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-700">
                                                    Unread
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($notif->read_at)
                                                <div class="flex flex-col">
                                                    <span class="text-sm text-gray-900">{{ $notif->read_at->format('M d, Y') }}</span>
                                                    <span class="text-xs text-gray-500">{{ $notif->read_at->format('g:i A') }}</span>
                                                </div>
                                            @else
                                                <span class="text-sm text-gray-500">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Notification Info -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 pb-4 border-b border-gray-200">
                        Notification Info
                    </h3>
                    
                    <div class="space-y-4">
                        <div>
                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Sent By</p>
                            <p class="text-sm text-gray-900 font-medium">
                                {{ $notification->sender ? $notification->sender->name : 'System' }}
                            </p>
                        </div>
                        
                        <div>
                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Created</p>
                            <p class="text-sm text-gray-900 font-medium">{{ $notification->created_at->format('M d, Y g:i A') }}</p>
                            <p class="text-xs text-gray-500">{{ $notification->created_at->diffForHumans() }}</p>
                        </div>
                        
                        @if($notification->sent_at)
                        <div>
                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Sent</p>
                            <p class="text-sm text-gray-900 font-medium">{{ $notification->sent_at->format('M d, Y g:i A') }}</p>
                            <p class="text-xs text-gray-500">{{ $notification->sent_at->diffForHumans() }}</p>
                        </div>
                        @endif
                        
                        @if($notification->scheduled_for)
                        <div>
                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Scheduled For</p>
                            <p class="text-sm text-gray-900 font-medium">{{ $notification->scheduled_for->format('M d, Y g:i A') }}</p>
                            @if($notification->isScheduled())
                                <p class="text-xs text-yellow-600">Pending delivery</p>
                            @endif
                        </div>
                        @endif
                        
                        <div>
                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Type</p>
                            <p class="text-sm text-gray-900 font-medium">{{ ucfirst($notification->type) }}</p>
                        </div>
                    </div>
                </div>
                
                <!-- Performance -->
                <div class="bg-gradient-to-br from-[#5E17EB]/10 to-[#DDEECD]/20 rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">
                        Performance
                    </h3>
                    
                    <div class="space-y-4">
                        <!-- Read Rate Progress -->
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm font-semibold text-gray-700">Read Rate</span>
                                <span class="text-sm font-bold text-[#5E17EB]">{{ $stats['read_percentage'] }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-3 overflow-hidden">
                                <div class="bg-gradient-to-r from-[#5E17EB] to-[#DDEECD] h-3 rounded-full transition-all duration-500" 
                                     style="width: {{ $stats['read_percentage'] }}%">
                                </div>
                            </div>
                        </div>
                        
                        <!-- Stats -->
                        <div class="grid grid-cols-2 gap-3 pt-4 border-t border-gray-200">
                            <div class="text-center p-3 bg-white/60 rounded-lg">
                                <p class="text-2xl font-bold text-gray-900">{{ $stats['read_count'] }}</p>
                                <p class="text-xs text-gray-600">Read</p>
                            </div>
                            <div class="text-center p-3 bg-white/60 rounded-lg">
                                <p class="text-2xl font-bold text-gray-900">{{ $stats['unread_count'] }}</p>
                                <p class="text-xs text-gray-600">Unread</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>
@endsection