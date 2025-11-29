@extends('layouts.admin')

@section('title', 'Users Report')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <a href="{{ route('admin.reports.index') }}" class="text-gray-600 hover:text-gray-900">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <h1 class="text-3xl font-bold text-gray-900">Users Report</h1>
            </div>
            <p class="text-gray-600">User growth, role distribution, and engagement metrics</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.reports.export', ['type' => 'users', 'start_date' => $startDate, 'end_date' => $endDate]) }}" 
               class="flex items-center gap-2 px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition font-medium">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Export CSV
            </a>
            <button onclick="window.print()" class="flex items-center gap-2 px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition font-medium">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                </svg>
                Print
            </button>
        </div>
    </div>

    <!-- Date Range Filter -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 mb-6">
        <form method="GET" action="{{ route('admin.reports.users') }}" class="flex flex-wrap items-center gap-4">
            <label class="text-sm font-medium text-gray-700">Date Range:</label>
            <input type="date" name="start_date" value="{{ $startDate }}" 
                   class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent">
            <span class="text-gray-500">to</span>
            <input type="date" name="end_date" value="{{ $endDate }}" 
                   class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent">
            <button type="submit" class="px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition font-medium">
                Apply Filter
            </button>
            <a href="{{ route('admin.reports.users') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition font-medium">
                Reset
            </a>
        </form>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
            <div class="text-sm text-gray-600 mb-1">Total Users</div>
            <div class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_users']) }}</div>
        </div>
        <div class="bg-green-50 border border-green-200 rounded-xl p-4">
            <div class="text-sm text-green-700 mb-1">Verified Users</div>
            <div class="text-2xl font-bold text-green-900">{{ number_format($stats['verified_users']) }}</div>
        </div>
        <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
            <div class="text-sm text-blue-700 mb-1">Admin Users</div>
            <div class="text-2xl font-bold text-blue-900">{{ number_format($stats['admin_users']) }}</div>
        </div>
        <div class="bg-purple-50 border border-purple-200 rounded-xl p-4">
            <div class="text-sm text-purple-700 mb-1">With Agency</div>
            <div class="text-2xl font-bold text-purple-900">{{ number_format($stats['users_with_agency']) }}</div>
        </div>
        <div class="bg-orange-50 border border-orange-200 rounded-xl p-4">
            <div class="text-sm text-orange-700 mb-1">New This Month</div>
            <div class="text-2xl font-bold text-orange-900">{{ number_format($stats['new_this_month']) }}</div>
        </div>
    </div>

    <!-- Verification Rate Card -->
    <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white mb-8">
        <h2 class="text-xl font-bold mb-4">Email Verification Rate</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <div class="text-sm text-green-100 mb-2">Total Users</div>
                <div class="text-3xl font-bold">{{ number_format($verificationRate->total) }}</div>
            </div>
            <div>
                <div class="text-sm text-green-100 mb-2">Verified</div>
                <div class="text-3xl font-bold">{{ number_format($verificationRate->verified) }}</div>
            </div>
            <div>
                <div class="text-sm text-green-100 mb-2">Verification Rate</div>
                <div class="text-3xl font-bold">{{ $verificationRate->total > 0 ? number_format(($verificationRate->verified / $verificationRate->total) * 100, 1) : 0 }}%</div>
            </div>
        </div>
        <div class="mt-6">
            <div class="w-full bg-white bg-opacity-20 rounded-full h-4">
                <div class="bg-white h-4 rounded-full transition-all" 
                     style="width: {{ $verificationRate->total > 0 ? ($verificationRate->verified / $verificationRate->total) * 100 : 0 }}%"></div>
            </div>
        </div>
    </div>

    <!-- Charts Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Users by Role -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-bold text-gray-900 mb-4">Users by Role</h2>
            @if($usersByRole->count() > 0)
                <div class="space-y-3">
                    @php 
                        $totalRoleUsers = $usersByRole->sum('count');
                        $maxRole = $usersByRole->max('count');
                        $roleColors = [
                            'admin' => ['bg' => 'from-blue-500 to-blue-600', 'text' => 'text-blue-600'],
                            'agency' => ['bg' => 'from-purple-500 to-purple-600', 'text' => 'text-purple-600'],
                            'agent' => ['bg' => 'from-orange-500 to-orange-600', 'text' => 'text-orange-600'],
                        ];
                    @endphp
                    @foreach($usersByRole as $role)
                        @php
                            $color = $roleColors[strtolower($role->name)] ?? ['bg' => 'from-gray-500 to-gray-600', 'text' => 'text-gray-600'];
                            $percentage = $totalRoleUsers > 0 ? ($role->count / $totalRoleUsers) * 100 : 0;
                        @endphp
                        <div>
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-sm font-medium text-gray-700">{{ ucfirst($role->name) }}</span>
                                <span class="text-sm font-bold {{ $color['text'] }}">{{ $role->count }} ({{ number_format($percentage, 1) }}%)</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-3">
                                <div class="bg-gradient-to-r {{ $color['bg'] }} h-3 rounded-full transition-all" 
                                     style="width: {{ ($role->count / $maxRole) * 100 }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-8">No role data available</p>
            @endif
        </div>

        <!-- Registration Trend -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-bold text-gray-900 mb-4">Registration Trend (Last 12 Months)</h2>
            @if($registrationTrend->count() > 0)
                <div class="space-y-3">
                    @php $maxReg = $registrationTrend->max('count') ?: 1; @endphp
                    @foreach($registrationTrend as $trend)
                        <div>
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-sm font-medium text-gray-700">{{ \Carbon\Carbon::parse($trend->month . '-01')->format('M Y') }}</span>
                                <span class="text-sm font-bold text-orange-600">{{ $trend->count }}</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-3">
                                <div class="bg-gradient-to-r from-orange-500 to-orange-600 h-3 rounded-full transition-all" 
                                     style="width: {{ ($trend->count / $maxReg) * 100 }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-8">No data available</p>
            @endif
        </div>
    </div>

    <!-- Recent Users -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h2 class="text-lg font-bold text-gray-900 mb-4">Recent User Registrations</h2>
        @if($recentUsers->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-200">
                            <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">User</th>
                            <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Email</th>
                            <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Role</th>
                            <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Agency</th>
                            <th class="text-center py-3 px-4 text-sm font-semibold text-gray-700">Verified</th>
                            <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Joined</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentUsers as $user)
                            <tr class="border-b border-gray-100 hover:bg-gray-50">
                                <td class="py-3 px-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center flex-shrink-0">
                                            <span class="text-orange-700 font-semibold text-sm">{{ substr($user->name, 0, 2) }}</span>
                                        </div>
                                        <div>
                                            <div class="font-semibold text-gray-900">{{ $user->name }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3 px-4 text-sm text-gray-600">{{ $user->email }}</td>
                                <td class="py-3 px-4">
                                    @php
                                        $roleName = $user->roles->first()->name ?? 'N/A';
                                        $roleBadge = [
                                            'admin' => 'bg-blue-100 text-blue-800',
                                            'agency' => 'bg-purple-100 text-purple-800',
                                            'agent' => 'bg-orange-100 text-orange-800',
                                        ];
                                        $badgeClass = $roleBadge[strtolower($roleName)] ?? 'bg-gray-100 text-gray-800';
                                    @endphp
                                    <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $badgeClass }}">
                                        {{ ucfirst($roleName) }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 text-sm text-gray-600">{{ $user->agency->agency_name ?? '-' }}</td>
                                <td class="py-3 px-4 text-center">
                                    @if($user->email_verified_at)
                                        <span class="inline-flex items-center justify-center w-6 h-6 bg-green-100 rounded-full">
                                            <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                            </svg>
                                        </span>
                                    @else
                                        <span class="inline-flex items-center justify-center w-6 h-6 bg-gray-100 rounded-full">
                                            <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                            </svg>
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3 px-4 text-sm text-gray-600">{{ $user->created_at->diffForHumans() }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-500 text-center py-8">No recent users</p>
        @endif
    </div>
</div>

<style>
    @media print {
        .no-print, button, form { display: none; }
        body { background: white; }
        .shadow-lg, .shadow-sm { box-shadow: none !important; }
    }
</style>
@endsection