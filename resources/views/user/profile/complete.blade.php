@extends('layouts.app')

@push('styles')
<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<!-- Flatpickr CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<!-- Custom styles -->
<style>
    /* Select2 Styling */
    .select2-container {
        width: 100% !important;
    }
    .select2-container .select2-selection--single {
        height: 42px !important;
        border-radius: 0.5rem !important;
        border: 1px solid #D1D5DB !important;
        padding: 0.5rem 1rem !important;
        display: flex !important;
        align-items: center !important;
    }
    .select2-container .select2-selection--single .select2-selection__rendered {
        padding-left: 0 !important;
        line-height: normal !important;
    }
    .select2-container--focus .select2-selection--single,
    .select2-container--open .select2-selection--single {
        border-color: #3B82F6 !important;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1) !important;
    }
    .select2-dropdown {
        border-radius: 0.5rem !important;
        border: 1px solid #D1D5DB !important;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }
    .select2-results__option {
        padding: 0.75rem 1rem !important;
    }
    .select2-results__option--highlighted {
        background-color: #3B82F6 !important;
    }
    
    /* Error state for Select2 */
    .select2-container.select2-error .select2-selection--single {
        border-color: #EF4444 !important;
    }
    
    /* Required field indicator */
    .required-field::after {
        content: ' *';
        color: #EF4444;
        font-weight: bold;
    }
    
    /* Input error state */
    .input-error {
        border-color: #EF4444 !important;
        background-color: #FEF2F2;
    }
    .input-error:focus {
        ring-color: #EF4444 !important;
    }
    
    /* Flatpickr styling */
    .flatpickr-input {
        background-color: white !important;
    }
    
    /* Mobile optimizations */
    @media (max-width: 640px) {
        .select2-container .select2-selection--single {
            font-size: 0.9rem;
        }
        .select2-results__option {
            font-size: 0.9rem;
            padding: 0.625rem 0.875rem !important;
        }
    }
    
    /* Animation for alerts */
    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    .alert-animated {
        animation: slideDown 0.3s ease-out;
    }
</style>
@endpush

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-50 py-4 sm:py-8">
    <div class="max-w-4xl mx-auto px-3 sm:px-4 lg:px-6">
        
        <!-- Alert Messages -->
        <div id="alertContainer" class="mb-4"></div>

        <!-- Header -->
        <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6 mb-4 sm:mb-6">
            <h1 class="text-xl sm:text-2xl font-bold text-gray-900 mb-2">Complete Your Profile</h1>
            <p class="text-sm sm:text-base text-gray-600">Please fill in all required information to apply for properties</p>
            
            @if($profile->exists && $profile->status === 'rejected')
                <div class="mt-4 bg-red-50 border border-red-200 rounded-lg p-3 sm:p-4 alert-animated">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-red-600 mt-0.5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        <div>
                            <h3 class="text-sm font-medium text-red-800">Profile Rejected</h3>
                            <p class="mt-1 text-sm text-red-700">{{ $profile->rejection_reason }}</p>
                            <p class="mt-2 text-sm text-red-700">Please update your information and resubmit.</p>
                        </div>
                    </div>
                </div>
            @elseif($profile->exists && $profile->status === 'pending')
                <div class="mt-4 bg-yellow-50 border border-yellow-200 rounded-lg p-3 sm:p-4 alert-animated">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-yellow-600 mt-0.5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                        </svg>
                        <div>
                            <h3 class="text-sm font-medium text-yellow-800">Pending Approval</h3>
                            <p class="mt-1 text-sm text-yellow-700">Your profile is currently under review by our team.</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Progress Bar -->
        <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6 mb-4 sm:mb-6">
            <div class="flex items-center justify-between mb-3">
                <span class="text-sm font-medium text-gray-700">Progress</span>
                <span class="text-sm font-medium text-blue-600">Step {{ $currentStep }} of 10</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-3">
                <div id="progressBar" class="bg-gradient-to-r from-blue-500 to-indigo-600 h-3 rounded-full transition-all duration-500 ease-out" 
                     style="width: {{ ($currentStep / 10) * 100 }}%"></div>
            </div>
            
            <!-- Step Icons Grid -->
            <div class="grid grid-cols-5 gap-2 mt-4 text-xs sm:text-sm">
                <div class="flex flex-col items-center {{ $currentStep >= 1 ? 'text-blue-600' : 'text-gray-400' }}">
                    <svg class="w-6 h-6 sm:w-8 sm:h-8 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    <span class="text-center font-medium hidden sm:block">Personal</span>
                    <span class="text-center font-medium sm:hidden">1</span>
                </div>
                <div class="flex flex-col items-center {{ $currentStep >= 2 ? 'text-blue-600' : 'text-gray-400' }}">
                    <svg class="w-6 h-6 sm:w-8 sm:h-8 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    <span class="text-center font-medium hidden sm:block">About</span>
                    <span class="text-center font-medium sm:hidden">2</span>
                </div>
                <div class="flex flex-col items-center {{ $currentStep >= 3 ? 'text-blue-600' : 'text-gray-400' }}">
                    <svg class="w-6 h-6 sm:w-8 sm:h-8 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="text-center font-medium hidden sm:block">Income</span>
                    <span class="text-center font-medium sm:hidden">3</span>
                </div>
                <div class="flex flex-col items-center {{ $currentStep >= 4 ? 'text-blue-600' : 'text-gray-400' }}">
                    <svg class="w-6 h-6 sm:w-8 sm:h-8 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    <span class="text-center font-medium hidden sm:block">Work</span>
                    <span class="text-center font-medium sm:hidden">4</span>
                </div>
                <div class="flex flex-col items-center {{ $currentStep >= 5 ? 'text-blue-600' : 'text-gray-400' }}">
                    <svg class="w-6 h-6 sm:w-8 sm:h-8 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-2 1m2-1l-2-1m2 1v2.5M14 4l-2-1-2 1M4 7l2-1M4 7l2 1M4 7v2.5M12 21l-2-1m2 1l2-1m-2 1v-2.5M6 18l-2-1v-2.5M18 18l2-1v-2.5"/>
                    </svg>
                    <span class="text-center font-medium hidden sm:block">Pets</span>
                    <span class="text-center font-medium sm:hidden">5</span>
                </div>
            </div>
            <div class="grid grid-cols-5 gap-2 mt-3 text-xs sm:text-sm">
                <div class="flex flex-col items-center {{ $currentStep >= 6 ? 'text-blue-600' : 'text-gray-400' }}">
                    <svg class="w-6 h-6 sm:w-8 sm:h-8 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"/>
                    </svg>
                    <span class="text-center font-medium hidden sm:block">Vehicles</span>
                    <span class="text-center font-medium sm:hidden">6</span>
                </div>
                <div class="flex flex-col items-center {{ $currentStep >= 7 ? 'text-blue-600' : 'text-gray-400' }}">
                    <svg class="w-6 h-6 sm:w-8 sm:h-8 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <span class="text-center font-medium hidden sm:block">Address</span>
                    <span class="text-center font-medium sm:hidden">7</span>
                </div>
                <div class="flex flex-col items-center {{ $currentStep >= 8 ? 'text-blue-600' : 'text-gray-400' }}">
                    <svg class="w-6 h-6 sm:w-8 sm:h-8 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    <span class="text-center font-medium hidden sm:block">References</span>
                    <span class="text-center font-medium sm:hidden">8</span>
                </div>
                <div class="flex flex-col items-center {{ $currentStep >= 9 ? 'text-blue-600' : 'text-gray-400' }}">
                    <svg class="w-6 h-6 sm:w-8 sm:h-8 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/>
                    </svg>
                    <span class="text-center font-medium hidden sm:block">ID</span>
                    <span class="text-center font-medium sm:hidden">9</span>
                </div>
                <div class="flex flex-col items-center {{ $currentStep >= 10 ? 'text-blue-600' : 'text-gray-400' }}">
                    <svg class="w-6 h-6 sm:w-8 sm:h-8 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="text-center font-medium hidden sm:block">Terms</span>
                    <span class="text-center font-medium sm:hidden">10</span>
                </div>
            </div>
        </div>

        <!-- Form Content -->
        <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6">
            <form id="profileForm" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="step" id="currentStepInput" value="{{ $currentStep }}">

                <!-- Step 1: Personal Details -->
                <div class="step-content" data-step="1" style="{{ $currentStep == 1 ? '' : 'display:none;' }}">
                    @include('user.profile.steps.step1', ['profile' => $profile])
                </div>

                <!-- Step 2: Introduction -->
                <div class="step-content" data-step="2" style="{{ $currentStep == 2 ? '' : 'display:none;' }}">
                    @include('user.profile.steps.step2', ['profile' => $profile])
                </div>

                <!-- Step 3: Income -->
                <div class="step-content" data-step="3" style="{{ $currentStep == 3 ? '' : 'display:none;' }}">
                    @include('user.profile.steps.step3', ['incomes' => $user->incomes])
                </div>

                <!-- Step 4: Employment -->
                <div class="step-content" data-step="4" style="{{ $currentStep == 4 ? '' : 'display:none;' }}">
                    @include('user.profile.steps.step4', ['employments' => $user->employments])
                </div>

                <!-- Step 5: Pets -->
                <div class="step-content" data-step="5" style="{{ $currentStep == 5 ? '' : 'display:none;' }}">
                    @include('user.profile.steps.step5', ['pets' => $user->pets])
                </div>

                <!-- Step 6: Vehicles -->
                <div class="step-content" data-step="6" style="{{ $currentStep == 6 ? '' : 'display:none;' }}">
                    @include('user.profile.steps.step6', ['vehicles' => $user->vehicles])
                </div>

                <!-- Step 7: Address -->
                <div class="step-content" data-step="7" style="{{ $currentStep == 7 ? '' : 'display:none;' }}">
                    @include('user.profile.steps.step7', ['addresses' => $user->addresses])
                </div>

                <!-- Step 8: References -->
                <div class="step-content" data-step="8" style="{{ $currentStep == 8 ? '' : 'display:none;' }}">
                    @include('user.profile.steps.step8', ['references' => $user->references])
                </div>

                <!-- Step 9: Identification -->
                <div class="step-content" data-step="9" style="{{ $currentStep == 9 ? '' : 'display:none;' }}">
                    @include('user.profile.steps.step9', ['identifications' => $user->identifications])
                </div>

                <!-- Step 10: Terms -->
                <div class="step-content" data-step="10" style="{{ $currentStep == 10 ? '' : 'display:none;' }}">
                    @include('user.profile.steps.step10', ['profile' => $profile])
                </div>

                <!-- Navigation Buttons -->
                <div class="flex flex-col sm:flex-row justify-between gap-3 mt-8 pt-6 border-t">
                    <button type="button" id="prevBtn" 
                            class="order-2 sm:order-1 px-6 py-3 border-2 border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 transition {{ $currentStep == 1 ? 'invisible' : '' }}">
                        <span class="flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                            Previous
                        </span>
                    </button>
                    <button type="button" id="nextBtn" 
                            class="order-1 sm:order-2 px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg font-medium hover:from-blue-700 hover:to-indigo-700 transition shadow-lg hover:shadow-xl">
                        <span id="nextBtnContent" class="flex items-center justify-center">
                            <span id="nextBtnText">{{ $currentStep == 10 ? 'Submit Application' : 'Next' }}</span>
                            <svg id="nextBtnIcon" class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                            <svg id="nextBtnSpinner" class="hidden w-5 h-5 ml-2 animate-spin" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- jQuery (required for Select2) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<!-- Flatpickr JS -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
let currentStep = {{ $currentStep }};

// Initialize Select2 and Flatpickr
function initializeFormPlugins() {
    try {
        // Initialize Select2 on all select elements
        $('select').not('.no-select2').each(function() {
            if (!$(this).hasClass('select2-hidden-accessible')) {
                $(this).select2({
                    placeholder: $(this).data('placeholder') || 'Select an option',
                    allowClear: false,
                    width: '100%'
                });
            }
        });
        
        // Initialize Flatpickr on date inputs
        const datepickers = document.querySelectorAll('.datepicker');
        if (datepickers.length > 0) {
            flatpickr('.datepicker', {
                dateFormat: 'Y-m-d',
                maxDate: 'today',
                altInput: true,
                altFormat: 'F j, Y'
            });
        }
        
        const futureDatepickers = document.querySelectorAll('.datepicker-future');
        if (futureDatepickers.length > 0) {
            flatpickr('.datepicker-future', {
                dateFormat: 'Y-m-d',
                altInput: true,
                altFormat: 'F j, Y'
            });
        }
    } catch (error) {
        console.error('Error initializing plugins:', error);
    }
}

// Initialize on page load
$(document).ready(function() {
    initializeFormPlugins();
    
    // Initialize step-specific event handlers
    initStepHandlers();
});

// Initialize step-specific handlers
function initStepHandlers() {
    // Guarantor toggle (Step 1)
    const guarantorToggle = document.getElementById('hasGuarantorToggle');
    if (guarantorToggle) {
        guarantorToggle.addEventListener('change', function() {
            const fields = document.getElementById('guarantorFields');
            if (fields) {
                if (this.checked) {
                    fields.style.display = 'block';
                    fields.style.animation = 'slideDown 0.3s ease-out';
                } else {
                    fields.style.display = 'none';
                }
            }
        });
    }
    
    // Employment toggle (Step 4)
    const employmentToggle = document.getElementById('hasEmploymentToggle');
    if (employmentToggle) {
        employmentToggle.addEventListener('change', function() {
            const section = document.getElementById('employmentSection');
            const message = document.getElementById('noEmploymentMessage');
            if (section && message) {
                section.style.display = this.checked ? 'block' : 'none';
                message.style.display = this.checked ? 'none' : 'block';
            }
        });
    }
    
    // Pets toggle (Step 5)
    const petsToggle = document.getElementById('hasPetsToggle');
    if (petsToggle) {
        petsToggle.addEventListener('change', function() {
            const section = document.getElementById('petsSection');
            if (section) {
                section.style.display = this.checked ? 'block' : 'none';
            }
        });
    }
    
    // Vehicles toggle (Step 6)
    const vehiclesToggle = document.getElementById('hasVehiclesToggle');
    if (vehiclesToggle) {
        vehiclesToggle.addEventListener('change', function() {
            const section = document.getElementById('vehiclesSection');
            if (section) {
                section.style.display = this.checked ? 'block' : 'none';
            }
        });
    }
    
    // References toggle (Step 8)
    const referencesToggle = document.getElementById('hasReferencesToggle');
    if (referencesToggle) {
        referencesToggle.addEventListener('change', function() {
            const section = document.getElementById('referencesSection');
            if (section) {
                section.style.display = this.checked ? 'block' : 'none';
            }
        });
    }
}

// Show alert message
function showAlert(message, type = 'success') {
    const icons = {
        success: '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>',
        error: '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>',
        warning: '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>',
        info: '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>'
    };
    
    const colors = {
        success: 'bg-green-50 border-green-200 text-green-800',
        error: 'bg-red-50 border-red-200 text-red-800',
        warning: 'bg-yellow-50 border-yellow-200 text-yellow-800',
        info: 'bg-blue-50 border-blue-200 text-blue-800'
    };
    
    const iconColors = {
        success: 'text-green-600',
        error: 'text-red-600',
        warning: 'text-yellow-600',
        info: 'text-blue-600'
    };
    
    const alert = `
        <div class="alert-animated ${colors[type]} border rounded-lg p-4 flex items-start">
            <div class="${iconColors[type]} mr-3 flex-shrink-0">
                ${icons[type]}
            </div>
            <div class="flex-1">
                <p class="text-sm font-medium">${message}</p>
            </div>
            <button onclick="this.parentElement.remove()" class="ml-3 ${iconColors[type]} hover:opacity-70">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                </svg>
            </button>
        </div>
    `;
    
    const container = document.getElementById('alertContainer');
    container.innerHTML = alert;
    
    // Auto dismiss after 5 seconds
    setTimeout(() => {
        const alertEl = container.querySelector('.alert-animated');
        if (alertEl) {
            alertEl.style.opacity = '0';
            alertEl.style.transform = 'translateY(-10px)';
            setTimeout(() => alertEl.remove(), 300);
        }
    }, 5000);
    
    // Scroll to top
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

// Validate form
function validateForm() {
    let isValid = true;
    const currentStepEl = document.querySelector(`[data-step="${currentStep}"]`);
    
    // Remove previous error states
    currentStepEl.querySelectorAll('.input-error').forEach(el => {
        el.classList.remove('input-error');
    });
    currentStepEl.querySelectorAll('.select2-error').forEach(el => {
        el.classList.remove('select2-error');
    });
    currentStepEl.querySelectorAll('.error-message').forEach(el => el.remove());
    
    // Check required fields
    const requiredFields = currentStepEl.querySelectorAll('[required]');
    requiredFields.forEach(field => {
        if (!field.value || field.value.trim() === '') {
            isValid = false;
            
            if (field.tagName === 'SELECT') {
                $(field).next('.select2-container').addClass('select2-error');
            } else {
                field.classList.add('input-error');
            }
            
            // Add error message
            const errorMsg = document.createElement('p');
            errorMsg.className = 'error-message text-red-600 text-sm mt-1';
            errorMsg.textContent = 'This field is required';
            
            if (field.tagName === 'SELECT') {
                $(field).next('.select2-container').after(errorMsg);
            } else {
                field.parentElement.appendChild(errorMsg);
            }
        }
    });
    
    // Special validation for step 9 (ID points)
    if (currentStep === 9) {
        const totalPoints = parseInt(document.getElementById('totalPoints')?.textContent || 0);
        if (totalPoints < 80) {
            isValid = false;
            showAlert('You must supply at least 80 ID Points for your application to be considered.', 'error');
        }
    }
    
    // Special validation for step 10 (terms)
    if (currentStep === 10) {
        const termsCheckbox = currentStepEl.querySelector('input[name="terms_accepted"]');
        const signature = currentStepEl.querySelector('input[name="signature"]');
        
        if (!termsCheckbox?.checked) {
            isValid = false;
            showAlert('You must accept the terms and conditions to proceed.', 'error');
        }
        
        if (!signature?.value) {
            isValid = false;
            signature?.classList.add('input-error');
        }
    }
    
    return isValid;
}

// Next button handler
const nextBtn = document.getElementById('nextBtn');
if (nextBtn) {
    nextBtn.addEventListener('click', async function() {
        if (!validateForm()) {
            showAlert('Please fill in all required fields before proceeding.', 'error');
            return;
        }
        
        // Show loading state
        const btn = this;
        const btnText = document.getElementById('nextBtnText');
        const btnIcon = document.getElementById('nextBtnIcon');
        const btnSpinner = document.getElementById('nextBtnSpinner');
        
        btn.disabled = true;
        if (btnText) btnText.textContent = 'Saving...';
        if (btnIcon) btnIcon.classList.add('hidden');
        if (btnSpinner) btnSpinner.classList.remove('hidden');
        
        const formData = new FormData(document.getElementById('profileForm'));
        formData.set('step', currentStep);
        
        try {
            const response = await fetch('{{ route("user.profile.update-step") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });
            
            const data = await response.json();
            
            if (data.success) {
                if (data.redirect) {
                    showAlert('Profile submitted successfully! Redirecting...', 'success');
                    setTimeout(() => window.location.href = data.redirect, 1500);
                } else {
                    showAlert('Step saved successfully!', 'success');
                    currentStep = data.next_step;
                    updateStepDisplay();
                }
            } else {
                showAlert(data.error || 'An error occurred. Please check your input.', 'error');
            }
        } catch (error) {
            console.error('Error:', error);
            showAlert('An error occurred. Please try again.', 'error');
        } finally {
            // Reset button state
            btn.disabled = false;
            if (btnText) btnText.textContent = currentStep >= 9 ? 'Submit Application' : 'Next';
            if (btnIcon) btnIcon.classList.remove('hidden');
            if (btnSpinner) btnSpinner.classList.add('hidden');
        }
    });
}

// Previous button handler
const prevBtn = document.getElementById('prevBtn');
if (prevBtn) {
    prevBtn.addEventListener('click', async function() {
        if (currentStep > 1) {
            try {
                const response = await fetch('{{ route("user.profile.previous-step") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });
                
                const data = await response.json();
                
                if (data.success) {
                    currentStep = data.previous_step;
                    updateStepDisplay();
                }
            } catch (error) {
                console.error('Error:', error);
            }
        }
    });
}

function updateStepDisplay() {
    // Hide all steps
    document.querySelectorAll('.step-content').forEach(step => {
        step.style.display = 'none';
    });
    
    // Show current step
    const currentStepEl = document.querySelector(`[data-step="${currentStep}"]`);
    if (currentStepEl) {
        currentStepEl.style.display = 'block';
    }
    
    // Update progress bar
    const progressBar = document.getElementById('progressBar');
    if (progressBar) {
        const progress = (currentStep / 10) * 100;
        progressBar.style.width = progress + '%';
    }
    
    // Update button text and visibility
    const prevBtn = document.getElementById('prevBtn');
    if (prevBtn) {
        prevBtn.classList.toggle('invisible', currentStep === 1);
    }
    
    const nextBtnText = document.getElementById('nextBtnText');
    if (nextBtnText) {
        nextBtnText.textContent = currentStep === 10 ? 'Submit Application' : 'Next';
    }
    
    // Update step input
    const stepInput = document.getElementById('currentStepInput');
    if (stepInput) {
        stepInput.value = currentStep;
    }
    
    // Reinitialize plugins for new step
    setTimeout(() => {
        initializeFormPlugins();
    }, 100);
    
    // Reload page to update step counter
    window.location.reload();
}
</script>
@endpush