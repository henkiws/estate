@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">User Profile Reviews</h1>
                    <p class="mt-2 text-gray-600">Review and manage user profile submissions</p>
                </div>
            </div>
        </div>

        <!-- Filter Tabs -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-2 mb-6 inline-flex gap-2">
            <a href="{{ route('admin.profiles.index', ['status' => 'pending']) }}" 
               class="px-4 py-2 rounded-lg font-semibold transition {{ $status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'text-gray-600 hover:bg-gray-100' }}">
                Pending ({{ $counts['pending'] ?? 0 }})
            </a>
            <a href="{{ route('admin.profiles.index', ['status' => 'approved']) }}" 
               class="px-4 py-2 rounded-lg font-semibold transition {{ $status === 'approved' ? 'bg-green-100 text-green-800' : 'text-gray-600 hover:bg-gray-100' }}">
                Approved ({{ $counts['approved'] ?? 0 }})
            </a>
            <a href="{{ route('admin.profiles.index', ['status' => 'rejected']) }}" 
               class="px-4 py-2 rounded-lg font-semibold transition {{ $status === 'rejected' ? 'bg-red-100 text-red-800' : 'text-gray-600 hover:bg-gray-100' }}">
                Rejected ({{ $counts['rejected'] ?? 0 }})
            </a>
            <a href="{{ route('admin.profiles.index', ['status' => 'all']) }}" 
               class="px-4 py-2 rounded-lg font-semibold transition {{ $status === 'all' ? 'bg-blue-100 text-blue-800' : 'text-gray-600 hover:bg-gray-100' }}">
                All ({{ ($counts['pending'] ?? 0) + ($counts['approved'] ?? 0) + ($counts['rejected'] ?? 0) }})
            </a>
        </div>

        <!-- Profiles List -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            @if($profiles->count() > 0)
                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    User
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Contact
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    ID Points
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Submitted
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($profiles as $profile)
                                @php
                                    $totalPoints = $profile->user->identifications->sum('points') ?? 0;
                                    $daysOld = $profile->submitted_at ? $profile->submitted_at->diffInDays(now()) : 0;
                                @endphp
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <div class="h-10 w-10 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold">
                                                    {{ substr($profile->user->name, 0, 1) }}
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $profile->user->name }}
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    ID: {{ $profile->id }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $profile->email }}</div>
                                        <div class="text-sm text-gray-500">{{ $profile->mobile_country_code }} {{ $profile->mobile_number }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <span class="text-2xl font-bold {{ $totalPoints >= 80 ? 'text-green-600' : 'text-red-600' }}">
                                                {{ $totalPoints }}
                                            </span>
                                            <span class="text-sm text-gray-500 ml-1">pts</span>
                                        </div>
                                        @if($totalPoints < 80)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">
                                                Need {{ 80 - $totalPoints }} more
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                                ✓ Verified
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        @if($profile->submitted_at)
                                            <div>{{ $profile->submitted_at->format('M j, Y') }}</div>
                                            <div class="text-xs">{{ $profile->submitted_at->format('g:i A') }}</div>
                                            @if($daysOld > 3 && $profile->status === 'pending')
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-orange-100 text-orange-800 mt-1">
                                                    🔥 {{ $daysOld }} days old
                                                </span>
                                            @endif
                                        @else
                                            <span class="text-gray-400">Not submitted</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold
                                            {{ $profile->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                            {{ $profile->status === 'approved' ? 'bg-green-100 text-green-800' : '' }}
                                            {{ $profile->status === 'rejected' ? 'bg-red-100 text-red-800' : '' }}
                                            {{ $profile->status === 'draft' ? 'bg-gray-100 text-gray-800' : '' }}">
                                            {{ ucfirst($profile->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex items-center justify-end gap-2">
                                            <!-- Review Button -->
                                            <a href="{{ route('admin.profiles.show', $profile->id) }}" 
                                               class="inline-flex items-center px-3 py-1.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                                Review
                                            </a>
                                            
                                            @if($profile->status === 'pending')
                                                <!-- Quick Approve -->
                                                <form action="{{ route('admin.profiles.approve', $profile->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" 
                                                            onclick="return confirm('Are you sure you want to approve this profile?')"
                                                            class="inline-flex items-center px-3 py-1.5 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                        </svg>
                                                        Approve
                                                    </button>
                                                </form>
                                            @endif

                                            <!-- History Button (if available) -->
                                            @if(isset($profile->histories) && $profile->histories->count() > 0)
                                                <a href="{{ route('admin.profiles.history', $profile->id) }}" 
                                                   class="inline-flex items-center px-3 py-1.5 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                    </svg>
                                                    History
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $profiles->appends(['status' => $status])->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No profiles found</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        @if($status === 'pending')
                            No pending profiles to review at the moment.
                        @elseif($status === 'approved')
                            No approved profiles yet.
                        @elseif($status === 'rejected')
                            No rejected profiles yet.
                        @else
                            No user profiles have been submitted yet.
                        @endif
                    </p>
                </div>
            @endif
        </div>

        <!-- Summary Stats -->
        <div class="mt-6 grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 p-3 bg-yellow-100 rounded-lg">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Pending</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $counts['pending'] ?? 0 }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 p-3 bg-green-100 rounded-lg">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Approved</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $counts['approved'] ?? 0 }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 p-3 bg-red-100 rounded-lg">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Rejected</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $counts['rejected'] ?? 0 }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 p-3 bg-blue-100 rounded-lg">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total</p>
                        <p class="text-2xl font-bold text-gray-900">{{ ($counts['pending'] ?? 0) + ($counts['approved'] ?? 0) + ($counts['rejected'] ?? 0) }}</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@if(session('success'))
    <div class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="fixed bottom-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg">
        {{ session('error') }}
    </div>
@endif
@endsection