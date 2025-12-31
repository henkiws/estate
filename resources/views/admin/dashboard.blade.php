@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')

<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-2">
        Welcome back, {{ Auth::user()->name }} 👋
    </h1>
    <p class="text-gray-600">Here's an overview of the platform today.</p>
</div>

{{-- Statistics Cards --}}
<div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Agencies -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-[#DDEECD] rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </div>
            <span class="text-xs font-semibold text-gray-600 bg-gray-100 px-2 py-1 rounded-full">Total</span>
        </div>
        <div class="text-2xl font-bold text-gray-800 mb-1">{{ $stats['total'] }}</div>
        <div class="text-sm text-gray-600">Total Agencies</div>
    </div>

    <!-- Active Agencies -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-[#DDEECD] rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <span class="text-xs font-semibold text-gray-700 bg-[#DDEECD] px-2 py-1 rounded-full">Active</span>
        </div>
        <div class="text-2xl font-bold text-gray-800 mb-1">{{ $stats['active'] }}</div>
        <div class="text-sm text-gray-600">Active Agencies</div>
    </div>

    <!-- Pending Approvals -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-[#E6FF4B]/30 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <span class="text-xs font-semibold text-gray-700 bg-[#E6FF4B] px-2 py-1 rounded-full">Pending</span>
        </div>
        <div class="text-2xl font-bold text-gray-800 mb-1">{{ $stats['pending'] }}</div>
        <div class="text-sm text-gray-600">Pending Approval</div>
    </div>

    <!-- NEW: Pending User Profiles -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-[#DDEECD] rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </div>
            <span class="text-xs font-semibold text-gray-700 bg-[#DDEECD] px-2 py-1 rounded-full">Profiles</span>
        </div>
        <div class="text-2xl font-bold text-gray-800 mb-1">{{ $pendingProfilesCount ?? 0 }}</div>
        <div class="text-sm text-gray-600">Pending User Profiles</div>
    </div>
</div>

<!-- Two Column Layout -->
<div class="grid lg:grid-cols-3 gap-8">
    <!-- Left Column -->
    <div class="lg:col-span-2 space-y-8">
        
        {{-- NEW: Pending USER PROFILES Widget --}}
        @if(isset($pendingProfiles) && $pendingProfiles->count() > 0)
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
            <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-bold text-gray-800">User Profiles Needing Review</h2>
                    <p class="text-sm text-gray-600 mt-1">Review and approve user profile submissions</p>
                </div>
                <span class="bg-[#DDEECD] text-gray-800 text-sm font-medium px-3 py-1 rounded-full">
                    {{ $pendingProfiles->count() }} Pending
                </span>
            </div>
            <div class="divide-y divide-gray-100">
                @foreach($pendingProfiles->take(5) as $profile)
                @php
                    $totalPoints = $profile->user->identifications->sum('points');
                    $daysPending = $profile->submitted_at ? $profile->submitted_at->diffInDays(now()) : 0;
                @endphp
                <div class="p-6 hover:bg-[#DDEECD]/20 transition-colors">
                    <div class="flex items-start justify-between gap-4">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-2">
                                <div class="w-10 h-10 bg-[#DDEECD] rounded-full flex items-center justify-center flex-shrink-0">
                                    <span class="text-gray-700 font-bold text-sm">{{ substr($profile->user->name, 0, 1) }}</span>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-800">{{ $profile->first_name }} {{ $profile->last_name }}</h3>
                                    <p class="text-sm text-gray-500">{{ $profile->user->email }}</p>
                                </div>
                                
                                @if($daysPending > 3)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-[#E6FF4B] text-gray-800">
                                    🔥 {{ $daysPending }} days old
                                </span>
                                @endif
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4 text-sm mb-3 ml-13">
                                <div>
                                    <span class="text-gray-500">DOB:</span>
                                    <span class="text-gray-800 font-medium ml-2">{{ $profile->date_of_birth ? $profile->date_of_birth->format('M d, Y') : 'N/A' }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-500">Mobile:</span>
                                    <span class="text-gray-800 font-medium ml-2">{{ $profile->mobile_country_code }} {{ $profile->mobile_number }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-500">Submitted:</span>
                                    <span class="text-gray-800 font-medium ml-2">{{ $profile->submitted_at ? $profile->submitted_at->diffForHumans() : 'N/A' }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-500">ID Points:</span>
                                    <span class="font-medium ml-2 {{ $totalPoints >= 80 ? 'text-gray-700' : 'text-gray-500' }}">
                                        {{ $totalPoints }} points
                                    </span>
                                </div>
                            </div>

                            <!-- Profile Completeness -->
                            <div class="flex items-center gap-4 text-sm ml-13">
                                @if($totalPoints >= 80)
                                <span class="inline-flex items-center text-gray-700 text-xs font-medium">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    Valid ID Points
                                </span>
                                @else
                                <span class="inline-flex items-center text-gray-500 text-xs font-medium">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                    </svg>
                                    Insufficient ID Points (min 80)
                                </span>
                                @endif
                                
                                @if($profile->user->incomes->count() > 0)
                                <span class="inline-flex items-center text-gray-600 text-xs">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ $profile->user->incomes->count() }} income source(s)
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="flex flex-col gap-2">
                            <a href="{{ route('admin.profiles.show', $profile->id) }}" 
                               class="px-4 py-2 bg-[#DDEECD] text-gray-800 text-sm font-medium rounded-xl hover:bg-[#DDEECD]/80 transition whitespace-nowrap text-center">
                                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                Review Profile
                            </a>
                            <form action="{{ route('admin.profiles.approve', $profile->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" 
                                        class="w-full px-4 py-2 bg-[#E6FF4B] text-gray-800 text-sm font-medium rounded-xl hover:bg-[#E6FF4B]/80 transition"
                                        onclick="return confirm('Approve {{ $profile->first_name }} {{ $profile->last_name }}\'s profile?')">
                                    ✓ Quick Approve
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            @if($pendingProfiles->count() > 5)
            <div class="p-4 bg-[#DDEECD]/20 border-t border-gray-100 text-center">
                <a href="{{ route('admin.profiles.index', ['status' => 'pending']) }}" 
                   class="inline-flex items-center text-gray-700 hover:text-gray-800 font-semibold text-sm">
                    View all {{ $pendingProfiles->count() }} pending profiles
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
            @endif
        </div>
        @endif

        {{-- Pending Agencies Widget --}}
        @if($pendingAgencies->count() > 0)
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
            <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-bold text-gray-800">Agencies Needing Review</h2>
                    <p class="text-sm text-gray-600 mt-1">Review and approve new agency registrations</p>
                </div>
                <span class="bg-[#f86b6b] text-white text-sm font-medium px-3 py-1 rounded-full">
                    {{ $pendingAgencies->count() }} Pending
                </span>
            </div>
            <div class="divide-y divide-gray-100">
                @foreach($pendingAgencies->take(5) as $agency)
                @php
                    $documents = $agency->documentRequirements;
                    $totalDocs = $documents->where('is_required', true)->count();
                    $uploadedDocs = $documents->where('is_required', true)->whereNotNull('file_path')->count();
                    $daysPending = $agency->created_at->diffInDays(now());
                @endphp
                <div class="p-6 hover:bg-[#DDEECD]/20 transition-colors">
                    <div class="flex items-start justify-between gap-4">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-2">
                                <h3 class="font-semibold text-gray-800">{{ $agency->agency_name }}</h3>
                                <span class="text-xs px-2 py-1 bg-[#DDEECD] text-gray-700 rounded-full font-medium">{{ $agency->state }}</span>
                                
                                @if($daysPending > 3)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-[#E6FF4B] text-gray-800">
                                    🔥 {{ $daysPending }} days old
                                </span>
                                @endif
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4 text-sm mb-3">
                                <div>
                                    <span class="text-gray-500">ABN:</span>
                                    <span class="text-gray-800 font-medium ml-2">{{ $agency->abn }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-500">License:</span>
                                    <span class="text-gray-800 font-medium ml-2">{{ $agency->license_number }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-500">Email:</span>
                                    <span class="text-gray-800 font-medium ml-2">{{ $agency->business_email }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-500">Submitted:</span>
                                    <span class="text-gray-800 font-medium ml-2">{{ $agency->created_at->diffForHumans() }}</span>
                                </div>
                            </div>

                            <div class="flex items-center gap-4 text-sm">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 text-gray-400 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <span class="text-gray-600">Documents: 
                                        <span class="font-medium {{ $uploadedDocs === $totalDocs ? 'text-gray-700' : 'text-gray-500' }}">
                                            {{ $uploadedDocs }}/{{ $totalDocs }}
                                        </span>
                                    </span>
                                </div>
                                
                                @if($uploadedDocs === $totalDocs)
                                <span class="inline-flex items-center text-gray-700 text-xs font-medium">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    All docs uploaded
                                </span>
                                @else
                                <span class="inline-flex items-center text-gray-500 text-xs font-medium">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    Incomplete docs
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="flex flex-col gap-2">
                            <a href="{{ route('admin.agencies.show', $agency->id) }}" 
                               class="px-4 py-2 bg-[#DDEECD] text-gray-800 text-sm font-medium rounded-xl hover:bg-[#DDEECD]/80 transition whitespace-nowrap text-center">
                                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                Review
                            </a>
                            <form action="{{ route('admin.agencies.approve', $agency->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" 
                                        class="w-full px-4 py-2 bg-[#E6FF4B] text-gray-800 text-sm font-medium rounded-xl hover:bg-[#E6FF4B]/80 transition"
                                        {{-- onclick="return confirm('Approve {{ $agency->agency_name }}?')" --}}
                                        onclick="confirmApproval(event, '{{ $agency->agency_name }}')"
                                        >
                                    ✓ Quick Approve
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            @if($pendingAgencies->count() > 5)
            <div class="p-4 bg-[#DDEECD]/20 border-t border-gray-100 text-center">
                <a href="{{ route('admin.agencies.index', ['status' => 'pending']) }}" 
                   class="inline-flex items-center text-gray-700 hover:text-gray-800 font-semibold text-sm">
                    View all {{ $pendingAgencies->count() }} pending agencies
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
            @endif
        </div>
        @else
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
            <div class="w-16 h-16 bg-[#DDEECD] rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-gray-700" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-800 mb-2">All Caught Up!</h3>
            <p class="text-gray-600">No agencies pending review at the moment.</p>
        </div>
        @endif

        <!-- Recent Agencies -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
            <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                <h2 class="text-xl font-bold text-gray-800">Recent Agencies</h2>
                <a href="{{ route('admin.agencies.index') }}" class="text-sm font-semibold text-gray-700 hover:text-gray-800">
                    View All
                </a>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @forelse($recentAgencies as $agency)
                    <div class="flex gap-4 p-4 border border-gray-200 rounded-xl hover:border-[#DDEECD] hover:bg-[#DDEECD]/10 transition-all cursor-pointer" 
                         onclick="window.location='{{ route('admin.agencies.show', $agency->id) }}'">
                        <div class="w-12 h-12 bg-gradient-to-br from-[#DDEECD] to-[#4ADE80] rounded-xl flex items-center justify-center flex-shrink-0">
                            <span class="text-gray-700 font-bold text-lg">{{ strtoupper(substr($agency->agency_name, 0, 1)) }}</span>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-semibold text-gray-800 mb-1">{{ $agency->agency_name }}</h3>
                            <p class="text-sm text-gray-600 mb-2">{{ $agency->state }} • ABN: {{ $agency->abn }} • ID: {{ $agency->id }}</p>
                            <div class="flex items-center gap-4 text-xs text-gray-500">
                                <span>{{ $agency->created_at->format('M d, Y') }}</span>
                                <span class="px-2 py-1 rounded-full font-semibold
                                    {{ $agency->status === 'approved' ? 'bg-[#DDEECD] text-gray-700' : '' }}
                                    {{ $agency->status === 'pending' ? 'bg-[#f86b6b] text-white' : '' }}
                                    {{ $agency->status === 'suspended' ? 'bg-gray-200 text-gray-600' : '' }}">
                                    {{ ucfirst($agency->status) }}
                                </span>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-8 text-gray-500">
                        <p>No agencies registered yet</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column -->
    <div class="space-y-8">
        
        <!-- Agencies by State -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
            <div class="p-6 border-b border-gray-100">
                <h2 class="text-xl font-bold text-gray-800">Agencies by State</h2>
            </div>
            <div class="p-6">
                <div class="space-y-3">
                    @foreach($stateStats as $state => $count)
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-[#DDEECD] rounded-lg flex items-center justify-center">
                                <span class="text-gray-700 font-bold text-sm">{{ $state }}</span>
                            </div>
                            <span class="text-sm font-medium text-gray-700">{{ $state }}</span>
                        </div>
                        <span class="text-sm font-bold text-gray-800">{{ $count }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="bg-gradient-to-br from-[#DDEECD] to-[#4ADE80] rounded-2xl p-6 text-gray-800">
            <h3 class="text-lg font-bold mb-2">Platform Stats</h3>
            <div class="space-y-4 mt-6">
                <div class="flex justify-between items-center">
                    <span class="text-gray-700 text-sm">Verified Agencies</span>
                    <span class="text-2xl font-bold">{{ $stats['verified'] }}</span>
                </div>
                <div class="h-px bg-gray-700/20"></div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-700 text-sm">This Week</span>
                    <span class="text-2xl font-bold">{{ $stats['this_week'] }}</span>
                </div>
                <div class="h-px bg-gray-700/20"></div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-700 text-sm">User Profiles Approved</span>
                    <span class="text-2xl font-bold">{{ $profileStats['approved'] ?? 0 }}</span>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-6">Quick Actions</h2>
            <div class="space-y-3">
                <a href="{{ route('admin.agencies.index') }}" 
                   class="w-full flex items-center gap-3 px-4 py-3 bg-[#DDEECD] text-gray-800 rounded-xl hover:bg-[#DDEECD]/80 transition-all font-semibold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    View All Agencies
                </a>
                <a href="{{ route('admin.profiles.index', ['status' => 'pending']) }}" 
                   class="w-full flex items-center gap-3 px-4 py-3 bg-[#E6FF4B] text-gray-800 rounded-xl hover:bg-[#E6FF4B]/80 transition-all font-semibold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Review User Profiles
                </a>
                <a href="{{ route('admin.agencies.index', ['status' => 'pending']) }}" 
                   class="w-full flex items-center gap-3 px-4 py-3 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-all font-semibold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                    </svg>
                    Review Pending Agencies
                </a>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
    <script>
        function confirmApproval(event, name) {
            event.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                text: 'Approve ' + name + '?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, approve it!',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
            }).then((result) => {
                if (result.isConfirmed) {
                    event.target.form.submit();
                }
            });

        }
    </script>
@endpush