<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choose Your Plan - Plyform</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-gray-50 via-white to-plyform-mint/20">
    <div class="min-h-screen py-8 px-4" x-data="{ isYearly: false }">
        <div class="max-w-7xl mx-auto">

            <!-- Error Messages -->
            @if(session('error'))
            <div class="bg-plyform-orange/10 border-l-4 border-plyform-orange rounded-xl p-6 mb-8 shadow-lg animate-fadeIn">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-plyform-orange/20 rounded-full flex items-center justify-center">
                            <svg class="w-7 h-7 text-plyform-orange" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4 flex-1">
                        <h3 class="text-xl font-bold text-plyform-orange mb-1">⚠️ Error</h3>
                        <p class="text-sm text-gray-700">{{ session('error') }}</p>
                    </div>
                    <button onclick="this.parentElement.parentElement.remove()" class="text-plyform-orange hover:text-plyform-orange/80">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
            </div>
            @endif

            <!-- Warning Messages -->
            @if(session('warning'))
            <div class="bg-plyform-yellow/20 border-l-4 border-plyform-yellow rounded-xl p-6 mb-8 shadow-lg animate-fadeIn">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-plyform-yellow/30 rounded-full flex items-center justify-center">
                            <svg class="w-7 h-7 text-plyform-dark" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4 flex-1">
                        <h3 class="text-xl font-bold text-plyform-dark mb-1">⚠️ Warning</h3>
                        <p class="text-sm text-gray-700">{{ session('warning') }}</p>
                    </div>
                    <button onclick="this.parentElement.parentElement.remove()" class="text-gray-600 hover:text-gray-800">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
            </div>
            @endif

            <!-- Success Messages -->
            @if(session('success'))
            <div class="bg-plyform-mint/20 border-l-4 border-plyform-mint rounded-xl p-6 mb-8 shadow-lg animate-fadeIn">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-plyform-mint/40 rounded-full flex items-center justify-center">
                            <svg class="w-7 h-7 text-plyform-dark" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4 flex-1">
                        <h3 class="text-xl font-bold text-plyform-dark mb-1">✅ Success</h3>
                        <p class="text-sm text-gray-700">{{ session('success') }}</p>
                    </div>
                    <button onclick="this.parentElement.parentElement.remove()" class="text-gray-600 hover:text-gray-800">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
            </div>
            @endif

            <!-- Validation Errors -->
            @if($errors->any())
            <div class="bg-plyform-orange/10 border-l-4 border-plyform-orange rounded-xl p-6 mb-8 shadow-lg animate-fadeIn">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-plyform-orange/20 rounded-full flex items-center justify-center">
                            <svg class="w-7 h-7 text-plyform-orange" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4 flex-1">
                        <h3 class="text-xl font-bold text-plyform-orange mb-2">⚠️ Validation Errors</h3>
                        <ul class="list-disc list-inside text-sm text-gray-700 space-y-1">
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <button onclick="this.parentElement.parentElement.remove()" class="text-plyform-orange hover:text-plyform-orange/80">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
            </div>
            @endif
        
            <!-- Success Banner -->
            <div class="bg-gradient-to-r from-plyform-mint/30 to-plyform-mint/20 border-l-4 border-plyform-mint rounded-xl p-6 mb-8 shadow-lg animate-fadeIn">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-plyform-mint/40 rounded-full flex items-center justify-center">
                            <svg class="w-7 h-7 text-plyform-dark" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4 flex-1">
                        <h3 class="text-xl font-bold text-plyform-dark mb-1">🎉 Congratulations, {{ $agency->agency_name }}!</h3>
                        <p class="text-sm text-gray-700">
                            Your agency has been approved! You're one step away from accessing all features. Choose a subscription plan to get started.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Debug Info (Remove in production) -->
            @if(config('app.debug'))
            <div class="bg-plyform-purple/10 border-l-4 border-plyform-purple rounded-xl p-6 mb-8">
                <h4 class="font-bold text-plyform-dark mb-2">🔧 Debug Info</h4>
                <div class="text-sm text-gray-700 space-y-1">
                    <p><strong>Agency ID:</strong> {{ $agency->id }}</p>
                    <p><strong>Agency Status:</strong> {{ $agency->status }}</p>
                    <p><strong>Plans Count:</strong> {{ $plans->count() }}</p>
                    <p><strong>Stripe Configured:</strong> {{ config('services.stripe.secret') ? '✅ Yes' : '❌ No' }}</p>
                    @if($plans->count() > 0)
                    <p><strong>First Plan ID:</strong> {{ $plans->first()->id }}</p>
                    <p><strong>First Plan Stripe Price ID:</strong> {{ $plans->first()->stripe_price_id ?? '❌ Not Set' }}</p>
                    @endif
                </div>
            </div>
            @endif

            <!-- Header -->
            <div class="text-center mb-12">
                <h1 class="text-4xl md:text-5xl font-bold text-plyform-dark mb-4">
                    Choose Your Perfect Plan
                </h1>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Select the plan that fits your agency's needs. Start with a 14-day free trial.
                </p>
            </div>

            <!-- Billing Toggle -->
            <div class="flex justify-center items-center gap-4 mb-12">
                <span class="text-sm font-semibold transition-colors duration-300" 
                      :class="isYearly ? 'text-gray-700' : 'text-plyform-purple font-bold'">
                    Monthly
                </span>
                <button type="button" 
                        @click="isYearly = !isYearly"
                        class="relative inline-flex h-7 w-14 items-center rounded-full transition-all duration-300 ease-in-out focus:outline-none focus:ring-2 focus:ring-plyform-purple focus:ring-offset-2"
                        :class="isYearly ? 'bg-plyform-purple' : 'bg-gray-300'">
                    <span class="inline-block h-5 w-5 transform rounded-full bg-white transition-transform duration-300 ease-in-out shadow-lg"
                          :class="isYearly ? 'translate-x-8' : 'translate-x-1'"></span>
                </button>
                <span class="text-sm font-semibold flex items-center gap-2 transition-colors duration-300" 
                      :class="isYearly ? 'text-plyform-purple font-bold' : 'text-gray-700'">
                    Yearly 
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-plyform-mint text-plyform-dark" 
                          :class="isYearly && 'animate-pulse'">
                        Save 20%
                    </span>
                </span>
            </div>

            <!-- Subscription Plans -->
            @if($plans->count() > 0)
            <div class="grid md:grid-cols-3 gap-8 mb-12">
                @foreach($plans as $index => $plan)
                <div class="relative bg-white rounded-2xl shadow-xl overflow-hidden transform transition-all duration-300 hover:scale-105 hover:shadow-2xl {{ $plan->is_popular ? 'ring-4 ring-plyform-purple ring-offset-2' : 'hover:ring-2 hover:ring-plyform-mint' }}">
                    
                    @if($plan->is_popular)
                    <div class="absolute top-0 right-0 bg-gradient-to-r from-plyform-yellow to-plyform-orange text-plyform-dark px-4 py-1 text-xs font-bold uppercase rounded-bl-lg shadow-lg">
                        ⭐ Most Popular
                    </div>
                    @endif

                    <div class="p-8">
                        <!-- Plan Icon -->
                        <div class="w-16 h-16 bg-gradient-to-br {{ $plan->is_popular ? 'from-plyform-purple to-plyform-dark' : 'from-gray-400 to-gray-600' }} rounded-2xl flex items-center justify-center mb-6 shadow-lg">
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
                        <h3 class="text-2xl font-bold text-plyform-dark mb-2">{{ $plan->name }}</h3>
                        <p class="text-gray-600 text-sm mb-6 min-h-[3rem]">{{ $plan->description }}</p>

                        <!-- Price -->
                        <div class="mb-8">
                            <div class="flex items-baseline">
                                <span class="text-5xl font-extrabold text-plyform-dark transition-all duration-300">
                                    <span x-text="isYearly ? '$' + Math.round({{ $plan->price }} * 12 * 0.8) : '${{ number_format($plan->price, 0) }}'">
                                        ${{ number_format($plan->price, 0) }}
                                    </span>
                                </span>
                                <span class="text-gray-600 ml-2 text-lg transition-all duration-300">
                                    /<span x-text="isYearly ? 'year' : 'month'">month</span>
                                </span>
                            </div>
                            <div class="text-sm text-gray-500 mt-2 min-h-[1.5rem]">
                                <span x-show="isYearly" 
                                      x-transition:enter="transition ease-out duration-200"
                                      x-transition:enter-start="opacity-0 transform -translate-y-2"
                                      x-transition:enter-end="opacity-100 transform translate-y-0"
                                      class="text-plyform-mint font-semibold block">
                                    💰 Save ${{ number_format($plan->price * 12 * 0.2, 0) }}/year!
                                </span>
                                <span x-show="!isYearly"
                                      x-transition:enter="transition ease-out duration-200"
                                      x-transition:enter-start="opacity-0 transform -translate-y-2"
                                      x-transition:enter-end="opacity-100 transform translate-y-0"
                                      class="block">
                                    Billed monthly
                                </span>
                            </div>
                        </div>

                        <!-- Features -->
                        <ul class="space-y-4 mb-8">
                            @foreach($plan->features as $feature)
                            <li class="flex items-start group">
                                <svg class="w-5 h-5 text-plyform-mint mr-3 mt-0.5 flex-shrink-0 group-hover:scale-110 transition-transform" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-gray-700 text-sm">{{ $feature }}</span>
                            </li>
                            @endforeach
                        </ul>

                        <!-- CTA Button -->
                        <form action="{{ route('agency.subscription.checkout', $plan->id) }}" method="POST" id="checkout-form-{{ $plan->id }}">
                            @csrf
                            <input type="hidden" name="billing_cycle" :value="isYearly ? 'yearly' : 'monthly'">
                            <button type="submit" 
                                    class="w-full py-4 px-6 rounded-xl font-bold text-lg transition-all duration-200 shadow-lg hover:shadow-2xl transform hover:-translate-y-1
                                           {{ $plan->is_popular 
                                              ? 'bg-gradient-to-r from-plyform-purple to-plyform-dark text-white hover:from-plyform-purple/90 hover:to-plyform-dark/90' 
                                              : 'bg-gradient-to-r from-plyform-yellow to-plyform-mint text-plyform-dark hover:from-plyform-yellow/90 hover:to-plyform-mint/90' }}"
                                    onclick="this.disabled=true; this.innerHTML='<svg class=\'animate-spin h-5 w-5 inline-block\' xmlns=\'http://www.w3.org/2000/svg\' fill=\'none\' viewBox=\'0 0 24 24\'><circle class=\'opacity-25\' cx=\'12\' cy=\'12\' r=\'10\' stroke=\'currentColor\' stroke-width=\'4\'></circle><path class=\'opacity-75\' fill=\'currentColor\' d=\'M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z\'></path></svg> Processing...'; this.form.submit();">
                                <span x-show="!isYearly">Choose {{ $plan->name }}</span>
                                <span x-show="isYearly" style="display: none;">Choose {{ $plan->name }} (Yearly)</span>
                            </button>
                        </form>

                        <p class="text-xs text-center text-gray-500 mt-4">
                            14-day free trial • <span x-text="isYearly ? 'Billed yearly' : 'No credit card required'">No credit card required</span> • Cancel anytime
                        </p>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="bg-plyform-orange/10 border-l-4 border-plyform-orange rounded-xl p-8 mb-8 text-center">
                <svg class="w-16 h-16 text-plyform-orange mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
                <h3 class="text-xl font-bold text-plyform-dark mb-2">No Subscription Plans Available</h3>
                <p class="text-gray-700 mb-4">Please run the subscription plans seeder:</p>
                <code class="bg-plyform-orange/20 text-plyform-dark px-4 py-2 rounded text-sm">php artisan db:seed --class=SubscriptionPlansSeeder</code>
            </div>
            @endif

            <!-- Trust Badges -->
            <div class="bg-white rounded-2xl shadow-xl p-8 mb-8">
                <div class="grid md:grid-cols-4 gap-6 text-center">
                    <div class="flex flex-col items-center">
                        <div class="w-12 h-12 bg-plyform-purple/10 rounded-full flex items-center justify-center mb-3">
                            <svg class="w-6 h-6 text-plyform-purple" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                        <h4 class="font-semibold text-plyform-dark mb-1">Secure</h4>
                        <p class="text-xs text-gray-600">256-bit SSL encryption</p>
                    </div>
                    <div class="flex flex-col items-center">
                        <div class="w-12 h-12 bg-plyform-mint/30 rounded-full flex items-center justify-center mb-3">
                            <svg class="w-6 h-6 text-plyform-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h4 class="font-semibold text-plyform-dark mb-1">Money-Back</h4>
                        <p class="text-xs text-gray-600">30-day guarantee</p>
                    </div>
                    <div class="flex flex-col items-center">
                        <div class="w-12 h-12 bg-plyform-yellow/30 rounded-full flex items-center justify-center mb-3">
                            <svg class="w-6 h-6 text-plyform-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                        </div>
                        <h4 class="font-semibold text-plyform-dark mb-1">Support</h4>
                        <p class="text-xs text-gray-600">24/7 customer service</p>
                    </div>
                    <div class="flex flex-col items-center">
                        <div class="w-12 h-12 bg-plyform-orange/10 rounded-full flex items-center justify-center mb-3">
                            <svg class="w-6 h-6 text-plyform-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <h4 class="font-semibold text-plyform-dark mb-1">No Lock-In</h4>
                        <p class="text-xs text-gray-600">Cancel anytime</p>
                    </div>
                </div>
            </div>

            <!-- FAQ Section -->
            <div class="bg-white rounded-2xl shadow-xl p-8 mb-8">
                <h2 class="text-3xl font-bold text-plyform-dark mb-8 text-center">Frequently Asked Questions</h2>
                
                <div class="space-y-4 max-w-3xl mx-auto">
                    <details class="group bg-plyform-mint/10 rounded-xl overflow-hidden hover:bg-plyform-mint/20 transition-colors">
                        <summary class="flex justify-between items-center cursor-pointer list-none p-5">
                            <span class="font-semibold text-plyform-dark">Can I change my plan later?</span>
                            <svg class="w-5 h-5 text-gray-500 transition-transform group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </summary>
                        <p class="text-gray-600 px-5 pb-5 text-sm">
                            Yes! You can upgrade or downgrade your plan at any time from your dashboard. Changes take effect immediately, and we'll prorate the charges accordingly.
                        </p>
                    </details>

                    <details class="group bg-plyform-purple/10 rounded-xl overflow-hidden hover:bg-plyform-purple/20 transition-colors">
                        <summary class="flex justify-between items-center cursor-pointer list-none p-5">
                            <span class="font-semibold text-plyform-dark">What payment methods do you accept?</span>
                            <svg class="w-5 h-5 text-gray-500 transition-transform group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </summary>
                        <p class="text-gray-600 px-5 pb-5 text-sm">
                            We accept all major credit cards (Visa, Mastercard, American Express, Discover) and debit cards through our secure Stripe payment processor.
                        </p>
                    </details>

                    <details class="group bg-plyform-yellow/20 rounded-xl overflow-hidden hover:bg-plyform-yellow/30 transition-colors">
                        <summary class="flex justify-between items-center cursor-pointer list-none p-5">
                            <span class="font-semibold text-plyform-dark">Is there a contract or commitment?</span>
                            <svg class="w-5 h-5 text-gray-500 transition-transform group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </summary>
                        <p class="text-gray-600 px-5 pb-5 text-sm">
                            No! All plans are month-to-month with no long-term contract required. You can cancel anytime with just one click, and there are absolutely no cancellation fees.
                        </p>
                    </details>

                    <details class="group bg-plyform-orange/10 rounded-xl overflow-hidden hover:bg-plyform-orange/20 transition-colors">
                        <summary class="flex justify-between items-center cursor-pointer list-none p-5">
                            <span class="font-semibold text-plyform-dark">What happens after the 14-day trial?</span>
                            <svg class="w-5 h-5 text-gray-500 transition-transform group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </summary>
                        <p class="text-gray-600 px-5 pb-5 text-sm">
                            After your free trial ends, your selected payment method will be charged automatically. You'll receive email reminders 7 days and 3 days before the trial ends, so you won't be surprised.
                        </p>
                    </details>

                    <details class="group bg-plyform-mint/10 rounded-xl overflow-hidden hover:bg-plyform-mint/20 transition-colors">
                        <summary class="flex justify-between items-center cursor-pointer list-none p-5">
                            <span class="font-semibold text-plyform-dark">Can I get a refund if I'm not satisfied?</span>
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
                       class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-plyform-purple to-plyform-dark text-white font-semibold rounded-xl hover:from-plyform-purple/90 hover:to-plyform-dark/90 transition-colors shadow-md hover:shadow-lg">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        Email Support
                    </a>
                    <a href="tel:1300123456" 
                       class="inline-flex items-center px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-xl hover:bg-gray-200 transition-colors">
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
                            class="inline-flex items-center justify-center px-8 py-3 bg-gray-100 text-gray-700 font-semibold rounded-xl hover:bg-gray-200 transition-colors">
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
</body>
</html>