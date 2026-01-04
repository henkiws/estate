@extends('layouts.admin')

@section('title', 'Support Analytics')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Page Header -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Support Analytics</h1>
                <p class="mt-2 text-gray-600">Track support performance and ticket metrics</p>
            </div>
            
            <a 
                href="{{ route('admin.support.tickets.index') }}" 
                class="px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 transition flex items-center gap-2"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Tickets
            </a>
        </div>
        
        <!-- Key Metrics -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-sm p-6 text-white">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-medium opacity-90">Total Tickets</h3>
                    <svg class="w-8 h-8 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <p class="text-3xl font-bold">{{ number_format($stats['total_tickets']) }}</p>
                <p class="text-sm opacity-80 mt-2">All time</p>
            </div>
            
            <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl shadow-sm p-6 text-white">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-medium opacity-90">Open Tickets</h3>
                    <svg class="w-8 h-8 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <p class="text-3xl font-bold">{{ number_format($stats['open_tickets']) }}</p>
                <p class="text-sm opacity-80 mt-2">Needs attention</p>
            </div>
            
            <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-sm p-6 text-white">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-medium opacity-90">Resolved Today</h3>
                    <svg class="w-8 h-8 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <p class="text-3xl font-bold">{{ number_format($stats['resolved_today']) }}</p>
                <p class="text-sm opacity-80 mt-2">Last 24 hours</p>
            </div>
            
            <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-sm p-6 text-white">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-medium opacity-90">Avg Response Time</h3>
                    <svg class="w-8 h-8 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <p class="text-3xl font-bold">{{ $stats['avg_response_time'] }}</p>
                <p class="text-sm opacity-80 mt-2">Last 30 days</p>
            </div>
        </div>
        
        <!-- Charts Row 1 -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            
            <!-- Tickets by Status -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-6">Tickets by Status</h3>
                <div class="space-y-4">
                    @php
                        $statusLabels = [
                            'open' => 'Open',
                            'in_progress' => 'In Progress',
                            'waiting_response' => 'Waiting Response',
                            'resolved' => 'Resolved',
                            'closed' => 'Closed'
                        ];
                        $statusColors = [
                            'open' => 'bg-blue-500',
                            'in_progress' => 'bg-yellow-500',
                            'waiting_response' => 'bg-purple-500',
                            'resolved' => 'bg-green-500',
                            'closed' => 'bg-gray-500'
                        ];
                        $total = $ticketsByStatus->sum();
                    @endphp
                    
                    @foreach($statusLabels as $key => $label)
                        @php
                            $count = $ticketsByStatus[$key] ?? 0;
                            $percentage = $total > 0 ? round(($count / $total) * 100, 1) : 0;
                        @endphp
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm font-medium text-gray-700">{{ $label }}</span>
                                <span class="text-sm font-bold text-gray-900">{{ $count }} ({{ $percentage }}%)</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="{{ $statusColors[$key] }} h-2.5 rounded-full transition-all" style="width: {{ $percentage }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            
            <!-- Tickets by Priority -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-6">Tickets by Priority</h3>
                <div class="space-y-4">
                    @php
                        $priorityLabels = [
                            'critical' => 'Critical',
                            'urgent' => 'Urgent',
                            'high' => 'High',
                            'medium' => 'Medium',
                            'low' => 'Low'
                        ];
                        $priorityColors = [
                            'critical' => 'bg-red-600',
                            'urgent' => 'bg-red-500',
                            'high' => 'bg-orange-500',
                            'medium' => 'bg-yellow-500',
                            'low' => 'bg-green-500'
                        ];
                        $totalPriority = $ticketsByPriority->sum();
                    @endphp
                    
                    @foreach($priorityLabels as $key => $label)
                        @php
                            $count = $ticketsByPriority[$key] ?? 0;
                            $percentage = $totalPriority > 0 ? round(($count / $totalPriority) * 100, 1) : 0;
                        @endphp
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm font-medium text-gray-700">{{ $label }}</span>
                                <span class="text-sm font-bold text-gray-900">{{ $count }} ({{ $percentage }}%)</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="{{ $priorityColors[$key] }} h-2.5 rounded-full transition-all" style="width: {{ $percentage }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            
        </div>
        
        <!-- Charts Row 2 -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            
            <!-- Tickets by User Type -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-6">Tickets by User Type</h3>
                <div class="space-y-4">
                    @php
                        $userTypeLabels = [
                            'user' => 'Users',
                            'agency' => 'Agencies'
                        ];
                        $userTypeColors = [
                            'user' => 'bg-teal-500',
                            'agency' => 'bg-blue-500'
                        ];
                        $totalUserType = $ticketsByUserType->sum();
                    @endphp
                    
                    @foreach($userTypeLabels as $key => $label)
                        @php
                            $count = $ticketsByUserType[$key] ?? 0;
                            $percentage = $totalUserType > 0 ? round(($count / $totalUserType) * 100, 1) : 0;
                        @endphp
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm font-medium text-gray-700">{{ $label }}</span>
                                <span class="text-sm font-bold text-gray-900">{{ $count }} ({{ $percentage }}%)</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="{{ $userTypeColors[$key] }} h-2.5 rounded-full transition-all" style="width: {{ $percentage }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Donut Chart Visual -->
                <div class="mt-8 flex justify-center">
                    <div class="relative w-48 h-48">
                        @php
                            $userCount = $ticketsByUserType['user'] ?? 0;
                            $agencyCount = $ticketsByUserType['agency'] ?? 0;
                            $userPercentage = $totalUserType > 0 ? ($userCount / $totalUserType) * 100 : 0;
                        @endphp
                        <svg class="transform -rotate-90" viewBox="0 0 100 100">
                            <!-- Background circle -->
                            <circle cx="50" cy="50" r="40" fill="none" stroke="#e5e7eb" stroke-width="20"/>
                            
                            <!-- Users segment -->
                            <circle 
                                cx="50" 
                                cy="50" 
                                r="40" 
                                fill="none" 
                                stroke="#14b8a6" 
                                stroke-width="20"
                                stroke-dasharray="{{ $userPercentage * 2.51 }} 251.2"
                                stroke-linecap="round"
                            />
                            
                            <!-- Agencies segment -->
                            <circle 
                                cx="50" 
                                cy="50" 
                                r="40" 
                                fill="none" 
                                stroke="#3b82f6" 
                                stroke-width="20"
                                stroke-dasharray="{{ (100 - $userPercentage) * 2.51 }} 251.2"
                                stroke-dashoffset="{{ -$userPercentage * 2.51 }}"
                                stroke-linecap="round"
                            />
                        </svg>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="text-center">
                                <p class="text-2xl font-bold text-gray-900">{{ $totalUserType }}</p>
                                <p class="text-xs text-gray-500">Total</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Tickets by Category -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-6">Top Categories</h3>
                <div class="space-y-4">
                    @php
                        $categoryLabels = [
                            'billing' => 'Billing & Payments',
                            'subscription' => 'Subscription',
                            'agent_management' => 'Agent Management',
                            'property_listing' => 'Property Listing',
                            'application' => 'Application',
                            'property' => 'Property',
                            'profile' => 'Profile',
                            'account' => 'Account',
                            'technical' => 'Technical',
                            'other' => 'Other'
                        ];
                        
                        $sortedCategories = $ticketsByCategory->sortDesc()->take(8);
                        $totalCategory = $ticketsByCategory->sum();
                    @endphp
                    
                    @foreach($sortedCategories as $key => $count)
                        @php
                            $percentage = $totalCategory > 0 ? round(($count / $totalCategory) * 100, 1) : 0;
                        @endphp
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm font-medium text-gray-700">{{ $categoryLabels[$key] ?? ucfirst($key) }}</span>
                                <span class="text-sm font-bold text-gray-900">{{ $count }} ({{ $percentage }}%)</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="bg-[#5E17EB] h-2.5 rounded-full transition-all" style="width: {{ $percentage }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            
        </div>
        
        <!-- Ticket Activity Chart -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
            <h3 class="text-lg font-bold text-gray-900 mb-6">Ticket Activity (Last 30 Days)</h3>
            
            <div class="h-64 flex items-end justify-between gap-2">
                @php
                    $maxCount = $recentActivity->max('count') ?: 1;
                @endphp
                
                @foreach($recentActivity as $activity)
                    @php
                        $height = ($activity->count / $maxCount) * 100;
                        $date = \Carbon\Carbon::parse($activity->date);
                    @endphp
                    <div class="flex-1 flex flex-col items-center group">
                        <div class="relative w-full">
                            <div 
                                class="w-full bg-gradient-to-t from-[#5E17EB] to-[#7c3aed] rounded-t-lg transition-all hover:from-[#4c12bc] hover:to-[#6b2fc4]" 
                                style="height: {{ $height }}%;"
                                title="{{ $activity->count }} tickets on {{ $date->format('M d') }}"
                            ></div>
                            <div class="absolute -top-8 left-1/2 transform -translate-x-1/2 bg-gray-900 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">
                                {{ $activity->count }} tickets
                            </div>
                        </div>
                        <span class="text-xs text-gray-500 mt-2">{{ $date->format('M d') }}</span>
                    </div>
                @endforeach
            </div>
        </div>
        
        <!-- Staff Performance -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-6">Staff Performance</h3>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Staff Member</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Assigned Tickets</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Resolved Tickets</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Resolution Rate</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Performance</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($staffPerformance->sortByDesc('resolved_count') as $staff)
                            @php
                                $resolutionRate = $staff->assigned_tickets_count > 0 
                                    ? round(($staff->resolved_count / $staff->assigned_tickets_count) * 100, 1) 
                                    : 0;
                            @endphp
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-[#DDEECD] rounded-full flex items-center justify-center mr-3">
                                            <span class="text-gray-800 font-bold">{{ substr($staff->name, 0, 1) }}</span>
                                        </div>
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">{{ $staff->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $staff->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900 font-semibold">{{ $staff->assigned_tickets_count }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-green-600 font-semibold">{{ $staff->resolved_count }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900 font-semibold">{{ $resolutionRate }}%</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-32 bg-gray-200 rounded-full h-2.5 mr-2">
                                            <div class="bg-[#5E17EB] h-2.5 rounded-full" style="width: {{ $resolutionRate }}%"></div>
                                        </div>
                                        <span class="text-xs text-gray-600">
                                            @if($resolutionRate >= 80)
                                                Excellent
                                            @elseif($resolutionRate >= 60)
                                                Good
                                            @elseif($resolutionRate >= 40)
                                                Average
                                            @else
                                                Needs Improvement
                                            @endif
                                        </span>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        
    </div>
</div>
@endsection