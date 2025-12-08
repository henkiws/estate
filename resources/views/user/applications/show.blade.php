<x-user-layout title="Application Details">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('user.applications') }}" class="inline-flex items-center gap-2 text-gray-600 hover:text-primary">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back to Applications
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Status Card -->
            <div class="bg-white rounded-2xl border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-2xl font-bold text-gray-900">Application Status</h2>
                    <span class="inline-flex px-4 py-2 text-sm font-semibold rounded-full
                        @if($application->status === 'pending') bg-yellow-100 text-yellow-800
                        @elseif($application->status === 'approved') bg-green-100 text-green-800
                        @elseif($application->status === 'rejected') bg-red-100 text-red-800
                        @else bg-gray-100 text-gray-800
                        @endif">
                        {{ $application->status_label }}
                    </span>
                </div>

                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-gray-600 mb-1">Submitted</p>
                        <p class="font-semibold text-gray-900">{{ $application->submitted_at->format('M d, Y g:i A') }}</p>
                    </div>
                    @if($application->reviewed_at)
                        <div>
                            <p class="text-gray-600 mb-1">Reviewed</p>
                            <p class="font-semibold text-gray-900">{{ $application->reviewed_at->format('M d, Y g:i A') }}</p>
                        </div>
                    @endif
                </div>

                @if($application->agency_notes)
                    <div class="mt-4 p-4 bg-blue-50 border border-blue-200 rounded-xl">
                        <p class="text-sm font-semibold text-blue-900 mb-1">Agency Feedback:</p>
                        <p class="text-sm text-blue-800">{{ $application->agency_notes }}</p>
                    </div>
                @endif

                @if($application->status === 'pending')
                    <div class="mt-4 pt-4 border-t border-gray-200">
                        <form action="{{ route('user.applications.withdraw', $application) }}" method="POST">
                            @csrf
                            <button type="submit" 
                                    onclick="return confirm('Are you sure you want to withdraw this application?')"
                                    class="w-full px-6 py-3 border-2 border-red-300 text-red-600 hover:bg-red-50 font-semibold rounded-xl transition-colors">
                                Withdraw Application
                            </button>
                        </form>
                    </div>
                @endif
            </div>

            <!-- Personal Information -->
            <div class="bg-white rounded-2xl border border-gray-200 p-6">
                <h3 class="text-xl font-bold text-gray-900 mb-4">Personal Information</h3>
                
                <div class="grid grid-cols-2 gap-4">
                    <div class="col-span-2 sm:col-span-1">
                        <p class="text-sm text-gray-600 mb-1">Full Name</p>
                        <p class="font-semibold text-gray-900">{{ $application->full_name }}</p>
                    </div>
                    
                    <div class="col-span-2 sm:col-span-1">
                        <p class="text-sm text-gray-600 mb-1">Email</p>
                        <p class="font-semibold text-gray-900">{{ $application->email }}</p>
                    </div>
                    
                    <div class="col-span-2 sm:col-span-1">
                        <p class="text-sm text-gray-600 mb-1">Phone</p>
                        <p class="font-semibold text-gray-900">{{ $application->phone }}</p>
                    </div>
                    
                    @if($application->date_of_birth)
                        <div class="col-span-2 sm:col-span-1">
                            <p class="text-sm text-gray-600 mb-1">Date of Birth</p>
                            <p class="font-semibold text-gray-900">{{ $application->date_of_birth->format('M d, Y') }}</p>
                        </div>
                    @endif
                    
                    <div class="col-span-2">
                        <p class="text-sm text-gray-600 mb-1">Current Address</p>
                        <p class="font-semibold text-gray-900">{{ $application->current_address }}</p>
                    </div>
                </div>
            </div>

            <!-- Move-in Details -->
            <div class="bg-white rounded-2xl border border-gray-200 p-6">
                <h3 class="text-xl font-bold text-gray-900 mb-4">Move-in Details</h3>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Preferred Move-in Date</p>
                        <p class="font-semibold text-gray-900">{{ $application->move_in_date->format('M d, Y') }}</p>
                    </div>
                    
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Number of Occupants</p>
                        <p class="font-semibold text-gray-900">{{ $application->number_of_occupants }}</p>
                    </div>
                    
                    <div class="col-span-2">
                        <p class="text-sm text-gray-600 mb-1">Pets</p>
                        <p class="font-semibold text-gray-900">
                            @if($application->has_pets)
                                Yes - {{ $application->pet_details }}
                            @else
                                No pets
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <!-- Employment Information -->
            <div class="bg-white rounded-2xl border border-gray-200 p-6">
                <h3 class="text-xl font-bold text-gray-900 mb-4">Employment Information</h3>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Employment Status</p>
                        <p class="font-semibold text-gray-900">{{ ucfirst(str_replace('_', ' ', $application->employment_status)) }}</p>
                    </div>
                    
                    @if($application->employer_name)
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Employer</p>
                            <p class="font-semibold text-gray-900">{{ $application->employer_name }}</p>
                        </div>
                    @endif
                    
                    @if($application->job_title)
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Job Title</p>
                            <p class="font-semibold text-gray-900">{{ $application->job_title }}</p>
                        </div>
                    @endif
                    
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Annual Income</p>
                        <p class="font-semibold text-gray-900">${{ number_format($application->annual_income, 2) }}</p>
                    </div>
                </div>
            </div>

            <!-- References -->
            @if($application->references && count($application->references) > 0)
                <div class="bg-white rounded-2xl border border-gray-200 p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">References</h3>
                    
                    <div class="space-y-4">
                        @foreach($application->references as $index => $reference)
                            <div class="p-4 bg-gray-50 rounded-xl">
                                <p class="font-semibold text-gray-900 mb-2">Reference {{ $index + 1 }}</p>
                                <div class="grid grid-cols-2 gap-3 text-sm">
                                    <div>
                                        <p class="text-gray-600">Name</p>
                                        <p class="font-medium text-gray-900">{{ $reference['name'] }}</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-600">Relationship</p>
                                        <p class="font-medium text-gray-900">{{ $reference['relationship'] }}</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-600">Phone</p>
                                        <p class="font-medium text-gray-900">{{ $reference['phone'] }}</p>
                                    </div>
                                    @if(isset($reference['email']))
                                        <div>
                                            <p class="text-gray-600">Email</p>
                                            <p class="font-medium text-gray-900">{{ $reference['email'] }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Additional Information -->
            @if($application->additional_information)
                <div class="bg-white rounded-2xl border border-gray-200 p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Additional Information</h3>
                    <p class="text-gray-700 leading-relaxed">{{ $application->additional_information }}</p>
                </div>
            @endif

            <!-- Documents -->
            @if($application->documents && count($application->documents) > 0)
                <div class="bg-white rounded-2xl border border-gray-200 p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Uploaded Documents</h3>
                    
                    <div class="space-y-3">
                        @foreach($application->documents as $document)
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                                <div class="flex items-center gap-3">
                                    <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                    </svg>
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $document['original_name'] }}</p>
                                        <p class="text-sm text-gray-600">{{ number_format($document['size'] / 1024, 2) }} KB</p>
                                    </div>
                                </div>
                                <a href="{{ Storage::disk('public')->url($document['path']) }}" 
                                   target="_blank"
                                   class="px-4 py-2 text-sm bg-primary hover:bg-primary-dark text-white font-medium rounded-lg transition-colors">
                                    View
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Property Card -->
            <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden sticky top-6">
                <div class="relative h-48 bg-gray-100">
                    @if($application->property->featuredImage)
                        <img src="{{ Storage::disk('public')->url($application->property->featuredImage->file_path) }}" 
                             alt="{{ $application->property->short_address }}"
                             class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-400">
                            <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                        </div>
                    @endif
                </div>

                <div class="p-6">
                    <p class="text-2xl font-bold text-primary mb-2">{{ $application->property->display_price }}</p>
                    <h3 class="text-lg font-bold text-gray-900 mb-1">{{ $application->property->full_address }}</h3>
                    <p class="text-sm text-gray-600 mb-4">{{ $application->property->suburb }}, {{ $application->property->state }}</p>

                    <div class="flex items-center gap-4 mb-6 text-sm text-gray-600">
                        @if($application->property->bedrooms)
                            <span>{{ $application->property->bedrooms }} bed</span>
                        @endif
                        @if($application->property->bathrooms)
                            <span>{{ $application->property->bathrooms }} bath</span>
                        @endif
                        @if($application->property->parking_spaces)
                            <span>{{ $application->property->parking_spaces }} car</span>
                        @endif
                    </div>

                    <a href="{{ route('properties.show', $application->property->property_code) }}" 
                       class="block w-full px-6 py-3 bg-primary hover:bg-primary-dark text-white text-center font-semibold rounded-xl transition-colors">
                        View Property
                    </a>
                </div>
            </div>

            <!-- Agency Info -->
            <div class="bg-white rounded-2xl border border-gray-200 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Managed By</h3>
                <p class="font-semibold text-gray-900 mb-1">{{ $application->property->agency->agency_name }}</p>
                <p class="text-sm text-gray-600 mb-4">{{ $application->property->agency->business_address }}</p>
                
                @if($application->property->agency->business_phone)
                    <a href="tel:{{ $application->property->agency->business_phone }}" 
                       class="flex items-center gap-2 text-sm text-primary hover:text-primary-dark mb-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        {{ $application->property->agency->business_phone }}
                    </a>
                @endif
                
                @if($application->property->agency->business_email)
                    <a href="mailto:{{ $application->property->agency->business_email }}" 
                       class="flex items-center gap-2 text-sm text-primary hover:text-primary-dark">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        {{ $application->property->agency->business_email }}
                    </a>
                @endif
            </div>
        </div>
    </div>
</x-user-layout>