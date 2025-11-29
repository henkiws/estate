@extends('layouts.admin')

@section('title', 'Agencies Report')

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
                <h1 class="text-3xl font-bold text-gray-900">Agencies Report</h1>
            </div>
            <p class="text-gray-600">Registration trends, approval rates, and geographic distribution</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.reports.export', ['type' => 'agencies', 'start_date' => $startDate, 'end_date' => $endDate]) }}" 
               class="flex items-center gap-2 px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition font-medium">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Export CSV
            </a>
            <button onclick="window.print()" class="flex items-center gap-2 px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition font-medium">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                </svg>
                Print
            </button>
        </div>
    </div>

    <!-- Date Range Filter -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 mb-6">
        <form method="GET" action="{{ route('admin.reports.agencies') }}" class="flex flex-wrap items-center gap-4">
            <label class="text-sm font-medium text-gray-700">Date Range:</label>
            <input type="date" name="start_date" value="{{ $startDate }}" 
                   class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
            <span class="text-gray-500">to</span>
            <input type="date" name="end_date" value="{{ $endDate }}" 
                   class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
            <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition font-medium">
                Apply Filter
            </button>
            <a href="{{ route('admin.reports.agencies') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition font-medium">
                Reset
            </a>
        </form>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 xl:grid-cols-7 gap-4 mb-8">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
            <div class="text-sm text-gray-600 mb-1">Total Agencies</div>
            <div class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_agencies']) }}</div>
        </div>
        <div class="bg-green-50 border border-green-200 rounded-xl p-4">
            <div class="text-sm text-green-700 mb-1">Approved</div>
            <div class="text-2xl font-bold text-green-900">{{ number_format($stats['approved_agencies']) }}</div>
        </div>
        <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4">
            <div class="text-sm text-yellow-700 mb-1">Pending</div>
            <div class="text-2xl font-bold text-yellow-900">{{ number_format($stats['pending_agencies']) }}</div>
        </div>
        <div class="bg-red-50 border border-red-200 rounded-xl p-4">
            <div class="text-sm text-red-700 mb-1">Rejected</div>
            <div class="text-2xl font-bold text-red-900">{{ number_format($stats['rejected_agencies']) }}</div>
        </div>
        <div class="bg-gray-50 border border-gray-200 rounded-xl p-4">
            <div class="text-sm text-gray-700 mb-1">Suspended</div>
            <div class="text-2xl font-bold text-gray-900">{{ number_format($stats['suspended_agencies']) }}</div>
        </div>
        <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
            <div class="text-sm text-blue-700 mb-1">New This Month</div>
            <div class="text-2xl font-bold text-blue-900">{{ number_format($stats['new_this_month']) }}</div>
        </div>
        <div class="bg-purple-50 border border-purple-200 rounded-xl p-4">
            <div class="text-sm text-purple-700 mb-1">With Subscriptions</div>
            <div class="text-2xl font-bold text-purple-900">{{ number_format($stats['with_subscriptions']) }}</div>
        </div>
    </div>

    <!-- Charts Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Geographic Distribution -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-bold text-gray-900 mb-4">Geographic Distribution</h2>
            @if($agenciesByState->count() > 0)
                <div class="space-y-3">
                    @php $maxCount = $agenciesByState->first()->count; @endphp
                    @foreach($agenciesByState as $state)
                        <div>
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-sm font-medium text-gray-700">{{ $state->state }}</span>
                                <span class="text-sm font-bold text-purple-600">{{ $state->count }}</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-3">
                                <div class="bg-gradient-to-r from-purple-500 to-purple-600 h-3 rounded-full transition-all" 
                                     style="width: {{ ($state->count / $maxCount) * 100 }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-8">No data available</p>
            @endif
        </div>

        <!-- Registration Trend -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-bold text-gray-900 mb-4">Registration Trend (Last 12 Months)</h2>
            @if($registrationTrend->count() > 0)
                <div class="space-y-3">
                    @php $maxReg = $registrationTrend->max('count') ?: 1; @endphp
                    @foreach($registrationTrend as $trend)
                        <div>
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-sm font-medium text-gray-700">{{ \Carbon\Carbon::parse($trend->month . '-01')->format('M Y') }}</span>
                                <span class="text-sm font-bold text-purple-600">{{ $trend->count }}</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-3">
                                <div class="bg-gradient-to-r from-blue-500 to-blue-600 h-3 rounded-full transition-all" 
                                     style="width: {{ ($trend->count / $maxReg) * 100 }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-8">No data available</p>
            @endif
        </div>
    </div>

    <!-- Approval Rate Chart -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
        <h2 class="text-lg font-bold text-gray-900 mb-4">Approval Rate by Month</h2>
        @if($approvalRate->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-200">
                            <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Month</th>
                            <th class="text-center py-3 px-4 text-sm font-semibold text-gray-700">Total</th>
                            <th class="text-center py-3 px-4 text-sm font-semibold text-gray-700">Approved</th>
                            <th class="text-center py-3 px-4 text-sm font-semibold text-gray-700">Rejected</th>
                            <th class="text-center py-3 px-4 text-sm font-semibold text-gray-700">Approval Rate</th>
                            <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Visual</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($approvalRate as $rate)
                            @php
                                $approvalPct = $rate->total > 0 ? ($rate->approved / $rate->total) * 100 : 0;
                                $rejectionPct = $rate->total > 0 ? ($rate->rejected / $rate->total) * 100 : 0;
                            @endphp
                            <tr class="border-b border-gray-100 hover:bg-gray-50">
                                <td class="py-3 px-4 text-sm text-gray-900">{{ \Carbon\Carbon::parse($rate->month . '-01')->format('M Y') }}</td>
                                <td class="py-3 px-4 text-sm text-center font-semibold">{{ $rate->total }}</td>
                                <td class="py-3 px-4 text-sm text-center text-green-600 font-semibold">{{ $rate->approved }}</td>
                                <td class="py-3 px-4 text-sm text-center text-red-600 font-semibold">{{ $rate->rejected }}</td>
                                <td class="py-3 px-4 text-sm text-center">
                                    <span class="px-2 py-1 rounded-full text-xs font-semibold
                                        {{ $approvalPct >= 80 ? 'bg-green-100 text-green-800' : ($approvalPct >= 60 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                        {{ number_format($approvalPct, 1) }}%
                                    </span>
                                </td>
                                <td class="py-3 px-4">
                                    <div class="w-full bg-gray-200 rounded-full h-2 flex overflow-hidden">
                                        <div class="bg-green-500 h-2" style="width: {{ $approvalPct }}%"></div>
                                        <div class="bg-red-500 h-2" style="width: {{ $rejectionPct }}%"></div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-500 text-center py-8">No data available for this period</p>
        @endif
    </div>

    <!-- Two Column Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Top Agencies by Properties -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-bold text-gray-900 mb-4">Top Agencies by Property Count</h2>
            @if($topAgenciesByProperties->count() > 0)
                <div class="space-y-3">
                    @foreach($topAgenciesByProperties as $index => $agency)
                        <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
                            <div class="w-8 h-8 {{ $index < 3 ? 'bg-gradient-to-br from-yellow-400 to-yellow-500' : 'bg-purple-100' }} rounded-full flex items-center justify-center flex-shrink-0">
                                <span class="text-sm font-bold {{ $index < 3 ? 'text-white' : 'text-purple-700' }}">#{{ $index + 1 }}</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="font-semibold text-gray-900 truncate">{{ $agency->agency_name }}</div>
                                <div class="text-xs text-gray-600">{{ $agency->state }}</div>
                            </div>
                            <div class="text-right">
                                <div class="text-lg font-bold text-purple-600">{{ $agency->properties_count }}</div>
                                <div class="text-xs text-gray-600">properties</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-8">No agencies with properties yet</p>
            @endif
        </div>

        <!-- Recent Agencies -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-bold text-gray-900 mb-4">Recent Agency Registrations</h2>
            @if($recentAgencies->count() > 0)
                <div class="space-y-3">
                    @foreach($recentAgencies as $agency)
                        <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
                            <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <span class="text-purple-700 font-semibold text-sm">{{ substr($agency->agency_name, 0, 2) }}</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="font-semibold text-gray-900 truncate">{{ $agency->agency_name }}</div>
                                <div class="text-xs text-gray-600">{{ $agency->created_at->diffForHumans() }}</div>
                            </div>
                            <div>
                                <span class="px-2 py-1 rounded-full text-xs font-semibold
                                    {{ $agency->status === 'approved' ? 'bg-green-100 text-green-800' : 
                                       ($agency->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                       ($agency->status === 'rejected' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800')) }}">
                                    {{ ucfirst($agency->status) }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-8">No recent agencies</p>
            @endif
        </div>
    </div>
</div>

<style>
    @media print {
        .no-print, button, form { display: none; }
        body { background: white; }
        .shadow-lg, .shadow-sm { box-shadow: none !important; }
    }
</style>
@endsection