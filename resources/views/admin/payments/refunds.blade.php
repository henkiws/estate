@extends('layouts.admin')

@section('title', 'Refunded Payments')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <a href="{{ route('admin.payments.index') }}" class="text-blue-600 hover:text-blue-800 mb-2 inline-block">
                ← Back to Payments
            </a>
            <h1 class="text-3xl font-bold text-gray-900">Refunded Payments</h1>
            <p class="text-gray-600 mt-1">View all refunded transactions and refund history</p>
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

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow-sm p-4 border-l-4 border-purple-500">
            <p class="text-sm text-gray-600">Total Refunds</p>
            <p class="text-2xl font-bold text-gray-900">
                {{ number_format($refunds->total()) }}
            </p>
        </div>
        <div class="bg-white rounded-lg shadow-sm p-4 border-l-4 border-red-500">
            <p class="text-sm text-gray-600">Refunded Amount</p>
            <p class="text-2xl font-bold text-red-600">
                ${{ number_format(\App\Models\Transaction::where('status', 'refunded')->sum('amount'), 2) }}
            </p>
        </div>
        <div class="bg-white rounded-lg shadow-sm p-4 border-l-4 border-blue-500">
            <p class="text-sm text-gray-600">This Month</p>
            <p class="text-2xl font-bold text-gray-900">
                {{ number_format(\App\Models\Transaction::where('status', 'refunded')->whereMonth('created_at', now()->month)->count()) }}
            </p>
        </div>
    </div>

    <!-- Refunds Table -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        @if($refunds->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Agency</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount Refunded</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Original Transaction</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Refund Reason</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Refund Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($refunds as $refund)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center mr-3">
                                            <span class="text-purple-600 text-sm font-semibold">
                                                {{ substr($refund->agency->agency_name ?? 'N/A', 0, 2) }}
                                            </span>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">
                                                {{ Str::limit($refund->agency->agency_name ?? 'N/A', 30) }}
                                            </p>
                                            <p class="text-xs text-gray-500">
                                                {{ $refund->agency->business_email ?? 'No email' }}
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div>
                                        <p class="text-sm font-bold text-red-600">
                                            -${{ number_format(abs($refund->amount), 2) }}
                                        </p>
                                        <p class="text-xs text-gray-500">{{ $refund->currency }}</p>
                                        @if($refund->type === 'refund')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-purple-100 text-purple-800 mt-1">
                                                Refund
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @if($refund->stripe_charge_id)
                                        <div>
                                            <p class="text-xs text-gray-600 font-mono">
                                                {{ Str::limit($refund->stripe_charge_id, 20) }}
                                            </p>
                                            @if($refund->subscription && $refund->subscription->plan)
                                                <p class="text-xs text-gray-500 mt-1">
                                                    {{ $refund->subscription->plan->name }}
                                                </p>
                                            @endif
                                        </div>
                                    @else
                                        <span class="text-sm text-gray-400">N/A</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="max-w-xs">
                                        @if($refund->failure_reason || $refund->description)
                                            <div class="bg-purple-50 border border-purple-200 rounded-lg p-2">
                                                <p class="text-xs text-purple-900">
                                                    {{ $refund->failure_reason ?? $refund->description ?? 'No reason provided' }}
                                                </p>
                                            </div>
                                        @else
                                            <span class="text-sm text-gray-400">No reason provided</span>
                                        @endif

                                        @if($refund->payment_method)
                                            <p class="text-xs text-gray-500 mt-2">
                                                Refunded to: {{ ucfirst($refund->payment_method) }}
                                                @if($refund->payment_method_last4)
                                                    (•••• {{ $refund->payment_method_last4 }})
                                                @endif
                                            </p>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div>
                                        <p class="text-sm text-gray-900">
                                            {{ $refund->created_at->format('M d, Y') }}
                                        </p>
                                        <p class="text-xs text-gray-500">
                                            {{ $refund->created_at->format('H:i A') }}
                                        </p>
                                        <p class="text-xs text-purple-600 mt-1">
                                            {{ $refund->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex flex-col gap-2">
                                        <a href="{{ route('admin.payments.show', $refund) }}" 
                                           class="inline-flex items-center px-3 py-1 bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100 transition text-xs font-medium">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            View Details
                                        </a>

                                        <a href="{{ route('admin.agencies.show', $refund->agency) }}" 
                                           class="inline-flex items-center px-3 py-1 bg-purple-50 text-purple-700 rounded-lg hover:bg-purple-100 transition text-xs font-medium">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                            </svg>
                                            View Agency
                                        </a>

                                        @if($refund->stripe_charge_id)
                                            <button onclick="copyToClipboard('{{ $refund->stripe_charge_id }}')" 
                                                    class="inline-flex items-center px-3 py-1 bg-gray-50 text-gray-700 rounded-lg hover:bg-gray-100 transition text-xs font-medium">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                                </svg>
                                                Copy ID
                                            </button>
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
                {{ $refunds->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <p class="mt-2 text-sm font-semibold text-gray-700">No Refunded Payments</p>
                <p class="mt-1 text-sm text-gray-500">There are no refunds in the system</p>
                <a href="{{ route('admin.payments.index') }}" 
                   class="mt-4 inline-block text-blue-600 hover:text-blue-800">
                    View All Transactions
                </a>
            </div>
        @endif
    </div>

    <!-- Refund Policy Information -->
    @if($refunds->count() > 0)
        <div class="mt-6 bg-purple-50 border border-purple-200 rounded-lg p-6">
            <h3 class="text-lg font-bold text-purple-900 mb-3">💰 Refund Policy & Notes</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-purple-800">
                <div>
                    <p class="font-semibold mb-2">Refund Types:</p>
                    <ul class="space-y-1 ml-4">
                        <li>• Full refund - 100% amount returned</li>
                        <li>• Partial refund - Portion of payment returned</li>
                        <li>• Pro-rated refund - Based on usage period</li>
                        <li>• Service credit - Applied to future payments</li>
                    </ul>
                </div>
                <div>
                    <p class="font-semibold mb-2">Processing Information:</p>
                    <ul class="space-y-1 ml-4">
                        <li>• Refunds are processed through Stripe</li>
                        <li>• Typically takes 5-10 business days</li>
                        <li>• Returns to original payment method</li>
                        <li>• Agency retains access until period end</li>
                        <li>• Negative transactions are refund records</li>
                    </ul>
                </div>
            </div>
            
            <div class="mt-4 pt-4 border-t border-purple-300">
                <p class="text-sm text-purple-900">
                    <strong>Note:</strong> All refunds are logged with timestamps and reasons. Original transaction IDs are preserved for reconciliation.
                    Contact support if you need to dispute or review any refund.
                </p>
            </div>
        </div>
    @endif
</div>

<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        alert('Transaction ID copied to clipboard!');
    });
}
</script>
@endsection