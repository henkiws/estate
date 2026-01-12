<!-- Employment Card -->
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-4 hover:shadow-md transition-shadow" id="employment-card">
    
    <!-- Card Header (Always Visible) -->
    <div class="p-6">
        <div class="flex items-start justify-between">
            
            <!-- Left: Icon + Content -->
            <div class="flex items-start gap-4 flex-1">
                <!-- Icon -->
                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-plyform-green/20 to-plyform-mint/30 flex items-center justify-center text-plyform-dark flex-shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                
                <!-- Content -->
                <div class="flex-1">
                    <h3 class="text-lg font-semibold text-plyform-dark">Employment</h3>
                    <p class="text-sm text-gray-600 mt-1" id="employment-summary">
                        @if($user->employments && $user->employments->count() > 0)
                            Currently at {{ $user->employments->first()->company_name }}
                        @else
                            Not completed yet
                        @endif
                    </p>
                    
                    <!-- Status Badge -->
                    <div class="mt-3">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $user->employments && $user->employments->count() > 0 ? 'bg-plyform-mint text-plyform-dark border border-plyform-mint' : 'bg-gray-100 text-gray-600 border border-gray-200' }}" id="employment-status">
                            @if($user->employments && $user->employments->count() > 0)
                                Complete
                            @else
                                Incomplete
                            @endif
                        </span>
                    </div>
                </div>
            </div>
            
            <!-- Right: Completion % + Edit Button -->
            <div class="flex items-start gap-4 ml-4">
                <!-- Completion Percentage -->
                <div class="flex items-center justify-center w-14 h-14 rounded-full border-4 {{ $user->employments && $user->employments->count() > 0 ? 'border-[#5E17EB]' : 'border-gray-300' }} bg-white">
                    <span class="text-xs font-bold {{ $user->employments && $user->employments->count() > 0 ? 'text-[#5E17EB]' : 'text-gray-400' }}" id="employment-percentage">
                        @if($user->employments && $user->employments->count() > 0)
                            100%
                        @else
                            0%
                        @endif
                    </span>
                </div>
                
                <!-- Edit Button -->
                <button 
                    type="button" 
                    onclick="toggleEmployment()"
                    class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-plyform-purple hover:text-plyform-dark hover:bg-plyform-purple/10 rounded-lg transition"
                    id="employment-edit-btn"
                >
                    <span>Edit</span>
                    <svg class="w-4 h-4 transition-transform" id="employment-chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
            </div>
            
        </div>
    </div>
    
    <!-- Expandable Form Content (Hidden by Default) -->
    <div class="border-t border-gray-200 bg-gray-50 hidden" id="employment-form">
        <form method="POST" action="{{ route('user.profile.update-step') }}" enctype="multipart/form-data" class="p-6 space-y-6">
            @csrf
            <input type="hidden" name="current_step" value="4">
            
            <!-- Has Employment Toggle -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <label class="flex items-center gap-3 cursor-pointer">
                    <input 
                        type="checkbox" 
                        name="has_employment" 
                        id="has-employment"
                        value="1"
                        onchange="toggleEmploymentSection()"
                        {{ old('has_employment', $user->employments->count() > 0) ? 'checked' : '' }}
                        class="w-5 h-5 text-plyform-green border-gray-300 rounded focus:ring-2 focus:ring-plyform-green/20"
                    >
                    <span class="font-medium text-plyform-dark">I am currently employed or have employment history</span>
                </label>
                <p class="text-sm text-gray-600 mt-2 ml-8">Check this if you have current or past employment to declare</p>
            </div>

            <div id="employment-section" class="{{ old('has_employment', $user->employments->count() > 0) ? '' : 'hidden' }}">
                <!-- Employment History Section -->
                <div class="bg-white rounded-lg p-6 space-y-4">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h4 class="text-base font-semibold text-plyform-dark">Employment History</h4>
                            <p class="text-sm text-gray-600 mt-1">Provide details about your current and previous employment</p>
                        </div>
                        <span class="text-plyform-orange text-sm font-medium">* Required</span>
                    </div>
                    
                    <div id="employment-container">
                        @php
                            $employments = old('employments', $user->employments->toArray() ?: [['company_name' => '', 'position' => '']]);
                        @endphp
                        
                        @foreach($employments as $index => $employment)
                            <div class="employment-item p-4 border-2 border-gray-200 rounded-lg mb-4 hover:border-plyform-purple/30 transition-colors" data-index="{{ $index }}">
                                <div class="flex items-center justify-between mb-4">
                                    <h4 class="font-semibold text-plyform-dark">Employment {{ $index + 1 }}</h4>
                                    @if($index > 0)
                                        <button 
                                            type="button" 
                                            onclick="removeEmployment({{ $index }})"
                                            class="text-plyform-orange hover:text-red-700 text-sm font-medium hover:bg-plyform-orange/10 px-3 py-1 rounded-lg transition-colors"
                                        >
                                            Remove
                                        </button>
                                    @endif
                                </div>
                                
                                <!-- Company & Position -->
                                <div class="grid md:grid-cols-2 gap-4 mb-4">
                                    <div>
                                        <label class="flex items-center gap-2 text-sm font-medium text-plyform-dark mb-2">
                                            Company Name <span class="text-plyform-orange">*</span>
                                        </label>
                                        <input 
                                            type="text" 
                                            name="employments[{{ $index }}][company_name]" 
                                            value="{{ $employment['company_name'] ?? '' }}"
                                            required
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all"
                                            placeholder="ABC Company Pty Ltd"
                                        >
                                    </div>
                                    
                                    <div>
                                        <label class="flex items-center gap-2 text-sm font-medium text-plyform-dark mb-2">
                                            Position/Job Title <span class="text-plyform-orange">*</span>
                                        </label>
                                        <input 
                                            type="text" 
                                            name="employments[{{ $index }}][position]" 
                                            value="{{ $employment['position'] ?? '' }}"
                                            required
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all"
                                            placeholder="Senior Developer"
                                        >
                                    </div>
                                </div>
                                
                                <!-- Company Address -->
                                <div class="mb-4">
                                    <label class="flex items-center gap-2 text-sm font-medium text-plyform-dark mb-2">
                                        Company Address <span class="text-plyform-orange">*</span>
                                    </label>
                                    <input 
                                        type="text" 
                                        name="employments[{{ $index }}][address]" 
                                        value="{{ $employment['address'] ?? '' }}"
                                        required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all"
                                        placeholder="123 Business St, Sydney NSW 2000"
                                    >
                                </div>
                                
                                <!-- Salary & Manager -->
                                <div class="grid md:grid-cols-2 gap-4 mb-4">
                                    <div>
                                        <label class="flex items-center gap-2 text-sm font-medium text-plyform-dark mb-2">
                                            Gross Annual Salary <span class="text-plyform-orange">*</span>
                                        </label>
                                        <div class="relative">
                                            <span class="absolute left-4 top-3.5 text-gray-500">$</span>
                                            <input 
                                                type="number" 
                                                name="employments[{{ $index }}][gross_annual_salary]" 
                                                value="{{ $employment['gross_annual_salary'] ?? '' }}"
                                                min="0"
                                                required
                                                class="w-full pl-8 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all"
                                                placeholder="75000"
                                            >
                                        </div>
                                    </div>
                                    
                                    <div>
                                        <label class="flex items-center gap-2 text-sm font-medium text-plyform-dark mb-2">
                                            Manager/Supervisor Name <span class="text-plyform-orange">*</span>
                                        </label>
                                        <input 
                                            type="text" 
                                            name="employments[{{ $index }}][manager_full_name]" 
                                            value="{{ $employment['manager_full_name'] ?? '' }}"
                                            required
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all"
                                            placeholder="John Smith"
                                        >
                                    </div>
                                </div>
                                
                                <!-- Contact Details -->
                                <div class="grid md:grid-cols-2 gap-4 mb-4">
                                    <div>
                                        <label class="flex items-center gap-2 text-sm font-medium text-plyform-dark mb-2">
                                            Contact Number <span class="text-plyform-orange">*</span>
                                        </label>
                                        <input 
                                            type="tel" 
                                            name="employments[{{ $index }}][contact_number]" 
                                            value="{{ $employment['contact_number'] ?? '' }}"
                                            required
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all"
                                            placeholder="0400 000 000"
                                        >
                                    </div>
                                    
                                    <div>
                                        <label class="flex items-center gap-2 text-sm font-medium text-plyform-dark mb-2">
                                            Email Address <span class="text-plyform-orange">*</span>
                                        </label>
                                        <input 
                                            type="email" 
                                            name="employments[{{ $index }}][email]" 
                                            value="{{ $employment['email'] ?? '' }}"
                                            required
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all"
                                            placeholder="manager@company.com"
                                        >
                                    </div>
                                </div>
                                
                                <!-- Employment Dates -->
                                <div class="grid md:grid-cols-3 gap-4 mb-4">
                                    <div>
                                        <label class="flex items-center gap-2 text-sm font-medium text-plyform-dark mb-2">
                                            Start Date <span class="text-plyform-orange">*</span>
                                        </label>
                                        <input 
                                            type="date" 
                                            name="employments[{{ $index }}][start_date]" 
                                            value="{{ isset($employment['start_date']) ? \Carbon\Carbon::parse($employment['start_date'])->format('Y-m-d') : '' }}"
                                            required
                                            max="{{ now()->format('Y-m-d') }}"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all"
                                        >
                                    </div>
                                    
                                    <div>
                                        <label class="flex items-center gap-2 text-sm font-medium text-plyform-dark mb-2">
                                            Still Employed?
                                        </label>
                                        <label class="flex items-center gap-3 cursor-pointer mt-3 p-2 rounded-lg hover:bg-plyform-mint/10 transition-colors">
                                            <input 
                                                type="checkbox" 
                                                name="employments[{{ $index }}][still_employed]" 
                                                value="1"
                                                onchange="toggleEndDate({{ $index }})"
                                                {{ ($employment['still_employed'] ?? false) ? 'checked' : '' }}
                                                class="w-5 h-5 text-plyform-green rounded focus:ring-plyform-green/20"
                                            >
                                            <span class="text-sm">Yes, currently employed</span>
                                        </label>
                                    </div>
                                    
                                    <div class="end-date-field" data-index="{{ $index }}">
                                        <label class="flex items-center gap-2 text-sm font-medium text-plyform-dark mb-2">
                                            End Date <span class="text-plyform-orange required-if">*</span>
                                        </label>
                                        <input 
                                            type="date" 
                                            name="employments[{{ $index }}][end_date]" 
                                            value="{{ isset($employment['end_date']) ? \Carbon\Carbon::parse($employment['end_date'])->format('Y-m-d') : '' }}"
                                            max="{{ now()->format('Y-m-d') }}"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all"
                                        >
                                    </div>
                                </div>
                                
                                <!-- Employment Letter Upload -->
                                <div>
                                    <label class="flex items-center gap-2 text-sm font-medium text-plyform-dark mb-2">
                                        Employment Letter (Optional)
                                    </label>
                                    <input 
                                        type="file" 
                                        name="employments[{{ $index }}][employment_letter]"
                                        accept=".pdf,.jpg,.jpeg,.png"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-plyform-green/20 file:text-plyform-dark hover:file:bg-plyform-green/30 transition-all"
                                    >
                                    <p class="mt-1 text-xs text-gray-500">Recommended for verification (PDF, JPG, PNG - Max 10MB)</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <!-- Add Employment Button -->
                    <button 
                        type="button" 
                        onclick="addEmployment()"
                        class="w-full py-3 border-2 border-dashed border-gray-300 rounded-lg text-gray-600 hover:border-plyform-green hover:text-plyform-dark hover:bg-plyform-green/5 transition flex items-center justify-center gap-2 font-medium"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Add Previous Employment
                    </button>
                    
                </div>
            </div>
            
            <!-- Form Actions -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200">
                <button 
                    type="button" 
                    onclick="toggleEmployment()"
                    class="px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 transition"
                >
                    Cancel
                </button>
                
                <button 
                    type="submit" 
                    class="px-8 py-3 bg-gradient-to-r from-plyform-green to-plyform-green text-white font-semibold rounded-lg hover:from-plyform-green/90 hover:to-plyform-green/90 transition shadow-sm flex items-center gap-2"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Save Changes
                </button>
            </div>
            
        </form>
    </div>
    
</div>

<script>
let employmentIndex = {{ count($employments ?? []) }};

function toggleEmployment() {
    const formDiv = document.getElementById('employment-form');
    const chevron = document.getElementById('employment-chevron');
    const editBtn = document.getElementById('employment-edit-btn');
    
    if (formDiv.classList.contains('hidden')) {
        // Expand
        formDiv.classList.remove('hidden');
        chevron.style.transform = 'rotate(180deg)';
        editBtn.querySelector('span').textContent = 'Close';
        
        // Scroll to card
        setTimeout(() => {
            document.getElementById('employment-card').scrollIntoView({ 
                behavior: 'smooth', 
                block: 'start' 
            });
        }, 100);
    } else {
        // Collapse
        formDiv.classList.add('hidden');
        chevron.style.transform = 'rotate(0deg)';
        editBtn.querySelector('span').textContent = 'Edit';
    }
}

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
        <div class="employment-item p-4 border-2 border-gray-200 rounded-lg mb-4 hover:border-plyform-purple/30 transition-colors" data-index="${employmentIndex}">
            <div class="flex items-center justify-between mb-4">
                <h4 class="font-semibold text-plyform-dark">Employment ${employmentIndex + 1}</h4>
                <button type="button" onclick="removeEmployment(${employmentIndex})" class="text-plyform-orange hover:text-red-700 text-sm font-medium hover:bg-plyform-orange/10 px-3 py-1 rounded-lg transition-colors">Remove</button>
            </div>
            
            <div class="grid md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="text-sm font-medium text-plyform-dark mb-2 block">Company Name <span class="text-plyform-orange">*</span></label>
                    <input type="text" name="employments[${employmentIndex}][company_name]" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all" placeholder="ABC Company Pty Ltd">
                </div>
                <div>
                    <label class="text-sm font-medium text-plyform-dark mb-2 block">Position <span class="text-plyform-orange">*</span></label>
                    <input type="text" name="employments[${employmentIndex}][position]" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all" placeholder="Senior Developer">
                </div>
            </div>
            
            <div class="mb-4">
                <label class="text-sm font-medium text-plyform-dark mb-2 block">Company Address <span class="text-plyform-orange">*</span></label>
                <input type="text" name="employments[${employmentIndex}][address]" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all" placeholder="123 Business St, Sydney NSW 2000">
            </div>
            
            <div class="grid md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="text-sm font-medium text-plyform-dark mb-2 block">Gross Annual Salary <span class="text-plyform-orange">*</span></label>
                    <div class="relative">
                        <span class="absolute left-4 top-3.5 text-gray-500">$</span>
                        <input type="number" name="employments[${employmentIndex}][gross_annual_salary]" required class="w-full pl-8 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all" placeholder="75000">
                    </div>
                </div>
                <div>
                    <label class="text-sm font-medium text-plyform-dark mb-2 block">Manager Name <span class="text-plyform-orange">*</span></label>
                    <input type="text" name="employments[${employmentIndex}][manager_full_name]" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all" placeholder="John Smith">
                </div>
            </div>
            
            <div class="grid md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="text-sm font-medium text-plyform-dark mb-2 block">Contact Number <span class="text-plyform-orange">*</span></label>
                    <input type="tel" name="employments[${employmentIndex}][contact_number]" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all" placeholder="0400 000 000">
                </div>
                <div>
                    <label class="text-sm font-medium text-plyform-dark mb-2 block">Email <span class="text-plyform-orange">*</span></label>
                    <input type="email" name="employments[${employmentIndex}][email]" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all" placeholder="manager@company.com">
                </div>
            </div>
            
            <div class="grid md:grid-cols-3 gap-4 mb-4">
                <div>
                    <label class="text-sm font-medium text-plyform-dark mb-2 block">Start Date <span class="text-plyform-orange">*</span></label>
                    <input type="date" name="employments[${employmentIndex}][start_date]" required max="{{ now()->format('Y-m-d') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all">
                </div>
                <div>
                    <label class="text-sm font-medium text-plyform-dark mb-2 block">Still Employed?</label>
                    <label class="flex items-center gap-3 cursor-pointer mt-3 p-2 rounded-lg hover:bg-plyform-mint/10 transition-colors">
                        <input type="checkbox" name="employments[${employmentIndex}][still_employed]" value="1" onchange="toggleEndDate(${employmentIndex})" class="w-5 h-5 text-plyform-green rounded focus:ring-plyform-green/20">
                        <span class="text-sm">Yes</span>
                    </label>
                </div>
                <div class="end-date-field" data-index="${employmentIndex}">
                    <label class="text-sm font-medium text-plyform-dark mb-2 block">End Date <span class="text-plyform-orange required-if">*</span></label>
                    <input type="date" name="employments[${employmentIndex}][end_date]" required max="{{ now()->format('Y-m-d') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all">
                </div>
            </div>
            
            <div>
                <label class="text-sm font-medium text-plyform-dark mb-2 block">Employment Letter (Optional)</label>
                <input type="file" name="employments[${employmentIndex}][employment_letter]" accept=".pdf,.jpg,.jpeg,.png" class="w-full px-4 py-3 border border-gray-300 rounded-lg file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-plyform-green/20 file:text-plyform-dark hover:file:bg-plyform-green/30 transition-all">
                <p class="mt-1 text-xs text-gray-500">Recommended for verification (PDF, JPG, PNG - Max 10MB)</p>
            </div>
        </div>
    `;
    
    container.insertAdjacentHTML('beforeend', newEmployment);
    const newElement = container.lastElementChild;
    if (typeof reinitializePlugins === 'function') {
        reinitializePlugins(newElement);
    }
    employmentIndex++;
}

function removeEmployment(index) {
    const item = document.querySelector(`.employment-item[data-index="${index}"]`);
    if (item) {
        item.remove();
        // Renumber remaining items
        document.querySelectorAll('.employment-item').forEach((el, idx) => {
            el.querySelector('h4').textContent = `Employment ${idx + 1}`;
        });
    }
}

// Initialize end date fields on page load
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('input[name^="employments"][name$="[still_employed]"]').forEach((checkbox, index) => {
        if (checkbox.checked) toggleEndDate(index);
    });
});
</script>