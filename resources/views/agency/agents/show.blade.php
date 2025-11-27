@extends('layouts.admin')

@section('title', $agent->full_name . ' - Agent Profile')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">
    {{-- Back Button --}}
    <div class="flex items-center gap-4">
        <a href="{{ route('agency.agents.index') }}" 
           class="p-2 hover:bg-gray-100 rounded-xl transition-colors">
            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div class="flex-1">
            <h1 class="text-3xl font-bold text-gray-900">Agent Profile</h1>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('agency.agents.edit', $agent->id) }}" 
               class="px-6 py-2.5 bg-primary hover:bg-primary-dark text-white font-medium rounded-xl transition-colors">
                Edit Profile
            </a>
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" 
                        class="p-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl transition-colors">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"/>
                    </svg>
                </button>
                
                <div x-show="open" 
                     @click.away="open = false"
                     class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-200 py-2 z-10">
                    <form action="{{ route('agency.agents.toggle-status', $agent->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                            {{ $agent->status === 'active' ? 'Deactivate Agent' : 'Activate Agent' }}
                        </button>
                    </form>
                    <form action="{{ route('agency.agents.toggle-featured', $agent->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                            {{ $agent->is_featured ? 'Remove from Featured' : 'Add to Featured' }}
                        </button>
                    </form>
                    @if(!$agent->user)
                        <form action="{{ route('agency.agents.send-invitation', $agent->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                Send Invitation
                            </button>
                        </form>
                    @endif
                    <div class="border-t border-gray-100 my-1"></div>
                    <form action="{{ route('agency.agents.destroy', $agent->id) }}" 
                          method="POST" 
                          onsubmit="return confirm('Are you sure you want to delete this agent?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                            Delete Agent
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Profile Header --}}
    <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">
        {{-- Cover & Photo --}}
        <div class="relative h-48 bg-gradient-to-br from-primary via-purple-600 to-pink-500">
            @if($agent->is_featured)
                <div class="absolute top-6 right-6">
                    <span class="inline-flex items-center gap-1 px-4 py-2 bg-yellow-400 text-yellow-900 text-sm font-bold rounded-full shadow-lg">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        Featured Agent
                    </span>
                </div>
            @endif
            
            <div class="absolute -bottom-16 left-8">
                <div class="relative">
                    <img src="{{ $agent->photo_url }}" 
                         alt="{{ $agent->full_name }}"
                         class="w-32 h-32 rounded-2xl border-4 border-white shadow-xl object-cover">
                    @php
                        $statusColors = [
                            'active' => 'bg-green-500',
                            'inactive' => 'bg-gray-500',
                            'on_leave' => 'bg-yellow-500',
                            'terminated' => 'bg-red-500',
                        ];
                    @endphp
                    <div class="absolute bottom-2 right-2 w-6 h-6 {{ $statusColors[$agent->status] ?? 'bg-gray-500' }} border-4 border-white rounded-full"></div>
                </div>
            </div>
        </div>

        <div class="pt-20 px-8 pb-8">
            <div class="flex items-start justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">{{ $agent->full_name }}</h2>
                    <p class="text-lg text-gray-600 mt-1">{{ $agent->position ?? 'Real Estate Agent' }}</p>
                    <div class="flex items-center gap-4 mt-3">
                        <span class="inline-flex items-center gap-1 text-sm text-gray-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                            {{ $agent->agent_code }}
                        </span>
                        <span class="inline-flex items-center gap-1 text-sm text-gray-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            {{ ucwords(str_replace('_', ' ', $agent->employment_type)) }}
                        </span>
                    </div>
                </div>
                
                @php
                    $statusBadges = [
                        'active' => 'bg-green-100 text-green-800',
                        'inactive' => 'bg-gray-100 text-gray-800',
                        'on_leave' => 'bg-yellow-100 text-yellow-800',
                        'terminated' => 'bg-red-100 text-red-800',
                    ];
                @endphp
                <span class="px-4 py-2 text-sm font-semibold rounded-full {{ $statusBadges[$agent->status] ?? 'bg-gray-100 text-gray-800' }}">
                    {{ ucwords(str_replace('_', ' ', $agent->status)) }}
                </span>
            </div>

            @if($agent->bio)
                <p class="mt-6 text-gray-700 leading-relaxed">{{ $agent->bio }}</p>
            @endif

            {{-- Contact Info --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6 pt-6 border-t border-gray-200">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs text-gray-600">Email</p>
                        <a href="mailto:{{ $agent->email }}" class="text-sm font-medium text-gray-900 hover:text-primary truncate block">
                            {{ $agent->email }}
                        </a>
                    </div>
                </div>

                @if($agent->mobile)
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-600">Mobile</p>
                            <a href="tel:{{ $agent->mobile }}" class="text-sm font-medium text-gray-900 hover:text-primary">
                                {{ $agent->mobile }}
                            </a>
                        </div>
                    </div>
                @endif

                @if($agent->phone)
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-purple-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-600">Office</p>
                            <a href="tel:{{ $agent->phone }}" class="text-sm font-medium text-gray-900 hover:text-primary">
                                {{ $agent->phone }}
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Stats & Details --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Performance Stats --}}
            <div class="bg-white rounded-2xl border border-gray-200 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-6">Performance Overview</h3>
                
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="p-4 bg-blue-50 rounded-xl">
                        <p class="text-sm text-blue-600 font-medium">Total Properties</p>
                        <p class="text-3xl font-bold text-blue-900 mt-2">{{ $stats['total_properties'] }}</p>
                    </div>
                    
                    <div class="p-4 bg-green-50 rounded-xl">
                        <p class="text-sm text-green-600 font-medium">Active Listings</p>
                        <p class="text-3xl font-bold text-green-900 mt-2">{{ $stats['active_listings'] }}</p>
                    </div>
                    
                    <div class="p-4 bg-purple-50 rounded-xl">
                        <p class="text-sm text-purple-600 font-medium">Sold</p>
                        <p class="text-3xl font-bold text-purple-900 mt-2">{{ $stats['sold_properties'] }}</p>
                    </div>
                    
                    <div class="p-4 bg-orange-50 rounded-xl">
                        <p class="text-sm text-orange-600 font-medium">Leased</p>
                        <p class="text-3xl font-bold text-orange-900 mt-2">{{ $stats['leased_properties'] }}</p>
                    </div>
                </div>
            </div>

            {{-- Specializations --}}
            @if($agent->specializations && count($agent->specializations) > 0)
                <div class="bg-white rounded-2xl border border-gray-200 p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Specializations</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach($agent->specializations as $spec)
                            <span class="px-4 py-2 bg-primary-light text-primary text-sm font-medium rounded-xl">
                                {{ $spec }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Languages --}}
            @if($agent->languages && count($agent->languages) > 0)
                <div class="bg-white rounded-2xl border border-gray-200 p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Languages</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach($agent->languages as $lang)
                            <span class="px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-xl">
                                {{ $lang }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Recent Activity --}}
            @if($activities->count() > 0)
                <div class="bg-white rounded-2xl border border-gray-200 p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Recent Activity</h3>
                    <div class="space-y-3">
                        @foreach($activities as $activity)
                            <div class="flex items-start gap-3 p-3 bg-gray-50 rounded-xl">
                                <div class="w-8 h-8 bg-primary-light rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm text-gray-900">{{ $activity->description }}</p>
                                    <p class="text-xs text-gray-500 mt-1">{{ $activity->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        {{-- Sidebar --}}
        <div class="space-y-6">
            {{-- Professional Details --}}
            <div class="bg-white rounded-2xl border border-gray-200 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Professional Details</h3>
                
                <div class="space-y-4">
                    @if($agent->license_number)
                        <div>
                            <p class="text-xs text-gray-600 mb-1">License Number</p>
                            <p class="text-sm font-medium text-gray-900">{{ $agent->license_number }}</p>
                        </div>
                    @endif
                    
                    @if($agent->license_expiry)
                        <div>
                            <p class="text-xs text-gray-600 mb-1">License Expiry</p>
                            <p class="text-sm font-medium {{ $agent->hasExpiredLicense() ? 'text-red-600' : 'text-gray-900' }}">
                                {{ $agent->license_expiry->format('d M Y') }}
                                @if($agent->hasExpiredLicense())
                                    <span class="text-xs">(Expired)</span>
                                @endif
                            </p>
                        </div>
                    @endif
                    
                    @if($agent->commission_rate)
                        <div>
                            <p class="text-xs text-gray-600 mb-1">Commission Rate</p>
                            <p class="text-sm font-medium text-gray-900">{{ $agent->commission_rate }}%</p>
                        </div>
                    @endif
                    
                    @if($agent->started_at)
                        <div>
                            <p class="text-xs text-gray-600 mb-1">Start Date</p>
                            <p class="text-sm font-medium text-gray-900">{{ $agent->started_at->format('d M Y') }}</p>
                        </div>
                    @endif

                    <div>
                        <p class="text-xs text-gray-600 mb-1">Status</p>
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 {{ $agent->is_accepting_new_listings ? 'bg-green-500' : 'bg-gray-400' }} rounded-full"></span>
                            <p class="text-sm font-medium text-gray-900">
                                {{ $agent->is_accepting_new_listings ? 'Accepting New Listings' : 'Not Accepting Listings' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Address --}}
            @if($agent->address_line1 || $agent->suburb)
                <div class="bg-white rounded-2xl border border-gray-200 p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Address</h3>
                    <div class="text-sm text-gray-700 leading-relaxed">
                        @if($agent->address_line1)
                            <p>{{ $agent->address_line1 }}</p>
                        @endif
                        <p>
                            @if($agent->suburb){{ $agent->suburb }}@endif
                            @if($agent->state) {{ $agent->state }}@endif
                            @if($agent->postcode) {{ $agent->postcode }}@endif
                        </p>
                    </div>
                </div>
            @endif

            {{-- Emergency Contact --}}
            @if($agent->emergency_contact_name)
                <div class="bg-white rounded-2xl border border-gray-200 p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Emergency Contact</h3>
                    <div class="space-y-2">
                        <div>
                            <p class="text-xs text-gray-600 mb-1">Name</p>
                            <p class="text-sm font-medium text-gray-900">{{ $agent->emergency_contact_name }}</p>
                        </div>
                        @if($agent->emergency_contact_phone)
                            <div>
                                <p class="text-xs text-gray-600 mb-1">Phone</p>
                                <a href="tel:{{ $agent->emergency_contact_phone }}" class="text-sm font-medium text-primary hover:underline">
                                    {{ $agent->emergency_contact_phone }}
                                </a>
                            </div>
                        @endif
                        @if($agent->emergency_contact_relationship)
                            <div>
                                <p class="text-xs text-gray-600 mb-1">Relationship</p>
                                <p class="text-sm font-medium text-gray-900">{{ $agent->emergency_contact_relationship }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection