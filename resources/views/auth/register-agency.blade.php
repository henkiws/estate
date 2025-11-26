<x-guest-layout title="Agency Registration - Sorted Services">

   <!-- Register Container -->
    <div class="w-full max-w-4xl mx-auto animate-fadeIn">
        
        <!-- Success Message -->
        @if(session('success'))
        <div class="mb-6 bg-green-50 border-l-4 border-green-500 rounded-xl p-4 shadow-lg animate-slideDown">
            <div class="flex items-start">
                <svg class="w-6 h-6 text-green-500 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                <div>
                    <h3 class="text-green-800 font-semibold mb-1">Success!</h3>
                    <p class="text-green-700">{{ session('success') }}</p>
                </div>
            </div>
        </div>
        @endif

        <!-- Error Message -->
        @if(session('error'))
        <div class="mb-6 bg-red-50 border-l-4 border-red-500 rounded-xl p-4 shadow-lg animate-slideDown">
            <div class="flex items-start">
                <svg class="w-6 h-6 text-red-500 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                </svg>
                <div>
                    <h3 class="text-red-800 font-semibold mb-1">Registration Failed</h3>
                    <p class="text-red-700">{{ session('error') }}</p>
                </div>
            </div>
        </div>
        @endif

        <!-- Validation Errors Summary -->
        @if($errors->any())
        <div class="mb-6 bg-red-50 border-l-4 border-red-500 rounded-xl p-4 shadow-lg animate-slideDown">
            <div class="flex items-start">
                <svg class="w-6 h-6 text-red-500 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
                <div class="flex-1">
                    <h3 class="text-red-800 font-semibold mb-2">Please fix the following errors:</h3>
                    <ul class="list-disc list-inside space-y-1 text-red-700 text-sm">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        @endif
        
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
            <form action="{{ route('register.agency.store') }}" method="POST" class="space-y-8" id="registrationForm">
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
                                value="{{ old('agency_name') }}"
                                required
                                class="w-full px-4 py-3 border-2 {{ $errors->has('agency_name') ? 'border-red-500' : 'border-gray-200' }} rounded-xl focus:border-primary focus:ring-4 focus:ring-primary/10 outline-none transition-all"
                                placeholder="e.g., Smith Property Group"
                            >
                            @error('agency_name')
                            <p class="text-red-600 text-sm mt-1 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $message }}
                            </p>
                            @enderror
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
                                value="{{ old('trading_name') }}"
                                required
                                class="w-full px-4 py-3 border-2 {{ $errors->has('trading_name') ? 'border-red-500' : 'border-gray-200' }} rounded-xl focus:border-primary focus:ring-4 focus:ring-primary/10 outline-none transition-all"
                                placeholder="e.g., Smith Realty"
                            >
                            @error('trading_name')
                            <p class="text-red-600 text-sm mt-1 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $message }}
                            </p>
                            @enderror
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
                                value="{{ old('abn') }}"
                                required
                                maxlength="14"
                                class="w-full px-4 py-3 border-2 {{ $errors->has('abn') ? 'border-red-500' : 'border-gray-200' }} rounded-xl focus:border-primary focus:ring-4 focus:ring-primary/10 outline-none transition-all"
                                placeholder="12 345 678 901"
                            >
                            @error('abn')
                            <p class="text-red-600 text-sm mt-1 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $message }}
                            </p>
                            @enderror
                            <p class="text-xs text-gray-500 mt-1">11 digits, spaces will be removed automatically</p>
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
                                class="w-full px-4 py-3 border-2 {{ $errors->has('business_type') ? 'border-red-500' : 'border-gray-200' }} rounded-xl focus:border-primary focus:ring-4 focus:ring-primary/10 outline-none transition-all bg-white"
                            >
                                <option value="">Select Business Type</option>
                                <option value="sole_trader" {{ old('business_type') == 'sole_trader' ? 'selected' : '' }}>Sole Trader</option>
                                <option value="partnership" {{ old('business_type') == 'partnership' ? 'selected' : '' }}>Partnership</option>
                                <option value="company" {{ old('business_type') == 'company' ? 'selected' : '' }}>Company (Pty Ltd)</option>
                            </select>
                            @error('business_type')
                            <p class="text-red-600 text-sm mt-1 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $message }}
                            </p>
                            @enderror
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
                                value="{{ old('acn') }}"
                                maxlength="11"
                                class="w-full px-4 py-3 border-2 {{ $errors->has('acn') ? 'border-red-500' : 'border-gray-200' }} rounded-xl focus:border-primary focus:ring-4 focus:ring-primary/10 outline-none transition-all"
                                placeholder="123 456 789"
                            >
                            @error('acn')
                            <p class="text-red-600 text-sm mt-1 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $message }}
                            </p>
                            @enderror
                            <p class="text-xs text-gray-500 mt-1">9 digits, required for companies</p>
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
                                value="{{ old('license_number') }}"
                                required
                                class="w-full px-4 py-3 border-2 {{ $errors->has('license_number') ? 'border-red-500' : 'border-gray-200' }} rounded-xl focus:border-primary focus:ring-4 focus:ring-primary/10 outline-none transition-all"
                                placeholder="e.g., 20123456"
                            >
                            @error('license_number')
                            <p class="text-red-600 text-sm mt-1 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $message }}
                            </p>
                            @enderror
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
                                value="{{ old('license_holder') }}"
                                required
                                class="w-full px-4 py-3 border-2 {{ $errors->has('license_holder') ? 'border-red-500' : 'border-gray-200' }} rounded-xl focus:border-primary focus:ring-4 focus:ring-primary/10 outline-none transition-all"
                                placeholder="e.g., John Smith"
                            >
                            @error('license_holder')
                            <p class="text-red-600 text-sm mt-1 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $message }}
                            </p>
                            @enderror
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
                                value="{{ old('business_address') }}"
                                required
                                class="w-full px-4 py-3 border-2 {{ $errors->has('business_address') ? 'border-red-500' : 'border-gray-200' }} rounded-xl focus:border-primary focus:ring-4 focus:ring-primary/10 outline-none transition-all"
                                placeholder="e.g., 123 Main Street, Sydney"
                            >
                            @error('business_address')
                            <p class="text-red-600 text-sm mt-1 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $message }}
                            </p>
                            @enderror
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
                                class="w-full px-4 py-3 border-2 {{ $errors->has('state') ? 'border-red-500' : 'border-gray-200' }} rounded-xl focus:border-primary focus:ring-4 focus:ring-primary/10 outline-none transition-all bg-white"
                            >
                                <option value="">Select State/Territory</option>
                                <option value="NSW" {{ old('state') == 'NSW' ? 'selected' : '' }}>New South Wales (NSW)</option>
                                <option value="VIC" {{ old('state') == 'VIC' ? 'selected' : '' }}>Victoria (VIC)</option>
                                <option value="QLD" {{ old('state') == 'QLD' ? 'selected' : '' }}>Queensland (QLD)</option>
                                <option value="WA" {{ old('state') == 'WA' ? 'selected' : '' }}>Western Australia (WA)</option>
                                <option value="SA" {{ old('state') == 'SA' ? 'selected' : '' }}>South Australia (SA)</option>
                                <option value="TAS" {{ old('state') == 'TAS' ? 'selected' : '' }}>Tasmania (TAS)</option>
                                <option value="ACT" {{ old('state') == 'ACT' ? 'selected' : '' }}>Australian Capital Territory (ACT)</option>
                                <option value="NT" {{ old('state') == 'NT' ? 'selected' : '' }}>Northern Territory (NT)</option>
                            </select>
                            @error('state')
                            <p class="text-red-600 text-sm mt-1 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $message }}
                            </p>
                            @enderror
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
                                value="{{ old('postcode') }}"
                                required
                                maxlength="4"
                                class="w-full px-4 py-3 border-2 {{ $errors->has('postcode') ? 'border-red-500' : 'border-gray-200' }} rounded-xl focus:border-primary focus:ring-4 focus:ring-primary/10 outline-none transition-all"
                                placeholder="e.g., 2000"
                            >
                            @error('postcode')
                            <p class="text-red-600 text-sm mt-1 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $message }}
                            </p>
                            @enderror
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
                                value="{{ old('business_phone') }}"
                                required
                                class="w-full px-4 py-3 border-2 {{ $errors->has('business_phone') ? 'border-red-500' : 'border-gray-200' }} rounded-xl focus:border-primary focus:ring-4 focus:ring-primary/10 outline-none transition-all"
                                placeholder="e.g., (02) 1234 5678"
                            >
                            @error('business_phone')
                            <p class="text-red-600 text-sm mt-1 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $message }}
                            </p>
                            @enderror
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
                                value="{{ old('business_email') }}"
                                required
                                class="w-full px-4 py-3 border-2 {{ $errors->has('business_email') ? 'border-red-500' : 'border-gray-200' }} rounded-xl focus:border-primary focus:ring-4 focus:ring-primary/10 outline-none transition-all"
                                placeholder="e.g., contact@agency.com.au"
                            >
                            @error('business_email')
                            <p class="text-red-600 text-sm mt-1 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $message }}
                            </p>
                            @enderror
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
                                value="{{ old('website') }}"
                                required
                                class="w-full px-4 py-3 border-2 {{ $errors->has('website') ? 'border-red-500' : 'border-gray-200' }} rounded-xl focus:border-primary focus:ring-4 focus:ring-primary/10 outline-none transition-all"
                                placeholder="e.g., https://www.youragency.com.au"
                            >
                            @error('website')
                            <p class="text-red-600 text-sm mt-1 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $message }}
                            </p>
                            @enderror
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
                                    value="{{ old('email') }}"
                                    required
                                    class="w-full pl-12 pr-4 py-3 border-2 {{ $errors->has('email') ? 'border-red-500' : 'border-gray-200' }} rounded-xl focus:border-primary focus:ring-4 focus:ring-primary/10 outline-none transition-all"
                                    placeholder="your@email.com"
                                >
                            </div>
                            @error('email')
                            <p class="text-red-600 text-sm mt-1 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $message }}
                            </p>
                            @enderror
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
                                    class="w-full pl-12 pr-4 py-3 border-2 {{ $errors->has('password') ? 'border-red-500' : 'border-gray-200' }} rounded-xl focus:border-primary focus:ring-4 focus:ring-primary/10 outline-none transition-all"
                                    placeholder="Minimum 8 characters"
                                >
                            </div>
                            @error('password')
                            <p class="text-red-600 text-sm mt-1 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $message }}
                            </p>
                            @else
                            <p class="text-xs text-gray-500 mt-2">Must be at least 8 characters long</p>
                            @enderror
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
                                    class="w-full pl-12 pr-4 py-3 border-2 {{ $errors->has('password_confirmation') ? 'border-red-500' : 'border-gray-200' }} rounded-xl focus:border-primary focus:ring-4 focus:ring-primary/10 outline-none transition-all"
                                    placeholder="Re-enter your password"
                                >
                            </div>
                            @error('password_confirmation')
                            <p class="text-red-600 text-sm mt-1 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $message }}
                            </p>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <!-- Terms & Conditions -->
                <div class="flex items-start p-4 bg-gray-50 rounded-xl border border-gray-200 {{ $errors->has('terms') ? 'border-red-500 bg-red-50' : '' }}">
                    <input 
                        type="checkbox" 
                        id="terms" 
                        name="terms"
                        {{ old('terms') ? 'checked' : '' }}
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
                @error('terms')
                <p class="text-red-600 text-sm mt-1 flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                    {{ $message }}
                </p>
                @enderror
                
                <!-- Submit Button -->
                <div class="flex flex-col sm:flex-row gap-4">
                    <button 
                        type="submit"
                        id="submitBtn"
                        class="flex-1 py-4 bg-primary hover:bg-primary-dark text-white font-semibold rounded-xl shadow-lg shadow-primary/30 hover:shadow-xl hover:shadow-primary/40 transition-all hover:-translate-y-0.5 disabled:opacity-50 disabled:cursor-not-allowed"
                    >
                        <span id="btnText">Complete Registration</span>
                        <span id="btnLoading" class="hidden">
                            <svg class="animate-spin h-5 w-5 inline mr-2" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Processing...
                        </span>
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

    <style>
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .animate-slideDown {
            animation: slideDown 0.3s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .animate-fadeIn {
            animation: fadeIn 0.5s ease-out;
        }
    </style>

    <script>
        // Form submission handler
        document.getElementById('registrationForm').addEventListener('submit', function(e) {
            const submitBtn = document.getElementById('submitBtn');
            const btnText = document.getElementById('btnText');
            const btnLoading = document.getElementById('btnLoading');
            
            // Show loading state
            submitBtn.disabled = true;
            btnText.classList.add('hidden');
            btnLoading.classList.remove('hidden');
        });

        // Auto-hide success/error messages after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.animate-slideDown');
            alerts.forEach(alert => {
                alert.style.transition = 'opacity 0.5s';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            });
        }, 5000);
    </script>

</x-guest-layout>