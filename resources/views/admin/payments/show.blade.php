@extends('layouts.admin')

@section('title', 'Transaction Details')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <a href="{{ route('admin.payments.index') }}" class="text-blue-600 hover:text-blue-800 mb-2 inline-block">
                ← Back to Transactions
            </a>
            <h1 class="text-3xl font-bold text-gray-900">Transaction Details</h1>
            <p class="text-gray-600 mt-1">{{ $transaction->transaction_id ?? 'Pending Transaction' }}</p>
        </div>
        <div>
            <span class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-medium
                @if($transaction->status === 'completed') bg-green-100 text-green-800
                @elseif($transaction->status === 'failed') bg-red-100 text-red-800
                @elseif($transaction->status === 'pending') bg-yellow-100 text-yellow-800
                @elseif($transaction->status === 'refunded') bg-purple-100 text-purple-800
                @else bg-gray-100 text-gray-800
                @endif">
                {{ ucfirst($transaction->status) }}
            </span>
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

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Transaction Information -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Transaction Information</h2>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-600">Transaction ID</p>
                        <p class="font-semibold">{{ $transaction->transaction_id ?? 'Pending' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Amount</p>
                        <p class="font-bold text-2xl {{ $transaction->amount < 0 ? 'text-red-600' : 'text-green-600' }}">
                            {{ $transaction->amount < 0 ? '-' : '' }}${{ number_format(abs($transaction->amount), 2) }}
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Currency</p>
                        <p class="font-semibold">{{ $transaction->currency }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Type</p>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            @if($transaction->type === 'subscription') bg-blue-100 text-blue-800
                            @elseif($transaction->type === 'refund') bg-purple-100 text-purple-800
                            @elseif($transaction->type === 'addon') bg-green-100 text-green-800
                            @else bg-gray-100 text-gray-800
                            @endif">
                            {{ ucfirst($transaction->type) }}
                        </span>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Payment Method</p>
                        <p class="font-semibold">
                            {{ ucfirst($transaction->payment_method ?? 'N/A') }}
                            @if($transaction->payment_method_last4)
                                (•••• {{ $transaction->payment_method_last4 }})
                            @endif
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Date & Time</p>
                        <p class="font-semibold">{{ $transaction->created_at->format('M d, Y H:i A') }}</p>
                    </div>
                </div>

                @if($transaction->description)
                    <div class="mt-4 pt-4 border-t">
                        <p class="text-sm text-gray-600 mb-1">Description</p>
                        <p class="text-gray-900">{{ $transaction->description }}</p>
                    </div>
                @endif

                @if($transaction->failure_reason)
                    <div class="mt-4 pt-4 border-t">
                        <p class="text-sm text-gray-600 mb-1">Failure Reason</p>
                        <div class="bg-red-50 border border-red-200 rounded-lg p-3">
                            <p class="text-red-800">{{ $transaction->failure_reason }}</p>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Stripe Information -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Stripe Information</h2>
                
                <div class="space-y-3">
                    @if($transaction->stripe_charge_id)
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Charge ID</p>
                            <div class="flex items-center justify-between bg-gray-50 px-3 py-2 rounded">
                                <code class="text-sm">{{ $transaction->stripe_charge_id }}</code>
                                <button onclick="copyToClipboard('{{ $transaction->stripe_charge_id }}')" 
                                        class="text-blue-600 hover:text-blue-800 text-sm">
                                    Copy
                                </button>
                            </div>
                        </div>
                    @endif

                    @if($transaction->stripe_invoice_id)
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Invoice ID</p>
                            <div class="flex items-center justify-between bg-gray-50 px-3 py-2 rounded">
                                <code class="text-sm">{{ $transaction->stripe_invoice_id }}</code>
                                <button onclick="copyToClipboard('{{ $transaction->stripe_invoice_id }}')" 
                                        class="text-blue-600 hover:text-blue-800 text-sm">
                                    Copy
                                </button>
                            </div>
                        </div>
                    @endif

                    @if($transaction->stripe_response)
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Stripe Response</p>
                            <details class="bg-gray-50 rounded-lg p-3">
                                <summary class="cursor-pointer text-sm font-medium text-gray-700">View JSON Response</summary>
                                <pre class="mt-2 text-xs overflow-x-auto">{{ json_encode($transaction->stripe_response, JSON_PRETTY_PRINT) }}</pre>
                            </details>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Agency Information -->
            @if($transaction->agency)
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">Agency Information</h2>
                    
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                            <span class="text-blue-600 font-semibold">
                                {{ substr($transaction->agency->agency_name, 0, 2) }}
                            </span>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900">{{ $transaction->agency->agency_name }}</p>
                            <p class="text-sm text-gray-500">{{ $transaction->agency->business_email }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 pt-4 border-t">
                        <div>
                            <p class="text-sm text-gray-600">License Number</p>
                            <p class="font-medium">{{ $transaction->agency->license_number }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">ABN</p>
                            <p class="font-medium">{{ $transaction->agency->abn }}</p>
                        </div>
                    </div>

                    <a href="{{ route('admin.agencies.show', $transaction->agency) }}" 
                       class="mt-4 block text-center px-4 py-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition">
                        View Agency Profile
                    </a>
                </div>
            @endif

            <!-- Subscription Information -->
            @if($transaction->subscription)
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">Subscription Information</h2>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600">Plan</p>
                            <p class="font-semibold">{{ $transaction->subscription->plan->name ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Status</p>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                @if($transaction->subscription->status === 'active') bg-green-100 text-green-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                {{ ucfirst($transaction->subscription->status) }}
                            </span>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Current Period</p>
                            <p class="font-medium text-sm">
                                {{ $transaction->subscription->current_period_start?->format('M d, Y') }} - 
                                {{ $transaction->subscription->current_period_end?->format('M d, Y') }}
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Stripe Subscription ID</p>
                            <p class="font-medium text-xs">{{ Str::limit($transaction->subscription->stripe_subscription_id, 20) }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Metadata -->
            @if($transaction->metadata)
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">Additional Metadata</h2>
                    <pre class="bg-gray-50 p-4 rounded text-xs overflow-x-auto">{{ json_encode($transaction->metadata, JSON_PRETTY_PRINT) }}</pre>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Quick Actions -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Quick Actions</h3>
                
                <div class="space-y-2">
                    @if($transaction->status === 'completed' && !$transaction->isRefunded())
                        <button onclick="document.getElementById('refundModal').classList.remove('hidden')" 
                                class="w-full px-4 py-2 bg-purple-50 text-purple-600 rounded-lg hover:bg-purple-100 transition text-sm">
                            💰 Process Refund
                        </button>
                    @endif

                    @if($transaction->status === 'failed')
                        <form action="{{ route('admin.payments.retry', $transaction) }}" method="POST">
                            @csrf
                            <button type="submit" 
                                    onclick="return confirm('Retry this payment?')"
                                    class="w-full px-4 py-2 bg-green-50 text-green-600 rounded-lg hover:bg-green-100 transition text-sm">
                                🔄 Retry Payment
                            </button>
                        </form>
                    @endif

                    <a href="{{ route('admin.payments.index') }}" 
                       class="block w-full px-4 py-2 bg-gray-50 text-gray-600 rounded-lg hover:bg-gray-100 transition text-sm text-center">
                        Back to Transactions
                    </a>
                </div>
            </div>

            <!-- Transaction Summary -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Summary</h3>
                
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Created:</span>
                        <span class="font-medium">{{ $transaction->created_at->diffForHumans() }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Updated:</span>
                        <span class="font-medium">{{ $transaction->updated_at->diffForHumans() }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Transaction ID:</span>
                        <span class="font-medium">#{{ $transaction->id }}</span>
                    </div>
                </div>
            </div>

            <!-- Status Timeline -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Status History</h3>
                
                <div class="space-y-3">
                    <div class="flex items-start">
                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <span class="text-blue-600 text-xs">1</span>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium">Transaction Created</p>
                            <p class="text-xs text-gray-500">{{ $transaction->created_at->format('M d, Y H:i A') }}</p>
                        </div>
                    </div>

                    @if($transaction->status === 'completed')
                        <div class="flex items-start">
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <span class="text-green-600 text-xs">✓</span>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium">Payment Completed</p>
                                <p class="text-xs text-gray-500">{{ $transaction->updated_at->format('M d, Y H:i A') }}</p>
                            </div>
                        </div>
                    @elseif($transaction->status === 'failed')
                        <div class="flex items-start">
                            <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <span class="text-red-600 text-xs">✗</span>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium">Payment Failed</p>
                                <p class="text-xs text-gray-500">{{ $transaction->updated_at->format('M d, Y H:i A') }}</p>
                            </div>
                        </div>
                    @elseif($transaction->status === 'refunded')
                        <div class="flex items-start">
                            <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <span class="text-purple-600 text-xs">↩</span>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium">Payment Refunded</p>
                                <p class="text-xs text-gray-500">{{ $transaction->updated_at->format('M d, Y H:i A') }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Refund Modal -->
<div id="refundModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Process Refund</h3>
            
            <form action="{{ route('admin.payments.process-refund', $transaction) }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Refund Amount</label>
                    <input type="number" 
                           name="amount" 
                           step="0.01"
                           max="{{ $transaction->amount }}"
                           value="{{ $transaction->amount }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                           required>
                    <p class="text-xs text-gray-500 mt-1">Maximum: ${{ number_format($transaction->amount, 2) }}</p>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Reason for Refund</label>
                    <textarea name="reason" 
                              rows="3"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                              placeholder="Enter reason for refund..."
                              required></textarea>
                </div>

                <div class="flex gap-3">
                    <button type="submit" 
                            class="flex-1 px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">
                        Process Refund
                    </button>
                    <button type="button" 
                            onclick="document.getElementById('refundModal').classList.add('hidden')"
                            class="flex-1 px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        alert('Copied to clipboard!');
    });
}
</script>
@endsection