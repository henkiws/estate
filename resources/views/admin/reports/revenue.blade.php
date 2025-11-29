@extends('layouts.admin')

@section('title', 'Revenue Report')

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
                <h1 class="text-3xl font-bold text-gray-900">Revenue Report</h1>
            </div>
            <p class="text-gray-600">Financial performance, MRR, ARR, and subscription analytics</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.reports.export', ['type' => 'revenue', 'start_date' => $startDate, 'end_date' => $endDate]) }}" 
               class="flex items-center gap-2 px-4 py-2 bg-pink-600 text-white rounded-lg hover:bg-pink-700 transition font-medium">
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
        <form method="GET" action="{{ route('admin.reports.revenue') }}" class="flex flex-wrap items-center gap-4">
            <label class="text-sm font-medium text-gray-700">Date Range:</label>
            <input type="date" name="start_date" value="{{ $startDate }}" 
                   class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent">
            <span class="text-gray-500">to</span>
            <input type="date" name="end_date" value="{{ $endDate }}" 
                   class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent">
            <button type="submit" class="px-4 py-2 bg-pink-600 text-white rounded-lg hover:bg-pink-700 transition font-medium">
                Apply Filter
            </button>
            <a href="{{ route('admin.reports.revenue') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition font-medium">
                Reset
            </a>
        </form>
    </div>

    <!-- Key Metrics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <!-- Total Revenue -->
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between mb-2">
                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"></path>
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"></path>
                    </svg>
                </div>
            </div>
            <div class="text-sm text-green-100 mb-1">Total Revenue</div>
            <div class="text-3xl font-bold">${{ number_format($stats['total_revenue'], 2) }}</div>
        </div>

        <!-- This Month Revenue -->
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between mb-2">
                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <div class="text-sm text-blue-100 mb-1">This Month</div>
            <div class="text-3xl font-bold">${{ number_format($stats['this_month_revenue'], 2) }}</div>
            @php
                $growth = $stats['last_month_revenue'] > 0 
                    ? (($stats['this_month_revenue'] - $stats['last_month_revenue']) / $stats['last_month_revenue']) * 100 
                    : 0;
            @endphp
            <div class="text-xs text-blue-100 mt-2">
                @if($growth > 0)
                    ↑ {{ number_format($growth, 1) }}% from last month
                @elseif($growth < 0)
                    ↓ {{ number_format(abs($growth), 1) }}% from last month
                @else
                    No change from last month
                @endif
            </div>
        </div>

        <!-- MRR -->
        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between mb-2">
                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>
            <div class="text-sm text-purple-100 mb-1">MRR</div>
            <div class="text-3xl font-bold">${{ number_format($stats['mrr'], 2) }}</div>
            <div class="text-xs text-purple-100 mt-2">Monthly Recurring Revenue</div>
        </div>

        <!-- ARR -->
        <div class="bg-gradient-to-br from-pink-500 to-pink-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between mb-2">
                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                </div>
            </div>
            <div class="text-sm text-pink-100 mb-1">ARR</div>
            <div class="text-3xl font-bold">${{ number_format($stats['arr'], 2) }}</div>
            <div class="text-xs text-pink-100 mt-2">Annual Recurring Revenue</div>
        </div>
    </div>

    <!-- Secondary Metrics -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
            <div class="text-sm text-gray-600 mb-1">Avg Transaction</div>
            <div class="text-2xl font-bold text-gray-900">${{ number_format($stats['average_transaction'], 2) }}</div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
            <div class="text-sm text-gray-600 mb-1">Total Transactions</div>
            <div class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_transactions']) }}</div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
            <div class="text-sm text-gray-600 mb-1">Active Subscriptions</div>
            <div class="text-2xl font-bold text-gray-900">{{ number_format($stats['active_subscriptions']) }}</div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
            <div class="text-sm text-gray-600 mb-1">Last Month Revenue</div>
            <div class="text-2xl font-bold text-gray-900">${{ number_format($stats['last_month_revenue'], 2) }}</div>
        </div>
    </div>

    <!-- Revenue Trend -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
        <h2 class="text-lg font-bold text-gray-900 mb-4">Revenue Trend (Last 12 Months)</h2>
        @if($revenueTrend->count() > 0)
            <div class="space-y-3">
                @php $maxRevenue = $revenueTrend->max('revenue') ?: 1; @endphp
                @foreach($revenueTrend as $trend)
                    <div>
                        <div class="flex justify-between items-center mb-1">
                            <span class="text-sm font-medium text-gray-700">{{ \Carbon\Carbon::parse($trend->month . '-01')->format('M Y') }}</span>
                            <span class="text-sm font-bold text-pink-600">${{ number_format($trend->revenue, 2) }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-3">
                            <div class="bg-gradient-to-r from-pink-500 to-pink-600 h-3 rounded-full transition-all" 
                                 style="width: {{ ($trend->revenue / $maxRevenue) * 100 }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500 text-center py-8">No revenue data available</p>
        @endif
    </div>

    <!-- Charts Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Revenue by Plan -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-bold text-gray-900 mb-4">Revenue by Subscription Plan</h2>
            @if($revenueByPlan->count() > 0)
                <div class="space-y-3">
                    @php 
                        $totalPlanRevenue = $revenueByPlan->sum('revenue');
                        $maxPlanRevenue = $revenueByPlan->max('revenue');
                        $planColors = [
                            'starter' => ['bg' => 'from-green-500 to-green-600', 'text' => 'text-green-600'],
                            'professional' => ['bg' => 'from-blue-500 to-blue-600', 'text' => 'text-blue-600'],
                            'enterprise' => ['bg' => 'from-purple-500 to-purple-600', 'text' => 'text-purple-600'],
                        ];
                    @endphp
                    @foreach($revenueByPlan as $plan)
                        @php
                            $planKey = strtolower($plan->name);
                            $color = $planColors[$planKey] ?? ['bg' => 'from-gray-500 to-gray-600', 'text' => 'text-gray-600'];
                            $percentage = $totalPlanRevenue > 0 ? ($plan->revenue / $totalPlanRevenue) * 100 : 0;
                        @endphp
                        <div>
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-sm font-medium text-gray-700">{{ $plan->name }}</span>
                                <span class="text-sm font-bold {{ $color['text'] }}">${{ number_format($plan->revenue, 2) }} ({{ number_format($percentage, 1) }}%)</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-3">
                                <div class="bg-gradient-to-r {{ $color['bg'] }} h-3 rounded-full transition-all" 
                                     style="width: {{ ($plan->revenue / $maxPlanRevenue) * 100 }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-8">No plan revenue data</p>
            @endif
        </div>

        <!-- Top Revenue Agencies -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-bold text-gray-900 mb-4">Top Revenue Generating Agencies</h2>
            @if($topRevenueAgencies->count() > 0)
                <div class="space-y-3">
                    @foreach($topRevenueAgencies as $index => $transaction)
                        @if($transaction->agency)
                            <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
                                <div class="w-8 h-8 {{ $index < 3 ? 'bg-gradient-to-br from-yellow-400 to-yellow-500' : 'bg-pink-100' }} rounded-full flex items-center justify-center flex-shrink-0">
                                    <span class="text-sm font-bold {{ $index < 3 ? 'text-white' : 'text-pink-700' }}">#{{ $index + 1 }}</span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="font-semibold text-gray-900 truncate">{{ $transaction->agency->agency_name }}</div>
                                    <div class="text-xs text-gray-600">{{ $transaction->agency->state ?? 'N/A' }}</div>
                                </div>
                                <div class="text-right">
                                    <div class="text-lg font-bold text-pink-600">${{ number_format($transaction->total_revenue, 2) }}</div>
                                    <div class="text-xs text-gray-600">total revenue</div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-8">No revenue data available</p>
            @endif
        </div>
    </div>

    <!-- Performance Insights -->
    <div class="bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl shadow-lg p-6 text-white">
        <h2 class="text-xl font-bold mb-4">Performance Insights</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white bg-opacity-10 rounded-lg p-4">
                <div class="text-sm text-indigo-100 mb-2">Revenue Growth</div>
                <div class="text-2xl font-bold">
                    @php
                        $revenueGrowth = $stats['last_month_revenue'] > 0 
                            ? (($stats['this_month_revenue'] - $stats['last_month_revenue']) / $stats['last_month_revenue']) * 100 
                            : 0;
                    @endphp
                    {{ $revenueGrowth > 0 ? '+' : '' }}{{ number_format($revenueGrowth, 1) }}%
                </div>
                <div class="text-xs text-indigo-100 mt-1">Month over month</div>
            </div>
            <div class="bg-white bg-opacity-10 rounded-lg p-4">
                <div class="text-sm text-indigo-100 mb-2">Active Sub Rate</div>
                <div class="text-2xl font-bold">
                    {{ $stats['total_transactions'] > 0 ? number_format(($stats['active_subscriptions'] / max($stats['total_transactions'], 1)) * 100, 1) : 0 }}%
                </div>
                <div class="text-xs text-indigo-100 mt-1">Of total transactions</div>
            </div>
            <div class="bg-white bg-opacity-10 rounded-lg p-4">
                <div class="text-sm text-indigo-100 mb-2">Revenue per Sub</div>
                <div class="text-2xl font-bold">
                    ${{ $stats['active_subscriptions'] > 0 ? number_format($stats['mrr'] / $stats['active_subscriptions'], 2) : 0 }}
                </div>
                <div class="text-xs text-indigo-100 mt-1">Average monthly</div>
            </div>
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