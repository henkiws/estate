@extends('layouts.admin')

@section('title', 'Agency Dashboard')

@section('content')

<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-2">
        Welcome back, {{ Auth::user()->name }} 👋
    </h1>
    <p class="text-gray-600">
        @if($agency)
            Managing <strong>{{ $agency->agency_name }}</strong>
        @else
            Here's what's happening with your agency today.
        @endif
    </p>
</div>

{{-- Agency Status Alert --}}
@if($agency && $agency->status !== 'active')
<div class="mb-6 bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-lg">
    <div class="flex">
        <svg class="w-5 h-5 text-yellow-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
        </svg>
        <div>
            <p class="text-yellow-700 font-medium">
                Your agency is currently <strong>{{ ucfirst($agency->status) }}</strong>
            </p>
            <p class="text-yellow-600 text-sm mt-1">
                @if($agency->status === 'pending')
                    We're reviewing your application. You'll receive an email once approved.
                @elseif($agency->status === 'suspended')
                    Your agency has been suspended. Please contact support for assistance.
                @else
                    Some features may be limited. Please contact support if you need help.
                @endif
            </p>
        </div>
    </div>
</div>
@endif

{{-- Statistics Cards --}}
<div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Agents -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-primary-light rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
            </div>
            <span class="text-xs font-semibold text-primary bg-primary-light px-2 py-1 rounded-full">Team</span>
        </div>
        <div class="text-2xl font-bold text-gray-900 mb-1">
            {{ $agency ? $agency->agents()->count() : 0 }}
        </div>
        <div class="text-sm text-gray-600">Total Agents</div>
    </div>

    <!-- Active Listings (Mock Data) -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </div>
            <span class="text-xs font-semibold text-success bg-success/10 px-2 py-1 rounded-full">Active</span>
        </div>
        <div class="text-2xl font-bold text-gray-900 mb-1">0</div>
        <div class="text-sm text-gray-600">Active Listings</div>
    </div>

    <!-- Total Revenue (Mock Data) -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <span class="text-xs font-semibold text-orange-600 bg-orange-100 px-2 py-1 rounded-full">MTD</span>
        </div>
        <div class="text-2xl font-bold text-gray-900 mb-1">$0</div>
        <div class="text-sm text-gray-600">Total Revenue</div>
    </div>

    <!-- Active Clients (Mock Data) -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
            </div>
            <span class="text-xs font-semibold text-gray-600 bg-gray-100 px-2 py-1 rounded-full">Total</span>
        </div>
        <div class="text-2xl font-bold text-gray-900 mb-1">0</div>
        <div class="text-sm text-gray-600">Active Clients</div>
    </div>
</div>

<!-- Two Column Layout -->
<div class="grid lg:grid-cols-3 gap-8">
    <!-- Left Column -->
    <div class="lg:col-span-2 space-y-8">
        
        <!-- Agency Information -->
        @if($agency)
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
            <div class="p-6 border-b border-gray-100">
                <h2 class="text-xl font-bold text-gray-900">Agency Information</h2>
            </div>
            <div class="p-6">
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label class="text-sm font-semibold text-gray-600">Agency Name</label>
                        <p class="text-gray-900 mt-1">{{ $agency->agency_name }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-gray-600">Trading Name</label>
                        <p class="text-gray-900 mt-1">{{ $agency->trading_name ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-gray-600">ABN</label>
                        <p class="text-gray-900 mt-1">{{ $agency->abn }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-gray-600">License Number</label>
                        <p class="text-gray-900 mt-1">{{ $agency->license_number }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-gray-600">State</label>
                        <p class="text-gray-900 mt-1">{{ $agency->state }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-gray-600">Status</label>
                        <p class="mt-1">
                            <span class="px-3 py-1 rounded-full text-sm font-semibold
                                {{ $agency->status === 'active' ? 'bg-success/10 text-success' : '' }}
                                {{ $agency->status === 'pending' ? 'bg-yellow-100 text-yellow-600' : '' }}
                                {{ $agency->status === 'suspended' ? 'bg-red-100 text-red-600' : '' }}">
                                {{ ucfirst($agency->status) }}
                            </span>
                        </p>
                    </div>
                </div>
                <div class="mt-6 pt-6 border-t border-gray-100">
                    <a href="{{ route('agency.profile') }}" class="inline-flex items-center text-primary hover:text-primary-dark font-semibold text-sm">
                        View Full Profile
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
        @endif

        <!-- My Agents -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
            <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                <h2 class="text-xl font-bold text-gray-900">My Agents</h2>
                <button class="px-4 py-2 bg-primary text-white rounded-lg text-sm font-semibold hover:bg-primary-dark transition-colors">
                    + Add Agent
                </button>
            </div>
            <div class="p-6">
                @if($agency && $agency->agents()->count() > 0)
                <div class="space-y-4">
                    @foreach($agency->agents as $agent)
                    <div class="flex gap-4 p-4 border border-gray-200 rounded-xl hover:border-primary transition-colors">
                        <div class="w-12 h-12 bg-gradient-to-br from-primary to-purple-600 rounded-full flex items-center justify-center text-white font-bold flex-shrink-0">
                            {{ strtoupper(substr($agent->agent_name, 0, 2)) }}
                        </div>
                        <div class="flex-1">
                            <h3 class="font-semibold text-gray-900">{{ $agent->agent_name }}</h3>
                            <p class="text-sm text-gray-600">{{ $agent->position ?? 'Sales Agent' }}</p>
                            <div class="flex items-center gap-4 text-xs text-gray-500 mt-2">
                                <span>{{ $agent->email }}</span>
                                <span>•</span>
                                <span>{{ $agent->mobile }}</span>
                            </div>
                        </div>
                        <div>
                            <span class="px-3 py-1 bg-success/10 text-success rounded-full text-xs font-semibold">
                                {{ ucfirst($agent->status) }}
                            </span>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    <p class="mt-4 text-gray-600">No agents added yet</p>
                    <button class="mt-4 px-6 py-2 bg-primary text-white rounded-lg text-sm font-semibold hover:bg-primary-dark transition">
                        Add Your First Agent
                    </button>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Right Column -->
    <div class="space-y-8">
        <!-- Quick Actions -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-6">Quick Actions</h2>
            <div class="space-y-3">
                <button class="w-full flex items-center gap-3 px-4 py-3 bg-primary-light text-primary rounded-xl hover:bg-primary hover:text-white transition-all font-semibold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                    </svg>
                    Add Agent
                </button>
                <button class="w-full flex items-center gap-3 px-4 py-3 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-all font-semibold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Add Property
                </button>
                <button class="w-full flex items-center gap-3 px-4 py-3 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-all font-semibold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Upload Document
                </button>
                <button class="w-full flex items-center gap-3 px-4 py-3 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-all font-semibold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    View Reports
                </button>
            </div>
        </div>

        <!-- Agency Stats -->
        @if($agency)
        <div class="bg-gradient-to-br from-primary to-primary-dark rounded-2xl p-6 text-white">
            <h3 class="text-lg font-bold mb-6">Your Agency</h3>
            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <span class="text-white/80 text-sm">Member Since</span>
                    <span class="font-bold">{{ $agency->created_at->format('M Y') }}</span>
                </div>
                <div class="h-px bg-white/20"></div>
                <div class="flex justify-between items-center">
                    <span class="text-white/80 text-sm">Total Agents</span>
                    <span class="text-2xl font-bold">{{ $agency->agents()->count() }}</span>
                </div>
                <div class="h-px bg-white/20"></div>
                <div class="flex justify-between items-center">
                    <span class="text-white/80 text-sm">State</span>
                    <span class="font-bold">{{ $agency->state }}</span>
                </div>
            </div>
        </div>
        @endif

        <!-- Getting Started -->
        @if($agency && $agency->status === 'pending')
        <div class="bg-yellow-50 rounded-2xl p-6 border border-yellow-200">
            <h3 class="text-lg font-bold text-yellow-900 mb-4">Getting Started</h3>
            <div class="space-y-3 text-sm">
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-yellow-600 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <p class="text-yellow-800">✓ Agency registered</p>
                </div>
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-yellow-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="text-yellow-800">Waiting for admin approval</p>
                </div>
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-gray-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                    <p class="text-gray-600">Full access after approval</p>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

@endsection