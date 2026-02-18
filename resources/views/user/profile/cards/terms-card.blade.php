<!-- Terms & Conditions Card -->
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-4 hover:shadow-md transition-shadow" id="terms-card">
    
    <!-- Card Header (Always Visible) -->
    <div class="p-6">
        <div class="flex items-start justify-between">
            
            <!-- Left: Icon + Content -->
            <div class="flex items-start gap-4 flex-1">
                <!-- Icon -->
                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-plyform-green/20 to-plyform-mint/30 flex items-center justify-center text-plyform-dark flex-shrink-0">
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
                    <span class="text-xs font-bold {{ $profile && $profile->terms_accepted ? 'text-[#5E17EB]' : 'text-gray-400' }}" id="terms-percentage">
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
        <form method="POST" action="{{ route('user.profile.update-step') }}" class="p-6 space-y-6" id="terms-submit-form">
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
                <div class="p-4 border-2 border-plyform-green/30 bg-plyform-green/5 rounded-lg">
                    <label class="flex items-start gap-3 cursor-pointer">
                        <input 
                            type="checkbox" 
                            name="terms_accepted" 
                            value="1"
                            {{ old('terms_accepted', $profile?->terms_accepted ?? false) ? 'checked' : '' }}
                            required
                            class="mt-1 w-5 h-5 text-plyform-green border-gray-300 rounded focus:ring-2 focus:ring-plyform-green/20"
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
                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-plyform-green/20 focus:border-plyform-green outline-none transition-all font-serif text-2xl"
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
            <div class="p-6 bg-gradient-to-r from-plyform-mint/20 to-plyform-green/10 border-2 border-plyform-mint rounded-xl">
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
                    type="button" 
                    id="final-submit-btn"
                    onclick="handleSubmitClick()"
                    class="px-8 py-3 bg-gradient-to-r from-plyform-green to-plyform-green text-white font-semibold rounded-lg hover:from-plyform-green/90 hover:to-plyform-green/90 transition shadow-sm flex items-center gap-2"
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


<!-- ===================== CUSTOM CONFIRM MODAL ===================== -->
<div id="submit-confirm-modal" class="fixed inset-0 z-50 flex items-center justify-center hidden" aria-modal="true" role="dialog">
    <!-- Backdrop -->
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" id="modal-backdrop"></div>

    <!-- Modal Box -->
    <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-md mx-4 overflow-hidden animate-modal-in">
        
        <!-- Top accent bar -->
        <div class="h-1.5 w-full bg-gradient-to-r from-[#5E17EB] via-[#7C3AED] to-[#a78bfa]"></div>

        <!-- Body -->
        <div class="p-8">
            <!-- Icon -->
            <div class="flex items-center justify-center mb-5">
                <div class="w-16 h-16 rounded-full bg-gradient-to-br from-[#5E17EB]/10 to-[#a78bfa]/20 flex items-center justify-center">
                    <svg class="w-8 h-8 text-[#5E17EB]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>

            <!-- Title -->
            <h3 class="text-xl font-bold text-center text-gray-900 mb-2">Submit Your Profile?</h3>
            <p class="text-sm text-center text-gray-500 mb-6 leading-relaxed">
                Make sure all your information is correct before submitting. 
                Once sent, it will be reviewed by our admin team within <strong class="text-gray-700">1–2 business days</strong>.
            </p>

            <!-- Checklist -->
            <ul class="space-y-2 mb-7 bg-gray-50 rounded-xl p-4 text-sm text-gray-700">
                <li class="flex items-center gap-2">
                    <span class="w-5 h-5 rounded-full bg-green-100 flex items-center justify-center flex-shrink-0">
                        <svg class="w-3 h-3 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                    </span>
                    All information will be verified
                </li>
                <li class="flex items-center gap-2">
                    <span class="w-5 h-5 rounded-full bg-green-100 flex items-center justify-center flex-shrink-0">
                        <svg class="w-3 h-3 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                    </span>
                    You'll be notified via email once approved
                </li>
                <li class="flex items-center gap-2">
                    <span class="w-5 h-5 rounded-full bg-green-100 flex items-center justify-center flex-shrink-0">
                        <svg class="w-3 h-3 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                    </span>
                    You can view your submitted profile anytime
                </li>
            </ul>

            <!-- Actions -->
            <div class="flex gap-3">
                <button 
                    type="button" 
                    onclick="closeConfirmModal()"
                    class="flex-1 px-5 py-3 rounded-xl border-2 border-gray-200 text-gray-700 font-semibold text-sm hover:bg-gray-50 hover:border-gray-300 transition-all"
                >
                    Go Back
                </button>
                <button 
                    type="button" 
                    onclick="confirmSubmit()"
                    class="flex-1 px-5 py-3 rounded-xl bg-gradient-to-r from-[#5E17EB] to-[#7C3AED] text-white font-semibold text-sm hover:from-[#4c13c2] hover:to-[#6b30d4] transition-all shadow-md hover:shadow-lg flex items-center justify-center gap-2"
                    id="modal-confirm-btn"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Yes, Submit
                </button>
            </div>
        </div>
    </div>
</div>
<!-- ===================== END MODAL ===================== -->


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

/* Modal entrance animation */
@keyframes modalIn {
    from { opacity: 0; transform: scale(0.92) translateY(16px); }
    to   { opacity: 1; transform: scale(1) translateY(0); }
}
.animate-modal-in {
    animation: modalIn 0.22s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
}
</style>


<script>
function toggleTerms() {
    const formDiv = document.getElementById('terms-form');
    const chevron = document.getElementById('terms-chevron');
    const editBtn = document.getElementById('terms-edit-btn');
    
    if (formDiv.classList.contains('hidden')) {
        formDiv.classList.remove('hidden');
        chevron.style.transform = 'rotate(180deg)';
        editBtn.querySelector('span').textContent = 'Close';
        setTimeout(() => {
            document.getElementById('terms-card').scrollIntoView({ behavior: 'smooth', block: 'start' });
        }, 100);
    } else {
        formDiv.classList.add('hidden');
        chevron.style.transform = 'rotate(0deg)';
        editBtn.querySelector('span').textContent = 'Edit';
    }
}

function handleSubmitClick() {
    const termsCheckbox = document.querySelector('input[name="terms_accepted"]');
    const signature     = document.querySelector('input[name="signature"]');

    if (!termsCheckbox.checked) {
        showValidationAlert('Please accept the terms and conditions before submitting.');
        return;
    }
    if (!signature.value.trim()) {
        showValidationAlert('Please provide your signature before submitting.');
        return;
    }

    // All good — show custom confirm modal
    openConfirmModal();
}

function openConfirmModal() {
    const modal = document.getElementById('submit-confirm-modal');
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeConfirmModal() {
    const modal = document.getElementById('submit-confirm-modal');
    modal.classList.add('hidden');
    document.body.style.overflow = '';
}

function confirmSubmit() {
    const btn = document.getElementById('modal-confirm-btn');
    btn.disabled = true;
    btn.innerHTML = `
        <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/>
        </svg>
        Submitting…
    `;
    document.getElementById('terms-submit-form').submit();
}

// Close modal when clicking backdrop
document.getElementById('modal-backdrop').addEventListener('click', closeConfirmModal);

// Close modal on Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeConfirmModal();
});

// ── Simple inline validation toast (replaces alert()) ──────────────────────
function showValidationAlert(message) {
    // Remove existing if any
    const existing = document.getElementById('validation-toast');
    if (existing) existing.remove();

    const toast = document.createElement('div');
    toast.id = 'validation-toast';
    toast.className = 'fixed bottom-6 left-1/2 -translate-x-1/2 z-50 flex items-center gap-3 bg-white border-2 border-red-300 text-red-700 text-sm font-medium px-5 py-3 rounded-xl shadow-xl';
    toast.innerHTML = `
        <svg class="w-5 h-5 flex-shrink-0 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M12 3a9 9 0 100 18A9 9 0 0012 3z"/>
        </svg>
        ${message}
    `;
    document.body.appendChild(toast);
    setTimeout(() => toast.remove(), 4000);
}
</script>