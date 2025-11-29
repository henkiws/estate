@extends('layouts.admin')

@section('title', 'Failed Payments')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <a href="{{ route('admin.payments.index') }}" class="text-blue-600 hover:text-blue-800 mb-2 inline-block">
                ← Back to Payments
            </a>
            <h1 class="text-3xl font-bold text-gray-900">Failed Payments</h1>
            <p class="text-gray-600 mt-1">Review and retry failed payment transactions</p>
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

    <!-- Alert Banner -->
    @if($failedTransactions->count() > 0)
        <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
            <div class="flex">
                <svg class="w-5 h-5 text-red-600 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
                <div>
                    <p class="font-semibold text-red-800">{{ $failedTransactions->count() }} Failed Payment(s) Require Attention</p>
                    <p class="text-sm text-red-700 mt-1">Review the failure reasons and retry payments or contact agencies as needed.</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Failed Transactions Table -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        @if($failedTransactions->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Agency</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Plan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Failure Reason</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Failed Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($failedTransactions as $transaction)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center mr-3">
                                            <span class="text-red-600 text-sm font-semibold">
                                                {{ substr($transaction->agency->agency_name ?? 'N/A', 0, 2) }}
                                            </span>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">
                                                {{ Str::limit($transaction->agency->agency_name ?? 'N/A', 30) }}
                                            </p>
                                            <p class="text-xs text-gray-500">
                                                {{ $transaction->agency->business_email ?? 'No email' }}
                                            </p>
                                            @if($transaction->agency->business_phone)
                                                <p class="text-xs text-gray-500">
                                                    📞 {{ $transaction->agency->business_phone }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <p class="text-sm font-bold text-red-600">
                                        ${{ number_format($transaction->amount, 2) }}
                                    </p>
                                    <p class="text-xs text-gray-500">{{ $transaction->currency }}</p>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($transaction->subscription && $transaction->subscription->plan)
                                        <p class="text-sm font-medium text-gray-900">
                                            {{ $transaction->subscription->plan->name }}
                                        </p>
                                        <p class="text-xs text-gray-500">
                                            ${{ number_format($transaction->subscription->plan->price, 2) }}/mo
                                        </p>
                                    @else
                                        <span class="text-sm text-gray-400">N/A</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="max-w-xs">
                                        @if($transaction->failure_reason)
                                            <div class="bg-red-50 border border-red-200 rounded-lg p-2">
                                                <p class="text-xs text-red-800 font-medium">
                                                    {{ $transaction->failure_reason }}
                                                </p>
                                            </div>
                                        @else
                                            <span class="text-sm text-gray-400">No reason provided</span>
                                        @endif
                                        
                                        @if($transaction->payment_method)
                                            <p class="text-xs text-gray-500 mt-1">
                                                Payment method: {{ ucfirst($transaction->payment_method) }}
                                                @if($transaction->payment_method_last4)
                                                    (•••• {{ $transaction->payment_method_last4 }})
                                                @endif
                                            </p>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <p class="text-sm text-gray-900">
                                        {{ $transaction->created_at->format('M d, Y') }}
                                    </p>
                                    <p class="text-xs text-gray-500">
                                        {{ $transaction->created_at->format('H:i A') }}
                                    </p>
                                    <p class="text-xs text-red-600 mt-1">
                                        {{ $transaction->created_at->diffForHumans() }}
                                    </p>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex flex-col gap-2">
                                        <a href="{{ route('admin.payments.show', $transaction) }}" 
                                           class="inline-flex items-center px-3 py-1 bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100 transition text-xs font-medium">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            View
                                        </a>

                                        <form action="{{ route('admin.payments.retry', $transaction) }}" 
                                              method="POST" 
                                              onsubmit="return confirm('Retry this payment? The customer will be notified.');">
                                            @csrf
                                            <button type="submit" 
                                                    class="w-full inline-flex items-center px-3 py-1 bg-green-50 text-green-700 rounded-lg hover:bg-green-100 transition text-xs font-medium">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                                </svg>
                                                Retry
                                            </button>
                                        </form>

                                        <a href="{{ route('admin.agencies.show', $transaction->agency) }}" 
                                           class="inline-flex items-center px-3 py-1 bg-purple-50 text-purple-700 rounded-lg hover:bg-purple-100 transition text-xs font-medium">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                            </svg>
                                            Agency
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t">
                {{ $failedTransactions->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p class="mt-2 text-sm font-semibold text-gray-700">No Failed Payments</p>
                <p class="mt-1 text-sm text-gray-500">All payments are processing successfully!</p>
                <a href="{{ route('admin.payments.index') }}" 
                   class="mt-4 inline-block text-blue-600 hover:text-blue-800">
                    View All Transactions
                </a>
            </div>
        @endif
    </div>

    <!-- Help Section -->
    @if($failedTransactions->count() > 0)
        <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-6">
            <h3 class="text-lg font-bold text-blue-900 mb-3">💡 Handling Failed Payments</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-blue-800">
                <div>
                    <p class="font-semibold mb-2">Common Failure Reasons:</p>
                    <ul class="space-y-1 ml-4">
                        <li>• Insufficient funds</li>
                        <li>• Expired card</li>
                        <li>• Card declined by bank</li>
                        <li>• Invalid payment method</li>
                        <li>• Authentication required</li>
                    </ul>
                </div>
                <div>
                    <p class="font-semibold mb-2">Recommended Actions:</p>
                    <ul class="space-y-1 ml-4">
                        <li>• Contact agency to update payment method</li>
                        <li>• Verify billing information is correct</li>
                        <li>• Check for fraud alerts on the card</li>
                        <li>• Retry payment after agency confirms update</li>
                        <li>• Consider suspending services if unresolved</li>
                    </ul>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection