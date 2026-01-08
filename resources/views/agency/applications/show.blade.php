@extends('layouts.admin')

@section('title', 'Application Details')

@section('content')
<div class="py-8">
    <div class="container mx-auto px-4 py-8">
        
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('agency.applications.index') }}" 
               class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-900 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Back to Applications
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

        <div class="grid lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- Application Header -->
                <div class="bg-gradient-to-r from-plyform-yellow to-plyform-mint rounded-xl shadow-sm p-6 text-plyform-dark">
                    <div class="flex items-start justify-between gap-4 mb-4">
                        <div class="flex items-center gap-4">
                            <div class="w-16 h-16 bg-white/30 backdrop-blur rounded-full flex items-center justify-center">
                                <span class="text-2xl font-bold">{{ strtoupper(substr($application->first_name, 0, 1) . substr($application->last_name, 0, 1)) }}</span>
                            </div>
                            <div>
                                <h1 class="text-2xl font-bold">{{ $application->first_name }} {{ $application->last_name }}</h1>
                                <p class="text-sm opacity-90">Application #{{ $application->id }}</p>
                            </div>
                        </div>
                        
                        @php
                            $statusColors = [
                                'draft' => 'bg-gray-500',
                                'pending' => 'bg-orange-500',
                                'under_review' => 'bg-yellow-500',
                                'approved' => 'bg-green-500',
                                'rejected' => 'bg-red-500',
                                'withdrawn' => 'bg-gray-500',
                            ];
                        @endphp
                        <span class="px-4 py-2 text-sm font-semibold rounded-full text-white {{ $statusColors[$application->status] ?? 'bg-gray-500' }}">
                            {{ ucfirst(str_replace('_', ' ', $application->status)) }}
                        </span>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                        <div>
                            <p class="opacity-75">Submitted</p>
                            <p class="font-semibold">{{ $application->submitted_at ? $application->submitted_at->format('M d, Y') : 'Not submitted' }}</p>
                        </div>
                        <div>
                            <p class="opacity-75">Move-in Date</p>
                            <p class="font-semibold">{{ $application->move_in_date->format('M d, Y') }}</p>
                        </div>
                        <div>
                            <p class="opacity-75">Lease Term</p>
                            <p class="font-semibold">{{ $application->lease_term }} {{ $application->lease_term === 1 ? 'month' : 'months' }}</p>
                        </div>
                        <div>
                            <p class="opacity-75">Occupants</p>
                            <p class="font-semibold">{{ $application->number_of_occupants }}</p>
                        </div>
                    </div>
                </div>

                <!-- Property Information -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h2 class="text-xl font-bold text-plyform-dark mb-4 flex items-center gap-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                        Property Applied For
                    </h2>

                    <div class="flex gap-4">
                        @if($application->property->images->count() > 0)
                            <img 
                                src="{{ Storage::url($application->property->images->first()->image_path) }}" 
                                alt="{{ $application->property->headline }}"
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
                            <h3 class="text-lg font-semibold text-plyform-dark mb-2">{{ $application->property->headline }}</h3>
                            <p class="text-gray-600 mb-2">{{ $application->property->street_address }}, {{ $application->property->suburb }}, {{ $application->property->state }} {{ $application->property->postcode }}</p>
                            
                            <div class="flex items-center gap-4 text-sm text-gray-600">
                                <span class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                    </svg>
                                    {{ $application->property->bedrooms }} bed
                                </span>
                                <span class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"/>
                                    </svg>
                                    {{ $application->property->bathrooms }} bath
                                </span>
                                <span class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"/>
                                    </svg>
                                    {{ $application->property->parking_spaces }} parking
                                </span>
                            </div>

                            @if($application->property->agents->where('pivot.role', 'listing_agent')->first())
                                @php
                                    $listingAgent = $application->property->agents->where('pivot.role', 'listing_agent')->first();
                                @endphp
                                <p class="text-sm text-gray-600 mt-2">
                                    <strong>Listing Agent:</strong> {{ $listingAgent->first_name }} {{ $listingAgent->last_name }}
                                </p>
                            @endif
                        </div>
                    </div>

                    <a href="{{ route('properties.show', $application->property) }}" 
                       target="_blank"
                       class="mt-4 inline-flex items-center gap-2 text-plyform-purple hover:text-plyform-dark transition font-medium">
                        View Property Listing
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                        </svg>
                    </a>
                </div>

                <!-- Property Inspection -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h2 class="text-xl font-bold text-plyform-dark mb-4 flex items-center gap-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        Property Inspection
                    </h2>

                    <div class="flex items-start gap-4">
                        @if($application->property_inspection === 'yes')
                            <div class="p-3 bg-green-100 rounded-lg">
                                <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold text-green-700">Yes, applicant has inspected the property</p>
                                @if($application->inspection_date)
                                    <p class="text-sm text-gray-600 mt-1">
                                        Inspection Date: {{ $application->inspection_date->format('F d, Y') }}
                                        <span class="text-gray-400">({{ $application->inspection_date->diffForHumans() }})</span>
                                    </p>
                                @endif
                                <p class="text-sm text-gray-500 mt-2">
                                    This applicant has physically viewed the property, showing serious interest.
                                </p>
                            </div>
                        @else
                            <div class="p-3 bg-gray-100 rounded-lg">
                                <svg class="w-6 h-6 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-700">No, applicant accepts the property as is</p>
                                <p class="text-sm text-gray-500 mt-2">
                                    Applicant has not inspected the property in person and is comfortable proceeding without viewing.
                                </p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Occupants Details -->
                @if($application->occupants_details && count($application->occupants_details) > 0)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h2 class="text-xl font-bold text-plyform-dark mb-4 flex items-center gap-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        Occupants ({{ count($application->occupants_details) }})
                    </h2>

                    <div class="space-y-4">
                        @foreach($application->occupants_details as $index => $occupant)
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

                <!-- Special Requests & Notes -->
                @if($application->special_requests || $application->notes)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h2 class="text-xl font-bold text-plyform-dark mb-4 flex items-center gap-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                        </svg>
                        Additional Information
                    </h2>

                    @if($application->special_requests)
                        <div class="mb-4">
                            <h3 class="font-semibold text-gray-700 mb-2">Special Requests:</h3>
                            <p class="text-gray-600 whitespace-pre-wrap">{{ $application->special_requests }}</p>
                        </div>
                    @endif

                    @if($application->notes)
                        <div>
                            <h3 class="font-semibold text-gray-700 mb-2">Additional Notes:</h3>
                            <p class="text-gray-600 whitespace-pre-wrap">{{ $application->notes }}</p>
                        </div>
                    @endif
                </div>
                @endif

                <!-- Rejection Reason (if rejected) -->
                @if($application->status === 'rejected' && $application->rejection_reason)
                <div class="bg-red-50 border-2 border-red-200 rounded-xl p-6">
                    <h2 class="text-xl font-bold text-red-700 mb-4 flex items-center gap-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                        Rejection Reason
                    </h2>
                    <p class="text-red-800 whitespace-pre-wrap">{{ $application->rejection_reason }}</p>
                </div>
                @endif

            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                
                <!-- Quick Actions -->
                @if(in_array($application->status, ['pending', 'under_review']))
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-bold text-plyform-dark mb-4">Quick Actions</h3>

                    <div class="space-y-3">
                        @if($application->status === 'pending')
                            <form action="{{ route('agency.applications.under-review', $application) }}" method="POST">
                                @csrf
                                <button type="submit" 
                                        class="w-full px-4 py-3 bg-yellow-500 text-white font-semibold rounded-lg hover:bg-yellow-600 transition flex items-center justify-center gap-2"
                                        onclick="return confirm('Mark this application as under review?')">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    Mark Under Review
                                </button>
                            </form>
                        @endif

                        <form action="{{ route('agency.applications.approve', $application) }}" method="POST">
                            @csrf
                            <button type="submit" 
                                    class="w-full px-4 py-3 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition flex items-center justify-center gap-2"
                                    onclick="return confirm('Are you sure you want to APPROVE this application? This will notify the applicant.')">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Approve Application
                            </button>
                        </form>

                        <button 
                            onclick="openRejectModal()"
                            class="w-full px-4 py-3 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            Reject Application
                        </button>
                    </div>
                </div>
                @endif

                <!-- Contact Applicant -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-bold text-plyform-dark mb-4">Contact Applicant</h3>

                    <div class="space-y-3">
                        <a href="mailto:{{ $application->email }}" 
                           class="flex items-center gap-3 p-3 bg-gray-50 hover:bg-gray-100 rounded-lg transition">
                            <div class="p-2 bg-plyform-purple/10 rounded-lg">
                                <svg class="w-5 h-5 text-plyform-purple" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900">Email</p>
                                <p class="text-xs text-gray-600 truncate">{{ $application->email }}</p>
                            </div>
                        </a>

                        @if($application->phone)
                            <a href="tel:{{ $application->phone }}" 
                               class="flex items-center gap-3 p-3 bg-gray-50 hover:bg-gray-100 rounded-lg transition">
                                <div class="p-2 bg-plyform-purple/10 rounded-lg">
                                    <svg class="w-5 h-5 text-plyform-purple" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900">Phone</p>
                                    <p class="text-xs text-gray-600">{{ $application->phone }}</p>
                                </div>
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Application Timeline -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-bold text-plyform-dark mb-4">Timeline</h3>

                    <div class="space-y-4">
                        @if($application->submitted_at)
                            <div class="flex gap-3">
                                <div class="p-2 bg-blue-100 rounded-lg h-fit">
                                    <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Application Submitted</p>
                                    <p class="text-xs text-gray-600">{{ $application->submitted_at->format('M d, Y g:i A') }}</p>
                                    <p class="text-xs text-gray-500">{{ $application->submitted_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        @endif

                        @if($application->reviewed_at)
                            <div class="flex gap-3">
                                <div class="p-2 bg-yellow-100 rounded-lg h-fit">
                                    <svg class="w-4 h-4 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Reviewed</p>
                                    <p class="text-xs text-gray-600">{{ $application->reviewed_at->format('M d, Y g:i A') }}</p>
                                </div>
                            </div>
                        @endif

                        @if($application->approved_at)
                            <div class="flex gap-3">
                                <div class="p-2 bg-green-100 rounded-lg h-fit">
                                    <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-green-700">Application Approved</p>
                                    <p class="text-xs text-gray-600">{{ $application->approved_at->format('M d, Y g:i A') }}</p>
                                </div>
                            </div>
                        @endif

                        @if($application->rejected_at)
                            <div class="flex gap-3">
                                <div class="p-2 bg-red-100 rounded-lg h-fit">
                                    <svg class="w-4 h-4 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-red-700">Application Rejected</p>
                                    <p class="text-xs text-gray-600">{{ $application->rejected_at->format('M d, Y g:i A') }}</p>
                                </div>
                            </div>
                        @endif

                        @if($application->created_at)
                            <div class="flex gap-3">
                                <div class="p-2 bg-gray-100 rounded-lg h-fit">
                                    <svg class="w-4 h-4 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Application Created</p>
                                    <p class="text-xs text-gray-600">{{ $application->created_at->format('M d, Y g:i A') }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

<!-- Reject Modal -->
<div id="rejectModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-xl font-bold text-plyform-dark">Reject Application</h3>
            <button onclick="closeRejectModal()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <form action="{{ route('agency.applications.reject', $application) }}" method="POST">
            @csrf
            
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Rejection Reason <span class="text-red-500">*</span>
                </label>
                <textarea 
                    name="rejection_reason" 
                    rows="5"
                    required
                    minlength="10"
                    maxlength="1000"
                    placeholder="Please provide a clear reason for rejecting this application..."
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent"
                ></textarea>
                <p class="mt-1 text-xs text-gray-500">Minimum 10 characters. This will be sent to the applicant.</p>
            </div>

            <div class="flex gap-3">
                <button 
                    type="button"
                    onclick="closeRejectModal()"
                    class="flex-1 px-4 py-3 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 transition">
                    Cancel
                </button>
                <button 
                    type="submit"
                    class="flex-1 px-4 py-3 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition">
                    Reject Application
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openRejectModal() {
    document.getElementById('rejectModal').classList.remove('hidden');
}

function closeRejectModal() {
    document.getElementById('rejectModal').classList.add('hidden');
}

// Close modal when clicking outside
document.getElementById('rejectModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeRejectModal();
    }
});
</script>
@endsection