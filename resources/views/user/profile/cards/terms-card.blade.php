<!-- Terms & Conditions Card -->
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-4 hover:shadow-md transition-shadow" id="terms-card">
    
    <!-- Card Header (Always Visible) -->
    <div class="p-6">
        <div class="flex items-start justify-between">
            
            <!-- Left: Icon + Content -->
            <div class="flex items-start gap-4 flex-1">
                <!-- Icon -->
                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-plyform-yellow/20 to-plyform-mint/30 flex items-center justify-center text-plyform-dark flex-shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                
                <!-- Content -->
                <div class="flex-1">
                    <h3 class="text-lg font-semibold text-plyform-dark">Terms & Conditions</h3>
                    <p class="text-sm text-gray-600 mt-1" id="terms-summary">
                        @if($profile && $profile->terms_accepted)
                            Accepted on {{ $profile->terms_accepted_at?->format('M d, Y') }}
                        @else
                            Not completed yet
                        @endif
                    </p>
                    
                    <!-- Status Badge -->
                    <div class="mt-3">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $profile && $profile->terms_accepted ? 'bg-plyform-mint text-plyform-dark border border-plyform-mint' : 'bg-gray-100 text-gray-600 border border-gray-200' }}" id="terms-status">
                            @if($profile && $profile->terms_accepted)
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
                <div class="flex items-center justify-center w-14 h-14 rounded-full border-4 {{ $profile && $profile->terms_accepted ? 'border-[#5E17EB]' : 'border-gray-300' }} bg-white">
                    <span class="text-sm font-bold {{ $profile && $profile->terms_accepted ? 'text-[#5E17EB]' : 'text-gray-400' }}" id="terms-percentage">
                        @if($profile && $profile->terms_accepted)
                            100%
                        @else
                            0%
                        @endif
                    </span>
                </div>
                
                <!-- Edit Button -->
                <button 
                    type="button" 
                    onclick="toggleTerms()"
                    class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-plyform-purple hover:text-plyform-dark hover:bg-plyform-purple/10 rounded-lg transition"
                    id="terms-edit-btn"
                >
                    <span>Edit</span>
                    <svg class="w-4 h-4 transition-transform" id="terms-chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
            </div>
            
        </div>
    </div>
    
    <!-- Expandable Form Content (Hidden by Default) -->
    <div class="border-t border-gray-200 bg-gray-50 hidden" id="terms-form">
        <form method="POST" action="{{ route('user.profile.update-step') }}" class="p-6 space-y-6">
            @csrf
            <input type="hidden" name="current_step" value="10">
            
            <!-- Terms & Conditions Section -->
            <div class="bg-white rounded-lg p-6 space-y-6">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h4 class="text-base font-semibold text-plyform-dark">Terms & Conditions</h4>
                        <p class="text-sm text-gray-600 mt-1">Please review and accept the terms and conditions to complete your profile</p>
                    </div>
                    <span class="text-plyform-orange text-sm font-medium">* Required</span>
                </div>
                
                <!-- Terms Content -->
                <div class="p-6 bg-gray-50 border-2 border-gray-200 rounded-lg max-h-96 overflow-y-auto custom-scrollbar">
                    <h3 class="font-bold text-plyform-dark mb-4">Rental Application Terms & Conditions</h3>
                    
                    <div class="space-y-4 text-sm text-gray-700 leading-relaxed">
                        <p><strong class="text-plyform-dark">1. Application Information</strong></p>
                        <p>I declare that the information provided in this application is true and correct. I understand that providing false or misleading information may result in the rejection of my application or termination of any tenancy agreement.</p>
                        
                        <p><strong class="text-plyform-dark">2. Privacy & Data Protection</strong></p>
                        <p>I consent to the collection, use, and disclosure of my personal information for the purposes of processing this rental application. This includes but is not limited to: identity verification, credit checks, reference checks, and assessment of rental suitability.</p>
                        
                        <p><strong class="text-plyform-dark">3. Reference & Background Checks</strong></p>
                        <p>I authorize the property manager to contact my references, current and previous landlords, employers, and other parties as necessary to verify the information provided in this application.</p>
                        
                        <p><strong class="text-plyform-dark">4. Credit Check Authorization</strong></p>
                        <p>I authorize the property manager to obtain my credit report and credit score from credit reporting agencies for the purpose of assessing my rental application.</p>
                        
                        <p><strong class="text-plyform-dark">5. Document Verification</strong></p>
                        <p>I understand that all documents provided (including identification, employment letters, and bank statements) may be verified for authenticity.</p>
                        
                        <p><strong class="text-plyform-dark">6. Application Fee</strong></p>
                        <p>I understand that any application fees paid are non-refundable, regardless of whether my application is successful.</p>
                        
                        <p><strong class="text-plyform-dark">7. No Guarantee of Approval</strong></p>
                        <p>I understand that submitting this application does not guarantee approval or secure the rental property. The property manager reserves the right to accept or reject any application.</p>
                        
                        <p><strong class="text-plyform-dark">8. Data Retention</strong></p>
                        <p>I understand that my application information will be retained for a period as required by law, after which it will be securely destroyed.</p>
                        
                        <p><strong class="text-plyform-dark">9. Communication</strong></p>
                        <p>I consent to receiving communications regarding my application via email, phone, or SMS to the contact details provided.</p>
                        
                        <p><strong class="text-plyform-dark">10. Accuracy of Information</strong></p>
                        <p>I agree to notify the property manager immediately if any information provided in this application changes before a tenancy agreement is signed.</p>
                    </div>
                </div>
                
                <!-- Acceptance Checkbox -->
                <div class="p-4 border-2 border-plyform-yellow/30 bg-plyform-yellow/5 rounded-lg">
                    <label class="flex items-start gap-3 cursor-pointer">
                        <input 
                            type="checkbox" 
                            name="terms_accepted" 
                            value="1"
                            {{ old('terms_accepted', $profile?->terms_accepted ?? false) ? 'checked' : '' }}
                            required
                            class="mt-1 w-5 h-5 text-plyform-yellow border-gray-300 rounded focus:ring-2 focus:ring-plyform-yellow/20"
                        >
                        <span class="text-sm text-plyform-dark font-medium">
                            I have read, understood, and agree to the above terms and conditions. 
                            I declare that all information provided is true and accurate to the best of my knowledge.
                            <span class="text-plyform-orange">*</span>
                        </span>
                    </label>
                </div>
                
            </div>
            
            <!-- Electronic Signature Section -->
            <div class="bg-white rounded-lg p-6 space-y-4">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h4 class="text-base font-semibold text-plyform-dark">Electronic Signature</h4>
                        <p class="text-sm text-gray-600 mt-1">Please sign below to confirm your agreement</p>
                    </div>
                    <span class="text-plyform-orange text-sm font-medium">* Required</span>
                </div>
                
                <!-- Signature Field -->
                <div>
                    <label class="flex items-center gap-2 text-sm font-medium text-plyform-dark mb-2">
                        Full Name (as signature) <span class="text-plyform-orange">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="signature" 
                        value="{{ old('signature', $profile->signature ?? '') }}"
                        required
                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-yellow/20 focus:border-plyform-yellow outline-none transition-all font-serif text-2xl"
                        placeholder="Your Full Name"
                    >
                    <p class="mt-2 text-xs text-gray-500">By typing your name, you agree that this constitutes a legal electronic signature</p>
                </div>
                
                <!-- Date Display -->
                <div>
                    <label class="text-sm font-medium text-plyform-dark mb-2 block">Date</label>
                    <input 
                        type="text" 
                        value="{{ now()->format('F j, Y') }}"
                        disabled
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg text-gray-700"
                    >
                </div>
                
            </div>
            
            <!-- Final Submission Notice -->
            <div class="p-6 bg-gradient-to-r from-plyform-mint/20 to-plyform-yellow/10 border-2 border-plyform-mint rounded-xl">
                <div class="flex items-start gap-4">
                    <svg class="w-8 h-8 text-plyform-dark flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div>
                        <h4 class="font-bold text-plyform-dark mb-2">Ready to Submit?</h4>
                        <p class="text-sm text-gray-700 mb-3">
                            Once you submit your profile, it will be sent to our admin team for review. 
                            You'll receive an email notification once your profile has been approved.
                        </p>
                        <ul class="text-sm text-gray-700 space-y-1">
                            <li>✓ All information provided will be verified</li>
                            <li>✓ You can view your submitted profile anytime</li>
                            <li>✓ Approval typically takes 1-2 business days</li>
                            <li>✓ You'll be notified via email once approved</li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <!-- Form Actions -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200">
                <button 
                    type="button" 
                    onclick="toggleTerms()"
                    class="px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 transition"
                >
                    Cancel
                </button>
                
                <button 
                    type="submit" 
                    id="final-submit-btn"
                    class="px-8 py-3 bg-gradient-to-r from-plyform-yellow to-plyform-mint text-plyform-dark font-semibold rounded-lg hover:from-plyform-yellow/90 hover:to-plyform-mint/90 transition shadow-sm flex items-center gap-2"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Submit Profile
                </button>
            </div>
            
        </form>
    </div>
    
</div>

<style>
.custom-scrollbar::-webkit-scrollbar {
    width: 8px;
}

.custom-scrollbar::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 4px;
}

.custom-scrollbar::-webkit-scrollbar-thumb {
    background: #E6FF4B;
    border-radius: 4px;
}

.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: #d4ed39;
}
</style>

<script>
function toggleTerms() {
    const formDiv = document.getElementById('terms-form');
    const chevron = document.getElementById('terms-chevron');
    const editBtn = document.getElementById('terms-edit-btn');
    
    if (formDiv.classList.contains('hidden')) {
        // Expand
        formDiv.classList.remove('hidden');
        chevron.style.transform = 'rotate(180deg)';
        editBtn.querySelector('span').textContent = 'Close';
        
        // Scroll to card
        setTimeout(() => {
            document.getElementById('terms-card').scrollIntoView({ 
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

// Confirm before submitting
document.addEventListener('DOMContentLoaded', function() {
    const submitBtn = document.getElementById('final-submit-btn');
    
    if (submitBtn) {
        submitBtn.addEventListener('click', function(e) {
            const termsCheckbox = document.querySelector('input[name="terms_accepted"]');
            const signature = document.querySelector('input[name="signature"]');
            
            if (!termsCheckbox || !signature) return;
            
            if (!termsCheckbox.checked) {
                e.preventDefault();
                alert('Please accept the terms and conditions before submitting');
                return false;
            }
            
            if (!signature.value.trim()) {
                e.preventDefault();
                alert('Please provide your signature before submitting');
                return false;
            }
            
            if (!confirm('Are you sure you want to submit your profile for approval? Make sure all information is correct.')) {
                e.preventDefault();
                return false;
            }
        });
    }
});
</script>