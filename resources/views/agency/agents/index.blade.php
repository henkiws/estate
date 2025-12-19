@extends('layouts.admin')

@section('title', 'My Agents')

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">My Agents</h1>
            <p class="mt-1 text-gray-600">Manage your team of {{ $stats['total'] }} {{ Str::plural('agent', $stats['total']) }}</p>
        </div>
        <a href="{{ route('agency.agents.create') }}" 
           class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-0.5">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            <span>Add New Agent</span>
        </a>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6">
        <div class="bg-white rounded-2xl p-4 lg:p-6 border border-gray-200 hover:shadow-lg transition-shadow">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-3">
                <div class="flex-1">
                    <p class="text-xs lg:text-sm font-medium text-gray-600">Total Agents</p>
                    <p class="mt-1 lg:mt-2 text-2xl lg:text-3xl font-bold text-gray-900">{{ $stats['total'] }}</p>
                </div>
                <div class="w-10 h-10 lg:w-12 lg:h-12 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 lg:w-6 lg:h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-4 lg:p-6 border border-gray-200 hover:shadow-lg transition-shadow">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-3">
                <div class="flex-1">
                    <p class="text-xs lg:text-sm font-medium text-gray-600">Active</p>
                    <p class="mt-1 lg:mt-2 text-2xl lg:text-3xl font-bold text-green-600">{{ $stats['active'] }}</p>
                </div>
                <div class="w-10 h-10 lg:w-12 lg:h-12 bg-green-100 rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 lg:w-6 lg:h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-4 lg:p-6 border border-gray-200 hover:shadow-lg transition-shadow">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-3">
                <div class="flex-1">
                    <p class="text-xs lg:text-sm font-medium text-gray-600">Inactive</p>
                    <p class="mt-1 lg:mt-2 text-2xl lg:text-3xl font-bold text-gray-600">{{ $stats['inactive'] }}</p>
                </div>
                <div class="w-10 h-10 lg:w-12 lg:h-12 bg-gray-100 rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 lg:w-6 lg:h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-4 lg:p-6 border border-gray-200 hover:shadow-lg transition-shadow">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-3">
                <div class="flex-1">
                    <p class="text-xs lg:text-sm font-medium text-gray-600">On Leave</p>
                    <p class="mt-1 lg:mt-2 text-2xl lg:text-3xl font-bold text-yellow-600">{{ $stats['on_leave'] }}</p>
                </div>
                <div class="w-10 h-10 lg:w-12 lg:h-12 bg-yellow-100 rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 lg:w-6 lg:h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    {{-- Search & Filters --}}
    <div class="bg-white rounded-2xl border border-gray-200 p-4 lg:p-6">
        <form method="GET" action="{{ route('agency.agents.index') }}" class="space-y-4" id="filter-form">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                {{-- Search --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Search</label>
                    <div class="relative">
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}"
                               placeholder="Search by name, email, or code..."
                               class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <svg class="absolute left-3 top-3 w-5 h-5 text-gray-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                </div>

                {{-- Status Filter --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
                    <select name="status" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent appearance-none bg-white">
                        <option value="">All Statuses</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                        <option value="on_leave" {{ request('status') === 'on_leave' ? 'selected' : '' }}>On Leave</option>
                        <option value="terminated" {{ request('status') === 'terminated' ? 'selected' : '' }}>Terminated</option>
                    </select>
                </div>

                {{-- Employment Type Filter --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Employment</label>
                    <select name="employment_type" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent appearance-none bg-white">
                        <option value="">All Types</option>
                        <option value="full_time" {{ request('employment_type') === 'full_time' ? 'selected' : '' }}>Full Time</option>
                        <option value="part_time" {{ request('employment_type') === 'part_time' ? 'selected' : '' }}>Part Time</option>
                        <option value="contractor" {{ request('employment_type') === 'contractor' ? 'selected' : '' }}>Contractor</option>
                        <option value="intern" {{ request('employment_type') === 'intern' ? 'selected' : '' }}>Intern</option>
                    </select>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold rounded-xl transition-all shadow-md hover:shadow-lg flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                    </svg>
                    Apply Filters
                </button>
                <a href="{{ route('agency.agents.index') }}" class="px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-xl transition-colors flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Clear
                </a>
                <div class="flex-1"></div>
                
                {{-- View Toggle --}}
                <div class="flex items-center gap-2 bg-gray-100 p-1 rounded-xl">
                    <button type="button" onclick="setView('grid')" id="grid-view-btn" class="px-4 py-2 rounded-lg transition-all flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                        </svg>
                        <span class="hidden sm:inline text-sm font-medium">Grid</span>
                    </button>
                    <button type="button" onclick="setView('list')" id="list-view-btn" class="px-4 py-2 rounded-lg transition-all flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                        <span class="hidden sm:inline text-sm font-medium">List</span>
                    </button>
                </div>
            </div>
        </form>
    </div>

    {{-- Results Count --}}
    @if($agents->count() > 0)
        <div class="flex items-center justify-between text-sm text-gray-600">
            <p>Showing <span class="font-semibold text-gray-900">{{ $agents->firstItem() }}</span> to <span class="font-semibold text-gray-900">{{ $agents->lastItem() }}</span> of <span class="font-semibold text-gray-900">{{ $agents->total() }}</span> results</p>
        </div>
    @endif

    {{-- Agents Grid View --}}
    <div id="grid-view" class="hidden">
        @if($agents->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 lg:gap-6">
                @foreach($agents as $agent)
                    <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                        {{-- Card Header with Photo --}}
                        <div class="relative h-24 sm:h-32 bg-gradient-to-br from-blue-500 via-blue-600 to-indigo-600">
                            @if($agent->is_featured)
                                <div class="absolute top-2 sm:top-3 right-2 sm:right-3">
                                    <span class="inline-flex items-center gap-1 px-2 sm:px-3 py-1 bg-yellow-400 text-yellow-900 text-xs font-bold rounded-full shadow-lg">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                        Featured
                                    </span>
                                </div>
                            @endif
                            
                            <div class="absolute -bottom-10 sm:-bottom-12 left-4 sm:left-6">
                                <img src="{{ $agent->photo_url }}" 
                                     alt="{{ $agent->full_name }}"
                                     class="w-20 h-20 sm:w-24 sm:h-24 rounded-2xl border-4 border-white object-cover shadow-lg">
                            </div>
                        </div>

                        {{-- Card Body --}}
                        <div class="pt-12 sm:pt-16 px-4 sm:px-6 pb-4 sm:pb-6">
                            <div class="flex items-start justify-between mb-3">
                                <div class="flex-1 min-w-0">
                                    <h3 class="text-base sm:text-lg font-bold text-gray-900 truncate">
                                        <a href="{{ route('agency.agents.show', $agent->id) }}" class="hover:text-blue-600 transition-colors">
                                            {{ $agent->full_name }}
                                        </a>
                                    </h3>
                                    <p class="text-xs sm:text-sm text-gray-600 truncate">{{ $agent->position ?? 'Agent' }}</p>
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
                                <span class="ml-2 px-2 sm:px-3 py-1 text-xs font-semibold rounded-full flex-shrink-0 {{ $statusColors[$agent->status] ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ ucwords(str_replace('_', ' ', $agent->status)) }}
                                </span>
                            </div>

                            {{-- Contact Info --}}
                            <div class="space-y-2 mb-4">
                                <div class="flex items-center gap-2 text-xs sm:text-sm text-gray-600">
                                    <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                    <span class="truncate">{{ $agent->email }}</span>
                                </div>
                                
                                @if($agent->mobile)
                                    <div class="flex items-center gap-2 text-xs sm:text-sm text-gray-600">
                                        <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                                    <p class="text-base sm:text-lg font-bold text-gray-900">{{ $agentStats['active_listings'] }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-600">Total Sales</p>
                                    <p class="text-base sm:text-lg font-bold text-gray-900">{{ $agentStats['sold_properties'] }}</p>
                                </div>
                            </div>

                            {{-- Actions --}}
                            <div class="flex items-center gap-2 mt-4">
                                <a href="{{ route('agency.agents.show', $agent->id) }}" 
                                   class="flex-1 px-3 sm:px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white text-xs sm:text-sm font-semibold rounded-xl text-center transition-all shadow-md hover:shadow-lg">
                                    View Profile
                                </a>
                                <a href="{{ route('agency.agents.edit', $agent->id) }}" 
                                   class="px-3 sm:px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs sm:text-sm font-medium rounded-xl transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- Agents List View --}}
    <div id="list-view" class="hidden">
        @if($agents->count() > 0)
            <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-4 lg:px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Agent</th>
                                <th class="hidden md:table-cell px-4 lg:px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Contact</th>
                                <th class="hidden lg:table-cell px-4 lg:px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Employment</th>
                                <th class="px-4 lg:px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Status</th>
                                <th class="hidden sm:table-cell px-4 lg:px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Stats</th>
                                <th class="px-4 lg:px-6 py-3 text-right text-xs font-semibold text-gray-700 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($agents as $agent)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    {{-- Agent Info --}}
                                    <td class="px-4 lg:px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-3">
                                            <img src="{{ $agent->photo_url }}" 
                                                 alt="{{ $agent->full_name }}"
                                                 class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl object-cover flex-shrink-0">
                                            <div class="min-w-0">
                                                <div class="flex items-center gap-2">
                                                    <a href="{{ route('agency.agents.show', $agent->id) }}" class="text-sm font-semibold text-gray-900 hover:text-blue-600 transition-colors truncate">
                                                        {{ $agent->full_name }}
                                                    </a>
                                                    @if($agent->is_featured)
                                                        <svg class="w-4 h-4 text-yellow-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                        </svg>
                                                    @endif
                                                </div>
                                                <p class="text-xs text-gray-600 truncate">{{ $agent->position ?? 'Agent' }}</p>
                                                <p class="text-xs text-gray-500">{{ $agent->agent_code }}</p>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- Contact --}}
                                    <td class="hidden md:table-cell px-4 lg:px-6 py-4">
                                        <div class="text-sm text-gray-900 truncate max-w-xs">{{ $agent->email }}</div>
                                        @if($agent->mobile)
                                            <div class="text-xs text-gray-600">{{ $agent->mobile }}</div>
                                        @endif
                                    </td>

                                    {{-- Employment --}}
                                    <td class="hidden lg:table-cell px-4 lg:px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm text-gray-900">{{ ucwords(str_replace('_', ' ', $agent->employment_type ?? 'N/A')) }}</span>
                                    </td>

                                    {{-- Status --}}
                                    <td class="px-4 lg:px-6 py-4 whitespace-nowrap">
                                        @php
                                            $statusColors = [
                                                'active' => 'bg-green-100 text-green-800',
                                                'inactive' => 'bg-gray-100 text-gray-800',
                                                'on_leave' => 'bg-yellow-100 text-yellow-800',
                                                'terminated' => 'bg-red-100 text-red-800',
                                            ];
                                        @endphp
                                        <span class="px-2 sm:px-3 py-1 text-xs font-semibold rounded-full {{ $statusColors[$agent->status] ?? 'bg-gray-100 text-gray-800' }}">
                                            {{ ucwords(str_replace('_', ' ', $agent->status)) }}
                                        </span>
                                    </td>

                                    {{-- Stats --}}
                                    <td class="hidden sm:table-cell px-4 lg:px-6 py-4 whitespace-nowrap">
                                        @php
                                            $agentStats = $agent->getPerformanceStats();
                                        @endphp
                                        <div class="flex items-center gap-4">
                                            <div>
                                                <p class="text-xs text-gray-600">Listings</p>
                                                <p class="text-sm font-semibold text-gray-900">{{ $agentStats['active_listings'] }}</p>
                                            </div>
                                            <div>
                                                <p class="text-xs text-gray-600">Sales</p>
                                                <p class="text-sm font-semibold text-gray-900">{{ $agentStats['sold_properties'] }}</p>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- Actions --}}
                                    <td class="px-4 lg:px-6 py-4 whitespace-nowrap text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('agency.agents.show', $agent->id) }}" 
                                               class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                                               title="View Profile">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                            </a>
                                            <a href="{{ route('agency.agents.edit', $agent->id) }}" 
                                               class="p-2 text-gray-600 hover:bg-gray-100 rounded-lg transition-colors"
                                               title="Edit">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>

    {{-- Empty State --}}
    @if($agents->count() === 0)
        <div class="bg-white rounded-2xl border border-gray-200 p-8 sm:p-12 text-center">
            <div class="w-16 h-16 sm:w-20 sm:h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 sm:w-10 sm:h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
            </div>
            <h3 class="text-lg sm:text-xl font-bold text-gray-900 mb-2">No agents found</h3>
            <p class="text-sm sm:text-base text-gray-600 mb-6">
                @if(request()->hasAny(['search', 'status', 'employment_type']))
                    No agents match your search criteria. Try adjusting your filters.
                @else
                    Get started by adding your first team member.
                @endif
            </p>
            @if(!request()->hasAny(['search', 'status', 'employment_type']))
                <a href="{{ route('agency.agents.create') }}" 
                   class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold rounded-xl transition-all shadow-lg hover:shadow-xl">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Add Your First Agent
                </a>
            @endif
        </div>
    @endif

    {{-- Pagination --}}
    @if($agents->hasPages())
        <div class="mt-6">
            <div class="bg-white rounded-2xl border border-gray-200 px-4 py-3 sm:px-6">
                {{ $agents->appends(request()->query())->links() }}
            </div>
        </div>
    @endif
</div>

<script>
// View toggle functionality
function setView(view) {
    const gridView = document.getElementById('grid-view');
    const listView = document.getElementById('list-view');
    const gridBtn = document.getElementById('grid-view-btn');
    const listBtn = document.getElementById('list-view-btn');
    
    if (view === 'grid') {
        gridView.classList.remove('hidden');
        listView.classList.add('hidden');
        gridBtn.classList.add('bg-white', 'text-gray-900', 'shadow-sm');
        gridBtn.classList.remove('text-gray-600');
        listBtn.classList.remove('bg-white', 'text-gray-900', 'shadow-sm');
        listBtn.classList.add('text-gray-600');
        localStorage.setItem('agentsView', 'grid');
    } else {
        listView.classList.remove('hidden');
        gridView.classList.add('hidden');
        listBtn.classList.add('bg-white', 'text-gray-900', 'shadow-sm');
        listBtn.classList.remove('text-gray-600');
        gridBtn.classList.remove('bg-white', 'text-gray-900', 'shadow-sm');
        gridBtn.classList.add('text-gray-600');
        localStorage.setItem('agentsView', 'list');
    }
}

// Load saved view preference on page load
document.addEventListener('DOMContentLoaded', function() {
    const savedView = localStorage.getItem('agentsView') || 'grid';
    setView(savedView);
});
</script>

<style>
/* Smooth transitions for view toggle */
#grid-view, #list-view {
    animation: fadeIn 0.3s ease-in;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Custom scrollbar for table */
.overflow-x-auto::-webkit-scrollbar {
    height: 8px;
}

.overflow-x-auto::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

.overflow-x-auto::-webkit-scrollbar-thumb {
    background: #cbd5e0;
    border-radius: 10px;
}

.overflow-x-auto::-webkit-scrollbar-thumb:hover {
    background: #a0aec0;
}
</style>
@endsection