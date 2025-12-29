@extends('layouts.app')

@section('title', 'Application Details - plyform')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-[#DDEECD] to-white py-8">
    <div class="max-w-7xl mx-auto px-4">
        
        <!-- Back Button -->
        <a href="{{ route('user.applications.index') }}" 
           class="inline-flex items-center gap-2 text-[#1E1C1C] hover:text-[#5E17EB] mb-6 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Back to Applications
        </a>

        <!-- Application Card - Compact Design -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-200">
            
            <!-- Header Section - Horizontal Layout -->
            <div class="p-6 lg:p-8 border-b border-gray-200">
                
                <!-- Top Row: Status, Date, and Group Members -->
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-4">
                        <!-- Status Badge -->
                        <span class="px-5 py-1.5 rounded-full text-sm font-semibold {{ 
                            $application->status === 'approved' ? 'bg-[#DDEECD] text-[#1E1C1C]' : 
                            ($application->status === 'pending' ? 'bg-[#E6FF4B] text-[#1E1C1C]' : 
                            'bg-gray-200 text-gray-700')
                        }}">
                            {{ ucfirst($application->status) }}
                        </span>
                        
                        <!-- Submission Date -->
                        <span class="text-gray-500 text-sm">
                            Submitted: {{ $application->submitted_at ? $application->submitted_at->format('D, d/m/Y') : 'N/A' }}
                        </span>
                    </div>

                    <!-- Group Members -->
                    @if(isset($groupMembers) && $groupMembers->count() > 0)
                    <div class="flex items-center gap-3">
                        <span class="text-sm font-semibold text-gray-700">My Group</span>
                        <div class="flex -space-x-2">
                            @foreach($groupMembers as $member)
                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-[#5E17EB] to-[#E6FF4B] flex items-center justify-center text-white font-bold text-xs border-2 border-white shadow"
                                 title="{{ $member->first_name }} {{ $member->last_name }}">
                                {{ strtoupper(substr($member->first_name, 0, 1) . substr($member->last_name, 0, 1)) }}
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Property Info Row - Horizontal Layout -->
                <div class="flex items-center gap-6">
                    
                    <!-- Floor Plan Thumbnail -->
                    <div class="w-28 h-28 bg-gray-100 rounded-lg overflow-hidden flex-shrink-0 border border-gray-200">
                        @if($application->property->images->first())
                        <img src="{{ $application->property->images->first()->url }}" 
                             alt="Property thumbnail"
                             class="w-full h-full object-cover">
                        @else
                        <div class="w-full h-full flex items-center justify-center">
                            <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                        </div>
                        @endif
                    </div>

                    <!-- Property Details - Takes remaining space -->
                    <div class="flex-1 min-w-0">
                        <h1 class="text-2xl lg:text-3xl font-bold text-[#1E1C1C] mb-1 truncate">
                            {{ $application->property->address }}
                        </h1>
                        <p class="text-gray-600 mb-3">
                            {{ $application->property->suburb }}, {{ $application->property->state }} {{ $application->property->postcode }}
                        </p>

                        <!-- Property Features - Horizontal -->
                        <div class="flex items-center gap-6 text-gray-700">
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                                </svg>
                                <span class="text-sm">{{ $application->property->bedrooms }} bedroom{{ $application->property->bedrooms != 1 ? 's' : '' }}</span>
                            </div>

                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3 5a2 2 0 012-2h10a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V5zm11 1H6v8l.01.01h7.99V6z" clip-rule="evenodd"/>
                                </svg>
                                <span class="text-sm">{{ $application->property->bathrooms }} bathroom{{ $application->property->bathrooms != 1 ? 's' : '' }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Price and Agency - Right Side -->
                    <div class="text-right flex-shrink-0 border-l border-gray-200 pl-6">
                        <!-- Agency Logo/Name -->
                        @if($application->agency)
                        <div class="flex justify-end mb-3">
                            @if($application->agency->logo)
                            <img src="{{ $application->agency->logo }}" 
                                 alt="{{ $application->agency->name }}"
                                 class="h-10 object-contain">
                            @else
                            <div class="px-3 py-1.5 bg-gray-100 rounded">
                                <span class="font-bold text-gray-700 text-xs uppercase tracking-wide">
                                    {{ $application->agency->name }}
                                </span>
                            </div>
                            @endif
                        </div>
                        @endif
                        
                        <!-- Price -->
                        <p class="text-3xl lg:text-4xl font-bold text-[#00BCD4]">
                            ${{ number_format($application->property->rent_per_week ?? $application->property->price_per_week) }}
                        </p>
                        <p class="text-gray-500 text-sm">Rent pw</p>
                    </div>
                </div>
            </div>

            <!-- Application Details Section - Clean Grid -->
            <div class="p-6 lg:p-8">
                
                <!-- First Row: Inspection Info -->
                <div class="grid md:grid-cols-2 gap-x-12 gap-y-6 mb-6 pb-6 border-b border-gray-200">
                    <div>
                        <h3 class="font-semibold text-[#1E1C1C] mb-1.5 text-base">
                            Have you inspected this property?
                        </h3>
                        <p class="text-gray-600 text-sm">
                            {{ $application->inspection_confirmed ?? false ? 'I have inspected this property in person and accept it in its current state' : 'Not inspected yet' }}
                        </p>
                    </div>

                    <div>
                        <h3 class="font-semibold text-[#1E1C1C] mb-1.5 text-base">
                            When did you inspect this property?
                        </h3>
                        <p class="text-gray-600 text-sm">
                            {{ $application->inspection_date ? $application->inspection_date->format('d/m/Y') : 'N/A' }}
                        </p>
                    </div>
                </div>

                <!-- Second Row: Move In and Lease Duration -->
                <div class="grid md:grid-cols-2 gap-x-12 gap-y-6">
                    <div>
                        <h3 class="font-semibold text-[#1E1C1C] mb-1.5 text-base">
                            Preferred move in date
                        </h3>
                        <p class="text-gray-600 text-sm">
                            {{ $application->move_in_date ? $application->move_in_date->format('d/m/Y') : 'Not specified' }}
                        </p>
                    </div>

                    <div>
                        <h3 class="font-semibold text-[#1E1C1C] mb-1.5 text-base">
                            Preferred lease duration
                        </h3>
                        <p class="text-gray-600 text-sm">
                            {{ $application->lease_duration ?? 'Not specified' }} month(s)
                        </p>
                    </div>
                </div>
            </div>

            <!-- Contact Info Collapsible Section -->
            <div class="border-t border-gray-200">
                <button onclick="toggleContactInfo()" 
                        class="w-full px-6 lg:px-8 py-4 flex items-center justify-between hover:bg-gray-50 transition-colors group">
                    <span class="text-base font-semibold text-[#00BCD4] group-hover:text-[#0097A7]">Contact info</span>
                    <svg id="contactInfoIcon" class="w-5 h-5 text-[#00BCD4] transform transition-transform group-hover:text-[#0097A7]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                
                <div id="contactInfoContent" class="hidden px-6 lg:px-8 pb-6">
                    <div class="bg-gray-50 rounded-lg p-6">
                        <div class="grid md:grid-cols-2 gap-8">
                            @if($application->agency)
                            <div>
                                <h4 class="font-semibold text-[#1E1C1C] mb-3">Agency Contact</h4>
                                <div class="space-y-2">
                                    <p class="text-gray-700 font-medium">{{ $application->agency->name }}</p>
                                    @if($application->agency->phone)
                                    <p class="text-gray-600 flex items-center gap-2 text-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                        </svg>
                                        {{ $application->agency->phone }}
                                    </p>
                                    @endif
                                    @if($application->agency->email)
                                    <p class="text-gray-600 flex items-center gap-2 text-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                        </svg>
                                        {{ $application->agency->email }}
                                    </p>
                                    @endif
                                </div>
                            </div>
                            @endif

                            <div>
                                <h4 class="font-semibold text-[#1E1C1C] mb-3">Your Contact</h4>
                                <div class="space-y-2">
                                    <p class="text-gray-700 font-medium">{{ $application->full_name }}</p>
                                    <p class="text-gray-600 flex items-center gap-2 text-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                        </svg>
                                        {{ $application->phone }}
                                    </p>
                                    <p class="text-gray-600 flex items-center gap-2 text-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                        </svg>
                                        {{ $application->email }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Expandable Additional Details Section -->
        <div class="mt-6 bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-200">
            <button onclick="toggleAdditionalDetails()" 
                    class="w-full px-6 lg:px-8 py-4 flex items-center justify-between hover:bg-gray-50 transition-colors group">
                <span class="text-base font-semibold text-[#1E1C1C]">View Full Application Details</span>
                <svg id="additionalDetailsIcon" class="w-5 h-5 text-gray-600 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
            
            <div id="additionalDetailsContent" class="hidden">
                <div class="px-6 lg:px-8 py-6 space-y-6 border-t border-gray-200">
                    
                    <!-- Personal Information -->
                    <div>
                        <h3 class="text-lg font-bold text-[#1E1C1C] mb-4">Personal Information</h3>
                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <p class="text-xs text-gray-500 mb-1">Full Name</p>
                                <p class="text-gray-800 font-medium">{{ $application->full_name }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 mb-1">Email</p>
                                <p class="text-gray-800 font-medium">{{ $application->email }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 mb-1">Phone</p>
                                <p class="text-gray-800 font-medium">{{ $application->phone }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 mb-1">Date of Birth</p>
                                <p class="text-gray-800 font-medium">{{ $application->date_of_birth ? $application->date_of_birth->format('d/m/Y') : 'N/A' }}</p>
                            </div>
                            <div class="md:col-span-2">
                                <p class="text-xs text-gray-500 mb-1">Current Address</p>
                                <p class="text-gray-800 font-medium">{{ $application->current_address }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 mb-1">Number of Occupants</p>
                                <p class="text-gray-800 font-medium">{{ $application->number_of_occupants }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 mb-1">Pets</p>
                                <p class="text-gray-800 font-medium">{{ $application->has_pets ? 'Yes' : 'No' }}</p>
                                @if($application->has_pets && $application->pet_details)
                                <p class="text-sm text-gray-600 mt-1">{{ $application->pet_details }}</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Employment Information -->
                    <div class="pt-6 border-t border-gray-200">
                        <h3 class="text-lg font-bold text-[#1E1C1C] mb-4">Employment Information</h3>
                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <p class="text-xs text-gray-500 mb-1">Employment Status</p>
                                <p class="text-gray-800 font-medium">{{ ucfirst($application->employment_status ?? 'N/A') }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 mb-1">Annual Income</p>
                                <p class="text-gray-800 font-medium">${{ number_format($application->annual_income ?? 0) }}</p>
                            </div>
                            @if($application->employer_name)
                            <div>
                                <p class="text-xs text-gray-500 mb-1">Employer</p>
                                <p class="text-gray-800 font-medium">{{ $application->employer_name }}</p>
                            </div>
                            @endif
                            @if($application->job_title)
                            <div>
                                <p class="text-xs text-gray-500 mb-1">Job Title</p>
                                <p class="text-gray-800 font-medium">{{ $application->job_title }}</p>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Additional Information -->
                    @if($application->additional_information)
                    <div class="pt-6 border-t border-gray-200">
                        <h3 class="text-lg font-bold text-[#1E1C1C] mb-4">Additional Information</h3>
                        <p class="text-gray-700 leading-relaxed">{{ $application->additional_information }}</p>
                    </div>
                    @endif

                    <!-- Documents -->
                    @if($application->documents && count($application->documents) > 0)
                    <div class="pt-6 border-t border-gray-200">
                        <h3 class="text-lg font-bold text-[#1E1C1C] mb-4">Uploaded Documents</h3>
                        <div class="grid md:grid-cols-2 gap-4">
                            @foreach($application->documents as $document)
                            <a href="{{ $document['url'] ?? '#' }}" 
                               target="_blank"
                               class="flex items-center gap-3 p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                <svg class="w-8 h-8 text-[#5E17EB]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                <div>
                                    <p class="font-medium text-gray-800">{{ $document['name'] ?? 'Document' }}</p>
                                    <p class="text-sm text-gray-500">{{ $document['type'] ?? 'PDF' }}</p>
                                </div>
                            </a>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Agency Notes -->
                    @if($application->agency_notes && $application->reviewed_at)
                    <div class="pt-6 border-t border-gray-200">
                        <h3 class="text-lg font-bold text-[#1E1C1C] mb-4">Agency Notes</h3>
                        <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded-r-lg">
                            <p class="text-gray-700">{{ $application->agency_notes }}</p>
                            <p class="text-sm text-gray-500 mt-2">
                                Reviewed on {{ $application->reviewed_at->format('d/m/Y \a\t H:i') }}
                            </p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        @if($application->status === 'pending')
        <div class="mt-6 flex justify-end gap-4">
            <button onclick="confirmWithdraw()" 
                    class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg font-semibold hover:bg-gray-300 transition-colors">
                Withdraw Application
            </button>
        </div>
        @endif

    </div>
</div>

@push('scripts')
<script>
function toggleContactInfo() {
    const content = document.getElementById('contactInfoContent');
    const icon = document.getElementById('contactInfoIcon');
    
    if (content.classList.contains('hidden')) {
        content.classList.remove('hidden');
        icon.style.transform = 'rotate(180deg)';
    } else {
        content.classList.add('hidden');
        icon.style.transform = 'rotate(0deg)';
    }
}

function toggleAdditionalDetails() {
    const content = document.getElementById('additionalDetailsContent');
    const icon = document.getElementById('additionalDetailsIcon');
    
    if (content.classList.contains('hidden')) {
        content.classList.remove('hidden');
        icon.style.transform = 'rotate(180deg)';
    } else {
        content.classList.add('hidden');
        icon.style.transform = 'rotate(0deg)';
    }
}

function confirmWithdraw() {
    if (confirm('Are you sure you want to withdraw this application? This action cannot be undone.')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("user.applications.withdraw", $application->id) }}';
        
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = '{{ csrf_token() }}';
        form.appendChild(csrfInput);
        
        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'PATCH';
        form.appendChild(methodInput);
        
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
@endpush
@endsection