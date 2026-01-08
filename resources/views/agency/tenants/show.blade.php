@extends('layouts.admin')

@section('title', 'Tenant Details')

@section('content')
<div class="py-8">
    <div class="container mx-auto px-4 py-8">
        
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('agency.tenants.index') }}" 
               class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-900 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Back to Tenants
            </a>
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

        <div class="grid lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- Tenant Header -->
                <div class="bg-gradient-to-r from-plyform-yellow to-plyform-mint rounded-xl shadow-sm p-6 text-plyform-dark">
                    <div class="flex items-start justify-between gap-4 mb-4">
                        <div class="flex items-center gap-4">
                            <div class="w-16 h-16 bg-white/30 backdrop-blur rounded-full flex items-center justify-center">
                                <span class="text-2xl font-bold">{{ strtoupper(substr($tenant->first_name, 0, 1) . substr($tenant->last_name, 0, 1)) }}</span>
                            </div>
                            <div>
                                <h1 class="text-2xl font-bold">{{ $tenant->full_name }}</h1>
                                <p class="text-sm opacity-90">{{ $tenant->tenant_code }}</p>
                            </div>
                        </div>
                        
                        <span class="px-4 py-2 text-sm font-semibold rounded-full text-white {{ $tenant->status === 'active' ? 'bg-green-500' : ($tenant->status === 'pending_move_in' ? 'bg-yellow-500' : 'bg-gray-500') }}">
                            {{ $tenant->status_label }}
                        </span>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                        <div>
                            <p class="opacity-75">Lease Start</p>
                            <p class="font-semibold">{{ $tenant->lease_start_date->format('M d, Y') }}</p>
                        </div>
                        <div>
                            <p class="opacity-75">Lease End</p>
                            <p class="font-semibold">{{ $tenant->lease_end_date->format('M d, Y') }}</p>
                        </div>
                        <div>
                            <p class="opacity-75">Rent</p>
                            <p class="font-semibold">{{ $tenant->formatted_rent }}</p>
                        </div>
                        <div>
                            <p class="opacity-75">Bond</p>
                            <p class="font-semibold">${{ number_format($tenant->bond_amount, 0) }}</p>
                        </div>
                    </div>
                </div>

                <!-- Property Information -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h2 class="text-xl font-bold text-plyform-dark mb-4 flex items-center gap-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                        Rental Property
                    </h2>

                    <div class="flex gap-4">
                        @if($tenant->property->images->count() > 0)
                            <img 
                                src="{{ Storage::url($tenant->property->images->first()->image_path) }}" 
                                alt="{{ $tenant->property->headline }}"
                                class="w-32 h-32 object-cover rounded-lg"
                            >
                        @else
                            <div class="w-32 h-32 bg-gray-100 rounded-lg flex items-center justify-center">
                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                            </div>
                        @endif

                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-plyform-dark mb-2">{{ $tenant->property->headline }}</h3>
                            <p class="text-gray-600 mb-2">{{ $tenant->property->full_address }}</p>
                            
                            <div class="flex items-center gap-4 text-sm text-gray-600">
                                <span class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                    </svg>
                                    {{ $tenant->property->bedrooms }} bed
                                </span>
                                <span class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"/>
                                    </svg>
                                    {{ $tenant->property->bathrooms }} bath
                                </span>
                                <span class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"/>
                                    </svg>
                                    {{ $tenant->property->parking_spaces }} parking
                                </span>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('properties.show', $tenant->property->public_url_code) }}" 
                       target="_blank"
                       class="mt-4 inline-flex items-center gap-2 text-plyform-purple hover:text-plyform-dark transition font-medium">
                        View Property Listing
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                        </svg>
                    </a>
                </div>

                <!-- Personal Information -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h2 class="text-xl font-bold text-plyform-dark mb-4 flex items-center gap-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        Personal Information
                    </h2>

                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Full Name</p>
                            <p class="font-medium text-gray-900">{{ $tenant->full_name }}</p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-600 mb-1">Email</p>
                            <a href="mailto:{{ $tenant->email }}" class="font-medium text-plyform-purple hover:text-plyform-dark">
                                {{ $tenant->email }}
                            </a>
                        </div>

                        @if($tenant->phone)
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Phone</p>
                            <a href="tel:{{ $tenant->phone }}" class="font-medium text-plyform-purple hover:text-plyform-dark">
                                {{ $tenant->phone }}
                            </a>
                        </div>
                        @endif

                        @if($tenant->date_of_birth)
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Date of Birth</p>
                            <p class="font-medium text-gray-900">{{ $tenant->date_of_birth->format('F d, Y') }}</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Lease Information -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h2 class="text-xl font-bold text-plyform-dark mb-4 flex items-center gap-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Lease Details
                    </h2>

                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Lease Start Date</p>
                            <p class="font-medium text-gray-900">{{ $tenant->lease_start_date->format('F d, Y') }}</p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-600 mb-1">Lease End Date</p>
                            <p class="font-medium text-gray-900">{{ $tenant->lease_end_date->format('F d, Y') }}</p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-600 mb-1">Lease Term</p>
                            <p class="font-medium text-gray-900">{{ $tenant->lease_term_months }} months</p>
                        </div>

                        @if($tenant->days_until_lease_end !== null)
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Days Until Lease End</p>
                            <p class="font-medium {{ $tenant->is_lease_expiring_soon ? 'text-red-600' : 'text-gray-900' }}">
                                {{ abs($tenant->days_until_lease_end) }} days
                                @if($tenant->days_until_lease_end < 0)
                                    (Expired)
                                @endif
                            </p>
                        </div>
                        @endif

                        @if($tenant->lease_signed_at)
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Lease Signed</p>
                            <p class="font-medium text-gray-900">{{ $tenant->lease_signed_at->format('F d, Y g:i A') }}</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Payment Information -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h2 class="text-xl font-bold text-plyform-dark mb-4 flex items-center gap-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        Payment Information
                    </h2>

                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Rent Amount</p>
                            <p class="font-medium text-gray-900 text-lg">${{ number_format($tenant->rent_amount, 2) }}</p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-600 mb-1">Payment Frequency</p>
                            <p class="font-medium text-gray-900">{{ ucfirst($tenant->payment_frequency) }}</p>
                        </div>

                        @if($tenant->next_payment_due)
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Next Payment Due</p>
                            <p class="font-medium {{ $tenant->isRentOverdue() ? 'text-red-600' : 'text-gray-900' }}">
                                {{ $tenant->next_payment_due->format('F d, Y') }}
                                @if($tenant->isRentOverdue())
                                    <span class="text-xs">({{ $tenant->days_overdue }} days overdue)</span>
                                @endif
                            </p>
                        </div>
                        @endif

                        <div>
                            <p class="text-sm text-gray-600 mb-1">Bond Amount</p>
                            <p class="font-medium text-gray-900">${{ number_format($tenant->bond_amount, 2) }}</p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-600 mb-1">Bond Status</p>
                            <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $tenant->bond_paid ? 'bg-green-100 text-green-700' : 'bg-orange-100 text-orange-700' }}">
                                {{ $tenant->bond_paid ? 'Paid' : 'Unpaid' }}
                            </span>
                        </div>

                        @if($tenant->bond_paid && $tenant->bond_paid_date)
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Bond Paid Date</p>
                            <p class="font-medium text-gray-900">{{ $tenant->bond_paid_date->format('F d, Y') }}</p>
                        </div>
                        @endif

                        @if($tenant->bond_reference)
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Bond Reference</p>
                            <p class="font-medium text-gray-900">{{ $tenant->bond_reference }}</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Emergency Contact -->
                @if($tenant->emergency_contact_name || $tenant->emergency_contact_phone)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h2 class="text-xl font-bold text-plyform-dark mb-4 flex items-center gap-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        Emergency Contact
                    </h2>

                    <div class="grid md:grid-cols-2 gap-6">
                        @if($tenant->emergency_contact_name)
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Name</p>
                            <p class="font-medium text-gray-900">{{ $tenant->emergency_contact_name }}</p>
                        </div>
                        @endif

                        @if($tenant->emergency_contact_phone)
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Phone</p>
                            <a href="tel:{{ $tenant->emergency_contact_phone }}" class="font-medium text-plyform-purple hover:text-plyform-dark">
                                {{ $tenant->emergency_contact_phone }}
                            </a>
                        </div>
                        @endif

                        @if($tenant->emergency_contact_relationship)
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Relationship</p>
                            <p class="font-medium text-gray-900">{{ $tenant->emergency_contact_relationship }}</p>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Additional Occupants -->
                @if($tenant->additional_occupants && count($tenant->additional_occupants) > 0)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h2 class="text-xl font-bold text-plyform-dark mb-4 flex items-center gap-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        Additional Occupants ({{ count($tenant->additional_occupants) }})
                    </h2>

                    <div class="space-y-4">
                        @foreach($tenant->additional_occupants as $index => $occupant)
                            <div class="p-4 {{ $index === 0 ? 'bg-teal-50 border-2 border-teal-200' : 'bg-gray-50 border border-gray-200' }} rounded-lg">
                                <div class="flex items-center gap-3 mb-3">
                                    <div class="w-10 h-10 bg-gradient-to-br from-plyform-yellow to-plyform-mint rounded-full flex items-center justify-center">
                                        <span class="text-sm font-bold text-plyform-dark">
                                            {{ strtoupper(substr($occupant['first_name'] ?? '', 0, 1) . substr($occupant['last_name'] ?? '', 0, 1)) }}
                                        </span>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-plyform-dark">
                                            {{ $occupant['first_name'] ?? '' }} {{ $occupant['last_name'] ?? '' }}
                                            @if($index === 0)
                                                <span class="ml-2 px-2 py-1 text-xs bg-teal-600 text-white rounded-full">Primary</span>
                                            @endif
                                        </h4>
                                        <p class="text-sm text-gray-600">{{ $occupant['relationship'] ?? 'N/A' }}</p>
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-4 text-sm">
                                    @if(isset($occupant['age']) && $occupant['age'])
                                        <div>
                                            <span class="text-gray-600">Age:</span>
                                            <span class="font-medium text-gray-900 ml-2">{{ $occupant['age'] }} years</span>
                                        </div>
                                    @endif
                                    @if(isset($occupant['email']) && $occupant['email'])
                                        <div>
                                            <span class="text-gray-600">Email:</span>
                                            <a href="mailto:{{ $occupant['email'] }}" class="font-medium text-plyform-purple hover:text-plyform-dark ml-2">
                                                {{ $occupant['email'] }}
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Notes -->
                @if($tenant->notes)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h2 class="text-xl font-bold text-plyform-dark mb-4 flex items-center gap-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                        </svg>
                        Notes
                    </h2>
                    <p class="text-gray-600 whitespace-pre-wrap">{{ $tenant->notes }}</p>
                </div>
                @endif

            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                
                <!-- Quick Actions -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-bold text-plyform-dark mb-4">Quick Actions</h3>

                    <div class="space-y-3">
                        <a href="{{ route('agency.tenants.edit', $tenant) }}" 
                           class="w-full px-4 py-3 bg-plyform-yellow text-plyform-dark font-semibold rounded-lg hover:bg-plyform-yellow/80 transition flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Edit Tenant Info
                        </a>

                        @if($tenant->status === 'pending_move_in')
                            <form action="{{ route('agency.tenants.move-in', $tenant) }}" method="POST">
                                @csrf
                                <button type="submit" 
                                        class="w-full px-4 py-3 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition flex items-center justify-center gap-2"
                                        onclick="return confirm('Mark this tenant as moved in?')">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Mark as Moved In
                                </button>
                            </form>
                        @endif

                        @if(in_array($tenant->status, ['pending_move_in', 'active']))
                            <button 
                                onclick="openGiveNoticeModal()"
                                class="w-full px-4 py-3 bg-orange-600 text-white font-semibold rounded-lg hover:bg-orange-700 transition flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                                Give Notice to Vacate
                            </button>
                        @endif

                        @if(!$tenant->bond_paid && in_array($tenant->status, ['pending_move_in', 'active', 'notice_given']))
                            <button 
                                onclick="openBondPaidModal()"
                                class="w-full px-4 py-3 bg-teal-600 text-white font-semibold rounded-lg hover:bg-teal-700 transition flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Mark Bond as Paid
                            </button>
                        @endif

                        @if($tenant->status === 'active' && $tenant->next_payment_due)
                            <form action="{{ route('agency.tenants.update-payment-due', $tenant) }}" method="POST">
                                @csrf
                                <button type="submit" 
                                        class="w-full px-4 py-3 bg-purple-600 text-white font-semibold rounded-lg hover:bg-purple-700 transition flex items-center justify-center gap-2"
                                        onclick="return confirm('Update next payment due date?')">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    Update Payment Due
                                </button>
                            </form>
                        @endif

                        @if(in_array($tenant->status, ['notice_given', 'ending']))
                            <form action="{{ route('agency.tenants.move-out', $tenant) }}" method="POST">
                                @csrf
                                <button type="submit" 
                                        class="w-full px-4 py-3 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition flex items-center justify-center gap-2"
                                        onclick="return confirm('Mark this tenant as moved out? This will end the tenancy.')">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                    </svg>
                                    Mark as Moved Out
                                </button>
                            </form>
                        @endif
                    </div>
                </div>

                <!-- Contact Tenant -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-bold text-plyform-dark mb-4">Contact Tenant</h3>

                    <div class="space-y-3">
                        <a href="mailto:{{ $tenant->email }}" 
                           class="flex items-center gap-3 p-3 bg-gray-50 hover:bg-gray-100 rounded-lg transition">
                            <div class="p-2 bg-plyform-purple/10 rounded-lg">
                                <svg class="w-5 h-5 text-plyform-purple" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900">Email</p>
                                <p class="text-xs text-gray-600 truncate">{{ $tenant->email }}</p>
                            </div>
                        </a>

                        @if($tenant->phone)
                            <a href="tel:{{ $tenant->phone }}" 
                               class="flex items-center gap-3 p-3 bg-gray-50 hover:bg-gray-100 rounded-lg transition">
                                <div class="p-2 bg-plyform-purple/10 rounded-lg">
                                    <svg class="w-5 h-5 text-plyform-purple" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900">Phone</p>
                                    <p class="text-xs text-gray-600">{{ $tenant->phone }}</p>
                                </div>
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Timeline -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-bold text-plyform-dark mb-4">Timeline</h3>

                    <div class="space-y-4">
                        @if($tenant->moved_out_at)
                            <div class="flex gap-3">
                                <div class="p-2 bg-gray-100 rounded-lg h-fit">
                                    <svg class="w-4 h-4 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Moved Out</p>
                                    <p class="text-xs text-gray-600">{{ $tenant->moved_out_at->format('M d, Y') }}</p>
                                </div>
                            </div>
                        @endif

                        @if($tenant->notice_given_date)
                            <div class="flex gap-3">
                                <div class="p-2 bg-orange-100 rounded-lg h-fit">
                                    <svg class="w-4 h-4 text-plyform-orange" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Notice Given</p>
                                    <p class="text-xs text-gray-600">{{ $tenant->notice_given_date->format('M d, Y') }}</p>
                                    @if($tenant->intended_vacate_date)
                                        <p class="text-xs text-gray-500">Vacate: {{ $tenant->intended_vacate_date->format('M d, Y') }}</p>
                                    @endif
                                </div>
                            </div>
                        @endif

                        @if($tenant->moved_in_at)
                            <div class="flex gap-3">
                                <div class="p-2 bg-green-100 rounded-lg h-fit">
                                    <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-green-700">Moved In</p>
                                    <p class="text-xs text-gray-600">{{ $tenant->moved_in_at->format('M d, Y') }}</p>
                                </div>
                            </div>
                        @endif

                        @if($tenant->lease_signed_at)
                            <div class="flex gap-3">
                                <div class="p-2 bg-blue-100 rounded-lg h-fit">
                                    <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v3.586l-1.293-1.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V8z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Lease Signed</p>
                                    <p class="text-xs text-gray-600">{{ $tenant->lease_signed_at->format('M d, Y g:i A') }}</p>
                                </div>
                            </div>
                        @endif

                        <div class="flex gap-3">
                            <div class="p-2 bg-gray-100 rounded-lg h-fit">
                                <svg class="w-4 h-4 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Tenant Created</p>
                                <p class="text-xs text-gray-600">{{ $tenant->created_at->format('M d, Y g:i A') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Related Application -->
                @if($tenant->application)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-bold text-plyform-dark mb-4">Related Application</h3>
                    <a href="{{ route('agency.applications.show', $tenant->application) }}" 
                       class="flex items-center gap-3 p-3 bg-gray-50 hover:bg-gray-100 rounded-lg transition">
                        <div class="p-2 bg-plyform-purple/10 rounded-lg">
                            <svg class="w-5 h-5 text-plyform-purple" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900">View Application</p>
                            <p class="text-xs text-gray-600">Application #{{ $tenant->application->id }}</p>
                        </div>
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
                @endif

            </div>
        </div>

    </div>
</div>

<!-- Give Notice Modal -->
<div id="giveNoticeModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-xl font-bold text-plyform-dark">Give Notice to Vacate</h3>
            <button onclick="closeGiveNoticeModal()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <form action="{{ route('agency.tenants.give-notice', $tenant) }}" method="POST">
            @csrf
            
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Intended Vacate Date <span class="text-red-500">*</span>
                </label>
                <input 
                    type="date" 
                    name="intended_vacate_date" 
                    required
                    min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-yellow focus:border-transparent"
                >
                <p class="mt-1 text-xs text-gray-500">When does the tenant intend to vacate the property?</p>
            </div>

            <div class="flex gap-3">
                <button 
                    type="button"
                    onclick="closeGiveNoticeModal()"
                    class="flex-1 px-4 py-3 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 transition">
                    Cancel
                </button>
                <button 
                    type="submit"
                    class="flex-1 px-4 py-3 bg-orange-600 text-white font-semibold rounded-lg hover:bg-orange-700 transition">
                    Record Notice
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Mark Bond Paid Modal -->
<div id="bondPaidModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-xl font-bold text-plyform-dark">Mark Bond as Paid</h3>
            <button onclick="closeBondPaidModal()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <form action="{{ route('agency.tenants.mark-bond-paid', $tenant) }}" method="POST">
            @csrf
            
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Bond Amount
                </label>
                <p class="text-2xl font-bold text-plyform-dark mb-4">${{ number_format($tenant->bond_amount, 2) }}</p>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Payment Date
                </label>
                <input 
                    type="date" 
                    name="bond_paid_date" 
                    value="{{ date('Y-m-d') }}"
                    max="{{ date('Y-m-d') }}"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-yellow focus:border-transparent"
                >
            </div>

            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Bond Reference (Optional)
                </label>
                <input 
                    type="text" 
                    name="bond_reference" 
                    maxlength="255"
                    placeholder="e.g., Transaction ID, Receipt number"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-yellow focus:border-transparent"
                >
            </div>

            <div class="flex gap-3">
                <button 
                    type="button"
                    onclick="closeBondPaidModal()"
                    class="flex-1 px-4 py-3 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 transition">
                    Cancel
                </button>
                <button 
                    type="submit"
                    class="flex-1 px-4 py-3 bg-teal-600 text-white font-semibold rounded-lg hover:bg-teal-700 transition">
                    Mark as Paid
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openGiveNoticeModal() {
    document.getElementById('giveNoticeModal').classList.remove('hidden');
}

function closeGiveNoticeModal() {
    document.getElementById('giveNoticeModal').classList.add('hidden');
}

function openBondPaidModal() {
    document.getElementById('bondPaidModal').classList.remove('hidden');
}

function closeBondPaidModal() {
    document.getElementById('bondPaidModal').classList.add('hidden');
}

// Close modals when clicking outside
document.getElementById('giveNoticeModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeGiveNoticeModal();
    }
});

document.getElementById('bondPaidModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeBondPaidModal();
    }
});
</script>
@endsection