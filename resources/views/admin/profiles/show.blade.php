@extends('layouts.admin')

@section('title', 'Review User Profile')

@section('content')

<div class="mb-6">
    <div class="flex items-center justify-between">
        <div>
            <a href="{{ route('admin.profiles.index') }}" class="text-primary hover:text-primary-dark mb-2 inline-flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Back to Profiles
            </a>
            <h1 class="text-3xl font-bold text-gray-900 mt-2">Review User Profile</h1>
            <p class="text-gray-600 mt-1">{{ $profile->first_name }} {{ $profile->last_name }}</p>
        </div>
        
        <!-- Status Badge -->
        <div>
            @if($profile->status === 'pending')
                <span class="inline-flex items-center px-4 py-2 rounded-lg bg-yellow-100 text-yellow-800 font-semibold">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                    </svg>
                    Pending Review
                </span>
            @elseif($profile->status === 'approved')
                <span class="inline-flex items-center px-4 py-2 rounded-lg bg-green-100 text-green-800 font-semibold">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    Approved
                </span>
            @elseif($profile->status === 'rejected')
                <span class="inline-flex items-center px-4 py-2 rounded-lg bg-red-100 text-red-800 font-semibold">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                    Rejected
                </span>
            @endif
        </div>
    </div>
</div>

<!-- Quick Stats -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-xl p-4 border border-gray-200">
        <div class="text-sm text-gray-600 mb-1">ID Points</div>
        <div class="text-2xl font-bold {{ $totalPoints >= 80 ? 'text-green-600' : 'text-red-600' }}">
            {{ $totalPoints }} / 80
        </div>
    </div>
    <div class="bg-white rounded-xl p-4 border border-gray-200">
        <div class="text-sm text-gray-600 mb-1">Income Sources</div>
        <div class="text-2xl font-bold text-gray-900">{{ $profile->user->incomes->count() }}</div>
    </div>
    <div class="bg-white rounded-xl p-4 border border-gray-200">
        <div class="text-sm text-gray-600 mb-1">Employment</div>
        <div class="text-2xl font-bold text-gray-900">{{ $profile->user->employments->count() }}</div>
    </div>
    <div class="bg-white rounded-xl p-4 border border-gray-200">
        <div class="text-sm text-gray-600 mb-1">Submitted</div>
        <div class="text-lg font-bold text-gray-900">{{ $profile->submitted_at ? $profile->submitted_at->diffForHumans() : 'N/A' }}</div>
    </div>
</div>

<!-- ID Points Validation Alert -->
@if($totalPoints < 80)
<div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-lg">
    <div class="flex items-center">
        <svg class="w-5 h-5 text-red-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
        </svg>
        <div>
            <h3 class="font-semibold text-red-800">Insufficient ID Points</h3>
            <p class="text-sm text-red-700">This user has only {{ $totalPoints }} ID points. Minimum 80 points required.</p>
        </div>
    </div>
</div>
@endif

<div class="grid lg:grid-cols-3 gap-6">
    <!-- Main Content -->
    <div class="lg:col-span-2 space-y-6">
        
        <!-- Personal Details -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                <svg class="w-6 h-6 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                Personal Details
            </h2>
            
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="text-sm text-gray-600">Full Name</label>
                    <p class="font-semibold text-gray-900">{{ $profile->title }} {{ $profile->first_name }} {{ $profile->middle_name }} {{ $profile->last_name }}</p>
                </div>
                <div>
                    <label class="text-sm text-gray-600">Date of Birth</label>
                    <p class="font-semibold text-gray-900">{{ $profile->date_of_birth ? $profile->date_of_birth->format('F j, Y') : 'N/A' }} ({{ $profile->date_of_birth ? $profile->date_of_birth->age : 'N/A' }} years old)</p>
                </div>
                <div>
                    <label class="text-sm text-gray-600">Email</label>
                    <p class="font-semibold text-gray-900">{{ $profile->email }}</p>
                </div>
                <div>
                    <label class="text-sm text-gray-600">Mobile</label>
                    <p class="font-semibold text-gray-900">{{ $profile->mobile_country_code }} {{ $profile->mobile_number }}</p>
                </div>
            </div>

            @if($profile->emergency_contact_name)
            <div class="mt-6 pt-6 border-t">
                <h3 class="font-semibold text-gray-900 mb-3">Emergency Contact</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm text-gray-600">Name</label>
                        <p class="font-semibold text-gray-900">{{ $profile->emergency_contact_name }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-600">Relationship</label>
                        <p class="font-semibold text-gray-900">{{ $profile->emergency_contact_relationship }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-600">Mobile</label>
                        <p class="font-semibold text-gray-900">{{ $profile->emergency_contact_country_code }} {{ $profile->emergency_contact_number }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-600">Email</label>
                        <p class="font-semibold text-gray-900">{{ $profile->emergency_contact_email }}</p>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Introduction -->
        @if($profile->introduction)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">About</h2>
            <p class="text-gray-700 whitespace-pre-wrap">{{ $profile->introduction }}</p>
        </div>
        @endif

        <!-- Income Sources -->
        @if($profile->user->incomes->count() > 0)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                <svg class="w-6 h-6 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Income Sources
            </h2>
            
            @foreach($profile->user->incomes as $income)
            <div class="bg-gray-50 p-4 rounded-lg mb-3">
                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <label class="text-sm text-gray-600">Source</label>
                        <p class="font-semibold">{{ $income->source_of_income }}</p>
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
                <div class="mt-2">
                    <a href="{{ Storage::url($income->bank_statement_path) }}" target="_blank" class="text-sm text-primary hover:underline">
                        📄 View Bank Statement
                    </a>
                </div>
                @endif
            </div>
            @endforeach
        </div>
        @endif

        <!-- Employment History -->
        @if($profile->user->employments->count() > 0)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                Employment History
            </h2>
            
            @foreach($profile->user->employments as $employment)
            <div class="bg-gray-50 p-4 rounded-lg mb-3">
                <h3 class="font-semibold text-gray-900 mb-2">{{ $employment->company_name }}</h3>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <label class="text-gray-600">Position</label>
                        <p class="font-semibold">{{ $employment->position }}</p>
                    </div>
                    <div>
                        <label class="text-gray-600">Salary</label>
                        <p class="font-semibold">${{ number_format($employment->gross_annual_salary, 2) }}/year</p>
                    </div>
                    <div>
                        <label class="text-gray-600">Duration</label>
                        <p class="font-semibold">
                            {{ $employment->start_date->format('M Y') }} - 
                            @if($employment->still_employed)
                                <span class="text-green-600">Present</span>
                            @else
                                {{ $employment->end_date ? $employment->end_date->format('M Y') : 'N/A' }}
                            @endif
                        </p>
                    </div>
                    <div>
                        <label class="text-gray-600">Manager</label>
                        <p class="font-semibold">{{ $employment->manager_full_name }}</p>
                    </div>
                </div>
                @if($employment->employment_letter_path)
                <div class="mt-2">
                    <a href="{{ Storage::url($employment->employment_letter_path) }}" target="_blank" class="text-sm text-primary hover:underline">
                        📄 View Employment Letter
                    </a>
                </div>
                @endif
            </div>
            @endforeach
        </div>
        @endif

        <!-- Identification Documents -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center justify-between">
                <span class="flex items-center">
                    <svg class="w-6 h-6 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/>
                    </svg>
                    Identification Documents
                </span>
                <span class="text-lg font-bold {{ $totalPoints >= 80 ? 'text-green-600' : 'text-red-600' }}">
                    Total: {{ $totalPoints }} points
                </span>
            </h2>
            
            @foreach($profile->user->identifications as $id)
            <div class="bg-gray-50 p-4 rounded-lg mb-3">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <div class="font-semibold text-gray-900">{{ ucwords(str_replace('_', ' ', $id->identification_type)) }}</div>
                        <div class="text-sm text-gray-600 mt-1">
                            Points: <span class="font-semibold text-primary">{{ $id->points }}</span>
                            @if($id->expiry_date)
                                | Expires: {{ $id->expiry_date->format('M d, Y') }}
                            @endif
                        </div>
                    </div>
                    @if($id->document_path)
                    <a href="{{ Storage::url($id->document_path) }}" target="_blank" 
                       class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary-dark text-sm">
                        View Document
                    </a>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

    </div>

    <!-- Sidebar -->
    <div class="space-y-6">
        
        <!-- Actions -->
        @if($profile->status === 'pending')
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="font-bold text-gray-900 mb-4">Actions</h3>
            
            <form action="{{ route('admin.profiles.approve', $profile->id) }}" method="POST" class="mb-3">
                @csrf
                <button type="submit" 
                        class="w-full px-4 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 font-semibold flex items-center justify-center"
                        onclick="return confirm('Are you sure you want to approve this profile?')">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    Approve Profile
                </button>
            </form>

            <button onclick="document.getElementById('rejectModal').classList.remove('hidden')"
                    class="w-full px-4 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 font-semibold flex items-center justify-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                Reject Profile
            </button>
        </div>
        @endif

        <!-- Profile Info -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="font-bold text-gray-900 mb-4">Profile Information</h3>
            
            <div class="space-y-3 text-sm">
                <div>
                    <label class="text-gray-600">User Email</label>
                    <p class="font-semibold">{{ $profile->user->email }}</p>
                </div>
                <div>
                    <label class="text-gray-600">Submitted</label>
                    <p class="font-semibold">{{ $profile->submitted_at ? $profile->submitted_at->format('M d, Y g:i A') : 'N/A' }}</p>
                </div>
                @if($profile->approved_at)
                <div>
                    <label class="text-gray-600">Approved</label>
                    <p class="font-semibold">{{ $profile->approved_at->format('M d, Y g:i A') }}</p>
                </div>
                @endif
                @if($profile->rejected_at)
                <div>
                    <label class="text-gray-600">Rejected</label>
                    <p class="font-semibold">{{ $profile->rejected_at->format('M d, Y g:i A') }}</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Additional Stats -->
        <div class="bg-gradient-to-br from-primary to-primary-dark rounded-xl p-6 text-white">
            <h3 class="font-bold mb-4">Profile Stats</h3>
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-white/80">Pets</span>
                    <span class="font-bold">{{ $profile->user->pets->count() }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-white/80">Vehicles</span>
                    <span class="font-bold">{{ $profile->user->vehicles->count() }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-white/80">Addresses</span>
                    <span class="font-bold">{{ $profile->user->addresses->count() }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-white/80">References</span>
                    <span class="font-bold">{{ $profile->user->references->count() }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div id="rejectModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl max-w-md w-full p-6">
        <h3 class="text-xl font-bold text-gray-900 mb-4">Reject Profile</h3>
        
        <form action="{{ route('admin.profiles.reject', $profile->id) }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Rejection Reason *</label>
                <textarea name="rejection_reason" rows="4" required 
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500"
                          placeholder="Please provide a clear reason for rejection..."></textarea>
                <p class="text-sm text-gray-500 mt-1">Minimum 10 characters, maximum 500 characters</p>
            </div>
            
            <div class="flex gap-3">
                <button type="button" 
                        onclick="document.getElementById('rejectModal').classList.add('hidden')"
                        class="flex-1 px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">
                    Cancel
                </button>
                <button type="submit" 
                        class="flex-1 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                    Reject Profile
                </button>
            </div>
        </form>
    </div>
</div>

@endsection