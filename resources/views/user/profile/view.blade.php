@extends('layouts.user')

@section('title', 'My Profile')

@section('content')
<div class="py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">My Profile</h1>
            <p class="mt-2 text-gray-600">View your submitted profile information</p>
        </div>
        
        <!-- Status Badge -->
        <div class="mb-6">
            <div class="bg-white rounded-xl shadow-sm p-6">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div class="flex-1">
                        <h2 class="text-lg font-semibold text-gray-900">Profile Status</h2>
                        <p class="text-sm text-gray-600 mt-1">Current status of your profile application</p>
                    </div>
                    
                    <div>
                        @if($profile->status === 'pending')
                            <div class="bg-yellow-100 text-yellow-800 px-4 py-2 rounded-lg flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                </svg>
                                <span class="font-semibold">Pending Review</span>
                            </div>
                        @elseif($profile->status === 'approved')
                            <div class="bg-green-100 text-green-800 px-4 py-2 rounded-lg flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span class="font-semibold">Approved</span>
                            </div>
                        @elseif($profile->status === 'rejected')
                            <div class="bg-red-100 text-red-800 px-4 py-2 rounded-lg flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                </svg>
                                <span class="font-semibold">Rejected</span>
                            </div>
                        @endif
                    </div>
                </div>
                
                @if($profile->status === 'rejected' && $profile->rejection_reason)
                    <div class="mt-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                        <h4 class="font-semibold text-red-800 mb-2">Rejection Reason:</h4>
                        <p class="text-red-700">{{ $profile->rejection_reason }}</p>
                        <a href="{{ route('user.profile.complete') }}" class="inline-block mt-3 text-red-700 font-semibold hover:text-red-900">
                            Update Profile →
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Personal Details -->
        <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
            <div class="flex items-center mb-6">
                <div class="bg-blue-100 rounded-full p-3 mr-4">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-gray-900">Personal Details</h2>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-gray-50 p-4 rounded-lg">
                    <label class="text-sm text-gray-600">Full Name</label>
                    <p class="font-semibold text-gray-900">{{ $profile->title }} {{ $profile->first_name }} {{ $profile->middle_name }} {{ $profile->last_name }}</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <label class="text-sm text-gray-600">Date of Birth</label>
                    <p class="font-semibold text-gray-900">{{ $profile->date_of_birth?->format('F j, Y') }}</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <label class="text-sm text-gray-600">Email</label>
                    <p class="font-semibold text-gray-900">{{ $profile->email }}</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <label class="text-sm text-gray-600">Mobile</label>
                    <p class="font-semibold text-gray-900">{{ $profile->mobile_country_code }} {{ $profile->mobile_number }}</p>
                </div>
            </div>

            @if($profile->emergency_contact_name)
            <div class="mt-6 border-t pt-6">
                <h3 class="font-semibold text-gray-900 mb-4">Emergency Contact</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <label class="text-sm text-gray-600">Name</label>
                        <p class="font-semibold text-gray-900">{{ $profile->emergency_contact_name }}</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <label class="text-sm text-gray-600">Relationship</label>
                        <p class="font-semibold text-gray-900">{{ $profile->emergency_contact_relationship }}</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <label class="text-sm text-gray-600">Mobile</label>
                        <p class="font-semibold text-gray-900">{{ $profile->emergency_contact_country_code }} {{ $profile->emergency_contact_number }}</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <label class="text-sm text-gray-600">Email</label>
                        <p class="font-semibold text-gray-900">{{ $profile->emergency_contact_email }}</p>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Introduction -->
        @if($profile->introduction)
        <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
            <div class="flex items-center mb-4">
                <div class="bg-purple-100 rounded-full p-3 mr-4">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-gray-900">About Me</h2>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg">
                <p class="text-gray-700 whitespace-pre-wrap">{{ $profile->introduction }}</p>
            </div>
        </div>
        @endif

        <!-- Income Sources -->
        @if($user->incomes->count() > 0)
        <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
            <div class="flex items-center mb-6">
                <div class="bg-green-100 rounded-full p-3 mr-4">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-gray-900">Income Sources</h2>
            </div>
            
            @foreach($user->incomes as $index => $income)
            <div class="bg-gray-50 p-4 rounded-lg mb-4">
                <h3 class="font-semibold text-gray-900 mb-3">Income Source {{ $index + 1 }}</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="text-sm text-gray-600">Source</label>
                        <p class="font-semibold">{{ $income->source }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-600">Weekly Amount</label>
                        <p class="font-semibold">${{ number_format($income->net_weekly_amount, 2) }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-600">Annual Amount</label>
                        <p class="font-semibold">${{ number_format($income->net_annual_amount, 2) }}</p>
                    </div>
                </div>
                @if($income->bank_statement_path)
                <p class="mt-2 text-sm text-green-600">✓ Bank statement uploaded</p>
                @endif
            </div>
            @endforeach
        </div>
        @endif

        <!-- Employment -->
        @if($user->employments->count() > 0)
        <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
            <div class="flex items-center mb-6">
                <div class="bg-blue-100 rounded-full p-3 mr-4">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-gray-900">Employment History</h2>
            </div>
            
            @foreach($user->employments as $index => $employment)
            <div class="bg-gray-50 p-4 rounded-lg mb-4">
                <h3 class="font-semibold text-gray-900 mb-3">{{ $employment->company_name }}</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm text-gray-600">Position</label>
                        <p class="font-semibold">{{ $employment->position }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-600">Salary</label>
                        <p class="font-semibold">${{ number_format($employment->gross_annual_salary, 2) }}/year</p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-600">Start Date</label>
                        <p class="font-semibold">{{ $employment->start_date ? $employment->start_date->format('F Y') : 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-600">End Date</label>
                        <p class="font-semibold">
                            @if($employment->still_employed)
                                <span class="text-green-600">Currently Employed</span>
                            @else
                                {{ $employment->end_date?->format('F Y') }}
                            @endif
                        </p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif

        <!-- Pets -->
        @if($user->pets->count() > 0)
        <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
            <div class="flex items-center mb-6">
                <div class="bg-pink-100 rounded-full p-3 mr-4">
                    <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-gray-900">Pets</h2>
            </div>
            
            @foreach($user->pets as $index => $pet)
            <div class="bg-gray-50 p-4 rounded-lg mb-4">
                <h3 class="font-semibold text-gray-900 mb-3">{{ $pet->name }}</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="text-sm text-gray-600">Type</label>
                        <p class="font-semibold">{{ ucfirst($pet->type) }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-600">Breed</label>
                        <p class="font-semibold">{{ $pet->breed }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-600">Weight</label>
                        <p class="font-semibold">{{ $pet->weight }} kg</p>
                    </div>
                </div>
                @if($pet->description)
                <div class="mt-3">
                    <label class="text-sm text-gray-600">Description</label>
                    <p class="text-gray-700">{{ $pet->description }}</p>
                </div>
                @endif
            </div>
            @endforeach
        </div>
        @endif

        <!-- Vehicles -->
        @if($user->vehicles->count() > 0)
        <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
            <div class="flex items-center mb-6">
                <div class="bg-indigo-100 rounded-full p-3 mr-4">
                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-gray-900">Vehicles</h2>
            </div>
            
            @foreach($user->vehicles as $index => $vehicle)
            <div class="bg-gray-50 p-4 rounded-lg mb-4">
                <h3 class="font-semibold text-gray-900 mb-3">{{ $vehicle->make }} {{ $vehicle->model }}</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="text-sm text-gray-600">Year</label>
                        <p class="font-semibold">{{ $vehicle->year }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-600">Color</label>
                        <p class="font-semibold">{{ $vehicle->color }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-600">Registration</label>
                        <p class="font-semibold">{{ $vehicle->registration_number }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif

        <!-- Address History -->
        @if($user->addresses->count() > 0)
        <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
            <div class="flex items-center mb-6">
                <div class="bg-yellow-100 rounded-full p-3 mr-4">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-gray-900">Address History</h2>
            </div>
            
            @foreach($user->addresses as $index => $address)
            <div class="bg-gray-50 p-4 rounded-lg mb-4">
                <h3 class="font-semibold text-gray-900 mb-3">Address {{ $index + 1 }}</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="md:col-span-2">
                        <label class="text-sm text-gray-600">Address</label>
                        <p class="font-semibold">{{ $address->street_address }}</p>
                        <p class="text-gray-700">{{ $address->suburb }}, {{ $address->state }} {{ $address->postcode }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-600">Moved In</label>
                        <p class="font-semibold">{{ $address->move_in_date ? $address->move_in_date->format('F Y') : 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-600">Moved Out</label>
                        <p class="font-semibold">
                            @if($address->currently_living)
                                <span class="text-green-600">Current Address</span>
                            @else
                                {{ $address->move_out_date?->format('F Y') }}
                            @endif
                        </p>
                    </div>
                </div>
                @if($address->landlord_name)
                <div class="mt-3 pt-3 border-t">
                    <label class="text-sm text-gray-600">Landlord/Agent</label>
                    <p class="font-semibold">{{ $address->landlord_name }}</p>
                    @if($address->landlord_phone)
                    <p class="text-gray-700 text-sm">{{ $address->landlord_phone }}</p>
                    @endif
                </div>
                @endif
            </div>
            @endforeach
        </div>
        @endif

        <!-- References -->
        @if($user->references->count() > 0)
        <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
            <div class="flex items-center mb-6">
                <div class="bg-teal-100 rounded-full p-3 mr-4">
                    <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-gray-900">References</h2>
            </div>
            
            @foreach($user->references as $index => $reference)
            <div class="bg-gray-50 p-4 rounded-lg mb-4">
                <h3 class="font-semibold text-gray-900 mb-3">{{ $reference->name }}</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm text-gray-600">Relationship</label>
                        <p class="font-semibold">{{ $reference->relationship }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-600">Known Duration</label>
                        <p class="font-semibold">{{ $reference->years_known }} years</p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-600">Phone</label>
                        <p class="font-semibold">{{ $reference->phone }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-600">Email</label>
                        <p class="font-semibold">{{ $reference->email }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif

        <!-- ID Documents -->
        @if($user->identifications->count() > 0)
        <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center">
                    <div class="bg-red-100 rounded-full p-3 mr-4">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/>
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold text-gray-900">Identification Documents</h2>
                </div>
                
                <div class="bg-blue-100 text-blue-800 px-4 py-2 rounded-lg">
                    <span class="font-semibold">Total Points: {{ $totalPoints }}</span>
                </div>
            </div>
            
            @foreach($user->identifications as $index => $document)
            <div class="bg-gray-50 p-4 rounded-lg mb-4">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <h3 class="font-semibold text-gray-900">{{ ucfirst(str_replace('_', ' ', $document->document_type)) }}</h3>
                        <p class="text-sm text-gray-600 mt-1">Document Number: {{ $document->document_number }}</p>
                        @if($document->expiry_date)
                        <p class="text-sm text-gray-600">Expires: {{ $document->expiry_date->format('F j, Y') }}</p>
                        @endif
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="bg-blue-100 text-blue-800 px-3 py-1 rounded-lg">
                            <span class="font-semibold text-sm">{{ $document->points }} pts</span>
                        </div>
                        <div class="text-green-600">
                            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif

        <!-- Action Buttons -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex flex-col sm:flex-row gap-4">
                <a href="{{ route('user.dashboard') }}" class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-800 px-6 py-3 rounded-lg font-semibold text-center transition">
                    ← Back to Dashboard
                </a>
                @if($profile->status === 'rejected' || $profile->status === 'incomplete')
                <a href="{{ route('user.profile.complete') }}" class="flex-1 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white px-6 py-3 rounded-lg font-semibold text-center transition">
                    Update Profile
                </a>
                @endif
            </div>
        </div>

        <!-- Help Card -->
        <div class="mt-8 p-6 bg-blue-50 border border-blue-200 rounded-xl">
            <div class="flex items-start gap-4">
                <svg class="w-6 h-6 text-blue-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div>
                    <h4 class="font-semibold text-blue-900 mb-2">Profile Information</h4>
                    <p class="text-sm text-blue-800 mb-3">
                        Your profile information is securely stored and only shared with property managers when you apply for a rental. 
                        All data is encrypted and handled according to privacy regulations.
                    </p>
                    @if($profile->status === 'approved')
                    <p class="text-sm text-green-700 font-semibold">
                        ✓ Your profile has been approved and is ready to use for rental applications.
                    </p>
                    @elseif($profile->status === 'pending')
                    <p class="text-sm text-yellow-700 font-semibold">
                        ⏳ Your profile is currently under review. You'll be notified once it's approved.
                    </p>
                    @endif
                </div>
            </div>
        </div>

    </div>
</div>
@endsection