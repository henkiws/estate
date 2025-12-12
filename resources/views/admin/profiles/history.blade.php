@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Profile Approval History</h1>
                    <p class="mt-2 text-gray-600">{{ $profile->user->name }} - {{ $profile->user->email }}</p>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('admin.profiles.show', $profile->id) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                        View Profile
                    </a>
                    <a href="{{ route('admin.profiles.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                        Back to List
                    </a>
                </div>
            </div>
        </div>

        <!-- Current Status Card -->
        <div class="bg-white rounded-2xl shadow-lg p-6 mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Current Status</h3>
                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold
                        {{ $profile->status === 'approved' ? 'bg-green-100 text-green-800' : '' }}
                        {{ $profile->status === 'rejected' ? 'bg-red-100 text-red-800' : '' }}
                        {{ $profile->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                        {{ $profile->status === 'draft' ? 'bg-gray-100 text-gray-800' : '' }}">
                        {{ ucfirst($profile->status) }}
                    </span>
                </div>
                <div class="text-right">
                    @if($profile->approved_at)
                        <p class="text-sm text-gray-600">Approved</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $profile->approved_at->format('M j, Y g:i A') }}</p>
                    @elseif($profile->rejected_at)
                        <p class="text-sm text-gray-600">Rejected</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $profile->rejected_at->format('M j, Y g:i A') }}</p>
                    @elseif($profile->submitted_at)
                        <p class="text-sm text-gray-600">Submitted</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $profile->submitted_at->format('M j, Y g:i A') }}</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- History Timeline -->
        <div class="bg-white rounded-2xl shadow-lg p-8">
            <h3 class="text-xl font-bold text-gray-900 mb-6">Activity Timeline</h3>

            @forelse($profile->histories as $history)
                <div class="relative pb-8 {{ !$loop->last ? 'border-l-2 border-gray-200' : '' }} ml-4">
                    <!-- Timeline Dot -->
                    <div class="absolute -left-[9px] mt-1.5">
                        <div class="w-4 h-4 rounded-full border-2 border-white
                            {{ $history->action === 'approved' ? 'bg-green-500' : '' }}
                            {{ $history->action === 'rejected' ? 'bg-red-500' : '' }}
                            {{ $history->action === 'submitted' ? 'bg-blue-500' : '' }}
                            {{ $history->action === 'updated' ? 'bg-yellow-500' : '' }}">
                        </div>
                    </div>

                    <!-- History Card -->
                    <div class="ml-8 bg-gray-50 rounded-xl p-6">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex-1">
                                <div class="flex items-center gap-3 mb-2">
                                    <!-- Action Badge -->
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold
                                        {{ $history->action === 'approved' ? 'bg-green-100 text-green-800' : '' }}
                                        {{ $history->action === 'rejected' ? 'bg-red-100 text-red-800' : '' }}
                                        {{ $history->action === 'submitted' ? 'bg-blue-100 text-blue-800' : '' }}
                                        {{ $history->action === 'updated' ? 'bg-yellow-100 text-yellow-800' : '' }}">
                                        {{ $history->action_text }}
                                    </span>

                                    <!-- Status Change Arrow -->
                                    @if($history->previous_status)
                                        <div class="flex items-center gap-2 text-sm text-gray-600">
                                            <span class="px-2 py-1 bg-white rounded capitalize">{{ $history->previous_status }}</span>
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                            </svg>
                                            <span class="px-2 py-1 bg-white rounded capitalize">{{ $history->new_status }}</span>
                                        </div>
                                    @endif
                                </div>

                                <h4 class="text-lg font-semibold text-gray-900 mb-1">
                                    {{ $history->action === 'approved' ? 'Profile Approved' : '' }}
                                    {{ $history->action === 'rejected' ? 'Profile Rejected' : '' }}
                                    {{ $history->action === 'submitted' ? 'Profile Submitted for Review' : '' }}
                                    {{ $history->action === 'updated' ? 'Profile Updated' : '' }}
                                </h4>

                                <div class="flex items-center gap-4 text-sm text-gray-600">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                        <span>{{ $history->admin->name }}</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <span>{{ $history->created_at->format('M j, Y g:i A') }}</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                                        </svg>
                                        <span>{{ $history->ip_address }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="text-right text-sm text-gray-500">
                                {{ $history->created_at->diffForHumans() }}
                            </div>
                        </div>

                        <!-- Reason (visible to user) -->
                        @if($history->reason)
                            <div class="mt-4 p-4 bg-white rounded-lg border-l-4 
                                {{ $history->action === 'rejected' ? 'border-red-500' : 'border-blue-500' }}">
                                <p class="text-sm font-semibold text-gray-700 mb-1">
                                    {{ $history->action === 'rejected' ? 'Rejection Reason:' : 'Reason:' }}
                                </p>
                                <p class="text-gray-900">{{ $history->reason }}</p>
                            </div>
                        @endif

                        <!-- Admin Notes (private) -->
                        @if($history->admin_notes)
                            <div class="mt-4 p-4 bg-yellow-50 rounded-lg border-l-4 border-yellow-500">
                                <p class="text-sm font-semibold text-gray-700 mb-1 flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                    Admin Notes (Private):
                                </p>
                                <p class="text-gray-900 text-sm">{{ $history->admin_notes }}</p>
                            </div>
                        @endif

                        <!-- Changes (if any) -->
                        @if($history->changes && is_array($history->changes) && count($history->changes) > 0)
                            <div class="mt-4 p-4 bg-gray-100 rounded-lg">
                                <p class="text-sm font-semibold text-gray-700 mb-2">Changes Made:</p>
                                <ul class="space-y-1 text-sm">
                                    @foreach($history->changes as $field => $change)
                                        <li class="flex items-center gap-2 text-gray-700">
                                            <svg class="w-3 h-3 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                            </svg>
                                            <span class="capitalize">{{ str_replace('_', ' ', $field) }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="text-center py-12">
                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <p class="text-gray-600">No history available for this profile</p>
                </div>
            @endforelse
        </div>

    </div>
</div>
@endsection