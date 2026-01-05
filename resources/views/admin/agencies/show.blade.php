@extends('layouts.admin')

@section('title', $agency->agency_name . ' - Agency Details')

@section('content')

{{-- Flash Messages --}}
@if(session('success'))
<div class="mb-6 bg-[#DDEECD]/30 border-l-4 border-[#DDEECD] rounded-xl p-4 flex items-start animate-slideDown shadow-lg">
    <svg class="w-6 h-6 text-gray-700 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
    </svg>
    <div class="flex-1">
        <h3 class="text-sm font-semibold text-gray-800">Success!</h3>
        <p class="text-sm text-gray-700 mt-1">{{ session('success') }}</p>
    </div>
</div>
@endif

@if(session('error'))
<div class="mb-6 bg-gray-100 border-l-4 border-gray-400 rounded-xl p-4 flex items-start animate-slideDown shadow-lg">
    <svg class="w-6 h-6 text-gray-600 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
    </svg>
    <div class="flex-1">
        <h3 class="text-sm font-semibold text-gray-800">Error!</h3>
        <p class="text-sm text-gray-700 mt-1">{{ session('error') }}</p>
    </div>
</div>
@endif

{{-- Header Section --}}
<div class="mb-8">
    <div class="flex items-start gap-4 mb-6">
        <a href="{{ route('admin.agencies.index') }}" 
           class="p-2 hover:bg-[#DDEECD] rounded-lg transition-colors">
            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div class="flex-1">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">{{ $agency->agency_name }}</h1>
            <div class="flex items-center gap-3 text-sm text-gray-600 mb-3">
                <span class="flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    Registered {{ $agency->created_at->format('M d, Y') }}
                </span>
                <span>•</span>
                <span>{{ $agency->created_at->diffForHumans() }}</span>
            </div>
            
            {{-- Status Badge --}}
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-xl font-semibold shadow-sm
                {{ $agency->status === 'active' ? 'bg-[#DDEECD] text-gray-800' : '' }}
                {{ $agency->status === 'approved' ? 'bg-[#E6FF4B] text-gray-800' : '' }}
                {{ $agency->status === 'pending' ? 'bg-[#E6FF4B]/50 text-gray-800' : '' }}
                {{ $agency->status === 'rejected' ? 'bg-gray-200 text-gray-600' : '' }}
                {{ $agency->status === 'suspended' ? 'bg-gray-300 text-gray-700' : '' }}
                {{ $agency->status === 'inactive' ? 'bg-gray-100 text-gray-500' : '' }}">
                <span class="w-2.5 h-2.5 rounded-full
                    {{ $agency->status === 'active' ? 'bg-gray-700 animate-pulse' : '' }}
                    {{ $agency->status === 'approved' ? 'bg-gray-700' : '' }}
                    {{ $agency->status === 'pending' ? 'bg-gray-700 animate-pulse' : '' }}
                    {{ $agency->status === 'rejected' ? 'bg-gray-500' : '' }}
                    {{ $agency->status === 'suspended' ? 'bg-gray-600' : '' }}
                    {{ $agency->status === 'inactive' ? 'bg-gray-400' : '' }}">
                </span>
                {{ ucfirst($agency->status) }}
                @if($agency->status === 'approved')
                <span class="text-xs opacity-75">• Awaiting Subscription</span>
                @endif
            </div>
        </div>
        
        {{-- Action Buttons --}}
        <div class="flex gap-2">
            @if($agency->status === 'pending')
            <form action="{{ route('admin.agencies.approve', $agency->id) }}" method="POST" class="inline">
                @csrf
                <button type="submit" 
                        onclick="return confirm('Approve {{ $agency->agency_name }}? They will be able to choose a subscription plan.')"
                        class="px-6 py-3 bg-[#DDEECD] text-gray-800 rounded-xl font-semibold hover:bg-[#DDEECD]/80 transition-all shadow-lg hover:shadow-xl flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Approve Agency
                </button>
            </form>
            <button onclick="openRejectModal()" 
                    class="px-6 py-3 bg-gray-600 text-white rounded-xl font-semibold hover:bg-gray-700 transition-all flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
                Reject
            </button>
            @elseif($agency->status === 'active' || $agency->status === 'approved')
            <form action="{{ route('admin.agencies.suspend', $agency->id) }}" method="POST" class="inline">
                @csrf
                <button type="submit" 
                        onclick="return confirm('Suspend {{ $agency->agency_name }}? They will lose access to the platform.')"
                        class="px-6 py-3 bg-gray-600 text-white rounded-xl font-semibold hover:bg-gray-700 transition-all flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                    </svg>
                    Suspend
                </button>
            </form>
            @elseif($agency->status === 'suspended')
            <form action="{{ route('admin.agencies.reactivate', $agency->id) }}" method="POST" class="inline">
                @csrf
                <button type="submit" 
                        onclick="return confirm('Reactivate {{ $agency->agency_name }}?')"
                        class="px-6 py-3 bg-[#E6FF4B] text-gray-800 rounded-xl font-semibold hover:bg-[#E6FF4B]/80 transition-all flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Reactivate
                </button>
            </form>
            @endif
            <a href="{{ route('admin.agencies.edit', $agency->id) }}" 
               class="px-6 py-3 bg-[#E6FF4B] text-gray-800 rounded-xl font-semibold hover:bg-[#E6FF4B]/80 transition-all flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit
            </a>
        </div>
    </div>
</div>

{{-- Tabs Navigation --}}
<div class="mb-6">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-2">
        <nav class="flex gap-2 overflow-x-auto">
            <button onclick="switchTab('details')" 
                    class="tab-btn flex items-center gap-2 px-6 py-3 rounded-lg font-semibold transition-all whitespace-nowrap"
                    data-tab="details">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
                Agency Details
            </button>
            <button onclick="switchTab('agents')" 
                    class="tab-btn flex items-center gap-2 px-6 py-3 rounded-lg font-semibold transition-all whitespace-nowrap"
                    data-tab="agents">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                Agents
                <span class="px-2 py-0.5 bg-gray-200 text-gray-700 text-xs rounded-full">{{ $agency->agents->count() }}</span>
            </button>
            <button onclick="switchTab('properties')" 
                    class="tab-btn flex items-center gap-2 px-6 py-3 rounded-lg font-semibold transition-all whitespace-nowrap"
                    data-tab="properties">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                Properties
                <span class="px-2 py-0.5 bg-gray-200 text-gray-700 text-xs rounded-full">{{ $propertyStats['total'] }}</span>
            </button>
            <button onclick="switchTab('documents')" 
                    class="tab-btn flex items-center gap-2 px-6 py-3 rounded-lg font-semibold transition-all whitespace-nowrap"
                    data-tab="documents">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Documents
                @php
                    $pendingDocs = $documentRequirements->where('status', 'pending_review')->count();
                @endphp
                @if($pendingDocs > 0)
                <span class="px-2 py-0.5 bg-[#E6FF4B] text-gray-800 text-xs rounded-full animate-pulse">{{ $pendingDocs }}</span>
                @else
                <span class="px-2 py-0.5 bg-gray-200 text-gray-700 text-xs rounded-full">{{ $documentRequirements->count() }}</span>
                @endif
            </button>
            <button onclick="switchTab('insurance')" 
                    class="tab-btn flex items-center gap-2 px-6 py-3 rounded-lg font-semibold transition-all whitespace-nowrap"
                    data-tab="insurance">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                </svg>
                Insurance
            </button>
            <button onclick="switchTab('subscription')" 
                    class="tab-btn flex items-center gap-2 px-6 py-3 rounded-lg font-semibold transition-all whitespace-nowrap"
                    data-tab="subscription">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                </svg>
                Subscription
            </button>
        </nav>
    </div>
</div>

{{-- Tab Contents --}}
<div class="space-y-6">
    
    {{-- TAB 1: Agency Details --}}
    <div id="tab-details" class="tab-content">
        <div class="grid lg:grid-cols-3 gap-6">
            
            {{-- Left Column (2/3) --}}
            <div class="lg:col-span-2 space-y-6">
                
                {{-- Agency Information --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-[#DDEECD]/30 to-[#DDEECD]/10 px-6 py-4 border-b border-gray-100">
                        <h2 class="text-xl font-bold text-gray-800 flex items-center">
                            <svg class="w-6 h-6 mr-2 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            Agency Information
                        </h2>
                    </div>
                    <div class="p-6">
                        <div class="grid md:grid-cols-2 gap-6">
                            <div class="space-y-1">
                                <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Agency Name</label>
                                <p class="text-gray-800 font-medium">{{ $agency->agency_name }}</p>
                            </div>
                            <div class="space-y-1">
                                <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Trading Name</label>
                                <p class="text-gray-800 font-medium">{{ $agency->trading_name ?? 'N/A' }}</p>
                            </div>
                            <div class="space-y-1">
                                <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">ABN</label>
                                <p class="text-gray-800 font-mono">{{ $agency->abn }}</p>
                            </div>
                            <div class="space-y-1">
                                <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">ACN</label>
                                <p class="text-gray-800 font-mono">{{ $agency->acn ?? 'N/A' }}</p>
                            </div>
                            <div class="space-y-1">
                                <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Business Type</label>
                                <p class="text-gray-800 font-medium">{{ ucfirst(str_replace('_', ' ', $agency->business_type)) }}</p>
                            </div>
                            <div class="space-y-1">
                                <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">License Number</label>
                                <p class="text-gray-800 font-mono">{{ $agency->license_number }}</p>
                            </div>
                            <div class="space-y-1">
                                <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">License Holder</label>
                                <p class="text-gray-800 font-medium">{{ $agency->license_holder_name }}</p>
                            </div>
                            <div class="space-y-1">
                                <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">License Expiry</label>
                                <p class="text-gray-800 font-medium">
                                    {{ $agency->license_expiry_date ? $agency->license_expiry_date->format('M d, Y') : 'N/A' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Contact Information --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-[#E6FF4B]/20 to-[#E6FF4B]/10 px-6 py-4 border-b border-gray-100">
                        <h2 class="text-xl font-bold text-gray-800 flex items-center">
                            <svg class="w-6 h-6 mr-2 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            Contact Information
                        </h2>
                    </div>
                    <div class="p-6">
                        <div class="grid md:grid-cols-2 gap-6">
                            <div class="space-y-1 md:col-span-2">
                                <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Business Address</label>
                                <p class="text-gray-800 font-medium">{{ $agency->business_address }}</p>
                            </div>
                            <div class="space-y-1">
                                <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">State / Postcode</label>
                                <p class="text-gray-800 font-medium">{{ $agency->state }} {{ $agency->postcode }}</p>
                            </div>
                            <div class="space-y-1">
                                <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Business Phone</label>
                                <p class="text-gray-800 font-medium">
                                    <a href="tel:{{ $agency->business_phone }}" class="text-gray-700 hover:underline">
                                        {{ $agency->business_phone }}
                                    </a>
                                </p>
                            </div>
                            <div class="space-y-1">
                                <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Business Email</label>
                                <p class="text-gray-800 font-medium">
                                    <a href="mailto:{{ $agency->business_email }}" class="text-gray-700 hover:underline">
                                        {{ $agency->business_email }}
                                    </a>
                                </p>
                            </div>
                            <div class="space-y-1">
                                <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Website</label>
                                <p class="text-gray-800 font-medium">
                                    @if($agency->website_url)
                                        <a href="{{ $agency->website_url }}" target="_blank" class="text-gray-700 hover:underline flex items-center gap-1">
                                            {{ $agency->website_url }}
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                            </svg>
                                        </a>
                                    @else
                                        N/A
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Primary Contact --}}
                @if($agency->primaryContact)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-[#DDEECD]/30 to-[#DDEECD]/10 px-6 py-4 border-b border-gray-100">
                        <h2 class="text-xl font-bold text-gray-800 flex items-center">
                            <svg class="w-6 h-6 mr-2 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Primary Contact
                        </h2>
                    </div>
                    <div class="p-6">
                        <div class="grid md:grid-cols-2 gap-6">
                            <div class="space-y-1">
                                <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Full Name</label>
                                <p class="text-gray-800 font-medium">{{ $agency->primaryContact->full_name }}</p>
                            </div>
                            <div class="space-y-1">
                                <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Position</label>
                                <p class="text-gray-800 font-medium">{{ $agency->primaryContact->position }}</p>
                            </div>
                            <div class="space-y-1">
                                <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Email</label>
                                <p class="text-gray-800 font-medium">
                                    <a href="mailto:{{ $agency->primaryContact->email }}" class="text-gray-700 hover:underline">
                                        {{ $agency->primaryContact->email }}
                                    </a>
                                </p>
                            </div>
                            <div class="space-y-1">
                                <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Phone</label>
                                <p class="text-gray-800 font-medium">
                                    <a href="tel:{{ $agency->primaryContact->phone }}" class="text-gray-700 hover:underline">
                                        {{ $agency->primaryContact->phone }}
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                {{-- Activity Log --}}
                @if(isset($activityLogs) && $activityLogs->count() > 0)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-[#DDEECD]/20 to-[#E6FF4B]/10 px-6 py-4 border-b border-gray-100">
                        <h2 class="text-xl font-bold text-gray-800 flex items-center">
                            <svg class="w-6 h-6 mr-2 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                            </svg>
                            Activity Log
                            <span class="ml-auto text-sm font-normal text-gray-600">{{ $activityLogs->count() }} activities</span>
                        </h2>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            @foreach($activityLogs->take(10) as $log)
                            <div class="relative">
                                @if(!$loop->last)
                                <div class="absolute left-5 top-12 bottom-0 w-0.5 bg-gray-200"></div>
                                @endif
                                
                                <div class="flex items-start gap-4">
                                    <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0 shadow-md
                                        {{ str_contains(strtolower($log->description), 'approved') ? 'bg-[#DDEECD]' : '' }}
                                        {{ str_contains(strtolower($log->description), 'rejected') ? 'bg-gray-200' : '' }}
                                        {{ str_contains(strtolower($log->description), 'uploaded') || str_contains(strtolower($log->description), 'created') ? 'bg-[#E6FF4B]/30' : '' }}
                                        {{ !str_contains(strtolower($log->description), 'approved') && !str_contains(strtolower($log->description), 'rejected') && !str_contains(strtolower($log->description), 'uploaded') && !str_contains(strtolower($log->description), 'created') ? 'bg-gray-100' : '' }}">
                                        <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    
                                    <div class="flex-1 bg-gray-50 rounded-xl p-4 border border-gray-200">
                                        <p class="text-sm font-bold text-gray-800 mb-2">{{ $log->description }}</p>
                                        <div class="flex items-center gap-4 text-xs text-gray-500">
                                            <span class="flex items-center gap-1 font-medium">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                </svg>
                                                {{ $log->causer->name ?? 'System' }}
                                            </span>
                                            <span class="text-gray-300">•</span>
                                            <span>{{ $log->created_at->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif
                
            </div>

            {{-- Right Sidebar (1/3) --}}
            <div class="space-y-6">
                
                {{-- Quick Stats --}}
                <div class="bg-gradient-to-br from-[#DDEECD] to-[#4ADE80] rounded-2xl shadow-xl p-6 text-gray-800">
                    <h3 class="text-lg font-bold mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        Quick Stats
                    </h3>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center pb-4 border-b border-gray-700/20">
                            <span class="text-gray-700 text-sm font-medium">Total Agents</span>
                            <span class="text-3xl font-bold">{{ $quickStats['total_agents'] }}</span>
                        </div>
                        <div class="flex justify-between items-center pb-4 border-b border-gray-700/20">
                            <span class="text-gray-700 text-sm font-medium">Active Agents</span>
                            <span class="text-2xl font-bold">{{ $quickStats['active_agents'] }}</span>
                        </div>
                        <div class="flex justify-between items-center pb-4 border-b border-gray-700/20">
                            <span class="text-gray-700 text-sm font-medium">Total Properties</span>
                            <span class="text-3xl font-bold">{{ $quickStats['total_properties'] }}</span>
                        </div>
                        <div class="flex justify-between items-center pb-4 border-b border-gray-700/20">
                            <span class="text-gray-700 text-sm font-medium">Active Properties</span>
                            <span class="text-2xl font-bold">{{ $quickStats['active_properties'] }}</span>
                        </div>
                        <div class="flex justify-between items-center pb-4 border-b border-gray-700/20">
                            <span class="text-gray-700 text-sm font-medium">Documents</span>
                            <span class="font-bold">
                                {{ $quickStats['approved_documents'] }}/{{ $quickStats['total_documents'] }}
                            </span>
                        </div>
                        <div class="flex justify-between items-center pb-4 border-b border-gray-700/20">
                            <span class="text-gray-700 text-sm font-medium">Member Since</span>
                            <span class="font-bold">{{ $quickStats['member_since']->format('M Y') }}</span>
                        </div>
                        @if($quickStats['verified_at'])
                        <div class="flex justify-between items-center">
                            <span class="text-gray-700 text-sm font-medium">Approved</span>
                            <span class="font-bold">{{ $quickStats['verified_at']->format('M d, Y') }}</span>
                        </div>
                        @endif
                    </div>
                </div>

                {{-- Danger Zone --}}
                <div class="bg-red-50 rounded-2xl border-2 border-red-200 p-6">
                    <h3 class="text-lg font-bold text-red-900 mb-3 flex items-center">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                        Danger Zone
                    </h3>
                    <p class="text-sm text-red-700 mb-4">Deleting an agency is permanent and cannot be undone.</p>
                    <form action="{{ route('admin.agencies.destroy', $agency->id) }}" method="POST" onsubmit="return confirm('⚠️ Are you absolutely sure?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full px-4 py-3 bg-red-600 text-white rounded-xl hover:bg-red-700 transition-all font-bold shadow-lg flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Delete Agency
                        </button>
                    </form>
                </div>
            </div>
            
        </div>
    </div>

    {{-- TAB 2: Agents --}}
    <div id="tab-agents" class="tab-content hidden">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-[#DDEECD]/30 to-[#DDEECD]/10 px-6 py-4 border-b border-gray-100">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-bold text-gray-800 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        Agents
                    </h2>
                    <div class="flex items-center gap-3">
                        <span class="text-sm text-gray-600">{{ $agents->count() }} {{ Str::plural('agent', $agents->count()) }}</span>
                        <span class="px-3 py-1 bg-[#DDEECD] text-gray-700 rounded-lg text-sm font-semibold">
                            {{ $agents->where('status', 'active')->count() }} Active
                        </span>
                    </div>
                </div>
            </div>
            <div class="p-6">
                @if($agents->count() > 0)
                    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($agents as $agent)
                        <div class="border border-gray-200 rounded-xl hover:border-[#DDEECD] hover:shadow-lg transition-all overflow-hidden">
                            <!-- Agent Header -->
                            <div class="bg-gradient-to-br from-[#DDEECD] to-[#4ADE80] p-4">
                                <div class="flex items-center gap-3 mb-3">
                                    <div class="w-14 h-14 bg-white rounded-full flex items-center justify-center text-gray-700 font-bold text-lg shadow-md">
                                        {{ $agent->initials }}
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h3 class="font-bold text-gray-800 truncate">{{ $agent->full_name }}</h3>
                                        <p class="text-sm text-gray-700">{{ $agent->position ?? 'Sales Agent' }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="px-3 py-1 bg-white/80 text-gray-700 rounded-full text-xs font-bold">
                                        {{ ucfirst($agent->status) }}
                                    </span>
                                    <span class="text-xs text-gray-700 font-mono">{{ $agent->agent_code }}</span>
                                </div>
                            </div>
                            
                            <!-- Agent Stats -->
                            <div class="p-4 bg-gray-50">
                                <div class="grid grid-cols-3 gap-2 text-center">
                                    <div>
                                        <p class="text-2xl font-bold text-gray-800">{{ $agent->total_properties ?? 0 }}</p>
                                        <p class="text-xs text-gray-600">Total</p>
                                    </div>
                                    <div>
                                        <p class="text-2xl font-bold text-[#4ADE80]">{{ $agent->active_listings ?? 0 }}</p>
                                        <p class="text-xs text-gray-600">Active</p>
                                    </div>
                                    <div>
                                        <p class="text-2xl font-bold text-gray-600">{{ $agent->sold_properties ?? 0 }}</p>
                                        <p class="text-xs text-gray-600">Sold</p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Agent Contact -->
                            <div class="p-4 border-t border-gray-200 space-y-2">
                                @if($agent->email)
                                <div class="flex items-center gap-2 text-sm text-gray-600">
                                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                    <a href="mailto:{{ $agent->email }}" class="hover:text-gray-800 truncate">{{ $agent->email }}</a>
                                </div>
                                @endif
                                @if($agent->mobile)
                                <div class="flex items-center gap-2 text-sm text-gray-600">
                                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                    <a href="tel:{{ $agent->mobile }}" class="hover:text-gray-800">{{ $agent->mobile }}</a>
                                </div>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No Agents Yet</h3>
                        <p class="text-gray-600">This agency hasn't added any agents to their account.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- TAB 3: Properties --}}
    <div id="tab-properties" class="tab-content hidden">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-[#DDEECD]/30 to-[#DDEECD]/10 px-6 py-4 border-b border-gray-100">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-bold text-gray-800 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        Properties
                    </h2>
                    <div class="flex items-center gap-3">
                        <span class="text-sm text-gray-600">{{ $propertyStats['total'] }} {{ Str::plural('property', $propertyStats['total']) }}</span>
                        <span class="px-3 py-1 bg-[#DDEECD] text-gray-700 rounded-lg text-sm font-semibold">
                            {{ $propertyStats['active'] }} Active
                        </span>
                    </div>
                </div>
            </div>
            
            @if($properties->count() > 0)
                {{-- Property Statistics Cards --}}
                <div class="p-6 border-b border-gray-100 bg-gray-50">
                    <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                        <div class="bg-white rounded-xl p-4 border border-gray-200">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm font-medium text-gray-600">Active</span>
                                <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                            </div>
                            <p class="text-3xl font-bold text-gray-800">{{ $propertyStats['active'] }}</p>
                        </div>
                        
                        <div class="bg-white rounded-xl p-4 border border-gray-200">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm font-medium text-gray-600">Leased</span>
                                <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <p class="text-3xl font-bold text-gray-800">{{ $propertyStats['leased'] }}</p>
                        </div>
                        
                        <div class="bg-white rounded-xl p-4 border border-gray-200">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm font-medium text-gray-600">Sold</span>
                                <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <p class="text-3xl font-bold text-gray-800">{{ $propertyStats['sold'] }}</p>
                        </div>
                        
                        <div class="bg-white rounded-xl p-4 border border-gray-200">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm font-medium text-gray-600">Under Contract</span>
                                <div class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                            </div>
                            <p class="text-3xl font-bold text-gray-800">{{ $propertyStats['under_contract'] }}</p>
                        </div>
                        
                        <div class="bg-white rounded-xl p-4 border border-gray-200">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm font-medium text-gray-600">Draft</span>
                                <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </div>
                            </div>
                            <p class="text-3xl font-bold text-gray-800">{{ $propertyStats['draft'] }}</p>
                        </div>
                    </div>
                </div>
                
                {{-- Properties Table --}}
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Property</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Code</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Details</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Agent</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Listed</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($properties as $property)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4">
                                    <div class="flex flex-col">
                                        <span class="text-sm font-semibold text-gray-900">{{ $property->headline ?: $property->short_address }}</span>
                                        <span class="text-xs text-gray-600">{{ $property->full_address }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-xs font-mono text-gray-600">{{ $property->property_code }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex flex-col">
                                        <span class="text-sm font-medium text-gray-900">{{ ucfirst(str_replace('_', ' ', $property->property_type)) }}</span>
                                        <span class="text-xs text-gray-600">
                                            @if($property->listing_type === 'sale')
                                                For Sale
                                            @elseif($property->listing_type === 'rent')
                                                For Rent
                                            @else
                                                {{ ucfirst($property->listing_type) }}
                                            @endif
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3 text-sm text-gray-600">
                                        @if($property->bedrooms)
                                        <span class="flex items-center gap-1" title="Bedrooms">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                            </svg>
                                            {{ $property->bedrooms }}
                                        </span>
                                        @endif
                                        @if($property->bathrooms)
                                        <span class="flex items-center gap-1" title="Bathrooms">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M2 6a2 2 0 012-2h12a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zm3 2a1 1 0 011-1h8a1 1 0 110 2H6a1 1 0 01-1-1z"/>
                                            </svg>
                                            {{ $property->bathrooms }}
                                        </span>
                                        @endif
                                        @if($property->parking_spaces)
                                        <span class="flex items-center gap-1" title="Parking Spaces">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                                            </svg>
                                            {{ $property->parking_spaces }}
                                        </span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($property->listing_type === 'rent')
                                        @if($property->rent_per_week)
                                            <span class="text-sm font-bold text-gray-900">${{ number_format($property->rent_per_week) }}</span>
                                            <span class="text-xs text-gray-600">/week</span>
                                        @elseif($property->rent_per_month)
                                            <span class="text-sm font-bold text-gray-900">${{ number_format($property->rent_per_month) }}</span>
                                            <span class="text-xs text-gray-600">/month</span>
                                        @else
                                            <span class="text-sm text-gray-500 italic">Contact for price</span>
                                        @endif
                                    @else
                                        @if($property->price)
                                            <span class="text-sm font-bold text-gray-900">${{ number_format($property->price) }}</span>
                                        @else
                                            <span class="text-sm text-gray-500 italic">POA</span>
                                        @endif
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($property->listingAgent->isNotEmpty())
                                        <span class="text-sm text-gray-900">{{ $property->listingAgent->first()->full_name }}</span>
                                    @else
                                        <span class="text-sm text-gray-500 italic">Unassigned</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex flex-col gap-1">
                                        <span class="px-3 py-1 text-xs font-semibold rounded-full
                                            {{ $property->status === 'active' ? 'bg-green-100 text-green-800' : '' }}
                                            {{ $property->status === 'leased' ? 'bg-blue-100 text-blue-800' : '' }}
                                            {{ $property->status === 'sold' ? 'bg-purple-100 text-purple-800' : '' }}
                                            {{ $property->status === 'under_contract' ? 'bg-orange-100 text-orange-800' : '' }}
                                            {{ $property->status === 'draft' ? 'bg-gray-100 text-gray-800' : '' }}
                                            {{ $property->status === 'inactive' ? 'bg-gray-100 text-gray-600' : '' }}">
                                            {{ ucfirst(str_replace('_', ' ', $property->status)) }}
                                        </span>
                                        @if($property->is_published)
                                            <span class="px-2 py-0.5 text-xs font-semibold rounded-full bg-green-50 text-green-700 text-center">
                                                Published
                                            </span>
                                        @endif
                                        @if($property->is_featured)
                                            <span class="px-2 py-0.5 text-xs font-semibold rounded-full bg-yellow-50 text-yellow-700 text-center">
                                                ⭐ Featured
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex flex-col">
                                        @if($property->listed_at)
                                            <span class="text-sm text-gray-900">{{ $property->listed_at->format('M d, Y') }}</span>
                                            <span class="text-xs text-gray-500">{{ $property->listed_at->diffForHumans() }}</span>
                                        @else
                                            <span class="text-sm text-gray-900">{{ $property->created_at->format('M d, Y') }}</span>
                                            <span class="text-xs text-gray-500">Created</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="p-6">
                    <div class="text-center py-12">
                        <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No Properties Listed</h3>
                        <p class="text-gray-600">This agency hasn't listed any properties yet.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- TAB 4: Documents --}}
    <div id="tab-documents" class="tab-content hidden">
        @if($documentRequirements->count() > 0)
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-[#E6FF4B]/30 to-[#E6FF4B]/10 px-6 py-4 border-b border-gray-100">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-bold text-gray-800 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Documents Review
                    </h2>
                    @php
                        $totalRequired = $documentRequirements->where('is_required', true)->count();
                        $uploadedRequired = $documentRequirements->where('is_required', true)->whereNotNull('file_path')->count();
                        $approvedDocs = $documentRequirements->where('status', 'approved')->count();
                        $pendingDocs = $documentRequirements->where('status', 'pending_review')->count();
                    @endphp
                    <div class="flex items-center gap-3 text-sm">
                        <span class="px-3 py-1 bg-white rounded-lg font-semibold text-gray-700 shadow-sm">
                            {{ $uploadedRequired }}/{{ $totalRequired }} uploaded
                        </span>
                        @if($approvedDocs > 0)
                        <span class="px-3 py-1 bg-[#DDEECD] text-gray-700 rounded-lg font-semibold">
                            {{ $approvedDocs }} approved
                        </span>
                        @endif
                        @if($pendingDocs > 0)
                        <span class="px-3 py-1 bg-[#E6FF4B] text-gray-800 rounded-lg font-semibold animate-pulse">
                            {{ $pendingDocs }} pending
                        </span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="divide-y divide-gray-100">
                @foreach($documentRequirements as $doc)
                <div class="p-6 hover:bg-[#DDEECD]/10 transition-colors">
                    <div class="flex items-start gap-4">
                        <!-- Status Icon -->
                        <div class="flex-shrink-0 mt-1">
                            @if($doc->status === 'approved')
                            <div class="w-12 h-12 bg-[#DDEECD] rounded-xl flex items-center justify-center shadow-sm">
                                <svg class="w-7 h-7 text-gray-700" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            @elseif($doc->status === 'pending_review')
                            <div class="w-12 h-12 bg-[#E6FF4B]/30 rounded-xl flex items-center justify-center animate-pulse shadow-sm">
                                <svg class="w-7 h-7 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            @elseif($doc->status === 'rejected')
                            <div class="w-12 h-12 bg-gray-200 rounded-xl flex items-center justify-center shadow-sm">
                                <svg class="w-7 h-7 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </div>
                            @else
                            <div class="w-12 h-12 bg-gray-100 rounded-xl flex items-center justify-center shadow-sm">
                                <svg class="w-7 h-7 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            @endif
                        </div>

                        <!-- Document Info -->
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 mb-2 flex-wrap">
                                <h3 class="font-bold text-gray-800 text-lg">{{ $doc->name }}</h3>
                                @if($doc->is_required)
                                <span class="text-xs px-2.5 py-1 bg-gray-200 text-gray-700 rounded-full font-bold">Required</span>
                                @endif
                                
                                <!-- Status Badge -->
                                @if($doc->status === 'approved')
                                <span class="text-xs px-2.5 py-1 bg-[#DDEECD] text-gray-700 rounded-full font-bold">✓ Approved</span>
                                @elseif($doc->status === 'pending_review')
                                <span class="text-xs px-2.5 py-1 bg-[#E6FF4B] text-gray-800 rounded-full font-bold">⏳ Pending Review</span>
                                @elseif($doc->status === 'rejected')
                                <span class="text-xs px-2.5 py-1 bg-gray-200 text-gray-600 rounded-full font-bold">✗ Rejected</span>
                                @else
                                <span class="text-xs px-2.5 py-1 bg-gray-100 text-gray-500 rounded-full font-bold">○ Not Uploaded</span>
                                @endif
                            </div>

                            <p class="text-sm text-gray-600 mb-4">{{ $doc->description }}</p>

                            @if($doc->file_path)
                            <!-- File Info Card -->
                            <div class="bg-gradient-to-r from-[#DDEECD]/20 to-[#E6FF4B]/10 border border-gray-200 rounded-xl p-4 mb-4">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3 flex-1 min-w-0">
                                        <div class="w-10 h-10 bg-[#E6FF4B]/30 rounded-lg flex items-center justify-center flex-shrink-0">
                                            <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-bold text-gray-800 truncate">{{ $doc->file_name }}</p>
                                            <p class="text-xs text-gray-600 mt-0.5">
                                                Uploaded {{ $doc->created_at->diffForHumans() }}
                                                @if($doc->reviewed_at)
                                                • Reviewed {{ $doc->reviewed_at->diffForHumans() }}
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                    
                                    <!-- Action Buttons -->
                                    <div class="flex gap-2 ml-4">
                                        <a href="{{ route('admin.agencies.documents.preview', [$agency->id, $doc->id]) }}" 
                                           target="_blank"
                                           class="p-2.5 bg-[#E6FF4B] text-gray-800 rounded-lg hover:bg-[#E6FF4B]/80 transition-colors shadow-md"
                                           title="Preview Document">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </a>
                                        <a href="{{ route('admin.agencies.documents.download', [$agency->id, $doc->id]) }}" 
                                           class="p-2.5 bg-gray-700 text-white rounded-lg hover:bg-gray-800 transition-colors shadow-md"
                                           title="Download Document">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Rejection Reason -->
                            @if($doc->status === 'rejected' && $doc->rejection_reason)
                            <div class="bg-gray-100 border-l-4 border-gray-500 rounded-lg p-4 mb-4">
                                <div class="flex items-start">
                                    <svg class="w-5 h-5 text-gray-600 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                    </svg>
                                    <div>
                                        <p class="text-sm font-bold text-gray-800 mb-1">Rejection Reason:</p>
                                        <p class="text-sm text-gray-700">{{ $doc->rejection_reason }}</p>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <!-- Admin Action Buttons -->
                            @if($doc->file_path && $doc->status !== 'approved')
                            <div class="flex gap-3">
                                <form action="{{ route('admin.agencies.documents.approve', [$agency->id, $doc->id]) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" 
                                            onclick="return confirm('Approve this document?')"
                                            class="px-5 py-2.5 bg-[#DDEECD] text-gray-800 text-sm font-bold rounded-lg hover:bg-[#DDEECD]/80 transition-all shadow-md flex items-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Approve Document
                                    </button>
                                </form>
                                <button onclick="openRejectDocModal({{ $doc->id }}, '{{ $doc->name }}')" 
                                        class="px-5 py-2.5 bg-gray-600 text-white text-sm font-bold rounded-lg hover:bg-gray-700 transition-all shadow-md flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    Reject Document
                                </button>
                            </div>
                            @endif
                            @else
                            <div class="bg-gray-50 border-2 border-dashed border-gray-300 rounded-lg p-4 text-center">
                                <svg class="w-10 h-10 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                </svg>
                                <p class="text-sm text-gray-600 font-medium">Document not uploaded yet</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>

    {{-- TAB 5: Insurance --}}
    <div id="tab-insurance" class="tab-content hidden">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-[#DDEECD]/30 to-[#DDEECD]/10 px-6 py-4 border-b border-gray-100">
                <h2 class="text-xl font-bold text-gray-800 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                    Insurance Information
                </h2>
            </div>
            <div class="p-6">
                <div class="text-center py-12">
                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No Insurance Information</h3>
                    <p class="text-gray-600">Insurance details will be displayed here when available.</p>
                </div>
            </div>
        </div>
    </div>

    {{-- TAB 6: Subscription --}}
    <div id="tab-subscription" class="tab-content hidden">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-[#E6FF4B]/20 to-[#E6FF4B]/10 px-6 py-4 border-b border-gray-100">
                <h2 class="text-xl font-bold text-gray-800 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                    </svg>
                    Subscription Details
                </h2>
            </div>
            <div class="p-6">
                @if($subscription)
                    <div class="grid md:grid-cols-3 gap-6 mb-6">
                        {{-- Current Plan Card --}}
                        <div class="md:col-span-2 bg-gradient-to-br from-[#E6FF4B]/30 to-[#DDEECD]/30 rounded-xl p-6 border-2 border-[#E6FF4B]">
                            <div class="flex items-start justify-between mb-4">
                                <div>
                                    <h3 class="text-lg font-bold text-gray-800 mb-1">Current Plan</h3>
                                    <p class="text-3xl font-bold text-gray-900">{{ $subscription->plan->name }}</p>
                                </div>
                                <span class="px-4 py-2 rounded-lg font-bold text-sm
                                    {{ $subscription->status === 'active' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $subscription->status === 'trialing' ? 'bg-blue-100 text-blue-800' : '' }}
                                    {{ $subscription->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}
                                    {{ $subscription->status === 'expired' ? 'bg-gray-100 text-gray-800' : '' }}">
                                    {{ ucfirst($subscription->status) }}
                                </span>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div class="bg-white/80 rounded-lg p-3">
                                    <p class="text-xs text-gray-600 mb-1">Billing Cycle</p>
                                    <p class="font-bold text-gray-800">{{ ucfirst($subscription->plan->billing_period) }}</p>
                                </div>
                                <div class="bg-white/80 rounded-lg p-3">
                                    <p class="text-xs text-gray-600 mb-1">Price</p>
                                    <p class="font-bold text-gray-800">{{ $subscription->plan->formatted_price }}</p>
                                </div>
                            </div>
                            
                            {{-- Plan Features --}}
                            @if($subscription->plan->features)
                            <div class="bg-white/60 rounded-lg p-4">
                                <p class="text-sm font-bold text-gray-700 mb-2">Plan Features:</p>
                                <div class="grid grid-cols-2 gap-2">
                                    @foreach($subscription->plan->features as $feature)
                                    <div class="flex items-center gap-2 text-sm text-gray-700">
                                        <svg class="w-4 h-4 text-green-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span>{{ $feature }}</span>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        </div>
                        
                        {{-- Usage Limits --}}
                        <div class="space-y-4">
                            <div class="bg-white rounded-xl p-4 border-2 border-gray-200">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-sm font-medium text-gray-600">Agents</span>
                                    <span class="text-sm font-bold text-gray-800">
                                        {{ $quickStats['total_agents'] }} / {{ $subscription->plan->agents_display }}
                                    </span>
                                </div>
                                @php
                                    $agentUsage = $subscription->plan->hasUnlimitedAgents() ? 0 : ($quickStats['total_agents'] / $subscription->plan->max_agents) * 100;
                                @endphp
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-[#4ADE80] h-2 rounded-full transition-all" style="width: {{ min($agentUsage, 100) }}%"></div>
                                </div>
                                @if($agentUsage > 80 && !$subscription->plan->hasUnlimitedAgents())
                                <p class="text-xs text-orange-600 mt-1">⚠️ Approaching limit</p>
                                @endif
                            </div>
                            
                            <div class="bg-white rounded-xl p-4 border-2 border-gray-200">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-sm font-medium text-gray-600">Properties</span>
                                    <span class="text-sm font-bold text-gray-800">
                                        {{ $quickStats['total_properties'] }} / {{ $subscription->plan->properties_display }}
                                    </span>
                                </div>
                                @php
                                    $propertyUsage = $subscription->plan->hasUnlimitedProperties() ? 0 : ($quickStats['total_properties'] / $subscription->plan->max_properties) * 100;
                                @endphp
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-[#4ADE80] h-2 rounded-full transition-all" style="width: {{ min($propertyUsage, 100) }}%"></div>
                                </div>
                                @if($propertyUsage > 80 && !$subscription->plan->hasUnlimitedProperties())
                                <p class="text-xs text-orange-600 mt-1">⚠️ Approaching limit</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    {{-- Billing Information --}}
                    <div class="grid md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <h3 class="text-lg font-bold text-gray-800">Billing Information</h3>
                            
                            <div class="bg-gray-50 rounded-xl p-4 border border-gray-200">
                                <p class="text-sm text-gray-600 mb-1">Current Period Start</p>
                                <p class="font-bold text-gray-800">{{ $subscription->current_period_start->format('M d, Y') }}</p>
                            </div>
                            
                            <div class="bg-gray-50 rounded-xl p-4 border border-gray-200">
                                <p class="text-sm text-gray-600 mb-1">Current Period End</p>
                                <p class="font-bold text-gray-800">{{ $subscription->current_period_end->format('M d, Y') }}</p>
                                <p class="text-xs text-gray-600 mt-1">
                                    {{ $subscription->daysUntilRenewal() > 0 ? $subscription->daysUntilRenewal() . ' days until renewal' : 'Renewal due' }}
                                </p>
                            </div>
                            
                            @if($subscription->trial_ends_at)
                            <div class="bg-blue-50 rounded-xl p-4 border border-blue-200">
                                <p class="text-sm text-blue-700 mb-1">Trial Period</p>
                                <p class="font-bold text-blue-900">
                                    @if($subscription->isOnTrial())
                                        Ends {{ $subscription->trial_ends_at->format('M d, Y') }}
                                    @else
                                        Ended {{ $subscription->trial_ends_at->format('M d, Y') }}
                                    @endif
                                </p>
                            </div>
                            @endif
                            
                            @if($subscription->cancelled_at)
                            <div class="bg-red-50 rounded-xl p-4 border border-red-200">
                                <p class="text-sm text-red-700 mb-1">Cancelled</p>
                                <p class="font-bold text-red-900">{{ $subscription->cancelled_at->format('M d, Y') }}</p>
                                @if($subscription->ends_at)
                                <p class="text-xs text-red-700 mt-1">Access ends {{ $subscription->ends_at->format('M d, Y') }}</p>
                                @endif
                            </div>
                            @endif
                        </div>
                        
                        {{-- Stripe Information --}}
                        <div class="space-y-4">
                            <h3 class="text-lg font-bold text-gray-800">Payment Details</h3>
                            
                            @if($subscription->stripe_customer_id)
                            <div class="bg-gray-50 rounded-xl p-4 border border-gray-200">
                                <p class="text-sm text-gray-600 mb-1">Stripe Customer ID</p>
                                <p class="font-mono text-sm text-gray-800">{{ $subscription->stripe_customer_id }}</p>
                            </div>
                            @endif
                            
                            @if($subscription->stripe_subscription_id)
                            <div class="bg-gray-50 rounded-xl p-4 border border-gray-200">
                                <p class="text-sm text-gray-600 mb-1">Stripe Subscription ID</p>
                                <p class="font-mono text-sm text-gray-800">{{ $subscription->stripe_subscription_id }}</p>
                            </div>
                            @endif
                            
                            {{-- Recent Transactions --}}
                            @if($transactions->count() > 0)
                            <div class="bg-gray-50 rounded-xl p-4 border border-gray-200">
                                <p class="text-sm font-bold text-gray-700 mb-3">Recent Transactions</p>
                                <div class="space-y-2">
                                    @foreach($transactions->take(5) as $transaction)
                                    <div class="flex items-center justify-between py-2 border-b border-gray-200 last:border-0">
                                        <div class="flex-1">
                                            <div class="flex items-center gap-2">
                                                <span class="text-sm text-gray-800">{{ $transaction->created_at->format('M d, Y') }}</span>
                                                @if($transaction->subscription && $transaction->subscription->plan)
                                                    <span class="text-xs px-2 py-0.5 bg-gray-100 text-gray-600 rounded">
                                                        {{ $transaction->subscription->plan->name }}
                                                    </span>
                                                @endif
                                            </div>
                                            @if($transaction->description)
                                            <p class="text-xs text-gray-600 mt-0.5">{{ $transaction->description }}</p>
                                            @endif
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <span class="font-bold text-gray-800">${{ number_format($transaction->amount, 2) }}</span>
                                            <span class="px-2 py-0.5 text-xs font-semibold rounded-full
                                                {{ $transaction->status === 'completed' ? 'bg-green-100 text-green-700' : '' }}
                                                {{ $transaction->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                                {{ $transaction->status === 'failed' ? 'bg-red-100 text-red-700' : '' }}">
                                                {{ ucfirst($transaction->status) }}
                                            </span>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                
                                @if($transactions->count() > 5)
                                <div class="mt-3 pt-3 border-t border-gray-200">
                                    <p class="text-xs text-gray-600 text-center">
                                        Showing 5 of {{ $transactions->count() }} transactions
                                    </p>
                                </div>
                                @endif
                            </div>
                            @endif
                        </div>
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No Active Subscription</h3>
                        <p class="text-gray-600 mb-4">This agency doesn't have an active subscription yet.</p>
                        @if($agency->status === 'approved')
                        <p class="text-sm text-orange-600 font-medium">⚠️ Agency is approved but needs to select a subscription plan</p>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>

</div>

{{-- Modals (kept from original) --}}
{{-- Reject Agency Modal --}}
<div id="rejectModal" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-2xl w-full p-6 animate-slideUp shadow-2xl">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-xl font-bold text-gray-800">Reject Agency Application</h3>
            <button onclick="closeRejectModal()" class="text-gray-400 hover:text-gray-600 p-2 rounded-lg hover:bg-gray-100 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <form action="{{ route('admin.agencies.reject', $agency->id) }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="rejection_reason" class="block text-sm font-bold text-gray-700 mb-2">
                    Rejection Reason <span class="text-gray-500">*</span>
                </label>
                <textarea id="rejection_reason" 
                          name="rejection_reason" 
                          rows="5" 
                          required
                          minlength="10"
                          class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#DDEECD] focus:border-[#DDEECD]"
                          placeholder="Please provide a detailed reason for rejection."></textarea>
            </div>

            <div class="flex gap-3">
                <button type="button" 
                        onclick="closeRejectModal()"
                        class="flex-1 px-4 py-3 bg-gray-100 text-gray-700 rounded-xl font-bold hover:bg-gray-200 transition-colors">
                    Cancel
                </button>
                <button type="submit" class="flex-1 px-4 py-3 bg-gray-600 text-white rounded-xl font-bold hover:bg-gray-700 transition-colors shadow-lg">
                    Reject Agency
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Reject Document Modal --}}
<div id="rejectDocModal" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-lg w-full p-6 animate-slideUp shadow-2xl">
        <h3 class="text-xl font-bold text-gray-800 mb-2">Reject Document</h3>
        <p class="text-sm text-gray-600 mb-4">Document: <span id="docName" class="font-bold text-gray-800"></span></p>
        
        <form id="rejectDocForm" method="POST">
            @csrf
            <div class="mb-4">
                <label for="doc_rejection_reason" class="block text-sm font-bold text-gray-700 mb-2">
                    Rejection Reason <span class="text-gray-500">*</span>
                </label>
                <textarea id="doc_rejection_reason" 
                          name="rejection_reason" 
                          rows="4" 
                          required
                          minlength="10"
                          class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#DDEECD] focus:border-[#DDEECD]"
                          placeholder="Why is this document being rejected?"></textarea>
            </div>

            <div class="flex gap-3">
                <button type="button" 
                        onclick="closeRejectDocModal()"
                        class="flex-1 px-4 py-3 bg-gray-100 text-gray-700 rounded-xl font-bold hover:bg-gray-200 transition-colors">
                    Cancel
                </button>
                <button type="submit" class="flex-1 px-4 py-3 bg-gray-600 text-white rounded-xl font-bold hover:bg-gray-700 transition-colors shadow-lg">
                    Reject Document
                </button>
            </div>
        </form>
    </div>
</div>

<style>
@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes slideUp {
    from {
        opacity: 0;
        transform: translateY(20px) scale(0.95);
    }
    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

.animate-slideDown {
    animation: slideDown 0.3s ease-out;
}

.animate-slideUp {
    animation: slideUp 0.3s ease-out;
}

/* Tab Styles */
.tab-btn {
    color: #6b7280;
    background: transparent;
}

.tab-btn.active {
    background: linear-gradient(135deg, #DDEECD 0%, #E6FF4B 100%);
    color: #1f2937;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
}
</style>

<script>
// Tab Switching
function switchTab(tabName) {
    // Hide all tab contents
    document.querySelectorAll('.tab-content').forEach(content => {
        content.classList.add('hidden');
    });
    
    // Remove active class from all tabs
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.classList.remove('active');
    });
    
    // Show selected tab content
    document.getElementById('tab-' + tabName).classList.remove('hidden');
    
    // Add active class to selected tab
    document.querySelector('[data-tab="' + tabName + '"]').classList.add('active');
    
    // Save to localStorage
    localStorage.setItem('activeAgencyTab', tabName);
}

// Initialize tab on page load
document.addEventListener('DOMContentLoaded', function() {
    const savedTab = localStorage.getItem('activeAgencyTab') || 'details';
    switchTab(savedTab);
});

// Modal functions
function openRejectModal() {
    document.getElementById('rejectModal').classList.remove('hidden');
}

function closeRejectModal() {
    document.getElementById('rejectModal').classList.add('hidden');
}

function openRejectDocModal(docId, docName) {
    document.getElementById('docName').textContent = docName;
    document.getElementById('rejectDocForm').action = '{{ route("admin.agencies.documents.reject", [$agency->id, "DOC_ID"]) }}'.replace('DOC_ID', docId);
    document.getElementById('rejectDocModal').classList.remove('hidden');
}

function closeRejectDocModal() {
    document.getElementById('rejectDocModal').classList.add('hidden');
}

// Close modals when clicking outside
document.getElementById('rejectModal')?.addEventListener('click', function(e) {
    if (e.target === this) closeRejectModal();
});

document.getElementById('rejectDocModal')?.addEventListener('click', function(e) {
    if (e.target === this) closeRejectDocModal();
});

// Auto-hide flash messages
setTimeout(() => {
    const alerts = document.querySelectorAll('.animate-slideDown');
    alerts.forEach(alert => {
        alert.style.animation = 'slideUp 0.3s ease-out reverse';
        setTimeout(() => alert.remove(), 300);
    });
}, 5000);
</script>

@endsection