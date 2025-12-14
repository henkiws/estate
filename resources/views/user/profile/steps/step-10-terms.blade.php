<x-form-section-card 
    title="Terms & Conditions" 
    description="Please review and accept the terms and conditions to complete your profile"
    required>
    
    <!-- Terms Content -->
    <div class="p-6 bg-gray-50 border border-gray-200 rounded-lg max-h-96 overflow-y-auto">
        <h3 class="font-bold text-gray-900 mb-4">Rental Application Terms & Conditions</h3>
        
        <div class="space-y-4 text-sm text-gray-700">
            <p><strong>1. Application Information</strong></p>
            <p>I declare that the information provided in this application is true and correct. I understand that providing false or misleading information may result in the rejection of my application or termination of any tenancy agreement.</p>
            
            <p><strong>2. Privacy & Data Protection</strong></p>
            <p>I consent to the collection, use, and disclosure of my personal information for the purposes of processing this rental application. This includes but is not limited to: identity verification, credit checks, reference checks, and assessment of rental suitability.</p>
            
            <p><strong>3. Reference & Background Checks</strong></p>
            <p>I authorize the property manager to contact my references, current and previous landlords, employers, and other parties as necessary to verify the information provided in this application.</p>
            
            <p><strong>4. Credit Check Authorization</strong></p>
            <p>I authorize the property manager to obtain my credit report and credit score from credit reporting agencies for the purpose of assessing my rental application.</p>
            
            <p><strong>5. Document Verification</strong></p>
            <p>I understand that all documents provided (including identification, employment letters, and bank statements) may be verified for authenticity.</p>
            
            <p><strong>6. Application Fee</strong></p>
            <p>I understand that any application fees paid are non-refundable, regardless of whether my application is successful.</p>
            
            <p><strong>7. No Guarantee of Approval</strong></p>
            <p>I understand that submitting this application does not guarantee approval or secure the rental property. The property manager reserves the right to accept or reject any application.</p>
            
            <p><strong>8. Data Retention</strong></p>
            <p>I understand that my application information will be retained for a period as required by law, after which it will be securely destroyed.</p>
            
            <p><strong>9. Communication</strong></p>
            <p>I consent to receiving communications regarding my application via email, phone, or SMS to the contact details provided.</p>
            
            <p><strong>10. Accuracy of Information</strong></p>
            <p>I agree to notify the property manager immediately if any information provided in this application changes before a tenancy agreement is signed.</p>
        </div>
    </div>
    
    <!-- Acceptance Checkbox -->
    <div class="mt-6">
        <label class="flex items-start gap-3 cursor-pointer">
            <input 
                type="checkbox" 
                name="terms_accepted" 
                value="1"
                required
                class="mt-1 w-5 h-5 text-teal-600 border-gray-300 rounded focus:ring-2 focus:ring-teal-500"
            >
            <span class="text-sm text-gray-700">
                I have read, understood, and agree to the above terms and conditions. 
                I declare that all information provided is true and accurate to the best of my knowledge.
                <span class="text-red-500">*</span>
            </span>
        </label>
        @error('terms_accepted')
            <p class="mt-2 ml-8 text-sm text-red-600">{{ $message }}</p>
        @enderror>
    </div>
    
</x-form-section-card>

<x-form-section-card 
    title="Electronic Signature" 
    description="Please sign below to confirm your agreement"
    required>
    
    <!-- Signature Field -->
    <div>
        <label class="flex items-center gap-2 text-sm font-medium text-gray-700 mb-2">
            Full Name (as signature) <span class="text-red-500">*</span>
            <x-profile-help-text text="Type your full legal name as your electronic signature" />
        </label>
        <input 
            type="text" 
            name="signature" 
            value="{{ old('signature', $profile->signature ?? '') }}"
            required
            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent font-serif text-2xl"
            placeholder="Your Full Name"
        >
        @error('signature')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
        <p class="mt-2 text-xs text-gray-500">By typing your name, you agree that this constitutes a legal electronic signature</p>
    </div>
    
    <!-- Date Display -->
    <div>
        <label class="text-sm font-medium text-gray-700 mb-2 block">Date</label>
        <input 
            type="text" 
            value="{{ now()->format('F j, Y') }}"
            disabled
            class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg text-gray-700"
        >
    </div>
    
</x-form-section-card>

<!-- Final Submission Notice -->
<div class="p-6 bg-gradient-to-r from-teal-50 to-blue-50 border-2 border-teal-200 rounded-xl">
    <div class="flex items-start gap-4">
        <svg class="w-8 h-8 text-teal-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <div>
            <h4 class="font-bold text-gray-900 mb-2">Ready to Submit?</h4>
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
// Confirm before submitting
document.getElementById('final-submit-btn').addEventListener('click', function(e) {
    const termsCheckbox = document.querySelector('input[name="terms_accepted"]');
    const signature = document.querySelector('input[name="signature"]').value.trim();
    
    if (!termsCheckbox.checked) {
        e.preventDefault();
        alert('Please accept the terms and conditions before submitting');
        return false;
    }
    
    if (!signature) {
        e.preventDefault();
        alert('Please provide your signature before submitting');
        return false;
    }
    
    if (!confirm('Are you sure you want to submit your profile for approval? You cannot edit it after submission.')) {
        e.preventDefault();
        return false;
    }
});
</script>