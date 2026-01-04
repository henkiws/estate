@extends('layouts.user')

@section('title', 'Help & Support')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Page Header -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Help & Support</h1>
                <p class="mt-2 text-gray-600">Get help with your rental applications and account</p>
            </div>
            
            <a 
                href="{{ route('user.support.create') }}" 
                class="px-6 py-3 bg-teal-600 text-white font-semibold rounded-lg hover:bg-teal-700 transition flex items-center gap-2"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                New Ticket
            </a>
        </div>
        
        <!-- Quick Links -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <a href="#faqs" class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition group">
                <div class="flex items-start gap-4">
                    <div class="p-3 bg-blue-100 rounded-lg group-hover:bg-blue-200 transition">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-900 mb-1">FAQs</h3>
                        <p class="text-sm text-gray-600">Find answers to common questions</p>
                    </div>
                </div>
            </a>
            
            <a href="{{ route('user.applications.browse') }}" class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition group">
                <div class="flex items-start gap-4">
                    <div class="p-3 bg-green-100 rounded-lg group-hover:bg-green-200 transition">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-900 mb-1">Getting Started</h3>
                        <p class="text-sm text-gray-600">Learn how to apply for properties</p>
                    </div>
                </div>
            </a>
            
            <a href="mailto:support@plyform.com" class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition group">
                <div class="flex items-start gap-4">
                    <div class="p-3 bg-purple-100 rounded-lg group-hover:bg-purple-200 transition">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-900 mb-1">Email Support</h3>
                        <p class="text-sm text-gray-600">support@plyform.com</p>
                    </div>
                </div>
            </a>
        </div>
        
        <!-- Filters & Search -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 mb-6">
            <form method="GET" action="{{ route('user.support.index') }}" class="flex flex-wrap gap-4">
                
                <!-- Search -->
                <div class="flex-1 min-w-[200px]">
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ request('search') }}"
                        placeholder="Search tickets..."
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent"
                    >
                </div>
                
                <!-- Status Filter -->
                <div class="min-w-[180px]">
                    <select 
                        name="status" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent"
                    >
                        <option value="all" {{ request('status') === 'all' || !request('status') ? 'selected' : '' }}>
                            All Status ({{ $counts['all'] }})
                        </option>
                        <option value="open" {{ request('status') === 'open' ? 'selected' : '' }}>
                            Open ({{ $counts['open'] }})
                        </option>
                        <option value="in_progress" {{ request('status') === 'in_progress' ? 'selected' : '' }}>
                            In Progress ({{ $counts['in_progress'] }})
                        </option>
                        <option value="waiting_response" {{ request('status') === 'waiting_response' ? 'selected' : '' }}>
                            Waiting Response ({{ $counts['waiting_response'] }})
                        </option>
                        <option value="resolved" {{ request('status') === 'resolved' ? 'selected' : '' }}>
                            Resolved ({{ $counts['resolved'] }})
                        </option>
                        <option value="closed" {{ request('status') === 'closed' ? 'selected' : '' }}>
                            Closed ({{ $counts['closed'] }})
                        </option>
                    </select>
                </div>
                
                <!-- Category Filter -->
                <div class="min-w-[150px]">
                    <select 
                        name="category" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent"
                    >
                        <option value="all">All Categories</option>
                        <option value="profile" {{ request('category') === 'profile' ? 'selected' : '' }}>Profile</option>
                        <option value="application" {{ request('category') === 'application' ? 'selected' : '' }}>Application</option>
                        <option value="property" {{ request('category') === 'property' ? 'selected' : '' }}>Property</option>
                        <option value="payment" {{ request('category') === 'payment' ? 'selected' : '' }}>Payment</option>
                        <option value="account" {{ request('category') === 'account' ? 'selected' : '' }}>Account</option>
                        <option value="technical" {{ request('category') === 'technical' ? 'selected' : '' }}>Technical</option>
                        <option value="other" {{ request('category') === 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>
                
                <!-- Sort -->
                <div class="min-w-[150px]">
                    <select 
                        name="sort" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent"
                    >
                        <option value="recent" {{ request('sort') === 'recent' || !request('sort') ? 'selected' : '' }}>Newest First</option>
                        <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Oldest First</option>
                        <option value="updated" {{ request('sort') === 'updated' ? 'selected' : '' }}>Recently Updated</option>
                    </select>
                </div>
                
                <!-- Apply Button -->
                <button 
                    type="submit" 
                    class="px-6 py-2 bg-teal-600 text-white font-semibold rounded-lg hover:bg-teal-700 transition"
                >
                    Filter
                </button>
                
                <!-- Clear Filters -->
                @if(request()->hasAny(['search', 'status', 'category', 'sort']))
                    <a 
                        href="{{ route('user.support.index') }}" 
                        class="px-6 py-2 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 transition"
                    >
                        Clear
                    </a>
                @endif
            </form>
        </div>
        
        <!-- Tickets List -->
        @if($tickets->count() > 0)
            <div class="space-y-4 mb-8">
                @foreach($tickets as $ticket)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition">
                        <div class="p-6">
                            <div class="flex items-start justify-between gap-4">
                                <div class="flex-1">
                                    <!-- Ticket Header -->
                                    <div class="flex items-center gap-3 mb-2">
                                        <span class="text-sm font-mono text-gray-500">{{ $ticket->ticket_number }}</span>
                                        <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $ticket->status_color }}">
                                            {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                                        </span>
                                        <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $ticket->priority_color }}">
                                            {{ ucfirst($ticket->priority) }} Priority
                                        </span>
                                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-700">
                                            {{ ucfirst($ticket->category) }}
                                        </span>
                                    </div>
                                    
                                    <!-- Subject -->
                                    <h3 class="text-lg font-bold text-gray-900 mb-2">{{ $ticket->subject }}</h3>
                                    
                                    <!-- Message Preview -->
                                    <p class="text-gray-600 text-sm mb-3 line-clamp-2">{{ $ticket->message }}</p>
                                    
                                    <!-- Meta Info -->
                                    <div class="flex items-center gap-4 text-xs text-gray-500">
                                        <span class="flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            Created {{ $ticket->created_at->diffForHumans() }}
                                        </span>
                                        @if($ticket->replies->count() > 0)
                                            <span class="flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                                </svg>
                                                {{ $ticket->replies->count() }} {{ Str::plural('reply', $ticket->replies->count()) }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                
                                <!-- Actions -->
                                <div class="flex gap-2">
                                    <a 
                                        href="{{ route('user.support.show', $ticket) }}"
                                        class="px-4 py-2 bg-teal-600 text-white font-semibold rounded-lg hover:bg-teal-700 transition"
                                    >
                                        View
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="mt-6">
                {{ $tickets->appends(request()->except('page'))->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center">
                <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No Support Tickets</h3>
                <p class="text-gray-600 mb-6">You haven't created any support tickets yet.</p>
                <a 
                    href="{{ route('user.support.create') }}" 
                    class="inline-flex items-center px-6 py-3 bg-teal-600 text-white font-semibold rounded-lg hover:bg-teal-700 transition"
                >
                    Create Your First Ticket
                </a>
            </div>
        @endif
        
    </div>
</div>
@endsection