@extends('layouts.admin')

@section('title', 'Properties Report')

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
                <h1 class="text-3xl font-bold text-plyform-dark">Properties Report</h1>
                <p class="mt-2 text-gray-600">Detailed analytics for all your properties</p>
            </div>
            <button onclick="window.print()" class="px-4 py-2 bg-plyform-yellow text-plyform-dark font-semibold rounded-lg hover:bg-plyform-yellow/80 transition inline-flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                </svg>
                Print Report
            </button>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-4 mb-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-xs text-gray-600">Total</p>
                    <div class="p-2 bg-blue-100 rounded-lg">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
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
                    <p class="text-xs text-gray-600">Rented</p>
                    <div class="p-2 bg-teal-100 rounded-lg">
                        <svg class="w-4 h-4 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                    </div>
                </div>
                <p class="text-2xl font-bold text-teal-600">{{ number_format($stats['rented']) }}</p>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-xs text-gray-600">Draft</p>
                    <div class="p-2 bg-gray-100 rounded-lg">
                        <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </div>
                </div>
                <p class="text-2xl font-bold text-gray-600">{{ number_format($stats['draft']) }}</p>
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
                <p class="text-2xl font-bold text-plyform-purple">{{ number_format($stats['total_applications']) }}</p>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-xs text-gray-600">Enquiries</p>
                    <div class="p-2 bg-orange-100 rounded-lg">
                        <svg class="w-4 h-4 text-plyform-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                        </svg>
                    </div>
                </div>
                <p class="text-2xl font-bold text-plyform-orange">{{ number_format($stats['total_enquiries']) }}</p>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-xs text-gray-600">Avg Rent</p>
                    <div class="p-2 bg-plyform-mint/50 rounded-lg">
                        <svg class="w-4 h-4 text-plyform-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <p class="text-xl font-bold text-plyform-dark">${{ number_format($stats['avg_rent'], 0) }}</p>
                <p class="text-xs text-gray-600">per week</p>
            </div>
        </div>

        <!-- Properties by Type -->
        @if($propertiesByType->count() > 0)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
            <h3 class="text-lg font-bold text-plyform-dark mb-4">Properties by Type</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach($propertiesByType as $type => $count)
                    @php
                        $total = $propertiesByType->sum();
                        $percentage = $total > 0 ? ($count / $total) * 100 : 0;
                    @endphp
                    <div class="text-center p-4 bg-gray-50 rounded-lg">
                        <p class="text-3xl font-bold text-plyform-dark">{{ $count }}</p>
                        <p class="text-sm text-gray-600 mt-1">{{ ucfirst($type) }}</p>
                        <p class="text-xs text-gray-500 mt-1">{{ number_format($percentage, 1) }}%</p>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Filters -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
            <form method="GET" action="{{ route('agency.reports.properties') }}">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-yellow focus:border-transparent">
                            <option value="">All Status</option>
                            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="rented" {{ request('status') === 'rented' ? 'selected' : '' }}>Rented</option>
                            <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Property Type</label>
                        <select name="property_type" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-yellow focus:border-transparent">
                            <option value="">All Types</option>
                            <option value="house" {{ request('property_type') === 'house' ? 'selected' : '' }}>House</option>
                            <option value="apartment" {{ request('property_type') === 'apartment' ? 'selected' : '' }}>Apartment</option>
                            <option value="townhouse" {{ request('property_type') === 'townhouse' ? 'selected' : '' }}>Townhouse</option>
                            <option value="unit" {{ request('property_type') === 'unit' ? 'selected' : '' }}>Unit</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Date From</label>
                        <input type="date" name="date_from" value="{{ request('date_from') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-yellow focus:border-transparent">
                    </div>

                    <div class="flex items-end gap-2">
                        <button type="submit" class="flex-1 px-4 py-2 bg-plyform-yellow text-plyform-dark font-semibold rounded-lg hover:bg-plyform-yellow/80 transition">
                            Apply
                        </button>
                        @if(request()->hasAny(['status', 'property_type', 'date_from', 'date_to']))
                            <a href="{{ route('agency.reports.properties') }}" class="px-4 py-2 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 transition">
                                Clear
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>

        <!-- Properties List -->
        @if($properties->count() > 0)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-6">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Property</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rent</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Applications</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Enquiries</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Listed</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($properties as $property)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            @if($property->images->count() > 0)
                                                <img src="{{ Storage::url($property->images->first()->image_path) }}" alt="" class="w-12 h-12 object-cover rounded-lg">
                                            @else
                                                <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center">
                                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                                    </svg>
                                                </div>
                                            @endif
                                            <div>
                                                <p class="text-sm font-semibold text-plyform-dark">{{ $property->headline ?? $property->short_address }}</p>
                                                <p class="text-xs text-gray-600">{{ $property->suburb }}, {{ $property->state }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ ucfirst($property->property_type) }}</td>
                                    <td class="px-6 py-4 text-sm font-semibold text-gray-900">
                                        @if($property->rent_per_week)
                                            ${{ number_format($property->rent_per_week, 0) }}/wk
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $property->status === 'active' ? 'bg-green-100 text-green-700' : ($property->status === 'rented' ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-700') }}">
                                            {{ ucfirst($property->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $property->applications_count }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $property->enquiries_count ?? 0 }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $property->created_at->format('M d, Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                {{ $properties->links() }}
            </div>
        @else
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center">
                <svg class="w-20 h-20 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No properties found</h3>
                <p class="text-gray-600">Try adjusting your filters or add new properties.</p>
            </div>
        @endif

    </div>
</div>
@endsection