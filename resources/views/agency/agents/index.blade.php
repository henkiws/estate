@extends('layouts.admin')

@section('title', 'My Agents')

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">My Agents</h1>
            <p class="mt-1 text-gray-600">Manage your team of {{ $stats['total'] }} agents</p>
        </div>
        <a href="{{ route('agency.agents.create') }}" 
           class="inline-flex items-center gap-2 px-6 py-3 bg-primary hover:bg-primary-dark text-white font-semibold rounded-xl transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Add New Agent
        </a>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white rounded-2xl p-6 border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Agents</p>
                    <p class="mt-2 text-3xl font-bold text-gray-900">{{ $stats['total'] }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-6 border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Active</p>
                    <p class="mt-2 text-3xl font-bold text-green-600">{{ $stats['active'] }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-6 border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Inactive</p>
                    <p class="mt-2 text-3xl font-bold text-gray-600">{{ $stats['inactive'] }}</p>
                </div>
                <div class="w-12 h-12 bg-gray-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-6 border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">On Leave</p>
                    <p class="mt-2 text-3xl font-bold text-yellow-600">{{ $stats['on_leave'] }}</p>
                </div>
                <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    {{-- Search & Filters --}}
    <div class="bg-white rounded-2xl border border-gray-200 p-6">
        <form method="GET" action="{{ route('agency.agents.index') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                {{-- Search --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                    <div class="relative">
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}"
                               placeholder="Search by name, email, or code..."
                               class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent">
                        <svg class="absolute left-3 top-3 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                </div>

                {{-- Status Filter --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <select name="status" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent">
                        <option value="">All Statuses</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                        <option value="on_leave" {{ request('status') === 'on_leave' ? 'selected' : '' }}>On Leave</option>
                        <option value="terminated" {{ request('status') === 'terminated' ? 'selected' : '' }}>Terminated</option>
                    </select>
                </div>

                {{-- Employment Type Filter --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Employment</label>
                    <select name="employment_type" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent">
                        <option value="">All Types</option>
                        <option value="full_time" {{ request('employment_type') === 'full_time' ? 'selected' : '' }}>Full Time</option>
                        <option value="part_time" {{ request('employment_type') === 'part_time' ? 'selected' : '' }}>Part Time</option>
                        <option value="contractor" {{ request('employment_type') === 'contractor' ? 'selected' : '' }}>Contractor</option>
                        <option value="intern" {{ request('employment_type') === 'intern' ? 'selected' : '' }}>Intern</option>
                    </select>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <button type="submit" class="px-6 py-2.5 bg-primary hover:bg-primary-dark text-white font-medium rounded-xl transition-colors">
                    Apply Filters
                </button>
                <a href="{{ route('agency.agents.index') }}" class="px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-xl transition-colors">
                    Clear
                </a>
            </div>
        </form>
    </div>

    {{-- Agents Grid --}}
    @if($agents->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($agents as $agent)
                <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden hover:shadow-lg transition-shadow">
                    {{-- Card Header with Photo --}}
                    <div class="relative h-32 bg-gradient-to-br from-primary to-purple-600">
                        @if($agent->is_featured)
                            <div class="absolute top-3 right-3">
                                <span class="inline-flex items-center gap-1 px-3 py-1 bg-yellow-400 text-yellow-900 text-xs font-bold rounded-full">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                    Featured
                                </span>
                            </div>
                        @endif
                        
                        <div class="absolute -bottom-12 left-6">
                            <img src="{{ $agent->photo_url }}" 
                                 alt="{{ $agent->full_name }}"
                                 class="w-24 h-24 rounded-2xl border-4 border-white object-cover">
                        </div>
                    </div>

                    {{-- Card Body --}}
                    <div class="pt-16 px-6 pb-6">
                        <div class="flex items-start justify-between mb-3">
                            <div>
                                <h3 class="text-lg font-bold text-gray-900">
                                    <a href="{{ route('agency.agents.show', $agent->id) }}" class="hover:text-primary">
                                        {{ $agent->full_name }}
                                    </a>
                                </h3>
                                <p class="text-sm text-gray-600">{{ $agent->position ?? 'Agent' }}</p>
                                <p class="text-xs text-gray-500 mt-1">{{ $agent->agent_code }}</p>
                            </div>
                            
                            {{-- Status Badge --}}
                            @php
                                $statusColors = [
                                    'active' => 'bg-green-100 text-green-800',
                                    'inactive' => 'bg-gray-100 text-gray-800',
                                    'on_leave' => 'bg-yellow-100 text-yellow-800',
                                    'terminated' => 'bg-red-100 text-red-800',
                                ];
                            @endphp
                            <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $statusColors[$agent->status] ?? 'bg-gray-100 text-gray-800' }}">
                                {{ ucwords(str_replace('_', ' ', $agent->status)) }}
                            </span>
                        </div>

                        {{-- Contact Info --}}
                        <div class="space-y-2 mb-4">
                            <div class="flex items-center gap-2 text-sm text-gray-600">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                <span class="truncate">{{ $agent->email }}</span>
                            </div>
                            
                            @if($agent->mobile)
                                <div class="flex items-center gap-2 text-sm text-gray-600">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                    <span>{{ $agent->mobile }}</span>
                                </div>
                            @endif
                        </div>

                        {{-- Stats --}}
                        @php
                            $agentStats = $agent->getPerformanceStats();
                        @endphp
                        <div class="grid grid-cols-2 gap-4 py-4 border-t border-gray-200">
                            <div>
                                <p class="text-xs text-gray-600">Listings</p>
                                <p class="text-lg font-bold text-gray-900">{{ $agentStats['active_listings'] }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-600">Total Sales</p>
                                <p class="text-lg font-bold text-gray-900">{{ $agentStats['sold_properties'] }}</p>
                            </div>
                        </div>

                        {{-- Actions --}}
                        <div class="flex items-center gap-2 mt-4">
                            <a href="{{ route('agency.agents.show', $agent->id) }}" 
                               class="flex-1 px-4 py-2 bg-primary hover:bg-primary-dark text-white text-sm font-medium rounded-xl text-center transition-colors">
                                View Profile
                            </a>
                            <a href="{{ route('agency.agents.edit', $agent->id) }}" 
                               class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-xl transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-6">
            {{ $agents->links() }}
        </div>
    @else
        {{-- Empty State --}}
        <div class="bg-white rounded-2xl border border-gray-200 p-12 text-center">
            <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">No agents found</h3>
            <p class="text-gray-600 mb-6">
                @if(request()->hasAny(['search', 'status', 'employment_type']))
                    No agents match your search criteria. Try adjusting your filters.
                @else
                    Get started by adding your first team member.
                @endif
            </p>
            @if(!request()->hasAny(['search', 'status', 'employment_type']))
                <a href="{{ route('agency.agents.create') }}" 
                   class="inline-flex items-center gap-2 px-6 py-3 bg-primary hover:bg-primary-dark text-white font-semibold rounded-xl transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Add Your First Agent
                </a>
            @endif
        </div>
    @endif
</div>
@endsection