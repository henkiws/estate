@extends('layouts.admin')

@section('title', 'Edit User')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <a href="{{ route('admin.users.show', $user) }}" class="text-gray-700 hover:text-gray-800 mb-2 inline-block font-medium">
                ← Back to User Details
            </a>
            <h1 class="text-3xl font-bold text-gray-800">Edit User</h1>
            <p class="text-gray-600 mt-1">{{ $user->name }} ({{ $user->email }})</p>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 bg-[#DDEECD]/30 border border-[#DDEECD] text-gray-800 px-4 py-3 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-6 bg-gray-100 border border-gray-400 text-gray-700 px-4 py-3 rounded-lg">
            <p class="font-semibold mb-2">Please fix the following errors:</p>
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.users.update', $user) }}" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Form -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Basic Information -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Basic Information</h2>
                    
                    <div class="space-y-4">
                        <!-- Name -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Full Name <span class="text-gray-500">*</span>
                            </label>
                            <input type="text" 
                                   name="name" 
                                   value="{{ old('name', $user->name) }}"
                                   required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#DDEECD] focus:border-[#DDEECD] hover:border-[#DDEECD]/50 transition-colors @error('name') border-gray-500 @enderror">
                            @error('name')
                                <p class="text-gray-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Email Address <span class="text-gray-500">*</span>
                            </label>
                            <input type="email" 
                                   name="email" 
                                   value="{{ old('email', $user->email) }}"
                                   required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#DDEECD] focus:border-[#DDEECD] hover:border-[#DDEECD]/50 transition-colors @error('email') border-gray-500 @enderror">
                            @error('email')
                                <p class="text-gray-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Password Change -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Change Password</h2>
                    <p class="text-sm text-gray-600 mb-4">Leave blank to keep current password</p>
                    
                    <div class="space-y-4">
                        <!-- New Password -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                New Password <span class="text-gray-400">(Optional)</span>
                            </label>
                            <input type="password" 
                                   name="password" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#DDEECD] focus:border-[#DDEECD] hover:border-[#DDEECD]/50 transition-colors @error('password') border-gray-500 @enderror"
                                   placeholder="Minimum 8 characters">
                            @error('password')
                                <p class="text-gray-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Confirm New Password
                            </label>
                            <input type="password" 
                                   name="password_confirmation" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#DDEECD] focus:border-[#DDEECD] hover:border-[#DDEECD]/50 transition-colors"
                                   placeholder="Re-enter new password">
                        </div>
                    </div>
                </div>

                <!-- Role & Agency -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Role & Agency</h2>
                    
                    <div class="space-y-4">
                        <!-- Role -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Role <span class="text-gray-500">*</span>
                            </label>
                            <select name="role" 
                                    required
                                    id="roleSelect"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#DDEECD] focus:border-[#DDEECD] hover:border-[#DDEECD]/50 bg-white transition-colors @error('role') border-gray-500 @enderror">
                                @foreach($roles as $role)
                                    <option value="{{ $role->name }}" 
                                            {{ (old('role', $user->roles->first()->name ?? '') == $role->name) ? 'selected' : '' }}>
                                        {{ ucfirst($role->name) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('role')
                                <p class="text-gray-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-sm text-gray-500 mt-1">
                                Current role: <strong>{{ $user->roles->first()->name ?? 'None' }}</strong>
                            </p>
                        </div>

                        <!-- Agency -->
                        <div id="agencyField">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Agency <span class="text-gray-400">(Optional)</span>
                            </label>
                            <select name="agency_id" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#DDEECD] focus:border-[#DDEECD] hover:border-[#DDEECD]/50 bg-white transition-colors @error('agency_id') border-gray-500 @enderror">
                                <option value="">No agency</option>
                                @foreach($agencies as $agency)
                                    <option value="{{ $agency->id }}" 
                                            {{ (old('agency_id', $user->agency_id) == $agency->id) ? 'selected' : '' }}>
                                        {{ $agency->agency_name }} - {{ $agency->state }}
                                    </option>
                                @endforeach
                            </select>
                            @error('agency_id')
                                <p class="text-gray-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                            @if($user->agency)
                                <p class="text-sm text-gray-500 mt-1">
                                    Current agency: <strong>{{ $user->agency->agency_name }}</strong>
                                </p>
                            @endif
                        </div>

                        <!-- Admin Status -->
                        @if($user->id !== auth()->id())
                            <div class="pt-4 border-t">
                                <label class="flex items-center cursor-pointer">
                                    <input type="checkbox" 
                                           name="is_admin" 
                                           value="1"
                                           {{ old('is_admin', $user->is_admin) ? 'checked' : '' }}
                                           class="w-5 h-5 text-gray-700 rounded border-gray-300 focus:ring-2 focus:ring-[#DDEECD]">
                                    <span class="ml-3">
                                        <span class="text-sm font-medium text-gray-800">Grant Admin Access</span>
                                        <span class="block text-sm text-gray-500">User will have full system access</span>
                                    </span>
                                </label>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Contact Information -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Contact Information</h2>
                    
                    <div class="space-y-4">
                        <!-- Phone -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Phone Number <span class="text-gray-400">(Optional)</span>
                            </label>
                            <input type="tel" 
                                   name="phone" 
                                   value="{{ old('phone', $user->phone) }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#DDEECD] focus:border-[#DDEECD] hover:border-[#DDEECD]/50 transition-colors @error('phone') border-gray-500 @enderror">
                            @error('phone')
                                <p class="text-gray-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Position -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Position/Title <span class="text-gray-400">(Optional)</span>
                            </label>
                            <input type="text" 
                                   name="position" 
                                   value="{{ old('position', $user->position) }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#DDEECD] focus:border-[#DDEECD] hover:border-[#DDEECD]/50 transition-colors @error('position') border-gray-500 @enderror">
                            @error('position')
                                <p class="text-gray-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="flex gap-4">
                    <button type="submit" 
                            class="px-6 py-3 bg-[#E6FF4B] text-gray-800 font-semibold rounded-lg hover:bg-[#E6FF4B]/80 transition-colors shadow-lg">
                        Save Changes
                    </button>
                    <a href="{{ route('admin.users.show', $user) }}" 
                       class="px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 transition-colors">
                        Cancel
                    </a>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Current Status -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Current Status</h3>
                    
                    <div class="space-y-3">
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Account Status:</p>
                            @if($user->email_verified_at)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-[#DDEECD] text-gray-700">
                                    ✓ Active
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-200 text-gray-600">
                                    ✗ Inactive
                                </span>
                            @endif
                        </div>

                        <div>
                            <p class="text-sm text-gray-600 mb-1">Current Role:</p>
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
                        </div>

                        @if($user->is_admin)
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Admin Access:</p>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-700 text-white">
                                    🔑 Enabled
                                </span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- User Metadata -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">User Information</h3>
                    
                    <div class="space-y-3 text-sm">
                        <div>
                            <p class="text-gray-600">User ID:</p>
                            <p class="font-medium text-gray-800">{{ $user->id }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600">Created:</p>
                            <p class="font-medium text-gray-800">{{ $user->created_at->format('M d, Y H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600">Last Updated:</p>
                            <p class="font-medium text-gray-800">{{ $user->updated_at->format('M d, Y H:i') }}</p>
                        </div>
                        @if($user->email_verified_at)
                            <div>
                                <p class="text-gray-600">Email Verified:</p>
                                <p class="font-medium text-gray-800">{{ $user->email_verified_at->format('M d, Y H:i') }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Warning -->
                @if($user->id === auth()->id())
                    <div class="bg-[#E6FF4B]/30 border border-[#E6FF4B] rounded-lg p-4">
                        <div class="flex">
                            <svg class="w-5 h-5 text-gray-700 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            <div>
                                <p class="text-sm font-medium text-gray-800">Editing Your Own Account</p>
                                <p class="text-sm text-gray-700 mt-1">Be careful when changing your own email or role.</p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Quick Actions -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Quick Actions</h3>
                    
                    <div class="space-y-2">
                        <a href="{{ route('admin.users.show', $user) }}" 
                           class="block px-4 py-2 bg-[#DDEECD] text-gray-800 rounded-lg hover:bg-[#DDEECD]/80 transition text-sm text-center font-medium">
                            View User Details
                        </a>
                        <a href="{{ route('admin.users.index') }}" 
                           class="block px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition text-sm text-center font-medium">
                            Back to Users List
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
// Show/hide agency field based on role selection
document.getElementById('roleSelect').addEventListener('change', function() {
    const agencyField = document.getElementById('agencyField');
    if (this.value === 'admin') {
        agencyField.style.display = 'none';
    } else {
        agencyField.style.display = 'block';
    }
});

// Trigger on page load
window.addEventListener('DOMContentLoaded', function() {
    const roleSelect = document.getElementById('roleSelect');
    if (roleSelect.value === 'admin') {
        document.getElementById('agencyField').style.display = 'none';
    }
});
</script>
@endsection