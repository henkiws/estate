@extends('layouts.admin')

@section('title', 'Agencies Management')

@section('content')

<div class="mb-8">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Agencies Management</h1>
            <p class="text-gray-600">Manage and review all registered agencies</p>
        </div>
        <div class="flex gap-3">
            <button class="px-6 py-3 bg-white border border-gray-300 text-gray-700 rounded-xl font-semibold hover:bg-[#DDEECD]/30 transition flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Export
            </button>
        </div>
    </div>
</div>

{{-- Statistics Cards --}}
<div class="grid sm:grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
    <div class="bg-white rounded-xl p-4 border border-gray-200 hover:shadow-md transition-shadow">
        <div class="text-sm text-gray-600 mb-1">Total</div>
        <div class="text-2xl font-bold text-gray-800">{{ $agencies->total() }}</div>
    </div>
    <div class="bg-white rounded-xl p-4 border border-gray-200 hover:shadow-md transition-shadow">
        <div class="text-sm text-gray-600 mb-1">Active</div>
        <div class="text-2xl font-bold text-gray-700">{{ \App\Models\Agency::where('status', 'active')->count() }}</div>
    </div>
    <div class="bg-white rounded-xl p-4 border border-gray-200 hover:shadow-md transition-shadow">
        <div class="text-sm text-gray-600 mb-1">Pending</div>
        <div class="text-2xl font-bold text-gray-700">{{ \App\Models\Agency::where('status', 'pending')->count() }}</div>
    </div>
    <div class="bg-white rounded-xl p-4 border border-gray-200 hover:shadow-md transition-shadow">
        <div class="text-sm text-gray-600 mb-1">Suspended</div>
        <div class="text-2xl font-bold text-gray-600">{{ \App\Models\Agency::where('status', 'suspended')->count() }}</div>
    </div>
    <div class="bg-white rounded-xl p-4 border border-gray-200 hover:shadow-md transition-shadow">
        <div class="text-sm text-gray-600 mb-1">This Month</div>
        <div class="text-2xl font-bold text-gray-700">{{ \App\Models\Agency::whereMonth('created_at', now()->month)->count() }}</div>
    </div>
</div>

{{-- Filters & Search --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-8">
    <form method="GET" action="{{ route('admin.agencies.index') }}" class="flex flex-col sm:flex-row gap-4">
        {{-- Search --}}
        <div class="flex-1">
            <div class="relative">
                <input type="search" 
                       name="search" 
                       value="{{ request('search') }}"
                       placeholder="Search by agency name, ABN, email..." 
                       class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#DDEECD] focus:border-[#DDEECD] hover:border-[#DDEECD]/50 transition-colors">
                <svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
        </div>

        {{-- Status Filter --}}
        <div class="w-full sm:w-48">
            <select name="status" 
                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#DDEECD] focus:border-[#DDEECD] hover:border-[#DDEECD]/50 bg-white transition-colors">
                <option value="">All Status</option>
                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="suspended" {{ request('status') === 'suspended' ? 'selected' : '' }}>Suspended</option>
                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        {{-- State Filter --}}
        <div class="w-full sm:w-40">
            <select name="state" 
                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#DDEECD] focus:border-[#DDEECD] hover:border-[#DDEECD]/50 bg-white transition-colors">
                <option value="">All States</option>
                <option value="NSW" {{ request('state') === 'NSW' ? 'selected' : '' }}>NSW</option>
                <option value="VIC" {{ request('state') === 'VIC' ? 'selected' : '' }}>VIC</option>
                <option value="QLD" {{ request('state') === 'QLD' ? 'selected' : '' }}>QLD</option>
                <option value="WA" {{ request('state') === 'WA' ? 'selected' : '' }}>WA</option>
                <option value="SA" {{ request('state') === 'SA' ? 'selected' : '' }}>SA</option>
                <option value="TAS" {{ request('state') === 'TAS' ? 'selected' : '' }}>TAS</option>
                <option value="ACT" {{ request('state') === 'ACT' ? 'selected' : '' }}>ACT</option>
                <option value="NT" {{ request('state') === 'NT' ? 'selected' : '' }}>NT</option>
            </select>
        </div>

        {{-- Buttons --}}
        <div class="flex gap-2">
            <button type="submit" class="px-6 py-3 bg-[#DDEECD] text-gray-800 rounded-xl font-semibold hover:bg-[#DDEECD]/80 transition">
                Filter
            </button>
            <a href="{{ route('admin.agencies.index') }}" class="px-6 py-3 bg-gray-100 text-gray-700 rounded-xl font-semibold hover:bg-gray-200 transition">
                Clear
            </a>
        </div>
    </form>
</div>

{{-- Agencies Table --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-[#DDEECD]/30 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider text-center">Agency ID</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Agency</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Contact</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Location</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Registered</th>
                    <th class="px-6 py-4 text-right text-xs font-semibold text-gray-700 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($agencies as $agency)
                <tr class="hover:bg-[#DDEECD]/20 transition">
                    <td class="px-6 py-4 text-sm text-gray-500 text-center">
                        {{ $agency->id }}
                    </td>
                    <td class="px-6 py-4">
                        <div>
                            <div class="font-semibold text-gray-800">{{ $agency->agency_name }}</div>
                            <div class="text-sm text-gray-500">ABN: {{ $agency->abn }}</div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm">
                            <div class="text-gray-800">{{ $agency->license_holder_name }}</div>
                            <div class="text-gray-500">{{ $agency->business_email }}</div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm">
                            <div class="text-gray-800">{{ $agency->state }}</div>
                            <div class="text-gray-500">{{ $agency->postcode }}</div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full
                            {{ $agency->status === 'active' ? 'bg-[#DDEECD] text-gray-800' : '' }}
                            {{ $agency->status === 'pending' ? 'bg-[#E6FF4B] text-gray-800' : '' }}
                            {{ $agency->status === 'suspended' ? 'bg-gray-200 text-gray-600' : '' }}
                            {{ $agency->status === 'inactive' ? 'bg-gray-100 text-gray-500' : '' }}">
                            {{ ucfirst($agency->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500">
                        {{ $agency->created_at->format('M d, Y') }}
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            {{-- View Details --}}
                            <a href="{{ route('admin.agencies.show', $agency->id) }}" 
                               class="p-2 text-gray-700 hover:bg-[#DDEECD] rounded-lg transition" 
                               title="View Details">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </a>

                            {{-- Edit --}}
                            <a href="{{ route('admin.agencies.edit', $agency->id) }}" 
                               class="p-2 text-gray-600 hover:bg-gray-100 rounded-lg transition" 
                               title="Edit">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>

                            {{-- Quick Actions Dropdown --}}
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" class="p-2 text-gray-600 hover:bg-gray-100 rounded-lg transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"/>
                                    </svg>
                                </button>
                                <div x-show="open" 
                                     @click.away="open = false"
                                     x-transition
                                     class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-200 py-2 z-10">
                                    
                                    @if($agency->status === 'pending')
                                    <form action="{{ route('admin.agencies.approve', $agency->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-[#DDEECD] flex items-center gap-2 transition">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            Approve
                                        </button>
                                    </form>
                                    @endif

                                    @if($agency->status === 'active')
                                    <form action="{{ route('admin.agencies.suspend', $agency->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-600 hover:bg-gray-100 flex items-center gap-2 transition">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            Suspend
                                        </button>
                                    </form>
                                    @endif

                                    @if($agency->status === 'suspended')
                                    <form action="{{ route('admin.agencies.reactivate', $agency->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-[#DDEECD] flex items-center gap-2 transition">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            Reactivate
                                        </button>
                                    </form>
                                    @endif

                                    <form action="{{ route('admin.agencies.destroy', $agency->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this agency? This action cannot be undone.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-500 hover:bg-gray-100 flex items-center gap-2 transition">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center justify-center">
                            <div class="w-16 h-16 bg-[#DDEECD]/30 rounded-full flex items-center justify-center mb-4">
                                <svg class="w-8 h-8 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                            </div>
                            <p class="text-gray-700 font-medium mb-2">No agencies found</p>
                            <p class="text-gray-500 text-sm">Try adjusting your search or filter criteria</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($agencies->hasPages())
    <div class="px-6 py-4 border-t border-gray-200">
        {{ $agencies->links() }}
    </div>
    @endif
</div>

@endsection