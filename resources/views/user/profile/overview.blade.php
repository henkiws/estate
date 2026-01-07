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
            
            <!-- Section 8: References -->
            @include('user.profile.cards.references-card')
            
            <!-- Section 9: Identification -->
            @include('user.profile.cards.identification-card')
            
            <!-- Section 10: Terms & Conditions -->
            @include('user.profile.cards.terms-card')
            
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
@endpush
@endsection