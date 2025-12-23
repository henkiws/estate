<x-guest-layout title="Sign Up - plyform">

   <!-- Register Container -->
    <div class="w-full max-w-6xl grid lg:grid-cols-2 gap-8 items-start animate-fadeIn">
        
        <!-- Left Side - Branding & Info -->
        <div class="hidden lg:block space-y-8 p-12 sticky top-8">
            <!-- Logo -->
            <a href="{{ route('homepage') }}" class="flex items-center space-x-3 mb-12 cursor-pointer group">
                <img src="{{ asset('assets/images/logo-yellow.png') }}" alt="plyform" class="h-12 w-auto transition-transform duration-300 group-hover:scale-105">
            </a>
            
            <div class="space-y-6">
                <h1 class="text-4xl lg:text-5xl font-bold leading-tight text-plyform-dark">
                    Start your journey with<br>
                    <span class="gradient-text">plyform</span>
                </h1>
                
                <p class="text-xl text-gray-600 leading-relaxed">
                    Join thousands of property managers, landlords, and tenants who trust plyform for their property management needs.
                </p>
            </div>
            
            <!-- Benefits -->
            <div class="space-y-6 pt-8">
                <div class="flex gap-4">
                    <div class="w-12 h-12 bg-plyform-yellow rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-plyform-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-plyform-dark mb-1">Quick Setup</h3>
                        <p class="text-gray-600 text-sm">Get started in minutes with our intuitive onboarding process</p>
                    </div>
                </div>
                
                <div class="flex gap-4">
                    <div class="w-12 h-12 bg-plyform-purple/20 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-plyform-purple" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-plyform-dark mb-1">Secure & Private</h3>
                        <p class="text-gray-600 text-sm">Your data is protected with bank-grade encryption</p>
                    </div>
                </div>
                
                <div class="flex gap-4">
                    <div class="w-12 h-12 bg-plyform-mint rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-plyform-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-plyform-dark mb-1">24/7 Support</h3>
                        <p class="text-gray-600 text-sm">Our team is always here to help you succeed</p>
                    </div>
                </div>
            </div>
            
            <!-- Stats -->
            <div class="grid grid-cols-3 gap-6 pt-8 border-t border-gray-200">
                <div>
                    <div class="text-3xl font-bold text-plyform-dark">10K+</div>
                    <div class="text-sm text-gray-600">Users</div>
                </div>
                <div>
                    <div class="text-3xl font-bold text-plyform-dark">50K+</div>
                    <div class="text-sm text-gray-600">Properties</div>
                </div>
                <div>
                    <div class="text-3xl font-bold text-plyform-dark">99%</div>
                    <div class="text-sm text-gray-600">Satisfaction</div>
                </div>
            </div>
        </div>
        
        <!-- Right Side - Register Form -->
        <div class="w-full">
            <div class="bg-white rounded-3xl shadow-2xl p-8 sm:p-10">
                <!-- Mobile Logo -->
                <div class="lg:hidden flex items-center justify-center mb-8">
                    <img src="{{ asset('assets/images/logo-yellow.png') }}" alt="plyform" class="h-10 w-auto">
                </div>
                
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-plyform-dark mb-2">Create an account</h2>
                    <p class="text-gray-600">Start managing your properties today</p>
                </div>
                
                <!-- Error Display -->
                @if($errors->any())
                <div class="mb-6 bg-red-50 border-l-4 border-plyform-orange rounded-xl p-4 shadow-lg animate-slideDown">
                    <div class="flex items-start">
                        <svg class="w-6 h-6 text-plyform-orange mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                        <div class="flex-1">
                            <h3 class="text-plyform-orange font-semibold mb-2">Please fix the following errors:</h3>
                            <ul class="list-disc list-inside space-y-1 text-red-700 text-sm">
                                @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                @endif
                
                <!-- Register Form -->
                <form method="POST" action="{{ route('register.user.store') }}" id="registerForm" class="space-y-6">
                    @csrf
                    
                    <!-- Section 1: Personal Details -->
                    <div class="space-y-5">
                        <div class="flex items-center gap-2 pb-3 border-b border-gray-200">
                            <h3 class="text-lg font-bold text-plyform-dark">Personal Details</h3>
                            <span class="text-xs text-gray-500 ml-auto">* Required</span>
                        </div>
                        <p class="text-sm text-gray-600 -mt-2">Your legal name as it appears on official documents</p>

                        <!-- Title & First Name Row -->
                        <div class="grid grid-cols-3 gap-4">
                            <!-- Title -->
                            <div>
                                <label for="title" class="block text-sm font-semibold text-plyform-dark mb-2">
                                    Title <span class="text-plyform-orange">*</span>
                                </label>
                                <select 
                                    id="title" 
                                    name="title"
                                    required
                                    class="w-full px-4 py-3 border-2 {{ $errors->has('title') ? 'border-plyform-orange' : 'border-gray-200' }} rounded-xl focus:border-plyform-yellow focus:ring-4 focus:ring-plyform-yellow/10 outline-none transition-all bg-white"
                                >
                                    <option value="">Select title</option>
                                    <option value="Mr" {{ old('title') == 'Mr' ? 'selected' : '' }}>Mr</option>
                                    <option value="Ms" {{ old('title') == 'Ms' ? 'selected' : '' }}>Ms</option>
                                    <option value="Mrs" {{ old('title') == 'Mrs' ? 'selected' : '' }}>Mrs</option>
                                    <option value="Miss" {{ old('title') == 'Miss' ? 'selected' : '' }}>Miss</option>
                                    <option value="Dr" {{ old('title') == 'Dr' ? 'selected' : '' }}>Dr</option>
                                    <option value="Prof" {{ old('title') == 'Prof' ? 'selected' : '' }}>Prof</option>
                                    <option value="Other" {{ old('title') == 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('title')
                                    <p class="mt-1 text-sm text-plyform-orange">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- First Name -->
                            <div class="col-span-2">
                                <label for="first_name" class="block text-sm font-semibold text-plyform-dark mb-2">
                                    First Name <span class="text-plyform-orange">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    id="first_name" 
                                    name="first_name"
                                    value="{{ old('first_name') }}"
                                    required
                                    class="w-full px-4 py-3 border-2 {{ $errors->has('first_name') ? 'border-plyform-orange' : 'border-gray-200' }} rounded-xl focus:border-plyform-yellow focus:ring-4 focus:ring-plyform-yellow/10 outline-none transition-all"
                                    placeholder="Enter your first name"
                                >
                                @error('first_name')
                                    <p class="mt-1 text-sm text-plyform-orange">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Middle Name & Last Name Row -->
                        <div class="grid grid-cols-2 gap-4">
                            <!-- Middle Name -->
                            <div>
                                <label for="middle_name" class="block text-sm font-semibold text-plyform-dark mb-2">
                                    Middle Name
                                </label>
                                <input 
                                    type="text" 
                                    id="middle_name" 
                                    name="middle_name"
                                    value="{{ old('middle_name') }}"
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-plyform-yellow focus:ring-4 focus:ring-plyform-yellow/10 outline-none transition-all"
                                    placeholder="Enter your middle name (optional)"
                                >
                            </div>

                            <!-- Last Name -->
                            <div>
                                <label for="last_name" class="block text-sm font-semibold text-plyform-dark mb-2">
                                    Last Name <span class="text-plyform-orange">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    id="last_name" 
                                    name="last_name"
                                    value="{{ old('last_name') }}"
                                    required
                                    class="w-full px-4 py-3 border-2 {{ $errors->has('last_name') ? 'border-plyform-orange' : 'border-gray-200' }} rounded-xl focus:border-plyform-yellow focus:ring-4 focus:ring-plyform-yellow/10 outline-none transition-all"
                                    placeholder="Enter your last name"
                                >
                                @error('last_name')
                                    <p class="mt-1 text-sm text-plyform-orange">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Surname & Date of Birth Row -->
                        <div class="grid grid-cols-2 gap-4">
                            <!-- Surname -->
                            <div>
                                <label for="surname" class="block text-sm font-semibold text-plyform-dark mb-2">
                                    Surname
                                </label>
                                <input 
                                    type="text" 
                                    id="surname" 
                                    name="surname"
                                    value="{{ old('surname') }}"
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-plyform-yellow focus:ring-4 focus:ring-plyform-yellow/10 outline-none transition-all"
                                    placeholder="Enter surname (if applicable)"
                                >
                            </div>

                            <!-- Date of Birth -->
                            <div>
                                <label for="date_of_birth" class="block text-sm font-semibold text-plyform-dark mb-2">
                                    Date of Birth <span class="text-plyform-orange">*</span>
                                </label>
                                <input 
                                    type="date" 
                                    id="date_of_birth" 
                                    name="date_of_birth"
                                    value="{{ old('date_of_birth') }}"
                                    required
                                    max="{{ date('Y-m-d', strtotime('-18 years')) }}"
                                    class="w-full px-4 py-3 border-2 {{ $errors->has('date_of_birth') ? 'border-plyform-orange' : 'border-gray-200' }} rounded-xl focus:border-plyform-yellow focus:ring-4 focus:ring-plyform-yellow/10 outline-none transition-all"
                                >
                                @error('date_of_birth')
                                    <p class="mt-1 text-sm text-plyform-orange">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Section 2: Contact Information -->
                    <div class="space-y-5">
                        <div class="flex items-center gap-2 pb-3 border-b border-gray-200">
                            <h3 class="text-lg font-bold text-plyform-dark">Contact Information</h3>
                            <span class="text-xs text-gray-500 ml-auto">* Required</span>
                        </div>
                        <p class="text-sm text-gray-600 -mt-2">How property managers can reach you</p>

                        <!-- Email Address -->
                        <div>
                            <label for="email" class="block text-sm font-semibold text-plyform-dark mb-2">
                                Email Address <span class="text-plyform-orange">*</span>
                            </label>
                            <input 
                                type="email" 
                                id="email" 
                                name="email"
                                value="{{ old('email') }}"
                                required
                                class="w-full px-4 py-3 border-2 {{ $errors->has('email') ? 'border-plyform-orange' : 'border-gray-200' }} rounded-xl focus:border-plyform-yellow focus:ring-4 focus:ring-plyform-yellow/10 outline-none transition-all"
                                placeholder="charlie.davis@email.com"
                            >
                            <p class="mt-1 text-xs text-gray-500">Email cannot be changed here. Contact support if you need to update it.</p>
                            @error('email')
                                <p class="mt-1 text-sm text-plyform-orange">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Mobile Number -->
                        <div>
                            <label for="mobile_number" class="block text-sm font-semibold text-plyform-dark mb-2">
                                Mobile Number <span class="text-plyform-orange">*</span>
                            </label>
                            <div class="grid grid-cols-3 gap-3">
                                <!-- Country Code -->
                                <div>
                                    <select 
                                        id="mobile_country_code" 
                                        name="mobile_country_code"
                                        required
                                        class="w-full px-3 py-3 border-2 border-gray-200 rounded-xl focus:border-plyform-yellow focus:ring-4 focus:ring-plyform-yellow/10 outline-none transition-all bg-white text-sm"
                                    >
                                        <option value="+61" {{ old('mobile_country_code', '+61') == '+61' ? 'selected' : '' }}>AU +61</option>
                                        <option value="+1" {{ old('mobile_country_code') == '+1' ? 'selected' : '' }}>US +1</option>
                                        <option value="+44" {{ old('mobile_country_code') == '+44' ? 'selected' : '' }}>UK +44</option>
                                        <option value="+64" {{ old('mobile_country_code') == '+64' ? 'selected' : '' }}>NZ +64</option>
                                    </select>
                                </div>
                                <!-- Mobile Number -->
                                <div class="col-span-2">
                                    <input 
                                        type="tel" 
                                        id="mobile_number" 
                                        name="mobile_number"
                                        value="{{ old('mobile_number') }}"
                                        required
                                        pattern="[0-9]{8,10}"
                                        class="w-full px-4 py-3 border-2 {{ $errors->has('mobile_number') ? 'border-plyform-orange' : 'border-gray-200' }} rounded-xl focus:border-plyform-yellow focus:ring-4 focus:ring-plyform-yellow/10 outline-none transition-all"
                                        placeholder="412345678"
                                    >
                                </div>
                            </div>
                            <p class="mt-1 text-xs text-gray-500">Enter your mobile number without spaces or leading zero (e.g., 412345678)</p>
                            @error('mobile_number')
                                <p class="mt-1 text-sm text-plyform-orange">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Section 3: Account Security -->
                    <div class="space-y-5">
                        <div class="flex items-center gap-2 pb-3 border-b border-gray-200">
                            <h3 class="text-lg font-bold text-plyform-dark">Account Security</h3>
                            <span class="text-xs text-gray-500 ml-auto">* Required</span>
                        </div>

                        <!-- Password Field -->
                        <div>
                            <label for="password" class="block text-sm font-semibold text-plyform-dark mb-2">
                                Password <span class="text-plyform-orange">*</span>
                            </label>
                            <div class="relative">
                                <input 
                                    type="password" 
                                    id="password" 
                                    name="password"
                                    required
                                    minlength="8"
                                    class="w-full px-4 pr-12 py-3 border-2 {{ $errors->has('password') ? 'border-plyform-orange' : 'border-gray-200' }} rounded-xl focus:border-plyform-yellow focus:ring-4 focus:ring-plyform-yellow/10 outline-none transition-all"
                                    placeholder="Minimum 8 characters"
                                >
                                <button 
                                    type="button"
                                    id="togglePassword"
                                    class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-plyform-dark transition-colors"
                                >
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </button>
                            </div>
                            @error('password')
                                <p class="mt-1 text-sm text-plyform-orange">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password Confirmation -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-semibold text-plyform-dark mb-2">
                                Confirm Password <span class="text-plyform-orange">*</span>
                            </label>
                            <div class="relative">
                                <input 
                                    type="password" 
                                    id="password_confirmation" 
                                    name="password_confirmation"
                                    required
                                    minlength="8"
                                    class="w-full px-4 pr-12 py-3 border-2 border-gray-200 rounded-xl focus:border-plyform-yellow focus:ring-4 focus:ring-plyform-yellow/10 outline-none transition-all"
                                    placeholder="Re-enter your password"
                                >
                                <button 
                                    type="button"
                                    id="togglePasswordConfirmation"
                                    class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-plyform-dark transition-colors"
                                >
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Terms & Conditions -->
                    <div class="flex items-start p-4 bg-plyform-mint/30 rounded-xl border border-plyform-mint">
                        <input 
                            type="checkbox" 
                            id="terms_accepted" 
                            name="terms_accepted"
                            value="1"
                            required 
                            class="w-4 h-4 mt-1 text-plyform-yellow border-gray-300 rounded focus:ring-2 focus:ring-plyform-yellow/20"
                        >
                        <label for="terms_accepted" class="ml-2 text-sm text-plyform-dark">
                            I agree to the <a href="#" class="text-plyform-purple hover:text-plyform-dark font-semibold">Terms of Service</a> and <a href="#" class="text-plyform-purple hover:text-plyform-dark font-semibold">Privacy Policy</a>
                        </label>
                    </div>
                    @error('terms_accepted')
                        <p class="mt-1 text-sm text-plyform-orange">{{ $message }}</p>
                    @enderror
                    
                    <!-- Submit Button -->
                    <button 
                        type="submit"
                        class="w-full py-4 bg-plyform-yellow hover:bg-plyform-yellow/90 text-plyform-dark font-semibold rounded-xl shadow-lg shadow-plyform-yellow/30 hover:shadow-xl hover:shadow-plyform-yellow/40 transition-all hover:-translate-y-0.5"
                    >
                        Create Account
                    </button>
                </form>
                
                <!-- Login Link -->
                <p class="text-center text-gray-600 mt-8">
                    Already have an account? 
                    <a href="{{ route('login') }}" class="font-semibold text-plyform-purple hover:text-plyform-dark transition-colors">Log in</a>
                </p>

                <!-- Divider -->
                <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-200"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-4 bg-white text-gray-500">or</span>
                    </div>
                </div>

                <!-- Agency Registration Link -->
                <div class="text-center p-4 bg-gradient-to-r from-plyform-mint/30 to-plyform-yellow/20 rounded-xl border border-plyform-mint">
                    <p class="text-sm text-plyform-dark mb-2">
                        <strong>Are you a Real Estate Agency?</strong>
                    </p>
                    <a href="{{ route('register.agency') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-plyform-purple hover:text-plyform-dark transition-colors">
                        Register as an Agency
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </a>
                </div>
            </div>
            
            <!-- Footer Links -->
            <div class="text-center mt-8 text-sm text-gray-500">
                <a href="#" class="hover:text-plyform-purple transition-colors">Privacy Policy</a>
                <span class="mx-2">•</span>
                <a href="#" class="hover:text-plyform-purple transition-colors">Terms of Service</a>
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
    </style>

    <script>
        // Password Toggle
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        
        if (togglePassword && passwordInput) {
            togglePassword.addEventListener('click', () => {
                const type = passwordInput.type === 'password' ? 'text' : 'password';
                passwordInput.type = type;
                togglePassword.querySelector('svg').classList.toggle('text-plyform-yellow');
            });
        }

        // Password Confirmation Toggle
        const togglePasswordConfirmation = document.getElementById('togglePasswordConfirmation');
        const passwordConfirmationInput = document.getElementById('password_confirmation');
        
        if (togglePasswordConfirmation && passwordConfirmationInput) {
            togglePasswordConfirmation.addEventListener('click', () => {
                const type = passwordConfirmationInput.type === 'password' ? 'text' : 'password';
                passwordConfirmationInput.type = type;
                togglePasswordConfirmation.querySelector('svg').classList.toggle('text-plyform-yellow');
            });
        }
    </script>

</x-guest-layout>