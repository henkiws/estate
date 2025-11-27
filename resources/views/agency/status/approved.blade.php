<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choose Your Plan - Sorted Services</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-gray-50 via-white to-blue-50">
    <div class="min-h-screen py-8 px-4">
        <div class="max-w-7xl mx-auto">
        
            <!-- Success Banner -->
            <div class="bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 rounded-xl p-6 mb-8 shadow-lg animate-fadeIn">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                            <svg class="w-7 h-7 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4 flex-1">
                        <h3 class="text-xl font-bold text-green-900 mb-1">🎉 Congratulations, {{ $agency->agency_name }}!</h3>
                        <p class="text-sm text-green-700">
                            Your agency has been approved! You're one step away from accessing all features. Choose a subscription plan to get started.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Header -->
            <div class="text-center mb-12">
                <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
                    Choose Your Perfect Plan
                </h1>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Select the plan that fits your agency's needs. Start with a 14-day free trial.
                </p>
            </div>

            <!-- Billing Toggle -->
            <div class="flex justify-center items-center gap-4 mb-12">
                <span class="text-sm font-semibold text-gray-700" :class="{ 'text-blue-600': !isYearly }">Monthly</span>
                <button type="button" 
                        @click="toggleBilling()"
                        class="relative inline-flex h-7 w-14 items-center rounded-full transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                        :class="isYearly ? 'bg-blue-600' : 'bg-gray-300'"
                        x-data="{ isYearly: false }">
                    <span class="inline-block h-5 w-5 transform rounded-full bg-white transition-transform shadow-lg"
                          :class="isYearly ? 'translate-x-8' : 'translate-x-1'"></span>
                </button>
                <span class="text-sm font-semibold text-gray-700 flex items-center gap-2" :class="{ 'text-blue-600': isYearly }">
                    Yearly 
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-green-100 text-green-800 animate-pulse">
                        Save 20%
                    </span>
                </span>
            </div>

            <!-- Subscription Plans -->
            <div class="grid md:grid-cols-3 gap-8 mb-12" x-data="planSelector()">
                @foreach($plans as $index => $plan)
                <div class="relative bg-white rounded-2xl shadow-xl overflow-hidden transform transition-all duration-300 hover:scale-105 hover:shadow-2xl {{ $plan->is_popular ? 'ring-4 ring-blue-500 ring-offset-2' : 'hover:ring-2 hover:ring-blue-300' }}">
                    
                    @if($plan->is_popular)
                    <div class="absolute top-0 right-0 bg-gradient-to-r from-yellow-400 to-orange-500 text-white px-4 py-1 text-xs font-bold uppercase rounded-bl-lg shadow-lg">
                        ⭐ Most Popular
                    </div>
                    @endif

                    <div class="p-8">
                        <!-- Plan Icon -->
                        <div class="w-16 h-16 bg-gradient-to-br {{ $plan->is_popular ? 'from-blue-500 to-indigo-600' : 'from-gray-400 to-gray-600' }} rounded-2xl flex items-center justify-center mb-6 shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                @if($loop->first)
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                @elseif($loop->last)
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                                @else
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                                @endif
                            </svg>
                        </div>

                        <!-- Plan Name -->
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ $plan->name }}</h3>
                        <p class="text-gray-600 text-sm mb-6 min-h-[3rem]">{{ $plan->description }}</p>

                        <!-- Price -->
                        <div class="mb-8">
                            <div class="flex items-baseline">
                                <span class="text-5xl font-extrabold text-gray-900" 
                                      x-text="isYearly ? '$' + Math.round({{ $plan->price }} * 12 * 0.8) : '${{ number_format($plan->price, 0) }}'">
                                    ${{ number_format($plan->price, 0) }}
                                </span>
                                <span class="text-gray-600 ml-2 text-lg">
                                    /<span x-text="isYearly ? 'year' : 'month'">month</span>
                                </span>
                            </div>
                            <p class="text-sm text-gray-500 mt-2">
                                <span x-show="isYearly" class="text-green-600 font-semibold">
                                    Save ${{ number_format($plan->price * 12 * 0.2, 0) }}/year 🎉
                                </span>
                                <span x-show="!isYearly">
                                    Billed monthly
                                </span>
                            </p>
                        </div>

                        <!-- Features -->
                        <ul class="space-y-4 mb-8">
                            @foreach($plan->features as $feature)
                            <li class="flex items-start group">
                                <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5 flex-shrink-0 group-hover:scale-110 transition-transform" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-gray-700 text-sm">{{ $feature }}</span>
                            </li>
                            @endforeach
                        </ul>

                        <!-- CTA Button -->
                        <form action="{{ route('agency.subscription.checkout', $plan->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="billing_cycle" x-model="isYearly ? 'yearly' : 'monthly'" value="monthly">
                            <button type="submit" 
                                    class="w-full py-4 px-6 rounded-xl font-bold text-lg transition-all duration-200 shadow-lg hover:shadow-2xl transform hover:-translate-y-1
                                           {{ $plan->is_popular 
                                              ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white hover:from-blue-700 hover:to-indigo-700' 
                                              : 'bg-gray-900 text-white hover:bg-gray-800' }}">
                                Choose {{ $plan->name }}
                            </button>
                        </form>

                        <p class="text-xs text-center text-gray-500 mt-4">
                            14-day free trial • No credit card required • Cancel anytime
                        </p>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Trust Badges -->
            <div class="bg-white rounded-2xl shadow-xl p-8 mb-8">
                <div class="grid md:grid-cols-4 gap-6 text-center">
                    <div class="flex flex-col items-center">
                        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mb-3">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                        <h4 class="font-semibold text-gray-900 mb-1">Secure</h4>
                        <p class="text-xs text-gray-600">256-bit SSL encryption</p>
                    </div>
                    <div class="flex flex-col items-center">
                        <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mb-3">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h4 class="font-semibold text-gray-900 mb-1">Money-Back</h4>
                        <p class="text-xs text-gray-600">30-day guarantee</p>
                    </div>
                    <div class="flex flex-col items-center">
                        <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mb-3">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                        </div>
                        <h4 class="font-semibold text-gray-900 mb-1">Support</h4>
                        <p class="text-xs text-gray-600">24/7 customer service</p>
                    </div>
                    <div class="flex flex-col items-center">
                        <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center mb-3">
                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <h4 class="font-semibold text-gray-900 mb-1">No Lock-In</h4>
                        <p class="text-xs text-gray-600">Cancel anytime</p>
                    </div>
                </div>
            </div>

            <!-- FAQ Section -->
            <div class="bg-white rounded-2xl shadow-xl p-8 mb-8">
                <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">Frequently Asked Questions</h2>
                
                <div class="space-y-4 max-w-3xl mx-auto">
                    <details class="group bg-gray-50 rounded-xl overflow-hidden hover:bg-gray-100 transition-colors">
                        <summary class="flex justify-between items-center cursor-pointer list-none p-5">
                            <span class="font-semibold text-gray-900">Can I change my plan later?</span>
                            <svg class="w-5 h-5 text-gray-500 transition-transform group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </summary>
                        <p class="text-gray-600 px-5 pb-5 text-sm">
                            Yes! You can upgrade or downgrade your plan at any time from your dashboard. Changes take effect immediately, and we'll prorate the charges accordingly.
                        </p>
                    </details>

                    <details class="group bg-gray-50 rounded-xl overflow-hidden hover:bg-gray-100 transition-colors">
                        <summary class="flex justify-between items-center cursor-pointer list-none p-5">
                            <span class="font-semibold text-gray-900">What payment methods do you accept?</span>
                            <svg class="w-5 h-5 text-gray-500 transition-transform group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </summary>
                        <p class="text-gray-600 px-5 pb-5 text-sm">
                            We accept all major credit cards (Visa, Mastercard, American Express, Discover) and debit cards through our secure Stripe payment processor.
                        </p>
                    </details>

                    <details class="group bg-gray-50 rounded-xl overflow-hidden hover:bg-gray-100 transition-colors">
                        <summary class="flex justify-between items-center cursor-pointer list-none p-5">
                            <span class="font-semibold text-gray-900">Is there a contract or commitment?</span>
                            <svg class="w-5 h-5 text-gray-500 transition-transform group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </summary>
                        <p class="text-gray-600 px-5 pb-5 text-sm">
                            No! All plans are month-to-month with no long-term contract required. You can cancel anytime with just one click, and there are absolutely no cancellation fees.
                        </p>
                    </details>

                    <details class="group bg-gray-50 rounded-xl overflow-hidden hover:bg-gray-100 transition-colors">
                        <summary class="flex justify-between items-center cursor-pointer list-none p-5">
                            <span class="font-semibold text-gray-900">What happens after the 14-day trial?</span>
                            <svg class="w-5 h-5 text-gray-500 transition-transform group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </summary>
                        <p class="text-gray-600 px-5 pb-5 text-sm">
                            After your free trial ends, your selected payment method will be charged automatically. You'll receive email reminders 7 days and 3 days before the trial ends, so you won't be surprised.
                        </p>
                    </details>

                    <details class="group bg-gray-50 rounded-xl overflow-hidden hover:bg-gray-100 transition-colors">
                        <summary class="flex justify-between items-center cursor-pointer list-none p-5">
                            <span class="font-semibold text-gray-900">Can I get a refund if I'm not satisfied?</span>
                            <svg class="w-5 h-5 text-gray-500 transition-transform group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </summary>
                        <p class="text-gray-600 px-5 pb-5 text-sm">
                            Yes! We offer a 30-day money-back guarantee. If you're not completely satisfied within the first 30 days, contact our support team for a full refund, no questions asked.
                        </p>
                    </details>
                </div>
            </div>

            <!-- Support -->
            <div class="text-center mb-8">
                <p class="text-gray-600 mb-4">
                    Still have questions? We're here to help!
                </p>
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    <a href="mailto:support@sorted.com" 
                       class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors shadow-md hover:shadow-lg">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        Email Support
                    </a>
                    <a href="tel:1300123456" 
                       class="inline-flex items-center px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        Call Us
                    </a>
                </div>
            </div>

            <!-- Logout Button -->
            <div class="flex justify-center">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" 
                            class="inline-flex items-center justify-center px-8 py-3 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        Logout
                    </button>
                </form>
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

    <!-- Alpine.js for interactivity -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <script>
        function planSelector() {
            return {
                isYearly: false,
                toggleBilling() {
                    this.isYearly = !this.isYearly;
                }
            }
        }
    </script>
</body>
</html>