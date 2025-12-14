<x-user-layout title="My Applications">
    <!-- Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">My Applications</h1>
            <p class="mt-2 text-gray-600">Track your rental applications</p>
        </div>
    </div>

    <!-- Filter Tabs -->
    <div class="bg-white rounded-2xl border border-gray-200 mb-8 overflow-hidden">
        <div class="flex border-b border-gray-200 overflow-x-auto">
            <a href="{{ route('user.applications') }}" 
               class="px-6 py-4 font-medium text-sm transition-colors whitespace-nowrap {{ !request('status') ? 'border-b-2 border-primary text-primary bg-primary/5' : 'text-gray-600 hover:text-primary' }}">
                All Applications ({{ $applications->total() }})
            </a>
            <a href="{{ route('user.applications') }}?status=pending" 
               class="px-6 py-4 font-medium text-sm transition-colors whitespace-nowrap {{ request('status') === 'pending' ? 'border-b-2 border-primary text-primary bg-primary/5' : 'text-gray-600 hover:text-primary' }}">
                Pending
            </a>
            <a href="{{ route('user.applications') }}?status=approved" 
               class="px-6 py-4 font-medium text-sm transition-colors whitespace-nowrap {{ request('status') === 'approved' ? 'border-b-2 border-primary text-primary bg-primary/5' : 'text-gray-600 hover:text-primary' }}">
                Approved
            </a>
            <a href="{{ route('user.applications') }}?status=rejected" 
               class="px-6 py-4 font-medium text-sm transition-colors whitespace-nowrap {{ request('status') === 'rejected' ? 'border-b-2 border-primary text-primary bg-primary/5' : 'text-gray-600 hover:text-primary' }}">
                Rejected
            </a>
            <a href="{{ route('user.applications') }}?status=withdrawn" 
               class="px-6 py-4 font-medium text-sm transition-colors whitespace-nowrap {{ request('status') === 'withdrawn' ? 'border-b-2 border-primary text-primary bg-primary/5' : 'text-gray-600 hover:text-primary' }}">
                Withdrawn
            </a>
        </div>
    </div>

    @if($applications->count() > 0)
        <!-- Applications List -->
        <div class="space-y-4 mb-8">
            @foreach($applications as $application)
                <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden hover:shadow-lg transition-shadow">
                    <div class="p-6">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex gap-4 flex-1">
                                <!-- Property Image -->
                                <div class="w-24 h-24 bg-gray-100 rounded-xl overflow-hidden flex-shrink-0">
                                    @if($application->property->featuredImage)
                                        <img src="{{ Storage::disk('public')->url($application->property->featuredImage->file_path) }}" 
                                             alt="{{ $application->property->short_address }}"
                                             class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-gray-400">
                                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                            </svg>
                                        </div>
                                    @endif
                                </div>

                                <!-- Property Details -->
                                <div class="flex-1">
                                    <a href="{{ route('properties.show', $application->property->property_code) }}" 
                                       class="text-lg font-bold text-gray-900 hover:text-primary">
                                        {{ $application->property->full_address }}
                                    </a>
                                    <p class="text-sm text-gray-600 mt-1">{{ $application->property->suburb }}, {{ $application->property->state }}</p>
                                    
                                    <div class="flex items-center gap-4 mt-2 text-sm text-gray-600">
                                        @if($application->property->bedrooms)
                                            <span>{{ $application->property->bedrooms }} bed</span>
                                        @endif
                                        @if($application->property->bathrooms)
                                            <span>{{ $application->property->bathrooms }} bath</span>
                                        @endif
                                        <span class="text-primary font-semibold">{{ $application->property->display_price }}</span>
                                    </div>

                                    <!-- Application Info -->
                                    <div class="mt-3 flex items-center gap-4 text-sm">
                                        <span class="text-gray-600">
                                            <strong>Submitted:</strong> {{ $application->submitted_at->format('M d, Y') }}
                                        </span>
                                        @if($application->reviewed_at)
                                            <span class="text-gray-600">
                                                <strong>Reviewed:</strong> {{ $application->reviewed_at->format('M d, Y') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Status Badge -->
                            <span class="inline-flex px-4 py-2 text-sm font-semibold rounded-full flex-shrink-0
                                @if($application->status === 'pending') bg-yellow-100 text-yellow-800
                                @elseif($application->status === 'approved') bg-green-100 text-green-800
                                @elseif($application->status === 'rejected') bg-red-100 text-red-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                {{ $application->status_label }}
                            </span>
                        </div>

                        <!-- Agency Notes (if any) -->
                        @if($application->agency_notes && $application->status !== 'pending')
                            <div class="mb-4 p-4 bg-blue-50 border border-blue-200 rounded-xl">
                                <p class="text-sm font-semibold text-blue-900 mb-1">Agency Feedback:</p>
                                <p class="text-sm text-blue-800">{{ $application->agency_notes }}</p>
                            </div>
                        @endif

                        <!-- Actions -->
                        <div class="flex items-center gap-3">
                            <a href="{{ route('user.applications.show', $application) }}" 
                               class="px-6 py-2 bg-primary hover:bg-primary-dark text-white font-medium rounded-xl transition-colors">
                                View Details
                            </a>

                            <a href="{{ route('properties.show', $application->property->property_code) }}" 
                               class="px-6 py-2 border border-gray-300 hover:border-primary hover:text-primary text-gray-700 font-medium rounded-xl transition-colors">
                                View Property
                            </a>

                            @if($application->status === 'pending')
                                <form action="{{ route('user.applications.withdraw', $application) }}" method="POST" class="ml-auto">
                                    @csrf
                                    <button type="submit" 
                                            onclick="return confirm('Are you sure you want to withdraw this application? This action cannot be undone.')"
                                            class="px-6 py-2 border border-red-300 text-red-600 hover:bg-red-50 font-medium rounded-xl transition-colors">
                                        Withdraw
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $applications->links() }}
        </div>
    @else
        <!-- Empty State -->
        <div class="bg-white rounded-2xl border border-gray-200 p-12 text-center">
            <svg class="w-20 h-20 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <h3 class="text-xl font-bold text-gray-900 mb-2">No applications found</h3>
            <p class="text-gray-600 mb-6">
                @if(request('status'))
                    No {{ request('status') }} applications at the moment
                @else
                    You haven't submitted any rental applications yet
                @endif
            </p>
            <a href="{{ route('properties.index') }}?listing_type=rent" class="inline-block px-6 py-3 bg-primary hover:bg-primary-dark text-white font-semibold rounded-xl transition-colors">
                Browse Rental Properties
            </a>
        </div>
    @endif
</x-user-layout>