@extends('layouts.admin')

@section('title', 'Payment Transactions')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Payment Transactions</h1>
            <p class="text-gray-600 mt-1">View and manage all payment transactions</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.payments.statistics') }}" 
               class="inline-flex items-center px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
                Statistics
            </a>
            <button onclick="exportTransactions()" 
                    class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Export CSV
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg">
            {{ session('error') }}
        </div>
    @endif

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow-sm p-4 border-l-4 border-green-500">
            <p class="text-sm text-gray-600">Total Revenue</p>
            <p class="text-2xl font-bold text-gray-900">
                ${{ number_format(\App\Models\Transaction::where('status', 'completed')->sum('amount'), 2) }}
            </p>
        </div>
        <div class="bg-white rounded-lg shadow-sm p-4 border-l-4 border-blue-500">
            <p class="text-sm text-gray-600">Completed</p>
            <p class="text-2xl font-bold text-gray-900">
                {{ number_format(\App\Models\Transaction::where('status', 'completed')->count()) }}
            </p>
        </div>
        <div class="bg-white rounded-lg shadow-sm p-4 border-l-4 border-red-500">
            <p class="text-sm text-gray-600">Failed</p>
            <p class="text-2xl font-bold text-gray-900">
                {{ number_format(\App\Models\Transaction::where('status', 'failed')->count()) }}
            </p>
        </div>
        <div class="bg-white rounded-lg shadow-sm p-4 border-l-4 border-yellow-500">
            <p class="text-sm text-gray-600">Pending</p>
            <p class="text-2xl font-bold text-gray-900">
                {{ number_format(\App\Models\Transaction::where('status', 'pending')->count()) }}
            </p>
        </div>
    </div>

    <!-- Quick Links -->
    <div class="flex gap-3 mb-6">
        <a href="{{ route('admin.payments.subscriptions') }}" 
           class="px-4 py-2 bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100 transition text-sm font-medium">
            📋 View Subscriptions
        </a>
        <a href="{{ route('admin.payments.failed') }}" 
           class="px-4 py-2 bg-red-50 text-red-700 rounded-lg hover:bg-red-100 transition text-sm font-medium">
            ⚠️ Failed Payments ({{ \App\Models\Transaction::where('status', 'failed')->count() }})
        </a>
        <a href="{{ route('admin.payments.refunds') }}" 
           class="px-4 py-2 bg-purple-50 text-purple-700 rounded-lg hover:bg-purple-100 transition text-sm font-medium">
            💰 Refunds ({{ \App\Models\Transaction::where('status', 'refunded')->count() }})
        </a>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <form method="GET" action="{{ route('admin.payments.index') }}" id="filterForm">
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-4">
                <!-- Status Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        <option value="">All Status</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Failed</option>
                        <option value="refunded" {{ request('status') == 'refunded' ? 'selected' : '' }}>Refunded</option>
                    </select>
                </div>

                <!-- Type Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Type</label>
                    <select name="type" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        <option value="">All Types</option>
                        <option value="subscription" {{ request('type') == 'subscription' ? 'selected' : '' }}>Subscription</option>
                        <option value="addon" {{ request('type') == 'addon' ? 'selected' : '' }}>Add-on</option>
                        <option value="refund" {{ request('type') == 'refund' ? 'selected' : '' }}>Refund</option>
                        <option value="adjustment" {{ request('type') == 'adjustment' ? 'selected' : '' }}>Adjustment</option>
                    </select>
                </div>

                <!-- Agency Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Agency</label>
                    <select name="agency_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        <option value="">All Agencies</option>
                        @foreach($agencies as $agency)
                            <option value="{{ $agency->id }}" {{ request('agency_id') == $agency->id ? 'selected' : '' }}>
                                {{ $agency->agency_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Start Date -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Start Date</label>
                    <input type="date" 
                           name="start_date" 
                           value="{{ request('start_date') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- End Date -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">End Date</label>
                    <input type="date" 
                           name="end_date" 
                           value="{{ request('end_date') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <!-- Search -->
            <div class="mt-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Search Transaction ID</label>
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}"
                       placeholder="Search by transaction ID, charge ID, or invoice ID"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="flex gap-3 mt-4">
                <button type="submit" 
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    Apply Filters
                </button>
                <a href="{{ route('admin.payments.index') }}" 
                   class="px-6 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
                    Clear Filters
                </a>
            </div>
        </form>
    </div>

    <!-- Transactions Table -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        @if($transactions->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Transaction</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Agency</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($transactions as $transaction)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">
                                            {{ $transaction->transaction_id ?? 'Pending' }}
                                        </p>
                                        @if($transaction->stripe_invoice_id)
                                            <p class="text-xs text-gray-500">{{ Str::limit($transaction->stripe_invoice_id, 20) }}</p>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-2">
                                            <span class="text-blue-600 text-xs font-semibold">
                                                {{ substr($transaction->agency->agency_name ?? 'N/A', 0, 2) }}
                                            </span>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">
                                                {{ Str::limit($transaction->agency->agency_name ?? 'N/A', 25) }}
                                            </p>
                                            @if($transaction->subscription)
                                                <p class="text-xs text-gray-500">{{ $transaction->subscription->plan->name ?? '' }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="text-sm font-bold {{ $transaction->amount < 0 ? 'text-red-600' : 'text-gray-900' }}">
                                        {{ $transaction->amount < 0 ? '-' : '' }}${{ number_format(abs($transaction->amount), 2) }}
                                    </p>
                                    <p class="text-xs text-gray-500">{{ $transaction->currency }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($transaction->type === 'subscription') bg-blue-100 text-blue-800
                                        @elseif($transaction->type === 'refund') bg-purple-100 text-purple-800
                                        @elseif($transaction->type === 'addon') bg-green-100 text-green-800
                                        @else bg-gray-100 text-gray-800
                                        @endif">
                                        {{ ucfirst($transaction->type) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($transaction->status === 'completed') bg-green-100 text-green-800
                                        @elseif($transaction->status === 'failed') bg-red-100 text-red-800
                                        @elseif($transaction->status === 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($transaction->status === 'refunded') bg-purple-100 text-purple-800
                                        @else bg-gray-100 text-gray-800
                                        @endif">
                                        {{ ucfirst($transaction->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    <div>
                                        <p>{{ $transaction->created_at->format('M d, Y') }}</p>
                                        <p class="text-xs">{{ $transaction->created_at->format('H:i A') }}</p>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex gap-2">
                                        <a href="{{ route('admin.payments.show', $transaction) }}" 
                                           class="text-blue-600 hover:text-blue-900 text-sm font-medium"
                                           title="View Details">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </a>
                                        @if($transaction->status === 'failed')
                                            <form action="{{ route('admin.payments.retry', $transaction) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" 
                                                        class="text-green-600 hover:text-green-900"
                                                        title="Retry Payment"
                                                        onclick="return confirm('Retry this payment?')">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t">
                {{ $transactions->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <p class="mt-2 text-sm text-gray-500">No transactions found</p>
                @if(request()->hasAny(['status', 'type', 'agency_id', 'start_date', 'end_date', 'search']))
                    <a href="{{ route('admin.payments.index') }}" class="mt-2 inline-block text-blue-600 hover:text-blue-800">
                        Clear filters to see all transactions
                    </a>
                @endif
            </div>
        @endif
    </div>
</div>

<script>
function exportTransactions() {
    // Get current filter values
    const form = document.getElementById('filterForm');
    const params = new URLSearchParams(new FormData(form));
    const exportUrl = '{{ route("admin.payments.export") }}?' + params.toString();
    window.location.href = exportUrl;
}
</script>
@endsection