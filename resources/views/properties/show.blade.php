@extends('layouts.app')

@section('content')
<div class="py-8">
    <div class="max-w-6xl mx-auto px-4">
        <!-- Gallery -->
        <x-property-gallery :images="$property->images" />
        
        <!-- Property Info -->
        <div class="mt-8 grid md:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="md:col-span-2">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <h1 class="text-3xl font-bold mb-2">{{ $property->address }}</h1>
                        <p class="text-gray-600">{{ $property->suburb }}, {{ $property->state }} {{ $property->postcode }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-3xl font-bold text-teal-600">${{ number_format($property->price_per_week) }}</p>
                        <p class="text-gray-500">/week</p>
                    </div>
                </div>
                
                <!-- Features -->
                <div class="flex gap-6 mb-6 pb-6 border-b">
                    <span class="flex items-center gap-2 text-gray-700">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">...</svg>
                        {{ $property->bedrooms }} Bedrooms
                    </span>
                    <span class="flex items-center gap-2 text-gray-700">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">...</svg>
                        {{ $property->bathrooms }} Bathrooms
                    </span>
                    <span class="flex items-center gap-2 text-gray-700">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">...</svg>
                        {{ $property->parking_spaces }} Parking
                    </span>
                </div>
                
                <!-- Description -->
                <div class="mb-8">
                    <h2 class="text-xl font-bold mb-3">About This Property</h2>
                    <p class="text-gray-700 leading-relaxed">{{ $property->description }}</p>
                </div>
                
                <!-- Features List -->
                @if($property->features)
                    <div class="mb-8">
                        <h2 class="text-xl font-bold mb-3">Features & Amenities</h2>
                        <div class="grid grid-cols-2 gap-3">
                            @foreach($property->features as $feature)
                                <span class="flex items-center gap-2 text-gray-700">
                                    <svg class="w-5 h-5 text-teal-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $feature }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
            
            <!-- Sidebar -->
            <div>
                <div class="bg-white rounded-xl shadow-lg border p-6 sticky top-4">
                    <h3 class="font-bold mb-4">Interested?</h3>
                    
                    <div class="space-y-3">
                        @auth
                            <a href="{{ route('user.applications.create', ['property_id' => $property->id]) }}" 
                                class="block w-full py-3 bg-teal-600 text-white text-center font-semibold rounded-lg hover:bg-teal-700">
                                Apply Now
                            </a>
                            
                            <button onclick="toggleFavorite({{ $property->id }}, this)"
                                class="w-full py-3 border-2 {{ $isFavorited ? 'border-red-500 text-red-500' : 'border-gray-300' }} rounded-lg hover:border-red-500">
                                {{ $isFavorited ? '♥ Saved' : '♡ Save Property' }}
                            </button>
                        @else
                            <a href="{{ route('login') }}" 
                                class="block w-full py-3 bg-teal-600 text-white text-center font-semibold rounded-lg">
                                Login to Apply
                            </a>
                        @endauth
                        
                        <button class="w-full py-3 bg-gray-100 rounded-lg hover:bg-gray-200">
                            Schedule Inspection
                        </button>
                    </div>
                    
                    <!-- Agency Info -->
                    @if($property->agency)
                        <div class="mt-6 pt-6 border-t">
                            <p class="text-sm text-gray-600 mb-1">Managed by</p>
                            <p class="font-semibold">{{ $property->agency->name }}</p>
                            <p class="text-sm text-gray-600">{{ $property->agency->phone }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Similar Properties -->
        @if($similarProperties->count() > 0)
            <div class="mt-12">
                <h2 class="text-2xl font-bold mb-6">Similar Properties</h2>
                <div class="grid grid-cols-3 gap-6">
                    @foreach($similarProperties as $similar)
                        <x-property-card :property="$similar" viewMode="grid" />
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
@endsection