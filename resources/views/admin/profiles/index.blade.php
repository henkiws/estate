@extends('layouts.admin')

@section('title', 'User Profiles')

@section('content')

<div class="mb-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">User Profiles</h1>
            <p class="text-gray-600 mt-1">Review and manage user profile submissions</p>
        </div>
    </div>
</div>

<!-- Filter Tabs -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-2 mb-6 inline-flex">
    <a href="{{ route('admin.profiles.index', ['status' => 'pending']) }}" 
       class="px-4 py-2 rounded-lg font-semibold {{ $status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'text-gray-600 hover:bg-gray-100' }}">
        Pending ({{ $pendingCount }})
    </a>
    <a href="{{ route('admin.profiles.index', ['status' => 'approved']) }}" 
       class="px-4 py-2 rounded-lg font-semibold {{ $status === 'approved' ? 'bg-green-100 text-green-800' : 'text-gray-600 hover:bg-gray-100' }}">
        Approved ({{ $approvedCount }})
    </a>
    <a href="{{ route('admin.profiles.index', ['status' => 'rejected']) }}" 
       class="px-4 py-2 rounded-lg font-semibold {{ $status === 'rejected' ? 'bg-red-100 text-red-800' : 'text-gray-600 hover:bg-gray-100' }}">
        Rejected ({{ $rejectedCount }})
    </a>
</div>

<!-- Profiles Table -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    @if($profiles->count() > 0)
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID Points</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Submitted</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($profiles as $profile)
                @php
                    $totalPoints = $profile->user->identifications->sum('points');
                @endphp
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <span class="text-blue-600 font-bold">{{ substr($profile->first_name, 0, 1) }}</span>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ $profile->first_name }} {{ $profile->last_name }}
                                </div>
                                <div class="text-sm text-gray-500">{{ $profile->user->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ $profile->mobile_country_code }} {{ $profile->mobile_number }}</div>
                        <div class="text-sm text-gray-500">{{ $profile->email }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="text-sm font-semibold {{ $totalPoints >= 80 ? 'text-green-600' : 'text-red-600' }}">
                            {{ $totalPoints }} points
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ $profile->submitted_at ? $profile->submitted_at->format('M d, Y') : 'N/A' }}</div>
                        <div class="text-sm text-gray-500">{{ $profile->submitted_at ? $profile->submitted_at->diffForHumans() : 'N/A' }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($profile->status === 'pending')
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                Pending
                            </span>
                        @elseif($profile->status === 'approved')
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                Approved
                            </span>
                        @else
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                Rejected
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <a href="{{ route('admin.profiles.show', $profile->id) }}" 
                           class="text-primary hover:text-primary-dark">
                            Review →
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($profiles->hasPages())
    <div class="px-6 py-4 border-t border-gray-200">
        {{ $profiles->links() }}
    </div>
    @endif
    @else
    <div class="text-center py-12">
        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
            </svg>
        </div>
        <h3 class="text-lg font-semibold text-gray-900 mb-2">No {{ ucfirst($status) }} Profiles</h3>
        <p class="text-gray-600">There are no profiles with {{ $status }} status at the moment.</p>
    </div>
    @endif
</div>

@endsection