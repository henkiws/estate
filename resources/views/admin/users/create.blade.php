@extends('layouts.admin')

@section('title', 'Create New User')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <a href="{{ route('admin.users.index') }}" class="text-gray-700 hover:text-gray-800 mb-2 inline-block font-medium">
                ← Back to Users
            </a>
            <h1 class="text-3xl font-bold text-gray-800">Create New User</h1>
            <p class="text-gray-600 mt-1">Add a new user to the system</p>
        </div>
    </div>

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

    <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-6">
        @csrf

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
                                   value="{{ old('name') }}"
                                   required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#DDEECD] focus:border-[#DDEECD] hover:border-[#DDEECD]/50 transition-colors @error('name') border-gray-500 @enderror"
                                   placeholder="John Doe">
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
                                   value="{{ old('email') }}"
                                   required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#DDEECD] focus:border-[#DDEECD] hover:border-[#DDEECD]/50 transition-colors @error('email') border-gray-500 @enderror"
                                   placeholder="john@example.com">
                            @error('email')
                                <p class="text-gray-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Password <span class="text-gray-500">*</span>
                            </label>
                            <input type="password" 
                                   name="password" 
                                   required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#DDEECD] focus:border-[#DDEECD] hover:border-[#DDEECD]/50 transition-colors @error('password') border-gray-500 @enderror"
                                   placeholder="Minimum 8 characters">
                            @error('password')
                                <p class="text-gray-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-sm text-gray-500 mt-1">Must be at least 8 characters long</p>
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Confirm Password <span class="text-gray-500">*</span>
                            </label>
                            <input type="password" 
                                   name="password_confirmation" 
                                   required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#DDEECD] focus:border-[#DDEECD] hover:border-[#DDEECD]/50 transition-colors"
                                   placeholder="Re-enter password">
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
                                <option value="">Select a role</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->name }}" {{ old('role') == $role->name ? 'selected' : '' }}>
                                        {{ ucfirst($role->name) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('role')
                                <p class="text-gray-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-sm text-gray-500 mt-1">Determines user permissions and access level</p>
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
                                    <option value="{{ $agency->id }}" {{ old('agency_id') == $agency->id ? 'selected' : '' }}>
                                        {{ $agency->agency_name }} - {{ $agency->state }}
                                    </option>
                                @endforeach
                            </select>
                            @error('agency_id')
                                <p class="text-gray-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-sm text-gray-500 mt-1">Assign user to an agency</p>
                        </div>
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
                                   value="{{ old('phone') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#DDEECD] focus:border-[#DDEECD] hover:border-[#DDEECD]/50 transition-colors @error('phone') border-gray-500 @enderror"
                                   placeholder="+61 123 456 789">
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
                                   value="{{ old('position') }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#DDEECD] focus:border-[#DDEECD] hover:border-[#DDEECD]/50 transition-colors @error('position') border-gray-500 @enderror"
                                   placeholder="e.g., Sales Manager, Property Agent">
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
                        Create User
                    </button>
                    <a href="{{ route('admin.users.index') }}" 
                       class="px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 transition-colors">
                        Cancel
                    </a>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Help Card -->
                <div class="bg-[#DDEECD]/30 border border-[#DDEECD] rounded-lg p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-3">📝 Creating a User</h3>
                    <div class="space-y-2 text-sm text-gray-700">
                        <p>• Users will be created with verified email status</p>
                        <p>• They can log in immediately with the provided credentials</p>
                        <p>• Role determines their access level</p>
                        <p>• Agency assignment is optional</p>
                        <p>• You can edit user details later</p>
                    </div>
                </div>

                <!-- Role Guide -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-3">Role Permissions</h3>
                    
                    <div class="space-y-4 text-sm">
                        <div>
                            <p class="font-semibold text-gray-700 mb-1">Admin</p>
                            <p class="text-gray-600">Full system access, can manage all users, agencies, and properties</p>
                        </div>
                        
                        <div>
                            <p class="font-semibold text-gray-700 mb-1">Agency</p>
                            <p class="text-gray-600">Manage own agency, agents, and properties</p>
                        </div>
                        
                        <div>
                            <p class="font-semibold text-gray-700 mb-1">Agent</p>
                            <p class="text-gray-600">Manage assigned properties and view agency data</p>
                        </div>
                    </div>
                </div>

                <!-- Password Requirements -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-3">Password Requirements</h3>
                    
                    <ul class="space-y-2 text-sm text-gray-600">
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-gray-700 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            Minimum 8 characters
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-gray-700 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            Mix of letters and numbers recommended
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-gray-700 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            Avoid common passwords
                        </li>
                    </ul>
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

// Trigger on page load if role is pre-selected
window.addEventListener('DOMContentLoaded', function() {
    const roleSelect = document.getElementById('roleSelect');
    if (roleSelect.value === 'admin') {
        document.getElementById('agencyField').style.display = 'none';
    }
});
</script>
@endsection