@extends('layouts.user')

@section('title', 'My Applications')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Page Header -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">My Applications</h1>
                <p class="mt-2 text-gray-600">Track and manage your rental applications</p>
            </div>
            
            <!-- View Toggle -->
            <div class="flex items-center gap-2 bg-gray-100 rounded-lg p-1">
                <a 
                    href="{{ route('user.applications.index', array_merge(request()->except('view'), ['view' => 'grid'])) }}"
                    class="px-4 py-2 rounded-md text-sm font-medium transition {{ $viewMode === 'grid' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-600 hover:text-gray-900' }}"
                >
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                    </svg>
                </a>
                <a 
                    href="{{ route('user.applications.index', array_merge(request()->except('view'), ['view' => 'list'])) }}"
                    class="px-4 py-2 rounded-md text-sm font-medium transition {{ $viewMode === 'list' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-600 hover:text-gray-900' }}"
                >
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"/>
                    </svg>
                </a>
            </div>
        </div>
        
        <!-- Filters & Search -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 mb-6">
            <form method="GET" action="{{ route('user.applications.index') }}" class="flex flex-wrap gap-4">
                <input type="hidden" name="view" value="{{ $viewMode }}">
                
                <!-- Search -->
                <div class="flex-1 min-w-[200px]">
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ request('search') }}"
                        placeholder="Search by property address..."
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent"
                    >
                </div>
                
                <!-- Status Filter -->
                <div class="min-w-[180px]">
                    <select 
                        name="status" 
                        onchange="this.form.submit()"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent"
                    >
                        <option value="all" {{ request('status') === 'all' || !request('status') ? 'selected' : '' }}>
                            All Status ({{ $counts['all'] }})
                        </option>
                        <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>
                            Draft ({{ $counts['draft'] }})
                        </option>
                        <option value="submitted" {{ request('status') === 'submitted' ? 'selected' : '' }}>
                            Submitted ({{ $counts['submitted'] }})
                        </option>
                        <option value="under_review" {{ request('status') === 'under_review' ? 'selected' : '' }}>
                            Under Review ({{ $counts['under_review'] }})
                        </option>
                        <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>
                            Approved ({{ $counts['approved'] }})
                        </option>
                        <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>
                            Rejected ({{ $counts['rejected'] }})
                        </option>
                        <option value="withdrawn" {{ request('status') === 'withdrawn' ? 'selected' : '' }}>
                            Withdrawn ({{ $counts['withdrawn'] }})
                        </option>
                    </select>
                </div>
                
                <!-- Sort -->
                <div class="min-w-[150px]">
                    <select 
                        name="sort" 
                        onchange="this.form.submit()"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent"
                    >
                        <option value="recent" {{ request('sort') === 'recent' || !request('sort') ? 'selected' : '' }}>Newest First</option>
                        <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Oldest First</option>
                        <option value="status" {{ request('sort') === 'status' ? 'selected' : '' }}>By Status</option>
                    </select>
                </div>
                
                <!-- Search Button -->
                <button 
                    type="submit" 
                    class="px-6 py-2 bg-teal-600 text-white font-semibold rounded-lg hover:bg-teal-700 transition"
                >
                    Search
                </button>
                
                <!-- Clear Filters -->
                @if(request()->hasAny(['search', 'status', 'sort']))
                    <a 
                        href="{{ route('user.applications.index', ['view' => $viewMode]) }}" 
                        class="px-6 py-2 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 transition"
                    >
                        Clear
                    </a>
                @endif
            </form>
        </div>
        
        <!-- Applications Grid/List -->
        @if($applications->count() > 0)
            @if($viewMode === 'grid')
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                    @foreach($applications as $application)
                        <x-application-card :application="$application" view-mode="grid" />
                    @endforeach
                </div>
            @else
                <div class="space-y-4 mb-8">
                    @foreach($applications as $application)
                        <x-application-card :application="$application" view-mode="list" />
                    @endforeach
                </div>
            @endif
            
            <!-- Pagination -->
            <div class="mt-6">
                {{ $applications->appends(request()->except('page'))->links() }}
            </div>
        @else
            <!-- Empty State -->
            <x-empty-state 
                icon="clipboard"
                title="No Applications Yet"
                message="You haven't submitted any rental applications. Start browsing properties to find your next home!"
                actionText="Browse Properties"
                actionUrl="{{ route('properties.index') }}"
            />
        @endif
        
    </div>
</div>
@endsection