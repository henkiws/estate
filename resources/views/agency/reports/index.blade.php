@extends('layouts.admin')

@section('title', 'Reports & Analytics')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-plyform-dark">Reports & Analytics</h1>
            <p class="mt-2 text-gray-600">Comprehensive insights into your agency performance</p>
        </div>

        <!-- Quick Links to Detailed Reports -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <a href="{{ route('agency.reports.properties') }}" class="group bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-all hover:border-plyform-yellow">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-blue-100 rounded-lg group-hover:bg-blue-200 transition">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <svg class="w-5 h-5 text-gray-400 group-hover:text-plyform-purple transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-plyform-dark mb-1">Properties Report</h3>
                <p class="text-sm text-gray-600">View detailed property analytics</p>
            </a>

            <a href="{{ route('agency.reports.applications') }}" class="group bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-all hover:border-plyform-yellow">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-purple-100 rounded-lg group-hover:bg-purple-200 transition">
                        <svg class="w-6 h-6 text-plyform-purple" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <svg class="w-5 h-5 text-gray-400 group-hover:text-plyform-purple transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-plyform-dark mb-1">Applications Report</h3>
                <p class="text-sm text-gray-600">Track application metrics</p>
            </a>

            <a href="{{ route('agency.reports.tenants') }}" class="group bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-all hover:border-plyform-yellow">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-green-100 rounded-lg group-hover:bg-green-200 transition">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <svg class="w-5 h-5 text-gray-400 group-hover:text-plyform-purple transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-plyform-dark mb-1">Tenants Report</h3>
                <p class="text-sm text-gray-600">Monitor tenant statistics</p>
            </a>

            <a href="{{ route('agency.reports.financial') }}" class="group bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-all hover:border-plyform-yellow">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-plyform-mint/50 rounded-lg group-hover:bg-plyform-mint transition">
                        <svg class="w-6 h-6 text-plyform-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <svg class="w-5 h-5 text-gray-400 group-hover:text-plyform-purple transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-plyform-dark mb-1">Financial Report</h3>
                <p class="text-sm text-gray-600">Review income and bonds</p>
            </a>
        </div>

        <!-- Overview Statistics -->
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-4 mb-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-xs text-gray-600">Properties</p>
                    <div class="p-2 bg-blue-100 rounded-lg">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                </div>
                <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_properties']) }}</p>
                <p class="text-xs text-green-600 mt-1">{{ $stats['active_properties'] }} active</p>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-xs text-gray-600">Applications</p>
                    <div class="p-2 bg-purple-100 rounded-lg">
                        <svg class="w-4 h-4 text-plyform-purple" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                </div>
                <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_applications']) }}</p>
                <p class="text-xs text-orange-600 mt-1">{{ $stats['pending_applications'] }} pending</p>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-xs text-gray-600">Approved</p>
                    <div class="p-2 bg-green-100 rounded-lg">
                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <p class="text-2xl font-bold text-green-600">{{ number_format($stats['approved_applications']) }}</p>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-xs text-gray-600">Tenants</p>
                    <div class="p-2 bg-teal-100 rounded-lg">
                        <svg class="w-4 h-4 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                </div>
                <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_tenants']) }}</p>
                <p class="text-xs text-green-600 mt-1">{{ $stats['active_tenants'] }} active</p>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="grid lg:grid-cols-2 gap-6 mb-8">
            <!-- Applications Trend -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-plyform-dark mb-4">Applications Trend (Last 12 Months)</h3>
                
                @if($monthlyApplications->count() > 0)
                    <div class="space-y-3">
                        @foreach($monthlyApplications as $month)
                            @php
                                $maxCount = $monthlyApplications->max('count');
                                $percentage = $maxCount > 0 ? ($month->count / $maxCount) * 100 : 0;
                            @endphp
                            <div>
                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-sm text-gray-600">{{ \Carbon\Carbon::parse($month->month . '-01')->format('M Y') }}</span>
                                    <span class="text-sm font-semibold text-gray-900">{{ $month->count }}</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-gradient-to-r from-plyform-yellow to-plyform-mint h-2 rounded-full transition-all duration-500" style="width: {{ $percentage }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8 text-gray-500">
                        <p>No data available</p>
                    </div>
                @endif
            </div>

            <!-- Tenant Growth -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-plyform-dark mb-4">Tenant Growth (Last 12 Months)</h3>
                
                @if($monthlyTenants->count() > 0)
                    <div class="space-y-3">
                        @foreach($monthlyTenants as $month)
                            @php
                                $maxCount = $monthlyTenants->max('count');
                                $percentage = $maxCount > 0 ? ($month->count / $maxCount) * 100 : 0;
                            @endphp
                            <div>
                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-sm text-gray-600">{{ \Carbon\Carbon::parse($month->month . '-01')->format('M Y') }}</span>
                                    <span class="text-sm font-semibold text-gray-900">{{ $month->count }}</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-gradient-to-r from-green-400 to-teal-500 h-2 rounded-full transition-all duration-500" style="width: {{ $percentage }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8 text-gray-500">
                        <p>No data available</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Bottom Row -->
        <div class="grid lg:grid-cols-2 gap-6">
            <!-- Top Performing Properties -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-plyform-dark mb-4">Top Performing Properties</h3>
                
                @if($propertyPerformance->count() > 0)
                    <div class="space-y-4">
                        @foreach($propertyPerformance as $property)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-semibold text-plyform-dark truncate">{{ $property->headline ?? $property->short_address }}</p>
                                    <p class="text-xs text-gray-600">{{ $property->suburb }}, {{ $property->state }}</p>
                                </div>
                                <div class="ml-4 flex items-center gap-2">
                                    <span class="px-3 py-1 text-xs font-bold bg-plyform-yellow text-plyform-dark rounded-full">
                                        {{ $property->applications_count }} {{ $property->applications_count === 1 ? 'app' : 'apps' }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8 text-gray-500">
                        <p>No applications yet</p>
                    </div>
                @endif
            </div>

            <!-- Status Distribution -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-plyform-dark mb-4">Application Status Distribution</h3>
                
                @if($applicationsByStatus->count() > 0)
                    <div class="space-y-3">
                        @foreach($applicationsByStatus as $status => $count)
                            @php
                                $total = $applicationsByStatus->sum();
                                $percentage = $total > 0 ? ($count / $total) * 100 : 0;
                                $colors = [
                                    'pending' => ['bg' => 'bg-orange-500', 'text' => 'text-orange-700'],
                                    'under_review' => ['bg' => 'bg-yellow-500', 'text' => 'text-yellow-700'],
                                    'approved' => ['bg' => 'bg-green-500', 'text' => 'text-green-700'],
                                    'rejected' => ['bg' => 'bg-red-500', 'text' => 'text-red-700'],
                                    'withdrawn' => ['bg' => 'bg-gray-500', 'text' => 'text-gray-700'],
                                ];
                                $color = $colors[$status] ?? ['bg' => 'bg-gray-500', 'text' => 'text-gray-700'];
                            @endphp
                            <div>
                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-sm {{ $color['text'] }} font-medium">{{ ucfirst(str_replace('_', ' ', $status)) }}</span>
                                    <span class="text-sm font-semibold text-gray-900">{{ $count }} ({{ number_format($percentage, 1) }}%)</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="{{ $color['bg'] }} h-2 rounded-full transition-all duration-500" style="width: {{ $percentage }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8 text-gray-500">
                        <p>No applications yet</p>
                    </div>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection