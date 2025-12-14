@extends('layouts.user')

@section('title', 'Application Details')

@section('content')
<div class="py-8">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('user.applications.index') }}" class="inline-flex items-center text-teal-600 hover:text-teal-700 font-medium">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Back to Applications
            </a>
        </div>
        
        <!-- Property Info Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-6">
            @if($application->property->images->count() > 0)
                <img 
                    src="{{ Storage::url($application->property->images->first()->image_path) }}" 
                    alt="{{ $application->property->address }}"
                    class="w-full h-64 object-cover"
                >
            @endif
            
            <div class="p-6">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 mb-2">{{ $application->property->address }}</h1>
                        <p class="text-gray-600">{{ $application->property->suburb }}, {{ $application->property->state }} {{ $application->property->postcode }}</p>
                    </div>
                    <x-application-status-badge :status="$application->status" size="lg" />
                </div>
                
                <div class="flex flex-wrap gap-4 text-sm text-gray-600">
                    <span class="flex items-center gap-1">
                        💰 ${{ number_format($application->property->price_per_week) }}/week
                    </span>
                    <span class="flex items-center gap-1">
                        🛏 {{ $application->property->bedrooms }} bed
                    </span>
                    <span class="flex items-center gap-1">
                        🚿 {{ $application->property->bathrooms }} bath
                    </span>
                    <span class="flex items-center gap-1">
                        🚗 {{ $application->property->parking_spaces }} parking
                    </span>
                </div>
                
                @if($application->property->agency)
                    <p class="text-sm text-gray-500 mt-4">Managed by {{ $application->property->agency->name }}</p>
                @endif
            </div>
        </div>
        
        <div class="grid md:grid-cols-2 gap-6">
            
            <!-- Application Timeline -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-6">Application Timeline</h2>
                <x-application-timeline :application="$application" />
            </div>
            
            <!-- Application Details -->
            <div class="space-y-6">
                
                <!-- Application Info -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">Application Details</h2>
                    
                    <div class="space-y-3">
                        <div>
                            <p class="text-sm text-gray-500">Move-in Date</p>
                            <p class="font-medium text-gray-900">{{ $application->move_in_date->format('F j, Y') }}</p>
                        </div>
                        
                        <div>
                            <p class="text-sm text-gray-500">Lease Term</p>
                            <p class="font-medium text-gray-900">{{ $application->lease_term }} months</p>
                        </div>
                        
                        <div>
                            <p class="text-sm text-gray-500">Number of Occupants</p>
                            <p class="font-medium text-gray-900">{{ $application->number_of_occupants }}</p>
                        </div>
                        
                        @if($application->occupants_details)
                            <div>
                                <p class="text-sm text-gray-500 mb-2">Occupants</p>
                                <div class="space-y-2">
                                    @foreach($application->occupants_details as $occupant)
                                        <div class="p-3 bg-gray-50 rounded-lg">
                                            <p class="font-medium text-sm">{{ $occupant['name'] }}</p>
                                            <p class="text-xs text-gray-600">{{ $occupant['relationship'] }}</p>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        
                        @if($application->special_requests)
                            <div>
                                <p class="text-sm text-gray-500">Special Requests</p>
                                <p class="text-gray-700 text-sm">{{ $application->special_requests }}</p>
                            </div>
                        @endif
                        
                        @if($application->notes)
                            <div>
                                <p class="text-sm text-gray-500">Additional Notes</p>
                                <p class="text-gray-700 text-sm">{{ $application->notes }}</p>
                            </div>
                        @endif
                        
                        <div class="pt-3 border-t">
                            <p class="text-xs text-gray-500">Applied {{ $application->getDaysAgo() }}</p>
                        </div>
                    </div>
                </div>
                
                <!-- Actions -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="font-bold text-gray-900 mb-4">Actions</h3>
                    
                    <div class="space-y-3">
                        @if($application->canEdit())
                            <a 
                                href="{{ route('user.applications.edit', $application) }}" 
                                class="block w-full px-4 py-3 bg-teal-600 text-white text-center font-semibold rounded-lg hover:bg-teal-700 transition"
                            >
                                Edit Application
                            </a>
                            
                            <form method="POST" action="{{ route('user.applications.submit', $application) }}">
                                @csrf
                                <button 
                                    type="submit"
                                    class="w-full px-4 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition"
                                >
                                    Submit Application
                                </button>
                            </form>
                        @endif
                        
                        @if($application->canWithdraw())
                            <form 
                                method="POST" 
                                action="{{ route('user.applications.withdraw', $application) }}"
                                onsubmit="return confirm('Are you sure you want to withdraw this application? This action cannot be undone.')"
                            >
                                @csrf
                                <button 
                                    type="submit"
                                    class="w-full px-4 py-3 bg-red-100 text-red-700 font-semibold rounded-lg hover:bg-red-200 transition"
                                >
                                    Withdraw Application
                                </button>
                            </form>
                        @endif
                        
                        <a 
                            href="{{ route('properties.show', $application->property) }}" 
                            class="block w-full px-4 py-3 bg-gray-100 text-gray-700 text-center font-semibold rounded-lg hover:bg-gray-200 transition"
                        >
                            View Property
                        </a>
                    </div>
                </div>
                
            </div>
            
        </div>
        
    </div>
</div>
@endsection