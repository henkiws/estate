<x-user-layout title="Dashboard">
    <!-- Welcome Section -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Welcome back, {{ Auth::user()->name }}!</h1>
        <p class="mt-2 text-gray-600">Manage your saved properties, applications, and enquiries.</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <!-- Saved Properties -->
        <div class="bg-white rounded-2xl border border-gray-200 p-6 hover:shadow-lg transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-red-600" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                </div>
            </div>
            <h3 class="text-3xl font-bold text-gray-900 mb-1">{{ $stats['saved_properties'] }}</h3>
            <p class="text-sm text-gray-600 mb-4">Saved Properties</p>
            <a href="{{ route('user.saved-properties') }}" class="text-sm text-primary hover:text-primary-dark font-medium">
                View all →
            </a>
        </div>

        <!-- Applications -->
        <div class="bg-white rounded-2xl border border-gray-200 p-6 hover:shadow-lg transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
            </div>
            <h3 class="text-3xl font-bold text-gray-900 mb-1">{{ $stats['applications'] }}</h3>
            <p class="text-sm text-gray-600 mb-4">Total Applications</p>
            <a href="{{ route('user.applications') }}" class="text-sm text-primary hover:text-primary-dark font-medium">
                View all →
            </a>
        </div>

        <!-- Pending Applications -->
        <div class="bg-white rounded-2xl border border-gray-200 p-6 hover:shadow-lg transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            <h3 class="text-3xl font-bold text-gray-900 mb-1">{{ $stats['pending_applications'] }}</h3>
            <p class="text-sm text-gray-600 mb-4">Pending Review</p>
            <a href="{{ route('user.applications') }}?status=pending" class="text-sm text-primary hover:text-primary-dark font-medium">
                View all →
            </a>
        </div>

        <!-- Enquiries -->
        <div class="bg-white rounded-2xl border border-gray-200 p-6 hover:shadow-lg transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
            </div>
            <h3 class="text-3xl font-bold text-gray-900 mb-1">{{ $stats['enquiries'] }}</h3>
            <p class="text-sm text-gray-600 mb-4">Enquiries Sent</p>
            <a href="{{ route('user.enquiries') }}" class="text-sm text-primary hover:text-primary-dark font-medium">
                View all →
            </a>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-2xl border border-gray-200 p-6 mb-8">
        <h2 class="text-xl font-bold text-gray-900 mb-4">Quick Actions</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="{{ route('properties.index') }}" class="flex items-center gap-4 p-4 border border-gray-200 rounded-xl hover:border-primary hover:bg-primary/5 transition-colors">
                <div class="w-10 h-10 bg-primary/10 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="font-semibold text-gray-900">Browse Properties</p>
                    <p class="text-sm text-gray-600">Find your next home</p>
                </div>
            </a>

            <a href="{{ route('user.saved-properties') }}" class="flex items-center gap-4 p-4 border border-gray-200 rounded-xl hover:border-primary hover:bg-primary/5 transition-colors">
                <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="font-semibold text-gray-900">Saved Properties</p>
                    <p class="text-sm text-gray-600">View favorites</p>
                </div>
            </a>

            <a href="{{ route('user.applications') }}" class="flex items-center gap-4 p-4 border border-gray-200 rounded-xl hover:border-primary hover:bg-primary/5 transition-colors">
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <div>
                    <p class="font-semibold text-gray-900">My Applications</p>
                    <p class="text-sm text-gray-600">Track status</p>
                </div>
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Recently Saved Properties -->
        <div class="bg-white rounded-2xl border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-gray-900">Recently Saved</h2>
                @if($recentSaved->count() > 0)
                    <a href="{{ route('user.saved-properties') }}" class="text-sm text-primary hover:text-primary-dark font-medium">
                        View all →
                    </a>
                @endif
            </div>

            @if($recentSaved->count() > 0)
                <div class="space-y-4">
                    @foreach($recentSaved as $property)
                        <a href="{{ route('properties.show', $property->property_code) }}" class="flex gap-4 p-4 border border-gray-200 rounded-xl hover:border-primary hover:bg-primary/5 transition-colors">
                            <div class="w-24 h-24 bg-gray-100 rounded-lg overflow-hidden flex-shrink-0">
                                @if($property->featuredImage)
                                    <img src="{{ Storage::disk('public')->url($property->featuredImage->file_path) }}" 
                                         alt="{{ $property->short_address }}"
                                         class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-semibold text-gray-900 truncate">{{ $property->short_address }}</p>
                                <p class="text-sm text-gray-600">{{ $property->suburb }}</p>
                                <p class="text-lg font-bold text-primary mt-1">{{ $property->display_price }}</p>
                                <div class="flex items-center gap-3 mt-2 text-sm text-gray-600">
                                    @if($property->bedrooms)
                                        <span>{{ $property->bedrooms }} bed</span>
                                    @endif
                                    @if($property->bathrooms)
                                        <span>{{ $property->bathrooms }} bath</span>
                                    @endif
                                    @if($property->parking_spaces)
                                        <span>{{ $property->parking_spaces }} car</span>
                                    @endif
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                    <p class="text-gray-500 mb-4">No saved properties yet</p>
                    <a href="{{ route('properties.index') }}" class="text-primary hover:text-primary-dark font-medium">
                        Browse Properties →
                    </a>
                </div>
            @endif
        </div>

        <!-- Recent Applications -->
        <div class="bg-white rounded-2xl border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-gray-900">Recent Applications</h2>
                @if($recentApplications->count() > 0)
                    <a href="{{ route('user.applications') }}" class="text-sm text-primary hover:text-primary-dark font-medium">
                        View all →
                    </a>
                @endif
            </div>

            @if($recentApplications->count() > 0)
                <div class="space-y-4">
                    @foreach($recentApplications as $application)
                        <a href="{{ route('user.applications.show', $application) }}" class="block p-4 border border-gray-200 rounded-xl hover:border-primary hover:bg-primary/5 transition-colors">
                            <div class="flex items-start justify-between mb-2">
                                <div class="flex-1">
                                    <p class="font-semibold text-gray-900">{{ $application->property->short_address }}</p>
                                    <p class="text-sm text-gray-600">{{ $application->property->suburb }}</p>
                                </div>
                                <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full
                                    @if($application->status === 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($application->status === 'approved') bg-green-100 text-green-800
                                    @elseif($application->status === 'rejected') bg-red-100 text-red-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    {{ $application->status_label }}
                                </span>
                            </div>
                            <p class="text-sm text-gray-500">
                                Submitted {{ $application->submitted_at->diffForHumans() }}
                            </p>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <p class="text-gray-500 mb-4">No applications yet</p>
                    <a href="{{ route('properties.index') }}?listing_type=rent" class="text-primary hover:text-primary-dark font-medium">
                        Browse Rentals →
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-user-layout>