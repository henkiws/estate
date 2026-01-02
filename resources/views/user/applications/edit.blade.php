@extends('layouts.user')

@section('title', 'Edit Application')

@section('content')
<div class="py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Edit Application</h1>
        <p class="text-gray-600 mb-8">Update your application details below</p>
        
        <!-- Success Message -->
        @if(session('success'))
            <div class="mb-6 bg-green-50 border-2 border-green-500 text-green-700 px-4 py-3 rounded-xl flex items-center gap-2 animate-fade-in">
                <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                <span>{{ session('success') }}</span>
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
        @if($application->property)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
                <h2 class="font-bold text-gray-900 mb-4">Property:</h2>
                <div class="flex items-start gap-4">
                    @if($application->property->floorplan_path && Storage::disk('public')->exists($application->property->floorplan_path))
                        <img 
                            src="{{ Storage::url($application->property->floorplan_path) }}" 
                            alt="{{ $application->property->title }}"
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
                        <h3 class="font-bold text-lg">{{ $application->property->title ?? $application->property->street_address }}</h3>
                        <p class="text-gray-600">{{ $application->property->suburb }}, {{ $application->property->state }} {{ $application->property->postcode }}</p>
                        @if($application->property->listing_type === 'rent')
                            <p class="text-teal-600 font-bold mt-2">${{ number_format($application->property->rent_amount) }}/{{ $application->property->rent_period }}</p>
                        @else
                            <p class="text-teal-600 font-bold mt-2">${{ number_format($application->property->sale_price) }}</p>
                        @endif
                    </div>
                </div>
            </div>
        @endif
        
        <!-- Application Form -->
        <form method="POST" action="{{ route('user.applications.update', $application) }}" id="application-form">
            @csrf
            @method('PUT')
            
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
                            value="{{ old('move_in_date', $application->move_in_date->format('Y-m-d')) }}"
                            min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                            requiredf
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
                                <option value="{{ $i }}" {{ old('lease_term', $application->lease_term) == $i ? 'selected' : '' }}>
                                    {{ $i }} {{ $i === 1 ? 'month' : 'months' }}
                                </option>
                            @endfor
                        </select>
                        @error('lease_term')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
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
                        value="{{ old('number_of_occupants', $application->number_of_occupants) }}"
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
            
            <!-- Occupants Details -->
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
                    >{{ old('special_requests', $application->special_requests) }}</textarea>
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
                    >{{ old('notes', $application->notes) }}</textarea>
                    @error('notes')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
            </x-form-section-card>
            
            <!-- Submit Buttons -->
            <div class="flex items-center justify-between mt-6">
                <a 
                    href="{{ route('user.applications.show', $application) }}" 
                    class="px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 transition"
                >
                    Cancel
                </a>
                
                <div class="flex gap-3">
                    @if($application->status === 'draft')
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
                    @endif
                    
                    <button 
                        type="submit" 
                        onclick="setSubmitType('submit')"
                        class="px-8 py-3 bg-teal-600 text-white font-semibold rounded-lg hover:bg-teal-700 transition shadow-sm disabled:opacity-50 disabled:cursor-not-allowed"
                        id="submit-btn"
                    >
                        <span class="flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            {{ $application->status === 'draft' ? 'Submit Application' : 'Update Application' }}
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
let currentSubmitType = 'submit';

// Get existing occupants data from server
const existingOccupants = @json(old('occupants_details', $application->occupants_details ?? []));

function setSubmitType(type) {
    currentSubmitType = type;
    document.getElementById('submit_type_input').value = type;
}

function updateOccupantsFields(count) {
    const container = document.getElementById('occupants-container');
    const section = document.getElementById('occupants-section');
    
    count = parseInt(count) || 0;
    
    if (count >= 1) {
        section.classList.remove('hidden');
    } else {
        section.classList.add('hidden');
        return;
    }
    
    container.innerHTML = '';
    
    for (let i = 0; i < count; i++) {
        const occupantNumber = i + 1;
        const isPrimary = i === 0;
        const existingData = existingOccupants[i] || {};
        
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
                            value="${escapeHtml(existingData.first_name || '')}"
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
                            value="${escapeHtml(existingData.last_name || '')}"
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
                            value="${isPrimary ? 'Primary Applicant' : escapeHtml(existingData.relationship || '')}"
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
                            value="${existingData.age || ''}"
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
                            value="${escapeHtml(existingData.email || '{{ auth()->user()->email }}')}"
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

function escapeHtml(text) {
    const map = {
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#039;'
    };
    return String(text).replace(/[&<>"']/g, m => map[m]);
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    const occupantsInput = document.querySelector('input[name="number_of_occupants"]');
    if (occupantsInput && occupantsInput.value >= 1) {
        updateOccupantsFields(occupantsInput.value);
    }
    
    const form = document.getElementById('application-form');
    const submitBtn = document.getElementById('submit-btn');
    const draftBtn = document.getElementById('draft-btn');
    
    form.addEventListener('submit', function(e) {
        submitBtn.disabled = true;
        if (draftBtn) draftBtn.disabled = true;
        
        if (currentSubmitType === 'submit') {
            submitBtn.innerHTML = '<span class="flex items-center gap-2"><svg class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Updating...</span>';
        } else if (draftBtn) {
            draftBtn.innerHTML = '<span class="flex items-center gap-2"><svg class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Saving...</span>';
        }
    });
    
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