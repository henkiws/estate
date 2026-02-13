<div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden section-card" data-section="terms_conditions">
    <button type="button" onclick="toggleSection('terms_conditions')" class="w-full px-6 py-4 flex items-center justify-between hover:bg-gray-50 transition">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center section-status" id="status_terms_conditions">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="text-left">
                <span class="font-semibold text-gray-900">Terms and Conditions</span>
                <p class="text-xs text-gray-500" id="terms-summary">Must be accepted to submit</p>
            </div>
        </div>
        <svg class="w-5 h-5 text-gray-400 section-chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
    </button>
    
    <div class="section-content hidden px-6 pb-6">
        
        <!-- Terms Section -->
        <div class="bg-gray-50 rounded-lg p-6 space-y-4">
            <div class="mb-4">
                <h4 class="text-base font-semibold text-plyform-dark">Application Terms & Conditions</h4>
                <p class="text-sm text-gray-600 mt-1">Please read carefully before submitting your application</p>
            </div>
            
            <!-- Terms Content Box -->
            <div class="bg-white rounded-lg border-2 border-gray-200 p-6 max-h-96 overflow-y-auto">
                <div class="prose prose-sm max-w-none text-gray-700">
                    <h5 class="text-sm font-bold text-plyform-dark mb-3">1. Application Agreement</h5>
                    <p class="text-xs mb-4">
                        By submitting this application, you acknowledge that all information provided is true, accurate, and complete to the best of your knowledge. You understand that providing false or misleading information may result in the rejection of your application or termination of any tenancy agreement.
                    </p>
                    
                    <h5 class="text-sm font-bold text-plyform-dark mb-3">2. Privacy and Information Use</h5>
                    <p class="text-xs mb-4">
                        You consent to the collection, use, and disclosure of your personal information for the purposes of processing this rental application, including but not limited to: conducting reference checks, verifying employment and income, performing credit checks, and contacting emergency contacts if necessary. Your information will be handled in accordance with applicable privacy laws.
                    </p>
                    
                    <h5 class="text-sm font-bold text-plyform-dark mb-3">3. Reference and Background Checks</h5>
                    <p class="text-xs mb-4">
                        You authorize the property manager/landlord to contact references provided, verify employment details, conduct credit checks, and perform any other reasonable background checks deemed necessary for assessing your application. You understand that these checks may involve contacting third parties including but not limited to previous landlords, employers, and credit reporting agencies.
                    </p>
                    
                    <h5 class="text-sm font-bold text-plyform-dark mb-3">4. Application Fee and Processing</h5>
                    <p class="text-xs mb-4">
                        You acknowledge that submitting this application does not guarantee approval or create any tenancy agreement. The property manager reserves the right to accept or reject any application at their discretion. Application processing times may vary, and you will be notified of the outcome once a decision has been made.
                    </p>
                    
                    <h5 class="text-sm font-bold text-plyform-dark mb-3">5. Accuracy of Information</h5>
                    <p class="text-xs mb-4">
                        You declare that all documents uploaded, information provided, and statements made in this application are genuine, accurate, and not misleading. You understand that any discrepancies discovered may lead to immediate rejection of your application or termination of tenancy.
                    </p>
                    
                    <h5 class="text-sm font-bold text-plyform-dark mb-3">6. Property Viewing and Inspection</h5>
                    <p class="text-xs mb-4">
                        You acknowledge that you have either inspected the property or accept the property in its current condition as described. If you have not inspected the property, you understand that you are applying based on the information and images provided, and the property manager makes no warranties regarding the condition beyond what has been disclosed.
                    </p>
                    
                    <h5 class="text-sm font-bold text-plyform-dark mb-3">7. Financial Obligations</h5>
                    <p class="text-xs mb-4">
                        If your application is successful, you agree to pay the bond, rent in advance, and any other applicable fees as specified in the lease agreement. You understand that failure to pay these amounts by the specified dates may result in the offer being withdrawn.
                    </p>
                    
                    <h5 class="text-sm font-bold text-plyform-dark mb-3">8. Utility Connections (If Applicable)</h5>
                    <p class="text-xs mb-4">
                        If you have opted for utility connection services, you consent to Direct Connect or the appointed utility connection service contacting you and arranging connections on your behalf. You understand this is a free service and authorize the sharing of necessary information with utility providers.
                    </p>
                    
                    <h5 class="text-sm font-bold text-plyform-dark mb-3">9. Changes to Application</h5>
                    <p class="text-xs mb-4">
                        You agree to notify the property manager immediately of any changes to the information provided in this application, including changes to employment, income, contact details, or number of occupants, prior to entering into a lease agreement.
                    </p>
                    
                    <h5 class="text-sm font-bold text-plyform-dark mb-3">10. Governing Law</h5>
                    <p class="text-xs mb-4">
                        This application and any resulting tenancy agreement shall be governed by the laws of the state/territory in which the property is located. You agree to comply with all applicable residential tenancy legislation and regulations.
                    </p>
                </div>
            </div>
            
            <!-- Acceptance Checkboxes -->
            <div class="mt-6 space-y-4">
                
                <!-- Main Terms Acceptance -->
                <label class="flex items-start gap-3 cursor-pointer p-4 rounded-lg border-2 border-gray-300 hover:border-plyform-green hover:bg-plyform-green/5 transition-all group">
                    <input 
                        type="checkbox" 
                        name="accept_terms" 
                        id="accept_terms"
                        value="1"
                        required
                        onchange="updateTermsStatus()"
                        class="mt-1 w-5 h-5 text-plyform-green border-gray-300 rounded focus:ring-2 focus:ring-plyform-green/20"
                    >
                    <div class="flex-1">
                        <span class="text-sm font-semibold text-gray-900 group-hover:text-plyform-dark">
                            I have read and agree to the Terms and Conditions <span class="text-plyform-orange">*</span>
                        </span>
                        <p class="text-xs text-gray-600 mt-1">By checking this box, you confirm that you have read, understood, and agree to abide by all terms and conditions outlined above.</p>
                    </div>
                </label>
                
                <!-- Information Accuracy Declaration -->
                <label class="flex items-start gap-3 cursor-pointer p-4 rounded-lg border-2 border-gray-300 hover:border-plyform-green hover:bg-plyform-green/5 transition-all group">
                    <input 
                        type="checkbox" 
                        name="declare_accuracy" 
                        id="declare_accuracy"
                        value="1"
                        required
                        onchange="updateTermsStatus()"
                        class="mt-1 w-5 h-5 text-plyform-green border-gray-300 rounded focus:ring-2 focus:ring-plyform-green/20"
                    >
                    <div class="flex-1">
                        <span class="text-sm font-semibold text-gray-900 group-hover:text-plyform-dark">
                            I declare that all information provided is true and accurate <span class="text-plyform-orange">*</span>
                        </span>
                        <p class="text-xs text-gray-600 mt-1">You confirm that all information, documents, and statements in this application are truthful, complete, and not misleading.</p>
                    </div>
                </label>
                
                <!-- Privacy Consent -->
                <label class="flex items-start gap-3 cursor-pointer p-4 rounded-lg border-2 border-gray-300 hover:border-plyform-green hover:bg-plyform-green/5 transition-all group">
                    <input 
                        type="checkbox" 
                        name="consent_privacy" 
                        id="consent_privacy"
                        value="1"
                        required
                        onchange="updateTermsStatus()"
                        class="mt-1 w-5 h-5 text-plyform-green border-gray-300 rounded focus:ring-2 focus:ring-plyform-green/20"
                    >
                    <div class="flex-1">
                        <span class="text-sm font-semibold text-gray-900 group-hover:text-plyform-dark">
                            I consent to privacy collection and use of my information <span class="text-plyform-orange">*</span>
                        </span>
                        <p class="text-xs text-gray-600 mt-1">You authorize the collection, use, and disclosure of your personal information for application processing, reference checks, and property management purposes.</p>
                    </div>
                </label>
                
            </div>
            
            <!-- Warning Message -->
            <div class="mt-4 p-4 bg-plyform-orange/10 border border-plyform-orange/30 rounded-lg">
                <div class="flex gap-3">
                    <svg class="w-5 h-5 text-plyform-orange flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    <div class="flex-1">
                        <p class="text-sm font-semibold text-plyform-dark mb-1">Important Notice</p>
                        <p class="text-xs text-gray-700">All three checkboxes above must be ticked before you can submit your application. Please ensure you have read and understood all terms and conditions.</p>
                    </div>
                </div>
            </div>
            
        </div>
        
    </div>
</div>

<script>
    // Terms and Conditions functions
    function updateTermsStatus() {
        const acceptTerms = document.getElementById('accept_terms');
        const declareAccuracy = document.getElementById('declare_accuracy');
        const consentPrivacy = document.getElementById('consent_privacy');
        const statusIcon = document.querySelector('#status_terms_conditions');
        const summary = document.getElementById('terms-summary');
        const submitBtn = document.getElementById('submit-btn');
        
        // Check if all checkboxes are checked
        const allChecked = acceptTerms?.checked && declareAccuracy?.checked && consentPrivacy?.checked;
        
        // Update status icon
        if (statusIcon) {
            if (allChecked) {
                statusIcon.innerHTML = `
                    <svg class="w-5 h-5 text-teal-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    </svg>
                `;
                statusIcon.classList.remove('bg-gray-100');
                statusIcon.classList.add('bg-teal-100');
            } else {
                statusIcon.innerHTML = `
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                `;
                statusIcon.classList.remove('bg-teal-100');
                statusIcon.classList.add('bg-gray-100');
            }
        }
        
        // Update summary
        if (summary) {
            if (allChecked) {
                summary.textContent = 'All terms accepted';
                summary.classList.remove('text-gray-500');
                summary.classList.add('text-teal-600');
            } else {
                summary.textContent = 'Must be accepted to submit';
                summary.classList.remove('text-teal-600');
                summary.classList.add('text-gray-500');
            }
        }
        
        // Enable/disable submit button
        if (submitBtn) {
            if (allChecked) {
                submitBtn.disabled = false;
                submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            } else {
                submitBtn.disabled = true;
                submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
            }
        }
    }

    // Initialize terms status on page load
    document.addEventListener('DOMContentLoaded', function() {
        updateTermsStatus();
    });
</script>