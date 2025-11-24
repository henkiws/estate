@extends('layouts.admin')

@section('title', $agency->agency_name . ' - Agency Details')

@section('content')

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
                <button type="submit" class="px-6 py-3 bg-green-600 text-white rounded-xl font-semibold hover:bg-green-700 transition flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Approve Agency
                </button>
            </form>
            <button onclick="document.getElementById('rejectModal').classList.remove('hidden')" class="px-6 py-3 bg-red-600 text-white rounded-xl font-semibold hover:bg-red-700 transition">
                Reject
            </button>
            @elseif($agency->status === 'active')
            <form action="{{ route('admin.agencies.suspend', $agency->id) }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="px-6 py-3 bg-orange-600 text-white rounded-xl font-semibold hover:bg-orange-700 transition">
                    Suspend
                </button>
            </form>
            @elseif($agency->status === 'suspended')
            <form action="{{ route('admin.agencies.reactivate', $agency->id) }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="px-6 py-3 bg-green-600 text-white rounded-xl font-semibold hover:bg-green-700 transition">
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
        {{ $agency->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
        {{ $agency->status === 'suspended' ? 'bg-red-100 text-red-800' : '' }}
        {{ $agency->status === 'inactive' ? 'bg-gray-100 text-gray-800' : '' }}">
        <span class="w-2 h-2 rounded-full
            {{ $agency->status === 'active' ? 'bg-green-600' : '' }}
            {{ $agency->status === 'pending' ? 'bg-yellow-600' : '' }}
            {{ $agency->status === 'suspended' ? 'bg-red-600' : '' }}
            {{ $agency->status === 'inactive' ? 'bg-gray-600' : '' }}">
        </span>
        {{ ucfirst($agency->status) }}
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
                    <span class="text-gray-600">Verified</span>
                    <span class="font-semibold text-gray-900">
                        @if($agency->verified_at)
                            ✓ Yes
                        @else
                            ✗ No
                        @endif
                    </span>
                </div>
            </div>
        </div>

        {{-- Activity Log --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-6">Activity</h3>
            <div class="space-y-4">
                <div class="flex items-start gap-3">
                    <div class="w-2 h-2 bg-primary rounded-full mt-2"></div>
                    <div>
                        <p class="text-sm font-medium text-gray-900">Agency Registered</p>
                        <p class="text-xs text-gray-500">{{ $agency->created_at->format('M d, Y h:i A') }}</p>
                    </div>
                </div>
                @if($agency->verified_at)
                <div class="flex items-start gap-3">
                    <div class="w-2 h-2 bg-green-600 rounded-full mt-2"></div>
                    <div>
                        <p class="text-sm font-medium text-gray-900">Agency Verified</p>
                        <p class="text-xs text-gray-500">{{ $agency->verified_at->format('M d, Y h:i A') }}</p>
                    </div>
                </div>
                @endif
            </div>
        </div>

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

{{-- Reject Modal --}}
<div id="rejectModal" class="hidden fixed inset-0 bg-gray-900/50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full p-6">
        <h3 class="text-xl font-bold text-gray-900 mb-4">Reject Agency</h3>
        <form action="{{ route('admin.agencies.reject', $agency->id) }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="reason" class="block text-sm font-semibold text-gray-700 mb-2">Rejection Reason</label>
                <textarea id="reason" 
                          name="reason" 
                          rows="4" 
                          required
                          class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary"
                          placeholder="Provide a reason for rejection..."></textarea>
            </div>
            <div class="flex gap-3">
                <button type="button" 
                        onclick="document.getElementById('rejectModal').classList.add('hidden')"
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

@endsection