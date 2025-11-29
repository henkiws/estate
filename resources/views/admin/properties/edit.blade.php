@extends('layouts.admin')

@section('title', 'Edit Property')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <a href="{{ route('admin.properties.show', $property) }}" class="text-blue-600 hover:text-blue-800 mb-2 inline-block">
                ← Back to Property Details
            </a>
            <h1 class="text-3xl font-bold text-gray-900">Edit Property</h1>
            <p class="text-gray-600 mt-1">{{ $property->title }} (ID: {{ $property->property_id }})</p>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.properties.update', $property) }}" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Form -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Property Information Card -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">Property Information</h2>
                    
                    <div class="bg-gray-50 rounded-lg p-4 mb-6">
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <p class="text-gray-600">Title:</p>
                                <p class="font-semibold">{{ $property->title }}</p>
                            </div>
                            <div>
                                <p class="text-gray-600">Property ID:</p>
                                <p class="font-semibold">{{ $property->property_id }}</p>
                            </div>
                            <div>
                                <p class="text-gray-600">Listing Type:</p>
                                <p class="font-semibold">{{ ucfirst($property->listing_type) }}</p>
                            </div>
                            <div>
                                <p class="text-gray-600">Property Type:</p>
                                <p class="font-semibold">{{ $property->property_type }}</p>
                            </div>
                            <div>
                                <p class="text-gray-600">Address:</p>
                                <p class="font-semibold">{{ $property->street_address }}, {{ $property->suburb }}</p>
                            </div>
                            <div>
                                <p class="text-gray-600">Price:</p>
                                <p class="font-semibold">
                                    @if($property->listing_type === 'sale')
                                        ${{ number_format($property->sale_price) }}
                                    @else
                                        ${{ number_format($property->rent_amount) }}/{{ $property->rent_period }}
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Admin Controls -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">Admin Controls</h2>
                    
                    <!-- Property Status -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Property Status <span class="text-red-500">*</span>
                        </label>
                        <select name="status" 
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="active" {{ $property->status === 'active' ? 'selected' : '' }}>
                                Active - Visible to public
                            </option>
                            <option value="pending" {{ $property->status === 'pending' ? 'selected' : '' }}>
                                Pending - Awaiting approval
                            </option>
                            <option value="sold" {{ $property->status === 'sold' ? 'selected' : '' }}>
                                Sold - Property has been sold
                            </option>
                            <option value="rented" {{ $property->status === 'rented' ? 'selected' : '' }}>
                                Rented - Property has been rented
                            </option>
                            <option value="withdrawn" {{ $property->status === 'withdrawn' ? 'selected' : '' }}>
                                Withdrawn - Hidden from public
                            </option>
                        </select>
                        <p class="text-sm text-gray-500 mt-1">
                            Current status: <strong>{{ ucfirst($property->status) }}</strong>
                        </p>
                    </div>

                    <!-- Featured Toggle -->
                    <div class="mb-6">
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" 
                                   name="featured" 
                                   value="1"
                                   {{ $property->featured ? 'checked' : '' }}
                                   class="w-5 h-5 text-blue-600 rounded border-gray-300 focus:ring-2 focus:ring-blue-500">
                            <span class="ml-3">
                                <span class="text-sm font-medium text-gray-900">Mark as Featured Property</span>
                                <span class="block text-sm text-gray-500">Featured properties get highlighted visibility</span>
                            </span>
                        </label>
                    </div>

                    <!-- Verified Toggle -->
                    <div class="mb-6">
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" 
                                   name="verified" 
                                   value="1"
                                   {{ $property->verified ? 'checked' : '' }}
                                   class="w-5 h-5 text-blue-600 rounded border-gray-300 focus:ring-2 focus:ring-blue-500">
                            <span class="ml-3">
                                <span class="text-sm font-medium text-gray-900">Mark as Verified</span>
                                <span class="block text-sm text-gray-500">Verified badge indicates admin approval</span>
                            </span>
                        </label>
                    </div>

                    <!-- Admin Notes -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Admin Notes
                        </label>
                        <textarea name="admin_notes" 
                                  rows="4"
                                  placeholder="Add internal notes about this property (not visible to public)..."
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('admin_notes', $property->admin_notes) }}</textarea>
                        <p class="text-sm text-gray-500 mt-1">
                            Internal notes for administrative purposes only
                        </p>
                    </div>
                </div>

                <!-- Change Agency (Optional) -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">Agency Assignment</h2>
                    
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-4">
                        <div class="flex">
                            <svg class="w-5 h-5 text-yellow-600 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            <div>
                                <p class="text-sm font-medium text-yellow-800">Warning: Changing Agency</p>
                                <p class="text-sm text-yellow-700 mt-1">Only change agency if absolutely necessary. This will transfer the property to a different agency.</p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Current Agency: <strong>{{ $property->agency->business_name ?? 'N/A' }}</strong>
                        </label>
                        <select name="agency_id" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="{{ $property->agency_id }}">Keep Current Agency</option>
                            @foreach($agencies as $agency)
                                <option value="{{ $agency->id }}" {{ old('agency_id') == $agency->id ? 'selected' : '' }}>
                                    {{ $agency->business_name }} - {{ $agency->suburb }}, {{ $agency->state }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-4">
                    <button type="submit" 
                            class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors shadow-lg">
                        Save Changes
                    </button>
                    <a href="{{ route('admin.properties.show', $property) }}" 
                       class="px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 transition-colors">
                        Cancel
                    </a>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Current Status Card -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Current Status</h3>
                    
                    <div class="space-y-3">
                        <div>
                            <p class="text-sm text-gray-600">Status:</p>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium mt-1
                                @if($property->status === 'active') bg-green-100 text-green-800
                                @elseif($property->status === 'pending') bg-yellow-100 text-yellow-800
                                @elseif($property->status === 'sold' || $property->status === 'rented') bg-purple-100 text-purple-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                {{ ucfirst($property->status) }}
                            </span>
                        </div>

                        <div>
                            <p class="text-sm text-gray-600">Featured:</p>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium mt-1
                                {{ $property->featured ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-600' }}">
                                {{ $property->featured ? '⭐ Yes' : 'No' }}
                            </span>
                        </div>

                        <div>
                            <p class="text-sm text-gray-600">Verified:</p>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium mt-1
                                {{ $property->verified ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-600' }}">
                                {{ $property->verified ? '✓ Yes' : 'No' }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Property Metadata -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Property Metadata</h3>
                    
                    <div class="space-y-3 text-sm">
                        <div>
                            <p class="text-gray-600">Created:</p>
                            <p class="font-medium">{{ $property->created_at->format('d M Y, H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600">Last Updated:</p>
                            <p class="font-medium">{{ $property->updated_at->format('d M Y, H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600">Total Views:</p>
                            <p class="font-medium">{{ number_format($property->view_count ?? 0) }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600">Images:</p>
                            <p class="font-medium">{{ $property->images->count() }} photos</p>
                        </div>
                    </div>
                </div>

                <!-- Agency Info -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Agency Information</h3>
                    
                    @if($property->agency)
                        <div class="flex items-center mb-3">
                            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                <span class="text-blue-600 font-semibold">
                                    {{ substr($property->agency->business_name, 0, 2) }}
                                </span>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">{{ $property->agency->business_name }}</p>
                                <p class="text-sm text-gray-500">{{ $property->agency->business_email }}</p>
                            </div>
                        </div>
                        
                        <a href="{{ route('admin.agencies.show', $property->agency) }}" 
                           class="block text-center px-4 py-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition text-sm">
                            View Agency Profile
                        </a>
                    @else
                        <p class="text-gray-500 text-sm">No agency assigned</p>
                    @endif
                </div>

                <!-- Quick Actions -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Quick Actions</h3>
                    
                    <div class="space-y-2">
                        <a href="{{ route('admin.properties.show', $property) }}" 
                           class="block px-4 py-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition text-sm text-center">
                            View Details
                        </a>
                        
                        <a href="{{ route('admin.properties.index') }}" 
                           class="block px-4 py-2 bg-gray-50 text-gray-600 rounded-lg hover:bg-gray-100 transition text-sm text-center">
                            Back to List
                        </a>
                        
                        <form action="{{ route('admin.properties.destroy', $property) }}" 
                              method="POST" 
                              onsubmit="return confirm('Are you sure you want to delete this property? This action cannot be undone.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="w-full px-4 py-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition text-sm">
                                Delete Property
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection