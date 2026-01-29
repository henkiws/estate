@extends('layouts.user')

@section('title', 'My Profile')

@section('content')
<div class="py-8">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Page Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">My Profile</h1>
                    <p class="mt-2 text-gray-600">Manage your rental application profile and information</p>
                </div>
                
                <!-- Overall Progress Badge -->
                <div class="text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full border-4 border-[#5E17EB] bg-white shadow-lg">
                        <div class="text-center">
                            <span class="block text-sm font-bold text-[#5E17EB]" id="overall-percentage">45%</span>
                            <span class="block text-[10px] text-gray-500 leading-tight">Done</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Alert Messages -->
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg flex items-start gap-3">
                <svg class="w-5 h-5 text-green-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <p class="text-green-800">{{ session('success') }}</p>
            </div>
        @endif
        
        @if(session('error'))
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg flex items-start gap-3">
                <svg class="w-5 h-5 text-red-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                <p class="text-red-800">{{ session('error') }}</p>
            </div>
        @endif
        
        <!-- Progress Info Card -->
        <div class="mb-6 p-5 bg-gradient-to-r from-blue-50 to-teal-50 border border-blue-200 rounded-xl">
            <div class="flex items-start gap-4">
                <svg class="w-6 h-6 text-blue-600 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div class="flex-1">
                    <h4 class="font-semibold text-blue-900 mb-1">Complete your profile to apply for properties</h4>
                    <p class="text-sm text-blue-800 mb-3">
                        You need at least <strong>80 points</strong> to submit rental applications. 
                        Complete all sections below to maximize your profile strength.
                    </p>
                    <div class="flex items-center gap-3">
                        <div class="flex-1 bg-white/50 rounded-full h-2 overflow-hidden">
                            <div class="bg-gradient-to-r from-blue-600 to-teal-600 h-full transition-all duration-500" style="width: 45%"></div>
                        </div>
                        <span class="text-sm font-semibold text-blue-900">36 / 80 points</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Profile Sections -->
        <div class="space-y-4">

            <!-- Section 0: About You (State Selection) -->
            @include('user.profile.cards.about-you-card')
            
            <!-- Section 1: Personal Details -->
            @include('user.profile.cards.personal-details-card')
            
            <!-- Section 2: Introduction -->
            @include('user.profile.cards.introduction-card')
            
            <!-- Section 3: Current Income -->
            @include('user.profile.cards.income-card')
            
            <!-- Section 4: Employment -->
            @include('user.profile.cards.employment-card')
            
            <!-- Section 5: Pets -->
            @include('user.profile.cards.pets-card')
            
            <!-- Section 6: Vehicles -->
            @include('user.profile.cards.vehicles-card')
            
            <!-- Section 7: Address History -->
            @include('user.profile.cards.address-history-card')
            
            {{-- <!-- Section 8: References -->
            @include('user.profile.cards.references-card') --}}
            
            <!-- Section 9: Identification -->
            @include('user.profile.cards.identification-card')
            
            <!-- Section 10: Terms & Conditions -->
            {{-- @include('user.profile.cards.terms-card') --}}
            
        </div>
        
        <!-- Help Card -->
        <div class="mt-8 p-6 bg-blue-50 border border-blue-200 rounded-xl">
            <div class="flex items-start gap-4">
                <svg class="w-6 h-6 text-blue-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div>
                    <h4 class="font-semibold text-blue-900 mb-2">Need Help?</h4>
                    <p class="text-sm text-blue-800 mb-3">
                        Your profile information helps property managers make informed decisions. 
                        All information is securely stored and encrypted.
                    </p>
                    <div class="flex items-center gap-4">
                        <a href="#" class="text-sm font-semibold text-blue-600 hover:text-blue-700 flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            View FAQs
                        </a>
                        <a href="#" class="text-sm font-semibold text-blue-600 hover:text-blue-700 flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            Contact Support
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>

<style>
    /* intl-tel-input custom styling */
    .iti {
        display: block;
        width: 100%;
    }

    .iti__flag-container {
        position: absolute;
        top: 0;
        bottom: 0;
        right: auto;
        left: 0;
        padding: 0;
    }

    .iti__selected-flag {
        padding: 0 12px;
        height: 100%;
        display: flex;
        align-items: center;
        border-right: 1px solid #d1d5db;
        background-color: #f9fafb;
        border-radius: 0.5rem 0 0 0.5rem;
        transition: all 0.2s;
    }

    .iti__selected-flag:hover {
        background-color: #f3f4f6;
    }

    .iti__country-list {
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        border-radius: 0.75rem;
        border: 1px solid #e5e7eb;
        max-height: 300px;
        margin-top: 4px;
    }

    .iti__country {
        padding: 10px 16px;
        transition: background-color 0.2s;
    }

    .iti__country:hover {
        background-color: #E6FF4B;
    }

    .iti__country.iti__highlight {
        background-color: #DDEECD;
    }

    .iti__country-name {
        margin-right: 8px;
        font-weight: 500;
    }

    .iti__dial-code {
        color: #6b7280;
    }

    .iti__selected-dial-code {
        font-weight: 600;
        color: #374151;
        margin-left: 4px;
    }

    .iti input[type="tel"] {
        padding-left: 70px !important;
        padding-right: 1rem !important;
        padding-top: 0.75rem !important;
        padding-bottom: 0.75rem !important;
    }

    /* Search box in dropdown */
    .iti__search-input {
        width: 100%;
        padding: 8px 12px;
        border: 1px solid #d1d5db;
        border-radius: 0.5rem;
        margin: 8px;
        width: calc(100% - 16px);
    }

    .iti__search-input:focus {
        outline: none;
        border-color: #5E17EB;
        box-shadow: 0 0 0 3px rgba(94, 23, 235, 0.1);
    }

    /* Divider */
    .iti__divider {
        border-bottom: 1px solid #e5e7eb;
        margin: 4px 0;
    }

    /* Arrow */
    .iti__arrow {
        border-left: 4px solid transparent;
        border-right: 4px solid transparent;
        border-top: 4px solid #6b7280;
        margin-left: 6px;
    }

    .iti__arrow--up {
        border-top: none;
        border-bottom: 4px solid #6b7280;
    }
</style>

@push('scripts')
<script>
// Calculate overall completion percentage
function calculateOverallCompletion() {
    // Get all percentage elements
    const percentageElements = document.querySelectorAll('[id$="-percentage"]');
    let total = 0;
    let count = 0;
    
    percentageElements.forEach(element => {
        if (element.id !== 'overall-percentage') {
            const value = parseInt(element.textContent);
            if (!isNaN(value)) {
                total += value;
                count++;
            }
        }
    });
    
    const overall = count > 0 ? Math.round(total / count) : 0;
    const overallElement = document.getElementById('overall-percentage');
    if (overallElement) {
        overallElement.textContent = overall + '%';
    }
    
    // Update progress bar
    const progressBar = document.querySelector('.bg-gradient-to-r.from-blue-600');
    if (progressBar) {
        progressBar.style.width = overall + '%';
    }
    
    // Calculate points (rough estimate: each section worth ~10 points)
    const points = Math.round((overall / 100) * 80);
    const pointsElement = progressBar?.parentElement?.nextElementSibling;
    if (pointsElement) {
        pointsElement.textContent = points + ' / 80 points';
    }
}

// Call on page load
document.addEventListener('DOMContentLoaded', function() {
    calculateOverallCompletion();
});

// Auto-scroll to expanded section
function scrollToCard(cardId) {
    const card = document.getElementById(cardId);
    if (card) {
        setTimeout(() => {
            card.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }, 100);
    }
}
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        
        // ========================================
        // MOBILE NUMBER - intl-tel-input
        // ========================================
        const phoneInput = document.querySelector("#mobile_number");
        if (phoneInput) {
            const iti = window.intlTelInput(phoneInput, {
                initialCountry: "au",
                preferredCountries: ["au", "us", "gb", "nz", "sg", "my", "id", "ph"],
                separateDialCode: true,
                nationalMode: false,
                autoPlaceholder: "polite",
                formatOnDisplay: true,
                customPlaceholder: function(selectedCountryPlaceholder, selectedCountryData) {
                    return "e.g. " + selectedCountryPlaceholder;
                },
                utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@19.5.6/build/js/utils.js"
            });

            // Set initial value if exists
            const existingCountryCode = document.getElementById('mobile_country_code').value;
            const existingNumber = document.getElementById('mobile_number_clean').value;
            
            if (existingCountryCode && existingNumber) {
                const countryCode = existingCountryCode.replace('+', '');
                // Use window.intlTelInputGlobals instead of iti instance
                const allCountries = window.intlTelInputGlobals.getCountryData();
                const countryData = allCountries.find(country => country.dialCode === countryCode);
                if (countryData) {
                    iti.setCountry(countryData.iso2);
                }
                phoneInput.value = existingNumber;
            }

            phoneInput.addEventListener('blur', function() {
                updatePhoneFields();
            });

            phoneInput.addEventListener('countrychange', function() {
                updatePhoneFields();
            });

            function updatePhoneFields() {
                const countryData = iti.getSelectedCountryData();
                document.getElementById('mobile_country_code').value = '+' + countryData.dialCode;
                const fullNumber = iti.getNumber();
                const numberWithoutCode = fullNumber.replace('+' + countryData.dialCode, '').trim();
                document.getElementById('mobile_number_clean').value = numberWithoutCode;
            }

            // Validate on form submit
            const form = document.getElementById('application-form');
            if (form) {
                form.addEventListener('submit', function(e) {
                    updatePhoneFields();
                    
                    // Validate phone number
                    if (phoneInput.value && !iti.isValidNumber()) {
                        e.preventDefault();
                        phoneInput.classList.add('border-red-500');
                        
                        let errorMsg = phoneInput.parentElement.querySelector('.phone-error');
                        if (!errorMsg) {
                            errorMsg = document.createElement('p');
                            errorMsg.className = 'phone-error mt-1 text-sm text-red-600';
                            phoneInput.parentElement.appendChild(errorMsg);
                        }
                        errorMsg.textContent = 'Please enter a valid phone number for the selected country.';
                        
                        phoneInput.focus();
                        return false;
                    } else {
                        phoneInput.classList.remove('border-red-500');
                        const errorMsg = phoneInput.parentElement.querySelector('.phone-error');
                        if (errorMsg) {
                            errorMsg.remove();
                        }
                    }
                });
            }
        }

        // ========================================
        // EMERGENCY CONTACT PHONE - intl-tel-input
        // ========================================
        const emergencyPhoneInput = document.querySelector("#emergency_contact_phone");
        if (emergencyPhoneInput) {
            const emergencyIti = window.intlTelInput(emergencyPhoneInput, {
                initialCountry: "au",
                preferredCountries: ["au", "us", "gb", "nz", "sg", "my", "id", "ph"],
                separateDialCode: true,
                nationalMode: false,
                autoPlaceholder: "polite",
                formatOnDisplay: true,
                customPlaceholder: function(selectedCountryPlaceholder, selectedCountryData) {
                    return "e.g. " + selectedCountryPlaceholder;
                },
                utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@19.5.6/build/js/utils.js"
            });

            const existingEmergencyCountryCode = document.getElementById('emergency_contact_country_code').value;
            const existingEmergencyNumber = document.getElementById('emergency_contact_number_clean').value;
            
            if (existingEmergencyCountryCode && existingEmergencyNumber) {
                const countryCode = existingEmergencyCountryCode.replace('+', '');
                // Use window.intlTelInputGlobals instead of emergencyIti instance
                const allCountries = window.intlTelInputGlobals.getCountryData();
                const countryData = allCountries.find(country => country.dialCode === countryCode);
                if (countryData) {
                    emergencyIti.setCountry(countryData.iso2);
                }
                emergencyPhoneInput.value = existingEmergencyNumber;
            }

            emergencyPhoneInput.addEventListener('blur', function() {
                updateEmergencyPhoneFields();
            });

            emergencyPhoneInput.addEventListener('countrychange', function() {
                updateEmergencyPhoneFields();
            });

            function updateEmergencyPhoneFields() {
                const countryData = emergencyIti.getSelectedCountryData();
                document.getElementById('emergency_contact_country_code').value = '+' + countryData.dialCode;
                const fullNumber = emergencyIti.getNumber();
                const numberWithoutCode = fullNumber.replace('+' + countryData.dialCode, '').trim();
                document.getElementById('emergency_contact_number_clean').value = numberWithoutCode;
            }

            // Validate emergency contact phone on form submission
            const form = document.getElementById('application-form');
            if (form) {
                form.addEventListener('submit', function(e) {
                    const hasEmergencyContact = document.getElementById('has_emergency_contact');
                    
                    if (hasEmergencyContact && hasEmergencyContact.checked) {
                        updateEmergencyPhoneFields();
                        
                        if (emergencyPhoneInput.value && !emergencyIti.isValidNumber()) {
                            e.preventDefault();
                            emergencyPhoneInput.classList.add('border-red-500');
                            
                            let errorMsg = emergencyPhoneInput.parentElement.querySelector('.emergency-phone-error');
                            if (!errorMsg) {
                                errorMsg = document.createElement('p');
                                errorMsg.className = 'emergency-phone-error mt-1 text-sm text-red-600';
                                emergencyPhoneInput.parentElement.appendChild(errorMsg);
                            }
                            errorMsg.textContent = 'Please enter a valid emergency contact phone number.';
                            
                            emergencyPhoneInput.focus();
                            return false;
                        } else {
                            emergencyPhoneInput.classList.remove('border-red-500');
                            const errorMsg = emergencyPhoneInput.parentElement.querySelector('.emergency-phone-error');
                            if (errorMsg) {
                                errorMsg.remove();
                            }
                        }
                    }
                });
            }
        }

        // ========================================
        // GUARANTOR PHONE - intl-tel-input
        // ========================================
        const guarantorPhoneInput = document.querySelector("#guarantor_phone");
        if (guarantorPhoneInput) {
            const guarantorIti = window.intlTelInput(guarantorPhoneInput, {
                initialCountry: "au",
                preferredCountries: ["au", "us", "gb", "nz", "sg", "my", "id", "ph"],
                separateDialCode: true,
                nationalMode: false,
                autoPlaceholder: "polite",
                formatOnDisplay: true,
                customPlaceholder: function(selectedCountryPlaceholder, selectedCountryData) {
                    return "e.g. " + selectedCountryPlaceholder;
                },
                utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@19.5.6/build/js/utils.js"
            });

            const existingGuarantorCountryCode = document.getElementById('guarantor_country_code').value;
            const existingGuarantorNumber = document.getElementById('guarantor_number_clean').value;
            
            if (existingGuarantorCountryCode && existingGuarantorNumber) {
                const countryCode = existingGuarantorCountryCode.replace('+', '');
                const allCountries = window.intlTelInputGlobals.getCountryData();
                const countryData = allCountries.find(country => country.dialCode === countryCode);
                if (countryData) {
                    guarantorIti.setCountry(countryData.iso2);
                }
                guarantorPhoneInput.value = existingGuarantorNumber;
            }

            guarantorPhoneInput.addEventListener('blur', function() {
                updateGuarantorPhoneFields();
            });

            guarantorPhoneInput.addEventListener('countrychange', function() {
                updateGuarantorPhoneFields();
            });

            function updateGuarantorPhoneFields() {
                const countryData = guarantorIti.getSelectedCountryData();
                document.getElementById('guarantor_country_code').value = '+' + countryData.dialCode;
                const fullNumber = guarantorIti.getNumber();
                const numberWithoutCode = fullNumber.replace('+' + countryData.dialCode, '').trim();
                document.getElementById('guarantor_number_clean').value = numberWithoutCode;
            }

            // Validate guarantor phone on form submission
            const form = document.getElementById('application-form');
            if (form) {
                form.addEventListener('submit', function(e) {
                    const hasGuarantor = document.getElementById('has_guarantor');
                    
                    if (hasGuarantor && hasGuarantor.checked) {
                        updateGuarantorPhoneFields();
                        
                        if (guarantorPhoneInput.value && !guarantorIti.isValidNumber()) {
                            e.preventDefault();
                            guarantorPhoneInput.classList.add('border-red-500');
                            
                            let errorMsg = guarantorPhoneInput.parentElement.querySelector('.guarantor-phone-error');
                            if (!errorMsg) {
                                errorMsg = document.createElement('p');
                                errorMsg.className = 'guarantor-phone-error mt-1 text-sm text-red-600';
                                guarantorPhoneInput.parentElement.appendChild(errorMsg);
                            }
                            errorMsg.textContent = 'Please enter a valid guarantor phone number.';
                            
                            guarantorPhoneInput.focus();
                            return false;
                        } else {
                            guarantorPhoneInput.classList.remove('border-red-500');
                            const errorMsg = guarantorPhoneInput.parentElement.querySelector('.guarantor-phone-error');
                            if (errorMsg) {
                                errorMsg.remove();
                            }
                        }
                    }
                });
            }
        }
        
    });
</script>
@endpush
@endsection

@push('scripts')
<script>
// Auto-scroll to next section after save
document.addEventListener('DOMContentLoaded', function() {
    @if(session('scroll_to'))
        const targetCardId = '{{ session('scroll_to') }}';
        const targetCard = document.getElementById(targetCardId);
        
        if (targetCard) {
            console.log('Found target card:', targetCardId);
            
            // Wait for page to fully load
            setTimeout(() => {
                // Calculate position with offset
                const cardPosition = targetCard.getBoundingClientRect().top + window.pageYOffset;
                const offset = 80; // 80px offset from top (adjust as needed)

                console.log('Scrolling to position:', cardPosition + offset);
                
                // Smooth scroll to position with offset
                window.scrollTo({
                    top: cardPosition + offset,
                    behavior: 'smooth'
                });
                
                // Wait for scroll to complete, then expand
                setTimeout(() => {
                    // Find the toggle button - try multiple selectors
                    const toggleButton = targetCard.querySelector('[data-action="toggle"]') || 
                                       targetCard.querySelector('.toggle-card') ||
                                       targetCard.querySelector('[onclick*="toggle"]') ||
                                       targetCard.querySelector('button[aria-expanded]');
                    
                    console.log('Toggle button:', toggleButton);
                    
                    if (toggleButton) {
                        // Check if already expanded
                        const isExpanded = toggleButton.getAttribute('aria-expanded') === 'true';
                        console.log('Is expanded:', isExpanded);
                        
                        if (!isExpanded) {
                            // Programmatically click the toggle button
                            toggleButton.click();
                            console.log('Clicked toggle button');
                        }
                    } else {
                        // Fallback: manually expand the card
                        console.log('No toggle button found, using fallback');
                        const content = targetCard.querySelector('[id$="-content"]') ||
                                      targetCard.querySelector('.card-content') ||
                                      targetCard.querySelector('[class*="hidden"]');
                        
                        if (content) {
                            console.log('Found content:', content);
                            content.classList.remove('hidden');
                            
                            // Rotate chevron if exists
                            const chevron = targetCard.querySelector('svg');
                            if (chevron) {
                                chevron.classList.remove('rotate-0');
                                chevron.classList.add('rotate-180');
                            }
                        }
                    }
                }, 600);
                
                // Add highlight effect
                targetCard.classList.add('ring-2', 'ring-[#0d9488]', 'ring-offset-2');
                setTimeout(() => {
                    targetCard.classList.remove('ring-2', 'ring-[#0d9488]', 'ring-offset-2');
                }, 2500);
            }, 300);
        } else {
            console.log('Target card not found:', targetCardId);
        }
    @endif
});
</script>
@endpush