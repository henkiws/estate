<x-guest-layout title="Sign Up - plyform">

    <div class="w-full max-w-5xl mx-auto animate-fadeIn">
        
        <!-- Header -->
        <div class="text-center mb-12">
            <!-- Logo -->
            <a href="{{ route('homepage') }}" class="inline-block mb-8 group">
                <img src="{{ asset('assets/images/logo-yellow.png') }}" alt="plyform" class="h-14 w-auto transition-transform duration-300 group-hover:scale-105">
            </a>
            
            <h1 class="text-4xl md:text-5xl font-bold text-plyform-dark mb-4">
                Welcome to <span class="gradient-text">plyform</span>
            </h1>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                Choose how you'd like to get started with our property management platform
            </p>
        </div>

        <!-- Registration Cards -->
        <div class="grid md:grid-cols-2 gap-8 mb-12">
            
            <!-- User Registration Card -->
            <a href="{{ route('register.user') }}" class="group">
                <div class="card-plyform p-8 h-full hover:shadow-plyform-lg transition-all duration-300 hover:-translate-y-2 border-2 border-transparent hover:border-plyform-yellow cursor-pointer">
                    <!-- Icon -->
                    <div class="w-20 h-20 bg-gradient-to-br from-plyform-mint to-plyform-yellow/50 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                        <svg class="w-10 h-10 text-plyform-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>

                    <!-- Title -->
                    <h2 class="text-2xl font-bold text-plyform-dark mb-3 group-hover:text-plyform-purple transition-colors">
                        I'm a User
                    </h2>
                    
                    <!-- Description -->
                    <p class="text-gray-600 mb-6 leading-relaxed">
                        Perfect for tenants, landlords, and individual property managers looking to streamline their rental experience.
                    </p>

                    <!-- Features List -->
                    <ul class="space-y-3 mb-6">
                        <li class="flex items-start gap-2">
                            <div class="w-5 h-5 rounded-full bg-plyform-yellow flex items-center justify-center flex-shrink-0 mt-0.5">
                                <svg class="w-3 h-3 text-plyform-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <span class="text-sm text-gray-700">Search and save properties</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <div class="w-5 h-5 rounded-full bg-plyform-yellow flex items-center justify-center flex-shrink-0 mt-0.5">
                                <svg class="w-3 h-3 text-plyform-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <span class="text-sm text-gray-700">Submit rental applications</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <div class="w-5 h-5 rounded-full bg-plyform-yellow flex items-center justify-center flex-shrink-0 mt-0.5">
                                <svg class="w-3 h-3 text-plyform-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <span class="text-sm text-gray-700">Manage enquiries and applications</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <div class="w-5 h-5 rounded-full bg-plyform-yellow flex items-center justify-center flex-shrink-0 mt-0.5">
                                <svg class="w-3 h-3 text-plyform-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <span class="text-sm text-gray-700">Quick & easy setup</span>
                        </li>
                    </ul>

                    <!-- CTA Button -->
                    <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                        <span class="text-sm font-semibold text-plyform-dark">Get Started</span>
                        <div class="w-10 h-10 rounded-full bg-plyform-yellow flex items-center justify-center group-hover:bg-plyform-dark transition-colors">
                            <svg class="w-5 h-5 text-plyform-dark group-hover:text-plyform-yellow group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                        </div>
                    </div>

                    <!-- Badge -->
                    <div class="mt-4 inline-flex items-center px-3 py-1 rounded-full bg-plyform-mint text-xs font-semibold text-plyform-dark">
                        <span class="w-1.5 h-1.5 rounded-full bg-plyform-yellow mr-2"></span>
                        Most Popular
                    </div>
                </div>
            </a>

            <!-- Agency Registration Card -->
            <a href="{{ route('register.agency') }}" class="group">
                <div class="card-plyform p-8 h-full hover:shadow-plyform-lg transition-all duration-300 hover:-translate-y-2 border-2 border-transparent hover:border-plyform-purple cursor-pointer">
                    <!-- Icon -->
                    <div class="w-20 h-20 bg-gradient-to-br from-plyform-purple/20 to-plyform-purple/40 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                        <svg class="w-10 h-10 text-plyform-purple" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>

                    <!-- Title -->
                    <h2 class="text-2xl font-bold text-plyform-dark mb-3 group-hover:text-plyform-purple transition-colors">
                        I'm a Real Estate Agency
                    </h2>
                    
                    <!-- Description -->
                    <p class="text-gray-600 mb-6 leading-relaxed">
                        Ideal for real estate agencies and property management companies with multiple agents and properties.
                    </p>

                    <!-- Features List -->
                    <ul class="space-y-3 mb-6">
                        <li class="flex items-start gap-2">
                            <div class="w-5 h-5 rounded-full bg-plyform-purple flex items-center justify-center flex-shrink-0 mt-0.5">
                                <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <span class="text-sm text-gray-700">Manage unlimited properties</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <div class="w-5 h-5 rounded-full bg-plyform-purple flex items-center justify-center flex-shrink-0 mt-0.5">
                                <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <span class="text-sm text-gray-700">Multi-agent team management</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <div class="w-5 h-5 rounded-full bg-plyform-purple flex items-center justify-center flex-shrink-0 mt-0.5">
                                <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <span class="text-sm text-gray-700">Advanced analytics & reporting</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <div class="w-5 h-5 rounded-full bg-plyform-purple flex items-center justify-center flex-shrink-0 mt-0.5">
                                <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <span class="text-sm text-gray-700">Subscription-based pricing</span>
                        </li>
                    </ul>

                    <!-- CTA Button -->
                    <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                        <span class="text-sm font-semibold text-plyform-dark">Get Started</span>
                        <div class="w-10 h-10 rounded-full bg-plyform-purple flex items-center justify-center group-hover:bg-plyform-dark transition-colors">
                            <svg class="w-5 h-5 text-white group-hover:text-plyform-purple group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                        </div>
                    </div>

                    <!-- Badge -->
                    <div class="mt-4 inline-flex items-center px-3 py-1 rounded-full bg-plyform-purple/10 text-xs font-semibold text-plyform-purple">
                        <span class="w-1.5 h-1.5 rounded-full bg-plyform-purple mr-2"></span>
                        For Businesses
                    </div>
                </div>
            </a>

        </div>

        <!-- Comparison Table (Optional) -->
        <div class="bg-white rounded-2xl shadow-plyform p-8 mb-8">
            <h3 class="text-xl font-bold text-plyform-dark mb-6 text-center">Not sure which option is right for you?</h3>
            
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-200">
                            <th class="text-left py-3 px-4 font-semibold text-plyform-dark">Features</th>
                            <th class="text-center py-3 px-4 font-semibold text-plyform-dark">User Account</th>
                            <th class="text-center py-3 px-4 font-semibold text-plyform-dark">Agency Account</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600">
                        <tr class="border-b border-gray-100">
                            <td class="py-3 px-4">Property Browsing</td>
                            <td class="text-center py-3 px-4">
                                <svg class="w-5 h-5 text-green-500 mx-auto" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </td>
                            <td class="text-center py-3 px-4">
                                <svg class="w-5 h-5 text-green-500 mx-auto" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </td>
                        </tr>
                        <tr class="border-b border-gray-100">
                            <td class="py-3 px-4">Submit Applications</td>
                            <td class="text-center py-3 px-4">
                                <svg class="w-5 h-5 text-green-500 mx-auto" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </td>
                            <td class="text-center py-3 px-4">
                                <svg class="w-5 h-5 text-gray-300 mx-auto" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                </svg>
                            </td>
                        </tr>
                        <tr class="border-b border-gray-100">
                            <td class="py-3 px-4">List Properties</td>
                            <td class="text-center py-3 px-4">
                                <svg class="w-5 h-5 text-gray-300 mx-auto" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                </svg>
                            </td>
                            <td class="text-center py-3 px-4">
                                <svg class="w-5 h-5 text-green-500 mx-auto" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </td>
                        </tr>
                        <tr class="border-b border-gray-100">
                            <td class="py-3 px-4">Team Management</td>
                            <td class="text-center py-3 px-4">
                                <svg class="w-5 h-5 text-gray-300 mx-auto" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                </svg>
                            </td>
                            <td class="text-center py-3 px-4">
                                <svg class="w-5 h-5 text-green-500 mx-auto" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </td>
                        </tr>
                        <tr>
                            <td class="py-3 px-4">Advanced Analytics</td>
                            <td class="text-center py-3 px-4">
                                <svg class="w-5 h-5 text-gray-300 mx-auto" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                </svg>
                            </td>
                            <td class="text-center py-3 px-4">
                                <svg class="w-5 h-5 text-green-500 mx-auto" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Already have account -->
        <div class="text-center">
            <p class="text-gray-600">
                Already have an account? 
                <a href="{{ route('login') }}" class="font-semibold text-plyform-purple hover:text-plyform-dark transition-colors">Log in</a>
            </p>
        </div>

        <!-- Footer Links -->
        <div class="text-center mt-8 text-sm text-gray-500">
            <a href="#" class="hover:text-plyform-purple transition-colors">Privacy Policy</a>
            <span class="mx-2">•</span>
            <a href="#" class="hover:text-plyform-purple transition-colors">Terms of Service</a>
            <span class="mx-2">•</span>
            <a href="#" class="hover:text-plyform-purple transition-colors">Contact Support</a>
        </div>
    </div>

</x-guest-layout>