@extends('layouts.admin')

@section('title', 'Notification Analytics')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Notification Analytics</h1>
                <p class="mt-2 text-gray-600">Monitor notification performance and engagement</p>
            </div>
            <a href="{{ route('admin.notifications.index') }}" 
               class="px-6 py-3 bg-[#DDEECD] text-gray-800 font-semibold rounded-lg hover:bg-[#DDEECD]/80 transition">
                Back to Notifications
            </a>
        </div>
        
        <!-- Overview Stats -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-xl shadow-lg p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-white/20 rounded-lg">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                    </div>
                </div>
                <p class="text-sm mb-1 opacity-90">Total Notifications</p>
                <p class="text-4xl font-bold">{{ number_format($stats['total_notifications']) }}</p>
                <p class="text-xs mt-2 opacity-75">All time</p>
            </div>
            
            <div class="bg-gradient-to-br from-green-500 to-green-600 text-white rounded-xl shadow-lg p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-white/20 rounded-lg">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <p class="text-sm mb-1 opacity-90">Total Read</p>
                <p class="text-4xl font-bold">{{ number_format($stats['total_read']) }}</p>
                <p class="text-xs mt-2 opacity-75">{{ $stats['overall_read_rate'] }}% read rate</p>
            </div>
            
            <div class="bg-gradient-to-br from-purple-500 to-purple-600 text-white rounded-xl shadow-lg p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-white/20 rounded-lg">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                        </svg>
                    </div>
                </div>
                <p class="text-sm mb-1 opacity-90">Sent (30 days)</p>
                <p class="text-4xl font-bold">{{ number_format($stats['recent_sent']) }}</p>
                <p class="text-xs mt-2 opacity-75">Last month</p>
            </div>
            
            <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 text-white rounded-xl shadow-lg p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-white/20 rounded-lg">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <p class="text-sm mb-1 opacity-90">Scheduled</p>
                <p class="text-4xl font-bold">{{ number_format($stats['total_scheduled']) }}</p>
                <p class="text-xs mt-2 opacity-75">Pending delivery</p>
            </div>
        </div>
        
        <div class="grid lg:grid-cols-2 gap-6 mb-8">
            <!-- By Priority -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-6">By Priority</h3>
                <div class="space-y-4">
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-medium text-gray-700">High Priority</span>
                            <span class="text-sm font-bold text-gray-900">{{ number_format($stats['high_priority']) }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-3">
                            <div class="bg-red-500 h-3 rounded-full" 
                                 style="width: {{ $stats['total_notifications'] > 0 ? ($stats['high_priority'] / $stats['total_notifications'] * 100) : 0 }}%">
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-medium text-gray-700">Medium Priority</span>
                            <span class="text-sm font-bold text-gray-900">{{ number_format($stats['medium_priority']) }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-3">
                            <div class="bg-yellow-500 h-3 rounded-full" 
                                 style="width: {{ $stats['total_notifications'] > 0 ? ($stats['medium_priority'] / $stats['total_notifications'] * 100) : 0 }}%">
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-medium text-gray-700">Low Priority</span>
                            <span class="text-sm font-bold text-gray-900">{{ number_format($stats['low_priority']) }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-3">
                            <div class="bg-green-500 h-3 rounded-full" 
                                 style="width: {{ $stats['total_notifications'] > 0 ? ($stats['low_priority'] / $stats['total_notifications'] * 100) : 0 }}%">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- By Category -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-6">By Category</h3>
                <div class="space-y-4">
                    @foreach($stats['by_category'] as $category => $count)
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-medium text-gray-700">{{ ucfirst($category) }}</span>
                            <span class="text-sm font-bold text-gray-900">{{ number_format($count) }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-3">
                            <div class="bg-[#5E17EB] h-3 rounded-full" 
                                 style="width: {{ $stats['total_notifications'] > 0 ? ($count / $stats['total_notifications'] * 100) : 0 }}%">
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        
        <!-- Daily Activity Chart -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-8">
            <h3 class="text-lg font-bold text-gray-900 mb-6">Activity (Last 30 Days)</h3>
            <div class="h-80 flex items-end justify-between gap-2">
                @php
                    $maxCount = $dailyActivity->max('count') ?: 1;
                @endphp
                @foreach($dailyActivity as $day)
                    <div class="flex-1 flex flex-col items-center group">
                        <div class="relative w-full">
                            <div class="bg-gradient-to-t from-[#5E17EB] to-[#DDEECD] rounded-t-lg transition-all hover:opacity-80 cursor-pointer" 
                                 style="height: {{ ($day->count / $maxCount) * 300 }}px; min-height: 4px;"
                                 title="{{ $day->date }}: {{ $day->count }} notifications">
                            </div>
                        </div>
                        <span class="text-xs text-gray-500 mt-2 transform rotate-45 origin-left">
                            {{ \Carbon\Carbon::parse($day->date)->format('M d') }}
                        </span>
                    </div>
                @endforeach
            </div>
        </div>
        
        <!-- Top Recipients -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <h3 class="text-lg font-bold text-gray-900">Top Recipients</h3>
                <p class="text-sm text-gray-600 mt-1">Users who received the most notifications</p>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rank</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Notifications</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($topRecipients as $index => $recipient)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm font-bold text-gray-900">#{{ $index + 1 }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm font-medium text-gray-900">{{ $recipient->recipient->name }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm text-gray-600">{{ $recipient->recipient->email }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm font-bold text-[#5E17EB]">{{ number_format($recipient->notification_count) }}</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        
    </div>
</div>
@endsection