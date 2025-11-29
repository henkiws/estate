@extends('layouts.admin')

@section('title', 'Subscription Management')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <a href="{{ route('admin.payments.index') }}" class="text-blue-600 hover:text-blue-800 mb-2 inline-block">
                ← Back to Payments
            </a>
            <h1 class="text-3xl font-bold text-gray-900">Subscription Management</h1>
            <p class="text-gray-600 mt-1">View and manage all agency subscriptions</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.payments.statistics') }}" 
               class="inline-flex items-center px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
                Statistics
            </a>
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
            <p class="text-sm text-gray-600">Active Subscriptions</p>
            <p class="text-2xl font-bold text-gray-900">
                {{ number_format(\App\Models\Subscription::where('status', 'active')->count()) }}
            </p>
        </div>
        <div class="bg-white rounded-lg shadow-sm p-4 border-l-4 border-yellow-500">
            <p class="text-sm text-gray-600">Trialing</p>
            <p class="text-2xl font-bold text-gray-900">
                {{ number_format(\App\Models\Subscription::where('status', 'trialing')->count()) }}
            </p>
        </div>
        <div class="bg-white rounded-lg shadow-sm p-4 border-l-4 border-red-500">
            <p class="text-sm text-gray-600">Past Due</p>
            <p class="text-2xl font-bold text-gray-900">
                {{ number_format(\App\Models\Subscription::where('status', 'past_due')->count()) }}
            </p>
        </div>
        <div class="bg-white rounded-lg shadow-sm p-4 border-l-4 border-gray-500">
            <p class="text-sm text-gray-600">Cancelled</p>
            <p class="text-2xl font-bold text-gray-900">
                {{ number_format(\App\Models\Subscription::where('status', 'cancelled')->count()) }}
            </p>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <form method="GET" action="{{ route('admin.payments.subscriptions') }}" id="filterForm">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Status Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="trialing" {{ request('status') == 'trialing' ? 'selected' : '' }}>Trialing</option>
                        <option value="past_due" {{ request('status') == 'past_due' ? 'selected' : '' }}>Past Due</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Expired</option>
                    </select>
                </div>

                <!-- Plan Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Plan</label>
                    <select name="plan_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        <option value="">All Plans</option>
                        @foreach($plans as $plan)
                            <option value="{{ $plan->id }}" {{ request('plan_id') == $plan->id ? 'selected' : '' }}>
                                {{ $plan->name }} - ${{ number_format($plan->price, 2) }}
                            </option>
                        @endforeach
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
            </div>

            <div class="flex gap-3 mt-4">
                <button type="submit" 
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    Apply Filters
                </button>
                <a href="{{ route('admin.payments.subscriptions') }}" 
                   class="px-6 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
                    Clear Filters
                </a>
            </div>
        </form>
    </div>

    <!-- Subscriptions Table -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        @if($subscriptions->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Agency</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Plan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Current Period</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Renewal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stripe ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($subscriptions as $subscription)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                            <span class="text-blue-600 text-sm font-semibold">
                                                {{ substr($subscription->agency->agency_name ?? 'N/A', 0, 2) }}
                                            </span>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">
                                                {{ Str::limit($subscription->agency->agency_name ?? 'N/A', 30) }}
                                            </p>
                                            <p class="text-xs text-gray-500">
                                                {{ $subscription->agency->business_email ?? '' }}
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div>
                                        <p class="text-sm font-semibold text-gray-900">
                                            {{ $subscription->plan->name ?? 'N/A' }}
                                        </p>
                                        <p class="text-xs text-gray-500">
                                            ${{ number_format($subscription->plan->price ?? 0, 2) }}/month
                                        </p>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($subscription->status === 'active') bg-green-100 text-green-800
                                        @elseif($subscription->status === 'trialing') bg-blue-100 text-blue-800
                                        @elseif($subscription->status === 'past_due') bg-red-100 text-red-800
                                        @elseif($subscription->status === 'cancelled') bg-gray-100 text-gray-800
                                        @elseif($subscription->status === 'expired') bg-yellow-100 text-yellow-800
                                        @else bg-gray-100 text-gray-800
                                        @endif">
                                        {{ ucfirst($subscription->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900">
                                    @if($subscription->current_period_start && $subscription->current_period_end)
                                        <div>
                                            <p>{{ $subscription->current_period_start->format('M d, Y') }}</p>
                                            <p class="text-xs text-gray-500">to {{ $subscription->current_period_end->format('M d, Y') }}</p>
                                        </div>
                                    @else
                                        <span class="text-gray-400">N/A</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if($subscription->status === 'active' && $subscription->current_period_end)
                                        @php
                                            $daysUntilRenewal = $subscription->daysUntilRenewal();
                                        @endphp
                                        <div>
                                            <p class="text-sm font-medium {{ $daysUntilRenewal < 7 ? 'text-red-600' : 'text-gray-900' }}">
                                                @if($daysUntilRenewal > 0)
                                                    {{ $daysUntilRenewal }} days
                                                @elseif($daysUntilRenewal == 0)
                                                    Today
                                                @else
                                                    {{ abs($daysUntilRenewal) }} days overdue
                                                @endif
                                            </p>
                                            <p class="text-xs text-gray-500">
                                                {{ $subscription->current_period_end->format('M d') }}
                                            </p>
                                        </div>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if($subscription->stripe_subscription_id)
                                        <div class="flex items-center gap-2">
                                            <code class="text-xs text-gray-600">
                                                {{ Str::limit($subscription->stripe_subscription_id, 12) }}
                                            </code>
                                            <button onclick="copyToClipboard('{{ $subscription->stripe_subscription_id }}')" 
                                                    class="text-blue-600 hover:text-blue-800"
                                                    title="Copy">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    @else
                                        <span class="text-gray-400">N/A</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex gap-2">
                                        <a href="{{ route('admin.agencies.show', $subscription->agency) }}" 
                                           class="text-blue-600 hover:text-blue-900"
                                           title="View Agency">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </a>
                                        
                                        @if($subscription->status === 'active')
                                            <button onclick="confirmCancel({{ $subscription->id }}, '{{ $subscription->agency->agency_name }}')" 
                                                    class="text-red-600 hover:text-red-900"
                                                    title="Cancel Subscription">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
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
                {{ $subscriptions->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <p class="mt-2 text-sm text-gray-500">No subscriptions found</p>
                @if(request()->hasAny(['status', 'plan_id', 'agency_id']))
                    <a href="{{ route('admin.payments.subscriptions') }}" class="mt-2 inline-block text-blue-600 hover:text-blue-800">
                        Clear filters to see all subscriptions
                    </a>
                @endif
            </div>
        @endif
    </div>
</div>

<!-- Cancel Confirmation Modal -->
<div id="cancelModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Cancel Subscription</h3>
            
            <p class="text-sm text-gray-600 mb-4">
                Are you sure you want to cancel the subscription for <strong id="agencyName"></strong>?
            </p>
            
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3 mb-4">
                <p class="text-sm text-yellow-800">
                    ⚠️ The subscription will be cancelled immediately, but the agency will retain access until the end of their current billing period.
                </p>
            </div>

            <form id="cancelForm" method="POST">
                @csrf
                <div class="flex gap-3">
                    <button type="submit" 
                            class="flex-1 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                        Cancel Subscription
                    </button>
                    <button type="button" 
                            onclick="document.getElementById('cancelModal').classList.add('hidden')"
                            class="flex-1 px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                        Close
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

function confirmCancel(subscriptionId, agencyName) {
    document.getElementById('agencyName').textContent = agencyName;
    document.getElementById('cancelForm').action = '/admin/payments/subscriptions/' + subscriptionId + '/cancel';
    document.getElementById('cancelModal').classList.remove('hidden');
}
</script>
@endsection