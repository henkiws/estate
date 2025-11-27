@extends('layouts.admin')

@section('title', $agency->agency_name . ' - Agency Details')

@section('content')

{{-- Flash Messages --}}
@if(session('success'))
<div class="mb-6 bg-green-50 border-l-4 border-green-500 rounded-xl p-4 flex items-start animate-slideDown shadow-lg">
    <svg class="w-6 h-6 text-green-600 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
    </svg>
    <div class="flex-1">
        <h3 class="text-sm font-semibold text-green-800">Success!</h3>
        <p class="text-sm text-green-700 mt-1">{{ session('success') }}</p>
    </div>
</div>
@endif

@if(session('error'))
<div class="mb-6 bg-red-50 border-l-4 border-red-500 rounded-xl p-4 flex items-start animate-slideDown shadow-lg">
    <svg class="w-6 h-6 text-red-600 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
    </svg>
    <div class="flex-1">
        <h3 class="text-sm font-semibold text-red-800">Error!</h3>
        <p class="text-sm text-red-700 mt-1">{{ session('error') }}</p>
    </div>
</div>
@endif

{{-- Header --}}
<div class="mb-8">
    <div class="flex items-start gap-4 mb-4">
        <a href="{{ route('admin.agencies.index') }}" 
           class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div class="flex-1">
            <h1 class="text-3xl font-bold text-gray-900 mb-1">{{ $agency->agency_name }}</h1>
            <div class="flex items-center gap-3 text-sm text-gray-600">
                <span class="flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    Registered {{ $agency->created_at->format('M d, Y') }}
                </span>
                <span>•</span>
                <span>{{ $agency->created_at->diffForHumans() }}</span>
            </div>
        </div>
        
        {{-- Action Buttons --}}
        <div class="flex gap-2">
            @if($agency->status === 'pending')
            <form action="{{ route('admin.agencies.approve', $agency->id) }}" method="POST" class="inline">
                @csrf
                <button type="submit" 
                        onclick="return confirm('Approve {{ $agency->agency_name }}? They will be able to choose a subscription plan.')"
                        class="px-6 py-3 bg-green-600 text-white rounded-xl font-semibold hover:bg-green-700 transition-all shadow-lg hover:shadow-xl flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Approve Agency
                </button>
            </form>
            <button onclick="openRejectModal()" 
                    class="px-6 py-3 bg-red-600 text-white rounded-xl font-semibold hover:bg-red-700 transition-all flex items-center gap-2">
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
                        class="px-6 py-3 bg-orange-600 text-white rounded-xl font-semibold hover:bg-orange-700 transition-all flex items-center gap-2">
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
                        class="px-6 py-3 bg-green-600 text-white rounded-xl font-semibold hover:bg-green-700 transition-all flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Reactivate
                </button>
            </form>
            @endif
            <a href="{{ route('admin.agencies.edit', $agency->id) }}" 
               class="px-6 py-3 bg-blue-600 text-white rounded-xl font-semibold hover:bg-blue-700 transition-all flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit
            </a>
        </div>
    </div>

    {{-- Status Badge --}}
    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-xl font-semibold shadow-sm
        {{ $agency->status === 'active' ? 'bg-green-100 text-green-800' : '' }}
        {{ $agency->status === 'approved' ? 'bg-blue-100 text-blue-800' : '' }}
        {{ $agency->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
        {{ $agency->status === 'rejected' ? 'bg-red-100 text-red-800' : '' }}
        {{ $agency->status === 'suspended' ? 'bg-orange-100 text-orange-800' : '' }}
        {{ $agency->status === 'inactive' ? 'bg-gray-100 text-gray-800' : '' }}">
        <span class="w-2.5 h-2.5 rounded-full
            {{ $agency->status === 'active' ? 'bg-green-600 animate-pulse' : '' }}
            {{ $agency->status === 'approved' ? 'bg-blue-600' : '' }}
            {{ $agency->status === 'pending' ? 'bg-yellow-600 animate-pulse' : '' }}
            {{ $agency->status === 'rejected' ? 'bg-red-600' : '' }}
            {{ $agency->status === 'suspended' ? 'bg-orange-600' : '' }}
            {{ $agency->status === 'inactive' ? 'bg-gray-600' : '' }}">
        </span>
        {{ ucfirst($agency->status) }}
        @if($agency->status === 'approved')
        <span class="text-xs opacity-75">• Awaiting Subscription</span>
        @endif
    </div>
</div>

{{-- 2-COLUMN LAYOUT --}}
<div class="grid lg:grid-cols-3 gap-8">
    
    {{-- LEFT COLUMN (2/3 width) --}}
    <div class="lg:col-span-2 space-y-6">
        
        {{-- Agency Information --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-4 border-b border-gray-100">
                <h2 class="text-xl font-bold text-gray-900 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    Agency Information
                </h2>
            </div>
            <div class="p-6">
                <div class="grid md:grid-cols-2 gap-6">
                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Agency Name</label>
                        <p class="text-gray-900 font-medium">{{ $agency->agency_name }}</p>
                    </div>
                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Trading Name</label>
                        <p class="text-gray-900 font-medium">{{ $agency->trading_name ?? 'N/A' }}</p>
                    </div>
                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">ABN</label>
                        <p class="text-gray-900 font-mono">{{ $agency->abn }}</p>
                    </div>
                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">ACN</label>
                        <p class="text-gray-900 font-mono">{{ $agency->acn ?? 'N/A' }}</p>
                    </div>
                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Business Type</label>
                        <p class="text-gray-900 font-medium">{{ ucfirst(str_replace('_', ' ', $agency->business_type)) }}</p>
                    </div>
                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">License Number</label>
                        <p class="text-gray-900 font-mono">{{ $agency->license_number }}</p>
                    </div>
                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">License Holder</label>
                        <p class="text-gray-900 font-medium">{{ $agency->license_holder_name }}</p>
                    </div>
                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">License Expiry</label>
                        <p class="text-gray-900 font-medium">
                            {{ $agency->license_expiry_date ? $agency->license_expiry_date->format('M d, Y') : 'N/A' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Contact Information --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-purple-50 to-pink-50 px-6 py-4 border-b border-gray-100">
                <h2 class="text-xl font-bold text-gray-900 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    Contact Information
                </h2>
            </div>
            <div class="p-6">
                <div class="grid md:grid-cols-2 gap-6">
                    <div class="space-y-1 md:col-span-2">
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Business Address</label>
                        <p class="text-gray-900 font-medium">{{ $agency->business_address }}</p>
                    </div>
                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">State / Postcode</label>
                        <p class="text-gray-900 font-medium">{{ $agency->state }} {{ $agency->postcode }}</p>
                    </div>
                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Business Phone</label>
                        <p class="text-gray-900 font-medium">
                            <a href="tel:{{ $agency->business_phone }}" class="text-blue-600 hover:underline">
                                {{ $agency->business_phone }}
                            </a>
                        </p>
                    </div>
                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Business Email</label>
                        <p class="text-gray-900 font-medium">
                            <a href="mailto:{{ $agency->business_email }}" class="text-blue-600 hover:underline">
                                {{ $agency->business_email }}
                            </a>
                        </p>
                    </div>
                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Website</label>
                        <p class="text-gray-900 font-medium">
                            @if($agency->website_url)
                                <a href="{{ $agency->website_url }}" target="_blank" class="text-blue-600 hover:underline flex items-center gap-1">
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
            <div class="bg-gradient-to-r from-green-50 to-emerald-50 px-6 py-4 border-b border-gray-100">
                <h2 class="text-xl font-bold text-gray-900 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    Primary Contact
                </h2>
            </div>
            <div class="p-6">
                <div class="grid md:grid-cols-2 gap-6">
                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Full Name</label>
                        <p class="text-gray-900 font-medium">{{ $agency->primaryContact->full_name }}</p>
                    </div>
                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Position</label>
                        <p class="text-gray-900 font-medium">{{ $agency->primaryContact->position }}</p>
                    </div>
                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Email</label>
                        <p class="text-gray-900 font-medium">
                            <a href="mailto:{{ $agency->primaryContact->email }}" class="text-blue-600 hover:underline">
                                {{ $agency->primaryContact->email }}
                            </a>
                        </p>
                    </div>
                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Phone</label>
                        <p class="text-gray-900 font-medium">
                            <a href="tel:{{ $agency->primaryContact->phone }}" class="text-blue-600 hover:underline">
                                {{ $agency->primaryContact->phone }}
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        @endif

        {{-- DOCUMENTS REVIEW SECTION - IMPROVED --}}
        @if($documentRequirements->count() > 0)
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-orange-50 to-amber-50 px-6 py-4 border-b border-gray-100">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-bold text-gray-900 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                        <span class="px-3 py-1 bg-green-100 text-green-700 rounded-lg font-semibold">
                            {{ $approvedDocs }} approved
                        </span>
                        @endif
                        @if($pendingDocs > 0)
                        <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-lg font-semibold animate-pulse">
                            {{ $pendingDocs }} pending
                        </span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="divide-y divide-gray-100">
                @foreach($documentRequirements as $doc)
                <div class="p-6 hover:bg-gray-50 transition-colors">
                    <div class="flex items-start gap-4">
                        <!-- Status Icon -->
                        <div class="flex-shrink-0 mt-1">
                            @if($doc->status === 'approved')
                            <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center shadow-sm">
                                <svg class="w-7 h-7 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            @elseif($doc->status === 'pending_review')
                            <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center animate-pulse shadow-sm">
                                <svg class="w-7 h-7 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            @elseif($doc->status === 'rejected')
                            <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center shadow-sm">
                                <svg class="w-7 h-7 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                                <h3 class="font-bold text-gray-900 text-lg">{{ $doc->name }}</h3>
                                @if($doc->is_required)
                                <span class="text-xs px-2.5 py-1 bg-red-100 text-red-700 rounded-full font-bold">Required</span>
                                @endif
                                
                                <!-- Status Badge -->
                                @if($doc->status === 'approved')
                                <span class="text-xs px-2.5 py-1 bg-green-100 text-green-700 rounded-full font-bold">✓ Approved</span>
                                @elseif($doc->status === 'pending_review')
                                <span class="text-xs px-2.5 py-1 bg-yellow-100 text-yellow-700 rounded-full font-bold">⏳ Pending Review</span>
                                @elseif($doc->status === 'rejected')
                                <span class="text-xs px-2.5 py-1 bg-red-100 text-red-700 rounded-full font-bold">✗ Rejected</span>
                                @else
                                <span class="text-xs px-2.5 py-1 bg-gray-100 text-gray-600 rounded-full font-bold">○ Not Uploaded</span>
                                @endif
                            </div>

                            <p class="text-sm text-gray-600 mb-4">{{ $doc->description }}</p>

                            @if($doc->file_path)
                            <!-- File Info Card -->
                            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-xl p-4 mb-4">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3 flex-1 min-w-0">
                                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-bold text-gray-900 truncate">{{ $doc->file_name }}</p>
                                            <p class="text-xs text-gray-600 mt-0.5">
                                                Uploaded {{ $doc->created_at ? $doc->created_at->diffForHumans() : $doc->created_at->diffForHumans() }}
                                                @if($doc->reviewed_at)
                                                • Reviewed {{ $doc->reviewed_at->diffForHumans() }}
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                    
                                    <!-- Action Buttons -->
                                    <div class="flex gap-2 ml-4">
                                        <!-- Preview Button -->
                                        <a href="{{ route('admin.agencies.documents.preview', [$agency->id, $doc->id]) }}" 
                                           target="_blank"
                                           class="p-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors shadow-md hover:shadow-lg"
                                           title="Preview Document">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </a>
                                        <!-- Download Button -->
                                        <a href="{{ route('admin.agencies.documents.download', [$agency->id, $doc->id]) }}" 
                                           class="p-2.5 bg-gray-700 text-white rounded-lg hover:bg-gray-800 transition-colors shadow-md hover:shadow-lg"
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
                            <div class="bg-red-50 border-l-4 border-red-500 rounded-lg p-4 mb-4">
                                <div class="flex items-start">
                                    <svg class="w-5 h-5 text-red-600 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                    </svg>
                                    <div>
                                        <p class="text-sm font-bold text-red-800 mb-1">Rejection Reason:</p>
                                        <p class="text-sm text-red-700">{{ $doc->rejection_reason }}</p>
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
                                            class="px-5 py-2.5 bg-green-600 text-white text-sm font-bold rounded-lg hover:bg-green-700 transition-all shadow-md hover:shadow-lg flex items-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Approve Document
                                    </button>
                                </form>
                                <button onclick="openRejectDocModal({{ $doc->id }}, '{{ $doc->name }}')" 
                                        class="px-5 py-2.5 bg-red-600 text-white text-sm font-bold rounded-lg hover:bg-red-700 transition-all shadow-md hover:shadow-lg flex items-center gap-2">
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

        {{-- ACTIVITY LOG SECTION - IMPROVED --}}
        @if(isset($activityLogs) && $activityLogs->count() > 0)
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-indigo-50 to-purple-50 px-6 py-4 border-b border-gray-100">
                <h2 class="text-xl font-bold text-gray-900 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                    </svg>
                    Activity Log
                    <span class="ml-auto text-sm font-normal text-gray-600">{{ $activityLogs->count() }} activities</span>
                </h2>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @foreach($activityLogs as $log)
                    <div class="relative">
                        <!-- Timeline Line -->
                        @if(!$loop->last)
                        <div class="absolute left-5 top-12 bottom-0 w-0.5 bg-gray-200"></div>
                        @endif
                        
                        <div class="flex items-start gap-4">
                            <!-- Icon -->
                            <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0 shadow-md
                                {{ str_contains(strtolower($log->description), 'approved') ? 'bg-green-100' : '' }}
                                {{ str_contains(strtolower($log->description), 'rejected') ? 'bg-red-100' : '' }}
                                {{ str_contains(strtolower($log->description), 'uploaded') || str_contains(strtolower($log->description), 'created') ? 'bg-blue-100' : '' }}
                                {{ str_contains(strtolower($log->description), 'suspended') ? 'bg-orange-100' : '' }}
                                {{ !str_contains(strtolower($log->description), 'approved') && !str_contains(strtolower($log->description), 'rejected') && !str_contains(strtolower($log->description), 'uploaded') && !str_contains(strtolower($log->description), 'created') && !str_contains(strtolower($log->description), 'suspended') ? 'bg-gray-100' : '' }}">
                                @if(str_contains(strtolower($log->description), 'approved'))
                                <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                @elseif(str_contains(strtolower($log->description), 'rejected'))
                                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                @elseif(str_contains(strtolower($log->description), 'uploaded') || str_contains(strtolower($log->description), 'created'))
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                </svg>
                                @elseif(str_contains(strtolower($log->description), 'suspended'))
                                <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                                </svg>
                                @else
                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                @endif
                            </div>
                            
                            <!-- Content -->
                            <div class="flex-1 bg-gray-50 rounded-xl p-4 border border-gray-200">
                                <p class="text-sm font-bold text-gray-900 mb-2">{{ $log->description }}</p>
                                
                                @if($log->properties && count($log->properties) > 0)
                                <div class="space-y-1 mb-3">
                                    @foreach($log->properties as $key => $value)
                                        @if(!is_array($value) && $key !== 'old' && $key !== 'attributes')
                                        <p class="text-xs text-gray-600 flex items-center gap-2">
                                            <span class="w-2 h-2 bg-gray-400 rounded-full"></span>
                                            <span class="font-semibold">{{ ucfirst(str_replace('_', ' ', $key)) }}:</span> 
                                            <span class="text-gray-900">{{ $value }}</span>
                                        </p>
                                        @endif
                                    @endforeach
                                </div>
                                @endif
                                
                                <div class="flex items-center gap-4 text-xs text-gray-500">
                                    <span class="flex items-center gap-1 font-medium">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        {{ $log->causer->name ?? 'System' }}
                                    </span>
                                    <span class="text-gray-300">•</span>
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ $log->created_at->format('M d, Y h:i A') }}
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

        {{-- Agents List --}}
        @if($agency->agents->count() > 0)
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-cyan-50 to-blue-50 px-6 py-4 border-b border-gray-100">
                <h2 class="text-xl font-bold text-gray-900 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    Agents
                    <span class="ml-auto text-sm font-normal text-gray-600">{{ $agency->agents->count() }} agents</span>
                </h2>
            </div>
            <div class="p-6">
                <div class="grid md:grid-cols-2 gap-4">
                    @foreach($agency->agents as $agent)
                    <div class="flex items-center gap-4 p-4 border border-gray-200 rounded-xl hover:border-blue-300 hover:shadow-md transition-all">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-full flex items-center justify-center text-white font-bold text-lg shadow-md">
                            {{ strtoupper(substr($agent->agent_name, 0, 2)) }}
                        </div>
                        <div class="flex-1">
                            <h3 class="font-bold text-gray-900">{{ $agent->agent_name }}</h3>
                            <p class="text-sm text-gray-600">{{ $agent->position ?? 'Sales Agent' }}</p>
                        </div>
                        <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold">
                            {{ ucfirst($agent->status) }}
                        </span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
    </div>

    {{-- RIGHT SIDEBAR (1/3 width) --}}
    <div class="space-y-6">
        
        {{-- Quick Stats --}}
        <div class="bg-gradient-to-br from-blue-600 to-indigo-700 rounded-2xl shadow-xl p-6 text-white">
            <h3 class="text-lg font-bold mb-6 flex items-center">
                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
                Quick Stats
            </h3>
            <div class="space-y-4">
                <div class="flex justify-between items-center pb-4 border-b border-white/20">
                    <span class="text-white/80 text-sm font-medium">Total Agents</span>
                    <span class="text-3xl font-bold">{{ $agency->agents->count() }}</span>
                </div>
                <div class="flex justify-between items-center pb-4 border-b border-white/20">
                    <span class="text-white/80 text-sm font-medium">Member Since</span>
                    <span class="font-bold">{{ $agency->created_at->format('M Y') }}</span>
                </div>
                <div class="flex justify-between items-center pb-4 border-b border-white/20">
                    <span class="text-white/80 text-sm font-medium">Documents</span>
                    <span class="font-bold">
                        @php
                            $uploaded = $documentRequirements->whereNotNull('file_path')->count();
                            $total = $documentRequirements->count();
                        @endphp
                        {{ $uploaded }}/{{ $total }}
                    </span>
                </div>
                @if($agency->verified_at)
                <div class="flex justify-between items-center">
                    <span class="text-white/80 text-sm font-medium">Approved</span>
                    <span class="font-bold">{{ $agency->verified_at->format('M d, Y') }}</span>
                </div>
                @endif
            </div>
        </div>

        {{-- Subscription Info --}}
        @if($subscription)
        <div class="bg-gradient-to-br from-purple-600 to-pink-600 rounded-2xl p-6 text-white shadow-xl">
            <h3 class="text-lg font-bold mb-4 flex items-center">
                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                </svg>
                Subscription
            </h3>
            <div class="space-y-3">
                <div>
                    <p class="text-white/80 text-sm font-medium">Plan</p>
                    <p class="text-2xl font-bold mt-1">{{ $subscription->subscriptionPlan->name }}</p>
                </div>
                <div class="h-px bg-white/20"></div>
                <div>
                    <p class="text-white/80 text-sm font-medium">Status</p>
                    <p class="font-bold mt-1">{{ ucfirst($subscription->status) }}</p>
                </div>
                <div class="h-px bg-white/20"></div>
                <div>
                    <p class="text-white/80 text-sm font-medium">Next Billing</p>
                    <p class="font-bold mt-1">{{ $subscription->current_period_end->format('M d, Y') }}</p>
                </div>
            </div>
        </div>
        @endif

        {{-- Danger Zone --}}
        <div class="bg-red-50 rounded-2xl border-2 border-red-200 p-6">
            <h3 class="text-lg font-bold text-red-900 mb-3 flex items-center">
                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
                Danger Zone
            </h3>
            <p class="text-sm text-red-700 mb-4">Deleting an agency is permanent and cannot be undone. All data including agents, properties, and documents will be permanently removed.</p>
            <form action="{{ route('admin.agencies.destroy', $agency->id) }}" method="POST" onsubmit="return confirm('⚠️ Are you absolutely sure?\n\nThis will permanently delete:\n• Agency profile\n• All agents\n• All documents\n• All activity logs\n\nType DELETE to confirm')">
                @csrf
                @method('DELETE')
                <button type="submit" class="w-full px-4 py-3 bg-red-600 text-white rounded-xl hover:bg-red-700 transition-all font-bold shadow-lg hover:shadow-xl flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    Delete Agency
                </button>
            </form>
        </div>
    </div>
</div>

{{-- Reject Agency Modal --}}
<div id="rejectModal" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-2xl w-full p-6 animate-slideUp shadow-2xl">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-xl font-bold text-gray-900">Reject Agency Application</h3>
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
                    Rejection Reason <span class="text-red-600">*</span>
                </label>
                <textarea id="rejection_reason" 
                          name="rejection_reason" 
                          rows="5" 
                          required
                          minlength="10"
                          class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500"
                          placeholder="Please provide a detailed reason for rejection. This will be sent to the agency via email."></textarea>
                <p class="text-xs text-gray-500 mt-1">Minimum 10 characters. Be specific and professional.</p>
            </div>

            <div class="bg-yellow-50 border-l-4 border-yellow-500 rounded-lg p-4 mb-4">
                <div class="flex">
                    <svg class="w-5 h-5 text-yellow-600 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                    <p class="text-sm text-yellow-800">
                        The agency will receive an email with your rejection reason. Please ensure it's clear, professional, and actionable.
                    </p>
                </div>
            </div>

            <div class="flex gap-3">
                <button type="button" 
                        onclick="closeRejectModal()"
                        class="flex-1 px-4 py-3 bg-gray-100 text-gray-700 rounded-xl font-bold hover:bg-gray-200 transition-colors">
                    Cancel
                </button>
                <button type="submit" class="flex-1 px-4 py-3 bg-red-600 text-white rounded-xl font-bold hover:bg-red-700 transition-colors shadow-lg hover:shadow-xl">
                    Reject Agency
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Reject Document Modal --}}
<div id="rejectDocModal" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-lg w-full p-6 animate-slideUp shadow-2xl">
        <h3 class="text-xl font-bold text-gray-900 mb-2">Reject Document</h3>
        <p class="text-sm text-gray-600 mb-4">Document: <span id="docName" class="font-bold text-gray-900"></span></p>
        
        <form id="rejectDocForm" method="POST">
            @csrf
            <div class="mb-4">
                <label for="doc_rejection_reason" class="block text-sm font-bold text-gray-700 mb-2">
                    Rejection Reason <span class="text-red-600">*</span>
                </label>
                <textarea id="doc_rejection_reason" 
                          name="rejection_reason" 
                          rows="4" 
                          required
                          minlength="10"
                          class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500"
                          placeholder="Why is this document being rejected? What needs to be corrected?"></textarea>
                <p class="text-xs text-gray-500 mt-1">Minimum 10 characters</p>
            </div>

            <div class="flex gap-3">
                <button type="button" 
                        onclick="closeRejectDocModal()"
                        class="flex-1 px-4 py-3 bg-gray-100 text-gray-700 rounded-xl font-bold hover:bg-gray-200 transition-colors">
                    Cancel
                </button>
                <button type="submit" class="flex-1 px-4 py-3 bg-red-600 text-white rounded-xl font-bold hover:bg-red-700 transition-colors shadow-lg hover:shadow-xl">
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
</style>

<script>
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