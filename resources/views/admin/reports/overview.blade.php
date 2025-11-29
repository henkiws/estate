@extends('layouts.admin')

@section('title', 'System Overview Report')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <a href="{{ route('admin.reports.index') }}" class="text-gray-600 hover:text-gray-900">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <h1 class="text-3xl font-bold text-gray-900">System Overview Report</h1>
            </div>
            <p class="text-gray-600">Platform-wide statistics and key performance indicators</p>
        </div>
        <div class="flex gap-3">
            <button onclick="window.print()" class="flex items-center gap-2 px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition font-medium">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                </svg>
                Print Report
            </button>
        </div>
    </div>

    <!-- Period Selector -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 mb-6">
        <form method="GET" action="{{ route('admin.reports.overview') }}" class="flex flex-wrap items-center gap-4">
            <label class="text-sm font-medium text-gray-700">Time Period:</label>
            <div class="flex gap-2">
                <button type="submit" name="period" value="30" 
                        class="px-4 py-2 {{ $period == 30 ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }} rounded-lg transition font-medium">
                    Last 30 Days
                </button>
                <button type="submit" name="period" value="60" 
                        class="px-4 py-2 {{ $period == 60 ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }} rounded-lg transition font-medium">
                    Last 60 Days
                </button>
                <button type="submit" name="period" value="90" 
                        class="px-4 py-2 {{ $period == 90 ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }} rounded-lg transition font-medium">
                    Last 90 Days
                </button>
            </div>
            <span class="text-sm text-gray-500 ml-auto">Showing data from the last {{ $period }} days</span>
        </form>
    </div>

    <!-- Main Statistics Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">
        <!-- Agencies Summary -->
        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
            </div>
            <div class="text-3xl font-bold mb-1">{{ number_format($stats['agencies']['total']) }}</div>
            <div class="text-purple-100 text-sm mb-4">Total Agencies</div>
            <div class="space-y-2 pt-4 border-t border-white border-opacity-20">
                <div class="flex justify-between text-sm">
                    <span class="text-purple-100">New ({{ $period }} days)</span>
                    <span class="font-semibold">{{ number_format($stats['agencies']['new']) }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-purple-100">Approved</span>
                    <span class="font-semibold">{{ number_format($stats['agencies']['approved']) }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-purple-100">Pending</span>
                    <span class="font-semibold">{{ number_format($stats['agencies']['pending']) }}</span>
                </div>
            </div>
        </div>

        <!-- Properties Summary -->
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                </div>
            </div>
            <div class="text-3xl font-bold mb-1">{{ number_format($stats['properties']['total']) }}</div>
            <div class="text-green-100 text-sm mb-4">Total Properties</div>
            <div class="space-y-2 pt-4 border-t border-white border-opacity-20">
                <div class="flex justify-between text-sm">
                    <span class="text-green-100">New ({{ $period }} days)</span>
                    <span class="font-semibold">{{ number_format($stats['properties']['new']) }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-green-100">For Sale</span>
                    <span class="font-semibold">{{ number_format($stats['properties']['for_sale']) }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-green-100">For Rent</span>
                    <span class="font-semibold">{{ number_format($stats['properties']['for_rent']) }}</span>
                </div>
            </div>
        </div>

        <!-- Users Summary -->
        <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
            </div>
            <div class="text-3xl font-bold mb-1">{{ number_format($stats['users']['total']) }}</div>
            <div class="text-orange-100 text-sm mb-4">Total Users</div>
            <div class="space-y-2 pt-4 border-t border-white border-opacity-20">
                <div class="flex justify-between text-sm">
                    <span class="text-orange-100">New ({{ $period }} days)</span>
                    <span class="font-semibold">{{ number_format($stats['users']['new']) }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-orange-100">Verified</span>
                    <span class="font-semibold">{{ number_format($stats['users']['verified']) }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-orange-100">Verification Rate</span>
                    <span class="font-semibold">{{ $stats['users']['total'] > 0 ? number_format(($stats['users']['verified'] / $stats['users']['total']) * 100, 1) : 0 }}%</span>
                </div>
            </div>
        </div>

        <!-- Revenue Summary -->
        <div class="bg-gradient-to-br from-pink-500 to-pink-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"></path>
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"></path>
                    </svg>
                </div>
            </div>
            <div class="text-3xl font-bold mb-1">${{ number_format($stats['revenue']['total'], 2) }}</div>
            <div class="text-pink-100 text-sm mb-4">Total Revenue</div>
            <div class="space-y-2 pt-4 border-t border-white border-opacity-20">
                <div class="flex justify-between text-sm">
                    <span class="text-pink-100">Period ({{ $period }} days)</span>
                    <span class="font-semibold">${{ number_format($stats['revenue']['this_period'], 2) }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-pink-100">Active Subscriptions</span>
                    <span class="font-semibold">{{ number_format($stats['revenue']['active_subscriptions']) }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Activity Timeline -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
        <h2 class="text-xl font-bold text-gray-900 mb-6">Activity Timeline (Last {{ $period }} Days)</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Agencies Activity -->
            <div>
                <div class="flex items-center gap-2 mb-4">
                    <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-900">Agency Registrations</h3>
                </div>
                @if($activityTimeline['agencies']->count() > 0)
                    <div class="space-y-2">
                        @php $maxAgencies = $activityTimeline['agencies']->max('count') ?: 1; @endphp
                        @foreach($activityTimeline['agencies']->sortByDesc('date')->take(10) as $activity)
                            <div>
                                <div class="flex justify-between text-sm mb-1">
                                    <span class="text-gray-600">{{ \Carbon\Carbon::parse($activity->date)->format('M d') }}</span>
                                    <span class="font-semibold text-gray-900">{{ $activity->count }}</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-purple-600 h-2 rounded-full" style="width: {{ ($activity->count / $maxAgencies) * 100 }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-sm">No activity in this period</p>
                @endif
            </div>

            <!-- Properties Activity -->
            <div>
                <div class="flex items-center gap-2 mb-4">
                    <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-900">New Properties</h3>
                </div>
                @if($activityTimeline['properties']->count() > 0)
                    <div class="space-y-2">
                        @php $maxProperties = $activityTimeline['properties']->max('count') ?: 1; @endphp
                        @foreach($activityTimeline['properties']->sortByDesc('date')->take(10) as $activity)
                            <div>
                                <div class="flex justify-between text-sm mb-1">
                                    <span class="text-gray-600">{{ \Carbon\Carbon::parse($activity->date)->format('M d') }}</span>
                                    <span class="font-semibold text-gray-900">{{ $activity->count }}</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-green-600 h-2 rounded-full" style="width: {{ ($activity->count / $maxProperties) * 100 }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-sm">No activity in this period</p>
                @endif
            </div>

            <!-- Users Activity -->
            <div>
                <div class="flex items-center gap-2 mb-4">
                    <div class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-900">User Registrations</h3>
                </div>
                @if($activityTimeline['users']->count() > 0)
                    <div class="space-y-2">
                        @php $maxUsers = $activityTimeline['users']->max('count') ?: 1; @endphp
                        @foreach($activityTimeline['users']->sortByDesc('date')->take(10) as $activity)
                            <div>
                                <div class="flex justify-between text-sm mb-1">
                                    <span class="text-gray-600">{{ \Carbon\Carbon::parse($activity->date)->format('M d') }}</span>
                                    <span class="font-semibold text-gray-900">{{ $activity->count }}</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-orange-600 h-2 rounded-full" style="width: {{ ($activity->count / $maxUsers) * 100 }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-sm">No activity in this period</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Quick Links -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <a href="{{ route('admin.reports.agencies') }}" class="bg-purple-50 border border-purple-200 rounded-xl p-4 hover:bg-purple-100 transition">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-purple-600 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </div>
                <div>
                    <div class="font-semibold text-purple-900">Agencies Report</div>
                    <div class="text-xs text-purple-700">Detailed analytics</div>
                </div>
            </div>
        </a>

        <a href="{{ route('admin.reports.properties') }}" class="bg-green-50 border border-green-200 rounded-xl p-4 hover:bg-green-100 transition">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-green-600 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </div>
                <div>
                    <div class="font-semibold text-green-900">Properties Report</div>
                    <div class="text-xs text-green-700">Detailed analytics</div>
                </div>
            </div>
        </a>

        <a href="{{ route('admin.reports.users') }}" class="bg-orange-50 border border-orange-200 rounded-xl p-4 hover:bg-orange-100 transition">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-orange-600 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </div>
                <div>
                    <div class="font-semibold text-orange-900">Users Report</div>
                    <div class="text-xs text-orange-700">Detailed analytics</div>
                </div>
            </div>
        </a>

        <a href="{{ route('admin.reports.revenue') }}" class="bg-pink-50 border border-pink-200 rounded-xl p-4 hover:bg-pink-100 transition">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-pink-600 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </div>
                <div>
                    <div class="font-semibold text-pink-900">Revenue Report</div>
                    <div class="text-xs text-pink-700">Detailed analytics</div>
                </div>
            </div>
        </a>
    </div>
</div>

<style>
    @media print {
        .no-print { display: none; }
        body { background: white; }
        .shadow-lg, .shadow-sm { box-shadow: none !important; }
    }
</style>
@endsection