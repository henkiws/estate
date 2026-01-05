@extends('layouts.admin')

@section('title', 'Create Notification')

@section('content')
<div class="py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="flex items-center gap-4 mb-8">
            <a href="{{ route('admin.notifications.index') }}" 
               class="p-2 hover:bg-[#DDEECD] rounded-lg transition-colors">
                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Create Notification</h1>
                <p class="mt-2 text-gray-600">Send notifications to users, agencies, or agents</p>
            </div>
        </div>

        <!-- Form -->
        <form action="{{ route('admin.notifications.store') }}" method="POST" class="space-y-6">
            @csrf
            
            <!-- Basic Information -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-6 pb-4 border-b border-gray-200">
                    Basic Information
                </h2>
                
                <!-- Title -->
                <div class="mb-6">
                    <label for="title" class="block text-sm font-semibold text-gray-700 mb-2">
                        Title <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="title" 
                        name="title" 
                        value="{{ old('title') }}"
                        required
                        maxlength="255"
                        placeholder="e.g., System Maintenance Notice"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#5E17EB] focus:border-transparent @error('title') border-red-500 @enderror"
                    >
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Message -->
                <div class="mb-6">
                    <label for="message" class="block text-sm font-semibold text-gray-700 mb-2">
                        Message <span class="text-red-500">*</span>
                    </label>
                    <textarea 
                        id="message" 
                        name="message" 
                        rows="5"
                        required
                        placeholder="Write your notification message here..."
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#5E17EB] focus:border-transparent @error('message') border-red-500 @enderror"
                    >{{ old('message') }}</textarea>
                    @error('message')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Be clear and concise in your message.</p>
                </div>
                
                <!-- Category & Priority -->
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label for="category" class="block text-sm font-semibold text-gray-700 mb-2">
                            Category <span class="text-red-500">*</span>
                        </label>
                        <select 
                            id="category" 
                            name="category" 
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#5E17EB] focus:border-transparent @error('category') border-red-500 @enderror"
                        >
                            <option value="">Select Category</option>
                            <option value="general" {{ old('category') === 'general' ? 'selected' : '' }}>General</option>
                            <option value="payment" {{ old('category') === 'payment' ? 'selected' : '' }}>Payment</option>
                            <option value="approval" {{ old('category') === 'approval' ? 'selected' : '' }}>Approval</option>
                            <option value="document" {{ old('category') === 'document' ? 'selected' : '' }}>Document</option>
                            <option value="support" {{ old('category') === 'support' ? 'selected' : '' }}>Support</option>
                            <option value="subscription" {{ old('category') === 'subscription' ? 'selected' : '' }}>Subscription</option>
                            <option value="maintenance" {{ old('category') === 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                        </select>
                        @error('category')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="priority" class="block text-sm font-semibold text-gray-700 mb-2">
                            Priority <span class="text-red-500">*</span>
                        </label>
                        <select 
                            id="priority" 
                            name="priority" 
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#5E17EB] focus:border-transparent @error('priority') border-red-500 @enderror"
                        >
                            <option value="">Select Priority</option>
                            <option value="low" {{ old('priority') === 'low' ? 'selected' : '' }}>Low</option>
                            <option value="medium" {{ old('priority') === 'medium' ? 'selected' : '' }} selected>Medium</option>
                            <option value="high" {{ old('priority') === 'high' ? 'selected' : '' }}>High</option>
                        </select>
                        @error('priority')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            
            <!-- Recipients -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-6 pb-4 border-b border-gray-200">
                    Recipients
                </h2>
                
                <!-- Target Type -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-3">
                        Who should receive this notification? <span class="text-red-500">*</span>
                    </label>
                    <div class="space-y-3">
                        <label class="flex items-start p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-[#5E17EB] transition has-[:checked]:border-[#5E17EB] has-[:checked]:bg-[#5E17EB]/5">
                            <input 
                                type="radio" 
                                name="target_type" 
                                value="all" 
                                {{ old('target_type') === 'all' ? 'checked' : '' }}
                                class="mt-1 text-[#5E17EB] focus:ring-[#5E17EB]"
                                onchange="toggleSpecificUsers(false)"
                            >
                            <div class="ml-3">
                                <span class="font-semibold text-gray-900">All Users</span>
                                <p class="text-sm text-gray-600 mt-1">Send to all users, agencies, and agents</p>
                            </div>
                        </label>
                        
                        <label class="flex items-start p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-[#5E17EB] transition has-[:checked]:border-[#5E17EB] has-[:checked]:bg-[#5E17EB]/5">
                            <input 
                                type="radio" 
                                name="target_type" 
                                value="all_users" 
                                {{ old('target_type') === 'all_users' ? 'checked' : '' }}
                                class="mt-1 text-[#5E17EB] focus:ring-[#5E17EB]"
                                onchange="toggleSpecificUsers(false)"
                            >
                            <div class="ml-3">
                                <span class="font-semibold text-gray-900">All Regular Users</span>
                                <p class="text-sm text-gray-600 mt-1">Send to all property seekers/tenants only</p>
                            </div>
                        </label>
                        
                        <label class="flex items-start p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-[#5E17EB] transition has-[:checked]:border-[#5E17EB] has-[:checked]:bg-[#5E17EB]/5">
                            <input 
                                type="radio" 
                                name="target_type" 
                                value="all_agencies" 
                                {{ old('target_type') === 'all_agencies' ? 'checked' : '' }}
                                class="mt-1 text-[#5E17EB] focus:ring-[#5E17EB]"
                                onchange="toggleSpecificUsers(false)"
                            >
                            <div class="ml-3">
                                <span class="font-semibold text-gray-900">All Agencies</span>
                                <p class="text-sm text-gray-600 mt-1">Send to all agency accounts</p>
                            </div>
                        </label>
                        
                        <label class="flex items-start p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-[#5E17EB] transition has-[:checked]:border-[#5E17EB] has-[:checked]:bg-[#5E17EB]/5">
                            <input 
                                type="radio" 
                                name="target_type" 
                                value="all_agents" 
                                {{ old('target_type') === 'all_agents' ? 'checked' : '' }}
                                class="mt-1 text-[#5E17EB] focus:ring-[#5E17EB]"
                                onchange="toggleSpecificUsers(false)"
                            >
                            <div class="ml-3">
                                <span class="font-semibold text-gray-900">All Agents</span>
                                <p class="text-sm text-gray-600 mt-1">Send to all agent accounts</p>
                            </div>
                        </label>
                        
                        <label class="flex items-start p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-[#5E17EB] transition has-[:checked]:border-[#5E17EB] has-[:checked]:bg-[#5E17EB]/5">
                            <input 
                                type="radio" 
                                name="target_type" 
                                value="specific" 
                                {{ old('target_type') === 'specific' ? 'checked' : '' }}
                                class="mt-1 text-[#5E17EB] focus:ring-[#5E17EB]"
                                onchange="toggleSpecificUsers(true)"
                            >
                            <div class="ml-3">
                                <span class="font-semibold text-gray-900">Specific Users</span>
                                <p class="text-sm text-gray-600 mt-1">Choose specific users to notify</p>
                            </div>
                        </label>
                    </div>
                    @error('target_type')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Specific Users Select -->
                <div id="specificUsersContainer" class="hidden">
                    <label for="specific_users" class="block text-sm font-semibold text-gray-700 mb-2">
                        Select Users <span class="text-red-500">*</span>
                    </label>
                    <select 
                        id="specific_users" 
                        name="specific_users[]" 
                        multiple
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#5E17EB] focus:border-transparent"
                        style="height: 200px;"
                    >
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ collect(old('specific_users'))->contains($user->id) ? 'selected' : '' }}>
                                {{ $user->name }} ({{ $user->email }}) - {{ ucfirst($user->role) }}
                            </option>
                        @endforeach
                    </select>
                    @error('specific_users')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Hold Ctrl (Windows) or Cmd (Mac) to select multiple users</p>
                </div>
            </div>
            
            <!-- Action Link (Optional) -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-6 pb-4 border-b border-gray-200">
                    Action Link (Optional)
                </h2>
                
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label for="action_url" class="block text-sm font-semibold text-gray-700 mb-2">
                            Action URL
                        </label>
                        <input 
                            type="url" 
                            id="action_url" 
                            name="action_url" 
                            value="{{ old('action_url') }}"
                            placeholder="https://example.com/page"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#5E17EB] focus:border-transparent @error('action_url') border-red-500 @enderror"
                        >
                        @error('action_url')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="action_text" class="block text-sm font-semibold text-gray-700 mb-2">
                            Button Text
                        </label>
                        <input 
                            type="text" 
                            id="action_text" 
                            name="action_text" 
                            value="{{ old('action_text') }}"
                            maxlength="50"
                            placeholder="e.g., View Details, Learn More"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#5E17EB] focus:border-transparent @error('action_text') border-red-500 @enderror"
                        >
                        @error('action_text')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <p class="mt-3 text-xs text-gray-500">
                    Add a link to direct users to a specific page (e.g., a payment page, document page, etc.)
                </p>
            </div>
            
            <!-- Schedule (Optional) -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-6 pb-4 border-b border-gray-200">
                    Schedule (Optional)
                </h2>
                
                <div class="flex items-start gap-3 mb-4">
                    <input 
                        type="checkbox" 
                        id="schedule" 
                        name="schedule" 
                        value="1"
                        {{ old('schedule') ? 'checked' : '' }}
                        class="mt-1 text-[#5E17EB] focus:ring-[#5E17EB] rounded"
                        onchange="toggleSchedule(this.checked)"
                    >
                    <div>
                        <label for="schedule" class="font-semibold text-gray-900 cursor-pointer">
                            Schedule this notification for later
                        </label>
                        <p class="text-sm text-gray-600 mt-1">Choose a future date and time to send this notification</p>
                    </div>
                </div>
                
                <div id="scheduleContainer" class="hidden">
                    <label for="scheduled_for" class="block text-sm font-semibold text-gray-700 mb-2">
                        Schedule Date & Time <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="datetime-local" 
                        id="scheduled_for" 
                        name="scheduled_for" 
                        value="{{ old('scheduled_for') }}"
                        min="{{ now()->addMinutes(5)->format('Y-m-d\TH:i') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#5E17EB] focus:border-transparent @error('scheduled_for') border-red-500 @enderror"
                    >
                    @error('scheduled_for')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Notification must be scheduled at least 5 minutes in the future</p>
                </div>
            </div>
            
            <!-- Actions -->
            <div class="flex items-center justify-end gap-3 pt-6">
                <a href="{{ route('admin.notifications.index') }}" 
                   class="px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 transition">
                    Cancel
                </a>
                <button 
                    type="submit" 
                    class="px-6 py-3 bg-[#DDEECD] text-gray-800 font-semibold rounded-lg hover:bg-[#DDEECD]/80 transition flex items-center gap-2"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                    </svg>
                    Send Notification
                </button>
            </div>
            
        </form>
        
    </div>
</div>

<script>
function toggleSpecificUsers(show) {
    const container = document.getElementById('specificUsersContainer');
    const select = document.getElementById('specific_users');
    
    if (show) {
        container.classList.remove('hidden');
        select.required = true;
    } else {
        container.classList.add('hidden');
        select.required = false;
    }
}

function toggleSchedule(checked) {
    const container = document.getElementById('scheduleContainer');
    const input = document.getElementById('scheduled_for');
    
    if (checked) {
        container.classList.remove('hidden');
        input.required = true;
    } else {
        container.classList.add('hidden');
        input.required = false;
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    const specificRadio = document.querySelector('input[name="target_type"][value="specific"]');
    const scheduleCheckbox = document.getElementById('schedule');
    
    if (specificRadio && specificRadio.checked) {
        toggleSpecificUsers(true);
    }
    
    if (scheduleCheckbox && scheduleCheckbox.checked) {
        toggleSchedule(true);
    }
});
</script>
@endsection