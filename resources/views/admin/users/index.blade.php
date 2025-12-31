@extends('layouts.admin')

@section('title', 'User Management')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">User Management</h1>
            <p class="text-gray-600 mt-1">Manage all platform users and their roles</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.users.statistics') }}" 
               class="inline-flex items-center px-4 py-2 bg-[#DDEECD] text-gray-800 rounded-lg hover:bg-[#DDEECD]/80 transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
                Statistics
            </a>
            <button onclick="exportUsers()" 
                    class="inline-flex items-center px-4 py-2 bg-[#E6FF4B] text-gray-800 rounded-lg hover:bg-[#E6FF4B]/80 transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Export CSV
            </button>
            <a href="{{ route('admin.users.create') }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-700 text-white rounded-lg hover:bg-gray-800 transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Add New User
            </a>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="mb-6 bg-[#DDEECD]/30 border border-[#DDEECD] text-gray-800 px-4 py-3 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 bg-gray-100 border border-gray-400 text-gray-700 px-4 py-3 rounded-lg">
            {{ session('error') }}
        </div>
    @endif

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <form method="GET" action="{{ route('admin.users.index') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Search -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}"
                           placeholder="Name or email..."
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#DDEECD] focus:border-[#DDEECD] hover:border-[#DDEECD]/50 transition-colors">
                </div>

                <!-- Role Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Role</label>
                    <select name="role" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#DDEECD] focus:border-[#DDEECD] hover:border-[#DDEECD]/50 bg-white transition-colors">
                        <option value="">All Roles</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->name }}" {{ request('role') == $role->name ? 'selected' : '' }}>
                                {{ ucfirst($role->name) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Agency Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Agency</label>
                    <select name="agency_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#DDEECD] focus:border-[#DDEECD] hover:border-[#DDEECD]/50 bg-white transition-colors">
                        <option value="">All Agencies</option>
                        @foreach($agencies as $agency)
                            <option value="{{ $agency->id }}" {{ request('agency_id') == $agency->id ? 'selected' : '' }}>
                                {{ $agency->agency_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Status Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#DDEECD] focus:border-[#DDEECD] hover:border-[#DDEECD]/50 bg-white transition-colors">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
            </div>

            <div class="flex gap-3">
                <button type="submit" class="px-6 py-2 bg-[#DDEECD] text-gray-800 rounded-lg hover:bg-[#DDEECD]/80 transition font-semibold">
                    Apply Filters
                </button>
                <a href="{{ route('admin.users.index') }}" class="px-6 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition font-semibold">
                    Clear Filters
                </a>
            </div>
        </form>
    </div>

    <!-- Bulk Actions -->
    <form id="bulkActionForm" method="POST" action="{{ route('admin.users.bulk-update') }}">
        @csrf
        <div class="bg-white rounded-lg shadow-sm p-4 mb-6 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <input type="checkbox" id="selectAll" class="w-5 h-5 text-gray-700 rounded border-gray-300 focus:ring-2 focus:ring-[#DDEECD]">
                <label for="selectAll" class="text-sm font-medium text-gray-700">Select All</label>
                <span id="selectedCount" class="text-sm text-gray-500">0 selected</span>
            </div>
            <div class="flex gap-2">
                <select name="action" class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#DDEECD] focus:border-[#DDEECD] hover:border-[#DDEECD]/50 bg-white transition-colors">
                    <option value="">Bulk Actions</option>
                    <option value="verify">Verify Email</option>
                    <option value="activate">Activate</option>
                    <option value="suspend">Suspend</option>
                    <option value="assign_role">Assign Role</option>
                    <option value="delete">Delete</option>
                </select>
                <select name="role" id="roleSelect" class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#DDEECD] focus:border-[#DDEECD] hover:border-[#DDEECD]/50 bg-white transition-colors hidden">
                    @foreach($roles as $role)
                        <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
                    @endforeach
                </select>
                <button type="submit" class="px-4 py-2 bg-[#E6FF4B] text-gray-800 rounded-lg hover:bg-[#E6FF4B]/80 transition font-semibold">
                    Apply
                </button>
            </div>
        </div>

        <!-- Users Table -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-[#DDEECD]/30">
                        <tr>
                            <th class="px-6 py-3 text-left">
                                <input type="checkbox" class="w-5 h-5 text-gray-700 rounded">
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">User</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Role</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Agency</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Contact</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Joined</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($users as $user)
                            <tr class="hover:bg-[#DDEECD]/20 transition-colors">
                                <td class="px-6 py-4">
                                    <input type="checkbox" name="user_ids[]" value="{{ $user->id }}" class="user-checkbox w-5 h-5 text-gray-700 rounded">
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-[#DDEECD] rounded-full flex items-center justify-center mr-3">
                                            <span class="text-gray-700 font-semibold text-sm">
                                                {{ substr($user->name, 0, 2) }}
                                            </span>
                                        </div>
                                        <div>
                                            <p class="font-semibold text-gray-800">{{ $user->name }}</p>
                                            <p class="text-sm text-gray-500">{{ $user->email }}</p>
                                            @if($user->is_admin)
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-700 text-white mt-1">
                                                    🔑 Admin
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @foreach($user->roles as $role)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            @if($role->name === 'admin') bg-gray-700 text-white
                                            @elseif($role->name === 'agency') bg-[#00ccff] text-white
                                            @elseif($role->name === 'agent') bg-[#E6FF4B] text-gray-800
                                            @else bg-gray-100 text-gray-700
                                            @endif">
                                            {{ ucfirst($role->name) }}
                                        </span>
                                    @endforeach
                                </td>
                                <td class="px-6 py-4">
                                    @if($user->agency)
                                        <div class="text-sm">
                                            <p class="font-medium text-gray-800">{{ Str::limit($user->agency->agency_name, 20) }}</p>
                                            <p class="text-gray-500">{{ $user->position ?? 'N/A' }}</p>
                                        </div>
                                    @else
                                        <span class="text-sm text-gray-500">No agency</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    {{ $user->phone ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4">
                                    @if($user->email_verified_at)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-[#DDEECD] text-gray-700">
                                            ✓ Active
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-[#f86b6b] text-white">
                                            ✗ Inactive
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{ $user->created_at->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex gap-2">
                                        <a href="{{ route('admin.users.show', $user) }}" 
                                           class="text-gray-700 hover:text-gray-800 hover:bg-[#DDEECD] p-1 rounded transition"
                                           title="View">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </a>
                                        <a href="{{ route('admin.users.edit', $user) }}" 
                                           class="text-gray-700 hover:text-gray-800 hover:bg-[#E6FF4B] p-1 rounded transition"
                                           title="Edit">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </a>
                                        @if($user->id !== auth()->id())
                                            <form action="{{ route('admin.users.destroy', $user) }}" 
                                                  method="POST" 
                                                  onsubmit="return confirm('Are you sure you want to delete this user?');"
                                                  class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="text-gray-600 hover:text-gray-700 hover:bg-gray-100 p-1 rounded transition"
                                                        title="Delete">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-12 text-center text-gray-500">
                                    <div class="w-16 h-16 bg-[#DDEECD]/30 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <svg class="w-8 h-8 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                        </svg>
                                    </div>
                                    <p class="text-lg font-medium mb-2 text-gray-700">No users found</p>
                                    <p>Try adjusting your filters or search criteria</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </form>

    <!-- Pagination -->
    @if($users->hasPages())
        <div class="mt-6">
            {{ $users->links() }}
        </div>
    @endif
</div>

<script>
// Select All Functionality
document.getElementById('selectAll').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.user-checkbox');
    checkboxes.forEach(cb => cb.checked = this.checked);
    updateSelectedCount();
});

// Update selected count
document.querySelectorAll('.user-checkbox').forEach(checkbox => {
    checkbox.addEventListener('change', updateSelectedCount);
});

function updateSelectedCount() {
    const checked = document.querySelectorAll('.user-checkbox:checked').length;
    document.getElementById('selectedCount').textContent = `${checked} selected`;
}

// Show role select when assign_role is selected
document.querySelector('select[name="action"]').addEventListener('change', function() {
    const roleSelect = document.getElementById('roleSelect');
    if (this.value === 'assign_role') {
        roleSelect.classList.remove('hidden');
    } else {
        roleSelect.classList.add('hidden');
    }
});

// Export users with current filters
function exportUsers() {
    const urlParams = new URLSearchParams(window.location.search);
    window.location.href = '{{ route("admin.users.export") }}?' + urlParams.toString();
}

// Confirm bulk actions
document.getElementById('bulkActionForm').addEventListener('submit', function(e) {
    const checked = document.querySelectorAll('.user-checkbox:checked').length;
    if (checked === 0) {
        e.preventDefault();
        alert('Please select at least one user');
        return false;
    }
    
    const action = this.querySelector('[name="action"]').value;
    if (!action) {
        e.preventDefault();
        alert('Please select an action');
        return false;
    }
    
    if (action === 'delete') {
        if (!confirm(`Are you sure you want to delete ${checked} user${checked > 1 ? 's' : ''}?`)) {
            e.preventDefault();
            return false;
        }
    }
});
</script>
@endsection