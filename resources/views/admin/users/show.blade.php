@extends('layouts.admin')

@section('title', 'User Details')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <a href="{{ route('admin.users.index') }}" class="text-gray-700 hover:text-gray-800 mb-2 inline-block font-medium">
                ← Back to Users
            </a>
            <h1 class="text-3xl font-bold text-gray-800">{{ $user->name }}</h1>
            <p class="text-gray-600 mt-1">{{ $user->email }}</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.users.edit', $user) }}" 
               class="inline-flex items-center px-4 py-2 bg-[#E6FF4B] text-gray-800 rounded-lg hover:bg-[#E6FF4B]/80 transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit User
            </a>
            @if($user->id !== auth()->id())
                <form action="{{ route('admin.users.destroy', $user) }}" 
                      method="POST" 
                      onsubmit="return confirm('Are you sure you want to delete this user?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Delete
                    </button>
                </form>
            @endif
        </div>
    </div>

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

    @if(session('info'))
        <div class="mb-6 bg-[#E6FF4B]/30 border border-[#E6FF4B] text-gray-800 px-4 py-3 rounded-lg">
            {{ session('info') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- User Information -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">User Information</h2>
                
                <div class="flex items-center mb-6">
                    <div class="w-20 h-20 bg-[#DDEECD] rounded-full flex items-center justify-center mr-4">
                        <span class="text-gray-700 font-bold text-2xl">
                            {{ substr($user->name, 0, 2) }}
                        </span>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-gray-800">{{ $user->name }}</h3>
                        <p class="text-gray-600">{{ $user->email }}</p>
                        <div class="flex gap-2 mt-2">
                            @foreach($user->roles as $role)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                    @if($role->name === 'admin') bg-gray-700 text-white
                                    @elseif($role->name === 'agency') bg-[#DDEECD] text-gray-800
                                    @elseif($role->name === 'agent') bg-[#E6FF4B] text-gray-800
                                    @else bg-gray-100 text-gray-700
                                    @endif">
                                    {{ ucfirst($role->name) }}
                                </span>
                            @endforeach
                            @if($user->is_admin)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-700 text-white">
                                    🔑 Admin Access
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-600">Phone</p>
                        <p class="font-semibold text-gray-800">{{ $user->phone ?? 'Not provided' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Position</p>
                        <p class="font-semibold text-gray-800">{{ $user->position ?? 'Not specified' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Member Since</p>
                        <p class="font-semibold text-gray-800">{{ $user->created_at->format('M d, Y') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Last Updated</p>
                        <p class="font-semibold text-gray-800">{{ $user->updated_at->format('M d, Y') }}</p>
                    </div>
                </div>
            </div>

            <!-- Agency Information -->
            @if($user->agency)
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Agency Information</h2>
                    
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-[#DDEECD] rounded-full flex items-center justify-center mr-3">
                            <span class="text-gray-700 font-semibold">
                                {{ substr($user->agency->agency_name, 0, 2) }}
                            </span>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-800">{{ $user->agency->agency_name }}</p>
                            <p class="text-sm text-gray-500">{{ $user->agency->trading_name ?? '' }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 pt-4 border-t">
                        <div>
                            <p class="text-sm text-gray-600">License Number</p>
                            <p class="font-medium text-gray-800">{{ $user->agency->license_number }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">ABN</p>
                            <p class="font-medium text-gray-800">{{ $user->agency->abn }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">State</p>
                            <p class="font-medium text-gray-800">{{ $user->agency->state }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Status</p>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                @if($user->agency->status === 'approved' || $user->agency->status === 'active') bg-[#DDEECD] text-gray-700
                                @elseif($user->agency->status === 'pending') bg-[#E6FF4B] text-gray-800
                                @else bg-gray-100 text-gray-600
                                @endif">
                                {{ ucfirst($user->agency->status) }}
                            </span>
                        </div>
                    </div>

                    <a href="{{ route('admin.agencies.show', $user->agency) }}" 
                       class="mt-4 block text-center px-4 py-2 bg-[#DDEECD] text-gray-800 rounded-lg hover:bg-[#DDEECD]/80 transition">
                        View Full Agency Profile
                    </a>
                </div>
            @else
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Agency Information</h2>
                    <p class="text-gray-500 text-center py-8">No agency assigned</p>
                </div>
            @endif

            <!-- Permissions -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Permissions</h2>
                
                @if($user->permissions->count() > 0)
                    <div class="grid grid-cols-2 gap-3">
                        @foreach($user->permissions as $permission)
                            <div class="flex items-center text-sm">
                                <svg class="w-4 h-4 text-gray-700 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $permission->name }}
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center py-4">No direct permissions assigned. Permissions inherited from role.</p>
                @endif

                @if($user->roles->count() > 0)
                    <div class="mt-6 pt-6 border-t">
                        <h3 class="font-semibold text-gray-800 mb-3">Role Permissions</h3>
                        @foreach($user->roles as $role)
                            <div class="mb-4">
                                <p class="text-sm font-medium text-gray-700 mb-2">{{ ucfirst($role->name) }} Role:</p>
                                <div class="grid grid-cols-2 gap-2">
                                    @foreach($role->permissions as $permission)
                                        <div class="flex items-center text-sm text-gray-600">
                                            <svg class="w-4 h-4 text-gray-700 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                            </svg>
                                            {{ $permission->name }}
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Status Card -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Account Status</h3>
                
                <div class="space-y-3">
                    <div>
                        <p class="text-sm text-gray-600 mb-2">Email Status:</p>
                        @if($user->email_verified_at)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-[#DDEECD] text-gray-700">
                                ✓ Verified
                            </span>
                            <p class="text-xs text-gray-500 mt-1">
                                {{ $user->email_verified_at->format('M d, Y H:i') }}
                            </p>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-200 text-gray-600">
                                ✗ Not Verified
                            </span>
                        @endif
                    </div>

                    <div>
                        <p class="text-sm text-gray-600 mb-2">Admin Status:</p>
                        @if($user->is_admin)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-700 text-white">
                                🔑 Admin
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-600">
                                Regular User
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Quick Actions</h3>
                
                <div class="space-y-2">
                    <a href="{{ route('admin.users.edit', $user) }}" 
                       class="block px-4 py-2 bg-[#DDEECD] text-gray-800 rounded-lg hover:bg-[#DDEECD]/80 transition text-sm text-center font-medium">
                        Edit User
                    </a>

                    @if(!$user->email_verified_at)
                        <form action="{{ route('admin.users.verify-email', $user) }}" method="POST">
                            @csrf
                            <button type="submit" 
                                    class="w-full px-4 py-2 bg-[#E6FF4B] text-gray-800 rounded-lg hover:bg-[#E6FF4B]/80 transition text-sm font-medium">
                                Verify Email
                            </button>
                        </form>
                    @endif

                    @if($user->id !== auth()->id())
                        <form action="{{ route('admin.users.toggle-status', $user) }}" method="POST">
                            @csrf
                            <button type="submit" 
                                    class="w-full px-4 py-2 {{ $user->email_verified_at ? 'bg-gray-200 text-gray-700 hover:bg-gray-300' : 'bg-[#DDEECD] text-gray-800 hover:bg-[#DDEECD]/80' }} rounded-lg transition text-sm font-medium">
                                {{ $user->email_verified_at ? 'Suspend User' : 'Activate User' }}
                            </button>
                        </form>

                        <form action="{{ route('admin.users.toggle-admin', $user) }}" method="POST">
                            @csrf
                            <button type="submit" 
                                    class="w-full px-4 py-2 bg-gray-700 text-white rounded-lg hover:bg-gray-800 transition text-sm font-medium">
                                {{ $user->is_admin ? 'Remove Admin' : 'Make Admin' }}
                            </button>
                        </form>

                        <form action="{{ route('admin.users.destroy', $user) }}" 
                              method="POST" 
                              onsubmit="return confirm('Are you sure you want to delete this user?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="w-full px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition text-sm font-medium">
                                Delete User
                            </button>
                        </form>
                    @else
                        <div class="px-4 py-2 bg-gray-50 text-gray-500 rounded-lg text-sm text-center">
                            You cannot perform actions on your own account
                        </div>
                    @endif
                </div>
            </div>

            <!-- Activity Summary -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Activity Summary</h3>
                
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Account Created:</span>
                        <span class="font-medium text-gray-800">{{ $user->created_at->diffForHumans() }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Last Updated:</span>
                        <span class="font-medium text-gray-800">{{ $user->updated_at->diffForHumans() }}</span>
                    </div>
                    @if($user->email_verified_at)
                        <div class="flex justify-between">
                            <span class="text-gray-600">Email Verified:</span>
                            <span class="font-medium text-gray-800">{{ $user->email_verified_at->diffForHumans() }}</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection