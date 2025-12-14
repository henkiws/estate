@extends('layouts.user')

@section('title', 'New Application')

@section('content')
<div class="py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <h1 class="text-3xl font-bold text-gray-900 mb-2">New Rental Application</h1>
        <p class="text-gray-600 mb-8">Complete the form below to apply for this property</p>
        
        <!-- Property Preview -->
        @if($property)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
                <h2 class="font-bold text-gray-900 mb-4">Property You're Applying For:</h2>
                <div class="flex items-start gap-4">
                    @if($property->images->count() > 0)
                        <img 
                            src="{{ Storage::url($property->images->first()->image_path) }}" 
                            class="w-32 h-32 object-cover rounded-lg"
                        >
                    @endif
                    <div>
                        <h3 class="font-bold text-lg">{{ $property->address }}</h3>
                        <p class="text-gray-600">{{ $property->suburb }}, {{ $property->state }}</p>
                        <p class="text-teal-600 font-bold mt-2">${{ number_format($property->price_per_week) }}/week</p>
                    </div>
                </div>
            </div>
        @endif
        
        <!-- Application Form -->
        <form method="POST" action="{{ route('user.applications.store') }}">
            @csrf
            
            <input type="hidden" name="property_id" value="{{ $property->id }}">
            
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
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500"
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
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500"
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
                        onchange="updateOccupantsFields(this.value)"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500"
                    >
                    @error('number_of_occupants')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
            </x-form-section-card>
            
            <!-- Additional Occupants -->
            <div id="occupants-section" class="hidden">
                <x-form-section-card title="Additional Occupants" description="Provide details about other people who will be living with you">
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
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500"
                        placeholder="Any special requirements or requests..."
                    >{{ old('special_requests') }}</textarea>
                    <p class="mt-1 text-xs text-gray-500">Maximum 1000 characters</p>
                </div>
                
                <div>
                    <label class="flex items-center gap-2 text-sm font-medium text-gray-700 mb-2">
                        Additional Notes
                    </label>
                    <textarea 
                        name="notes" 
                        rows="3"
                        maxlength="1000"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500"
                        placeholder="Anything else you'd like the property manager to know..."
                    >{{ old('notes') }}</textarea>
                </div>
                
            </x-form-section-card>
            
            <!-- Submit Buttons -->
            <div class="flex items-center justify-between mt-6">
                <a 
                    href="{{ route('user.applications.index') }}" 
                    class="px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 transition"
                >
                    Cancel
                </a>
                
                <div class="flex gap-3">
                    <button 
                        type="submit" 
                        name="submit_type" 
                        value="draft"
                        class="px-6 py-3 bg-gray-600 text-white font-semibold rounded-lg hover:bg-gray-700 transition"
                    >
                        Save as Draft
                    </button>
                    
                    <button 
                        type="submit" 
                        name="submit_type" 
                        value="submit"
                        class="px-8 py-3 bg-teal-600 text-white font-semibold rounded-lg hover:bg-teal-700 transition shadow-sm"
                    >
                        Submit Application
                    </button>
                </div>
            </div>
            
        </form>
        
    </div>
</div>

<script>
function updateOccupantsFields(count) {
    const container = document.getElementById('occupants-container');
    const section = document.getElementById('occupants-section');
    
    // Show/hide section
    if (count > 1) {
        section.classList.remove('hidden');
    } else {
        section.classList.add('hidden');
        return;
    }
    
    // Clear existing
    container.innerHTML = '';
    
    // Create fields for additional occupants (excluding yourself)
    for (let i = 0; i < count - 1; i++) {
        const occupantFields = `
            <div class="p-4 border border-gray-200 rounded-lg mb-4">
                <h4 class="font-semibold text-gray-900 mb-3">Occupant ${i + 2}</h4>
                
                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm font-medium text-gray-700 mb-2 block">
                            Full Name <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="occupants_details[${i}][name]" 
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500"
                            placeholder="John Doe"
                        >
                    </div>
                    
                    <div>
                        <label class="text-sm font-medium text-gray-700 mb-2 block">
                            Relationship <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="occupants_details[${i}][relationship]" 
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500"
                            placeholder="e.g., Partner, Child, Roommate"
                        >
                    </div>
                    
                    <div>
                        <label class="text-sm font-medium text-gray-700 mb-2 block">Age (Optional)</label>
                        <input 
                            type="number" 
                            name="occupants_details[${i}][age]" 
                            min="0"
                            max="120"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500"
                        >
                    </div>
                </div>
            </div>
        `;
        
        container.insertAdjacentHTML('beforeend', occupantFields);
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    const occupantsInput = document.querySelector('input[name="number_of_occupants"]');
    if (occupantsInput && occupantsInput.value > 1) {
        updateOccupantsFields(occupantsInput.value);
    }
});
</script>
@endsection