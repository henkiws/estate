@extends('layouts.user')

@section('title', 'New Application')

@section('content')
<div class="py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <h1 class="text-3xl font-bold text-gray-900 mb-2">New Rental Application</h1>
        <p class="text-gray-600 mb-8">Complete the form below to apply for this property</p>
        
        <!-- Success Message -->
        @if(session('success'))
            <div class="mb-6 bg-green-50 border-2 border-green-500 text-green-700 px-4 py-3 rounded-xl flex items-center gap-2 animate-fade-in">
                <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- Info Message -->
        @if(session('info'))
            <div class="mb-6 bg-blue-50 border-2 border-blue-500 text-blue-700 px-4 py-3 rounded-xl flex items-center gap-2 animate-fade-in">
                <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                </svg>
                <span>{{ session('info') }}</span>
            </div>
        @endif

        <!-- Warning Message -->
        @if(session('warning'))
            <div class="mb-6 bg-yellow-50 border-2 border-yellow-500 text-yellow-700 px-4 py-3 rounded-xl flex items-center gap-2 animate-fade-in">
                <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
                <span>{{ session('warning') }}</span>
            </div>
        @endif

        <!-- Error Message -->
        @if(session('error'))
            <div class="mb-6 bg-red-50 border-2 border-red-500 text-red-700 px-4 py-3 rounded-xl flex items-center gap-2 animate-fade-in">
                <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <!-- Validation Errors -->
        @if($errors->any())
            <div class="mb-6 bg-red-50 border-2 border-red-500 text-red-700 px-4 py-3 rounded-xl animate-fade-in">
                <div class="flex items-center gap-2 mb-2">
                    <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                    </svg>
                    <strong class="font-semibold">Please fix the following errors:</strong>
                </div>
                <ul class="list-disc list-inside space-y-1 text-sm ml-7">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <!-- Property Preview -->
        @if($property)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
                <h2 class="font-bold text-gray-900 mb-4">Property You're Applying For:</h2>
                <div class="flex items-start gap-4">
                    @if($property->floorplan_path && Storage::disk('public')->exists($property->floorplan_path))
                        <img 
                            src="{{ Storage::url($property->floorplan_path) }}" 
                            alt="{{ $property->title }}"
                            class="w-32 h-32 object-cover rounded-lg"
                            onerror="this.onerror=null; this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'128\' height=\'128\' fill=\'%23e5e7eb\'%3E%3Crect width=\'128\' height=\'128\' fill=\'%23f3f4f6\'/%3E%3Ctext x=\'50%25\' y=\'50%25\' text-anchor=\'middle\' dy=\'.3em\' fill=\'%239ca3af\' font-size=\'14\' font-family=\'Arial\'%3ENo Image%3C/text%3E%3C/svg%3E';"
                        >
                    @else
                        <div class="w-32 h-32 bg-gray-100 rounded-lg flex items-center justify-center">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                    @endif
                    <div>
                        <h3 class="font-bold text-lg">{{ $property->title ?? $property->street_address }}</h3>
                        <p class="text-gray-600">{{ $property->suburb }}, {{ $property->state }} {{ $property->postcode }}</p>
                        @if($property->listing_type === 'rent')
                            <p class="text-teal-600 font-bold mt-2">${{ number_format($property->rent_amount) }}/{{ $property->rent_period }}</p>
                        @else
                            <p class="text-teal-600 font-bold mt-2">${{ number_format($property->sale_price) }}</p>
                        @endif
                    </div>
                </div>
            </div>
        @endif
        
        <!-- Application Form -->
        <form method="POST" action="{{ route('user.applications.store') }}" id="application-form">
            @csrf
            
            <input type="hidden" name="property_id" value="{{ $property->id }}">
            <input type="hidden" name="submit_type" id="submit_type_input" value="submit">
            
            <x-form-section-card title="Application Details" required>
    
                <div class="grid md:grid-cols-2 gap-4">
                    <!-- Move-in Date -->
                    <div>
                        <label class="flex items-center gap-2 text-sm font-medium text-gray-700 mb-2">
                            Desired Move-in Date <span class="text-red-500">*</span>
                            <x-profile-help-text text="When would you like to move in?" />
                        </label>
                        <input 
                            type="date" 
                            name="move_in_date" 
                            value="{{ old('move_in_date') }}"
                            min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 @error('move_in_date') border-red-500 @enderror"
                        >
                        @error('move_in_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Lease Term -->
                    <div>
                        <label class="flex items-center gap-2 text-sm font-medium text-gray-700 mb-2">
                            Lease Term <span class="text-red-500">*</span>
                            <x-profile-help-text text="How many months do you want to lease?" />
                        </label>
                        <select 
                            name="lease_term" 
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 @error('lease_term') border-red-500 @enderror"
                        >
                            <option value="">Select lease term</option>
                            @for($i = 1; $i <= 24; $i++)
                                <option value="{{ $i }}" {{ old('lease_term') == $i ? 'selected' : '' }}>
                                    {{ $i }} {{ $i === 1 ? 'month' : 'months' }}
                                </option>
                            @endfor
                        </select>
                        @error('lease_term')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <!-- Property Inspection -->
                <div>
                    <label class="flex items-center gap-2 text-sm font-medium text-gray-700 mb-3">
                        Have you inspected the property? <span class="text-red-500">*</span>
                        <x-profile-help-text text="Property managers value applicants who have inspected the property" />
                    </label>
                    
                    <div class="space-y-3">
                        <label class="flex items-start p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-teal-500 transition has-[:checked]:border-teal-500 has-[:checked]:bg-teal-50">
                            <input 
                                type="radio" 
                                name="property_inspection" 
                                value="yes" 
                                {{ old('property_inspection') === 'yes' ? 'checked' : '' }}
                                required
                                onchange="toggleInspectionDateField(true)"
                                class="mt-1 text-teal-600 focus:ring-teal-500"
                            >
                            <div class="ml-3">
                                <span class="font-semibold text-gray-900">Yes, I have or plan to inspect the property</span>
                                <p class="text-sm text-gray-600 mt-1">I have viewed the property or have an inspection scheduled</p>
                            </div>
                        </label>
                        
                        <label class="flex items-start p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-teal-500 transition has-[:checked]:border-teal-500 has-[:checked]:bg-teal-50">
                            <input 
                                type="radio" 
                                name="property_inspection" 
                                value="no" 
                                {{ old('property_inspection') === 'no' ? 'checked' : '' }}
                                required
                                onchange="toggleInspectionDateField(false)"
                                class="mt-1 text-teal-600 focus:ring-teal-500"
                            >
                            <div class="ml-3">
                                <span class="font-semibold text-gray-900">No, I accept the property as is</span>
                                <p class="text-sm text-gray-600 mt-1">I am comfortable proceeding without an in-person inspection</p>
                            </div>
                        </label>
                    </div>
                    
                    <!-- Inspection Date Field (conditional) -->
                    <div id="inspection-date-container" class="mt-4 hidden">
                        <div class="bg-teal-50 border-2 border-teal-200 rounded-lg p-4">
                            <label class="flex items-center gap-2 text-sm font-medium text-gray-700 mb-2">
                                When did you inspect this property? <span class="text-red-500">*</span>
                                <x-profile-help-text text="Provide the date of your inspection or scheduled inspection" />
                            </label>
                            <input 
                                type="date" 
                                name="inspection_date" 
                                id="inspection_date_input"
                                value="{{ old('inspection_date') }}"
                                max="{{ date('Y-m-d') }}"
                                class="w-full px-4 py-3 border border-teal-300 rounded-lg focus:ring-2 focus:ring-teal-500 @error('inspection_date') border-red-500 @enderror"
                            >
                            <p class="mt-1 text-xs text-gray-600">Select the date you inspected or will inspect the property</p>
                            @error('inspection_date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <!-- Info Message -->
                    <div class="mt-4 bg-blue-50 border-l-4 border-blue-400 p-4 rounded-lg">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-blue-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                            </svg>
                            <div class="ml-3">
                                <p class="text-sm text-blue-700">
                                    <strong class="font-semibold">Tip:</strong> Inspecting a property before applying can show property managers that you're serious about renting.
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    @error('property_inspection')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Number of Occupants -->
                <div>
                    <label class="flex items-center gap-2 text-sm font-medium text-gray-700 mb-2">
                        Number of Occupants <span class="text-red-500">*</span>
                        <x-profile-help-text text="Including yourself" />
                    </label>
                    <input 
                        type="number" 
                        name="number_of_occupants" 
                        value="{{ old('number_of_occupants', 1) }}"
                        min="1"
                        max="10"
                        required
                        onkeyup="updateOccupantsFields(this.value)"
                        onchange="updateOccupantsFields(this.value)"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 @error('number_of_occupants') border-red-500 @enderror"
                    >
                    @error('number_of_occupants')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
            </x-form-section-card>
            
            <!-- Additional Occupants -->
            <div id="occupants-section" class="hidden">
                <x-form-section-card title="Occupants Details" description="Provide details about all people who will be living in the property">
                    <div id="occupants-container"></div>
                </x-form-section-card>
            </div>
            
            <!-- Special Requests & Notes -->
            <x-form-section-card title="Additional Information">
                
                <div>
                    <label class="flex items-center gap-2 text-sm font-medium text-gray-700 mb-2">
                        Special Requests
                        <x-profile-help-text text="e.g., Pet accommodation, parking needs, early move-in" />
                    </label>
                    <textarea 
                        name="special_requests" 
                        rows="4"
                        maxlength="1000"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 @error('special_requests') border-red-500 @enderror"
                        placeholder="Any special requirements or requests..."
                    >{{ old('special_requests') }}</textarea>
                    <p class="mt-1 text-xs text-gray-500">Maximum 1000 characters</p>
                    @error('special_requests')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label class="flex items-center gap-2 text-sm font-medium text-gray-700 mb-2">
                        Additional Notes
                    </label>
                    <textarea 
                        name="notes" 
                        rows="3"
                        maxlength="1000"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 @error('notes') border-red-500 @enderror"
                        placeholder="Anything else you'd like the property manager to know..."
                    >{{ old('notes') }}</textarea>
                    @error('notes')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
            </x-form-section-card>
            
            <!-- Submit Buttons -->
            <div class="flex items-center justify-between mt-6">
                <a 
                    href="{{ route('user.dashboard') }}" 
                    class="px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 transition"
                >
                    Cancel
                </a>
                
                <div class="flex gap-3">
                    <button 
                        type="submit" 
                        onclick="setSubmitType('draft')"
                        class="px-6 py-3 bg-gray-600 text-white font-semibold rounded-lg hover:bg-gray-700 transition disabled:opacity-50 disabled:cursor-not-allowed"
                        id="draft-btn"
                    >
                        <span class="flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                            </svg>
                            Save as Draft
                        </span>
                    </button>
                    
                    <button 
                        type="submit" 
                        onclick="setSubmitType('submit')"
                        class="px-8 py-3 bg-teal-600 text-white font-semibold rounded-lg hover:bg-teal-700 transition shadow-sm disabled:opacity-50 disabled:cursor-not-allowed"
                        id="submit-btn"
                    >
                        <span class="flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Submit Application
                        </span>
                    </button>
                </div>
            </div>
            
        </form>
        
    </div>
</div>

<style>
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in {
    animation: fadeIn 0.3s ease-out;
}
</style>

<script>
let currentSubmitType = 'submit'; // Default to submit

function setSubmitType(type) {
    currentSubmitType = type;
    // Update hidden input
    document.getElementById('submit_type_input').value = type;
}

function updateOccupantsFields(count) {
    const container = document.getElementById('occupants-container');
    const section = document.getElementById('occupants-section');
    
    // Convert to number and validate
    count = parseInt(count) || 0;
    
    // Show section if count is at least 1
    if (count >= 1) {
        section.classList.remove('hidden');
    } else {
        section.classList.add('hidden');
        return;
    }
    
    // Clear existing
    container.innerHTML = '';
    
    // Create fields for ALL occupants (including yourself as Occupant 1)
    for (let i = 0; i < count; i++) {
        const occupantNumber = i + 1;
        const isPrimary = i === 0;
        
        const occupantFields = `
            <div class="p-4 border-2 ${isPrimary ? 'border-teal-200 bg-teal-50' : 'border-gray-200'} rounded-lg mb-4">
                <div class="flex items-center gap-2 mb-3">
                    <h4 class="font-semibold text-gray-900">
                        ${isPrimary ? '👤 Primary Applicant (You)' : `Occupant ${occupantNumber}`}
                    </h4>
                    ${isPrimary ? '<span class="text-xs bg-teal-600 text-white px-2 py-1 rounded-full">Primary</span>' : ''}
                </div>
                
                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm font-medium text-gray-700 mb-2 block">
                            First Name <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="occupants_details[${i}][first_name]" 
                            value="${getOldValue('occupants_details.' + i + '.first_name')}"
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500"
                            placeholder="${isPrimary ? 'Your first name' : 'First name'}"
                        >
                    </div>
                    
                    <div>
                        <label class="text-sm font-medium text-gray-700 mb-2 block">
                            Last Name <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="occupants_details[${i}][last_name]" 
                            value="${getOldValue('occupants_details.' + i + '.last_name')}"
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500"
                            placeholder="${isPrimary ? 'Your last name' : 'Last name'}"
                        >
                    </div>
                    
                    <div>
                        <label class="text-sm font-medium text-gray-700 mb-2 block">
                            Relationship <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="occupants_details[${i}][relationship]" 
                            value="${isPrimary ? 'Primary Applicant' : getOldValue('occupants_details.' + i + '.relationship')}"
                            ${isPrimary ? 'readonly' : 'required'}
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 ${isPrimary ? 'bg-gray-100' : ''}"
                            placeholder="${isPrimary ? 'Primary Applicant' : 'e.g., Partner, Child, Roommate'}"
                        >
                    </div>
                    
                    <div>
                        <label class="text-sm font-medium text-gray-700 mb-2 block">
                            Age ${isPrimary ? '<span class="text-red-500">*</span>' : '(Optional)'}
                        </label>
                        <input 
                            type="number" 
                            name="occupants_details[${i}][age]" 
                            value="${getOldValue('occupants_details.' + i + '.age')}"
                            min="${isPrimary ? '18' : '0'}"
                            max="120"
                            ${isPrimary ? 'required' : ''}
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500"
                            placeholder="${isPrimary ? 'Your age (must be 18+)' : 'Age'}"
                        >
                        ${isPrimary ? '<p class="text-xs text-gray-500 mt-1">Primary applicant must be 18 or older</p>' : ''}
                    </div>
                    
                    ${isPrimary ? `
                    <div class="md:col-span-2">
                        <label class="text-sm font-medium text-gray-700 mb-2 block">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="email" 
                            name="occupants_details[${i}][email]" 
                            value="{{ auth()->user()->email }}"
                            readonly
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-100"
                        >
                        <p class="text-xs text-gray-500 mt-1">From your account</p>
                    </div>
                    ` : ''}
                </div>
            </div>
        `;
        
        container.insertAdjacentHTML('beforeend', occupantFields);
    }
}

// Helper function to get old form values
function getOldValue(key) {
    // This would need to be populated from Laravel's old() helper
    // For now, return empty string
    return '';
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    const occupantsInput = document.querySelector('input[name="number_of_occupants"]');
    if (occupantsInput && occupantsInput.value >= 1) {
        updateOccupantsFields(occupantsInput.value);
    }
    
    // Prevent double submission
    const form = document.getElementById('application-form');
    const submitBtn = document.getElementById('submit-btn');
    const draftBtn = document.getElementById('draft-btn');
    
    form.addEventListener('submit', function(e) {
        // Don't prevent default - let form submit naturally
        
        // Disable both buttons to prevent double submission
        submitBtn.disabled = true;
        draftBtn.disabled = true;
        
        // Change button text to show loading based on which was clicked
        if (currentSubmitType === 'submit') {
            submitBtn.innerHTML = '<span class="flex items-center gap-2"><svg class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Submitting...</span>';
        } else {
            draftBtn.innerHTML = '<span class="flex items-center gap-2"><svg class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Saving...</span>';
        }
    });
    
    // Auto-dismiss alerts after 5 seconds
    const alerts = document.querySelectorAll('.animate-fade-in');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.transition = 'opacity 0.5s ease-out';
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 500);
        }, 5000);
    });
});
</script>

<script>
let currentSubmitType2 = 'submit'; // Default to submit

function setSubmitType(type) {
    currentSubmitType2 = type;
    // Update hidden input
    document.getElementById('submit_type_input').value = type;
}

// Toggle inspection date field
function toggleInspectionDateField(show) {
    const container = document.getElementById('inspection-date-container');
    const input = document.getElementById('inspection_date_input');
    
    if (show) {
        container.classList.remove('hidden');
        input.required = true;
    } else {
        container.classList.add('hidden');
        input.required = false;
        input.value = ''; // Clear the value when hidden
    }
}

function updateOccupantsFields(count) {
    const container = document.getElementById('occupants-container');
    const section = document.getElementById('occupants-section');
    
    // Convert to number and validate
    count = parseInt(count) || 0;
    
    // Show section if count is at least 1
    if (count >= 1) {
        section.classList.remove('hidden');
    } else {
        section.classList.add('hidden');
        return;
    }
    
    // Clear existing
    container.innerHTML = '';
    
    // Create fields for ALL occupants (including yourself as Occupant 1)
    for (let i = 0; i < count; i++) {
        const occupantNumber = i + 1;
        const isPrimary = i === 0;
        
        const occupantFields = `
            <div class="p-4 border-2 ${isPrimary ? 'border-teal-200 bg-teal-50' : 'border-gray-200'} rounded-lg mb-4">
                <div class="flex items-center gap-2 mb-3">
                    <h4 class="font-semibold text-gray-900">
                        ${isPrimary ? '👤 Primary Applicant (You)' : `Occupant ${occupantNumber}`}
                    </h4>
                    ${isPrimary ? '<span class="text-xs bg-teal-600 text-white px-2 py-1 rounded-full">Primary</span>' : ''}
                </div>
                
                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm font-medium text-gray-700 mb-2 block">
                            First Name <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="occupants_details[${i}][first_name]" 
                            value="${getOldValue('occupants_details.' + i + '.first_name')}"
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500"
                            placeholder="${isPrimary ? 'Your first name' : 'First name'}"
                        >
                    </div>
                    
                    <div>
                        <label class="text-sm font-medium text-gray-700 mb-2 block">
                            Last Name <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="occupants_details[${i}][last_name]" 
                            value="${getOldValue('occupants_details.' + i + '.last_name')}"
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500"
                            placeholder="${isPrimary ? 'Your last name' : 'Last name'}"
                        >
                    </div>
                    
                    <div>
                        <label class="text-sm font-medium text-gray-700 mb-2 block">
                            Relationship <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="occupants_details[${i}][relationship]" 
                            value="${isPrimary ? 'Primary Applicant' : getOldValue('occupants_details.' + i + '.relationship')}"
                            ${isPrimary ? 'readonly' : 'required'}
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 ${isPrimary ? 'bg-gray-100' : ''}"
                            placeholder="${isPrimary ? 'Primary Applicant' : 'e.g., Partner, Child, Roommate'}"
                        >
                    </div>
                    
                    <div>
                        <label class="text-sm font-medium text-gray-700 mb-2 block">
                            Age ${isPrimary ? '<span class="text-red-500">*</span>' : '(Optional)'}
                        </label>
                        <input 
                            type="number" 
                            name="occupants_details[${i}][age]" 
                            value="${getOldValue('occupants_details.' + i + '.age')}"
                            min="${isPrimary ? '18' : '0'}"
                            max="120"
                            ${isPrimary ? 'required' : ''}
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500"
                            placeholder="${isPrimary ? 'Your age (must be 18+)' : 'Age'}"
                        >
                        ${isPrimary ? '<p class="text-xs text-gray-500 mt-1">Primary applicant must be 18 or older</p>' : ''}
                    </div>
                    
                    ${isPrimary ? `
                    <div class="md:col-span-2">
                        <label class="text-sm font-medium text-gray-700 mb-2 block">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="email" 
                            name="occupants_details[${i}][email]" 
                            value="{{ auth()->user()->email }}"
                            readonly
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-100"
                        >
                        <p class="text-xs text-gray-500 mt-1">From your account</p>
                    </div>
                    ` : ''}
                </div>
            </div>
        `;
        
        container.insertAdjacentHTML('beforeend', occupantFields);
    }
}

// Helper function to get old form values
function getOldValue(key) {
    // This would need to be populated from Laravel's old() helper
    // For now, return empty string
    return '';
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    // Initialize occupants fields
    const occupantsInput = document.querySelector('input[name="number_of_occupants"]');
    if (occupantsInput && occupantsInput.value >= 1) {
        updateOccupantsFields(occupantsInput.value);
    }
    
    // Initialize inspection date field based on old value
    const inspectionYes = document.querySelector('input[name="property_inspection"][value="yes"]');
    if (inspectionYes && inspectionYes.checked) {
        toggleInspectionDateField(true);
    }
    
    // Prevent double submission
    const form = document.getElementById('application-form');
    const submitBtn = document.getElementById('submit-btn');
    const draftBtn = document.getElementById('draft-btn');
    
    form.addEventListener('submit', function(e) {
        // Don't prevent default - let form submit naturally
        
        // Disable both buttons to prevent double submission
        submitBtn.disabled = true;
        draftBtn.disabled = true;
        
        // Change button text to show loading based on which was clicked
        if (currentSubmitType2 === 'submit') {
            submitBtn.innerHTML = '<span class="flex items-center gap-2"><svg class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Submitting...</span>';
        } else {
            draftBtn.innerHTML = '<span class="flex items-center gap-2"><svg class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Saving...</span>';
        }
    });
    
    // Auto-dismiss alerts after 5 seconds
    const alerts = document.querySelectorAll('.animate-fade-in');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.transition = 'opacity 0.5s ease-out';
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 500);
        }, 5000);
    });
});
</script>
@endsection