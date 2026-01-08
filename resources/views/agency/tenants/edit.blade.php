@extends('layouts.admin')

@section('title', 'Edit Tenant')

@section('content')
<div class="py-8">
    <div class="container mx-auto px-4 py-8">
        
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('agency.tenants.show', $tenant) }}" 
               class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-900 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Back to Tenant Details
            </a>
        </div>

        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-plyform-dark">Edit Tenant Information</h1>
            <p class="mt-2 text-gray-600">Update tenant details and lease information</p>
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

        <!-- Validation Errors -->
        @if($errors->any())
            <div class="mb-6 p-4 bg-red-50 border-2 border-red-500 text-red-700 rounded-xl">
                <div class="flex items-center gap-2 mb-2">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                    <strong>Please fix the following errors:</strong>
                </div>
                <ul class="list-disc list-inside space-y-1 text-sm ml-7">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Edit Form -->
        <form method="POST" action="{{ route('agency.tenants.update', $tenant) }}">
            @csrf
            @method('PUT')

            <!-- Personal Information -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
                <h2 class="text-xl font-bold text-plyform-dark mb-6 flex items-center gap-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Personal Information
                </h2>

                <div class="grid md:grid-cols-2 gap-6">
                    <!-- First Name -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            First Name <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="first_name" 
                            value="{{ old('first_name', $tenant->first_name) }}"
                            required
                            maxlength="255"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-yellow focus:border-transparent @error('first_name') border-red-500 @enderror"
                        >
                        @error('first_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Last Name -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Last Name <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="last_name" 
                            value="{{ old('last_name', $tenant->last_name) }}"
                            required
                            maxlength="255"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-yellow focus:border-transparent @error('last_name') border-red-500 @enderror"
                        >
                        @error('last_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="email" 
                            name="email" 
                            value="{{ old('email', $tenant->email) }}"
                            required
                            maxlength="255"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-yellow focus:border-transparent @error('email') border-red-500 @enderror"
                        >
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Phone -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Phone
                        </label>
                        <input 
                            type="text" 
                            name="phone" 
                            value="{{ old('phone', $tenant->phone) }}"
                            maxlength="20"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-yellow focus:border-transparent @error('phone') border-red-500 @enderror"
                        >
                        @error('phone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Date of Birth -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Date of Birth
                        </label>
                        <input 
                            type="date" 
                            name="date_of_birth" 
                            value="{{ old('date_of_birth', $tenant->date_of_birth?->format('Y-m-d')) }}"
                            max="{{ date('Y-m-d') }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-yellow focus:border-transparent @error('date_of_birth') border-red-500 @enderror"
                        >
                        @error('date_of_birth')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Lease Information -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
                <h2 class="text-xl font-bold text-plyform-dark mb-6 flex items-center gap-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Lease Information
                </h2>

                <div class="grid md:grid-cols-2 gap-6">
                    <!-- Lease Start Date -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Lease Start Date <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="date" 
                            name="lease_start_date" 
                            value="{{ old('lease_start_date', $tenant->lease_start_date->format('Y-m-d')) }}"
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-yellow focus:border-transparent @error('lease_start_date') border-red-500 @enderror"
                        >
                        @error('lease_start_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Lease End Date -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Lease End Date <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="date" 
                            name="lease_end_date" 
                            value="{{ old('lease_end_date', $tenant->lease_end_date->format('Y-m-d')) }}"
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-yellow focus:border-transparent @error('lease_end_date') border-red-500 @enderror"
                        >
                        @error('lease_end_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Payment Information -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
                <h2 class="text-xl font-bold text-plyform-dark mb-6 flex items-center gap-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    Payment Information
                </h2>

                <div class="grid md:grid-cols-2 gap-6">
                    <!-- Rent Amount -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Rent Amount <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-4 top-3.5 text-gray-500">$</span>
                            <input 
                                type="number" 
                                name="rent_amount" 
                                value="{{ old('rent_amount', $tenant->rent_amount) }}"
                                required
                                min="0"
                                step="0.01"
                                class="w-full pl-8 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-yellow focus:border-transparent @error('rent_amount') border-red-500 @enderror"
                            >
                        </div>
                        @error('rent_amount')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Payment Frequency -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Payment Frequency <span class="text-red-500">*</span>
                        </label>
                        <select 
                            name="payment_frequency" 
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-yellow focus:border-transparent @error('payment_frequency') border-red-500 @enderror"
                        >
                            <option value="weekly" {{ old('payment_frequency', $tenant->payment_frequency) === 'weekly' ? 'selected' : '' }}>Weekly</option>
                            <option value="fortnightly" {{ old('payment_frequency', $tenant->payment_frequency) === 'fortnightly' ? 'selected' : '' }}>Fortnightly</option>
                            <option value="monthly" {{ old('payment_frequency', $tenant->payment_frequency) === 'monthly' ? 'selected' : '' }}>Monthly</option>
                        </select>
                        @error('payment_frequency')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Bond Amount -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Bond Amount <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-4 top-3.5 text-gray-500">$</span>
                            <input 
                                type="number" 
                                name="bond_amount" 
                                value="{{ old('bond_amount', $tenant->bond_amount) }}"
                                required
                                min="0"
                                step="0.01"
                                class="w-full pl-8 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-yellow focus:border-transparent @error('bond_amount') border-red-500 @enderror"
                            >
                        </div>
                        @error('bond_amount')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Emergency Contact -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
                <h2 class="text-xl font-bold text-plyform-dark mb-6 flex items-center gap-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                    Emergency Contact
                </h2>

                <div class="grid md:grid-cols-2 gap-6">
                    <!-- Emergency Contact Name -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Contact Name
                        </label>
                        <input 
                            type="text" 
                            name="emergency_contact_name" 
                            value="{{ old('emergency_contact_name', $tenant->emergency_contact_name) }}"
                            maxlength="255"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-yellow focus:border-transparent @error('emergency_contact_name') border-red-500 @enderror"
                        >
                        @error('emergency_contact_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Emergency Contact Phone -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Contact Phone
                        </label>
                        <input 
                            type="text" 
                            name="emergency_contact_phone" 
                            value="{{ old('emergency_contact_phone', $tenant->emergency_contact_phone) }}"
                            maxlength="20"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-yellow focus:border-transparent @error('emergency_contact_phone') border-red-500 @enderror"
                        >
                        @error('emergency_contact_phone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Emergency Contact Relationship -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Relationship
                        </label>
                        <input 
                            type="text" 
                            name="emergency_contact_relationship" 
                            value="{{ old('emergency_contact_relationship', $tenant->emergency_contact_relationship) }}"
                            maxlength="100"
                            placeholder="e.g., Parent, Sibling, Friend"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-yellow focus:border-transparent @error('emergency_contact_relationship') border-red-500 @enderror"
                        >
                        @error('emergency_contact_relationship')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Notes -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
                <h2 class="text-xl font-bold text-plyform-dark mb-6 flex items-center gap-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                    </svg>
                    Notes
                </h2>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Internal Notes
                    </label>
                    <textarea 
                        name="notes" 
                        rows="5"
                        maxlength="5000"
                        placeholder="Add any internal notes about this tenant..."
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-yellow focus:border-transparent @error('notes') border-red-500 @enderror"
                    >{{ old('notes', $tenant->notes) }}</textarea>
                    <p class="mt-1 text-xs text-gray-500">Maximum 5000 characters. These notes are internal and not visible to the tenant.</p>
                    @error('notes')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="flex items-center justify-between">
                <a 
                    href="{{ route('agency.tenants.show', $tenant) }}" 
                    class="px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 transition"
                >
                    Cancel
                </a>
                
                <button 
                    type="submit" 
                    class="px-8 py-3 bg-plyform-yellow text-plyform-dark font-semibold rounded-lg hover:bg-plyform-yellow/80 transition shadow-sm"
                >
                    <span class="flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Update Tenant
                    </span>
                </button>
            </div>

        </form>

    </div>
</div>
@endsection