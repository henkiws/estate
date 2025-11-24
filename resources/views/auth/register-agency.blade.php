<x-guest-layout title="Agency Registration - Sorted Services">

   <!-- Register Container -->
    <div class="w-full max-w-4xl mx-auto animate-fadeIn">
        
        <!-- Form Card -->
        <div class="bg-white rounded-3xl shadow-2xl p-6 sm:p-10">
            
            <!-- Header -->
            <div class="text-center mb-8">
                <!-- Logo -->
                <a href="{{ route('homepage') }}" class="inline-flex items-center space-x-3 mb-6 cursor-pointer">
                    <div class="w-12 h-12 bg-gradient-to-br from-primary to-primary-dark rounded-xl flex items-center justify-center">
                        <span class="text-white font-bold text-2xl">S</span>
                    </div>
                    <span class="text-3xl font-bold text-gray-900">Sorted</span>
                </a>
                
                <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-2">Agency Registration</h1>
                <p class="text-gray-600">Register your real estate agency to get started</p>
            </div>
            
            <!-- Registration Form -->
            <form action="{{ route('register.agency') }}" method="POST" class="space-y-8">
                @csrf
                
                <!-- Section 1: Agency Information -->
                <div class="space-y-6">
                    <div class="border-b border-gray-200 pb-3">
                        <h2 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
                            <span class="flex items-center justify-center w-8 h-8 bg-primary text-white rounded-lg text-sm font-bold">1</span>
                            Agency Information
                        </h2>
                        <p class="text-sm text-gray-600 mt-2">All fields are required unless marked as optional</p>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <!-- Agency Name -->
                        <div class="md:col-span-2">
                            <label for="agency_name" class="block text-sm font-semibold text-gray-700 mb-2">
                                Agency Name <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                id="agency_name" 
                                name="agency_name"
                                required
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-primary focus:ring-4 focus:ring-primary/10 outline-none transition-all"
                                placeholder="e.g., Smith Property Group"
                            >
                        </div>
                        
                        <!-- Business Trading Name -->
                        <div class="md:col-span-2">
                            <label for="trading_name" class="block text-sm font-semibold text-gray-700 mb-2">
                                Business Trading Name <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                id="trading_name" 
                                name="trading_name"
                                required
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-primary focus:ring-4 focus:ring-primary/10 outline-none transition-all"
                                placeholder="e.g., Smith Realty"
                            >
                        </div>
                        
                        <!-- ABN -->
                        <div>
                            <label for="abn" class="block text-sm font-semibold text-gray-700 mb-2">
                                ABN (Australian Business Number) <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                id="abn" 
                                name="abn"
                                required
                                pattern="[0-9\s]{11,14}"
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-primary focus:ring-4 focus:ring-primary/10 outline-none transition-all"
                                placeholder="12 345 678 901"
                            >
                        </div>
                        
                        <!-- Business Type -->
                        <div>
                            <label for="business_type" class="block text-sm font-semibold text-gray-700 mb-2">
                                Business Type <span class="text-red-500">*</span>
                            </label>
                            <select 
                                id="business_type" 
                                name="business_type"
                                required
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-primary focus:ring-4 focus:ring-primary/10 outline-none transition-all bg-white"
                            >
                                <option value="">Select Business Type</option>
                                <option value="sole_trader">Sole Trader</option>
                                <option value="partnership">Partnership</option>
                                <option value="company">Company (Pty Ltd)</option>
                            </select>
                        </div>
                        
                        <!-- ACN -->
                        <div>
                            <label for="acn" class="block text-sm font-semibold text-gray-700 mb-2">
                                ACN <span class="text-gray-400 text-xs">(Optional)</span>
                            </label>
                            <input 
                                type="text" 
                                id="acn" 
                                name="acn"
                                pattern="[0-9\s]{9,11}"
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-primary focus:ring-4 focus:ring-primary/10 outline-none transition-all"
                                placeholder="123 456 789"
                            >
                        </div>
                        
                        <!-- Real Estate License Number -->
                        <div>
                            <label for="license_number" class="block text-sm font-semibold text-gray-700 mb-2">
                                Real Estate License Number <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                id="license_number" 
                                name="license_number"
                                required
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-primary focus:ring-4 focus:ring-primary/10 outline-none transition-all"
                                placeholder="e.g., 20123456"
                            >
                        </div>
                        
                        <!-- License Holder Name -->
                        <div>
                            <label for="license_holder" class="block text-sm font-semibold text-gray-700 mb-2">
                                License Holder / Principal Licensee Name <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                id="license_holder" 
                                name="license_holder"
                                required
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-primary focus:ring-4 focus:ring-primary/10 outline-none transition-all"
                                placeholder="e.g., John Smith"
                            >
                        </div>
                        
                        <!-- Business Address -->
                        <div class="md:col-span-2">
                            <label for="business_address" class="block text-sm font-semibold text-gray-700 mb-2">
                                Business Address <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                id="business_address" 
                                name="business_address"
                                required
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-primary focus:ring-4 focus:ring-primary/10 outline-none transition-all"
                                placeholder="e.g., 123 Main Street, Sydney"
                            >
                        </div>
                        
                        <!-- State/Territory -->
                        <div>
                            <label for="state" class="block text-sm font-semibold text-gray-700 mb-2">
                                State/Territory <span class="text-red-500">*</span>
                            </label>
                            <select 
                                id="state" 
                                name="state"
                                required
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-primary focus:ring-4 focus:ring-primary/10 outline-none transition-all bg-white"
                            >
                                <option value="">Select State/Territory</option>
                                <option value="NSW">New South Wales (NSW)</option>
                                <option value="VIC">Victoria (VIC)</option>
                                <option value="QLD">Queensland (QLD)</option>
                                <option value="WA">Western Australia (WA)</option>
                                <option value="SA">South Australia (SA)</option>
                                <option value="TAS">Tasmania (TAS)</option>
                                <option value="ACT">Australian Capital Territory (ACT)</option>
                                <option value="NT">Northern Territory (NT)</option>
                            </select>
                        </div>
                        
                        <!-- Postcode -->
                        <div>
                            <label for="postcode" class="block text-sm font-semibold text-gray-700 mb-2">
                                Postcode <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                id="postcode" 
                                name="postcode"
                                required
                                pattern="[0-9]{4}"
                                maxlength="4"
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-primary focus:ring-4 focus:ring-primary/10 outline-none transition-all"
                                placeholder="e.g., 2000"
                            >
                        </div>
                        
                        <!-- Business Phone -->
                        <div>
                            <label for="business_phone" class="block text-sm font-semibold text-gray-700 mb-2">
                                Business Phone Number <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="tel" 
                                id="business_phone" 
                                name="business_phone"
                                required
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-primary focus:ring-4 focus:ring-primary/10 outline-none transition-all"
                                placeholder="e.g., (02) 1234 5678"
                            >
                        </div>
                        
                        <!-- Business Email -->
                        <div>
                            <label for="business_email" class="block text-sm font-semibold text-gray-700 mb-2">
                                Business Email <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="email" 
                                id="business_email" 
                                name="business_email"
                                required
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-primary focus:ring-4 focus:ring-primary/10 outline-none transition-all"
                                placeholder="e.g., contact@agency.com.au"
                            >
                        </div>
                        
                        <!-- Website URL -->
                        <div class="md:col-span-2">
                            <label for="website" class="block text-sm font-semibold text-gray-700 mb-2">
                                Website URL <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="url" 
                                id="website" 
                                name="website"
                                required
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-primary focus:ring-4 focus:ring-primary/10 outline-none transition-all"
                                placeholder="e.g., https://www.youragency.com.au"
                            >
                        </div>
                    </div>
                </div>
                
                <!-- Section 2: Login Account -->
                <div class="space-y-6">
                    <div class="border-b border-gray-200 pb-3">
                        <h2 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
                            <span class="flex items-center justify-center w-8 h-8 bg-primary text-white rounded-lg text-sm font-bold">2</span>
                            Login Account
                        </h2>
                        <p class="text-sm text-gray-600 mt-2">Create your account credentials</p>
                    </div>
                    
                    <div class="grid grid-cols-1 gap-5">
                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                                Email Address <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                                    </svg>
                                </div>
                                <input 
                                    type="email" 
                                    id="email" 
                                    name="email"
                                    required
                                    class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:border-primary focus:ring-4 focus:ring-primary/10 outline-none transition-all"
                                    placeholder="your@email.com"
                                >
                            </div>
                        </div>
                        
                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                                Password <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                </div>
                                <input 
                                    type="password" 
                                    id="password" 
                                    name="password"
                                    required
                                    minlength="8"
                                    class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:border-primary focus:ring-4 focus:ring-primary/10 outline-none transition-all"
                                    placeholder="Minimum 8 characters"
                                >
                            </div>
                            <p class="text-xs text-gray-500 mt-2">Must be at least 8 characters long</p>
                        </div>
                        
                        <!-- Confirm Password -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                                Confirm Password <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <input 
                                    type="password" 
                                    id="password_confirmation" 
                                    name="password_confirmation"
                                    required
                                    minlength="8"
                                    class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:border-primary focus:ring-4 focus:ring-primary/10 outline-none transition-all"
                                    placeholder="Re-enter your password"
                                >
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Terms & Conditions -->
                <div class="flex items-start p-4 bg-gray-50 rounded-xl border border-gray-200">
                    <input 
                        type="checkbox" 
                        id="terms" 
                        name="terms"
                        required 
                        class="w-5 h-5 mt-0.5 text-primary border-gray-300 rounded focus:ring-2 focus:ring-primary/20 flex-shrink-0"
                    >
                    <label for="terms" class="ml-3 text-sm text-gray-700">
                        I confirm that all information provided is accurate and agree to the 
                        <a href="#" class="text-primary hover:text-primary-dark font-semibold underline">Terms of Service</a> and 
                        <a href="#" class="text-primary hover:text-primary-dark font-semibold underline">Privacy Policy</a>
                        <span class="text-red-500">*</span>
                    </label>
                </div>
                
                <!-- Submit Button -->
                <div class="flex flex-col sm:flex-row gap-4">
                    <button 
                        type="submit"
                        class="flex-1 py-4 bg-primary hover:bg-primary-dark text-white font-semibold rounded-xl shadow-lg shadow-primary/30 hover:shadow-xl hover:shadow-primary/40 transition-all hover:-translate-y-0.5"
                    >
                        Complete Registration
                    </button>
                </div>
            </form>
            
            <!-- Login Link -->
            <div class="text-center mt-8 pt-6 border-t border-gray-200">
                <p class="text-gray-600">
                    Already have an account? 
                    <a href="{{ route('login') }}" class="font-semibold text-primary hover:text-primary-dark">Log in here</a>
                </p>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="text-center mt-6 text-sm text-gray-500">
            <p>&copy; 2024 Sorted Services. All rights reserved.</p>
        </div>
    </div>

</x-guest-layout>