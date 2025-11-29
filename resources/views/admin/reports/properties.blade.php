@extends('layouts.admin')

@section('title', 'Properties Report')

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
                <h1 class="text-3xl font-bold text-gray-900">Properties Report</h1>
            </div>
            <p class="text-gray-600">Listing analytics, property types, and market trends</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.reports.export', ['type' => 'properties', 'start_date' => $startDate, 'end_date' => $endDate]) }}" 
               class="flex items-center gap-2 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-medium">
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
        <form method="GET" action="{{ route('admin.reports.properties') }}" class="flex flex-wrap items-center gap-4">
            <label class="text-sm font-medium text-gray-700">Date Range:</label>
            <input type="date" name="start_date" value="{{ $startDate }}" 
                   class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
            <span class="text-gray-500">to</span>
            <input type="date" name="end_date" value="{{ $endDate }}" 
                   class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
            <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-medium">
                Apply Filter
            </button>
            <a href="{{ route('admin.reports.properties') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition font-medium">
                Reset
            </a>
        </form>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 xl:grid-cols-7 gap-4 mb-8">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
            <div class="text-sm text-gray-600 mb-1">Total Properties</div>
            <div class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_properties']) }}</div>
        </div>
        <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
            <div class="text-sm text-blue-700 mb-1">For Sale</div>
            <div class="text-2xl font-bold text-blue-900">{{ number_format($stats['for_sale']) }}</div>
        </div>
        <div class="bg-purple-50 border border-purple-200 rounded-xl p-4">
            <div class="text-sm text-purple-700 mb-1">For Rent</div>
            <div class="text-2xl font-bold text-purple-900">{{ number_format($stats['for_rent']) }}</div>
        </div>
        <div class="bg-indigo-50 border border-indigo-200 rounded-xl p-4">
            <div class="text-sm text-indigo-700 mb-1">Both</div>
            <div class="text-2xl font-bold text-indigo-900">{{ number_format($stats['both']) }}</div>
        </div>
        <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4">
            <div class="text-sm text-yellow-700 mb-1">Featured</div>
            <div class="text-2xl font-bold text-yellow-900">{{ number_format($stats['featured']) }}</div>
        </div>
        <div class="bg-green-50 border border-green-200 rounded-xl p-4">
            <div class="text-sm text-green-700 mb-1">Verified</div>
            <div class="text-2xl font-bold text-green-900">{{ number_format($stats['verified']) }}</div>
        </div>
        <div class="bg-orange-50 border border-orange-200 rounded-xl p-4">
            <div class="text-sm text-orange-700 mb-1">New This Month</div>
            <div class="text-2xl font-bold text-orange-900">{{ number_format($stats['new_this_month']) }}</div>
        </div>
    </div>

    <!-- Average Prices Card -->
    <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white mb-8">
        <h2 class="text-xl font-bold mb-4">Average Prices</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <div class="text-sm text-green-100 mb-2">Average Sale Price</div>
                <div class="text-3xl font-bold">${{ number_format($averagePrices['sale'] ?? 0, 2) }}</div>
            </div>
            <div>
                <div class="text-sm text-green-100 mb-2">Average Monthly Rent</div>
                <div class="text-3xl font-bold">${{ number_format($averagePrices['rent'] ?? 0, 2) }}</div>
            </div>
        </div>
    </div>

    <!-- Charts Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Property Types Distribution -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-bold text-gray-900 mb-4">Property Types Distribution</h2>
            @if($propertiesByType->count() > 0)
                <div class="space-y-3">
                    @php $maxCount = $propertiesByType->first()->count; @endphp
                    @foreach($propertiesByType as $index => $type)
                        @php
                            $colors = ['from-blue-500 to-blue-600', 'from-purple-500 to-purple-600', 
                                      'from-green-500 to-green-600', 'from-orange-500 to-orange-600',
                                      'from-pink-500 to-pink-600', 'from-indigo-500 to-indigo-600'];
                            $color = $colors[$index % count($colors)];
                        @endphp
                        <div>
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-sm font-medium text-gray-700">{{ ucfirst($type->property_type) }}</span>
                                <span class="text-sm font-bold text-green-600">{{ $type->count }} ({{ number_format(($type->count / $stats['total_properties']) * 100, 1) }}%)</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-3">
                                <div class="bg-gradient-to-r {{ $color }} h-3 rounded-full transition-all" 
                                     style="width: {{ ($type->count / $maxCount) * 100 }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-8">No data available</p>
            @endif
        </div>

        <!-- Geographic Distribution -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-bold text-gray-900 mb-4">Geographic Distribution</h2>
            @if($propertiesByState->count() > 0)
                <div class="space-y-3">
                    @php $maxState = $propertiesByState->first()->count; @endphp
                    @foreach($propertiesByState as $state)
                        <div>
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-sm font-medium text-gray-700">{{ $state->state }}</span>
                                <span class="text-sm font-bold text-green-600">{{ $state->count }}</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-3">
                                <div class="bg-gradient-to-r from-green-500 to-green-600 h-3 rounded-full transition-all" 
                                     style="width: {{ ($state->count / $maxState) * 100 }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-8">No data available</p>
            @endif
        </div>
    </div>

    <!-- Listing Trend -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
        <h2 class="text-lg font-bold text-gray-900 mb-4">Listing Trend (Last 12 Months)</h2>
        @if($listingTrend->count() > 0)
            <div class="space-y-3">
                @php $maxListing = $listingTrend->max('count') ?: 1; @endphp
                @foreach($listingTrend as $trend)
                    <div>
                        <div class="flex justify-between items-center mb-1">
                            <span class="text-sm font-medium text-gray-700">{{ \Carbon\Carbon::parse($trend->month . '-01')->format('M Y') }}</span>
                            <span class="text-sm font-bold text-green-600">{{ $trend->count }} new listings</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-3">
                            <div class="bg-gradient-to-r from-blue-500 to-green-500 h-3 rounded-full transition-all" 
                                 style="width: {{ ($trend->count / $maxListing) * 100 }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500 text-center py-8">No data available</p>
        @endif
    </div>

    <!-- Two Column Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Top Agencies by Properties -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-bold text-gray-900 mb-4">Top Agencies by Property Count</h2>
            @if($topAgencies->count() > 0)
                <div class="space-y-3">
                    @foreach($topAgencies as $index => $agency)
                        <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
                            <div class="w-8 h-8 {{ $index < 3 ? 'bg-gradient-to-br from-yellow-400 to-yellow-500' : 'bg-green-100' }} rounded-full flex items-center justify-center flex-shrink-0">
                                <span class="text-sm font-bold {{ $index < 3 ? 'text-white' : 'text-green-700' }}">#{{ $index + 1 }}</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="font-semibold text-gray-900 truncate">{{ $agency->agency_name }}</div>
                                <div class="text-xs text-gray-600">{{ $agency->state ?? 'N/A' }}</div>
                            </div>
                            <div class="text-right">
                                <div class="text-lg font-bold text-green-600">{{ $agency->properties_count }}</div>
                                <div class="text-xs text-gray-600">properties</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-8">No agencies with properties yet</p>
            @endif
        </div>

        <!-- Recent Properties -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-bold text-gray-900 mb-4">Recent Property Listings</h2>
            @if($recentProperties->count() > 0)
                <div class="space-y-3">
                    @foreach($recentProperties as $property)
                        <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
                            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="font-semibold text-gray-900 truncate">{{ $property->title }}</div>
                                <div class="text-xs text-gray-600">{{ $property->agency->agency_name ?? 'N/A' }} • {{ $property->created_at->diffForHumans() }}</div>
                            </div>
                            <div class="text-right">
                                <span class="px-2 py-1 rounded-full text-xs font-semibold
                                    {{ $property->listing_type === 'sale' ? 'bg-blue-100 text-blue-800' : 
                                       ($property->listing_type === 'rent' ? 'bg-purple-100 text-purple-800' : 'bg-indigo-100 text-indigo-800') }}">
                                    {{ ucfirst($property->listing_type) }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-8">No recent properties</p>
            @endif
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