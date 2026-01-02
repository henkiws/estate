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
                            {{ $application->status_label }}
                        </span>
                        
                        <!-- Submission Date -->
                        <span class="text-gray-500 text-sm">
                            Applied {{ $application->getDaysAgo() }}
                        </span>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-2">
                        @if($application->canEdit())
                            <a href="{{ route('user.applications.edit', $application) }}" 
                               class="px-4 py-2 bg-gray-100 text-gray-700 font-medium rounded-lg hover:bg-gray-200 transition">
                                Edit
                            </a>
                        @endif
                        
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
                            {{ $application->property->title ?? $application->property->street_address }}
                        </h1>
                        <p class="text-gray-600 mb-4">
                            {{ $application->property->suburb }}, {{ $application->property->state }} {{ $application->property->postcode }}
                        </p>

                        <!-- Property Features -->
                        <div class="flex flex-wrap items-center gap-4 text-gray-700 mb-4">
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                                </svg>
                                <span class="text-sm font-medium">{{ $application->property->bedrooms }} bed</span>
                            </div>

                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3 5a2 2 0 012-2h10a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V5zm11 1H6v8l.01.01h7.99V6z" clip-rule="evenodd"/>
                                </svg>
                                <span class="text-sm font-medium">{{ $application->property->bathrooms }} bath</span>
                            </div>

                            @if($application->property->parking)
                                <div class="flex items-center gap-2">
                                    <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                                        <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z"/>
                                    </svg>
                                    <span class="text-sm font-medium">{{ $application->property->parking }} car</span>
                                </div>
                            @endif
                        </div>

                        <!-- Price -->
                        @if($application->property->listing_type === 'rent')
                            <p class="text-3xl font-bold text-teal-600">
                                ${{ number_format($application->property->rent_amount) }}<span class="text-lg text-gray-600">/{{ $application->property->rent_period }}</span>
                            </p>
                        @else
                            <p class="text-3xl font-bold text-teal-600">
                                ${{ number_format($application->property->sale_price) }}
                            </p>
                        @endif
                    </div>

                    <!-- Agency Info -->
                    @if($application->agency)
                        <div class="text-right border-l border-gray-200 pl-6 flex-shrink-0">
                            @if($application->agency->branding && $application->agency->branding->logo_path)
                                <img src="{{ Storage::url($application->agency->branding->logo_path) }}" 
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
        <div class="grid lg:grid-cols-3 gap-6 mb-6">
            <!-- Move-in Date Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 bg-teal-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-900">Move-in Date</h3>
                </div>
                <p class="text-2xl font-bold text-gray-900">
                    {{ $application->move_in_date->format('M j, Y') }}
                </p>
                <p class="text-sm text-gray-500 mt-1">
                    {{ $application->move_in_date->diffForHumans() }}
                </p>
            </div>

            <!-- Lease Term Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-900">Lease Term</h3>
                </div>
                <p class="text-2xl font-bold text-gray-900">
                    {{ $application->lease_term ?? 'N/A' }} months
                </p>
                <p class="text-sm text-gray-500 mt-1">
                    Requested duration
                </p>
            </div>

            <!-- Occupants Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-900">Occupants</h3>
                </div>
                <p class="text-2xl font-bold text-gray-900">
                    {{ $application->number_of_occupants }}
                </p>
                <p class="text-sm text-gray-500 mt-1">
                    Total people
                </p>
            </div>
        </div>

        <!-- Occupants Details -->
        @if($application->occupants_details && count($application->occupants_details) > 0)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
                <h2 class="text-lg font-bold text-gray-900 mb-4">Occupant Details</h2>
                <div class="space-y-4">
                    @foreach($application->occupants_details as $index => $occupant)
                        <div class="p-4 {{ $index === 0 ? 'bg-teal-50 border-2 border-teal-200' : 'bg-gray-50 border border-gray-200' }} rounded-lg">
                            <div class="flex items-center gap-3 mb-2">
                                <div class="w-10 h-10 {{ $index === 0 ? 'bg-teal-600' : 'bg-gray-400' }} rounded-full flex items-center justify-center text-white font-bold">
                                    {{ strtoupper(substr($occupant['first_name'] ?? 'O', 0, 1)) }}{{ strtoupper(substr($occupant['last_name'] ?? 'O', 0, 1)) }}
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center gap-2">
                                        <h4 class="font-semibold text-gray-900">
                                            {{ $occupant['first_name'] ?? 'N/A' }} {{ $occupant['last_name'] ?? '' }}
                                        </h4>
                                        @if($index === 0)
                                            <span class="text-xs bg-teal-600 text-white px-2 py-1 rounded-full font-medium">Primary</span>
                                        @endif
                                    </div>
                                    <p class="text-sm text-gray-600">{{ $occupant['relationship'] ?? 'N/A' }}</p>
                                </div>
                                @if(isset($occupant['age']))
                                    <div class="text-right">
                                        <p class="text-sm text-gray-500">Age</p>
                                        <p class="font-semibold text-gray-900">{{ $occupant['age'] }}</p>
                                    </div>
                                @endif
                            </div>
                            @if(isset($occupant['email']) && $index === 0)
                                <div class="mt-3 pt-3 border-t border-teal-200">
                                    <p class="text-sm text-gray-600">
                                        <span class="font-medium">Email:</span> {{ $occupant['email'] }}
                                    </p>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Additional Information -->
        @if($application->special_requests || $application->notes)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
                <h2 class="text-lg font-bold text-gray-900 mb-4">Additional Information</h2>
                
                @if($application->special_requests)
                    <div class="mb-4">
                        <h3 class="font-semibold text-gray-700 mb-2">Special Requests</h3>
                        <p class="text-gray-600 leading-relaxed">{{ $application->special_requests }}</p>
                    </div>
                @endif
                
                @if($application->notes)
                    <div>
                        <h3 class="font-semibold text-gray-700 mb-2">Additional Notes</h3>
                        <p class="text-gray-600 leading-relaxed">{{ $application->notes }}</p>
                    </div>
                @endif
            </div>
        @endif

        <!-- Agency Review Notes -->
        @if($application->agency_notes)
            <div class="bg-blue-50 border-l-4 border-blue-500 rounded-xl p-6">
                <div class="flex items-start gap-3">
                    <svg class="w-6 h-6 text-blue-600 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div class="flex-1">
                        <h3 class="font-bold text-blue-900 mb-2">Agency Response</h3>
                        <p class="text-blue-800 leading-relaxed">{{ $application->agency_notes }}</p>
                        @if($application->reviewed_at)
                            <p class="text-sm text-blue-600 mt-2">
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