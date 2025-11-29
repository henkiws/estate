@extends('layouts.admin')

@section('title', 'Property Statistics')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <a href="{{ route('admin.properties.index') }}" class="text-blue-600 hover:text-blue-800 mb-2 inline-block">
                ← Back to Properties
            </a>
            <h1 class="text-3xl font-bold text-gray-900">Property Statistics & Analytics</h1>
            <p class="text-gray-600 mt-1">Overview of all properties across all agencies</p>
        </div>
        <div class="flex gap-3">
            <button onclick="window.print()" 
                    class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                </svg>
                Print Report
            </button>
            <a href="{{ route('admin.properties.export') }}" 
               class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Export All Data
            </a>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Properties -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Total Properties</p>
                    <p class="text-3xl font-bold text-gray-900">{{ number_format($stats['total_properties']) }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                </div>
            </div>
            <p class="text-sm text-gray-500 mt-2">All properties in system</p>
        </div>

        <!-- Active Properties -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Active Listings</p>
                    <p class="text-3xl font-bold text-green-600">{{ number_format($stats['active_properties']) }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                </div>
            </div>
            <p class="text-sm text-gray-500 mt-2">
                {{ $stats['total_properties'] > 0 ? round(($stats['active_properties'] / $stats['total_properties']) * 100, 1) : 0 }}% of total
            </p>
        </div>

        <!-- Featured Properties -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Featured</p>
                    <p class="text-3xl font-bold text-yellow-600">{{ number_format($stats['featured_properties']) }}</p>
                </div>
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                    </svg>
                </div>
            </div>
            <p class="text-sm text-gray-500 mt-2">Highlighted properties</p>
        </div>

        <!-- Pending Approval -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Pending</p>
                    <p class="text-3xl font-bold text-orange-600">{{ number_format($stats['pending_properties']) }}</p>
                </div>
                <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <p class="text-sm text-gray-500 mt-2">Awaiting approval</p>
        </div>
    </div>

    <!-- Listing Type & Status Charts -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Listing Type Breakdown -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Listing Type Distribution</h2>
            <div class="space-y-4">
                <!-- For Sale -->
                <div>
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-sm font-medium text-gray-700">For Sale</span>
                        <span class="text-sm font-bold text-gray-900">{{ number_format($stats['properties_for_sale']) }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-3">
                        <div class="bg-green-500 h-3 rounded-full" 
                             style="width: {{ $stats['total_properties'] > 0 ? ($stats['properties_for_sale'] / $stats['total_properties']) * 100 : 0 }}%"></div>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">
                        {{ $stats['total_properties'] > 0 ? round(($stats['properties_for_sale'] / $stats['total_properties']) * 100, 1) : 0 }}% of total
                    </p>
                </div>

                <!-- For Rent -->
                <div>
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-sm font-medium text-gray-700">For Rent</span>
                        <span class="text-sm font-bold text-gray-900">{{ number_format($stats['properties_for_rent']) }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-3">
                        <div class="bg-blue-500 h-3 rounded-full" 
                             style="width: {{ $stats['total_properties'] > 0 ? ($stats['properties_for_rent'] / $stats['total_properties']) * 100 : 0 }}%"></div>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">
                        {{ $stats['total_properties'] > 0 ? round(($stats['properties_for_rent'] / $stats['total_properties']) * 100, 1) : 0 }}% of total
                    </p>
                </div>
            </div>
        </div>

        <!-- Property Status Breakdown -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Property Status</h2>
            <div class="space-y-4">
                <!-- Active -->
                <div class="flex justify-between items-center">
                    <div class="flex items-center">
                        <span class="w-3 h-3 bg-green-500 rounded-full mr-2"></span>
                        <span class="text-sm text-gray-700">Active</span>
                    </div>
                    <span class="text-sm font-bold text-gray-900">{{ number_format($stats['active_properties']) }}</span>
                </div>

                <!-- Pending -->
                <div class="flex justify-between items-center">
                    <div class="flex items-center">
                        <span class="w-3 h-3 bg-yellow-500 rounded-full mr-2"></span>
                        <span class="text-sm text-gray-700">Pending</span>
                    </div>
                    <span class="text-sm font-bold text-gray-900">{{ number_format($stats['pending_properties']) }}</span>
                </div>

                <!-- Sold -->
                <div class="flex justify-between items-center">
                    <div class="flex items-center">
                        <span class="w-3 h-3 bg-purple-500 rounded-full mr-2"></span>
                        <span class="text-sm text-gray-700">Sold</span>
                    </div>
                    <span class="text-sm font-bold text-gray-900">{{ number_format($stats['sold_properties']) }}</span>
                </div>

                <!-- Rented -->
                <div class="flex justify-between items-center">
                    <div class="flex items-center">
                        <span class="w-3 h-3 bg-indigo-500 rounded-full mr-2"></span>
                        <span class="text-sm text-gray-700">Rented</span>
                    </div>
                    <span class="text-sm font-bold text-gray-900">{{ number_format($stats['rented_properties']) }}</span>
                </div>

                <!-- Featured -->
                <div class="flex justify-between items-center">
                    <div class="flex items-center">
                        <span class="w-3 h-3 bg-yellow-400 rounded-full mr-2"></span>
                        <span class="text-sm text-gray-700">Featured</span>
                    </div>
                    <span class="text-sm font-bold text-gray-900">{{ number_format($stats['featured_properties']) }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Properties by Agency -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
        <h2 class="text-xl font-bold text-gray-900 mb-4">Properties by Agency</h2>
        
        @if($propertiesByAgency->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Agency Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Properties</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Percentage</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Visual</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($propertiesByAgency->sortByDesc('count')->take(10) as $item)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                            <span class="text-blue-600 text-xs font-semibold">
                                                {{ substr($item['agency'], 0, 2) }}
                                            </span>
                                        </div>
                                        <span class="font-medium text-gray-900">{{ $item['agency'] }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm font-bold text-gray-900">{{ number_format($item['count']) }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm text-gray-600">
                                        {{ $stats['total_properties'] > 0 ? round(($item['count'] / $stats['total_properties']) * 100, 1) : 0 }}%
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="bg-blue-500 h-2 rounded-full" 
                                             style="width: {{ $stats['total_properties'] > 0 ? ($item['count'] / $stats['total_properties']) * 100 : 0 }}%"></div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            @if($propertiesByAgency->count() > 10)
                <p class="text-sm text-gray-500 mt-4 text-center">
                    Showing top 10 agencies. Total agencies: {{ $propertiesByAgency->count() }}
                </p>
            @endif
        @else
            <p class="text-gray-500 text-center py-8">No agency data available</p>
        @endif
    </div>

    <!-- Recent Properties -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h2 class="text-xl font-bold text-gray-900 mb-4">Recent Property Listings</h2>
        
        @if($recentProperties->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Property</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Agency</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($recentProperties as $property)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <div>
                                        <p class="font-medium text-gray-900">{{ Str::limit($property->title, 40) }}</p>
                                        <p class="text-sm text-gray-500">{{ $property->property_id }}</p>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm text-gray-900">{{ Str::limit($property->agency->agency_name ?? 'N/A', 20) }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                        {{ $property->listing_type === 'sale' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                                        {{ ucfirst($property->listing_type) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($property->status === 'active') bg-green-100 text-green-800
                                        @elseif($property->status === 'pending') bg-yellow-100 text-yellow-800
                                        @else bg-gray-100 text-gray-800
                                        @endif">
                                        {{ ucfirst($property->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $property->created_at->diffForHumans() }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <a href="{{ route('admin.properties.show', $property) }}" 
                                       class="text-blue-600 hover:text-blue-900">
                                        View
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-500 text-center py-8">No recent properties</p>
        @endif
    </div>

    <!-- Quick Links -->
    <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
        <a href="{{ route('admin.properties.index', ['status' => 'pending']) }}" 
           class="block bg-yellow-50 border border-yellow-200 rounded-lg p-6 hover:bg-yellow-100 transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-yellow-800 font-semibold">Review Pending</p>
                    <p class="text-2xl font-bold text-yellow-900 mt-2">{{ $stats['pending_properties'] }}</p>
                </div>
                <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </a>

        <a href="{{ route('admin.properties.index', ['featured' => '1']) }}" 
           class="block bg-yellow-50 border border-yellow-200 rounded-lg p-6 hover:bg-yellow-100 transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-yellow-800 font-semibold">Featured Properties</p>
                    <p class="text-2xl font-bold text-yellow-900 mt-2">{{ $stats['featured_properties'] }}</p>
                </div>
                <svg class="w-8 h-8 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                </svg>
            </div>
        </a>

        <a href="{{ route('admin.properties.index') }}" 
           class="block bg-blue-50 border border-blue-200 rounded-lg p-6 hover:bg-blue-100 transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-800 font-semibold">All Properties</p>
                    <p class="text-2xl font-bold text-blue-900 mt-2">{{ $stats['total_properties'] }}</p>
                </div>
                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
            </div>
        </a>
    </div>
</div>

<style>
@media print {
    .no-print {
        display: none !important;
    }
    
    body {
        print-color-adjust: exact;
        -webkit-print-color-adjust: exact;
    }
}
</style>
@endsection