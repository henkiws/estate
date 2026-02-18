<!-- Employment Card -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden section-card mb-4" id="employment-card">
    
    <!-- Card Header - Collapsible Button (Always Visible) -->
    <button type="button" onclick="toggleEmployment()" class="w-full px-6 py-4 flex items-center justify-between hover:bg-gray-50 transition">
        <div class="flex items-center gap-3">
            <!-- Status Icon -->
            <div class="w-8 h-8 rounded-full {{ $user->employments && $user->employments->count() > 0 ? 'bg-teal-100' : 'bg-gray-100' }} flex items-center justify-center section-status" id="status_employment">
                @if($user->employments && $user->employments->count() > 0)
                    <svg class="w-5 h-5 text-teal-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    </svg>
                @else
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                @endif
            </div>
            
            <!-- Title and Summary -->
            <div class="text-left">
                <span class="font-semibold text-gray-900">Employment</span>
                <p class="text-xs text-gray-500" id="employment-summary">
                    @if($user->employments && $user->employments->count() > 0)
                        @php
                            $employment = $user->employments->first();
                            $verified = $employment->reference_status === 'verified';
                            $pending = $employment->reference_status === 'pending';
                        @endphp
                        Currently at {{ $employment->company_name }}
                        @if($verified)
                            <span class="inline-flex items-center ml-1 px-1.5 py-0.5 rounded text-xs font-medium bg-green-100 text-green-700">
                                ✓ Verified
                            </span>
                        @elseif($pending)
                            <span class="inline-flex items-center ml-1 px-1.5 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-700">
                                ⏱ Pending
                            </span>
                        @endif
                    @else
                        Not completed yet
                    @endif
                </p>
            </div>
        </div>
        
        <!-- Right Side: Percentage + Chevron -->
        <div class="flex items-center gap-4">
            <!-- Completion Percentage Circle -->
            <div class="flex items-center justify-center w-12 h-12 rounded-full border-3 {{ $user->employments && $user->employments->count() > 0 ? 'border-teal-600 bg-teal-50' : 'border-gray-300 bg-gray-50' }}" id="employment-percentage-circle">
                <span class="text-xs font-bold {{ $user->employments && $user->employments->count() > 0 ? 'text-teal-600' : 'text-gray-400' }}" id="employment-percentage">
                    @if($user->employments && $user->employments->count() > 0)
                        100%
                    @else
                        0%
                    @endif
                </span>
            </div>
            
            <!-- Chevron Icon -->
            <svg class="w-5 h-5 text-gray-400 section-chevron transition-transform" id="employment-chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </div>
    </button>
    
    <!-- Expandable Form Content (Hidden by Default) -->
    <div class="section-content hidden px-6 pb-6" id="employment-form">
        <form method="POST" action="{{ route('user.profile.update-step') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            <input type="hidden" name="current_step" value="4">
            <input type="hidden" name="mode" value="{{ $mode }}">
            
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
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
                    <div class="flex gap-3">
                        <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                        <div class="flex-1">
                            <h4 class="font-semibold text-blue-900 mb-1">Employment Reference</h4>
                            <p class="text-sm text-blue-800">
                                After saving, an email will be sent to your manager/supervisor to verify your employment details.
                                Once verified, you can only delete (not edit) the employment record.
                            </p>
                        </div>
                    </div>
                </div>
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
                                    <div class="flex items-center gap-3">
                                        <h4 class="font-semibold text-plyform-dark">Employment {{ $index + 1 }}</h4>
                                        
                                        <!-- Reference Status Badge -->
                                        @if(!empty($employment['reference_status']))
                                            @if($employment['reference_status'] === 'verified')
                                                <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-green-100 text-green-800">
                                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                    </svg>
                                                    Reference Verified
                                                </span>
                                            @elseif($employment['reference_status'] === 'pending')
                                                <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-yellow-100 text-yellow-800">
                                                    <svg class="w-3 h-3 mr-1 animate-pulse" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                                    </svg>
                                                    Reference Pending
                                                </span>
                                            @endif
                                        @endif
                                    </div>
                                    
                                    <!-- ✅ FIXED: Action buttons for ALL employments (removed $index > 0 condition) -->
                                    @php
                                        $isVerified = ($employment['reference_status'] ?? '') === 'verified';
                                        $isPending = ($employment['reference_status'] ?? '') === 'pending';
                                        $hasNoReference = empty($employment['reference_status']);
                                    @endphp
                                    
                                    <div class="flex items-center gap-2">
                                        @if($isVerified)
                                            <!-- Verified: Can only DELETE with confirmation -->
                                            <button 
                                                type="button" 
                                                onclick="deleteVerifiedEmployment({{ $index }})"
                                                class="text-red-600 hover:text-red-800 text-sm font-medium hover:bg-red-50 px-3 py-1 rounded-lg transition-colors"
                                            >
                                                Delete
                                            </button>
                                            
                                        @elseif($isPending)
                                            <!-- Pending: Can EDIT (will resend email) or DELETE -->
                                            <button 
                                                type="button" 
                                                onclick="confirmEditPendingEmployment({{ $index }})"
                                                class="text-blue-600 hover:text-blue-800 text-sm font-medium hover:bg-blue-50 px-3 py-1 rounded-lg transition-colors"
                                                title="Editing will send a new reference request"
                                            >
                                                Edit
                                            </button>
                                            
                                            @if($index > 0)
                                                <button 
                                                    type="button" 
                                                    onclick="deleteEmployment({{ $index }})"
                                                    class="text-red-600 hover:text-red-800 text-sm font-medium hover:bg-red-50 px-3 py-1 rounded-lg transition-colors"
                                                >
                                                    Delete
                                                </button>
                                            @endif
                                            
                                        @else
                                            <!-- No reference: Normal REMOVE (only for additional employments) -->
                                            @if($index > 0)
                                                <button 
                                                    type="button" 
                                                    onclick="removeEmployment({{ $index }})"
                                                    class="text-plyform-orange hover:text-red-700 text-sm font-medium hover:bg-plyform-orange/10 px-3 py-1 rounded-lg transition-colors"
                                                >
                                                    Remove
                                                </button>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                                
                                <!-- Hidden field for employment ID -->
                                <input type="hidden" name="employments[{{ $index }}][id]" value="{{ $employment['id'] ?? '' }}">
                                
                                <!-- Make fields readonly if verified -->
                                @php
                                    $isVerified = ($employment['reference_status'] ?? '') === 'verified';
                                    $isPending = ($employment['reference_status'] ?? '') === 'pending';
                                    $readonlyAttr = $isVerified || $isPending ? 'readonly' : '';
                                    $disabledClass = $isVerified || $isPending ? 'bg-gray-100 cursor-not-allowed' : '';
                                @endphp
                                
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
                                            {{ $readonlyAttr }}
                                            required
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all {{ $disabledClass }} @error('employments.'.$index.'.company_name') border-red-500 @enderror"
                                            placeholder="ABC Company Pty Ltd"
                                        >
                                        @error('employments.'.$index.'.company_name')
                                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    
                                    <div>
                                        <label class="flex items-center gap-2 text-sm font-medium text-plyform-dark mb-2">
                                            Position/Job Title <span class="text-plyform-orange">*</span>
                                        </label>
                                        <input 
                                            type="text" 
                                            name="employments[{{ $index }}][position]" 
                                            value="{{ $employment['position'] ?? '' }}"
                                            {{ $readonlyAttr }}
                                            required
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all {{ $disabledClass }}"
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
                                        {{ $readonlyAttr }}
                                        required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all {{ $disabledClass }}"
                                        placeholder="123 Business St, Sydney NSW 2000"
                                    >
                                </div>
                                
                                <!-- Manager Name -->
                                <div class="mb-4">
                                    <label class="flex items-center gap-2 text-sm font-medium text-plyform-dark mb-2">
                                        Manager/Supervisor Name <span class="text-plyform-orange">*</span>
                                    </label>
                                    <input 
                                        type="text" 
                                        name="employments[{{ $index }}][manager_full_name]" 
                                        value="{{ $employment['manager_full_name'] ?? '' }}"
                                        {{ $readonlyAttr }}
                                        required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all {{ $disabledClass }}"
                                        placeholder="John Smith"
                                    >
                                </div>
                                
                                <!-- Contact Details -->
                                <div class="grid md:grid-cols-2 gap-4 mb-4">
                                    <!-- Contact Number with intl-tel-input -->
                                    <div>
                                        <label class="flex items-center gap-2 text-sm font-medium text-plyform-dark mb-2">
                                            Contact Number <span class="text-plyform-orange">*</span>
                                        </label>
                                        
                                        <input 
                                            type="tel" 
                                            id="employment_contact_{{ $index }}" 
                                            name="employments[{{ $index }}][contact_number_display]"
                                            value="{{ $employment['contact_number'] ?? '' }}"
                                            {{ $readonlyAttr }}
                                            required
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all {{ $disabledClass }}"
                                            placeholder="Enter phone number"
                                        >
                                        
                                        <input type="hidden" id="employment_contact_country_code_{{ $index }}" name="employments[{{ $index }}][contact_country_code]" value="{{ $employment['contact_country_code'] ?? '+61' }}">
                                        <input type="hidden" id="employment_contact_number_clean_{{ $index }}" name="employments[{{ $index }}][contact_number]" value="{{ $employment['contact_number'] ?? '' }}">
                                        
                                        <p class="mt-1 text-xs text-gray-500">Select country and enter contact number</p>
                                    </div>
                                    
                                    <div>
                                        <label class="flex items-center gap-2 text-sm font-medium text-plyform-dark mb-2">
                                            Email Address <span class="text-plyform-orange">*</span>
                                        </label>
                                        <input 
                                            type="email" 
                                            name="employments[{{ $index }}][email]" 
                                            value="{{ $employment['email'] ?? '' }}"
                                            {{ $readonlyAttr }}
                                            required
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all {{ $disabledClass }}"
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
                                            {{ $readonlyAttr }}
                                            required
                                            max="{{ now()->format('Y-m-d') }}"
                                            onchange="updateStartDate({{ $index }})"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all {{ $disabledClass }}"
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
                                                {{-- {{ $isVerified ? 'disabled' : '' }} --}}
                                                class="w-5 h-5 text-plyform-green rounded focus:ring-plyform-green/20 {{ $disabledClass }}"
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
                                            {{ $readonlyAttr }}
                                            max="{{ now()->format('Y-m-d') }}"
                                            min="{{ isset($employment['start_date']) ? \Carbon\Carbon::parse($employment['start_date'])->format('Y-m-d') : '' }}"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all end-date-field {{ $disabledClass }} @error('employments.'.$index.'.end_date') border-red-500 @enderror"
                                            data-index='{{ $index }}'
                                        >
                                        @error('employments.'.$index.'.end_date')
                                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                
                                <!-- Employment Letter Upload -->
                                <div>
                                    <label class="flex items-center gap-2 text-sm font-medium text-plyform-dark mb-2">
                                        Employment Letter (Optional)
                                    </label>
                                    <div class="space-y-3">
                                        <!-- File Input (Hidden) -->
                                        <input 
                                            type="file" 
                                            name="employments[{{ $index }}][employment_letter]"
                                            id="employment_letter_{{ $index }}"
                                            accept=".pdf,.jpg,.jpeg,.png"
                                            onchange="previewEmploymentLetter({{ $index }})"
                                            {{ $isVerified ? 'disabled' : '' }}
                                            class="hidden"
                                        >
                                        
                                        <!-- Upload Button/Preview Container -->
                                        <div id="employment_letter_preview_{{ $index }}" class="space-y-2">
                                            @if(!empty($employment['employment_letter_path']) && Storage::disk('public')->exists($employment['employment_letter_path']))
                                                <!-- EXISTING FILE PREVIEW -->
                                                <div class="relative bg-gray-50 border-2 border-gray-200 rounded-lg p-3">
                                                    <div class="flex items-center gap-3">
                                                        <!-- File Icon/Thumbnail -->
                                                        @if(in_array(pathinfo($employment['employment_letter_path'], PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png']))
                                                            <img src="{{ Storage::url($employment['employment_letter_path']) }}" alt="Employment Letter" class="w-16 h-16 object-cover rounded-lg border-2 border-gray-300">
                                                        @else
                                                            <div class="w-16 h-16 bg-red-100 rounded-lg border-2 border-red-300 flex items-center justify-center">
                                                                <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                                                </svg>
                                                            </div>
                                                        @endif
                                                        
                                                        <!-- File Info -->
                                                        <div class="flex-1 min-w-0">
                                                            <p class="text-sm font-medium text-gray-900 truncate">{{ basename($employment['employment_letter_path']) }}</p>
                                                            <p class="text-xs text-gray-500">Uploaded document</p>
                                                        </div>
                                                        
                                                        <!-- View Button -->
                                                        <a 
                                                            href="{{ Storage::url($employment['employment_letter_path']) }}" 
                                                            target="_blank"
                                                            class="flex-shrink-0 text-blue-600 hover:text-blue-800 transition p-2 hover:bg-blue-50 rounded-lg"
                                                            title="View document"
                                                        >
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                            </svg>
                                                        </a>
                                                        
                                                        @if(!$isVerified)
                                                            <!-- Remove Button (only if not verified) -->
                                                            <button 
                                                                type="button" 
                                                                onclick="removeEmploymentLetter({{ $index }})"
                                                                class="flex-shrink-0 text-red-600 hover:text-red-800 transition p-2 hover:bg-red-50 rounded-lg"
                                                                title="Remove document"
                                                            >
                                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                                </svg>
                                                            </button>
                                                            
                                                            <!-- Re-upload Button (only if not verified) -->
                                                            <button 
                                                                type="button" 
                                                                onclick="document.getElementById('employment_letter_{{ $index }}').click()"
                                                                class="flex-shrink-0 text-gray-600 hover:text-gray-800 transition p-2 hover:bg-gray-100 rounded-lg"
                                                                title="Change document"
                                                            >
                                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                                                </svg>
                                                            </button>
                                                        @endif
                                                    </div>
                                                </div>
                                                <input type="hidden" name="employments[{{ $index }}][existing_letter]" value="{{ $employment['employment_letter_path'] }}">
                                            @else
                                                <!-- NO FILE YET - UPLOAD BUTTON -->
                                                @if(!$isVerified)
                                                    <button 
                                                        type="button" 
                                                        onclick="document.getElementById('employment_letter_{{ $index }}').click()"
                                                        class="w-full px-4 py-3 border-2 border-dashed border-gray-300 rounded-lg hover:border-plyform-purple transition-colors text-center cursor-pointer"
                                                    >
                                                        <svg class="w-8 h-8 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                                        </svg>
                                                        <span class="text-sm text-gray-600">Click to upload employment letter</span>
                                                        <span class="text-xs text-gray-500 block mt-1">PDF, JPG, PNG (Max 10MB)</span>
                                                    </button>
                                                @else
                                                    <p class="text-sm text-gray-500 italic">No employment letter uploaded</p>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
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
                    Save And Next
                </button>
            </div>
            
        </form>
    </div>
    
</div>

<!-- ===================== EMPLOYMENT CONFIRM MODALS ===================== -->

<!-- 1. Remove Employment Modal (simple, unsaved entry) -->
<div id="modal-remove-employment" class="fixed inset-0 z-50 flex items-center justify-center hidden" role="dialog" aria-modal="true">
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" onclick="closeModal('modal-remove-employment')"></div>
    <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-sm mx-4 overflow-hidden animate-modal-in">
        <div class="h-1.5 w-full bg-gradient-to-r from-orange-400 to-red-400"></div>
        <div class="p-7">
            <div class="flex items-center justify-center mb-4">
                <div class="w-14 h-14 rounded-full bg-orange-50 flex items-center justify-center">
                    <svg class="w-7 h-7 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                </div>
            </div>
            <h3 class="text-lg font-bold text-center text-gray-900 mb-2">Remove Employment?</h3>
            <p class="text-sm text-center text-gray-500 mb-6">This entry will be removed. This action cannot be undone.</p>
            <div class="flex gap-3">
                <button type="button" onclick="closeModal('modal-remove-employment')" class="flex-1 px-4 py-2.5 rounded-xl border-2 border-gray-200 text-gray-700 font-semibold text-sm hover:bg-gray-50 transition">Cancel</button>
                <button type="button" onclick="fireModalCallback('modal-remove-employment')" class="flex-1 px-4 py-2.5 rounded-xl bg-orange-500 hover:bg-orange-600 text-white font-semibold text-sm transition shadow-sm">Remove</button>
            </div>
        </div>
    </div>
</div>

<!-- 2. Delete Pending Employment Modal -->
<div id="modal-delete-pending" class="fixed inset-0 z-50 flex items-center justify-center hidden" role="dialog" aria-modal="true">
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" onclick="closeModal('modal-delete-pending')"></div>
    <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-sm mx-4 overflow-hidden animate-modal-in">
        <div class="h-1.5 w-full bg-gradient-to-r from-yellow-400 to-orange-400"></div>
        <div class="p-7">
            <div class="flex items-center justify-center mb-4">
                <div class="w-14 h-14 rounded-full bg-yellow-50 flex items-center justify-center">
                    <svg class="w-7 h-7 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>
            <h3 class="text-lg font-bold text-center text-gray-900 mb-2">Delete Pending Employment?</h3>
            <p class="text-sm text-center text-gray-500 mb-4">The pending reference request will be <strong class="text-gray-700">cancelled</strong> and cannot be recovered.</p>
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg px-4 py-3 mb-6 text-xs text-yellow-800 text-center">
                ⏱ The reference request email will be expired immediately.
            </div>
            <div class="flex gap-3">
                <button type="button" onclick="closeModal('modal-delete-pending')" class="flex-1 px-4 py-2.5 rounded-xl border-2 border-gray-200 text-gray-700 font-semibold text-sm hover:bg-gray-50 transition">Cancel</button>
                <button type="button" onclick="fireModalCallback('modal-delete-pending')" class="flex-1 px-4 py-2.5 rounded-xl bg-red-500 hover:bg-red-600 text-white font-semibold text-sm transition shadow-sm">Delete</button>
            </div>
        </div>
    </div>
</div>

<!-- 3. Delete Verified Employment Modal (strongest warning) -->
<div id="modal-delete-verified" class="fixed inset-0 z-50 flex items-center justify-center hidden" role="dialog" aria-modal="true">
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" onclick="closeModal('modal-delete-verified')"></div>
    <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-sm mx-4 overflow-hidden animate-modal-in">
        <div class="h-1.5 w-full bg-gradient-to-r from-red-500 to-rose-600"></div>
        <div class="p-7">
            <div class="flex items-center justify-center mb-4">
                <div class="w-14 h-14 rounded-full bg-red-50 flex items-center justify-center">
                    <svg class="w-7 h-7 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                    </svg>
                </div>
            </div>
            <h3 class="text-lg font-bold text-center text-gray-900 mb-2">Delete Verified Employment?</h3>
            <p class="text-sm text-center text-gray-500 mb-4">This record has been <span class="font-semibold text-green-700">✓ verified</span>. Deleting it is permanent and irreversible.</p>
            <div class="bg-red-50 border border-red-200 rounded-lg px-4 py-3 mb-6 text-xs text-red-700 space-y-1">
                <p class="font-semibold">⚠️ Warning — this will permanently:</p>
                <p>• Remove the verified employment record</p>
                <p>• Lose the reference verification permanently</p>
            </div>
            <div class="flex gap-3">
                <button type="button" onclick="closeModal('modal-delete-verified')" class="flex-1 px-4 py-2.5 rounded-xl border-2 border-gray-200 text-gray-700 font-semibold text-sm hover:bg-gray-50 transition">Keep It</button>
                <button type="button" onclick="fireModalCallback('modal-delete-verified')" class="flex-1 px-4 py-2.5 rounded-xl bg-red-600 hover:bg-red-700 text-white font-semibold text-sm transition shadow-sm">Yes, Delete</button>
            </div>
        </div>
    </div>
</div>

<!-- 4. Edit Pending Employment Modal (resend warning) -->
<div id="modal-edit-pending" class="fixed inset-0 z-50 flex items-center justify-center hidden" role="dialog" aria-modal="true">
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" onclick="closeModal('modal-edit-pending')"></div>
    <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-sm mx-4 overflow-hidden animate-modal-in">
        <div class="h-1.5 w-full bg-gradient-to-r from-blue-500 to-indigo-500"></div>
        <div class="p-7">
            <div class="flex items-center justify-center mb-4">
                <div class="w-14 h-14 rounded-full bg-blue-50 flex items-center justify-center">
                    <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
            </div>
            <h3 class="text-lg font-bold text-center text-gray-900 mb-2">Edit & Resend Reference?</h3>
            <p class="text-sm text-center text-gray-500 mb-4">Making any changes will trigger a <strong class="text-gray-700">new reference request</strong> to be sent.</p>
            <div class="bg-blue-50 border border-blue-200 rounded-lg px-4 py-3 mb-6 text-xs text-blue-800 space-y-1">
                <p class="font-semibold">📧 What happens next:</p>
                <p>• The previous reference link will expire</p>
                <p>• A new email will be sent to your manager</p>
                <p>• Status resets to "Pending" until re-verified</p>
            </div>
            <div class="flex gap-3">
                <button type="button" onclick="closeModal('modal-edit-pending')" class="flex-1 px-4 py-2.5 rounded-xl border-2 border-gray-200 text-gray-700 font-semibold text-sm hover:bg-gray-50 transition">Cancel</button>
                <button type="button" onclick="fireModalCallback('modal-edit-pending')" class="flex-1 px-4 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm transition shadow-sm flex items-center justify-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    Yes, Edit
                </button>
            </div>
        </div>
    </div>
</div>

<style>
@keyframes modalIn {
    from { opacity: 0; transform: scale(0.92) translateY(16px); }
    to   { opacity: 1; transform: scale(1) translateY(0); }
}
.animate-modal-in {
    animation: modalIn 0.22s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
}
</style>

<script>

    // ── Modal helpers ──────────────────────────────────────────────────────────
let _modalCallback = null;

function openModal(id, onConfirm) {
    _modalCallback = onConfirm;
    const modal = document.getElementById(id);
    if (modal) {
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
}

function closeModal(id) {
    const modal = document.getElementById(id);
    if (modal) {
        modal.classList.add('hidden');
        document.body.style.overflow = '';
    }
    _modalCallback = null;
}

// Called directly by each confirm button's onclick
function fireModalCallback(id) {
    // Save callback BEFORE closeModal() runs (closeModal nulls _modalCallback)
    const cb = _modalCallback;
    console.log('[Modal] fireModalCallback called for:', id);
    console.log('[Modal] callback value:', cb);
    closeModal(id);
    if (typeof cb === 'function') {
        console.log('[Modal] Executing callback...');
        cb();
    } else {
        console.warn('[Modal] No callback found - cb is:', cb);
    }
}

// Close on Escape
document.addEventListener('keydown', e => {
    if (e.key === 'Escape') {
        ['modal-remove-employment','modal-delete-pending','modal-delete-verified','modal-edit-pending'].forEach(closeModal);
    }
});

let employmentIndex = {{ count($employments ?? []) }};

function toggleEmployment() {
    const formDiv = document.getElementById('employment-form');
    const chevron = document.getElementById('employment-chevron');
    
    if (formDiv.classList.contains('hidden')) {
        // Expand
        formDiv.classList.remove('hidden');
        chevron.style.transform = 'rotate(90deg)';
        
        // Scroll to card
        setTimeout(() => {
            document.getElementById('employment-card')?.scrollIntoView({ 
                behavior: 'smooth', 
                block: 'start' 
            });
        }, 100);
    } else {
        // Collapse
        formDiv.classList.add('hidden');
        chevron.style.transform = 'rotate(0deg)';
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
    const endDateField = document.querySelector(`.end-date-field[data-index="${index}"] input[type="text"]`);
    const requiredStar = document.querySelector(`.end-date-field[data-index="${index}"] .required-if`);
    
    if (!endDateField) return;
    
    if (checkbox && checkbox.checked) {
        // Still employed = true → End date NOT required, disabled, and cleared
        endDateField.required = false;
        endDateField.disabled = true;
        endDateField.value = '';
        endDateField.setAttribute('disabled', 'disabled'); // Add this for safety
        endDateField.classList.add('bg-gray-100', 'cursor-not-allowed');
        if (requiredStar) requiredStar.classList.add('hidden');
    } else {
        // Still employed = false → End date IS required and enabled
        endDateField.required = true;
        endDateField.disabled = false;
        endDateField.removeAttribute('disabled'); // Remove disabled attribute
        endDateField.classList.remove('bg-gray-100', 'cursor-not-allowed');
        if (requiredStar) requiredStar.classList.remove('hidden');
        
        // Set min date to start date
        const startDateField = document.querySelector(`input[name="employments[${index}][start_date]"]`);
        if (startDateField && startDateField.value) {
            endDateField.setAttribute('min', startDateField.value);
        }
    }
}

// Update start date to set min for end date
function updateStartDate(index) {
    const startDateField = document.querySelector(`input[name="employments[${index}][start_date]"]`);
    const endDateField = document.querySelector(`.end-date-field[data-index="${index}"] input[type="date"]`);
    const checkbox = document.querySelector(`input[name="employments[${index}][still_employed]"]`);
    
    if (startDateField && endDateField && startDateField.value) {
        // Only set min if not still employed
        if (!checkbox || !checkbox.checked) {
            endDateField.setAttribute('min', startDateField.value);
            
            // Clear end date if it's before start date
            if (endDateField.value && endDateField.value < startDateField.value) {
                endDateField.value = '';
            }
        }
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
            
            <!-- Company & Position -->
            <div class="grid md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="text-sm font-medium text-plyform-dark mb-2 block">Company Name <span class="text-plyform-orange">*</span></label>
                    <input type="text" name="employments[${employmentIndex}][company_name]" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all" placeholder="ABC Company Pty Ltd">
                </div>
                <div>
                    <label class="text-sm font-medium text-plyform-dark mb-2 block">Position/Job Title <span class="text-plyform-orange">*</span></label>
                    <input type="text" name="employments[${employmentIndex}][position]" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all" placeholder="Senior Developer">
                </div>
            </div>
            
            <!-- Company Address -->
            <div class="mb-4">
                <label class="text-sm font-medium text-plyform-dark mb-2 block">Company Address <span class="text-plyform-orange">*</span></label>
                <input type="text" name="employments[${employmentIndex}][address]" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all" placeholder="123 Business St, Sydney NSW 2000">
            </div>
            
            <!-- Manager/Supervisor Name -->
            <div class="mb-4">
                <label class="text-sm font-medium text-plyform-dark mb-2 block">Manager/Supervisor Name <span class="text-plyform-orange">*</span></label>
                <input type="text" name="employments[${employmentIndex}][manager_full_name]" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all" placeholder="John Smith">
            </div>
            
            <!-- Contact Details -->
            <div class="grid md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="text-sm font-medium text-plyform-dark mb-2 block">Contact Number <span class="text-plyform-orange">*</span></label>
                    <input 
                        type="tel" 
                        id="employment_contact_${employmentIndex}" 
                        name="employments[${employmentIndex}][contact_number_display]" 
                        required 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all" 
                        placeholder="Enter phone number"
                    >
                    <input type="hidden" id="employment_contact_country_code_${employmentIndex}" name="employments[${employmentIndex}][contact_country_code]" value="+61">
                    <input type="hidden" id="employment_contact_number_clean_${employmentIndex}" name="employments[${employmentIndex}][contact_number]" value="">
                    <p class="mt-1 text-xs text-gray-500">Select country and enter contact number</p>
                </div>
                <div>
                    <label class="text-sm font-medium text-plyform-dark mb-2 block">Email Address <span class="text-plyform-orange">*</span></label>
                    <input type="email" name="employments[${employmentIndex}][email]" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all" placeholder="manager@company.com">
                </div>
            </div>
            
            <!-- Employment Dates -->
            <div class="grid md:grid-cols-3 gap-4 mb-4">
                <div>
                    <label class="text-sm font-medium text-plyform-dark mb-2 block">Start Date <span class="text-plyform-orange">*</span></label>
                    <input type="date" name="employments[${employmentIndex}][start_date]" required max="{{ now()->format('Y-m-d') }}" onchange="updateStartDate(${employmentIndex})" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all">
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
                    <input type="date" name="employments[${employmentIndex}][end_date]" required max="{{ now()->format('Y-m-d') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all end-date-field" data-index="${employmentIndex}">
                </div>
            </div>
            
            <!-- Employment Letter Upload -->
            <div>
                <label class="text-sm font-medium text-plyform-dark mb-2 block">Employment Letter (Optional)</label>
                <div class="space-y-3">
                    <input 
                        type="file" 
                        name="employments[${employmentIndex}][employment_letter]"
                        id="employment_letter_${employmentIndex}"
                        accept=".pdf,.jpg,.jpeg,.png"
                        onchange="previewEmploymentLetter(${employmentIndex})"
                        class="hidden"
                    >
                    
                    <div id="employment_letter_preview_${employmentIndex}" class="space-y-2">
                        <button 
                            type="button" 
                            onclick="document.getElementById('employment_letter_${employmentIndex}').click()"
                            class="w-full px-4 py-3 border-2 border-dashed border-gray-300 rounded-lg hover:border-plyform-purple transition-colors text-center cursor-pointer"
                        >
                            <svg class="w-8 h-8 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                            </svg>
                            <span class="text-sm text-gray-600">Click to upload employment letter</span>
                            <span class="text-xs text-gray-500 block mt-1">PDF, JPG, PNG (Max 10MB)</span>
                        </button>
                    </div>
                </div>
                <p class="mt-1 text-xs text-gray-500">Recommended for verification (PDF, JPG, PNG - Max 10MB)</p>
            </div>
        </div>
    `;
    
    container.insertAdjacentHTML('beforeend', newEmployment);
    
    // Initialize phone input for new employment
    setTimeout(() => {
        initializeEmploymentContactPhone(employmentIndex);
        initializeDatepicker();
    }, 100);
    
    setTimeout(() => {
        employmentIndex++;
    }, 200);
}

// Remove employment (for new/unsaved employments)
function removeEmployment(index) {
    openModal('modal-remove-employment', () => {
        const item = document.querySelector(`.employment-item[data-index="${index}"]`);
        if (item) {
            if (employmentContactPhoneInstances[index]) {
                employmentContactPhoneInstances[index].destroy();
                delete employmentContactPhoneInstances[index];
            }
            item.remove();
            document.querySelectorAll('.employment-item').forEach((el, idx) => {
                const h4 = el.querySelector('h4');
                if (h4) h4.textContent = `Employment ${idx + 1}`;
            });
        }
    });
}

// Initialize end date fields on page load
document.addEventListener('DOMContentLoaded', function() {
    // Loop through all employments and set initial state
    document.querySelectorAll('input[name^="employments"][name$="[still_employed]"]').forEach((checkbox) => {
        // Get index from checkbox name
        const match = checkbox.name.match(/employments\[(\d+)\]/);
        if (match) {
            const index = match[1];
            toggleEndDate(index);
        }
    });
});

// Preview employment letter
function previewEmploymentLetter(index) {
    const input = document.getElementById(`employment_letter_${index}`);
    const previewContainer = document.getElementById(`employment_letter_preview_${index}`);
    
    if (!input || !input.files || input.files.length === 0) {
        return;
    }
    
    const file = input.files[0];
    
    // Validate file size (10MB)
    if (file.size > 10 * 1024 * 1024) {
        alert('File size must be less than 10MB');
        input.value = '';
        return;
    }
    
    // Validate file type
    const validTypes = ['application/pdf', 'image/jpeg', 'image/png', 'image/jpg'];
    if (!validTypes.includes(file.type)) {
        alert('Please select a valid file (PDF, JPG, PNG)');
        input.value = '';
        return;
    }
    
    const fileExtension = file.name.split('.').pop().toLowerCase();
    const isImage = ['jpg', 'jpeg', 'png'].includes(fileExtension);
    
    if (isImage) {
        const reader = new FileReader();
        reader.onload = function(e) {
            // Store the preview URL for viewing
            window[`employment_letter_preview_url_${index}`] = e.target.result;
            
            previewContainer.innerHTML = `
                <div class="relative bg-gray-50 border-2 border-gray-200 rounded-lg p-3">
                    <div class="flex items-center gap-3">
                        <!-- Image Preview -->
                        <img src="${e.target.result}" alt="Employment Letter" class="w-16 h-16 object-cover rounded-lg border-2 border-gray-300">
                        
                        <!-- File Info -->
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate">${file.name}</p>
                            <p class="text-xs text-gray-500">${(file.size / 1024).toFixed(2)} KB</p>
                        </div>
                        
                        <!-- View Button -->
                        <button 
                            type="button" 
                            onclick="viewEmploymentLetter(${index})"
                            class="flex-shrink-0 text-blue-600 hover:text-blue-800 transition p-2 hover:bg-blue-50 rounded-lg"
                            title="View document"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                        
                        <!-- Remove Button -->
                        <button 
                            type="button" 
                            onclick="removeEmploymentLetter(${index})"
                            class="flex-shrink-0 text-red-600 hover:text-red-800 transition p-2 hover:bg-red-50 rounded-lg"
                            title="Remove document"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                        
                        <!-- Re-upload Button -->
                        <button 
                            type="button" 
                            onclick="document.getElementById('employment_letter_${index}').click()"
                            class="flex-shrink-0 text-gray-600 hover:text-gray-800 transition p-2 hover:bg-gray-100 rounded-lg"
                            title="Change document"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                        </button>
                    </div>
                </div>
            `;
        };
        reader.readAsDataURL(file);
    } else {
        // PDF preview - store blob URL for viewing
        const blobUrl = URL.createObjectURL(file);
        window[`employment_letter_preview_url_${index}`] = blobUrl;
        
        previewContainer.innerHTML = `
            <div class="relative bg-gray-50 border-2 border-gray-200 rounded-lg p-3">
                <div class="flex items-center gap-3">
                    <!-- PDF Icon -->
                    <div class="w-16 h-16 bg-red-100 rounded-lg border-2 border-red-300 flex items-center justify-center">
                        <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    
                    <!-- File Info -->
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate">${file.name}</p>
                        <p class="text-xs text-gray-500">${(file.size / 1024).toFixed(2)} KB</p>
                    </div>
                    
                    <!-- View Button -->
                    <button 
                        type="button" 
                        onclick="viewEmploymentLetter(${index})"
                        class="flex-shrink-0 text-blue-600 hover:text-blue-800 transition p-2 hover:bg-blue-50 rounded-lg"
                        title="View document"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </button>
                    
                    <!-- Remove Button -->
                    <button 
                        type="button" 
                        onclick="removeEmploymentLetter(${index})"
                        class="flex-shrink-0 text-red-600 hover:text-red-800 transition p-2 hover:bg-red-50 rounded-lg"
                        title="Remove document"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                    
                    <!-- Re-upload Button -->
                    <button 
                        type="button" 
                        onclick="document.getElementById('employment_letter_${index}').click()"
                        class="flex-shrink-0 text-gray-600 hover:text-gray-800 transition p-2 hover:bg-gray-100 rounded-lg"
                        title="Change document"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                    </button>
                </div>
            </div>
        `;
    }
}

// View employment letter in new tab
function viewEmploymentLetter(index) {
    const previewUrl = window[`employment_letter_preview_url_${index}`];
    if (previewUrl) {
        window.open(previewUrl, '_blank');
    }
}

// Remove employment letter
function removeEmploymentLetter(index) {
    const input = document.getElementById(`employment_letter_${index}`);
    const previewContainer = document.getElementById(`employment_letter_preview_${index}`);
    
    // Clean up blob URL if exists
    const previewUrl = window[`employment_letter_preview_url_${index}`];
    if (previewUrl && previewUrl.startsWith('blob:')) {
        URL.revokeObjectURL(previewUrl);
    }
    delete window[`employment_letter_preview_url_${index}`];
    
    if (input) {
        input.value = '';
    }
    
    if (previewContainer) {
        previewContainer.innerHTML = `
            <button 
                type="button" 
                onclick="document.getElementById('employment_letter_${index}').click()"
                class="w-full px-4 py-3 border-2 border-dashed border-gray-300 rounded-lg hover:border-plyform-purple transition-colors text-center cursor-pointer"
            >
                <svg class="w-8 h-8 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                </svg>
                <span class="text-sm text-gray-600">Click to upload employment letter</span>
                <span class="text-xs text-gray-500 block mt-1">PDF, JPG, PNG (Max 10MB)</span>
            </button>
        `;
    }
}

// Store intl-tel-input instances for employment contacts
var employmentContactPhoneInstances = {};

// Initialize employment contact phone number input
function initializeEmploymentContactPhone(index) {
    const phoneInput = document.querySelector(`#employment_contact_${index}`);
    
    if (!phoneInput) return;
    
    const iti = window.intlTelInput(phoneInput, {
        initialCountry: "au",
        preferredCountries: ["au", "us", "gb", "nz", "sg", "my", "id", "ph"],
        separateDialCode: true,
        nationalMode: false,
        autoPlaceholder: "polite",
        formatOnDisplay: false,
        customPlaceholder: function(selectedCountryPlaceholder, selectedCountryData) {
            return "e.g. " + selectedCountryPlaceholder;
        },
        utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@19.5.6/build/js/utils.js"
    });
    
    // Store instance
    employmentContactPhoneInstances[index] = iti;
    
    // Set initial value if exists
    const existingCountryCode = document.getElementById(`employment_contact_country_code_${index}`).value;
    const existingNumber = document.getElementById(`employment_contact_number_clean_${index}`).value;
    
    if (existingCountryCode && existingNumber) {
        const countryCode = existingCountryCode.replace('+', '');
        const allCountries = window.intlTelInputGlobals.getCountryData();
        const countryData = allCountries.find(country => country.dialCode === countryCode);
        if (countryData) {
            iti.setCountry(countryData.iso2);
        }
        phoneInput.value = existingNumber;
    }
    
    // Update hidden fields on blur
    phoneInput.addEventListener('blur', function() {
        updateEmploymentContactPhoneFields(index);
    });
    
    // Update hidden fields on country change
    phoneInput.addEventListener('countrychange', function() {
        updateEmploymentContactPhoneFields(index);
    });
}

// Update hidden phone fields for employment contact
function updateEmploymentContactPhoneFields(index) {
    const iti = employmentContactPhoneInstances[index];
    if (!iti) return;
    
    const countryData = iti.getSelectedCountryData();
    document.getElementById(`employment_contact_country_code_${index}`).value = '+' + countryData.dialCode;
    
    const fullNumber = iti.getNumber();
    const numberWithoutCode = fullNumber.replace('+' + countryData.dialCode, '').trim();
    document.getElementById(`employment_contact_number_clean_${index}`).value = numberWithoutCode;
}

// Initialize all employment contact phones on page load
document.addEventListener('DOMContentLoaded', function() {
    // Initialize existing employment contact phones
    @foreach($employments as $index => $employment)
        initializeEmploymentContactPhone({{ $index }});
    @endforeach

    // Loop through all employments and set initial state
    document.querySelectorAll('input[name^="employments"][name$="[still_employed]"]').forEach((checkbox) => {
        // Get index from checkbox name
        const match = checkbox.name.match(/employments\[(\d+)\]/);
        if (match) {
            const index = match[1];
            toggleEndDate(index);
        }
    });
});
</script>

<script>
// Confirm edit for pending employment (will resend email)
function confirmEditPendingEmployment(index) {
    openModal('modal-edit-pending', () => {
        const item = document.querySelector(`.employment-item[data-index="${index}"]`);
        if (!item) return;

        // Remove readonly from all input fields
        item.querySelectorAll('input[readonly], select[readonly], textarea[readonly]').forEach(field => {
            field.removeAttribute('readonly');
            field.classList.remove('bg-gray-100', 'cursor-not-allowed');
        });

        // Re-enable disabled checkboxes
        item.querySelectorAll('input[type="checkbox"][disabled]').forEach(cb => {
            cb.removeAttribute('disabled');
        });

        // Re-enable file upload
        const fileInput = item.querySelector('input[type="file"][disabled]');
        if (fileInput) fileInput.removeAttribute('disabled');

        showNotification('Fields are now editable. A new reference email will be sent when you save.', 'warning');

        const editBtn = item.querySelector('button[onclick*="confirmEditPendingEmployment"]');
        if (editBtn) {
            editBtn.textContent = 'Editing...';
            editBtn.classList.add('opacity-50', 'cursor-not-allowed');
            editBtn.disabled = true;
        }
    });
}

// Delete employment with pending reference (with confirmation)
function deleteEmployment(index) {
    openModal('modal-delete-pending', () => {
        const item = document.querySelector(`.employment-item[data-index="${index}"]`);
        if (item) {
            if (employmentContactPhoneInstances[index]) {
                employmentContactPhoneInstances[index].destroy();
                delete employmentContactPhoneInstances[index];
            }
            item.remove();
            document.querySelectorAll('.employment-item').forEach((el, idx) => {
                const h4 = el.querySelector('h4');
                if (h4) h4.textContent = `Employment ${idx + 1}`;
            });
        }
    });
}

// Delete verified employment (with stronger confirmation)
function deleteVerifiedEmployment(index) {
    openModal('modal-delete-verified', () => {
        const item = document.querySelector(`.employment-item[data-index="${index}"]`);
        if (item) {
            if (employmentContactPhoneInstances[index]) {
                employmentContactPhoneInstances[index].destroy();
                delete employmentContactPhoneInstances[index];
            }
            item.remove();
            document.querySelectorAll('.employment-item').forEach((el, idx) => {
                const h4 = el.querySelector('h4');
                if (h4) h4.textContent = `Employment ${idx + 1}`;
            });
        }
    });
}

// Show notification helper
function showNotification(message, type = 'info') {
    const colors = {
        info: 'bg-blue-100 text-blue-800 border-blue-200',
        warning: 'bg-yellow-100 text-yellow-800 border-yellow-200',
        success: 'bg-green-100 text-green-800 border-green-200',
        error: 'bg-red-100 text-red-800 border-red-200'
    };
    
    const icons = {
        info: '<path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>',
        warning: '<path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>',
        success: '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>',
        error: '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>'
    };
    
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 ${colors[type]} px-4 py-3 rounded-lg shadow-lg border z-50 max-w-md`;
    notification.innerHTML = `
        <div class="flex items-start gap-3">
            <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                ${icons[type]}
            </svg>
            <span class="text-sm">${message}</span>
        </div>
    `;
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.style.opacity = '0';
        notification.style.transition = 'opacity 0.3s';
        setTimeout(() => notification.remove(), 300);
    }, 5000);
}
</script>