@extends('layouts.admin')

@section('title', 'Tenants Report')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('agency.reports.index') }}" 
               class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-900 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Back to Reports
            </a>
        </div>

        <!-- Header -->
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-plyform-dark">Tenants Report</h1>
                <p class="mt-2 text-gray-600">Monitor tenant lifecycle and statistics</p>
            </div>
            <button onclick="window.print()" class="px-4 py-2 bg-plyform-yellow text-plyform-dark font-semibold rounded-lg hover:bg-plyform-yellow/80 transition inline-flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                </svg>
                Print Report
            </button>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-xs text-gray-600">Total</p>
                    <div class="p-2 bg-blue-100 rounded-lg">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                </div>
                <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['total']) }}</p>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-xs text-gray-600">Active</p>
                    <div class="p-2 bg-green-100 rounded-lg">
                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <p class="text-2xl font-bold text-green-600">{{ number_format($stats['active']) }}</p>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-xs text-gray-600">Pending</p>
                    <div class="p-2 bg-yellow-100 rounded-lg">
                        <svg class="w-4 h-4 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <p class="text-2xl font-bold text-yellow-600">{{ number_format($stats['pending_move_in']) }}</p>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-xs text-gray-600">Notice</p>
                    <div class="p-2 bg-orange-100 rounded-lg">
                        <svg class="w-4 h-4 text-plyform-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                </div>
                <p class="text-2xl font-bold text-plyform-orange">{{ number_format($stats['notice_given']) }}</p>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-xs text-gray-600">Expiring</p>
                    <div class="p-2 bg-purple-100 rounded-lg">
                        <svg class="w-4 h-4 text-plyform-purple" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                </div>
                <p class="text-2xl font-bold text-plyform-purple">{{ number_format($stats['expiring_soon']) }}</p>
                <p class="text-xs text-gray-600 mt-1">within 60 days</p>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-xs text-gray-600">Total Rent</p>
                    <div class="p-2 bg-plyform-mint/50 rounded-lg">
                        <svg class="w-4 h-4 text-plyform-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <p class="text-xl font-bold text-plyform-dark">${{ number_format($stats['total_rent'], 0) }}</p>
                <p class="text-xs text-gray-600 mt-1">per period</p>
            </div>
        </div>

        <!-- Tenants by Status Chart -->
        @if($tenantsByStatus->count() > 0)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
            <h3 class="text-lg font-bold text-plyform-dark mb-4">Tenants by Status</h3>
            <div class="space-y-3">
                @foreach($tenantsByStatus as $status => $count)
                    @php
                        $total = $tenantsByStatus->sum();
                        $percentage = $total > 0 ? ($count / $total) * 100 : 0;
                        $colors = [
                            'pending_move_in' => ['bg' => 'bg-yellow-500', 'text' => 'text-yellow-700'],
                            'active' => ['bg' => 'bg-green-500', 'text' => 'text-green-700'],
                            'notice_given' => ['bg' => 'bg-orange-500', 'text' => 'text-orange-700'],
                            'ending' => ['bg' => 'bg-red-500', 'text' => 'text-red-700'],
                            'ended' => ['bg' => 'bg-gray-500', 'text' => 'text-gray-700'],
                        ];
                        $color = $colors[$status] ?? ['bg' => 'bg-gray-500', 'text' => 'text-gray-700'];
                    @endphp
                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <span class="text-sm {{ $color['text'] }} font-medium">{{ ucfirst(str_replace('_', ' ', $status)) }}</span>
                            <span class="text-sm font-semibold text-gray-900">{{ $count }} ({{ number_format($percentage, 1) }}%)</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-3">
                            <div class="{{ $color['bg'] }} h-3 rounded-full transition-all duration-500" style="width: {{ $percentage }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Filters -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
            <form method="GET" action="{{ route('agency.reports.tenants') }}">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-yellow focus:border-transparent">
                            <option value="">All Status</option>
                            <option value="pending_move_in" {{ request('status') === 'pending_move_in' ? 'selected' : '' }}>Pending Move-In</option>
                            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="notice_given" {{ request('status') === 'notice_given' ? 'selected' : '' }}>Notice Given</option>
                            <option value="ending" {{ request('status') === 'ending' ? 'selected' : '' }}>Ending</option>
                            <option value="ended" {{ request('status') === 'ended' ? 'selected' : '' }}>Ended</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Lease Start From</label>
                        <input type="date" name="date_from" value="{{ request('date_from') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-yellow focus:border-transparent">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Lease Start To</label>
                        <input type="date" name="date_to" value="{{ request('date_to') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-yellow focus:border-transparent">
                    </div>

                    <div class="flex items-end gap-2">
                        <button type="submit" class="flex-1 px-4 py-2 bg-plyform-yellow text-plyform-dark font-semibold rounded-lg hover:bg-plyform-yellow/80 transition">
                            Apply
                        </button>
                        @if(request()->hasAny(['status', 'date_from', 'date_to']))
                            <a href="{{ route('agency.reports.tenants') }}" class="px-4 py-2 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 transition">
                                Clear
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>

        <!-- Tenants List -->
        @if($tenants->count() > 0)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-6">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tenant</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Property</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lease Period</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rent</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($tenants as $tenant)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 bg-gradient-to-br from-plyform-yellow to-plyform-mint rounded-full flex items-center justify-center">
                                                <span class="text-sm font-bold text-plyform-dark">
                                                    {{ strtoupper(substr($tenant->first_name, 0, 1) . substr($tenant->last_name, 0, 1)) }}
                                                </span>
                                            </div>
                                            <div>
                                                <p class="text-sm font-semibold text-plyform-dark">{{ $tenant->full_name }}</p>
                                                <p class="text-xs text-gray-600">{{ $tenant->email }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="text-sm text-gray-900">{{ $tenant->property->headline ?? $tenant->property->short_address }}</p>
                                        <p class="text-xs text-gray-600">{{ $tenant->property->suburb }}</p>
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="text-sm text-gray-900">{{ $tenant->lease_start_date->format('M d, Y') }}</p>
                                        <p class="text-xs text-gray-600">to {{ $tenant->lease_end_date->format('M d, Y') }}</p>
                                    </td>
                                    <td class="px-6 py-4 text-sm font-semibold text-gray-900">
                                        ${{ number_format($tenant->rent_amount, 0) }}
                                        <span class="text-xs text-gray-600 font-normal">{{ $tenant->payment_frequency }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $tenant->status_color }}">
                                            {{ $tenant->status_label }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <a href="{{ route('agency.tenants.show', $tenant) }}" class="text-plyform-purple hover:text-plyform-dark font-medium text-sm">
                                            View
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                {{ $tenants->links() }}
            </div>
        @else
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center">
                <svg class="w-20 h-20 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No tenants found</h3>
                <p class="text-gray-600">Try adjusting your filters.</p>
            </div>
        @endif

    </div>
</div>
@endsection