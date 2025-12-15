<!-- Has Employment Toggle -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
    <label class="flex items-center gap-3 cursor-pointer">
        <input 
            type="checkbox" 
            name="has_employment" 
            id="has-employment"
            value="1"
            onchange="toggleEmploymentSection()"
            {{ old('has_employment', $user->employments->count() > 0) ? 'checked' : '' }}
            class="w-5 h-5 text-teal-600 border-gray-300 rounded focus:ring-2 focus:ring-teal-500"
        >
        <span class="font-medium text-gray-900">I am currently employed or have employment history</span>
    </label>
    <p class="text-sm text-gray-600 mt-2 ml-8">Check this if you have current or past employment to declare</p>
</div>

<div id="employment-section" class="{{ old('has_employment', $user->employments->count() > 0) ? '' : 'hidden' }}">
    <x-form-section-card 
        title="Employment History" 
        description="Provide details about your current and previous employment"
        required>
        
        <div id="employment-container">
            @php
                $employments = old('employments', $user->employments->toArray() ?: [['company_name' => '', 'position' => '']]);
            @endphp
            
            @foreach($employments as $index => $employment)
                <div class="employment-item p-4 border-2 border-gray-200 rounded-lg mb-4" data-index="{{ $index }}">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="font-semibold text-gray-900">Employment {{ $index + 1 }}</h4>
                        @if($index > 0)
                            <button 
                                type="button" 
                                onclick="removeEmployment({{ $index }})"
                                class="text-red-600 hover:text-red-700 text-sm font-medium"
                            >
                                Remove
                            </button>
                        @endif
                    </div>
                    
                    <!-- Company & Position -->
                    <div class="grid md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="flex items-center gap-2 text-sm font-medium text-gray-700 mb-2">
                                Company Name <span class="text-red-500">*</span>
                                <x-profile-help-text text="Full legal name of your employer" />
                            </label>
                            <input 
                                type="text" 
                                name="employments[{{ $index }}][company_name]" 
                                value="{{ $employment['company_name'] ?? '' }}"
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500"
                                placeholder="ABC Company Pty Ltd"
                            >
                        </div>
                        
                        <div>
                            <label class="flex items-center gap-2 text-sm font-medium text-gray-700 mb-2">
                                Position/Job Title <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                name="employments[{{ $index }}][position]" 
                                value="{{ $employment['position'] ?? '' }}"
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500"
                                placeholder="Senior Developer"
                            >
                        </div>
                    </div>
                    
                    <!-- Company Address -->
                    <div class="mb-4">
                        <label class="flex items-center gap-2 text-sm font-medium text-gray-700 mb-2">
                            Company Address <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="employments[{{ $index }}][address]" 
                            value="{{ $employment['address'] ?? '' }}"
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500"
                            placeholder="123 Business St, Sydney NSW 2000"
                        >
                    </div>
                    
                    <!-- Salary & Manager -->
                    <div class="grid md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="flex items-center gap-2 text-sm font-medium text-gray-700 mb-2">
                                Gross Annual Salary <span class="text-red-500">*</span>
                                <x-profile-help-text text="Your salary before tax (per year)" />
                            </label>
                            <div class="relative">
                                <span class="absolute left-4 top-3.5 text-gray-500">$</span>
                                <input 
                                    type="number" 
                                    name="employments[{{ $index }}][gross_annual_salary]" 
                                    value="{{ $employment['gross_annual_salary'] ?? '' }}"
                                    min="0"
                                    required
                                    class="w-full pl-8 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500"
                                    placeholder="75000"
                                >
                            </div>
                        </div>
                        
                        <div>
                            <label class="flex items-center gap-2 text-sm font-medium text-gray-700 mb-2">
                                Manager/Supervisor Name <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                name="employments[{{ $index }}][manager_full_name]" 
                                value="{{ $employment['manager_full_name'] ?? '' }}"
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500"
                                placeholder="John Smith"
                            >
                        </div>
                    </div>
                    
                    <!-- Contact Details -->
                    <div class="grid md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="flex items-center gap-2 text-sm font-medium text-gray-700 mb-2">
                                Contact Number <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="tel" 
                                name="employments[{{ $index }}][contact_number]" 
                                value="{{ $employment['contact_number'] ?? '' }}"
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500"
                                placeholder="0400 000 000"
                            >
                        </div>
                        
                        <div>
                            <label class="flex items-center gap-2 text-sm font-medium text-gray-700 mb-2">
                                Email Address <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="email" 
                                name="employments[{{ $index }}][email]" 
                                value="{{ $employment['email'] ?? '' }}"
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500"
                                placeholder="manager@company.com"
                            >
                        </div>
                    </div>
                    
                    <!-- Employment Dates -->
                    <div class="grid md:grid-cols-3 gap-4 mb-4">
                        <div>
                            <label class="flex items-center gap-2 text-sm font-medium text-gray-700 mb-2">
                                Start Date <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="date" 
                                name="employments[{{ $index }}][start_date]" 
                                value="{{ isset($employment['start_date']) ? \Carbon\Carbon::parse($employment['start_date'])->format('Y-m-d') : '' }}"
                                required
                                max="{{ now()->format('Y-m-d') }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500"
                            >
                        </div>
                        
                        <div>
                            <label class="flex items-center gap-2 text-sm font-medium text-gray-700 mb-2">
                                Still Employed?
                            </label>
                            <label class="flex items-center gap-3 cursor-pointer mt-3">
                                <input 
                                    type="checkbox" 
                                    name="employments[{{ $index }}][still_employed]" 
                                    value="1"
                                    onchange="toggleEndDate({{ $index }})"
                                    {{ ($employment['still_employed'] ?? false) ? 'checked' : '' }}
                                    class="w-5 h-5 text-teal-600 rounded"
                                >
                                <span class="text-sm">Yes, currently employed</span>
                            </label>
                        </div>
                        
                        <div class="end-date-field" data-index="{{ $index }}">
                            <label class="flex items-center gap-2 text-sm font-medium text-gray-700 mb-2">
                                End Date <span class="text-red-500 required-if">*</span>
                            </label>
                            <input 
                                type="date" 
                                name="employments[{{ $index }}][end_date]" 
                                value="{{ isset($employment['end_date']) ? \Carbon\Carbon::parse($employment['end_date'])->format('Y-m-d') : '' }}"
                                max="{{ now()->format('Y-m-d') }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500"
                            >
                        </div>
                    </div>
                    
                    <!-- Employment Letter Upload -->
                    <div>
                        <label class="flex items-center gap-2 text-sm font-medium text-gray-700 mb-2">
                            Employment Letter (Optional)
                            <x-profile-help-text text="Letter from employer confirming your employment (PDF, JPG, PNG - Max 10MB)" />
                        </label>
                        <input 
                            type="file" 
                            name="employments[{{ $index }}][employment_letter]"
                            accept=".pdf,.jpg,.jpeg,.png"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100"
                        >
                        <p class="mt-1 text-xs text-gray-500">Recommended for verification</p>
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Add Employment Button -->
        <button 
            type="button" 
            onclick="addEmployment()"
            class="w-full py-3 border-2 border-dashed border-gray-300 rounded-lg text-gray-600 hover:border-teal-500 hover:text-teal-600 transition flex items-center justify-center gap-2"
        >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            Add Previous Employment
        </button>
        
    </x-form-section-card>
</div>

@php
    $previousStep = max(1, $currentStep - 1);
@endphp

<!-- Navigation Buttons -->
<div class="flex items-center justify-between mt-6">
    @if($currentStep > 1)
        <!-- Back Button (Steps 2-10) -->
        <a href="{{ route('user.profile.complete', ['step' => $previousStep]) }}" 
           class="px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 transition flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Back
        </a>
    @else
        <!-- Cancel Button (Step 1 only) -->
        <a href="{{ route('user.dashboard') }}" 
           class="px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 transition flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Cancel
        </a>
    @endif
    
    <!-- Save & Continue Button (All steps) -->
    <button type="submit" class="px-8 py-3 bg-teal-600 text-white font-semibold rounded-lg hover:bg-teal-700 transition shadow-sm flex items-center gap-2">
        Save & Continue
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
    </button>
</div>

<script>
let employmentIndex = {{ count($employments) }};

function toggleEmploymentSection() {
    const checkbox = document.getElementById('has-employment');
    const section = document.getElementById('employment-section');
    
    if (checkbox.checked) {
        section.classList.remove('hidden');
    } else {
        section.classList.add('hidden');
    }
}

function toggleEndDate(index) {
    const checkbox = document.querySelector(`input[name="employments[${index}][still_employed]"]`);
    const endDateField = document.querySelector(`.end-date-field[data-index="${index}"] input`);
    const requiredStar = document.querySelector(`.end-date-field[data-index="${index}"] .required-if`);
    
    if (checkbox.checked) {
        endDateField.required = false;
        endDateField.disabled = true;
        endDateField.value = '';
        if (requiredStar) requiredStar.classList.add('hidden');
    } else {
        endDateField.required = true;
        endDateField.disabled = false;
        if (requiredStar) requiredStar.classList.remove('hidden');
    }
}

function addEmployment() {
    const container = document.getElementById('employment-container');
    const newEmployment = `
        <div class="employment-item p-4 border-2 border-gray-200 rounded-lg mb-4" data-index="${employmentIndex}">
            <div class="flex items-center justify-between mb-4">
                <h4 class="font-semibold text-gray-900">Employment ${employmentIndex + 1}</h4>
                <button type="button" onclick="removeEmployment(${employmentIndex})" class="text-red-600 hover:text-red-700 text-sm font-medium">Remove</button>
            </div>
            
            <div class="grid md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="text-sm font-medium text-gray-700 mb-2 block">Company Name <span class="text-red-500">*</span></label>
                    <input type="text" name="employments[${employmentIndex}][company_name]" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-700 mb-2 block">Position <span class="text-red-500">*</span></label>
                    <input type="text" name="employments[${employmentIndex}][position]" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">
                </div>
            </div>
            
            <div class="mb-4">
                <label class="text-sm font-medium text-gray-700 mb-2 block">Company Address <span class="text-red-500">*</span></label>
                <input type="text" name="employments[${employmentIndex}][address]" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">
            </div>
            
            <div class="grid md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="text-sm font-medium text-gray-700 mb-2 block">Gross Annual Salary <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <span class="absolute left-4 top-3.5 text-gray-500">$</span>
                        <input type="number" name="employments[${employmentIndex}][gross_annual_salary]" required class="w-full pl-8 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">
                    </div>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-700 mb-2 block">Manager Name <span class="text-red-500">*</span></label>
                    <input type="text" name="employments[${employmentIndex}][manager_full_name]" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">
                </div>
            </div>
            
            <div class="grid md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="text-sm font-medium text-gray-700 mb-2 block">Contact Number <span class="text-red-500">*</span></label>
                    <input type="tel" name="employments[${employmentIndex}][contact_number]" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-700 mb-2 block">Email <span class="text-red-500">*</span></label>
                    <input type="email" name="employments[${employmentIndex}][email]" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">
                </div>
            </div>
            
            <div class="grid md:grid-cols-3 gap-4 mb-4">
                <div>
                    <label class="text-sm font-medium text-gray-700 mb-2 block">Start Date <span class="text-red-500">*</span></label>
                    <input type="date" name="employments[${employmentIndex}][start_date]" required max="{{ now()->format('Y-m-d') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-700 mb-2 block">Still Employed?</label>
                    <label class="flex items-center gap-3 cursor-pointer mt-3">
                        <input type="checkbox" name="employments[${employmentIndex}][still_employed]" value="1" onchange="toggleEndDate(${employmentIndex})" class="w-5 h-5 text-teal-600 rounded">
                        <span class="text-sm">Yes</span>
                    </label>
                </div>
                <div class="end-date-field" data-index="${employmentIndex}">
                    <label class="text-sm font-medium text-gray-700 mb-2 block">End Date <span class="text-red-500 required-if">*</span></label>
                    <input type="date" name="employments[${employmentIndex}][end_date]" required max="{{ now()->format('Y-m-d') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">
                </div>
            </div>
            
            <div>
                <label class="text-sm font-medium text-gray-700 mb-2 block">Employment Letter (Optional)</label>
                <input type="file" name="employments[${employmentIndex}][employment_letter]" accept=".pdf,.jpg,.jpeg,.png" class="w-full px-4 py-3 border border-gray-300 rounded-lg file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100">
            </div>
        </div>
    `;
    
    container.insertAdjacentHTML('beforeend', newEmployment);
    employmentIndex++;
}

function removeEmployment(index) {
    const item = document.querySelector(`.employment-item[data-index="${index}"]`);
    if (item) item.remove();
}

// Initialize end date fields on page load
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('input[name^="employments"][name$="[still_employed]"]').forEach((checkbox, index) => {
        if (checkbox.checked) toggleEndDate(index);
    });
});
</script>