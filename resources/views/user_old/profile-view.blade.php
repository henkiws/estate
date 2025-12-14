@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-purple-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header with Status -->
        <div class="mb-8">
            <div class="flex items-center justify-between flex-wrap gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">My Profile</h1>
                    <p class="mt-2 text-gray-600">Review your submitted profile information - All 10 Steps</p>
                </div>
                
                <!-- Status Badge -->
                <div>
                    @if($profile->status === 'pending')
                        <span class="inline-flex items-center px-6 py-3 rounded-full text-sm font-semibold bg-yellow-100 text-yellow-800">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                            </svg>
                            Pending Review
                        </span>
                    @elseif($profile->status === 'approved')
                        <span class="inline-flex items-center px-6 py-3 rounded-full text-sm font-semibold bg-green-100 text-green-800">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            Approved
                        </span>
                    @elseif($profile->status === 'rejected')
                        <span class="inline-flex items-center px-6 py-3 rounded-full text-sm font-semibold bg-red-100 text-red-800">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                            Update Required
                        </span>
                    @endif
                </div>
            </div>

            <!-- Rejection Reason Alert -->
            @if($profile->status === 'rejected' && $profile->rejection_reason)
                <div class="mt-6 bg-red-50 border-l-4 border-red-500 p-6 rounded-lg">
                    <div class="flex items-start">
                        <svg class="w-6 h-6 text-red-500 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-red-900 mb-2">Profile Update Required</h3>
                            <p class="text-red-800">{{ $profile->rejection_reason }}</p>
                            <div class="mt-4">
                                <a href="{{ route('user.profile.complete') }}" class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition">
                                    Update Profile Now
                                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Approval Success Alert -->
            @if($profile->status === 'approved')
                <div class="mt-6 bg-green-50 border-l-4 border-green-500 p-6 rounded-lg">
                    <div class="flex items-start">
                        <svg class="w-6 h-6 text-green-500 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-green-900 mb-2">Profile Approved!</h3>
                            <p class="text-green-800">Your profile has been verified. You can now apply for properties.</p>
                            <div class="mt-4 flex gap-3 flex-wrap">
                                <a href="{{ route('properties.index') }}" class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg transition">
                                    Browse Properties
                                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                    </svg>
                                </a>
                                <a href="{{ route('user.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-white border-2 border-green-600 text-green-600 hover:bg-green-50 font-semibold rounded-lg transition">
                                    Go to Dashboard
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Progress Steps Indicator -->
        <div class="bg-white rounded-2xl shadow-lg p-6 mb-8">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Profile Completion - 10 Steps</h3>
            <div class="grid grid-cols-5 md:grid-cols-10 gap-3">
                @foreach([
                    'Personal',
                    'Introduction',
                    'Income',
                    'Employment',
                    'Pets',
                    'Vehicles',
                    'Address',
                    'References',
                    'ID',
                    'Terms'
                ] as $index => $label)
                    <div class="flex flex-col items-center">
                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 text-white flex items-center justify-center font-bold mb-2 shadow-lg">
                            {{ $index + 1 }}
                        </div>
                        <span class="text-xs text-gray-600 text-center">{{ $label }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Left Column - Main Information -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- STEP 1: Personal Details -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden border-l-4 border-blue-500">
                    <div class="bg-gradient-to-r from-blue-500 to-purple-600 px-6 py-4">
                        <h2 class="text-xl font-bold text-white flex items-center">
                            <span class="bg-white text-blue-600 rounded-full w-8 h-8 flex items-center justify-center mr-3 font-bold">1</span>
                            Personal Details
                        </h2>
                    </div>
                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="text-sm font-semibold text-gray-600">Title</label>
                            <p class="mt-1 text-gray-900">{{ $profile->title }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-semibold text-gray-600">First Name</label>
                            <p class="mt-1 text-gray-900">{{ $profile->first_name }}</p>
                        </div>
                        @if($profile->middle_name)
                        <div>
                            <label class="text-sm font-semibold text-gray-600">Middle Name</label>
                            <p class="mt-1 text-gray-900">{{ $profile->middle_name }}</p>
                        </div>
                        @endif
                        <div>
                            <label class="text-sm font-semibold text-gray-600">Last Name</label>
                            <p class="mt-1 text-gray-900">{{ $profile->last_name }}</p>
                        </div>
                        @if($profile->surname)
                        <div>
                            <label class="text-sm font-semibold text-gray-600">Surname</label>
                            <p class="mt-1 text-gray-900">{{ $profile->surname }}</p>
                        </div>
                        @endif
                        <div>
                            <label class="text-sm font-semibold text-gray-600">Email</label>
                            <p class="mt-1 text-gray-900">{{ $profile->email }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-semibold text-gray-600">Mobile</label>
                            <p class="mt-1 text-gray-900">{{ $profile->mobile_country_code }} {{ $profile->mobile_number }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-semibold text-gray-600">Date of Birth</label>
                            <p class="mt-1 text-gray-900">{{ \Carbon\Carbon::parse($profile->date_of_birth)->format('F j, Y') }}</p>
                        </div>
                        <div class="md:col-span-2">
                            <label class="text-sm font-semibold text-gray-600">Emergency Contact</label>
                            <p class="mt-1 text-gray-900">
                                {{ $profile->emergency_contact_name }} ({{ $profile->emergency_contact_relationship }})<br>
                                {{ $profile->emergency_contact_country_code }} {{ $profile->emergency_contact_number }}<br>
                                {{ $profile->emergency_contact_email }}
                            </p>
                        </div>
                        @if($profile->has_guarantor)
                        <div class="md:col-span-2 bg-blue-50 rounded-lg p-4">
                            <label class="text-sm font-semibold text-blue-900 block mb-2">Guarantor Information</label>
                            <p class="text-gray-900">
                                {{ $profile->guarantor_name }}<br>
                                {{ $profile->guarantor_country_code }} {{ $profile->guarantor_number }}<br>
                                {{ $profile->guarantor_email }}
                            </p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- STEP 2: Introduction -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden border-l-4 border-purple-500">
                    <div class="bg-gradient-to-r from-purple-500 to-pink-600 px-6 py-4">
                        <h2 class="text-xl font-bold text-white flex items-center">
                            <span class="bg-white text-purple-600 rounded-full w-8 h-8 flex items-center justify-center mr-3 font-bold">2</span>
                            Introduction / About Me
                        </h2>
                    </div>
                    <div class="p-6">
                        @if($profile->introduction)
                            <p class="text-gray-900 leading-relaxed">{{ $profile->introduction }}</p>
                        @else
                            <p class="text-gray-500 italic">No introduction provided</p>
                        @endif
                    </div>
                </div>

                <!-- STEP 3: Income Sources -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden border-l-4 border-green-500">
                    <div class="bg-gradient-to-r from-green-500 to-emerald-600 px-6 py-4">
                        <h2 class="text-xl font-bold text-white flex items-center">
                            <span class="bg-white text-green-600 rounded-full w-8 h-8 flex items-center justify-center mr-3 font-bold">3</span>
                            Income Sources
                        </h2>
                    </div>
                    <div class="p-6 space-y-4">
                        @forelse($user->incomes as $index => $income)
                            <div class="bg-gray-50 rounded-xl p-4">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <h3 class="font-semibold text-gray-900">{{ $income->source_of_income }}</h3>
                                        <p class="text-2xl font-bold text-green-600 mt-2">${{ number_format($income->net_weekly_amount, 2) }} <span class="text-sm text-gray-500">per week</span></p>
                                        @if($income->bank_statement_path)
                                            <a href="{{ Storage::url($income->bank_statement_path) }}" target="_blank" class="inline-flex items-center mt-2 text-sm text-blue-600 hover:text-blue-800">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
                                                </svg>
                                                View Bank Statement
                                            </a>
                                        @endif
                                    </div>
                                    <span class="ml-4 px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-semibold">
                                        #{{ $index + 1 }}
                                    </span>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500 text-center py-4">No income sources added</p>
                        @endforelse
                    </div>
                </div>

                <!-- STEP 4: Employment History -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden border-l-4 border-indigo-500">
                    <div class="bg-gradient-to-r from-indigo-500 to-blue-600 px-6 py-4">
                        <h2 class="text-xl font-bold text-white flex items-center">
                            <span class="bg-white text-indigo-600 rounded-full w-8 h-8 flex items-center justify-center mr-3 font-bold">4</span>
                            Employment History
                        </h2>
                    </div>
                    <div class="p-6 space-y-6">
                        @forelse($user->employments as $index => $employment)
                            <div class="border-l-4 border-indigo-500 pl-4 py-2 bg-gray-50 rounded-r-lg">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <h3 class="font-semibold text-lg text-gray-900">{{ $employment->position }}</h3>
                                        <p class="text-gray-600">{{ $employment->company_name }}</p>
                                        <p class="text-sm text-gray-500 mt-1">{{ $employment->address }}</p>
                                        <p class="text-sm text-gray-500 mt-1">
                                            {{ \Carbon\Carbon::parse($employment->start_date)->format('M Y') }} - 
                                            @if($employment->still_employed)
                                                <span class="text-green-600 font-semibold">Current</span>
                                            @else
                                                {{ \Carbon\Carbon::parse($employment->end_date)->format('M Y') }}
                                            @endif
                                        </p>
                                        <p class="text-lg font-bold text-indigo-600 mt-2">${{ number_format($employment->gross_annual_salary, 2) }} <span class="text-sm text-gray-500">per year</span></p>
                                        <p class="text-sm text-gray-600 mt-2">
                                            <strong>Manager:</strong> {{ $employment->manager_full_name }}<br>
                                            <strong>Contact:</strong> {{ $employment->contact_number }} | {{ $employment->email }}
                                        </p>
                                        @if($employment->employment_letter_path)
                                            <a href="{{ Storage::url($employment->employment_letter_path) }}" target="_blank" class="inline-flex items-center mt-2 text-sm text-blue-600 hover:text-blue-800">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
                                                </svg>
                                                View Employment Letter
                                            </a>
                                        @endif
                                    </div>
                                    <span class="ml-4 px-3 py-1 bg-indigo-100 text-indigo-800 rounded-full text-sm font-semibold">
                                        #{{ $index + 1 }}
                                    </span>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500 text-center py-4">No employment history added</p>
                        @endforelse
                    </div>
                </div>

                <!-- STEP 5: Pets -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden border-l-4 border-pink-500">
                    <div class="bg-gradient-to-r from-pink-500 to-rose-600 px-6 py-4">
                        <h2 class="text-xl font-bold text-white flex items-center">
                            <span class="bg-white text-pink-600 rounded-full w-8 h-8 flex items-center justify-center mr-3 font-bold">5</span>
                            Pets
                        </h2>
                    </div>
                    <div class="p-6 space-y-4">
                        @forelse($user->pets as $index => $pet)
                            <div class="bg-gray-50 rounded-xl p-4">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <h3 class="font-semibold text-gray-900 capitalize">{{ $pet->type }} - {{ $pet->breed }}</h3>
                                        <div class="mt-2 grid grid-cols-2 gap-3 text-sm">
                                            <div>
                                                <span class="text-gray-600">Desexed:</span>
                                                <span class="text-gray-900 font-medium ml-2 capitalize">{{ $pet->desexed }}</span>
                                            </div>
                                            <div>
                                                <span class="text-gray-600">Size:</span>
                                                <span class="text-gray-900 font-medium ml-2 capitalize">{{ $pet->size }}</span>
                                            </div>
                                            @if($pet->registration_number)
                                            <div class="col-span-2">
                                                <span class="text-gray-600">Registration:</span>
                                                <span class="text-gray-900 font-mono font-medium ml-2">{{ $pet->registration_number }}</span>
                                            </div>
                                            @endif
                                        </div>
                                        @if($pet->document_path)
                                            <a href="{{ Storage::url($pet->document_path) }}" target="_blank" class="inline-flex items-center mt-2 text-sm text-blue-600 hover:text-blue-800">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
                                                </svg>
                                                View Pet Document
                                            </a>
                                        @endif
                                    </div>
                                    <span class="ml-4 px-3 py-1 bg-pink-100 text-pink-800 rounded-full text-sm font-semibold">
                                        #{{ $index + 1 }}
                                    </span>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500 text-center py-4">No pets registered</p>
                        @endforelse
                    </div>
                </div>

                <!-- STEP 6: Vehicles -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden border-l-4 border-cyan-500">
                    <div class="bg-gradient-to-r from-cyan-500 to-blue-600 px-6 py-4">
                        <h2 class="text-xl font-bold text-white flex items-center">
                            <span class="bg-white text-cyan-600 rounded-full w-8 h-8 flex items-center justify-center mr-3 font-bold">6</span>
                            Vehicles
                        </h2>
                    </div>
                    <div class="p-6 space-y-4">
                        @forelse($user->vehicles as $index => $vehicle)
                            <div class="bg-gray-50 rounded-xl p-4">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <h3 class="font-semibold text-gray-900 capitalize">{{ $vehicle->vehicle_type }} - {{ $vehicle->make }} {{ $vehicle->model }}</h3>
                                        <div class="mt-2 grid grid-cols-2 gap-3 text-sm">
                                            <div>
                                                <span class="text-gray-600">Year:</span>
                                                <span class="text-gray-900 font-medium ml-2">{{ $vehicle->year }}</span>
                                            </div>
                                            <div>
                                                <span class="text-gray-600">State:</span>
                                                <span class="text-gray-900 font-medium ml-2">{{ $vehicle->state }}</span>
                                            </div>
                                            <div class="col-span-2">
                                                <span class="text-gray-600">Registration:</span>
                                                <span class="text-gray-900 font-mono font-medium ml-2">{{ $vehicle->registration_number }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <span class="ml-4 px-3 py-1 bg-cyan-100 text-cyan-800 rounded-full text-sm font-semibold">
                                        #{{ $index + 1 }}
                                    </span>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500 text-center py-4">No vehicles registered</p>
                        @endforelse
                    </div>
                </div>

                <!-- STEP 7: Address History -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden border-l-4 border-orange-500">
                    <div class="bg-gradient-to-r from-orange-500 to-amber-600 px-6 py-4">
                        <h2 class="text-xl font-bold text-white flex items-center">
                            <span class="bg-white text-orange-600 rounded-full w-8 h-8 flex items-center justify-center mr-3 font-bold">7</span>
                            Address History
                        </h2>
                    </div>
                    <div class="p-6 space-y-4">
                        @forelse($user->addresses as $index => $address)
                            <div class="bg-gray-50 rounded-xl p-4">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        @if($address->is_current)
                                            <span class="inline-block px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-semibold mb-2">Current</span>
                                        @endif
                                        <h3 class="font-semibold text-gray-900 capitalize">{{ str_replace('_', ' ', $address->living_arrangement) }}</h3>
                                        <p class="text-gray-700 mt-2">{{ $address->address }}</p>
                                        <p class="text-sm text-gray-600 mt-2">
                                            <strong>Duration:</strong> {{ $address->years_lived }} years, {{ $address->months_lived }} months
                                        </p>
                                        @if($address->reason_for_leaving)
                                        <p class="text-sm text-gray-600 mt-1">
                                            <strong>Reason for Leaving:</strong> {{ $address->reason_for_leaving }}
                                        </p>
                                        @endif
                                        @if($address->different_postal_address && $address->postal_code)
                                        <p class="text-sm text-gray-600 mt-1">
                                            <strong>Postal Code:</strong> {{ $address->postal_code }}
                                        </p>
                                        @endif
                                    </div>
                                    <span class="ml-4 px-3 py-1 bg-orange-100 text-orange-800 rounded-full text-sm font-semibold">
                                        #{{ $index + 1 }}
                                    </span>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500 text-center py-4">No address history added</p>
                        @endforelse
                    </div>
                </div>

                <!-- STEP 8: References -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden border-l-4 border-violet-500">
                    <div class="bg-gradient-to-r from-violet-500 to-purple-600 px-6 py-4">
                        <h2 class="text-xl font-bold text-white flex items-center">
                            <span class="bg-white text-violet-600 rounded-full w-8 h-8 flex items-center justify-center mr-3 font-bold">8</span>
                            References
                        </h2>
                    </div>
                    <div class="p-6 space-y-4">
                        @forelse($user->references as $index => $reference)
                            <div class="bg-gray-50 rounded-xl p-4">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <h3 class="font-semibold text-gray-900">{{ $reference->full_name }}</h3>
                                        <p class="text-gray-600 capitalize">{{ $reference->relationship }}</p>
                                        <div class="mt-2 space-y-1 text-sm">
                                            <p class="text-gray-700">📧 {{ $reference->email }}</p>
                                            <p class="text-gray-700">📞 {{ $reference->mobile_country_code }} {{ $reference->mobile_number }}</p>
                                        </div>
                                    </div>
                                    <span class="ml-4 px-3 py-1 bg-violet-100 text-violet-800 rounded-full text-sm font-semibold">
                                        #{{ $index + 1 }}
                                    </span>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500 text-center py-4">No references added</p>
                        @endforelse
                    </div>
                </div>

                <!-- STEP 9: Identification -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden border-l-4 border-red-500">
                    <div class="bg-gradient-to-r from-red-500 to-rose-600 px-6 py-4">
                        <h2 class="text-xl font-bold text-white flex items-center">
                            <span class="bg-white text-red-600 rounded-full w-8 h-8 flex items-center justify-center mr-3 font-bold">9</span>
                            Identification Documents
                        </h2>
                    </div>
                    <div class="p-6">
                        <div class="mb-6 p-4 rounded-xl {{ $totalPoints >= 80 ? 'bg-green-50 border-2 border-green-500' : 'bg-red-50 border-2 border-red-500' }}">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-semibold {{ $totalPoints >= 80 ? 'text-green-800' : 'text-red-800' }}">Total ID Points</p>
                                    <p class="text-3xl font-bold {{ $totalPoints >= 80 ? 'text-green-600' : 'text-red-600' }}">{{ $totalPoints }} Points</p>
                                </div>
                                @if($totalPoints >= 80)
                                    <svg class="w-12 h-12 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                @else
                                    <svg class="w-12 h-12 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                @endif
                            </div>
                            <p class="mt-2 text-sm {{ $totalPoints >= 80 ? 'text-green-700' : 'text-red-700' }}">
                                @if($totalPoints >= 80)
                                    ✓ Minimum requirement met (80 points)
                                @else
                                    ⚠ Need {{ 80 - $totalPoints }} more points (minimum 80 required)
                                @endif
                            </p>
                        </div>

                        <div class="space-y-4">
                            @forelse($user->identifications as $index => $id)
                                <div class="border-l-4 {{ $id->points >= 50 ? 'border-green-500' : ($id->points >= 25 ? 'border-blue-500' : 'border-yellow-500') }} pl-4 py-3 bg-gray-50 rounded-r-lg">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1">
                                            <h3 class="font-semibold text-gray-900 capitalize">{{ str_replace('_', ' ', $id->identification_type) }}</h3>
                                            @if($id->expiry_date)
                                            <p class="text-sm text-gray-600 mt-1">
                                                <strong>Expires:</strong> {{ \Carbon\Carbon::parse($id->expiry_date)->format('F j, Y') }}
                                            </p>
                                            @endif
                                            @if($id->document_path)
                                                <a href="{{ Storage::url($id->document_path) }}" target="_blank" class="inline-flex items-center mt-2 text-sm text-blue-600 hover:text-blue-800">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
                                                    </svg>
                                                    View Document
                                                </a>
                                            @endif
                                        </div>
                                        <span class="ml-4 px-4 py-2 rounded-full text-sm font-bold {{ $id->points >= 50 ? 'bg-green-100 text-green-800' : ($id->points >= 25 ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800') }}">
                                            {{ $id->points }} pts
                                        </span>
                                    </div>
                                </div>
                            @empty
                                <p class="text-gray-500 text-center py-4">No identification documents uploaded</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- STEP 10: Terms and Conditions -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden border-l-4 border-emerald-500">
                    <div class="bg-gradient-to-r from-emerald-500 to-teal-600 px-6 py-4">
                        <h2 class="text-xl font-bold text-white flex items-center">
                            <span class="bg-white text-emerald-600 rounded-full w-8 h-8 flex items-center justify-center mr-3 font-bold">10</span>
                            Terms and Conditions
                        </h2>
                    </div>
                    <div class="p-6">
                        <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg mb-4">
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <div>
                                    <p class="font-semibold text-green-900">Terms Accepted</p>
                                    <p class="text-sm text-green-700">Accepted on {{ $profile->terms_accepted_at->format('F j, Y \a\t g:i A') }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-sm font-semibold text-gray-700 mb-2">Electronic Signature:</p>
                            <p class="text-2xl font-signature text-gray-900 border-b-2 border-gray-300 inline-block pb-1">{{ $profile->signature }}</p>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Right Column - Sidebar -->
            <div class="lg:col-span-1 space-y-6">
                
                <!-- Quick Stats -->
                <div class="bg-white rounded-2xl shadow-lg p-6 sticky top-4">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Profile Summary</h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between pb-3 border-b">
                            <span class="text-gray-600">Status</span>
                            <span class="font-semibold capitalize {{ $profile->status === 'approved' ? 'text-green-600' : ($profile->status === 'rejected' ? 'text-red-600' : 'text-yellow-600') }}">
                                {{ $profile->status }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between pb-3 border-b">
                            <span class="text-gray-600">Submitted</span>
                            <span class="font-semibold text-gray-900">{{ $profile->submitted_at->format('M j, Y') }}</span>
                        </div>
                        <div class="flex items-center justify-between pb-3 border-b">
                            <span class="text-gray-600">Income Sources</span>
                            <span class="font-semibold text-gray-900">{{ $user->incomes->count() }}</span>
                        </div>
                        <div class="flex items-center justify-between pb-3 border-b">
                            <span class="text-gray-600">Employment</span>
                            <span class="font-semibold text-gray-900">{{ $user->employments->count() }}</span>
                        </div>
                        <div class="flex items-center justify-between pb-3 border-b">
                            <span class="text-gray-600">Pets</span>
                            <span class="font-semibold text-gray-900">{{ $user->pets->count() }}</span>
                        </div>
                        <div class="flex items-center justify-between pb-3 border-b">
                            <span class="text-gray-600">Vehicles</span>
                            <span class="font-semibold text-gray-900">{{ $user->vehicles->count() }}</span>
                        </div>
                        <div class="flex items-center justify-between pb-3 border-b">
                            <span class="text-gray-600">Addresses</span>
                            <span class="font-semibold text-gray-900">{{ $user->addresses->count() }}</span>
                        </div>
                        <div class="flex items-center justify-between pb-3 border-b">
                            <span class="text-gray-600">References</span>
                            <span class="font-semibold text-gray-900">{{ $user->references->count() }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600">ID Points</span>
                            <span class="font-semibold {{ $totalPoints >= 80 ? 'text-green-600' : 'text-red-600' }}">
                                {{ $totalPoints }}/80
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Actions</h3>
                    <div class="space-y-3">
                        <a href="{{ route('user.dashboard') }}" class="block w-full px-4 py-3 bg-gradient-to-r from-blue-500 to-purple-600 text-white text-center font-semibold rounded-xl hover:shadow-lg transition">
                            <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                            Back to Dashboard
                        </a>
                        
                        @if($profile->status === 'rejected')
                            <a href="{{ route('user.profile.complete') }}" class="block w-full px-4 py-3 bg-gradient-to-r from-red-500 to-orange-600 text-white text-center font-semibold rounded-xl hover:shadow-lg transition">
                                <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                Update Profile
                            </a>
                        @endif

                        @if($profile->status === 'approved')
                            <a href="{{ route('properties.index') }}" class="block w-full px-4 py-3 bg-gradient-to-r from-green-500 to-emerald-600 text-white text-center font-semibold rounded-xl hover:shadow-lg transition">
                                <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                                Browse Properties
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Help & Support -->
                <div class="bg-gradient-to-br from-blue-50 to-purple-50 rounded-2xl shadow-lg p-6">
                    <div class="text-center">
                        <svg class="w-12 h-12 text-blue-600 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Need Help?</h3>
                        <p class="text-sm text-gray-600 mb-4">Have questions about your profile status?</p>
                        <a href="mailto:support@sorted.com" class="inline-flex items-center text-blue-600 hover:text-blue-800 font-semibold">
                            Contact Support
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                        </a>
                    </div>
                </div>

            </div>

        </div>

    </div>
</div>
@endsection