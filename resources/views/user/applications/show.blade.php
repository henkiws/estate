@extends('layouts.user')

@section('title', 'Application Details')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Success/Error Messages -->
        <x-alert-messages />
        
        <!-- Back Button -->
        <a href="{{ route('user.applications.index') }}" 
           class="inline-flex items-center gap-2 text-gray-600 hover:text-teal-600 mb-6 transition-colors group">
            <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            <span class="font-medium">Back to My Applications</span>
        </a>

        <!-- Application Header Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-6">
            <div class="p-6">
                <!-- Status and Date Row -->
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-3">
                        <!-- Status Badge -->
                        <span class="px-4 py-2 rounded-full text-sm font-semibold {{ 
                            $application->status === 'approved' ? 'bg-green-100 text-green-700' : 
                            ($application->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : 
                            ($application->status === 'under_review' ? 'bg-blue-100 text-blue-700' :
                            ($application->status === 'rejected' ? 'bg-red-100 text-red-700' :
                            ($application->status === 'draft' ? 'bg-gray-100 text-gray-700' : 'bg-gray-100 text-gray-700'))))
                        }}">
                            {{ ucfirst(str_replace('_', ' ', $application->status)) }}
                        </span>
                        
                        <!-- Application ID -->
                        <span class="text-gray-500 text-sm font-mono">
                            #{{ $application->id }}
                        </span>
                        
                        <!-- Submission Date -->
                        <span class="text-gray-500 text-sm">
                            Applied {{ $application->submitted_at->format('M j, Y') }}
                        </span>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-2">
                        {{-- @if($application->canEdit())
                            <a href="{{ route('user.applications.edit', $application) }}" 
                               class="px-4 py-2 bg-gray-100 text-gray-700 font-medium rounded-lg hover:bg-gray-200 transition">
                                Edit
                            </a>
                        @endif --}}
                        
                        {{-- @if($application->canWithdraw())
                            <button 
                                onclick="confirmWithdraw()"
                                class="px-4 py-2 bg-red-100 text-red-700 font-medium rounded-lg hover:bg-red-200 transition">
                                Withdraw
                            </button>
                        @endif --}}
                    </div>
                </div>

                <!-- Property Info -->
                <div class="flex gap-6">
                    <!-- Property Image -->
                    <div class="w-40 h-40 bg-gray-100 rounded-xl overflow-hidden flex-shrink-0 border border-gray-200">
                        @if($application->property->floorplan_path && Storage::disk('public')->exists($application->property->floorplan_path))
                            <img src="{{ Storage::url($application->property->floorplan_path) }}" 
                                 alt="Property"
                                 class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                            </div>
                        @endif
                    </div>

                    <!-- Property Details -->
                    <div class="flex-1">
                        <h1 class="text-2xl font-bold text-gray-900 mb-2">
                            {{ $application->property->full_address }}
                        </h1>

                        <!-- Property Features -->
                        <div class="flex flex-wrap items-center gap-4 text-gray-700 mb-4">
                            @if($application->property->bedrooms)
                                <div class="flex items-center gap-2">
                                    <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                                    </svg>
                                    <span class="text-sm font-medium">{{ $application->property->bedrooms }} bed</span>
                                </div>
                            @endif

                            @if($application->property->bathrooms)
                                <div class="flex items-center gap-2">
                                    <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M3 5a2 2 0 012-2h10a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V5zm11 1H6v8l.01.01h7.99V6z" clip-rule="evenodd"/>
                                    </svg>
                                    <span class="text-sm font-medium">{{ $application->property->bathrooms }} bath</span>
                                </div>
                            @endif

                            @if($application->property->parking_spaces)
                                <div class="flex items-center gap-2">
                                    <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                                        <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z"/>
                                    </svg>
                                    <span class="text-sm font-medium">{{ $application->property->parking_spaces }} car</span>
                                </div>
                            @endif

                            @if($application->property->property_type)
                                <div class="px-3 py-1 bg-gray-100 text-gray-700 text-xs font-medium rounded-full">
                                    {{ ucfirst($application->property->property_type) }}
                                </div>
                            @endif
                        </div>

                        <!-- Price -->
                        <div class="flex items-baseline gap-2 mb-3">
                            <p class="text-3xl font-bold text-teal-600">
                                ${{ number_format($application->rent_per_week ?? $application->property->rent_per_week, 2) }}
                            </p>
                            <span class="text-lg text-gray-600">per week</span>
                        </div>

                        @if($application->property->bond_amount)
                            <p class="text-sm text-gray-600">
                                Bond: <span class="font-semibold text-gray-900">${{ number_format($application->property->bond_amount) }}</span>
                            </p>
                        @endif
                    </div>

                    <!-- Agency Info -->
                    @if($application->agency)
                        <div class="text-right border-l border-gray-200 pl-6 flex-shrink-0">
                            @if($application->agency->logo_path)
                                <img src="{{ Storage::url($application->agency->logo_path) }}" 
                                     alt="{{ $application->agency->trading_name }}"
                                     class="h-12 object-contain mb-3 ml-auto">
                            @else
                                <div class="px-3 py-2 bg-gray-100 rounded-lg mb-3">
                                    <span class="font-bold text-gray-700 text-xs uppercase tracking-wide">
                                        {{ $application->agency->trading_name }}
                                    </span>
                                </div>
                            @endif
                            <p class="text-sm text-gray-600">Managing Agency</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Application Details Grid -->
        <div class="grid lg:grid-cols-4 gap-6 mb-6">
            <!-- Move-in Date Card -->
            <div class="bg-gradient-to-br from-teal-50 to-teal-100 rounded-xl border-2 border-teal-200 p-6">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 bg-teal-200 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-teal-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-teal-900">Move-in Date</h3>
                </div>
                <p class="text-2xl font-bold text-teal-900">
                    {{ $application->move_in_date->format('M j, Y') }}
                </p>
                <p class="text-sm text-teal-700 mt-1">
                    {{ $application->move_in_date->diffForHumans() }}
                </p>
            </div>

            <!-- Lease Term Card -->
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl border-2 border-blue-200 p-6">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 bg-blue-200 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-blue-900">Lease Term</h3>
                </div>
                <p class="text-2xl font-bold text-blue-900">
                    {{ $application->lease_term ?? 'N/A' }} months
                </p>
                <p class="text-sm text-blue-700 mt-1">
                    Requested duration
                </p>
            </div>

            <!-- Occupants Card -->
            <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl border-2 border-purple-200 p-6">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 bg-purple-200 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-purple-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-purple-900">Occupants</h3>
                </div>
                <p class="text-2xl font-bold text-purple-900">
                    {{ $application->number_of_occupants }}
                </p>
                <p class="text-sm text-purple-700 mt-1">
                    Total people
                </p>
            </div>

            <!-- Annual Income Card -->
            <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl border-2 border-green-200 p-6">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 bg-green-200 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-green-900">Annual Income</h3>
                </div>
                <p class="text-2xl font-bold text-green-900">
                    ${{ number_format($application->annual_income, 0) }}
                </p>
                <p class="text-sm text-green-700 mt-1">
                    Declared income
                </p>
            </div>
        </div>

        <div class="grid lg:grid-cols-2 gap-6 mb-6">
            <!-- Personal Information -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Personal Information
                </h2>
                <div class="space-y-3">
                    <div class="flex justify-between py-2 border-b border-gray-100">
                        <span class="text-gray-600">Full Name</span>
                        <span class="font-semibold text-gray-900">{{ $application->first_name }} {{ $application->last_name }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-gray-100">
                        <span class="text-gray-600">Email</span>
                        <span class="font-semibold text-gray-900">{{ $application->email }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-gray-100">
                        <span class="text-gray-600">Phone</span>
                        <span class="font-semibold text-gray-900">{{ $application->phone }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-gray-100">
                        <span class="text-gray-600">Date of Birth</span>
                        <span class="font-semibold text-gray-900">{{ $application->date_of_birth ? $application->date_of_birth->format('M j, Y') : 'N/A' }}</span>
                    </div>
                    <div class="flex justify-between py-2">
                        <span class="text-gray-600">Current Address</span>
                        <span class="font-semibold text-gray-900 text-right">{{ $application->current_address }}</span>
                    </div>
                </div>
            </div>

            <!-- Inspection & Utilities -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                    </svg>
                    Inspection & Utilities
                </h2>
                <div class="space-y-3">
                    <div class="flex justify-between py-2 border-b border-gray-100">
                        <span class="text-gray-600">Property Inspected</span>
                        <span class="font-semibold {{ $application->property_inspection === 'yes' ? 'text-green-600' : 'text-gray-900' }}">
                            {{ $application->property_inspection === 'yes' ? 'Yes ✓' : 'No' }}
                        </span>
                    </div>
                    @if($application->property_inspection === 'yes' && $application->inspection_date)
                        <div class="flex justify-between py-2 border-b border-gray-100">
                            <span class="text-gray-600">Inspection Date</span>
                            <span class="font-semibold text-gray-900">{{ $application->inspection_date->format('M j, Y') }}</span>
                        </div>
                    @endif

                    <div class="pt-3">
                        <p class="text-sm font-medium text-gray-700 mb-2">Utility Connections Requested:</p>
                        <div class="flex flex-wrap gap-2">
                            @if($application->utility_electricity)
                                <span class="px-3 py-1 bg-yellow-100 text-yellow-800 text-sm font-medium rounded-full flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd"/>
                                    </svg>
                                    Electricity
                                </span>
                            @endif
                            @if($application->utility_gas)
                                <span class="px-3 py-1 bg-orange-100 text-orange-800 text-sm font-medium rounded-full flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z" clip-rule="evenodd"/>
                                    </svg>
                                    Gas
                                </span>
                            @endif
                            @if($application->utility_internet)
                                <span class="px-3 py-1 bg-blue-100 text-blue-800 text-sm font-medium rounded-full flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M2 5a2 2 0 012-2h12a2 2 0 012 2v2a2 2 0 01-2 2H4a2 2 0 01-2-2V5zm14 1a1 1 0 11-2 0 1 1 0 012 0zM2 13a2 2 0 012-2h12a2 2 0 012 2v2a2 2 0 01-2 2H4a2 2 0 01-2-2v-2zm14 1a1 1 0 11-2 0 1 1 0 012 0z" clip-rule="evenodd"/>
                                    </svg>
                                    Internet
                                </span>
                            @endif
                            @if(!$application->utility_electricity && !$application->utility_gas && !$application->utility_internet)
                                <span class="text-sm text-gray-500 italic">None requested</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Occupants Details -->
        @if($application->occupants_details && count($application->occupants_details) > 0)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
                <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    Occupant Details
                </h2>
                <div class="grid md:grid-cols-2 gap-4">
                    @foreach($application->occupants_details as $index => $occupant)
                        <div class="p-4 {{ $index === 0 ? 'bg-gradient-to-br from-teal-50 to-teal-100 border-2 border-teal-200' : 'bg-gray-50 border border-gray-200' }} rounded-lg">
                            <div class="flex items-center gap-3 mb-2">
                                <div class="w-12 h-12 {{ $index === 0 ? 'bg-teal-600' : 'bg-gray-400' }} rounded-full flex items-center justify-center text-white font-bold text-lg">
                                    {{ strtoupper(substr($occupant['first_name'] ?? 'O', 0, 1)) }}{{ strtoupper(substr($occupant['last_name'] ?? 'O', 0, 1)) }}
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <h4 class="font-semibold text-gray-900">
                                            {{ $occupant['first_name'] ?? 'N/A' }} {{ $occupant['last_name'] ?? '' }}
                                        </h4>
                                        @if($index === 0)
                                            <span class="text-xs bg-teal-600 text-white px-2 py-1 rounded-full font-medium">Primary Applicant</span>
                                        @endif
                                    </div>
                                    <p class="text-sm text-gray-600">{{ $occupant['relationship'] ?? 'N/A' }}</p>
                                </div>
                            </div>
                            <div class="mt-3 pt-3 border-t {{ $index === 0 ? 'border-teal-200' : 'border-gray-200' }} space-y-1">
                                @if(isset($occupant['age']))
                                    <p class="text-sm">
                                        <span class="text-gray-600">Age:</span>
                                        <span class="font-semibold text-gray-900">{{ $occupant['age'] }} years old</span>
                                    </p>
                                @endif
                                @if(isset($occupant['email']) && $occupant['email'])
                                    <p class="text-sm">
                                        <span class="text-gray-600">Email:</span>
                                        <span class="font-medium text-gray-900">{{ $occupant['email'] }}</span>
                                    </p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Additional Information -->
        @if($application->special_requests || $application->notes)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
                <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                    </svg>
                    Additional Information
                </h2>
                
                @if($application->special_requests)
                    <div class="mb-4 p-4 bg-blue-50 border-l-4 border-blue-500 rounded-r-lg">
                        <h3 class="font-semibold text-blue-900 mb-2 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                            Special Requests
                        </h3>
                        <p class="text-blue-800 leading-relaxed">{{ $application->special_requests }}</p>
                    </div>
                @endif
                
                @if($application->notes)
                    <div class="p-4 bg-purple-50 border-l-4 border-purple-500 rounded-r-lg">
                        <h3 class="font-semibold text-purple-900 mb-2 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                            </svg>
                            Additional Notes
                        </h3>
                        <p class="text-purple-800 leading-relaxed">{{ $application->notes }}</p>
                    </div>
                @endif
            </div>
        @endif

        <!-- Agency Review Notes -->
        @if($application->agency_notes)
            <div class="bg-blue-50 border-l-4 border-blue-500 rounded-r-xl p-6">
                <div class="flex items-start gap-3">
                    <svg class="w-6 h-6 text-blue-600 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div class="flex-1">
                        <h3 class="font-bold text-blue-900 mb-2 text-lg">Agency Response</h3>
                        <p class="text-blue-800 leading-relaxed">{{ $application->agency_notes }}</p>
                        @if($application->reviewed_at)
                            <p class="text-sm text-blue-600 mt-3 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Reviewed {{ $application->reviewed_at->diffForHumans() }}
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        @endif

    </div>
</div>

<script>
function confirmWithdraw() {
    if (confirm('Are you sure you want to withdraw this application? This action cannot be undone.')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("user.applications.withdraw", $application) }}';
        
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = '{{ csrf_token() }}';
        form.appendChild(csrfInput);
        
        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'DELETE';
        form.appendChild(methodInput);
        
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
@endsection