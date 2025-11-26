@extends('layouts.admin')

@section('title', $agency->agency_name . ' - Agency Details')

@section('content')

{{-- Flash Messages --}}
@if(session('success'))
<div class="mb-6 bg-green-50 border border-green-200 rounded-xl p-4 flex items-start animate-fadeIn">
    <svg class="w-6 h-6 text-green-600 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
    </svg>
    <p class="text-green-800 font-medium">{{ session('success') }}</p>
</div>
@endif

@if(session('error'))
<div class="mb-6 bg-red-50 border border-red-200 rounded-xl p-4 flex items-start animate-fadeIn">
    <svg class="w-6 h-6 text-red-600 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
    </svg>
    <p class="text-red-800 font-medium">{{ session('error') }}</p>
</div>
@endif

{{-- Header --}}
<div class="mb-8">
    <div class="flex items-center gap-3 mb-4">
        <a href="{{ route('admin.agencies.index') }}" class="p-2 hover:bg-gray-100 rounded-lg transition">
            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div class="flex-1">
            <h1 class="text-3xl font-bold text-gray-900">{{ $agency->agency_name }}</h1>
            <p class="text-gray-600 mt-1">Registered on {{ $agency->created_at->format('F d, Y') }}</p>
        </div>
        <div class="flex gap-2">
            @if($agency->status === 'pending')
            <form action="{{ route('admin.agencies.approve', $agency->id) }}" method="POST" class="inline">
                @csrf
                <button type="submit" 
                        onclick="return confirm('Approve {{ $agency->agency_name }}? This will allow them to choose a subscription plan.')"
                        class="px-6 py-3 bg-green-600 text-white rounded-xl font-semibold hover:bg-green-700 transition flex items-center gap-2 shadow-lg hover:shadow-xl">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Approve Agency
                </button>
            </form>
            <button onclick="openRejectModal()" class="px-6 py-3 bg-red-600 text-white rounded-xl font-semibold hover:bg-red-700 transition flex items-center gap-2">
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
                        class="px-6 py-3 bg-orange-600 text-white rounded-xl font-semibold hover:bg-orange-700 transition">
                    Suspend
                </button>
            </form>
            @elseif($agency->status === 'suspended')
            <form action="{{ route('admin.agencies.reactivate', $agency->id) }}" method="POST" class="inline">
                @csrf
                <button type="submit" 
                        onclick="return confirm('Reactivate {{ $agency->agency_name }}?')"
                        class="px-6 py-3 bg-green-600 text-white rounded-xl font-semibold hover:bg-green-700 transition">
                    Reactivate
                </button>
            </form>
            @endif
            <a href="{{ route('admin.agencies.edit', $agency->id) }}" class="px-6 py-3 bg-primary text-white rounded-xl font-semibold hover:bg-primary-dark transition">
                Edit Agency
            </a>
        </div>
    </div>

    {{-- Status Badge --}}
    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-xl font-semibold
        {{ $agency->status === 'active' ? 'bg-green-100 text-green-800' : '' }}
        {{ $agency->status === 'approved' ? 'bg-blue-100 text-blue-800' : '' }}
        {{ $agency->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
        {{ $agency->status === 'rejected' ? 'bg-red-100 text-red-800' : '' }}
        {{ $agency->status === 'suspended' ? 'bg-orange-100 text-orange-800' : '' }}
        {{ $agency->status === 'inactive' ? 'bg-gray-100 text-gray-800' : '' }}">
        <span class="w-2 h-2 rounded-full
            {{ $agency->status === 'active' ? 'bg-green-600 animate-pulse' : '' }}
            {{ $agency->status === 'approved' ? 'bg-blue-600' : '' }}
            {{ $agency->status === 'pending' ? 'bg-yellow-600 animate-pulse' : '' }}
            {{ $agency->status === 'rejected' ? 'bg-red-600' : '' }}
            {{ $agency->status === 'suspended' ? 'bg-orange-600' : '' }}
            {{ $agency->status === 'inactive' ? 'bg-gray-600' : '' }}">
        </span>
        {{ ucfirst($agency->status) }}
        @if($agency->status === 'approved')
        - Awaiting Subscription
        @endif
    </div>
</div>

<div class="grid lg:grid-cols-3 gap-8">
    {{-- Main Content --}}
    <div class="lg:col-span-2 space-y-8">
        
        {{-- Agency Information --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
            <div class="p-6 border-b border-gray-100">
                <h2 class="text-xl font-bold text-gray-900">Agency Information</h2>
            </div>
            <div class="p-6">
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label class="text-sm font-semibold text-gray-600">Agency Name</label>
                        <p class="text-gray-900 mt-1">{{ $agency->agency_name }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-gray-600">Trading Name</label>
                        <p class="text-gray-900 mt-1">{{ $agency->trading_name ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-gray-600">ABN</label>
                        <p class="text-gray-900 mt-1">{{ $agency->abn }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-gray-600">ACN</label>
                        <p class="text-gray-900 mt-1">{{ $agency->acn ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-gray-600">Business Type</label>
                        <p class="text-gray-900 mt-1">{{ ucfirst(str_replace('_', ' ', $agency->business_type)) }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-gray-600">License Number</label>
                        <p class="text-gray-900 mt-1">{{ $agency->license_number }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-gray-600">License Holder</label>
                        <p class="text-gray-900 mt-1">{{ $agency->license_holder_name }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-gray-600">License Expiry</label>
                        <p class="text-gray-900 mt-1">{{ $agency->license_expiry_date ? $agency->license_expiry_date->format('M d, Y') : 'N/A' }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Contact Information --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
            <div class="p-6 border-b border-gray-100">
                <h2 class="text-xl font-bold text-gray-900">Contact Information</h2>
            </div>
            <div class="p-6">
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label class="text-sm font-semibold text-gray-600">Business Address</label>
                        <p class="text-gray-900 mt-1">{{ $agency->business_address }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-gray-600">State / Postcode</label>
                        <p class="text-gray-900 mt-1">{{ $agency->state }} {{ $agency->postcode }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-gray-600">Business Phone</label>
                        <p class="text-gray-900 mt-1">{{ $agency->business_phone }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-gray-600">Business Email</label>
                        <p class="text-gray-900 mt-1">
                            <a href="mailto:{{ $agency->business_email }}" class="text-primary hover:underline">
                                {{ $agency->business_email }}
                            </a>
                        </p>
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-gray-600">Website</label>
                        <p class="text-gray-900 mt-1">
                            @if($agency->website_url)
                                <a href="{{ $agency->website_url }}" target="_blank" class="text-primary hover:underline">
                                    {{ $agency->website_url }}
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
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
            <div class="p-6 border-b border-gray-100">
                <h2 class="text-xl font-bold text-gray-900">Primary Contact</h2>
            </div>
            <div class="p-6">
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label class="text-sm font-semibold text-gray-600">Full Name</label>
                        <p class="text-gray-900 mt-1">{{ $agency->primaryContact->full_name }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-gray-600">Position</label>
                        <p class="text-gray-900 mt-1">{{ $agency->primaryContact->position }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-gray-600">Email</label>
                        <p class="text-gray-900 mt-1">{{ $agency->primaryContact->email }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-gray-600">Phone</label>
                        <p class="text-gray-900 mt-1">{{ $agency->primaryContact->phone }}</p>
                    </div>
                </div>
            </div>
        </div>
        @endif

        {{-- Document Review Section - NEW --}}
        @if($documentRequirements->count() > 0)
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
            <div class="p-6 border-b border-gray-100">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-bold text-gray-900">Documents Review</h2>
                    @php
                        $totalRequired = $documentRequirements->where('is_required', true)->count();
                        $uploadedRequired = $documentRequirements->where('is_required', true)->whereNotNull('file_path')->count();
                        $approvedDocs = $documentRequirements->where('status', 'approved')->count();
                    @endphp
                    <span class="text-sm font-medium text-gray-600">
                        {{ $uploadedRequired }}/{{ $totalRequired }} uploaded • {{ $approvedDocs }} approved
                    </span>
                </div>
            </div>
            <div class="divide-y divide-gray-100">
                @foreach($documentRequirements as $doc)
                <div class="p-6 hover:bg-gray-50 transition-colors">
                    <div class="flex items-start gap-4">
                        <!-- Status Icon -->
                        <div class="flex-shrink-0 mt-1">
                            @if($doc->status === 'approved')
                            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            @elseif($doc->status === 'pending_review')
                            <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center animate-pulse">
                                <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            @elseif($doc->status === 'rejected')
                            <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </div>
                            @else
                            <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            @endif
                        </div>

                        <!-- Document Info -->
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-2">
                                <h3 class="font-semibold text-gray-900">{{ $doc->name }}</h3>
                                @if($doc->is_required)
                                <span class="text-xs px-2 py-0.5 bg-red-100 text-red-700 rounded-full font-medium">Required</span>
                                @endif
                                
                                <!-- Status Badge -->
                                @if($doc->status === 'approved')
                                <span class="text-xs px-2 py-0.5 bg-green-100 text-green-700 rounded-full font-medium">✓ Approved</span>
                                @elseif($doc->status === 'pending_review')
                                <span class="text-xs px-2 py-0.5 bg-yellow-100 text-yellow-700 rounded-full font-medium">⏳ Review</span>
                                @elseif($doc->status === 'rejected')
                                <span class="text-xs px-2 py-0.5 bg-red-100 text-red-700 rounded-full font-medium">✗ Rejected</span>
                                @else
                                <span class="text-xs px-2 py-0.5 bg-gray-100 text-gray-600 rounded-full font-medium">○ Not Uploaded</span>
                                @endif
                            </div>

                            <p class="text-sm text-gray-600 mb-3">{{ $doc->description }}</p>

                            @if($doc->file_path)
                            <!-- File Info -->
                            <div class="bg-gray-50 border border-gray-200 rounded-lg p-3 mb-3">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                        </svg>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">{{ $doc->file_name }}</p>
                                            <p class="text-xs text-gray-500">
                                                Uploaded {{ $doc->uploaded_at->diffForHumans() }}
                                                @if($doc->reviewed_at)
                                                • Reviewed {{ $doc->reviewed_at->diffForHumans() }}
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                    <a href="{{ route('admin.agencies.documents.download', [$agency->id, $doc->id]) }}" 
                                       class="text-primary hover:text-primary-dark p-2 rounded-lg hover:bg-blue-50 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                        </svg>
                                    </a>
                                </div>
                            </div>

                            <!-- Rejection Reason -->
                            @if($doc->status === 'rejected' && $doc->rejection_reason)
                            <div class="bg-red-50 border border-red-200 rounded-lg p-3 mb-3">
                                <p class="text-sm font-medium text-red-800 mb-1">Rejection Reason:</p>
                                <p class="text-sm text-red-700">{{ $doc->rejection_reason }}</p>
                            </div>
                            @endif

                            <!-- Action Buttons -->
                            @if($doc->file_path && $doc->status !== 'approved')
                            <div class="flex gap-2">
                                <form action="{{ route('admin.agencies.documents.approve', [$agency->id, $doc->id]) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" 
                                            onclick="return confirm('Approve this document?')"
                                            class="px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition">
                                        ✓ Approve
                                    </button>
                                </form>
                                <button onclick="openRejectDocModal({{ $doc->id }}, '{{ $doc->name }}')" 
                                        class="px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition">
                                    ✗ Reject
                                </button>
                            </div>
                            @endif
                            @else
                            <p class="text-sm text-gray-500 italic">Document not uploaded yet</p>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Activity Log Section - NEW --}}
        @if(isset($activityLogs) && $activityLogs->count() > 0)
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
            <div class="p-6 border-b border-gray-100">
                <h2 class="text-xl font-bold text-gray-900">Activity Log</h2>
                <p class="text-sm text-gray-600 mt-1">Complete history of all actions taken on this agency</p>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @foreach($activityLogs as $log)
                    <div class="flex items-start border-l-4 {{ $log->description === 'Agency approved by admin' ? 'border-green-500' : ($log->description === 'Agency rejected by admin' ? 'border-red-500' : 'border-blue-500') }} pl-4 py-2">
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-900">{{ $log->description }}</p>
                            
                            @if($log->properties && count($log->properties) > 0)
                            <div class="mt-2 space-y-1">
                                @foreach($log->properties as $key => $value)
                                    @if(!is_array($value))
                                    <p class="text-xs text-gray-600">
                                        <span class="font-medium">{{ ucfirst(str_replace('_', ' ', $key)) }}:</span> 
                                        {{ $value }}
                                    </p>
                                    @endif
                                @endforeach
                            </div>
                            @endif
                            
                            <div class="flex items-center gap-4 mt-2 text-xs text-gray-500">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    {{ $log->causer->name ?? 'System' }}
                                </span>
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $log->created_at->format('M d, Y h:i A') }}
                                </span>
                                <span class="text-gray-400">•</span>
                                <span>{{ $log->created_at->diffForHumans() }}</span>
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
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
            <div class="p-6 border-b border-gray-100">
                <h2 class="text-xl font-bold text-gray-900">Agents ({{ $agency->agents->count() }})</h2>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @foreach($agency->agents as $agent)
                    <div class="flex items-center gap-4 p-4 border border-gray-200 rounded-xl">
                        <div class="w-12 h-12 bg-gradient-to-br from-primary to-purple-600 rounded-full flex items-center justify-center text-white font-bold">
                            {{ strtoupper(substr($agent->agent_name, 0, 2)) }}
                        </div>
                        <div class="flex-1">
                            <h3 class="font-semibold text-gray-900">{{ $agent->agent_name }}</h3>
                            <p class="text-sm text-gray-600">{{ $agent->position ?? 'Sales Agent' }}</p>
                        </div>
                        <div>
                            <span class="px-3 py-1 bg-success/10 text-success rounded-full text-xs font-semibold">
                                {{ ucfirst($agent->status) }}
                            </span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
    </div>

    {{-- Sidebar --}}
    <div class="space-y-8">
        {{-- Quick Stats --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-6">Quick Stats</h3>
            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Total Agents</span>
                    <span class="text-2xl font-bold text-gray-900">{{ $agency->agents->count() }}</span>
                </div>
                <div class="h-px bg-gray-200"></div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Member Since</span>
                    <span class="font-semibold text-gray-900">{{ $agency->created_at->format('M Y') }}</span>
                </div>
                <div class="h-px bg-gray-200"></div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Documents</span>
                    <span class="font-semibold text-gray-900">
                        @php
                            $uploaded = $documentRequirements->whereNotNull('file_path')->count();
                            $total = $documentRequirements->count();
                        @endphp
                        {{ $uploaded }}/{{ $total }}
                    </span>
                </div>
                @if($agency->approved_at)
                <div class="h-px bg-gray-200"></div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Approved</span>
                    <span class="font-semibold text-gray-900">{{ $agency->approved_at->format('M d, Y') }}</span>
                </div>
                @endif
            </div>
        </div>

        {{-- Subscription Info --}}
        @if($subscription)
        <div class="bg-gradient-to-br from-primary to-primary-dark rounded-2xl p-6 text-white">
            <h3 class="text-lg font-bold mb-4">Subscription</h3>
            <div class="space-y-3">
                <div>
                    <p class="text-white/80 text-sm">Plan</p>
                    <p class="text-xl font-bold">{{ $subscription->subscriptionPlan->name }}</p>
                </div>
                <div class="h-px bg-white/20"></div>
                <div>
                    <p class="text-white/80 text-sm">Status</p>
                    <p class="font-semibold">{{ ucfirst($subscription->status) }}</p>
                </div>
                <div class="h-px bg-white/20"></div>
                <div>
                    <p class="text-white/80 text-sm">Next Billing</p>
                    <p class="font-semibold">{{ $subscription->current_period_end->format('M d, Y') }}</p>
                </div>
            </div>
        </div>
        @endif

        {{-- Danger Zone --}}
        <div class="bg-red-50 rounded-2xl border border-red-200 p-6">
            <h3 class="text-lg font-bold text-red-900 mb-4">Danger Zone</h3>
            <p class="text-sm text-red-700 mb-4">Deleting an agency is permanent and cannot be undone.</p>
            <form action="{{ route('admin.agencies.destroy', $agency->id) }}" method="POST" onsubmit="return confirm('Are you absolutely sure? This will delete the agency and all related data.')">
                @csrf
                @method('DELETE')
                <button type="submit" class="w-full px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-semibold">
                    Delete Agency
                </button>
            </form>
        </div>
    </div>
</div>

{{-- Reject Agency Modal - IMPROVED --}}
<div id="rejectModal" class="hidden fixed inset-0 bg-gray-900/50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-2xl w-full p-6 animate-fadeIn">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-xl font-bold text-gray-900">Reject Agency Application</h3>
            <button onclick="closeRejectModal()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <form action="{{ route('admin.agencies.reject', $agency->id) }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="rejection_reason" class="block text-sm font-semibold text-gray-700 mb-2">
                    Rejection Reason <span class="text-red-600">*</span>
                </label>
                <textarea id="rejection_reason" 
                          name="rejection_reason" 
                          rows="5" 
                          required
                          minlength="10"
                          class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary"
                          placeholder="Please provide a detailed reason for rejection. This will be sent to the agency via email."></textarea>
                <p class="text-xs text-gray-500 mt-1">Minimum 10 characters. Be specific and professional.</p>
            </div>

            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-4">
                <div class="flex">
                    <svg class="w-5 h-5 text-yellow-600 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
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
                        class="flex-1 px-4 py-3 bg-gray-100 text-gray-700 rounded-xl font-semibold hover:bg-gray-200 transition">
                    Cancel
                </button>
                <button type="submit" class="flex-1 px-4 py-3 bg-red-600 text-white rounded-xl font-semibold hover:bg-red-700 transition">
                    Reject Agency
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Reject Document Modal - NEW --}}
<div id="rejectDocModal" class="hidden fixed inset-0 bg-gray-900/50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-lg w-full p-6 animate-fadeIn">
        <h3 class="text-xl font-bold text-gray-900 mb-4">Reject Document</h3>
        <p class="text-sm text-gray-600 mb-4">Document: <span id="docName" class="font-semibold"></span></p>
        
        <form id="rejectDocForm" method="POST">
            @csrf
            <div class="mb-4">
                <label for="doc_rejection_reason" class="block text-sm font-semibold text-gray-700 mb-2">
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
                        class="flex-1 px-4 py-3 bg-gray-100 text-gray-700 rounded-xl font-semibold hover:bg-gray-200 transition">
                    Cancel
                </button>
                <button type="submit" class="flex-1 px-4 py-3 bg-red-600 text-white rounded-xl font-semibold hover:bg-red-700 transition">
                    Reject Document
                </button>
            </div>
        </form>
    </div>
</div>

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
</script>

<style>
@keyframes fadeIn {
    from { 
        opacity: 0; 
        transform: translateY(20px); 
    }
    to { 
        opacity: 1; 
        transform: translateY(0); 
    }
}

.animate-fadeIn {
    animation: fadeIn 0.3s ease-out;
}
</style>

@endsection