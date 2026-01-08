@extends('layouts.admin')

@section('title', 'Tenants')

@section('content')
<div class="py-8">
    <div class="container mx-auto px-4 py-8">
        
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-plyform-dark">Tenant Management</h1>
            <p class="mt-2 text-gray-600">Manage all your tenants and their lease information</p>
        </div>

        <!-- Flash Messages -->
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border-2 border-green-500 text-green-700 rounded-xl flex items-center gap-2">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 bg-red-50 border-2 border-red-500 text-red-700 rounded-xl flex items-center gap-2">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                {{ session('error') }}
            </div>
        @endif

        <!-- Statistics Cards -->
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-8 gap-4 mb-6">
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
                    <p class="text-xs text-gray-600">Ending</p>
                    <div class="p-2 bg-red-100 rounded-lg">
                        <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </div>
                </div>
                <p class="text-2xl font-bold text-red-600">{{ number_format($stats['ending']) }}</p>
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
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-xs text-gray-600">Bond Due</p>
                    <div class="p-2 bg-plyform-mint/50 rounded-lg">
                        <svg class="w-4 h-4 text-plyform-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                </div>
                <p class="text-2xl font-bold text-plyform-dark">{{ number_format($stats['bond_unpaid']) }}</p>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-xs text-gray-600">Overdue</p>
                    <div class="p-2 bg-red-100 rounded-lg">
                        <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <p class="text-2xl font-bold text-red-600">{{ number_format($stats['payment_overdue']) }}</p>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
            <form method="GET" action="{{ route('agency.tenants.index') }}">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                    <!-- Search -->
                    <div class="lg:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                        <div class="relative">
                            <input 
                                type="text" 
                                name="search" 
                                value="{{ request('search') }}"
                                placeholder="Search by name, email, tenant code, or property..."
                                class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-yellow focus:border-transparent"
                            >
                            <svg class="absolute left-3 top-2.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                    </div>
                    
                    <!-- Status Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <select 
                            name="status" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-yellow focus:border-transparent"
                        >
                            <option value="">All Status</option>
                            <option value="pending_move_in" {{ request('status') === 'pending_move_in' ? 'selected' : '' }}>Pending Move-In</option>
                            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="notice_given" {{ request('status') === 'notice_given' ? 'selected' : '' }}>Notice Given</option>
                            <option value="ending" {{ request('status') === 'ending' ? 'selected' : '' }}>Ending</option>
                            <option value="ended" {{ request('status') === 'ended' ? 'selected' : '' }}>Ended</option>
                        </select>
                    </div>
                    
                    <!-- Property Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Property</label>
                        <select 
                            name="property_id" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-yellow focus:border-transparent"
                        >
                            <option value="">All Properties</option>
                            @foreach($properties as $property)
                                <option value="{{ $property->id }}" {{ request('property_id') == $property->id ? 'selected' : '' }}>
                                    {{ $property->headline ?? $property->short_address }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                    <!-- Bond Status Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Bond Status</label>
                        <select 
                            name="bond_status" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-yellow focus:border-transparent"
                        >
                            <option value="">All</option>
                            <option value="paid" {{ request('bond_status') === 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="unpaid" {{ request('bond_status') === 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                        </select>
                    </div>

                    <!-- Lease Expiring Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Lease Expiring</label>
                        <select 
                            name="lease_expiring" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-yellow focus:border-transparent"
                        >
                            <option value="">All</option>
                            <option value="30" {{ request('lease_expiring') == '30' ? 'selected' : '' }}>Within 30 days</option>
                            <option value="60" {{ request('lease_expiring') == '60' ? 'selected' : '' }}>Within 60 days</option>
                            <option value="90" {{ request('lease_expiring') == '90' ? 'selected' : '' }}>Within 90 days</option>
                        </select>
                    </div>

                    <!-- Payment Overdue Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Payment</label>
                        <select 
                            name="payment_overdue" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-yellow focus:border-transparent"
                        >
                            <option value="">All</option>
                            <option value="yes" {{ request('payment_overdue') === 'yes' ? 'selected' : '' }}>Overdue</option>
                        </select>
                    </div>

                    <!-- Date From -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Lease Start From</label>
                        <input 
                            type="date" 
                            name="date_from" 
                            value="{{ request('date_from') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-yellow focus:border-transparent"
                        >
                    </div>

                    <!-- Filter Buttons -->
                    <div class="flex items-end gap-2">
                        <button 
                            type="submit" 
                            class="flex-1 px-4 py-2 bg-plyform-yellow text-plyform-dark font-semibold rounded-lg hover:bg-plyform-yellow/80 transition"
                        >
                            Apply
                        </button>
                        @if(request()->hasAny(['search', 'status', 'property_id', 'bond_status', 'lease_expiring', 'payment_overdue', 'date_from']))
                            <a 
                                href="{{ route('agency.tenants.index') }}" 
                                class="px-4 py-2 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 transition"
                            >
                                Clear
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>

        <!-- Tenants List -->
        @if($tenants->count() > 0)
            <div class="space-y-4 mb-6">
                @foreach($tenants as $tenant)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                        <div class="p-6">
                            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                                <!-- Left: Tenant Info -->
                                <div class="flex-1">
                                    <div class="flex items-start gap-4">
                                        <div class="w-12 h-12 bg-gradient-to-br from-plyform-yellow to-plyform-mint rounded-full flex items-center justify-center flex-shrink-0">
                                            <span class="text-plyform-dark font-bold">{{ strtoupper(substr($tenant->first_name, 0, 1) . substr($tenant->last_name, 0, 1)) }}</span>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center gap-2 mb-1">
                                                <h3 class="text-lg font-semibold text-plyform-dark">
                                                    {{ $tenant->full_name }}
                                                </h3>
                                                <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $tenant->status_color }}">
                                                    {{ $tenant->status_label }}
                                                </span>
                                            </div>
                                            <p class="text-sm text-gray-600 mb-2">{{ $tenant->tenant_code }} • {{ $tenant->email }}</p>
                                            
                                            <div class="flex flex-wrap items-center gap-3 text-sm text-gray-600">
                                                <span class="flex items-center gap-1">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                                    </svg>
                                                    {{ $tenant->property->headline ?? $tenant->property->short_address }}
                                                </span>
                                                <span>•</span>
                                                <span class="flex items-center gap-1">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                                                    </svg>
                                                    {{ $tenant->formatted_rent }}
                                                </span>
                                                <span>•</span>
                                                <span class="flex items-center gap-1">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                    </svg>
                                                    Lease: {{ $tenant->lease_start_date->format('M d, Y') }} - {{ $tenant->lease_end_date->format('M d, Y') }}
                                                </span>
                                            </div>

                                            <!-- Additional badges -->
                                            <div class="flex flex-wrap gap-2 mt-2">
                                                @if(!$tenant->bond_paid)
                                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-orange-100 text-orange-700">
                                                        Bond Unpaid
                                                    </span>
                                                @endif

                                                @if($tenant->isRentOverdue())
                                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-700">
                                                        {{ $tenant->days_overdue }} days overdue
                                                    </span>
                                                @endif

                                                @if($tenant->is_lease_expiring_soon)
                                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-700">
                                                        Expires in {{ $tenant->days_until_lease_end }} days
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Right: Actions -->
                                <div class="flex items-center gap-3">
                                    <a href="{{ route('agency.tenants.show', $tenant) }}" 
                                       class="px-4 py-2 bg-plyform-yellow text-plyform-dark font-semibold rounded-lg hover:bg-plyform-yellow/80 transition inline-flex items-center gap-2 whitespace-nowrap">
                                        View Details
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                {{ $tenants->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center">
                <svg class="w-20 h-20 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No tenants found</h3>
                <p class="text-gray-600 mb-6">
                    @if(request()->hasAny(['search', 'status', 'property_id', 'bond_status', 'lease_expiring', 'payment_overdue', 'date_from']))
                        Try adjusting your filters to find what you're looking for.
                    @else
                        You haven't converted any applications to tenants yet.
                    @endif
                </p>
                @if(request()->hasAny(['search', 'status', 'property_id', 'bond_status', 'lease_expiring', 'payment_overdue', 'date_from']))
                    <a href="{{ route('agency.tenants.index') }}" 
                       class="inline-flex items-center gap-2 px-6 py-3 bg-plyform-yellow text-plyform-dark font-semibold rounded-lg hover:bg-plyform-yellow/80 transition">
                        Clear Filters
                    </a>
                @else
                    <a href="{{ route('agency.applications.index') }}" 
                       class="inline-flex items-center gap-2 px-6 py-3 bg-plyform-yellow text-plyform-dark font-semibold rounded-lg hover:bg-plyform-yellow/80 transition">
                        View Applications
                    </a>
                @endif
            </div>
        @endif
        
    </div>
</div>
@endsection