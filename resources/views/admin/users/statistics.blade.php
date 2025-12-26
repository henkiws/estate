@extends('layouts.admin')

@section('title', 'User Statistics')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <a href="{{ route('admin.users.index') }}" class="text-gray-700 hover:text-gray-800 mb-2 inline-block font-medium">
                ← Back to Users
            </a>
            <h1 class="text-3xl font-bold text-gray-800">User Statistics & Analytics</h1>
            <p class="text-gray-600 mt-1">Overview of all users in the system</p>
        </div>
        <div class="flex gap-3">
            <button onclick="window.print()" 
                    class="inline-flex items-center px-4 py-2 bg-gray-700 text-white rounded-lg hover:bg-gray-800 transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                </svg>
                Print Report
            </button>
            <a href="{{ route('admin.users.export') }}" 
               class="inline-flex items-center px-4 py-2 bg-[#E6FF4B] text-gray-800 rounded-lg hover:bg-[#E6FF4B]/80 transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Export All Data
            </a>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Users -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Total Users</p>
                    <p class="text-3xl font-bold text-gray-800">{{ number_format($stats['total_users']) }}</p>
                </div>
                <div class="w-12 h-12 bg-[#DDEECD] rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
            </div>
            <p class="text-sm text-gray-500 mt-2">All registered users</p>
        </div>

        <!-- Verified Users -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Active Users</p>
                    <p class="text-3xl font-bold text-gray-700">{{ number_format($stats['verified_users']) }}</p>
                </div>
                <div class="w-12 h-12 bg-[#DDEECD] rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-gray-700" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                </div>
            </div>
            <p class="text-sm text-gray-500 mt-2">
                {{ $stats['total_users'] > 0 ? round(($stats['verified_users'] / $stats['total_users']) * 100, 1) : 0 }}% of total
            </p>
        </div>

        <!-- Admin Users -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Admin Users</p>
                    <p class="text-3xl font-bold text-gray-700">{{ number_format($stats['admin_users']) }}</p>
                </div>
                <div class="w-12 h-12 bg-gray-700 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div>
            </div>
            <p class="text-sm text-gray-500 mt-2">Full system access</p>
        </div>

        <!-- Agency Users -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Agency Assigned</p>
                    <p class="text-3xl font-bold text-gray-700">{{ number_format($stats['users_with_agency']) }}</p>
                </div>
                <div class="w-12 h-12 bg-[#E6FF4B] rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
            </div>
            <p class="text-sm text-gray-500 mt-2">Users with agency</p>
        </div>
    </div>

    <!-- Users by Role -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Role Distribution -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Users by Role</h2>
            <div class="space-y-4">
                @foreach($usersByRole as $role)
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm font-medium 
                                @if($role->name === 'admin') text-gray-700
                                @elseif($role->name === 'agency') text-gray-700
                                @elseif($role->name === 'agent') text-gray-700
                                @else text-gray-700
                                @endif">
                                {{ ucfirst($role->name) }}
                            </span>
                            <span class="text-sm font-bold text-gray-800">{{ number_format($role->users_count) }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-3">
                            <div class="h-3 rounded-full 
                                @if($role->name === 'admin') bg-gray-700
                                @elseif($role->name === 'agency') bg-[#DDEECD]
                                @elseif($role->name === 'agent') bg-[#E6FF4B]
                                @else bg-gray-500
                                @endif" 
                                 style="width: {{ $stats['total_users'] > 0 ? ($role->users_count / $stats['total_users']) * 100 : 0 }}%">
                            </div>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">
                            {{ $stats['total_users'] > 0 ? round(($role->users_count / $stats['total_users']) * 100, 1) : 0 }}% of total users
                        </p>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Account Status -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Account Status</h2>
            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <div class="flex items-center">
                        <span class="w-3 h-3 bg-[#DDEECD] rounded-full mr-2"></span>
                        <span class="text-sm text-gray-700">Active (Verified)</span>
                    </div>
                    <span class="text-sm font-bold text-gray-800">{{ number_format($stats['verified_users']) }}</span>
                </div>

                <div class="flex justify-between items-center">
                    <div class="flex items-center">
                        <span class="w-3 h-3 bg-gray-400 rounded-full mr-2"></span>
                        <span class="text-sm text-gray-700">Inactive (Unverified)</span>
                    </div>
                    <span class="text-sm font-bold text-gray-800">{{ number_format($stats['total_users'] - $stats['verified_users']) }}</span>
                </div>

                <div class="flex justify-between items-center">
                    <div class="flex items-center">
                        <span class="w-3 h-3 bg-gray-700 rounded-full mr-2"></span>
                        <span class="text-sm text-gray-700">Admin Access</span>
                    </div>
                    <span class="text-sm font-bold text-gray-800">{{ number_format($stats['admin_users']) }}</span>
                </div>

                <div class="flex justify-between items-center">
                    <div class="flex items-center">
                        <span class="w-3 h-3 bg-[#E6FF4B] rounded-full mr-2"></span>
                        <span class="text-sm text-gray-700">With Agency</span>
                    </div>
                    <span class="text-sm font-bold text-gray-800">{{ number_format($stats['users_with_agency']) }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Users by Agency -->
    @if($usersByAgency->count() > 0)
        <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Users by Agency</h2>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-[#DDEECD]/30">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Agency Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Total Users</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Percentage</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Visual</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($usersByAgency->sortByDesc('count')->take(10) as $item)
                            <tr class="hover:bg-[#DDEECD]/20 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-[#DDEECD] rounded-full flex items-center justify-center mr-3">
                                            <span class="text-gray-700 text-xs font-semibold">
                                                {{ substr($item['agency'], 0, 2) }}
                                            </span>
                                        </div>
                                        <span class="font-medium text-gray-800">{{ $item['agency'] }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm font-bold text-gray-800">{{ number_format($item['count']) }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm text-gray-600">
                                        {{ $stats['total_users'] > 0 ? round(($item['count'] / $stats['total_users']) * 100, 1) : 0 }}%
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="bg-[#DDEECD] h-2 rounded-full" 
                                             style="width: {{ $stats['total_users'] > 0 ? ($item['count'] / $stats['total_users']) * 100 : 0 }}%"></div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            @if($usersByAgency->count() > 10)
                <p class="text-sm text-gray-500 mt-4 text-center">
                    Showing top 10 agencies. Total agencies with users: {{ $usersByAgency->count() }}
                </p>
            @endif
        </div>
    @endif

    <!-- Recent Users -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Recent User Registrations</h2>
        
        @if($recentUsers->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-[#DDEECD]/30">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">User</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Role</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Agency</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Joined</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($recentUsers as $user)
                            <tr class="hover:bg-[#DDEECD]/20 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-[#DDEECD] rounded-full flex items-center justify-center mr-3">
                                            <span class="text-gray-700 text-xs font-semibold">
                                                {{ substr($user->name, 0, 2) }}
                                            </span>
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-800">{{ Str::limit($user->name, 30) }}</p>
                                            <p class="text-sm text-gray-500">{{ $user->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @foreach($user->roles as $role)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            @if($role->name === 'admin') bg-gray-700 text-white
                                            @elseif($role->name === 'agency') bg-[#DDEECD] text-gray-800
                                            @elseif($role->name === 'agent') bg-[#E6FF4B] text-gray-800
                                            @else bg-gray-100 text-gray-700
                                            @endif">
                                            {{ ucfirst($role->name) }}
                                        </span>
                                    @endforeach
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                    {{ $user->agency->agency_name ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($user->email_verified_at)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-[#DDEECD] text-gray-700">
                                            Active
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-200 text-gray-600">
                                            Inactive
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $user->created_at->diffForHumans() }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <a href="{{ route('admin.users.show', $user) }}" 
                                       class="text-gray-700 hover:text-gray-800 font-medium">
                                        View
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-500 text-center py-8">No recent users</p>
        @endif
    </div>

    <!-- Quick Links -->
    <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
        <a href="{{ route('admin.users.index', ['status' => 'inactive']) }}" 
           class="block bg-gray-100 border border-gray-300 rounded-lg p-6 hover:bg-gray-200 transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-700 font-semibold">Review Inactive Users</p>
                    <p class="text-2xl font-bold text-gray-800 mt-2">{{ $stats['total_users'] - $stats['verified_users'] }}</p>
                </div>
                <svg class="w-8 h-8 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
            </div>
        </a>

        <a href="{{ route('admin.users.index', ['role' => 'admin']) }}" 
           class="block bg-gray-700 border border-gray-700 rounded-lg p-6 hover:bg-gray-800 transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-white font-semibold">Admin Users</p>
                    <p class="text-2xl font-bold text-white mt-2">{{ $stats['admin_users'] }}</p>
                </div>
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
            </div>
        </a>

        <a href="{{ route('admin.users.index') }}" 
           class="block bg-[#DDEECD] border border-[#DDEECD] rounded-lg p-6 hover:bg-[#DDEECD]/80 transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-800 font-semibold">All Users</p>
                    <p class="text-2xl font-bold text-gray-800 mt-2">{{ $stats['total_users'] }}</p>
                </div>
                <svg class="w-8 h-8 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
            </div>
        </a>
    </div>
</div>

<style>
@media print {
    .no-print {
        display: none !important;
    }
    
    body {
        print-color-adjust: exact;
        -webkit-print-color-adjust: exact;
    }
}
</style>
@endsection