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
                        <a href="{{ route('user.profile.overview') }}" class="inline-block mt-3 text-red-700 font-semibold hover:text-red-900">
                            Update Profile →
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Personal Details -->
        <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
            <div class="flex items-center mb-6">
                <div class="bg-gradient-to-br from-blue-400 to-blue-600 rounded-full p-3 mr-4">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-gray-900">Personal Details</h2>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-gray-50 p-4 rounded-lg">
                    <label class="text-sm text-gray-600 block mb-1">Full Name</label>
                    <p class="font-semibold text-gray-900">{{ $profile->title }} {{ $profile->first_name }} {{ $profile->middle_name }} {{ $profile->last_name }}</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <label class="text-sm text-gray-600 block mb-1">Preferred Name</label>
                    <p class="font-semibold text-gray-900">{{ $profile->preferred_name ?: 'N/A' }}</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <label class="text-sm text-gray-600 block mb-1">Date of Birth</label>
                    <p class="font-semibold text-gray-900">{{ $profile->date_of_birth?->format('F j, Y') }}</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <label class="text-sm text-gray-600 block mb-1">Gender</label>
                    <p class="font-semibold text-gray-900">{{ $profile->gender ? ucfirst($profile->gender) : 'N/A' }}</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <label class="text-sm text-gray-600 block mb-1">Email</label>
                    <p class="font-semibold text-gray-900">{{ $profile->email }}</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <label class="text-sm text-gray-600 block mb-1">Mobile</label>
                    <p class="font-semibold text-gray-900">{{ $profile->mobile_country_code }} {{ $profile->mobile_number }}</p>
                </div>
            </div>

            @if($profile->emergency_contact_name)
            <div class="mt-6 pt-6 border-t border-gray-200">
                <h3 class="font-semibold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    Emergency Contact
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <label class="text-sm text-gray-600 block mb-1">Name</label>
                        <p class="font-semibold text-gray-900">{{ $profile->emergency_contact_name }}</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <label class="text-sm text-gray-600 block mb-1">Relationship</label>
                        <p class="font-semibold text-gray-900">{{ $profile->emergency_contact_relationship }}</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <label class="text-sm text-gray-600 block mb-1">Mobile</label>
                        <p class="font-semibold text-gray-900">{{ $profile->emergency_contact_country_code }} {{ $profile->emergency_contact_number }}</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <label class="text-sm text-gray-600 block mb-1">Email</label>
                        <p class="font-semibold text-gray-900">{{ $profile->emergency_contact_email ?: 'N/A' }}</p>
                    </div>
                </div>
            </div>
            @endif

            @if($profile->has_guarantor && $profile->guarantor_name)
            <div class="mt-6 pt-6 border-t border-gray-200">
                <h3 class="font-semibold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                    Guarantor Information
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <label class="text-sm text-gray-600 block mb-1">Name</label>
                        <p class="font-semibold text-gray-900">{{ $profile->guarantor_name }}</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <label class="text-sm text-gray-600 block mb-1">Relationship</label>
                        <p class="font-semibold text-gray-900">{{ $profile->guarantor_relationship }}</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <label class="text-sm text-gray-600 block mb-1">Mobile</label>
                        <p class="font-semibold text-gray-900">{{ $profile->guarantor_country_code }} {{ $profile->guarantor_number }}</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <label class="text-sm text-gray-600 block mb-1">Email</label>
                        <p class="font-semibold text-gray-900">{{ $profile->guarantor_email ?: 'N/A' }}</p>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Introduction -->
        @if($profile->introduction)
        <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
            <div class="flex items-center mb-4">
                <div class="bg-gradient-to-br from-purple-400 to-purple-600 rounded-full p-3 mr-4">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                <div class="bg-gradient-to-br from-green-400 to-green-600 rounded-full p-3 mr-4">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="flex-1">
                    <h2 class="text-xl font-bold text-gray-900">Income Sources</h2>
                    <p class="text-sm text-gray-600 mt-1">
                        Total Weekly: ${{ number_format($user->incomes->sum('net_weekly_amount'), 2) }} | 
                        Annual: ${{ number_format($user->incomes->sum('net_weekly_amount') * 52, 2) }}
                    </p>
                </div>
            </div>
            
            @foreach($user->incomes as $index => $income)
            <div class="bg-gray-50 p-4 rounded-lg mb-4 last:mb-0 border-l-4 border-green-500">
                <div class="flex items-start justify-between mb-3">
                    <h3 class="font-semibold text-gray-900">Income Source {{ $index + 1 }}</h3>
                    <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-medium">
                        ${{ number_format($income->net_weekly_amount, 2) }}/week
                    </span>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-3">
                    <div>
                        <label class="text-sm text-gray-600 block mb-1">Source Type</label>
                        <p class="font-semibold text-gray-900">{{ ucfirst(str_replace('_', ' ', $income->source_of_income)) }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-600 block mb-1">Weekly Amount</label>
                        <p class="font-semibold text-gray-900">${{ number_format($income->net_weekly_amount, 2) }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-600 block mb-1">Annual Amount</label>
                        <p class="font-semibold text-gray-900">${{ number_format($income->net_weekly_amount * 52, 2) }}</p>
                    </div>
                </div>

                @php
                    $bankStatements = $income->bankStatements ?? collect();
                @endphp

                @if($bankStatements->count() > 0)
                <div class="pt-3 border-t border-gray-200">
                    <label class="text-sm text-gray-600 block mb-2">Bank Statements ({{ $bankStatements->count() }})</label>
                    <div class="space-y-2">
                        @foreach($bankStatements as $statement)
                        <a href="{{ Storage::url($statement->file_path) }}" 
                           target="_blank"
                           class="flex items-center gap-3 p-3 bg-white border border-gray-200 rounded-lg hover:border-green-500 hover:shadow-sm transition group">
                            @if(in_array(pathinfo($statement->file_path, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png']))
                                <img src="{{ Storage::url($statement->file_path) }}" 
                                     alt="Statement" 
                                     class="w-12 h-12 object-cover rounded border border-gray-300">
                            @else
                                <div class="w-12 h-12 bg-red-100 rounded flex items-center justify-center">
                                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            @endif
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">{{ $statement->file_name ?? basename($statement->file_path) }}</p>
                                <p class="text-xs text-gray-500">
                                    {{ $statement->file_size ? number_format($statement->file_size / 1024, 2) . ' KB' : '' }}
                                    @if($statement->created_at)
                                        • Uploaded {{ $statement->created_at->diffForHumans() }}
                                    @endif
                                </p>
                            </div>
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                            </svg>
                        </a>
                        @endforeach
                    </div>
                </div>
                @else
                <div class="pt-3 border-t border-gray-200">
                    <p class="text-sm text-gray-500 italic">No bank statements uploaded</p>
                </div>
                @endif
            </div>
            @endforeach
        </div>
        @endif

        <!-- Employment -->
        @if($user->employments->count() > 0)
        <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
            <div class="flex items-center mb-6">
                <div class="bg-gradient-to-br from-blue-400 to-indigo-600 rounded-full p-3 mr-4">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-gray-900">Employment History</h2>
            </div>
            
            @foreach($user->employments as $index => $employment)
            <div class="bg-gray-50 p-4 rounded-lg mb-4 last:mb-0 border-l-4 border-blue-500">
                <div class="flex items-start justify-between mb-3">
                    <h3 class="font-semibold text-gray-900 text-lg">{{ $employment->company_name }}</h3>
                    @if($employment->still_employed)
                        <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-medium">Current</span>
                    @endif
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-3">
                    <div>
                        <label class="text-sm text-gray-600 block mb-1">Position</label>
                        <p class="font-semibold text-gray-900">{{ $employment->position }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-600 block mb-1">Employment Type</label>
                        <p class="font-semibold text-gray-900">{{ ucfirst(str_replace('_', ' ', $employment->employment_type ?? 'N/A')) }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-600 block mb-1">Gross Annual Salary</label>
                        <p class="font-semibold text-gray-900">${{ number_format($employment->gross_annual_salary, 2) }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-600 block mb-1">Employment Period</label>
                        <p class="font-semibold text-gray-900">
                            {{ $employment->start_date?->format('M Y') }} - 
                            {{ $employment->still_employed ? 'Present' : ($employment->end_date?->format('M Y') ?? 'N/A') }}
                        </p>
                    </div>
                </div>

                @if($employment->supervisor_name || $employment->supervisor_phone)
                <div class="pt-3 border-t border-gray-200">
                    <label class="text-sm text-gray-600 block mb-2">Supervisor Contact</label>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @if($employment->supervisor_name)
                        <div class="bg-white p-3 rounded-lg">
                            <label class="text-xs text-gray-500 block mb-1">Name</label>
                            <p class="font-medium text-gray-900">{{ $employment->supervisor_name }}</p>
                        </div>
                        @endif
                        @if($employment->supervisor_phone)
                        <div class="bg-white p-3 rounded-lg">
                            <label class="text-xs text-gray-500 block mb-1">Phone</label>
                            <p class="font-medium text-gray-900">{{ $employment->supervisor_phone }}</p>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                @if($employment->employment_letter_path && Storage::disk('public')->exists($employment->employment_letter_path))
                <div class="pt-3 border-t border-gray-200">
                    <label class="text-sm text-gray-600 block mb-2">Employment Letter</label>
                    <a href="{{ Storage::url($employment->employment_letter_path) }}" 
                       target="_blank"
                       class="flex items-center gap-3 p-3 bg-white border border-gray-200 rounded-lg hover:border-blue-500 hover:shadow-sm transition group">
                        <div class="w-12 h-12 bg-blue-100 rounded flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-900">Employment Letter</p>
                            <p class="text-xs text-gray-500">Click to view document</p>
                        </div>
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                        </svg>
                    </a>
                </div>
                @endif
            </div>
            @endforeach
        </div>
        @endif

        <!-- Pets -->
        @if($user->pets->count() > 0)
        <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
            <div class="flex items-center mb-6">
                <div class="bg-gradient-to-br from-pink-400 to-pink-600 rounded-full p-3 mr-4">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-gray-900">Pets ({{ $user->pets->count() }})</h2>
            </div>
            
            @foreach($user->pets as $index => $pet)
            <div class="bg-gray-50 p-4 rounded-lg mb-4 last:mb-0 border-l-4 border-pink-500">
                <div class="flex items-start justify-between mb-3">
                    <h3 class="font-semibold text-gray-900 text-lg">{{ $pet->name }}</h3>
                    <span class="bg-pink-100 text-pink-800 px-3 py-1 rounded-full text-xs font-medium">{{ ucfirst($pet->type) }}</span>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-3">
                    <div>
                        <label class="text-sm text-gray-600 block mb-1">Breed</label>
                        <p class="font-semibold text-gray-900">{{ $pet->breed }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-600 block mb-1">Age</label>
                        <p class="font-semibold text-gray-900">{{ $pet->age }} years</p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-600 block mb-1">Weight</label>
                        <p class="font-semibold text-gray-900">{{ $pet->weight }} kg</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-3">
                    <div>
                        <label class="text-sm text-gray-600 block mb-1">Desexed</label>
                        <p class="font-semibold text-gray-900">{{ $pet->is_desexed ? 'Yes' : 'No' }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-600 block mb-1">Microchipped</label>
                        <p class="font-semibold text-gray-900">{{ $pet->is_microchipped ? 'Yes' : 'No' }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-600 block mb-1">Registered</label>
                        <p class="font-semibold text-gray-900">{{ $pet->is_registered ? 'Yes' : 'No' }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-600 block mb-1">Vaccinated</label>
                        <p class="font-semibold text-gray-900">{{ $pet->is_vaccinated ? 'Yes' : 'No' }}</p>
                    </div>
                </div>

                @if($pet->description)
                <div class="mb-3">
                    <label class="text-sm text-gray-600 block mb-1">Description</label>
                    <p class="text-gray-700 bg-white p-3 rounded-lg">{{ $pet->description }}</p>
                </div>
                @endif

                @php
                    $petPhotos = $pet->petPhotos ?? collect();
                @endphp

                @if($petPhotos->count() > 0)
                <div class="pt-3 border-t border-gray-200">
                    <label class="text-sm text-gray-600 block mb-2">Pet Photos ({{ $petPhotos->count() }})</label>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                        @foreach($petPhotos as $photo)
                        <a href="{{ Storage::url($photo->file_path) }}" 
                           target="_blank"
                           class="group relative aspect-square rounded-lg overflow-hidden border-2 border-gray-200 hover:border-pink-500 transition">
                            <img src="{{ Storage::url($photo->file_path) }}" 
                                 alt="Pet photo" 
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 transition-all flex items-center justify-center">
                                <svg class="w-8 h-8 text-white opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/>
                                </svg>
                            </div>
                        </a>
                        @endforeach
                    </div>
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
                <div class="bg-gradient-to-br from-indigo-400 to-indigo-600 rounded-full p-3 mr-4">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-gray-900">Vehicles ({{ $user->vehicles->count() }})</h2>
            </div>
            
            @foreach($user->vehicles as $index => $vehicle)
            <div class="bg-gray-50 p-4 rounded-lg mb-4 last:mb-0 border-l-4 border-indigo-500">
                <h3 class="font-semibold text-gray-900 text-lg mb-3">{{ $vehicle->make }} {{ $vehicle->model }} ({{ $vehicle->year }})</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="text-sm text-gray-600 block mb-1">Type</label>
                        <p class="font-semibold text-gray-900">{{ ucfirst($vehicle->type ?? 'N/A') }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-600 block mb-1">Color</label>
                        <p class="font-semibold text-gray-900">{{ $vehicle->color }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-600 block mb-1">Registration</label>
                        <p class="font-semibold text-gray-900">{{ $vehicle->registration_number }}</p>
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
                <div class="bg-gradient-to-br from-yellow-400 to-orange-500 rounded-full p-3 mr-4">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-gray-900">Address History ({{ $user->addresses->count() }})</h2>
            </div>
            
            @foreach($user->addresses as $index => $address)
            <div class="bg-gray-50 p-4 rounded-lg mb-4 last:mb-0 border-l-4 border-yellow-500">
                <div class="flex items-start justify-between mb-3">
                    <h3 class="font-semibold text-gray-900">Address {{ $index + 1 }}</h3>
                    @if($address->currently_living)
                        <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-medium">Current</span>
                    @endif
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-3">
                    <div class="md:col-span-2">
                        <label class="text-sm text-gray-600 block mb-1">Address</label>
                        <p class="font-semibold text-gray-900">{{ $address->street_address }}</p>
                        <p class="text-gray-700">{{ $address->suburb }}, {{ $address->state }} {{ $address->postcode }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-600 block mb-1">Accommodation Type</label>
                        <p class="font-semibold text-gray-900">{{ ucfirst(str_replace('_', ' ', $address->accommodation_type ?? 'N/A')) }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-600 block mb-1">Rental Amount</label>
                        <p class="font-semibold text-gray-900">
                            @if($address->rental_amount)
                                ${{ number_format($address->rental_amount, 2) }}/{{ $address->rental_frequency ?? 'week' }}
                            @else
                                N/A
                            @endif
                        </p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-600 block mb-1">Moved In</label>
                        <p class="font-semibold text-gray-900">{{ $address->move_in_date?->format('F Y') ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-600 block mb-1">Moved Out</label>
                        <p class="font-semibold text-gray-900">
                            {{ $address->currently_living ? 'Present' : ($address->move_out_date?->format('F Y') ?? 'N/A') }}
                        </p>
                    </div>
                </div>

                @if($address->reason_for_leaving)
                <div class="mb-3">
                    <label class="text-sm text-gray-600 block mb-1">Reason for Leaving</label>
                    <p class="text-gray-700 bg-white p-3 rounded-lg">{{ $address->reason_for_leaving }}</p>
                </div>
                @endif

                @if($address->landlord_name || $address->landlord_phone || $address->landlord_email)
                <div class="pt-3 border-t border-gray-200">
                    <label class="text-sm text-gray-600 block mb-2">Landlord/Agent Contact</label>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                        @if($address->landlord_name)
                        <div class="bg-white p-3 rounded-lg">
                            <label class="text-xs text-gray-500 block mb-1">Name</label>
                            <p class="font-medium text-gray-900">{{ $address->landlord_name }}</p>
                        </div>
                        @endif
                        @if($address->landlord_phone)
                        <div class="bg-white p-3 rounded-lg">
                            <label class="text-xs text-gray-500 block mb-1">Phone</label>
                            <p class="font-medium text-gray-900">{{ $address->landlord_phone }}</p>
                        </div>
                        @endif
                        @if($address->landlord_email)
                        <div class="bg-white p-3 rounded-lg">
                            <label class="text-xs text-gray-500 block mb-1">Email</label>
                            <p class="font-medium text-gray-900">{{ $address->landlord_email }}</p>
                        </div>
                        @endif
                    </div>
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
                <div class="bg-gradient-to-br from-teal-400 to-teal-600 rounded-full p-3 mr-4">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-gray-900">References ({{ $user->references->count() }})</h2>
            </div>
            
            @foreach($user->references as $index => $reference)
            <div class="bg-gray-50 p-4 rounded-lg mb-4 last:mb-0 border-l-4 border-teal-500">
                <div class="flex items-start justify-between mb-3">
                    <h3 class="font-semibold text-gray-900">{{ $reference->full_name }}</h3>
                    <span class="px-3 py-1 rounded-full text-xs font-medium
                        {{ $reference->reference_status === 'completed' ? 'bg-green-100 text-green-800' : '' }}
                        {{ $reference->reference_status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                        {{ $reference->reference_status === 'expired' ? 'bg-red-100 text-red-800' : '' }}">
                        {{ ucfirst($reference->reference_status ?? 'pending') }}
                    </span>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-3">
                    <div>
                        <label class="text-sm text-gray-600 block mb-1">Relationship</label>
                        <p class="font-semibold text-gray-900">{{ ucfirst(str_replace('_', ' ', $reference->relationship)) }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-600 block mb-1">Mobile</label>
                        <p class="font-semibold text-gray-900">{{ $reference->mobile_country_code }} {{ $reference->mobile_number }}</p>
                    </div>
                    <div class="md:col-span-2">
                        <label class="text-sm text-gray-600 block mb-1">Email</label>
                        <p class="font-semibold text-gray-900">{{ $reference->email }}</p>
                    </div>
                </div>

                @if($reference->reference_status === 'completed' && $reference->reference_response)
                    @php
                        $response = json_decode($reference->reference_response, true);
                    @endphp
                    <div class="pt-3 border-t border-gray-200">
                        <label class="text-sm text-gray-600 block mb-2">Reference Response</label>
                        <div class="bg-white p-4 rounded-lg space-y-3">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                <div>
                                    <label class="text-xs text-gray-500 block mb-1">How Long Known</label>
                                    <p class="text-sm font-medium text-gray-900">{{ $response['how_long_known'] ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <label class="text-xs text-gray-500 block mb-1">Would Recommend</label>
                                    <p class="text-sm font-medium {{ ($response['would_recommend'] ?? false) ? 'text-green-700' : 'text-red-700' }}">
                                        {{ ($response['would_recommend'] ?? false) ? '✓ Yes' : '✗ No' }}
                                    </p>
                                </div>
                                <div>
                                    <label class="text-xs text-gray-500 block mb-1">Character Assessment</label>
                                    <p class="text-sm font-medium text-gray-900">{{ ucfirst($response['character_assessment'] ?? 'N/A') }}</p>
                                </div>
                                <div>
                                    <label class="text-xs text-gray-500 block mb-1">Reliability Assessment</label>
                                    <p class="text-sm font-medium text-gray-900">{{ ucfirst($response['reliability_assessment'] ?? 'N/A') }}</p>
                                </div>
                            </div>
                            @if(!empty($response['recommendation_reason']))
                            <div>
                                <label class="text-xs text-gray-500 block mb-1">Recommendation Reason</label>
                                <p class="text-sm text-gray-700">{{ $response['recommendation_reason'] }}</p>
                            </div>
                            @endif
                            @if(!empty($response['additional_comments']))
                            <div>
                                <label class="text-xs text-gray-500 block mb-1">Additional Comments</label>
                                <p class="text-sm text-gray-700">{{ $response['additional_comments'] }}</p>
                            </div>
                            @endif
                            <div class="text-xs text-gray-500 pt-2 border-t">
                                Submitted: {{ $reference->reference_submitted_at?->format('F j, Y \a\t g:i A') }}
                            </div>
                        </div>
                    </div>
                @elseif($reference->reference_status === 'pending')
                    <div class="pt-3 border-t border-gray-200">
                        <p class="text-sm text-yellow-700 bg-yellow-50 p-3 rounded-lg">
                            ⏳ Reference request sent. Waiting for response.
                        </p>
                    </div>
                @endif
            </div>
            @endforeach
        </div>
        @endif

        <!-- ID Documents -->
        @if($user->identifications->count() > 0)
        <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center">
                    <div class="bg-gradient-to-br from-red-400 to-red-600 rounded-full p-3 mr-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/>
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold text-gray-900">Identification Documents</h2>
                </div>
                
                @php
                    $totalPoints = $user->identifications->sum('points');
                @endphp
                <div class="bg-blue-100 text-blue-800 px-4 py-2 rounded-lg">
                    <span class="font-semibold">Total Points: {{ $totalPoints }}</span>
                </div>
            </div>
            
            @foreach($user->identifications as $index => $document)
            <div class="bg-gray-50 p-4 rounded-lg mb-4 last:mb-0 border-l-4 border-red-500">
                <div class="flex items-start justify-between mb-3">
                    <div class="flex-1">
                        <h3 class="font-semibold text-gray-900 text-lg">{{ ucfirst(str_replace('_', ' ', $document->document_type)) }}</h3>
                        <p class="text-sm text-gray-600 mt-1">Number: {{ $document->document_number }}</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="bg-blue-100 text-blue-800 px-3 py-1.5 rounded-lg">
                            <span class="font-semibold">{{ $document->points }} pts</span>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-3">
                    @if($document->issue_date)
                    <div>
                        <label class="text-sm text-gray-600 block mb-1">Issue Date</label>
                        <p class="font-semibold text-gray-900">{{ $document->issue_date->format('F j, Y') }}</p>
                    </div>
                    @endif
                    @if($document->expiry_date)
                    <div>
                        <label class="text-sm text-gray-600 block mb-1">Expiry Date</label>
                        <p class="font-semibold text-gray-900">{{ $document->expiry_date->format('F j, Y') }}</p>
                    </div>
                    @endif
                </div>

                @php
                    $documentFiles = $document->identificationDocuments ?? collect();
                @endphp

                @if($documentFiles->count() > 0)
                <div class="pt-3 border-t border-gray-200">
                    <label class="text-sm text-gray-600 block mb-2">Uploaded Documents ({{ $documentFiles->count() }})</label>
                    <div class="space-y-2">
                        @foreach($documentFiles as $file)
                        <a href="{{ Storage::url($file->file_path) }}" 
                           target="_blank"
                           class="flex items-center gap-3 p-3 bg-white border border-gray-200 rounded-lg hover:border-blue-500 hover:shadow-sm transition group">
                            @if(in_array(pathinfo($file->file_path, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png']))
                                <img src="{{ Storage::url($file->file_path) }}" 
                                     alt="ID Document" 
                                     class="w-12 h-12 object-cover rounded border border-gray-300">
                            @else
                                <div class="w-12 h-12 bg-blue-100 rounded flex items-center justify-center">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            @endif
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">{{ $file->file_name ?? basename($file->file_path) }}</p>
                                <p class="text-xs text-gray-500">
                                    {{ $file->file_size ? number_format($file->file_size / 1024, 2) . ' KB' : '' }}
                                    @if($file->created_at)
                                        • Uploaded {{ $file->created_at->diffForHumans() }}
                                    @endif
                                </p>
                            </div>
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                            </svg>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
            @endforeach
        </div>
        @endif

        <!-- Terms & Signature -->
        @if($profile->terms_accepted)
        <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
            <div class="flex items-center mb-4">
                <div class="bg-gradient-to-br from-gray-600 to-gray-800 rounded-full p-3 mr-4">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-gray-900">Terms & Conditions</h2>
            </div>
            
            <div class="bg-gray-50 p-4 rounded-lg">
                <div class="flex items-center gap-2 mb-3">
                    <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span class="font-semibold text-gray-900">Terms Accepted</span>
                </div>
                
                <div class="space-y-2">
                    <div>
                        <label class="text-sm text-gray-600 block mb-1">Digital Signature</label>
                        <p class="font-semibold text-gray-900 text-lg italic">{{ $profile->signature }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-600 block mb-1">Accepted On</label>
                        <p class="text-gray-900">{{ $profile->terms_accepted_at?->format('F j, Y \a\t g:i A') }}</p>
                    </div>
                    @if($profile->submitted_at)
                    <div>
                        <label class="text-sm text-gray-600 block mb-1">Profile Submitted</label>
                        <p class="text-gray-900">{{ $profile->submitted_at->format('F j, Y \a\t g:i A') }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @endif

        <!-- Action Buttons -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex flex-col sm:flex-row gap-4">
                <a href="{{ route('user.dashboard') }}" class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-800 px-6 py-3 rounded-lg font-semibold text-center transition flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to Dashboard
                </a>
                @if($profile->status === 'rejected' || $profile->status === 'incomplete')
                <a href="{{ route('user.profile.overview') }}" class="flex-1 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white px-6 py-3 rounded-lg font-semibold text-center transition flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
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
                    <p class="text-sm text-green-700 font-semibold flex items-center gap-2">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        Your profile has been approved and is ready to use for rental applications.
                    </p>
                    @elseif($profile->status === 'pending')
                    <p class="text-sm text-yellow-700 font-semibold flex items-center gap-2">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                        </svg>
                        Your profile is currently under review. You'll be notified once it's approved.
                    </p>
                    @endif
                </div>
            </div>
        </div>

    </div>
</div>
@endsection