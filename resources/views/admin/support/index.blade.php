@extends('layouts.admin')

@section('title', 'Support Tickets Management')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Page Header -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Support Tickets</h1>
                <p class="mt-2 text-gray-600">Manage and respond to user and agency support requests</p>
            </div>
            
            <a 
                href="{{ route('admin.support.analytics') }}" 
                class="px-6 py-3 bg-[#5E17EB] text-white font-semibold rounded-lg hover:bg-[#4c12bc] transition flex items-center gap-2"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                Analytics
            </a>
        </div>
        
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Total Tickets</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $counts['all'] }}</p>
                    </div>
                    <div class="p-3 bg-gray-100 rounded-lg">
                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Open</p>
                        <p class="text-2xl font-bold text-blue-600">{{ $counts['open'] }}</p>
                    </div>
                    <div class="p-3 bg-blue-100 rounded-lg">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">In Progress</p>
                        <p class="text-2xl font-bold text-yellow-600">{{ $counts['in_progress'] }}</p>
                    </div>
                    <div class="p-3 bg-yellow-100 rounded-lg">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Resolved</p>
                        <p class="text-2xl font-bold text-green-600">{{ $counts['resolved'] }}</p>
                    </div>
                    <div class="p-3 bg-green-100 rounded-lg">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Unassigned</p>
                        <p class="text-2xl font-bold text-red-600">{{ $counts['unassigned'] }}</p>
                    </div>
                    <div class="p-3 bg-red-100 rounded-lg">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Filters & Search -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
            <form method="GET" action="{{ route('admin.support.tickets.index') }}">
                
                <!-- Row 1: Search and Quick Filters -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                    <!-- Search -->
                    <div class="lg:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                        <input 
                            type="text" 
                            name="search" 
                            value="{{ request('search') }}"
                            placeholder="Ticket #, subject, user name or email..."
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#5E17EB] focus:border-transparent"
                        >
                    </div>
                    
                    <!-- User Type -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">User Type</label>
                        <select 
                            name="user_type" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#5E17EB] focus:border-transparent"
                        >
                            <option value="all" {{ request('user_type') === 'all' || !request('user_type') ? 'selected' : '' }}>
                                All Types ({{ $counts['all'] }})
                            </option>
                            <option value="user" {{ request('user_type') === 'user' ? 'selected' : '' }}>
                                Users ({{ $counts['user'] }})
                            </option>
                            <option value="agency" {{ request('user_type') === 'agency' ? 'selected' : '' }}>
                                Agencies ({{ $counts['agency'] }})
                            </option>
                        </select>
                    </div>
                    
                    <!-- Sort -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Sort By</label>
                        <select 
                            name="sort" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#5E17EB] focus:border-transparent"
                        >
                            <option value="recent" {{ request('sort') === 'recent' || !request('sort') ? 'selected' : '' }}>Newest First</option>
                            <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Oldest First</option>
                            <option value="updated" {{ request('sort') === 'updated' ? 'selected' : '' }}>Recently Updated</option>
                            <option value="priority" {{ request('sort') === 'priority' ? 'selected' : '' }}>Priority</option>
                        </select>
                    </div>
                </div>
                
                <!-- Row 2: Advanced Filters -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- Status -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <select 
                            name="status" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#5E17EB] focus:border-transparent"
                        >
                            <option value="all" {{ request('status') === 'all' || !request('status') ? 'selected' : '' }}>All Status</option>
                            <option value="open" {{ request('status') === 'open' ? 'selected' : '' }}>Open</option>
                            <option value="in_progress" {{ request('status') === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="waiting_response" {{ request('status') === 'waiting_response' ? 'selected' : '' }}>Waiting Response</option>
                            <option value="resolved" {{ request('status') === 'resolved' ? 'selected' : '' }}>Resolved</option>
                            <option value="closed" {{ request('status') === 'closed' ? 'selected' : '' }}>Closed</option>
                        </select>
                    </div>
                    
                    <!-- Priority -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Priority</label>
                        <select 
                            name="priority" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#5E17EB] focus:border-transparent"
                        >
                            <option value="all">All Priorities</option>
                            <option value="critical" {{ request('priority') === 'critical' ? 'selected' : '' }}>Critical</option>
                            <option value="urgent" {{ request('priority') === 'urgent' ? 'selected' : '' }}>Urgent</option>
                            <option value="high" {{ request('priority') === 'high' ? 'selected' : '' }}>High</option>
                            <option value="medium" {{ request('priority') === 'medium' ? 'selected' : '' }}>Medium</option>
                            <option value="low" {{ request('priority') === 'low' ? 'selected' : '' }}>Low</option>
                        </select>
                    </div>
                    
                    <!-- Category -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                        <select 
                            name="category" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#5E17EB] focus:border-transparent"
                        >
                            <option value="all">All Categories</option>
                            <option value="profile" {{ request('category') === 'profile' ? 'selected' : '' }}>Profile</option>
                            <option value="application" {{ request('category') === 'application' ? 'selected' : '' }}>Application</option>
                            <option value="property" {{ request('category') === 'property' ? 'selected' : '' }}>Property</option>
                            <option value="billing" {{ request('category') === 'billing' ? 'selected' : '' }}>Billing</option>
                            <option value="subscription" {{ request('category') === 'subscription' ? 'selected' : '' }}>Subscription</option>
                            <option value="agent_management" {{ request('category') === 'agent_management' ? 'selected' : '' }}>Agent Management</option>
                            <option value="property_listing" {{ request('category') === 'property_listing' ? 'selected' : '' }}>Property Listing</option>
                            <option value="account" {{ request('category') === 'account' ? 'selected' : '' }}>Account</option>
                            <option value="technical" {{ request('category') === 'technical' ? 'selected' : '' }}>Technical</option>
                            <option value="other" {{ request('category') === 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>
                    
                    <!-- Assigned To -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Assigned To</label>
                        <select 
                            name="assigned_to" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#5E17EB] focus:border-transparent"
                        >
                            <option value="all">All Staff</option>
                            <option value="unassigned" {{ request('assigned_to') === 'unassigned' ? 'selected' : '' }}>Unassigned</option>
                            @foreach($staffMembers as $staff)
                                <option value="{{ $staff->id }}" {{ request('assigned_to') == $staff->id ? 'selected' : '' }}>
                                    {{ $staff->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <!-- Action Buttons -->
                <div class="flex items-center gap-3 mt-6">
                    <button 
                        type="submit" 
                        class="px-6 py-2 bg-[#5E17EB] text-white font-semibold rounded-lg hover:bg-[#4c12bc] transition"
                    >
                        Apply Filters
                    </button>
                    
                    @if(request()->hasAny(['search', 'user_type', 'status', 'priority', 'category', 'assigned_to', 'sort']))
                        <a 
                            href="{{ route('admin.support.tickets.index') }}" 
                            class="px-6 py-2 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 transition"
                        >
                            Clear All
                        </a>
                    @endif
                </div>
            </form>
        </div>
        
        <!-- Tickets Table -->
        @if($tickets->count() > 0)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-8">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ticket</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subject</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Priority</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Assigned</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($tickets as $ticket)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex flex-col">
                                            <span class="text-sm font-mono text-gray-900">{{ $ticket->ticket_number }}</span>
                                            <span class="text-xs text-gray-500">
                                                <span class="px-2 py-0.5 bg-{{ $ticket->user_type === 'agency' ? 'blue' : 'teal' }}-100 text-{{ $ticket->user_type === 'agency' ? 'blue' : 'teal' }}-700 rounded">
                                                    {{ ucfirst($ticket->user_type) }}
                                                </span>
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex flex-col">
                                            <span class="text-sm font-medium text-gray-900">{{ $ticket->user->name }}</span>
                                            <span class="text-xs text-gray-500">{{ $ticket->user->email }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-col max-w-xs">
                                            <span class="text-sm font-medium text-gray-900 truncate">{{ $ticket->subject }}</span>
                                            <span class="text-xs text-gray-500">{{ ucfirst(str_replace('_', ' ', $ticket->category)) }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $ticket->status_color }}">
                                            {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $ticket->priority_color }}">
                                            {{ ucfirst($ticket->priority) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($ticket->assignedTo)
                                            <span class="text-sm text-gray-900">{{ $ticket->assignedTo->name }}</span>
                                        @else
                                            <span class="text-sm text-gray-400 italic">Unassigned</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex flex-col">
                                            <span class="text-sm text-gray-900">{{ $ticket->created_at->format('M d, Y') }}</span>
                                            <span class="text-xs text-gray-500">{{ $ticket->created_at->diffForHumans() }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <a 
                                            href="{{ route('admin.support.tickets.show', $ticket) }}"
                                            class="inline-flex items-center px-3 py-1.5 bg-[#DDEECD] text-gray-800 text-sm font-semibold rounded-lg hover:bg-[#E6FF4B] transition"
                                        >
                                            View
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Pagination -->
            <div class="mt-6">
                {{ $tickets->appends(request()->except('page'))->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center">
                <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No Tickets Found</h3>
                <p class="text-gray-600">No support tickets match your current filters.</p>
            </div>
        @endif
        
    </div>
</div>
@endsection