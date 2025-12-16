<x-guest-layout title="Agency Registration - Sorted Services">

   <!-- Register Container -->
    <div class="w-full max-w-6xl grid lg:grid-cols-2 gap-8 items-start animate-fadeIn">
        
        <!-- Left Side - Branding & Info -->
        <div class="hidden lg:block space-y-8 p-12 sticky top-8">
            <!-- Logo -->
            <a href="{{ route('homepage') }}" class="flex items-center space-x-3 mb-12 cursor-pointer">
                <div class="w-12 h-12 bg-gradient-to-br from-primary to-primary-dark rounded-xl flex items-center justify-center">
                    <span class="text-white font-bold text-2xl">S</span>
                </div>
                <span class="text-3xl font-bold text-gray-900">Sorted</span>
            </a>
            
            <div class="space-y-6">
                <h1 class="text-4xl lg:text-5xl font-bold leading-tight">
                    Register Your<br>
                    <span class="gradient-text">Real Estate Agency</span>
                </h1>
                
                <p class="text-xl text-gray-600 leading-relaxed">
                    Join the leading property management platform trusted by agencies across Australia.
                </p>
            </div>
            
            <!-- Benefits -->
            <div class="space-y-6 pt-8">
                <div class="flex gap-4">
                    <div class="w-12 h-12 bg-primary-light rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 mb-1">Multi-Agent Management</h3>
                        <p class="text-gray-600 text-sm">Manage your entire team and property portfolio in one place</p>
                    </div>
                </div>
                
                <div class="flex gap-4">
                    <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 mb-1">Compliance Ready</h3>
                        <p class="text-gray-600 text-sm">Built-in compliance features for Australian real estate regulations</p>
                    </div>
                </div>
                
                <div class="flex gap-4">
                    <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 mb-1">Instant Activation</h3>
                        <p class="text-gray-600 text-sm">Get started immediately with our streamlined onboarding</p>
                    </div>
                </div>
            </div>
            
            <!-- Stats -->
            <div class="grid grid-cols-3 gap-6 pt-8 border-t border-gray-200">
                <div>
                    <div class="text-3xl font-bold text-gray-900">500+</div>
                    <div class="text-sm text-gray-600">Agencies</div>
                </div>
                <div>
                    <div class="text-3xl font-bold text-gray-900">2K+</div>
                    <div class="text-sm text-gray-600">Agents</div>
                </div>
                <div>
                    <div class="text-3xl font-bold text-gray-900">50K+</div>
                    <div class="text-sm text-gray-600">Properties</div>
                </div>
            </div>
        </div>
        
        <!-- Right Side - Registration Form -->
        <div class="w-full">
            <!-- Mobile Logo -->
            <div class="lg:hidden flex items-center justify-center space-x-2 mb-8">
                <div class="w-10 h-10 bg-gradient-to-br from-primary to-primary-dark rounded-lg flex items-center justify-center">
                    <span class="text-white font-bold text-xl">S</span>
                </div>
                <span class="text-2xl font-bold text-gray-900">Sorted</span>
            </div>

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
            <div class="bg-white rounded-3xl shadow-2xl p-8 sm:p-10">
                
                <!-- Header -->
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-gray-900 mb-2">Agency Registration</h2>
                    <p class="text-gray-600">Complete the form below to get started</p>
                </div>
                
                <!-- Registration Form -->
                <form action="{{ route('register.agency.store') }}" method="POST" class="space-y-6" id="registrationForm">
                    @csrf
                    
                    <!-- Section 1: Business Identity -->
                    <div class="space-y-5">
                        <div class="flex items-center gap-2 pb-3 border-b border-gray-200">
                            <span class="flex items-center justify-center w-7 h-7 bg-primary text-white rounded-lg text-sm font-bold">1</span>
                            <h3 class="text-lg font-bold text-gray-900">Business Identity</h3>
                        </div>
                        
                        <!-- Agency Name -->
                        <div>
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
                        
                        <!-- Trading Name -->
                        <div>
                            <label for="trading_name" class="block text-sm font-semibold text-gray-700 mb-2">
                                Trading Name <span class="text-red-500">*</span>
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
                        
                        <div class="grid grid-cols-2 gap-4">
                            <!-- ABN -->
                            <div>
                                <label for="abn" class="block text-sm font-semibold text-gray-700 mb-2">
                                    ABN <span class="text-red-500">*</span>
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
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
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
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
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
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <!-- Section 2: Licensing -->
                    <div class="space-y-5">
                        <div class="flex items-center gap-2 pb-3 border-b border-gray-200">
                            <span class="flex items-center justify-center w-7 h-7 bg-primary text-white rounded-lg text-sm font-bold">2</span>
                            <h3 class="text-lg font-bold text-gray-900">Licensing Information</h3>
                        </div>
                        
                        <!-- License Number -->
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
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- License Holder -->
                        <div>
                            <label for="license_holder" class="block text-sm font-semibold text-gray-700 mb-2">
                                Principal Licensee Name <span class="text-red-500">*</span>
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
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <!-- Section 3: Contact Details -->
                    <div class="space-y-5">
                        <div class="flex items-center gap-2 pb-3 border-b border-gray-200">
                            <span class="flex items-center justify-center w-7 h-7 bg-primary text-white rounded-lg text-sm font-bold">3</span>
                            <h3 class="text-lg font-bold text-gray-900">Contact Details</h3>
                        </div>
                        
                        <!-- Business Address -->
                        <div>
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
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <!-- State -->
                            <div>
                                <label for="state" class="block text-sm font-semibold text-gray-700 mb-2">
                                    State <span class="text-red-500">*</span>
                                </label>
                                <select 
                                    id="state" 
                                    name="state"
                                    required
                                    class="w-full px-4 py-3 border-2 {{ $errors->has('state') ? 'border-red-500' : 'border-gray-200' }} rounded-xl focus:border-primary focus:ring-4 focus:ring-primary/10 outline-none transition-all bg-white"
                                >
                                    <option value="">Select State</option>
                                    <option value="NSW" {{ old('state') == 'NSW' ? 'selected' : '' }}>NSW</option>
                                    <option value="VIC" {{ old('state') == 'VIC' ? 'selected' : '' }}>VIC</option>
                                    <option value="QLD" {{ old('state') == 'QLD' ? 'selected' : '' }}>QLD</option>
                                    <option value="WA" {{ old('state') == 'WA' ? 'selected' : '' }}>WA</option>
                                    <option value="SA" {{ old('state') == 'SA' ? 'selected' : '' }}>SA</option>
                                    <option value="TAS" {{ old('state') == 'TAS' ? 'selected' : '' }}>TAS</option>
                                    <option value="ACT" {{ old('state') == 'ACT' ? 'selected' : '' }}>ACT</option>
                                    <option value="NT" {{ old('state') == 'NT' ? 'selected' : '' }}>NT</option>
                                </select>
                                @error('state')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
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
                                    placeholder="2000"
                                >
                                @error('postcode')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <!-- Business Phone -->
                            <div>
                                <label for="business_phone" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Phone <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="tel" 
                                    id="business_phone" 
                                    name="business_phone"
                                    value="{{ old('business_phone') }}"
                                    required
                                    class="w-full px-4 py-3 border-2 {{ $errors->has('business_phone') ? 'border-red-500' : 'border-gray-200' }} rounded-xl focus:border-primary focus:ring-4 focus:ring-primary/10 outline-none transition-all"
                                    placeholder="(02) 1234 5678"
                                >
                                @error('business_phone')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Business Email -->
                            <div>
                                <label for="business_email" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Email <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="email" 
                                    id="business_email" 
                                    name="business_email"
                                    value="{{ old('business_email') }}"
                                    required
                                    class="w-full px-4 py-3 border-2 {{ $errors->has('business_email') ? 'border-red-500' : 'border-gray-200' }} rounded-xl focus:border-primary focus:ring-4 focus:ring-primary/10 outline-none transition-all"
                                    placeholder="contact@agency.com.au"
                                >
                                @error('business_email')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        
                        <!-- Website -->
                        <div>
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
                                placeholder="https://www.youragency.com.au"
                            >
                            @error('website')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <!-- Section 4: Account Credentials -->
                    <div class="space-y-5">
                        <div class="flex items-center gap-2 pb-3 border-b border-gray-200">
                            <span class="flex items-center justify-center w-7 h-7 bg-primary text-white rounded-lg text-sm font-bold">4</span>
                            <h3 class="text-lg font-bold text-gray-900">Account Credentials</h3>
                        </div>
                        
                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                                Your Email Address <span class="text-red-500">*</span>
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
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
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
                                    class="w-full pl-12 pr-12 py-3 border-2 {{ $errors->has('password') ? 'border-red-500' : 'border-gray-200' }} rounded-xl focus:border-primary focus:ring-4 focus:ring-primary/10 outline-none transition-all"
                                    placeholder="Minimum 8 characters"
                                >
                                <button 
                                    type="button"
                                    id="togglePassword"
                                    class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-gray-600"
                                >
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </button>
                            </div>
                            @error('password')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
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
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
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
                            class="w-4 h-4 mt-1 text-primary border-gray-300 rounded focus:ring-2 focus:ring-primary/20"
                        >
                        <label for="terms" class="ml-2 text-sm text-gray-700">
                            I confirm all information is accurate and agree to the 
                            <a href="#" class="text-primary hover:text-primary-dark font-semibold">Terms of Service</a> and 
                            <a href="#" class="text-primary hover:text-primary-dark font-semibold">Privacy Policy</a>
                        </label>
                    </div>
                    @error('terms')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    
                    <!-- Submit Button -->
                    <button 
                        type="submit"
                        id="submitBtn"
                        class="w-full py-4 bg-primary hover:bg-primary-dark text-white font-semibold rounded-xl shadow-lg shadow-primary/30 hover:shadow-xl hover:shadow-primary/40 transition-all hover:-translate-y-0.5 disabled:opacity-50 disabled:cursor-not-allowed"
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
                </form>
                
                <!-- Login Link -->
                <p class="text-center text-gray-600 mt-8 pt-6 border-t border-gray-200">
                    Already have an account? 
                    <a href="{{ route('login') }}" class="font-semibold text-primary hover:text-primary-dark">Log in</a>
                </p>
            </div>
            
            <!-- Footer Links -->
            <div class="text-center mt-8 text-sm text-gray-500">
                <a href="#" class="hover:text-gray-700">Privacy Policy</a>
                <span class="mx-2">•</span>
                <a href="#" class="hover:text-gray-700">Terms of Service</a>
            </div>
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
        // Password Toggle
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        
        if (togglePassword && passwordInput) {
            togglePassword.addEventListener('click', () => {
                const type = passwordInput.type === 'password' ? 'text' : 'password';
                passwordInput.type = type;
            });
        }

        // Form submission handler
        const registrationForm = document.getElementById('registrationForm');
        if (registrationForm) {
            registrationForm.addEventListener('submit', function(e) {
                const submitBtn = document.getElementById('submitBtn');
                const btnText = document.getElementById('btnText');
                const btnLoading = document.getElementById('btnLoading');
                
                // Show loading state
                submitBtn.disabled = true;
                btnText.classList.add('hidden');
                btnLoading.classList.remove('hidden');
            });
        }

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