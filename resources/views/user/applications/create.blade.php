@extends('layouts.user')

@section('title', 'New Application')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="grid lg:grid-cols-3 gap-8">
            
            <!-- Left Column - Property Preview -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 sticky top-8">
                    
                    <!-- Property Image -->
                    @if($property->images->count() > 0)
                        <div class="relative mb-4 rounded-xl overflow-hidden group">
                            <img 
                                src="{{ Storage::url($property->images->first()->image_path) }}" 
                                alt="{{ $property->headline }}"
                                class="w-full h-48 object-cover"
                            >
                            @if($property->images->count() > 1)
                                <div class="absolute top-3 left-3 bg-white/90 backdrop-blur px-3 py-1 rounded-full text-sm font-semibold text-gray-700">
                                    📸 {{ $property->images->count() }} photos
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="w-full h-48 bg-gray-100 rounded-xl flex items-center justify-center mb-4">
                            <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                    @endif
                    
                    <!-- Property Title -->
                    <h2 class="text-xl font-bold text-gray-900 mb-2">{{ $property->headline ?? $property->short_address }}</h2>
                    
                    <!-- Property Details -->
                    <div class="space-y-3 mb-4">
                        <div class="flex items-center gap-2 text-sm text-gray-600">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            {{ $property->street_address }}, {{ $property->suburb }} {{ $property->state }} {{ $property->postcode }}
                        </div>
                    </div>
                    
                    <!-- Property Stats -->
                    <div class="flex items-center gap-4 py-3 border-y border-gray-200 mb-4">
                        @if($property->bedrooms)
                            <div class="flex items-center gap-1.5 text-gray-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                </svg>
                                <span class="text-sm font-medium">{{ $property->bedrooms }}</span>
                            </div>
                        @endif
                        
                        @if($property->bathrooms)
                            <div class="flex items-center gap-1.5 text-gray-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <span class="text-sm font-medium">{{ $property->bathrooms }}</span>
                            </div>
                        @endif
                        
                        @if($property->parking)
                            <div class="flex items-center gap-1.5 text-gray-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                                </svg>
                                <span class="text-sm font-medium">{{ $property->parking }}</span>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Rent/Price -->
                    <div class="mb-4">
                        <div class="text-sm text-gray-600 mb-1">Rent</div>
                        <div class="text-2xl font-bold text-gray-900">${{ number_format($property->rent_per_week) }} <span class="text-base font-normal text-gray-600">per week</span></div>
                    </div>
                    
                    <div class="mb-4">
                        <div class="text-sm text-gray-600 mb-1">Bond</div>
                        <div class="text-xl font-bold text-gray-900">${{ number_format($property->bond_amount ?? ($property->rent_per_week * 4)) }}</div>
                    </div>
                    
                    <div class="mb-6">
                        <div class="text-sm text-gray-600 mb-1">Available</div>
                        <div class="text-base font-semibold text-gray-900">{{ \Carbon\Carbon::parse($property->available_date)->format('d M Y') }}</div>
                    </div>
                    
                    <!-- Property Inspection Question -->
                    <div class="bg-gray-50 rounded-xl p-4">
                        <div class="text-sm font-semibold text-gray-900 mb-3">Have you inspected the property?</div>
                        
                        <div class="space-y-2">
                            <label class="flex items-start cursor-pointer group">
                                <input 
                                    type="radio" 
                                    name="sidebar_inspection" 
                                    value="yes"
                                    class="mt-1 text-teal-600 focus:ring-teal-500"
                                    onchange="syncInspectionChoice('yes')"
                                >
                                <div class="ml-3">
                                    <span class="text-sm font-medium text-gray-900 group-hover:text-teal-600">Yes, I have or plan to inspect the property</span>
                                </div>
                            </label>
                            
                            <label class="flex items-start cursor-pointer group">
                                <input 
                                    type="radio" 
                                    name="sidebar_inspection" 
                                    value="no"
                                    checked
                                    class="mt-1 text-teal-600 focus:ring-teal-500"
                                    onchange="syncInspectionChoice('no')"
                                >
                                <div class="ml-3">
                                    <span class="text-sm font-medium text-gray-900 group-hover:text-teal-600">No, I accept the property as is</span>
                                </div>
                            </label>
                        </div>
                        
                        <!-- Inspection Date Field (conditional) -->
                        <div id="inspection-date-sidebar" class="mt-3 hidden">
                            <label class="text-sm font-medium text-gray-700 mb-2 block">Inspection Date</label>
                            <input 
                                type="date"
                                id="sidebar_inspection_date"
                                min="{{ date('Y-m-d') }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-500"
                            >
                        </div>
                        
                        <div id="inspection-info-sidebar" class="mt-3 bg-blue-50 border border-blue-200 rounded-lg p-3">
                            <div class="flex items-start gap-2">
                                <svg class="w-4 h-4 text-blue-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                </svg>
                                <p class="text-xs text-blue-700">Inspecting a property before applying can show property managers that you're serious</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Lease Details Quick Form -->
                    <div class="mt-6 space-y-4">
                        <div>
                            <label class="text-sm font-medium text-gray-700 mb-2 block">Preferred lease start date</label>
                            <input 
                                type="date"
                                id="sidebar_move_in_date"
                                name="sidebar_move_in_date"
                                min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-teal-500"
                                placeholder="Day Month Year"
                                onchange="syncMoveInDate(this.value)"
                            >
                        </div>
                        
                        <div>
                            <label class="text-sm font-medium text-gray-700 mb-2 block">Initial lease term (months)</label>
                            <div class="grid grid-cols-4 gap-2">
                                <button type="button" onclick="setLeaseTerm(6)" class="lease-term-btn px-3 py-2 border-2 border-gray-300 rounded-lg text-sm font-semibold hover:border-teal-500 hover:bg-teal-50 transition">6</button>
                                <button type="button" onclick="setLeaseTerm(12)" class="lease-term-btn px-3 py-2 border-2 border-teal-500 bg-teal-50 rounded-lg text-sm font-semibold transition">12</button>
                                <button type="button" onclick="setLeaseTerm(18)" class="lease-term-btn px-3 py-2 border-2 border-gray-300 rounded-lg text-sm font-semibold hover:border-teal-500 hover:bg-teal-50 transition">18</button>
                                <button type="button" onclick="setLeaseTerm(24)" class="lease-term-btn px-3 py-2 border-2 border-gray-300 rounded-lg text-sm font-semibold hover:border-teal-500 hover:bg-teal-50 transition">24</button>
                            </div>
                        </div>
                        
                        <div>
                            <label class="text-sm font-medium text-gray-700 mb-2 block">
                                Rent per week <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500 font-semibold">$</span>
                                <input 
                                    type="number"
                                    id="rent_per_week_input"
                                    value="{{ number_format($property->rent_per_week, 2, '.', '') }}"
                                    required
                                    min="0"
                                    step="0.01"
                                    class="w-full pl-8 pr-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all"
                                    placeholder="Enter weekly rent amount"
                                >
                            </div>
                            <p class="mt-1 text-xs text-gray-500">Enter the weekly rent amount for this property</p>
                        </div>
                    </div>
                    
                </div>
            </div>
            
            <!-- Right Column - Application Steps -->
            <div class="lg:col-span-2">
                
                <!-- Progress Header -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-4">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">Application Progress</h1>
                            <p class="text-sm text-gray-600 mt-1">Review and complete your application</p>
                        </div>
                        <div class="text-right">
                            <div class="text-3xl font-bold text-teal-600" id="progress-percentage">0%</div>
                            <div class="text-xs text-gray-600">Complete</div>
                        </div>
                    </div>
                    
                    <!-- Progress Bar -->
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div id="progress-bar" class="bg-gradient-to-r from-teal-500 to-teal-600 h-2 rounded-full transition-all duration-500" style="width: 0%"></div>
                    </div>
                </div>

                <!-- Alert Messages -->
                @if(session('success'))
                    <div class="mb-6 bg-green-50 border border-green-200 rounded-xl p-4">
                        <div class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-green-600 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <p class="text-sm text-green-800">{{ session('success') }}</p>
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 bg-red-50 border border-red-200 rounded-xl p-4">
                        <div class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-red-600 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                            <p class="text-sm text-red-800">{{ session('error') }}</p>
                        </div>
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-6 bg-red-50 border border-red-200 rounded-xl p-4">
                        <div class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-red-600 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                            <div class="flex-1">
                                <p class="text-sm font-semibold text-red-800 mb-1">Please fix the following errors:</p>
                                <ul class="text-sm text-red-700 list-disc list-inside space-y-1">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif
                    
                    <!-- Section Cards -->
                    <div class="space-y-4">

                        <!-- Section 0: About You (State Selection) -->
                        @include('user.profile.cards.about-you-card', ['mode' => 'application'])
                        
                        <!-- Section 1: Personal Details -->
                        @include('user.profile.cards.personal-details-card', ['mode' => 'application'])
                        
                        <!-- Section 2: Introduction -->
                        @include('user.profile.cards.introduction-card', ['mode' => 'application'])
                        
                        <!-- Section 3: Current Income -->
                        @include('user.profile.cards.income-card', ['mode' => 'application'])
                        
                        <!-- Section 4: Employment -->
                        @include('user.profile.cards.employment-card', ['mode' => 'application'])
                        
                        <!-- Section 5: Pets -->
                        @include('user.profile.cards.pets-card', ['mode' => 'application'])
                        
                        <!-- Section 6: Vehicles -->
                        @include('user.profile.cards.vehicles-card', ['mode' => 'application'])
                        
                        <!-- Section 7: Address History -->
                        @include('user.profile.cards.address-history-card', ['mode' => 'application'])
                        
                        <!-- Section 9: Identification -->
                        @include('user.profile.cards.identification-card', ['mode' => 'application'])

                        <div class="flex items-center my-8">
                            <div class="flex-grow border-t border-gray-300 dark:border-gray-600"></div>
                            <span class="mx-4 text-sm font-semibold text-gray-500 dark:text-gray-400">
                                Application Details
                            </span>
                            <div class="flex-grow border-t border-gray-300 dark:border-gray-600"></div>
                        </div>

                        <form method="POST" action="{{ route('user.applications.store') }}" id="application-form">
                            @csrf
                            <input type="hidden" name="property_id" value="{{ $property->id }}">
                            <input type="hidden" name="move_in_date" id="move_in_date_hidden" value="{{ old('move_in_date') }}">
                            <input type="hidden" name="lease_term" id="lease_term_hidden" value="{{ old('lease_term', 12) }}">
                            <input type="hidden" name="rent_per_week" id="rent_per_week_hidden">
                            <input type="hidden" name="property_inspection" id="property_inspection_hidden" value="{{ old('property_inspection', 'no') }}">
                            <input type="hidden" name="inspection_date" id="inspection_date_hidden" value="{{ old('inspection_date') }}">

                        <!-- Household -->
                        @include('user.applications.cards.household-card')

                        <!-- Utility Connection Service -->
                        @include('user.applications.cards.utility-connections-card')
                        
                        <!-- Additional Notes -->
                        @include('user.applications.cards.additional-notes-card')

                        <!-- Terms and Conditions -->
                        @include('user.applications.cards.terms-conditions-card')
                        
                    </div>
                    
                    <!-- Terms and Conditions -->
                    <div class="mt-6 bg-gray-50 rounded-xl p-6">
                        <p class="text-sm text-gray-600 mb-4 text-center">
                            By submitting an application, you accept our 
                            <a href="#" class="text-teal-600 hover:underline">Terms and conditions</a> 
                            and the 
                            <a href="#" class="text-teal-600 hover:underline">Personal Information Declaration Statement</a>.
                        </p>
                        
                        <!-- Submit Button -->
                       <button 
                            type="submit"
                            id="submit-btn"
                            disabled
                            class="w-full bg-gradient-to-r from-[#0d9488] to-[#0f766e] text-white font-bold py-4 rounded-xl
                                hover:from-[#0f766e] hover:to-[#115e59]
                                transition shadow-lg text-lg opacity-50 cursor-not-allowed"
                        >
                            Submit application
                        </button>

                        <p class="text-sm text-gray-600 mb-4 text-center mt-4">
                            Your application will be sent to <br>
                            <strong>{{ $property->headline }}</strong>
                        </p>

                    </div>
                    
                </form>
                
            </div>
            
        </div>
        
    </div>
</div>

<script>
    // Section toggle
    function toggleSection(sectionId) {
        const card = document.querySelector(`[data-section="${sectionId}"]`);
        const content = card.querySelector('.section-content');
        const chevron = card.querySelector('.section-chevron');
        
        const isHidden = content.classList.contains('hidden');
        
        if (isHidden) {
            content.classList.remove('hidden');
            chevron.style.transform = 'rotate(90deg)';
        } else {
            content.classList.add('hidden');
            chevron.style.transform = 'rotate(0deg)';
        }
        
        updateProgress();
    }

    // Update progress
    function updateProgress() {
        // Define which sections are required vs optional
        const requiredSections = [
            'about_me',
            'personal_details',
            'address_history',
            'employment',
            'finances',
            'identity_documents',
            'household',
            'terms_conditions'
        ];
        
        const optionalSections = [
            'emergency_contact',
            'pets',
            'utility_connections',
            'additional_notes'
        ];
        
        // Count only required sections
        let completedCount = 0;
        
        requiredSections.forEach(sectionId => {
            const statusIcon = document.querySelector(`#status_${sectionId}`);
            if (statusIcon && statusIcon.classList.contains('bg-teal-100')) {
                completedCount++;
            }
        });
        
        const totalRequired = requiredSections.length;
        const percentage = Math.round((completedCount / totalRequired) * 100);
        
        // Update progress display
        const progressPercentage = document.getElementById('progress-percentage');
        const progressBar = document.getElementById('progress-bar');
        
        if (progressPercentage) {
            progressPercentage.textContent = percentage + '%';
        }
        
        if (progressBar) {
            progressBar.style.width = percentage + '%';
            
            // Change color based on progress
            if (percentage === 100) {
                progressBar.className = 'bg-gradient-to-r from-teal-500 to-teal-600 h-2 rounded-full transition-all duration-500';
            } else if (percentage >= 70) {
                progressBar.className = 'bg-gradient-to-r from-teal-500 to-teal-600 h-2 rounded-full transition-all duration-500';
            } else {
                progressBar.className = 'bg-gradient-to-r from-teal-500 to-teal-600 h-2 rounded-full transition-all duration-500';
            }
        }
    }

    // Sync inspection choice
    function syncInspectionChoice(value) {
        document.getElementById('property_inspection_hidden').value = value;
        
        // Show/hide inspection date field
        const inspectionDateSidebar = document.getElementById('inspection-date-sidebar');
        if (value === 'yes') {
            inspectionDateSidebar.classList.remove('hidden');
            document.getElementById('inspection-info-sidebar').classList.add('hidden');
        } else {
            inspectionDateSidebar.classList.add('hidden');
            document.getElementById('inspection-info-sidebar').classList.remove('hidden');
            document.getElementById('sidebar_inspection_date').value = '';
            document.getElementById('inspection_date_hidden').value = '';
        }
    }

    const elem = document.getElementById('sidebar_inspection_date');
    elem.addEventListener('changeDate', function (e) {
        document.getElementById('inspection_date_hidden').value = elem.value;
    });

    // Sync move-in date
    function syncMoveInDate(value) {
        document.getElementById('move_in_date_hidden').value = value;
        console.log('Move-in date synced:', value); // Debug log
    }

    // Set lease term
    function setLeaseTerm(months) {
        document.getElementById('lease_term_hidden').value = months;
        
        // Update button styles
        document.querySelectorAll('.lease-term-btn').forEach(btn => {
            btn.classList.remove('border-teal-500', 'bg-teal-50');
            btn.classList.add('border-gray-300');
        });
        
        event.target.classList.remove('border-gray-300');
        event.target.classList.add('border-teal-500', 'bg-teal-50');
    }

    // Form submission handling
    document.addEventListener('DOMContentLoaded', function() {
        updateProgress();
        
        const form = document.getElementById('application-form');
        const submitBtn = document.getElementById('submit-btn');
        
        // Disable HTML5 validation to handle it ourselves
        form.setAttribute('novalidate', 'novalidate');
        
        form.addEventListener('submit', async function (e) {
            e.preventDefault(); // Prevent default first, we'll submit manually if valid

            // ENSURE move-in date is synced FIRST
            const sidebarMoveIn = document.getElementById('sidebar_move_in_date');
            const hiddenMoveIn = document.getElementById('move_in_date_hidden');
            if (sidebarMoveIn && sidebarMoveIn.value && hiddenMoveIn) {
                hiddenMoveIn.value = sidebarMoveIn.value;
            }

            // Copy sidebar values to hidden fields
            const rentInput = document.getElementById('rent_per_week_input');
            const rentHidden = document.getElementById('rent_per_week_hidden');
            
            if (rentInput && rentHidden) {
                rentHidden.value = rentInput.value;
            }
            
            // Validate rent
            if (!rentInput || !rentInput.value || parseFloat(rentInput.value) <= 0) {
                alert('Please enter a valid rent amount.');
                rentInput.focus();
                return false;
            }
            
            // Clear any existing error messages
            document.querySelectorAll('.field-error-message').forEach(el => el.remove());
            document.querySelectorAll('.border-red-500').forEach(el => {
                el.classList.remove('border-red-500');
            });
            
            // Object to store first error found
            let firstError = null;
            
            // Helper function to show error on field
            function showFieldError(field, message, sectionName = null) {
                if (!firstError) {
                    firstError = { field, message, sectionName };
                }
                
                // Add red border to field
                field.classList.add('border-red-500');
                
                // Create error message element
                const errorEl = document.createElement('p');
                errorEl.className = 'field-error-message mt-1 text-sm text-red-600 font-medium';
                errorEl.textContent = message;
                
                // Insert error message after the field
                if (field.parentElement) {
                    field.parentElement.appendChild(errorEl);
                }
            }
            
            // 1. Validate Terms & Conditions (check this first as it's at the bottom)
            const acceptTerms = document.getElementById('accept_terms');
            const declareAccuracy = document.getElementById('declare_accuracy');
            const consentPrivacy = document.getElementById('consent_privacy');
            
            if (!acceptTerms?.checked) {
                showFieldError(acceptTerms, 'You must accept the Terms and Conditions to submit.', 'terms_conditions');
            }
            if (!declareAccuracy?.checked) {
                showFieldError(declareAccuracy, 'You must declare that all information is accurate.', 'terms_conditions');
            }
            if (!consentPrivacy?.checked) {
                showFieldError(consentPrivacy, 'You must consent to privacy collection.', 'terms_conditions');
            }
            
            // 7. Validate Household (always required)
            const numOccupants = document.querySelector('input[name="number_of_occupants"]');
            if (!numOccupants?.value || numOccupants.value < 1) {
                showFieldError(numOccupants, 'Number of occupants is required (minimum 1).', 'household');
            }
            
            const primaryFirstName = document.querySelector('input[name="occupants_details[0][first_name]"]');
            if (!primaryFirstName?.value || primaryFirstName.value.trim() === '') {
                showFieldError(primaryFirstName, 'Primary applicant first name is required.', 'household');
            }
            
            const primaryLastName = document.querySelector('input[name="occupants_details[0][last_name]"]');
            if (!primaryLastName?.value || primaryLastName.value.trim() === '') {
                showFieldError(primaryLastName, 'Primary applicant last name is required.', 'household');
            }
            
            const primaryAge = document.querySelector('input[name="occupants_details[0][age]"]');
            if (!primaryAge?.value) {
                showFieldError(primaryAge, 'Primary applicant age is required.', 'household');
            } else if (parseInt(primaryAge.value) < 18) {
                showFieldError(primaryAge, 'Primary applicant must be 18 years or older.', 'household');
            }
            
            // 8. Validate Pets IF checkbox is checked
            const hasPets = document.getElementById('has-pets');
            if (hasPets?.checked) {
                const petType0 = document.querySelector('select[name="pets[0][type]"]');
                if (!petType0?.value) {
                    showFieldError(petType0, 'Pet type is required.', 'pets');
                }
                
                const petBreed0 = document.querySelector('input[name="pets[0][breed]"]');
                if (!petBreed0?.value || petBreed0.value.trim() === '') {
                    showFieldError(petBreed0, 'Pet breed is required.', 'pets');
                }
                
                const petDesexed0 = document.querySelector('select[name="pets[0][desexed]"]');
                if (!petDesexed0?.value && petDesexed0?.value !== '0') {
                    showFieldError(petDesexed0, 'Please specify if pet is desexed.', 'pets');
                }
                
                const petSize0 = document.querySelector('select[name="pets[0][size]"]');
                if (!petSize0?.value) {
                    showFieldError(petSize0, 'Pet size is required.', 'pets');
                }
            }
            
            // 9. Validate move-in date from sidebar
            const moveInDate = document.getElementById('move_in_date_hidden');
            if (!moveInDate?.value) {
                // Show error in sidebar
                const moveInDateDisplay = document.getElementById('sidebar_move_in_date');
                if (moveInDateDisplay) {
                    moveInDateDisplay.classList.add('border-2', 'border-red-500');
                    
                    const errorEl = document.createElement('p');
                    errorEl.className = 'field-error-message mt-2 text-sm text-red-600 font-medium';
                    errorEl.textContent = 'Please select a move-in date.';
                    moveInDateDisplay.parentElement.appendChild(errorEl);
                    
                    if (!firstError) {
                        firstError = { 
                            field: moveInDateDisplay, 
                            message: 'Please select a move-in date.', 
                            sectionName: null,
                            isSidebar: true
                        };
                    }
                }
            }

            // 10. Validate rent per week from sidebar
            const rentPerWeek = document.getElementById('rent_per_week_hidden');
            const rentPerWeekInput = document.getElementById('rent_per_week_input');
            if (!rentPerWeek?.value || parseFloat(rentPerWeek.value) <= 0) {
                // Show error in sidebar
                if (rentPerWeekInput) {
                    rentPerWeekInput.classList.add('border-2', 'border-red-500');
                    
                    const errorEl = document.createElement('p');
                    errorEl.className = 'field-error-message mt-2 text-sm text-red-600 font-medium';
                    errorEl.textContent = 'Please enter a valid rent amount.';
                    rentPerWeekInput.parentElement.appendChild(errorEl);
                    
                    if (!firstError) {
                        firstError = { 
                            field: rentPerWeekInput, 
                            message: 'Please enter a valid rent amount.', 
                            sectionName: null,
                            isSidebar: true
                        };
                    }
                }
            }
            
            // If there are errors, focus on first error
            if (firstError) {
                // If error is in a collapsible section, open it
                if (firstError.sectionName) {
                    const sectionContent = document.querySelector(`[data-section="${firstError.sectionName}"] .section-content`);
                    if (sectionContent && sectionContent.classList.contains('hidden')) {
                        toggleSection(firstError.sectionName);
                    }
                }
                
                // Scroll to and focus the field
                setTimeout(() => {
                    if (firstError.isSidebar) {
                        // For sidebar elements, just scroll to them
                        firstError.field.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    } else {
                        // For form fields, scroll and focus
                        firstError.field.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        firstError.field.focus();
                    }
                    
                    // Show toast notification with error count
                    const errorCount = document.querySelectorAll('.field-error-message').length;
                    showToast(`Please fix ${errorCount} error${errorCount > 1 ? 's' : ''} to submit your application.`, 'error');
                }, 300);
                
                return false;
            }
            
            // ============================================
            // All validation passed - PREPARE FOR SUBMIT
            // ============================================

            // Disable submit button
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="flex items-center justify-center gap-2"><svg class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Submitting...</span>';

            // Use HTMLFormElement.submit() method which preserves all data including files
            // DO NOT use form.submit() - use requestSubmit() instead to trigger native form submission
            // form.requestSubmit();
            // form.submit();

            try {
                const response = await fetch('{{ route("user.applications.store") }}', {
                    method: 'POST',
                    body: new FormData(form),
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });

                const result = await response.json();

                if (!response.ok) {
                    // Handle validation errors
                    if (response.status === 422 && result.errors) {
                        let errorMessage = 'Please fix the following errors:\n\n';
                        Object.keys(result.errors).forEach(key => {
                            errorMessage += `• ${result.errors[key][0]}\n`;
                        });
                        alert(errorMessage);
                    } else {
                        // Handle other errors
                        alert(result.message || 'Failed to submit application');
                    }
                    throw new Error(result.message || 'Failed to submit');
                }

                // ✅ Success - redirect to application show page
                // alert(result.message);
                window.location.href = result.redirect_url;

            } catch (error) {
                console.error('Submission error:', error);
            } finally {
                submitBtn.disabled = false;
                submitBtn.innerHTML = 'Submit application';
            }
        });
    });

    // Toast notification helper
    function showToast(message, type = 'error') {
        // Remove existing toasts
        document.querySelectorAll('.validation-toast').forEach(el => el.remove());
        
        const toast = document.createElement('div');
        toast.className = 'validation-toast fixed top-20 right-4 z-50 max-w-md px-6 py-4 rounded-lg shadow-lg transform transition-all duration-300 translate-x-0';
        
        if (type === 'error') {
            toast.classList.add('bg-red-50', 'border-2', 'border-red-500', 'text-red-800');
            toast.innerHTML = `
                <div class="flex items-start gap-3">
                    <svg class="w-6 h-6 text-red-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                    <div class="flex-1">
                        <p class="font-semibold mb-1">Validation Error</p>
                        <p class="text-sm">${message}</p>
                    </div>
                    <button onclick="this.parentElement.parentElement.remove()" class="text-red-500 hover:text-red-700">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                </div>
            `;
        }
        
        document.body.appendChild(toast);
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            toast.style.transform = 'translateX(120%)';
            setTimeout(() => toast.remove(), 300);
        }, 5000);
    }
</script>
@endsection

@include('user.profile.js')