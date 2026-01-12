@extends('layouts.admin')

@section('title', 'Property Applications')

@section('content')
<div class="container mx-auto px-4 py-8">
    
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h1 class="text-3xl font-bold text-plyform-dark mb-2">Applications</h1>
                <p class="text-gray-600">{{ $property->full_address }}</p>
            </div>
            <a href="{{ route('agency.properties.show', $property) }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition">
                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Property
            </a>
        </div>

        <!-- Stats Summary -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-4 border border-blue-200">
                <div class="text-2xl font-bold text-blue-900">{{ $applications->total() }}</div>
                <div class="text-sm text-blue-700 font-medium">Total Applications</div>
            </div>
            <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-xl p-4 border border-yellow-200">
                <div class="text-2xl font-bold text-yellow-900">{{ $applications->where('status', 'pending')->count() }}</div>
                <div class="text-sm text-yellow-700 font-medium">Pending Review</div>
            </div>
            <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-4 border border-green-200">
                <div class="text-2xl font-bold text-green-900">{{ $applications->where('status', 'approved')->count() }}</div>
                <div class="text-sm text-green-700 font-medium">Approved</div>
            </div>
            <div class="bg-gradient-to-br from-red-50 to-red-100 rounded-xl p-4 border border-red-200">
                <div class="text-2xl font-bold text-red-900">{{ $applications->where('status', 'rejected')->count() }}</div>
                <div class="text-sm text-red-700 font-medium">Rejected</div>
            </div>
        </div>
    </div>

    @if($applications->count() > 0)
        <!-- Applications List -->
        <div class="space-y-4">
            @foreach($applications as $application)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-all">
                    <div class="p-6">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex items-start gap-4">
                                <!-- Avatar -->
                                <div class="w-16 h-16 bg-gradient-to-br from-plyform-purple to-plyform-dark rounded-full flex items-center justify-center text-white font-bold text-xl flex-shrink-0">
                                    {{ substr($application->user->profile->first_name ?? 'U', 0, 1) }}{{ substr($application->user->profile->last_name ?? 'N', 0, 1) }}
                                </div>
                                
                                <!-- Applicant Info -->
                                <div>
                                    <h3 class="text-xl font-bold text-plyform-dark mb-1">
                                        {{ $application->user->profile->first_name ?? 'Unknown' }} {{ $application->user->profile->last_name ?? 'User' }}
                                    </h3>
                                    <div class="flex flex-wrap items-center gap-3 text-sm text-gray-600">
                                        <span class="flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                            </svg>
                                            {{ $application->user->email }}
                                        </span>
                                        @if($application->user->profile && $application->user->profile->mobile_number)
                                            <span class="flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                                </svg>
                                                {{ $application->user->profile->mobile_country_code }} {{ $application->user->profile->mobile_number }}
                                            </span>
                                        @endif
                                        <span class="flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            {{ $application->submitted_at->diffForHumans() }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Status Badge -->
                            <div>
                                @if($application->status === 'pending')
                                    <span class="px-4 py-2 bg-yellow-100 text-yellow-800 text-sm font-semibold rounded-full">Pending</span>
                                @elseif($application->status === 'approved')
                                    <span class="px-4 py-2 bg-green-100 text-green-800 text-sm font-semibold rounded-full">Approved</span>
                                @elseif($application->status === 'rejected')
                                    <span class="px-4 py-2 bg-red-100 text-red-800 text-sm font-semibold rounded-full">Rejected</span>
                                @elseif($application->status === 'under_review')
                                    <span class="px-4 py-2 bg-blue-100 text-blue-800 text-sm font-semibold rounded-full">Under Review</span>
                                @endif
                            </div>
                        </div>

                        <!-- Application Details Grid -->
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
                            <div class="bg-gray-50 rounded-lg p-3">
                                <div class="text-xs text-gray-600 mb-1">Move-in Date</div>
                                <div class="font-semibold text-plyform-dark">{{ $application->move_in_date->format('d M Y') }}</div>
                            </div>
                            <div class="bg-gray-50 rounded-lg p-3">
                                <div class="text-xs text-gray-600 mb-1">Lease Term</div>
                                <div class="font-semibold text-plyform-dark">{{ $application->lease_term }} months</div>
                            </div>
                            <div class="bg-gray-50 rounded-lg p-3">
                                <div class="text-xs text-gray-600 mb-1">Annual Income</div>
                                <div class="font-semibold text-plyform-dark">${{ number_format($application->annual_income, 0) }}</div>
                            </div>
                            <div class="bg-gray-50 rounded-lg p-3">
                                <div class="text-xs text-gray-600 mb-1">Occupants</div>
                                <div class="font-semibold text-plyform-dark">{{ $application->number_of_occupants }} {{ $application->number_of_occupants === 1 ? 'person' : 'people' }}</div>
                            </div>
                        </div>

                        <!-- Quick Info -->
                        <div class="flex flex-wrap items-center gap-4 text-sm mb-4">
                            @if($application->property_inspection === 'yes')
                                <span class="flex items-center gap-1 text-green-700 bg-green-50 px-3 py-1 rounded-full">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    Property Inspected
                                </span>
                            @endif
                            @if($application->user->employments->count() > 0)
                                <span class="flex items-center gap-1 text-blue-700 bg-blue-50 px-3 py-1 rounded-full">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                    {{ $application->user->employments->count() }} Employment {{ $application->user->employments->count() === 1 ? 'Record' : 'Records' }}
                                </span>
                            @endif
                            @if($application->user->pets->count() > 0)
                                <span class="flex items-center gap-1 text-purple-700 bg-purple-50 px-3 py-1 rounded-full">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $application->user->pets->count() }} {{ $application->user->pets->count() === 1 ? 'Pet' : 'Pets' }}
                                </span>
                            @endif
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
                            <a href="{{ route('agency.applications.show', $application) }}" 
                               class="flex-1 px-4 py-2 bg-gradient-to-r from-plyform-purple to-plyform-dark text-white rounded-lg hover:from-plyform-purple/90 hover:to-plyform-dark/90 transition text-center font-medium">
                                View Details
                            </a>
                            <a href="{{ route('agency.properties.applications.download', $application) }}" 
                               class="px-4 py-2 bg-plyform-mint text-plyform-dark rounded-lg hover:bg-plyform-mint/90 transition font-medium">
                                <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                Download
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $applications->links() }}
        </div>
    @else
        <!-- Empty State -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center">
            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">No Applications Yet</h3>
            <p class="text-gray-600">This property hasn't received any applications yet.</p>
        </div>
    @endif

</div>
@endsection