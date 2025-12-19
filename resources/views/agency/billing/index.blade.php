@extends('layouts.admin')

@section('title', 'Billing & Subscriptions')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Billing & Subscriptions</h1>
        <p class="text-gray-600 mt-1">Manage your subscription and view payment history</p>
    </div>

    <!-- Current Subscription Card -->
    <div class="bg-gradient-to-br from-blue-600 to-indigo-700 rounded-2xl shadow-xl p-8 mb-8 text-white">
        <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6">
            <div class="flex-1">
                <div class="flex items-center gap-3 mb-4">
                    <h2 class="text-2xl font-bold">
                        @if($subscription)
                            {{ $subscription->plan->name }} Plan
                        @else
                            No Active Subscription
                        @endif
                    </h2>
                    @if($subscription)
                        @if($subscription->isActive())
                            <span class="px-3 py-1 bg-green-500 text-white text-xs font-semibold rounded-full">Active</span>
                        @elseif($subscription->isOnTrial())
                            <span class="px-3 py-1 bg-yellow-500 text-white text-xs font-semibold rounded-full">Trial</span>
                        @elseif($subscription->isCancelled())
                            <span class="px-3 py-1 bg-red-500 text-white text-xs font-semibold rounded-full">Cancelled</span>
                        @elseif($subscription->isExpired())
                            <span class="px-3 py-1 bg-gray-500 text-white text-xs font-semibold rounded-full">Expired</span>
                        @endif
                    @endif
                </div>

                @if($subscription)
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <div>
                            <p class="text-blue-200 text-sm mb-1">Current Period</p>
                            <p class="font-semibold text-lg">
                                {{ $subscription->current_period_start?->format('M d, Y') }} - 
                                {{ $subscription->current_period_end?->format('M d, Y') }}
                            </p>
                        </div>

                        <div>
                            <p class="text-blue-200 text-sm mb-1">Next Renewal</p>
                            <p class="font-semibold text-lg">
                                @if($subscription->current_period_end)
                                    {{ $subscription->current_period_end->format('M d, Y') }}
                                @else
                                    N/A
                                @endif
                            </p>
                            @if($subscription->current_period_end)
                                <p class="text-blue-200 text-xs">
                                    {{ abs($subscription->daysUntilRenewal()) }} days 
                                    {{ $subscription->daysUntilRenewal() >= 0 ? 'remaining' : 'overdue' }}
                                </p>
                            @endif
                        </div>

                        <div>
                            <p class="text-blue-200 text-sm mb-1">Monthly Cost</p>
                            <p class="font-semibold text-lg">{{ $subscription->plan->formatted_price }}</p>
                            <p class="text-blue-200 text-xs">Billed {{ $subscription->plan->billing_period }}ly</p>
                        </div>
                    </div>

                    <!-- Plan Features -->
                    <div class="flex flex-wrap gap-4 text-sm">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            {{ $subscription->plan->agents_display }} Agents
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            {{ $subscription->plan->properties_display }} Properties
                        </div>
                        @if($subscription->plan->email_support)
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                Email Support
                            </div>
                        @endif
                        @if($subscription->plan->priority_support)
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                Priority Support
                            </div>
                        @endif
                    </div>
                @else
                    <p class="text-blue-100 mb-4">You don't have an active subscription. Subscribe to a plan to unlock all features.</p>
                @endif
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col gap-3 lg:flex-shrink-0">
                @if($subscription)
                    <a href="{{ route('agency.subscription.manage') }}" 
                       class="px-6 py-3 bg-white text-blue-700 rounded-lg hover:bg-blue-50 transition font-semibold text-center whitespace-nowrap">
                        Manage Subscription
                    </a>
                @else
                    <a href="#" 
                       class="px-6 py-3 bg-white text-blue-700 rounded-lg hover:bg-blue-50 transition font-semibold text-center whitespace-nowrap">
                        Choose a Plan
                    </a>
                @endif
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Spent</p>
                    <p class="text-2xl font-bold text-gray-900 mt-2">${{ number_format($stats['total_spent'], 2) }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Payments</p>
                    <p class="text-2xl font-bold text-gray-900 mt-2">{{ $stats['total_transactions'] }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Successful</p>
                    <p class="text-2xl font-bold text-green-600 mt-2">{{ $stats['successful_transactions'] }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Failed</p>
                    <p class="text-2xl font-bold text-red-600 mt-2">{{ $stats['failed_transactions'] }}</p>
                </div>
                <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Billing Information -->
    @if($billing)
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
        <h3 class="text-lg font-bold text-gray-900 mb-4">Billing Information</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <p class="text-sm text-gray-600 mb-1">Contact Name</p>
                <p class="font-semibold text-gray-900">{{ $billing->billing_contact_name }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600 mb-1">Email</p>
                <p class="font-semibold text-gray-900">{{ $billing->billing_email }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600 mb-1">Phone</p>
                <p class="font-semibold text-gray-900">{{ $billing->billing_phone ?? 'N/A' }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600 mb-1">Payment Method</p>
                <p class="font-semibold text-gray-900">{{ ucfirst($billing->payment_method ?? 'Not set') }}</p>
            </div>
            @if($billing->billing_address)
            <div class="md:col-span-2">
                <p class="text-sm text-gray-600 mb-1">Billing Address</p>
                <p class="font-semibold text-gray-900">{{ $billing->billing_address }}</p>
            </div>
            @endif
        </div>
    </div>
    @endif

    <!-- Payment History -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="p-6 border-b border-gray-200">
            <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4">
                <h3 class="text-lg font-bold text-gray-900">Payment History</h3>

                <!-- Filters -->
                <form method="GET" action="{{ route('agency.billing.index') }}" class="flex flex-wrap gap-3">
                    <select name="status" class="px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">All Status</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Failed</option>
                    </select>

                    <select name="type" class="px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">All Types</option>
                        <option value="subscription" {{ request('type') == 'subscription' ? 'selected' : '' }}>Subscription</option>
                        <option value="payment" {{ request('type') == 'payment' ? 'selected' : '' }}>Payment</option>
                        <option value="refund" {{ request('type') == 'refund' ? 'selected' : '' }}>Refund</option>
                    </select>

                    <input type="date" name="date_from" value="{{ request('date_from') }}" placeholder="From"
                           class="px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">

                    <input type="date" name="date_to" value="{{ request('date_to') }}" placeholder="To"
                           class="px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">

                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm font-medium">
                        Filter
                    </button>

                    @if(request()->hasAny(['status', 'type', 'date_from', 'date_to']))
                        <a href="{{ route('agency.billing.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition text-sm font-medium">
                            Clear
                        </a>
                    @endif
                </form>
            </div>
        </div>

        <!-- Transactions Table -->
        @if($transactions->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Transaction ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($transactions as $transaction)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $transaction->created_at->format('M d, Y') }}
                                    <div class="text-xs text-gray-500">{{ $transaction->created_at->format('h:i A') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-gray-600">
                                    {{ $transaction->transaction_id ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900">
                                    {{ $transaction->description ?? ($transaction->subscription ? $transaction->subscription->plan->name . ' Subscription' : 'Payment') }}
                                    @if($transaction->payment_method_last4)
                                        <div class="text-xs text-gray-500">•••• {{ $transaction->payment_method_last4 }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <span class="px-2 py-1 bg-gray-100 text-gray-800 text-xs font-medium rounded">
                                        {{ ucfirst($transaction->type) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                    {{ $transaction->formatted_amount }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($transaction->status == 'completed')
                                        <span class="px-3 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full">Completed</span>
                                    @elseif($transaction->status == 'pending')
                                        <span class="px-3 py-1 bg-yellow-100 text-yellow-800 text-xs font-semibold rounded-full">Pending</span>
                                    @elseif($transaction->status == 'failed')
                                        <span class="px-3 py-1 bg-red-100 text-red-800 text-xs font-semibold rounded-full">Failed</span>
                                    @else
                                        <span class="px-3 py-1 bg-gray-100 text-gray-800 text-xs font-semibold rounded-full">{{ ucfirst($transaction->status) }}</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    @if($transaction->stripe_invoice_id)
                                        <button onclick="downloadInvoice({{ $transaction->id }})" 
                                                class="text-blue-600 hover:text-blue-800 font-medium inline-flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                            Invoice
                                        </button>
                                    @else
                                        <span class="text-gray-400 text-xs">N/A</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $transactions->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="p-12 text-center">
                <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">No Transactions Yet</h3>
                <p class="text-gray-600">Your payment history will appear here once you make your first transaction.</p>
            </div>
        @endif
    </div>
</div>

<script>
function downloadInvoice(transactionId) {
    // This will be implemented with Stripe API
    alert('Invoice download functionality will be implemented');
    
    // Example implementation:
    // window.location.href = `/agency/billing/invoice/${transactionId}`;
}
</script>
@endsection