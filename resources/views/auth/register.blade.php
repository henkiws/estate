<x-guest-layout title="Sign Up - Sorted Services">

   <!-- Register Container -->
    <div class="w-full max-w-6xl grid lg:grid-cols-2 gap-8 items-center animate-fadeIn">
        
        <!-- Left Side - Branding & Info -->
        <div class="hidden lg:block space-y-8 p-12">
            <!-- Logo -->
            <a href="{{ route('homepage') }}" class="flex items-center space-x-3 mb-12 cursor-pointer">
                <div class="w-12 h-12 bg-gradient-to-br from-primary to-primary-dark rounded-xl flex items-center justify-center">
                    <span class="text-white font-bold text-2xl">S</span>
                </div>
                <span class="text-3xl font-bold text-gray-900">Sorted</span>
            </a>
            
            <div class="space-y-6">
                <h1 class="text-4xl lg:text-5xl font-bold leading-tight">
                    Start your journey with<br>
                    <span class="gradient-text">Sorted</span>
                </h1>
                
                <p class="text-xl text-gray-600 leading-relaxed">
                    Join thousands of property managers, landlords, and tenants who trust Sorted for their property management needs.
                </p>
            </div>
            
            <!-- Benefits -->
            <div class="space-y-6 pt-8">
                <div class="flex gap-4">
                    <div class="w-12 h-12 bg-primary-light rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 mb-1">Quick Setup</h3>
                        <p class="text-gray-600 text-sm">Get started in minutes with our intuitive onboarding process</p>
                    </div>
                </div>
                
                <div class="flex gap-4">
                    <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 mb-1">Secure & Private</h3>
                        <p class="text-gray-600 text-sm">Your data is protected with bank-grade encryption</p>
                    </div>
                </div>
                
                <div class="flex gap-4">
                    <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 mb-1">24/7 Support</h3>
                        <p class="text-gray-600 text-sm">Our team is always here to help you succeed</p>
                    </div>
                </div>
            </div>
            
            <!-- Stats -->
            <div class="grid grid-cols-3 gap-6 pt-8 border-t border-gray-200">
                <div>
                    <div class="text-3xl font-bold text-gray-900">10K+</div>
                    <div class="text-sm text-gray-600">Users</div>
                </div>
                <div>
                    <div class="text-3xl font-bold text-gray-900">50K+</div>
                    <div class="text-sm text-gray-600">Properties</div>
                </div>
                <div>
                    <div class="text-3xl font-bold text-gray-900">99%</div>
                    <div class="text-sm text-gray-600">Satisfaction</div>
                </div>
            </div>
        </div>
        
        <!-- Right Side - Register Form -->
        <div class="w-full max-w-md mx-auto">
            <div class="bg-white rounded-3xl shadow-2xl p-8 sm:p-10">
                <!-- Mobile Logo -->
                <div class="lg:hidden flex items-center justify-center space-x-2 mb-8">
                    <div class="w-10 h-10 bg-gradient-to-br from-primary to-primary-dark rounded-lg flex items-center justify-center">
                        <span class="text-white font-bold text-xl">S</span>
                    </div>
                    <span class="text-2xl font-bold text-gray-900">Sorted</span>
                </div>
                
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-gray-900 mb-2">Create an account</h2>
                    <p class="text-gray-600">Start managing your properties today</p>
                </div>
                
                <!-- Register Form -->
                <form id="registerForm" class="space-y-5">
                    <!-- Full Name -->
                    <div>
                        <label for="fullName" class="block text-sm font-semibold text-gray-700 mb-2">Full Name</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                            <input 
                                type="text" 
                                id="fullName" 
                                name="fullName"
                                required
                                class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:border-primary focus:ring-4 focus:ring-primary/10 outline-none transition-all"
                                placeholder="John Doe"
                            >
                        </div>
                    </div>
                    
                    <!-- Email Field -->
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
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
                                placeholder="you@example.com"
                            >
                        </div>
                    </div>
                    
                    <!-- Password Field -->
                    <div>
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
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
                                class="w-full pl-12 pr-12 py-3 border-2 border-gray-200 rounded-xl focus:border-primary focus:ring-4 focus:ring-primary/10 outline-none transition-all"
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
                    </div>
                    
                    <!-- Role Selection -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">I am a...</label>
                        <div class="grid grid-cols-3 gap-3">
                            <label class="relative">
                                <input type="radio" name="role" value="tenant" class="peer sr-only" required>
                                <div class="p-3 border-2 border-gray-200 rounded-xl text-center cursor-pointer peer-checked:border-primary peer-checked:bg-primary-light transition-all">
                                    <div class="text-2xl mb-1">🏠</div>
                                    <div class="text-xs font-semibold text-gray-700">Tenant</div>
                                </div>
                            </label>
                            <label class="relative">
                                <input type="radio" name="role" value="landlord" class="peer sr-only">
                                <div class="p-3 border-2 border-gray-200 rounded-xl text-center cursor-pointer peer-checked:border-primary peer-checked:bg-primary-light transition-all">
                                    <div class="text-2xl mb-1">🔑</div>
                                    <div class="text-xs font-semibold text-gray-700">Landlord</div>
                                </div>
                            </label>
                            <label class="relative">
                                <input type="radio" name="role" value="agent" class="peer sr-only">
                                <div class="p-3 border-2 border-gray-200 rounded-xl text-center cursor-pointer peer-checked:border-primary peer-checked:bg-primary-light transition-all">
                                    <div class="text-2xl mb-1">💼</div>
                                    <div class="text-xs font-semibold text-gray-700">Agent</div>
                                </div>
                            </label>
                        </div>
                    </div>
                    
                    <!-- Terms & Conditions -->
                    <div class="flex items-start">
                        <input type="checkbox" id="terms" required class="w-4 h-4 mt-1 text-primary border-gray-300 rounded focus:ring-2 focus:ring-primary/20">
                        <label for="terms" class="ml-2 text-sm text-gray-600">
                            I agree to the <a href="#" class="text-primary hover:text-primary-dark font-semibold">Terms of Service</a> and <a href="#" class="text-primary hover:text-primary-dark font-semibold">Privacy Policy</a>
                        </label>
                    </div>
                    
                    <!-- Submit Button -->
                    <button 
                        type="submit"
                        class="w-full py-4 bg-primary hover:bg-primary-dark text-white font-semibold rounded-xl shadow-lg shadow-primary/30 hover:shadow-xl hover:shadow-primary/40 transition-all hover:-translate-y-0.5"
                    >
                        Create Account
                    </button>
                </form>
                
                <!-- Divider -->
                <div class="relative my-6 hidden">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-200"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-4 bg-white text-gray-500">Or sign up with</span>
                    </div>
                </div>
                
                <!-- Social Login -->
                <div class="grid grid-cols-2 gap-4 hidden">
                    <button class="flex items-center justify-center gap-2 px-4 py-3 border-2 border-gray-200 rounded-xl hover:bg-gray-50 hover:border-gray-300 transition-all">
                        <svg class="w-5 h-5" viewBox="0 0 24 24">
                            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                        </svg>
                        <span class="text-sm font-semibold text-gray-700">Google</span>
                    </button>
                    <button class="flex items-center justify-center gap-2 px-4 py-3 border-2 border-gray-200 rounded-xl hover:bg-gray-50 hover:border-gray-300 transition-all">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                        </svg>
                        <span class="text-sm font-semibold text-gray-700">GitHub</span>
                    </button>
                </div>
                
                <!-- Login Link -->
                <p class="text-center text-gray-600 mt-8">
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

    <script>
        // Password Toggle
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        
        togglePassword.addEventListener('click', () => {
            const type = passwordInput.type === 'password' ? 'text' : 'password';
            passwordInput.type = type;
        });
        
        // Form Submission
        const registerForm = document.getElementById('registerForm');
        registerForm.addEventListener('submit', (e) => {
            e.preventDefault();
            
            const fullName = document.getElementById('fullName').value;
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const role = document.querySelector('input[name="role"]:checked').value;
            const terms = document.getElementById('terms').checked;
            
            if (!terms) {
                alert('Please accept the terms and conditions');
                return;
            }
            
            // Here you would typically make an API call
            console.log('Registration:', { fullName, email, password, role });
            
            // Simulate successful registration
            alert('Account created successfully! Redirecting to dashboard...');
            window.location.href = 'dashboard.html';
        });
    </script>

</x-guest-layout>
