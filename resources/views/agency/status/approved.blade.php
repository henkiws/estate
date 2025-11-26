@extends('layouts.admin')

@section('title', 'Choose Your Plan - Sorted Services')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 via-white to-blue-50 py-12 px-4">
    <div class="max-w-7xl mx-auto">
        
        <!-- Success Banner -->
        <div class="bg-green-50 border border-green-200 rounded-xl p-6 mb-8 animate-fadeIn">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="ml-4 flex-1">
                    <h3 class="text-lg font-semibold text-green-900">🎉 Congratulations! Your agency has been approved!</h3>
                    <p class="text-sm text-green-700 mt-1">
                        You're one step away from accessing all features. Choose a subscription plan to get started.
                    </p>
                </div>
            </div>
        </div>

        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
                Choose Your Plan
            </h1>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                Select the perfect plan for your agency. All plans include a 14-day free trial.
            </p>
        </div>

        <!-- Billing Toggle -->
        <div class="flex justify-center items-center gap-4 mb-12">
            <span class="text-sm font-medium text-gray-700" id="monthly-label">Monthly</span>
            <button type="button" 
                    onclick="toggleBilling()"
                    class="relative inline-flex h-6 w-11 items-center rounded-full bg-gray-200 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                    id="billing-toggle">
                <span class="translate-x-1 inline-block h-4 w-4 transform rounded-full bg-white transition-transform" id="billing-toggle-dot"></span>
            </button>
            <span class="text-sm font-medium text-gray-700" id="yearly-label">
                Yearly <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">Save 20%</span>
            </span>
        </div>

        <!-- Subscription Plans -->
        <div class="grid md:grid-cols-3 gap-8 mb-12">
            @foreach($plans as $plan)
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden transform transition-all duration-300 hover:scale-105 hover:shadow-2xl {{ $plan->is_popular ? 'ring-2 ring-blue-500' : '' }}">
                
                @if($plan->is_popular)
                <div class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white text-center py-2 text-sm font-semibold">
                    ⭐ MOST POPULAR
                </div>
                @endif

                <div class="p-8">
                    <!-- Plan Name -->
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ $plan->name }}</h3>
                    <p class="text-gray-600 text-sm mb-6 min-h-[3rem]">{{ $plan->description }}</p>

                    <!-- Price -->
                    <div class="mb-6">
                        <div class="flex items-baseline">
                            <span class="text-5xl font-bold text-gray-900 plan-price" data-monthly="{{ $plan->price }}" data-yearly="{{ $plan->price * 12 * 0.8 }}">
                                ${{ number_format($plan->price, 0) }}
                            </span>
                            <span class="text-gray-600 ml-2">
                                /<span class="billing-period">month</span>
                            </span>
                        </div>
                        <p class="text-sm text-gray-500 mt-2">
                            <span class="yearly-savings hidden">Save ${{ number_format($plan->price * 12 * 0.2, 0) }}/year</span>
                            <span class="monthly-note">Billed monthly</span>
                        </p>
                    </div>

                    <!-- Features -->
                    <ul class="space-y-3 mb-8">
                        @foreach($plan->features as $feature)
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-gray-700 text-sm">{{ $feature }}</span>
                        </li>
                        @endforeach
                    </ul>

                    <!-- CTA Button -->
                    <form action="{{ route('agency.subscription.checkout', $plan->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="billing_cycle" value="monthly" class="billing-cycle-input">
                        <button type="submit" 
                                class="w-full py-3 px-6 rounded-lg font-semibold transition-all duration-200 
                                       {{ $plan->is_popular 
                                          ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white hover:from-blue-700 hover:to-indigo-700 shadow-lg hover:shadow-xl' 
                                          : 'bg-gray-100 text-gray-900 hover:bg-gray-200' }}">
                            Choose {{ $plan->name }}
                        </button>
                    </form>

                    <p class="text-xs text-center text-gray-500 mt-4">
                        14-day free trial • Cancel anytime
                    </p>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Document Upload Section -->
        <div class="bg-white rounded-2xl shadow-xl p-8 mb-8">
            <div class="flex items-start mb-6">
                <div class="flex-shrink-0">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <div class="ml-4 flex-1">
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">Required Documents</h2>
                    <p class="text-gray-600">
                        Please upload the following documents. These are required for compliance and verification purposes.
                    </p>
                </div>
            </div>

            <!-- Document Progress -->
            @php
                $totalRequired = $documentRequirements->where('is_required', true)->count();
                $uploadedRequired = $documentRequirements->where('is_required', true)->whereNotNull('file_path')->count();
                $progressPercent = $totalRequired > 0 ? ($uploadedRequired / $totalRequired) * 100 : 0;
            @endphp

            <div class="mb-6">
                <div class="flex justify-between items-center mb-2">
                    <span class="text-sm font-medium text-gray-700">Document Upload Progress</span>
                    <span class="text-sm font-medium text-gray-700">{{ $uploadedRequired }}/{{ $totalRequired }} completed</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-3">
                    <div class="bg-gradient-to-r from-blue-500 to-indigo-600 h-3 rounded-full transition-all duration-300" style="width: {{ $progressPercent }}%"></div>
                </div>
            </div>

            <!-- Document List -->
            <div class="space-y-4">
                @foreach($documentRequirements as $doc)
                <div class="border border-gray-200 rounded-lg p-4 hover:border-blue-300 transition-colors">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-2">
                                <h3 class="font-semibold text-gray-900">{{ $doc->name }}</h3>
                                @if($doc->is_required)
                                <span class="text-xs px-2 py-0.5 bg-red-100 text-red-700 rounded-full font-medium">Required</span>
                                @else
                                <span class="text-xs px-2 py-0.5 bg-gray-100 text-gray-600 rounded-full font-medium">Optional</span>
                                @endif
                            </div>
                            <p class="text-sm text-gray-600 mb-3">{{ $doc->description }}</p>

                            @if($doc->file_path)
                                <!-- Document Uploaded -->
                                <div class="flex items-center justify-between bg-green-50 border border-green-200 rounded-lg p-3">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 text-green-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                        <div>
                                            <p class="text-sm font-medium text-green-900">{{ $doc->file_name }}</p>
                                            <p class="text-xs text-green-700">
                                                Uploaded {{ $doc->uploaded_at->diffForHumans() }} • 
                                                <span class="font-medium">
                                                    @if($doc->status === 'approved')
                                                        ✅ Approved
                                                    @elseif($doc->status === 'pending_review')
                                                        ⏳ Under Review
                                                    @elseif($doc->status === 'rejected')
                                                        ❌ Rejected
                                                    @endif
                                                </span>
                                            </p>
                                        </div>
                                    </div>
                                    <form action="{{ route('agency.documents.delete', $doc->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this document?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-700">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>

                                @if($doc->status === 'rejected' && $doc->rejection_reason)
                                <div class="mt-2 bg-red-50 border border-red-200 rounded-lg p-3">
                                    <p class="text-sm text-red-800">
                                        <strong>Rejection Reason:</strong> {{ $doc->rejection_reason }}
                                    </p>
                                </div>
                                @endif
                            @else
                                <!-- Upload Form -->
                                <form action="{{ route('agency.documents.upload') }}" method="POST" enctype="multipart/form-data" class="flex items-center gap-3">
                                    @csrf
                                    <input type="hidden" name="requirement_id" value="{{ $doc->id }}">
                                    <input type="file" 
                                           name="document" 
                                           accept=".pdf,.jpg,.jpeg,.png"
                                           class="flex-1 text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                                           required>
                                    <button type="submit" 
                                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm font-medium">
                                        Upload
                                    </button>
                                </form>
                                <p class="text-xs text-gray-500 mt-2">
                                    Accepted formats: PDF, JPG, PNG • Max size: 5MB
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="mt-6 text-center">
                <a href="{{ route('agency.documents') }}" 
                   class="inline-flex items-center text-blue-600 hover:text-blue-700 font-medium">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    View All Documents
                </a>
            </div>
        </div>

        <!-- FAQ Section -->
        <div class="bg-white rounded-2xl shadow-xl p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">Frequently Asked Questions</h2>
            
            <div class="space-y-4 max-w-3xl mx-auto">
                <details class="group">
                    <summary class="flex justify-between items-center cursor-pointer list-none p-4 bg-gray-50 rounded-lg hover:bg-gray-100">
                        <span class="font-medium text-gray-900">Can I change my plan later?</span>
                        <svg class="w-5 h-5 text-gray-500 transition-transform group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </summary>
                    <p class="text-gray-600 p-4 text-sm">
                        Yes! You can upgrade or downgrade your plan at any time. Changes take effect immediately, and we'll prorate the charges.
                    </p>
                </details>

                <details class="group">
                    <summary class="flex justify-between items-center cursor-pointer list-none p-4 bg-gray-50 rounded-lg hover:bg-gray-100">
                        <span class="font-medium text-gray-900">What payment methods do you accept?</span>
                        <svg class="w-5 h-5 text-gray-500 transition-transform group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </summary>
                    <p class="text-gray-600 p-4 text-sm">
                        We accept all major credit cards (Visa, Mastercard, American Express) through our secure Stripe payment processor.
                    </p>
                </details>

                <details class="group">
                    <summary class="flex justify-between items-center cursor-pointer list-none p-4 bg-gray-50 rounded-lg hover:bg-gray-100">
                        <span class="font-medium text-gray-900">Is there a contract or commitment?</span>
                        <svg class="w-5 h-5 text-gray-500 transition-transform group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </summary>
                    <p class="text-gray-600 p-4 text-sm">
                        No! All plans are month-to-month with no long-term contract. You can cancel anytime with no cancellation fees.
                    </p>
                </details>

                <details class="group">
                    <summary class="flex justify-between items-center cursor-pointer list-none p-4 bg-gray-50 rounded-lg hover:bg-gray-100">
                        <span class="font-medium text-gray-900">What happens after the 14-day trial?</span>
                        <svg class="w-5 h-5 text-gray-500 transition-transform group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </summary>
                    <p class="text-gray-600 p-4 text-sm">
                        After your free trial ends, your card will be charged automatically. You'll receive an email reminder 3 days before the trial ends.
                    </p>
                </details>
            </div>
        </div>

        <!-- Support -->
        <div class="text-center mt-8">
            <p class="text-gray-600">
                Need help choosing? 
                <a href="mailto:support@sorted.com" class="text-blue-600 hover:text-blue-700 font-medium">Contact our team</a>
            </p>
        </div>
    </div>
</div>

<style>
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fadeIn {
        animation: fadeIn 0.6s ease-out;
    }
</style>

<script>
let isYearly = false;

function toggleBilling() {
    isYearly = !isYearly;
    const toggle = document.getElementById('billing-toggle');
    const dot = document.getElementById('billing-toggle-dot');
    const prices = document.querySelectorAll('.plan-price');
    const periods = document.querySelectorAll('.billing-period');
    const savings = document.querySelectorAll('.yearly-savings');
    const monthlyNotes = document.querySelectorAll('.monthly-note');
    const billingInputs = document.querySelectorAll('.billing-cycle-input');
    
    if (isYearly) {
        toggle.classList.add('bg-blue-600');
        toggle.classList.remove('bg-gray-200');
        dot.classList.add('translate-x-6');
        dot.classList.remove('translate-x-1');
        
        prices.forEach(price => {
            const yearly = parseFloat(price.dataset.yearly);
            price.textContent = '$' + Math.round(yearly);
        });
        
        periods.forEach(period => period.textContent = 'year');
        savings.forEach(saving => saving.classList.remove('hidden'));
        monthlyNotes.forEach(note => note.classList.add('hidden'));
        billingInputs.forEach(input => input.value = 'yearly');
    } else {
        toggle.classList.remove('bg-blue-600');
        toggle.classList.add('bg-gray-200');
        dot.classList.remove('translate-x-6');
        dot.classList.add('translate-x-1');
        
        prices.forEach(price => {
            const monthly = parseFloat(price.dataset.monthly);
            price.textContent = '$' + Math.round(monthly);
        });
        
        periods.forEach(period => period.textContent = 'month');
        savings.forEach(saving => saving.classList.add('hidden'));
        monthlyNotes.forEach(note => note.classList.remove('hidden'));
        billingInputs.forEach(input => input.value = 'monthly');
    }
}
</script>
@endsection