@extends('layouts.admin')

@section('title', 'Payment Statistics')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <a href="{{ route('admin.payments.index') }}" class="text-blue-600 hover:text-blue-800 mb-2 inline-block">
                ← Back to Payments
            </a>
            <h1 class="text-3xl font-bold text-gray-900">Payment Statistics & Analytics</h1>
            <p class="text-gray-600 mt-1">Overview of all payment activity and revenue</p>
        </div>
        <div class="flex gap-3">
            <button onclick="window.print()" 
                    class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                </svg>
                Print Report
            </button>
            <a href="{{ route('admin.payments.export') }}" 
               class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Export Data
            </a>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Revenue -->
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm mb-1">Total Revenue</p>
                    <p class="text-3xl font-bold">${{ number_format($stats['total_revenue'], 2) }}</p>
                    <p class="text-green-100 text-xs mt-2">All completed transactions</p>
                </div>
                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"></path>
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Transactions -->
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm mb-1">Total Transactions</p>
                    <p class="text-3xl font-bold">{{ number_format($stats['total_transactions']) }}</p>
                    <p class="text-blue-100 text-xs mt-2">
                        {{ $stats['total_transactions'] > 0 ? round(($stats['successful_transactions'] / $stats['total_transactions']) * 100, 1) : 0 }}% success rate
                    </p>
                </div>
                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                        <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Active Subscriptions -->
        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm mb-1">Active Subscriptions</p>
                    <p class="text-3xl font-bold">{{ number_format($stats['active_subscriptions']) }}</p>
                    <p class="text-purple-100 text-xs mt-2">
                        {{ number_format($stats['cancelled_subscriptions']) }} cancelled
                    </p>
                </div>
                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Failed Payments -->
        <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-red-100 text-sm mb-1">Failed Payments</p>
                    <p class="text-3xl font-bold">{{ number_format($stats['failed_transactions']) }}</p>
                    <p class="text-red-100 text-xs mt-2">
                        {{ number_format($stats['pending_transactions']) }} pending
                    </p>
                </div>
                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Monthly Revenue -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Monthly Revenue (Last 12 Months)</h2>
            
            @if($monthlyRevenue->count() > 0)
                <div class="space-y-3">
                    @foreach($monthlyRevenue as $month)
                        <div>
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm font-medium text-gray-700">
                                    {{ \Carbon\Carbon::parse($month->month . '-01')->format('M Y') }}
                                </span>
                                <span class="text-sm font-bold text-gray-900">
                                    ${{ number_format($month->revenue, 2) }}
                                </span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-blue-500 h-2 rounded-full" 
                                     style="width: {{ $monthlyRevenue->max('revenue') > 0 ? ($month->revenue / $monthlyRevenue->max('revenue')) * 100 : 0 }}%">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-center text-gray-500 py-8">No revenue data available</p>
            @endif
        </div>

        <!-- Revenue by Plan -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Revenue by Plan</h2>
            
            @if($revenueByPlan->count() > 0)
                <div class="space-y-4">
                    @foreach($revenueByPlan as $plan)
                        <div>
                            <div class="flex justify-between items-center mb-2">
                                <div>
                                    <span class="text-sm font-medium text-gray-900">{{ $plan->name }}</span>
                                    <p class="text-xs text-gray-500">{{ $plan->count }} transactions</p>
                                </div>
                                <span class="text-sm font-bold text-green-600">
                                    ${{ number_format($plan->revenue, 2) }}
                                </span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-3">
                                <div class="h-3 rounded-full
                                    @if($plan->name === 'Starter') bg-green-500
                                    @elseif($plan->name === 'Professional') bg-blue-500
                                    @elseif($plan->name === 'Enterprise') bg-purple-500
                                    @else bg-gray-500
                                    @endif" 
                                     style="width: {{ $revenueByPlan->max('revenue') > 0 ? ($plan->revenue / $revenueByPlan->max('revenue')) * 100 : 0 }}%">
                                </div>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">
                                {{ $stats['total_revenue'] > 0 ? round(($plan->revenue / $stats['total_revenue']) * 100, 1) : 0 }}% of total revenue
                            </p>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-center text-gray-500 py-8">No plan data available</p>
            @endif
        </div>
    </div>

    <!-- Subscription Distribution -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Active Subscriptions by Plan -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Active Subscriptions by Plan</h2>
            
            @if($subscriptionsByPlan->count() > 0)
                <div class="space-y-4">
                    @foreach($subscriptionsByPlan as $sub)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center flex-1">
                                <div class="w-10 h-10 rounded-lg flex items-center justify-center mr-3
                                    @if($sub->plan->name === 'Starter') bg-green-100
                                    @elseif($sub->plan->name === 'Professional') bg-blue-100
                                    @elseif($sub->plan->name === 'Enterprise') bg-purple-100
                                    @else bg-gray-100
                                    @endif">
                                    <span class="font-bold
                                        @if($sub->plan->name === 'Starter') text-green-600
                                        @elseif($sub->plan->name === 'Professional') text-blue-600
                                        @elseif($sub->plan->name === 'Enterprise') text-purple-600
                                        @else text-gray-600
                                        @endif">
                                        {{ substr($sub->plan->name, 0, 1) }}
                                    </span>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-900">{{ $sub->plan->name }}</p>
                                    <div class="w-full bg-gray-200 rounded-full h-2 mt-1">
                                        <div class="h-2 rounded-full
                                            @if($sub->plan->name === 'Starter') bg-green-500
                                            @elseif($sub->plan->name === 'Professional') bg-blue-500
                                            @elseif($sub->plan->name === 'Enterprise') bg-purple-500
                                            @else bg-gray-500
                                            @endif" 
                                             style="width: {{ $subscriptionsByPlan->max('count') > 0 ? ($sub->count / $subscriptionsByPlan->max('count')) * 100 : 0 }}%">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-right ml-4">
                                <p class="text-lg font-bold text-gray-900">{{ $sub->count }}</p>
                                <p class="text-xs text-gray-500">
                                    {{ $stats['active_subscriptions'] > 0 ? round(($sub->count / $stats['active_subscriptions']) * 100, 1) : 0 }}%
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-center text-gray-500 py-8">No active subscriptions</p>
            @endif
        </div>

        <!-- Payment Status Breakdown -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Payment Status Breakdown</h2>
            
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <span class="w-3 h-3 bg-green-500 rounded-full mr-2"></span>
                        <span class="text-sm text-gray-700">Completed</span>
                    </div>
                    <div class="text-right">
                        <span class="text-sm font-bold text-gray-900">{{ number_format($stats['successful_transactions']) }}</span>
                        <p class="text-xs text-gray-500">
                            ${{ number_format($stats['total_revenue'], 2) }}
                        </p>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <span class="w-3 h-3 bg-red-500 rounded-full mr-2"></span>
                        <span class="text-sm text-gray-700">Failed</span>
                    </div>
                    <span class="text-sm font-bold text-gray-900">{{ number_format($stats['failed_transactions']) }}</span>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <span class="w-3 h-3 bg-yellow-500 rounded-full mr-2"></span>
                        <span class="text-sm text-gray-700">Pending</span>
                    </div>
                    <span class="text-sm font-bold text-gray-900">{{ number_format($stats['pending_transactions']) }}</span>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <span class="w-3 h-3 bg-purple-500 rounded-full mr-2"></span>
                        <span class="text-sm text-gray-700">Refunded</span>
                    </div>
                    <div class="text-right">
                        <span class="text-sm font-bold text-gray-900">Refunds</span>
                        <p class="text-xs text-gray-500">
                            ${{ number_format($stats['refunded_amount'], 2) }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="mt-6 pt-6 border-t">
                <div class="flex justify-between items-center">
                    <span class="text-sm font-medium text-gray-700">Success Rate</span>
                    <span class="text-lg font-bold text-green-600">
                        {{ $stats['total_transactions'] > 0 ? round(($stats['successful_transactions'] / $stats['total_transactions']) * 100, 1) : 0 }}%
                    </span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-3 mt-2">
                    <div class="bg-green-500 h-3 rounded-full" 
                         style="width: {{ $stats['total_transactions'] > 0 ? ($stats['successful_transactions'] / $stats['total_transactions']) * 100 : 0 }}%">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Agencies -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
        <h2 class="text-xl font-bold text-gray-900 mb-4">Top Paying Agencies</h2>
        
        @if($topAgencies->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rank</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Agency</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Paid</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Payments</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Avg Payment</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Visual</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($topAgencies as $index => $item)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center justify-center w-8 h-8 rounded-full
                                        @if($index === 0) bg-yellow-100 text-yellow-800
                                        @elseif($index === 1) bg-gray-200 text-gray-700
                                        @elseif($index === 2) bg-orange-100 text-orange-700
                                        @else bg-blue-50 text-blue-600
                                        @endif font-bold">
                                        {{ $index + 1 }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                            <span class="text-blue-600 text-xs font-semibold">
                                                {{ substr($item->agency->agency_name ?? 'N/A', 0, 2) }}
                                            </span>
                                        </div>
                                        <span class="font-medium text-gray-900">{{ $item->agency->agency_name ?? 'N/A' }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm font-bold text-green-600">${{ number_format($item->total_paid, 2) }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm text-gray-900">{{ $item->payment_count }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm text-gray-600">${{ number_format($item->total_paid / $item->payment_count, 2) }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="bg-green-500 h-2 rounded-full" 
                                             style="width: {{ $topAgencies->max('total_paid') > 0 ? ($item->total_paid / $topAgencies->max('total_paid')) * 100 : 0 }}%">
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-center text-gray-500 py-8">No payment data available</p>
        @endif
    </div>

    <!-- Recent Transactions -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h2 class="text-xl font-bold text-gray-900 mb-4">Recent Transactions</h2>
        
        @if($recentTransactions->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Agency</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($recentTransactions as $transaction)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <span class="text-sm font-medium text-gray-900">
                                        {{ Str::limit($transaction->agency->agency_name ?? 'N/A', 30) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm font-bold {{ $transaction->amount < 0 ? 'text-red-600' : 'text-green-600' }}">
                                        ${{ number_format(abs($transaction->amount), 2) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($transaction->type === 'subscription') bg-blue-100 text-blue-800
                                        @elseif($transaction->type === 'refund') bg-purple-100 text-purple-800
                                        @else bg-gray-100 text-gray-800
                                        @endif">
                                        {{ ucfirst($transaction->type) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($transaction->status === 'completed') bg-green-100 text-green-800
                                        @elseif($transaction->status === 'failed') bg-red-100 text-red-800
                                        @elseif($transaction->status === 'pending') bg-yellow-100 text-yellow-800
                                        @else bg-gray-100 text-gray-800
                                        @endif">
                                        {{ ucfirst($transaction->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $transaction->created_at->diffForHumans() }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <a href="{{ route('admin.payments.show', $transaction) }}" 
                                       class="text-blue-600 hover:text-blue-900 text-sm">
                                        View
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-center text-gray-500 py-8">No recent transactions</p>
        @endif
    </div>
</div>

<style>
@media print {
    .no-print, button, a[href] {
        display: none !important;
    }
    body {
        print-color-adjust: exact;
        -webkit-print-color-adjust: exact;
    }
}
</style>
@endsection