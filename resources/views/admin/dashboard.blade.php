@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-2">
        Welcome back, {{ Auth::user()->name }} 👋
    </h1>
    <p class="text-gray-600">Here's what's happening with your properties today.</p>
</div>

<div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Stat Card 1 -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-primary-light rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
            </div>
            <span class="text-xs font-semibold text-success bg-success/10 px-2 py-1 rounded-full">+12%</span>
        </div>
        <div class="text-2xl font-bold text-gray-900 mb-1">3</div>
        <div class="text-sm text-gray-600">Total Properties</div>
    </div>

    <!-- Stat Card 2 -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <span class="text-xs font-semibold text-success bg-success/10 px-2 py-1 rounded-full">+8%</span>
        </div>
        <div class="text-2xl font-bold text-gray-900 mb-1">$12,450</div>
        <div class="text-sm text-gray-600">Monthly Revenue</div>
    </div>

    <!-- Stat Card 3 -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                </svg>
            </div>
            <span class="text-xs font-semibold text-orange-600 bg-orange-100 px-2 py-1 rounded-full">2 Active</span>
        </div>
        <div class="text-2xl font-bold text-gray-900 mb-1">2</div>
        <div class="text-sm text-gray-600">Maintenance Requests</div>
    </div>

    <!-- Stat Card 4 -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
            <span class="text-xs font-semibold text-gray-600 bg-gray-100 px-2 py-1 rounded-full">100%</span>
        </div>
        <div class="text-2xl font-bold text-gray-900 mb-1">8</div>
        <div class="text-sm text-gray-600">Active Tenants</div>
    </div>
</div>

<!-- Two Column Layout -->
<div class="grid lg:grid-cols-3 gap-8">
    <!-- Left Column -->
    <div class="lg:col-span-2 space-y-8">
        <!-- Recent Activity -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
            <div class="p-6 border-b border-gray-100">
                <h2 class="text-xl font-bold text-gray-900">Recent Activity</h2>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    <!-- Activity Item -->
                    <div class="flex gap-4">
                        <div
                            class="w-10 h-10 bg-primary-light rounded-full flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-900">Payment received from Sarah Johnson</p>
                            <p class="text-xs text-gray-500">$1,500 • Apartment 3B • 2 hours ago</p>
                        </div>
                    </div>

                    <div class="flex gap-4">
                        <div
                            class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-900">New maintenance request</p>
                            <p class="text-xs text-gray-500">Kitchen sink leak • House 12A • 5 hours ago</p>
                        </div>
                    </div>

                    <div class="flex gap-4">
                        <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-900">Maintenance completed</p>
                            <p class="text-xs text-gray-500">HVAC repair • Office Suite 5 • Yesterday</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Properties List -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
            <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                <h2 class="text-xl font-bold text-gray-900">Your Properties</h2>
                <button
                    class="px-4 py-2 bg-primary text-white rounded-lg text-sm font-semibold hover:bg-primary-dark transition-colors">
                    + Add Property
                </button>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    <!-- Property Card -->
                    <div
                        class="flex gap-4 p-4 border border-gray-200 rounded-xl hover:border-primary transition-colors cursor-pointer">
                        <img src="https://placehold.co/100x100/E8F5FF/0066FF?text=Home" alt="Property"
                            class="w-20 h-20 rounded-lg object-cover">
                        <div class="flex-1">
                            <h3 class="font-semibold text-gray-900 mb-1">Sunset Apartments 3B</h3>
                            <p class="text-sm text-gray-600 mb-2">123 Main St, City, State 12345</p>
                            <div class="flex items-center gap-4 text-xs text-gray-500">
                                <span class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    4 Tenants
                                </span>
                                <span
                                    class="px-2 py-1 bg-success/10 text-success rounded-full font-semibold">Active</span>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-lg font-bold text-gray-900">$2,800</div>
                            <div class="text-xs text-gray-500">per month</div>
                        </div>
                    </div>

                    <div
                        class="flex gap-4 p-4 border border-gray-200 rounded-xl hover:border-primary transition-colors cursor-pointer">
                        <img src="https://placehold.co/100x100/F0F9FF/00AAFF?text=Office" alt="Property"
                            class="w-20 h-20 rounded-lg object-cover">
                        <div class="flex-1">
                            <h3 class="font-semibold text-gray-900 mb-1">Commercial Suite 5</h3>
                            <p class="text-sm text-gray-600 mb-2">789 Business Blvd, City, State 12345</p>
                            <div class="flex items-center gap-4 text-xs text-gray-500">
                                <span class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    2 Tenants
                                </span>
                                <span
                                    class="px-2 py-1 bg-success/10 text-success rounded-full font-semibold">Active</span>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-lg font-bold text-gray-900">$3,200</div>
                            <div class="text-xs text-gray-500">per month</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column -->
    <div class="space-y-8">
        <!-- Quick Actions -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-6">Quick Actions</h2>
            <div class="space-y-3">
                <button
                    class="w-full flex items-center gap-3 px-4 py-3 bg-primary-light text-primary rounded-xl hover:bg-primary hover:text-white transition-all font-semibold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Add Property
                </button>
                <button
                    class="w-full flex items-center gap-3 px-4 py-3 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-all font-semibold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                    Add Tenant
                </button>
                <button
                    class="w-full flex items-center gap-3 px-4 py-3 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-all font-semibold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Upload Document
                </button>
                <button
                    class="w-full flex items-center gap-3 px-4 py-3 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-all font-semibold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7" />
                    </svg>
                    Report Issue
                </button>
            </div>
        </div>

        <!-- Upcoming Payments -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
            <div class="p-6 border-b border-gray-100">
                <h2 class="text-xl font-bold text-gray-900">Upcoming Payments</h2>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-semibold text-gray-900">Sarah Johnson</p>
                            <p class="text-xs text-gray-500">Apartment 3B</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-bold text-gray-900">$1,500</p>
                            <p class="text-xs text-gray-500">Due in 5 days</p>
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-semibold text-gray-900">Michael Chen</p>
                            <p class="text-xs text-gray-500">House 12A</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-bold text-gray-900">$2,800</p>
                            <p class="text-xs text-gray-500">Due in 8 days</p>
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-semibold text-gray-900">Tech Corp LLC</p>
                            <p class="text-xs text-gray-500">Suite 5</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-bold text-gray-900">$3,200</p>
                            <p class="text-xs text-gray-500">Due in 12 days</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Performance Chart -->
        <div class="bg-gradient-to-br from-primary to-primary-dark rounded-2xl p-6 text-white">
            <h3 class="text-lg font-bold mb-2">Monthly Performance</h3>
            <div class="text-3xl font-bold mb-4">$12,450</div>
            <div class="flex items-center gap-2 mb-4">
                <span class="px-2 py-1 bg-white/20 rounded-full text-xs font-semibold">+8% from last month</span>
            </div>
            <div class="h-32 flex items-end justify-between gap-2">
                <div class="flex-1 bg-white/30 rounded-t-lg" style="height: 60%"></div>
                <div class="flex-1 bg-white/30 rounded-t-lg" style="height: 75%"></div>
                <div class="flex-1 bg-white/30 rounded-t-lg" style="height: 50%"></div>
                <div class="flex-1 bg-white/30 rounded-t-lg" style="height: 85%"></div>
                <div class="flex-1 bg-white/20 rounded-t-lg" style="height: 90%"></div>
                <div class="flex-1 bg-white rounded-t-lg" style="height: 100%"></div>
            </div>
            <div class="flex justify-between mt-2 text-xs opacity-75">
                <span>Jan</span>
                <span>Feb</span>
                <span>Mar</span>
                <span>Apr</span>
                <span>May</span>
                <span>Jun</span>
            </div>
        </div>
    </div>
</div>

@endsection
