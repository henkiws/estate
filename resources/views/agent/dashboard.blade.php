@extends('layouts.admin')

@section('title', 'Agent Dashboard')

@section('content')

<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-2">
        Welcome back, {{ Auth::user()->name }} 👋
    </h1>
    <p class="text-gray-600">
        @if(auth()->user()->agency)
            {{ auth()->user()->agency->agency_name }}
        @else
            Here's your performance overview.
        @endif
    </p>
</div>

{{-- Statistics Cards --}}
<div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- My Listings -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-primary-light rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </div>
            <span class="text-xs font-semibold text-primary bg-primary-light px-2 py-1 rounded-full">Active</span>
        </div>
        <div class="text-2xl font-bold text-gray-900 mb-1">0</div>
        <div class="text-sm text-gray-600">My Listings</div>
    </div>

    <!-- Total Clients -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
            </div>
            <span class="text-xs font-semibold text-success bg-success/10 px-2 py-1 rounded-full">Total</span>
        </div>
        <div class="text-2xl font-bold text-gray-900 mb-1">0</div>
        <div class="text-sm text-gray-600">Total Clients</div>
    </div>

    <!-- Appointments -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <span class="text-xs font-semibold text-orange-600 bg-orange-100 px-2 py-1 rounded-full">Today</span>
        </div>
        <div class="text-2xl font-bold text-gray-900 mb-1">2</div>
        <div class="text-sm text-gray-600">Appointments</div>
    </div>

    <!-- Commission (MTD) -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <span class="text-xs font-semibold text-gray-600 bg-gray-100 px-2 py-1 rounded-full">MTD</span>
        </div>
        <div class="text-2xl font-bold text-gray-900 mb-1">$0</div>
        <div class="text-sm text-gray-600">Commission</div>
    </div>
</div>

<!-- Two Column Layout -->
<div class="grid lg:grid-cols-3 gap-8">
    <!-- Left Column -->
    <div class="lg:col-span-2 space-y-8">
        
        <!-- Today's Appointments -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
            <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                <h2 class="text-xl font-bold text-gray-900">Today's Appointments</h2>
                <button class="px-4 py-2 bg-primary text-white rounded-lg text-sm font-semibold hover:bg-primary-dark transition-colors">
                    + New Appointment
                </button>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    <!-- Appointment Item 1 -->
                    <div class="flex gap-4 p-4 border border-gray-200 rounded-xl hover:border-primary transition-colors">
                        <div class="flex flex-col items-center justify-center bg-primary-light rounded-lg px-4 py-3 flex-shrink-0">
                            <div class="text-2xl font-bold text-primary">10</div>
                            <div class="text-xs text-primary">AM</div>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-semibold text-gray-900 mb-1">Property Inspection</h3>
                            <p class="text-sm text-gray-600 mb-2">123 Main Street, Sydney NSW</p>
                            <div class="flex items-center gap-4 text-xs text-gray-500">
                                <span class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    John Smith
                                </span>
                                <span>•</span>
                                <span>0412 345 678</span>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <span class="px-3 py-1 bg-green-100 text-green-600 rounded-full text-xs font-semibold">Confirmed</span>
                        </div>
                    </div>

                    <!-- Appointment Item 2 -->
                    <div class="flex gap-4 p-4 border border-gray-200 rounded-xl hover:border-primary transition-colors">
                        <div class="flex flex-col items-center justify-center bg-primary-light rounded-lg px-4 py-3 flex-shrink-0">
                            <div class="text-2xl font-bold text-primary">2</div>
                            <div class="text-xs text-primary">PM</div>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-semibold text-gray-900 mb-1">Client Meeting</h3>
                            <p class="text-sm text-gray-600 mb-2">Office - Contract Signing</p>
                            <div class="flex items-center gap-4 text-xs text-gray-500">
                                <span class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    Sarah Johnson
                                </span>
                                <span>•</span>
                                <span>0423 456 789</span>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <span class="px-3 py-1 bg-yellow-100 text-yellow-600 rounded-full text-xs font-semibold">Pending</span>
                        </div>
                    </div>
                </div>
                <div class="mt-6 text-center">
                    <button class="text-primary hover:text-primary-dark font-semibold text-sm">
                        View All Appointments →
                    </button>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
            <div class="p-6 border-b border-gray-100">
                <h2 class="text-xl font-bold text-gray-900">Recent Activity</h2>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    <!-- Activity Item -->
                    <div class="flex gap-4">
                        <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-900">New listing approved</p>
                            <p class="text-xs text-gray-500">123 Main Street • 2 hours ago</p>
                        </div>
                    </div>

                    <div class="flex gap-4">
                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-900">Appointment scheduled</p>
                            <p class="text-xs text-gray-500">Property inspection with John Smith • 5 hours ago</p>
                        </div>
                    </div>

                    <div class="flex gap-4">
                        <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-900">New client added</p>
                            <p class="text-xs text-gray-500">Sarah Johnson • Yesterday</p>
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
                <button class="w-full flex items-center gap-3 px-4 py-3 bg-primary-light text-primary rounded-xl hover:bg-primary hover:text-white transition-all font-semibold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Add Listing
                </button>
                <button class="w-full flex items-center gap-3 px-4 py-3 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-all font-semibold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                    </svg>
                    Add Client
                </button>
                <button class="w-full flex items-center gap-3 px-4 py-3 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-all font-semibold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Schedule Meeting
                </button>
                <button class="w-full flex items-center gap-3 px-4 py-3 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-all font-semibold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    View Performance
                </button>
            </div>
        </div>

        <!-- This Month's Performance -->
        <div class="bg-gradient-to-br from-primary to-primary-dark rounded-2xl p-6 text-white">
            <h3 class="text-lg font-bold mb-2">This Month</h3>
            <div class="text-3xl font-bold mb-4">$0</div>
            <div class="space-y-3">
                <div class="flex justify-between items-center text-sm">
                    <span class="text-white/80">Listings</span>
                    <span class="font-bold">0</span>
                </div>
                <div class="h-px bg-white/20"></div>
                <div class="flex justify-between items-center text-sm">
                    <span class="text-white/80">Clients</span>
                    <span class="font-bold">0</span>
                </div>
                <div class="h-px bg-white/20"></div>
                <div class="flex justify-between items-center text-sm">
                    <span class="text-white/80">Commission</span>
                    <span class="font-bold">$0</span>
                </div>
            </div>
        </div>

        <!-- Tips & Resources -->
        <div class="bg-purple-50 rounded-2xl p-6 border border-purple-200">
            <h3 class="text-lg font-bold text-purple-900 mb-4">💡 Quick Tips</h3>
            <div class="space-y-3 text-sm text-purple-800">
                <p>• Follow up with leads within 24 hours</p>
                <p>• Keep property photos updated</p>
                <p>• Schedule regular client check-ins</p>
                <p>• Use CRM tools for better tracking</p>
            </div>
            <button class="mt-4 w-full px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition text-sm font-semibold">
                View All Resources
            </button>
        </div>
    </div>
</div>

@endsection