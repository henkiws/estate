@extends('layouts.admin')

@section('title', 'Financial Report')

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
                <h1 class="text-3xl font-bold text-plyform-dark">Financial Report</h1>
                <p class="mt-2 text-gray-600">Income overview and bond management</p>
            </div>
            <button onclick="window.print()" class="px-4 py-2 bg-plyform-yellow text-plyform-dark font-semibold rounded-lg hover:bg-plyform-yellow/80 transition inline-flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                </svg>
                Print Report
            </button>
        </div>

        <!-- Date Range Filter -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
            <form method="GET" action="{{ route('agency.reports.financial') }}">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Date From</label>
                        <input type="date" name="date_from" value="{{ $dateFrom }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-yellow focus:border-transparent">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Date To</label>
                        <input type="date" name="date_to" value="{{ $dateTo }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-yellow focus:border-transparent">
                    </div>

                    <div class="flex items-end">
                        <button type="submit" class="w-full px-4 py-2 bg-plyform-yellow text-plyform-dark font-semibold rounded-lg hover:bg-plyform-yellow/80 transition">
                            Apply Filter
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Key Financial Metrics -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
            <!-- Expected Monthly Income -->
            <div class="bg-gradient-to-br from-plyform-yellow to-plyform-mint rounded-xl shadow-sm p-6 text-plyform-dark col-span-2">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-white/30 backdrop-blur rounded-lg">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <p class="text-sm opacity-90 mb-2">Expected Monthly Income</p>
                <p class="text-4xl font-bold">${{ number_format($stats['expected_monthly_income'], 2) }}</p>
                <p class="text-sm opacity-75 mt-2">From {{ $stats['active_tenants_count'] }} active tenants</p>
            </div>

            <!-- Active Tenants -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-green-100 rounded-lg">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                </div>
                <p class="text-xs text-gray-600 mb-2">Active Tenants</p>
                <p class="text-3xl font-bold text-gray-900">{{ $stats['active_tenants_count'] }}</p>
            </div>

            <!-- Properties Rented -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-blue-100 rounded-lg">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                    </div>
                </div>
                <p class="text-xs text-gray-600 mb-2">Rented Properties</p>
                <p class="text-3xl font-bold text-gray-900">{{ $stats['total_properties_rented'] }}</p>
            </div>

            <!-- Vacancy Rate -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 {{ $stats['vacancy_rate'] > 20 ? 'bg-red-100' : 'bg-teal-100' }} rounded-lg">
                        <svg class="w-6 h-6 {{ $stats['vacancy_rate'] > 20 ? 'text-red-600' : 'text-teal-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                </div>
                <p class="text-xs text-gray-600 mb-2">Vacancy Rate</p>
                <p class="text-3xl font-bold {{ $stats['vacancy_rate'] > 20 ? 'text-red-600' : 'text-teal-600' }}">{{ number_format($stats['vacancy_rate'], 1) }}%</p>
            </div>
        </div>

        <!-- Bond Management Section -->
        <div class="grid lg:grid-cols-2 gap-6 mb-8">
            <!-- Bond Statistics -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-plyform-dark mb-6 flex items-center gap-2">
                    <svg class="w-6 h-6 text-plyform-purple" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                    Bond Management
                </h3>

                <div class="space-y-4">
                    <div class="p-4 bg-blue-50 rounded-lg">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm text-gray-600">Total Bonds Held</span>
                            <span class="text-2xl font-bold text-blue-600">${{ number_format($bondStats['total_bonds'], 2) }}</span>
                        </div>
                        <div class="w-full bg-blue-200 rounded-full h-2">
                            <div class="bg-blue-600 h-2 rounded-full" style="width: 100%"></div>
                        </div>
                    </div>

                    <div class="p-4 bg-green-50 rounded-lg">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm text-gray-600">Bonds Paid</span>
                            <span class="text-2xl font-bold text-green-600">${{ number_format($bondStats['bonds_paid'], 2) }}</span>
                        </div>
                        @php
                            $paidPercentage = $bondStats['total_bonds'] > 0 ? ($bondStats['bonds_paid'] / $bondStats['total_bonds']) * 100 : 0;
                        @endphp
                        <div class="w-full bg-green-200 rounded-full h-2">
                            <div class="bg-green-600 h-2 rounded-full" style="width: {{ $paidPercentage }}%"></div>
                        </div>
                        <p class="text-xs text-gray-600 mt-1">{{ number_format($paidPercentage, 1) }}% collected</p>
                    </div>

                    <div class="p-4 bg-orange-50 rounded-lg">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm text-gray-600">Bonds Unpaid</span>
                            <span class="text-2xl font-bold text-plyform-orange">${{ number_format($bondStats['bonds_unpaid'], 2) }}</span>
                        </div>
                        @php
                            $unpaidPercentage = $bondStats['total_bonds'] > 0 ? ($bondStats['bonds_unpaid'] / $bondStats['total_bonds']) * 100 : 0;
                        @endphp
                        <div class="w-full bg-orange-200 rounded-full h-2">
                            <div class="bg-plyform-orange h-2 rounded-full" style="width: {{ $unpaidPercentage }}%"></div>
                        </div>
                        <p class="text-xs text-gray-600 mt-1">{{ number_format($unpaidPercentage, 1) }}% outstanding</p>
                    </div>
                </div>
            </div>

            <!-- Average Rent -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-plyform-dark mb-6 flex items-center gap-2">
                    <svg class="w-6 h-6 text-plyform-purple" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                    </svg>
                    Rent Analysis
                </h3>

                <div class="mb-6">
                    <p class="text-sm text-gray-600 mb-2">Average Rent per Property</p>
                    <p class="text-4xl font-bold text-plyform-dark">${{ number_format($stats['avg_rent_per_property'], 2) }}</p>
                    <p class="text-sm text-gray-600 mt-1">Per payment period</p>
                </div>

                <div class="space-y-3">
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <span class="text-sm text-gray-600">Active Tenants</span>
                        <span class="text-sm font-semibold text-gray-900">{{ $stats['active_tenants_count'] }}</span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <span class="text-sm text-gray-600">Total Monthly Income</span>
                        <span class="text-sm font-semibold text-green-600">${{ number_format($stats['expected_monthly_income'], 2) }}</span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <span class="text-sm text-gray-600">Properties Rented</span>
                        <span class="text-sm font-semibold text-gray-900">{{ $stats['total_properties_rented'] }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top 10 Income by Property -->
        @if($incomeByProperty->count() > 0)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-bold text-plyform-dark mb-6 flex items-center gap-2">
                <svg class="w-6 h-6 text-plyform-purple" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                </svg>
                Top 10 Properties by Monthly Rent
            </h3>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Property</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tenant</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Payment Frequency</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Monthly Income</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($incomeByProperty as $index => $item)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $index + 1 }}</td>
                                <td class="px-6 py-4">
                                    <p class="text-sm font-semibold text-plyform-dark">{{ $item['property'] }}</p>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $item['tenant'] }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-700">
                                        {{ ucfirst($item['payment_frequency']) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <span class="text-lg font-bold text-green-600">${{ number_format($item['rent'], 2) }}</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gray-50">
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-right text-sm font-semibold text-gray-900">Total from Top 10:</td>
                            <td class="px-6 py-4 text-right text-lg font-bold text-plyform-dark">
                                ${{ number_format($incomeByProperty->sum('rent'), 2) }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        @else
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center">
                <svg class="w-20 h-20 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No active tenants</h3>
                <p class="text-gray-600">Start by approving rental applications to generate income.</p>
            </div>
        @endif

    </div>
</div>
@endsection