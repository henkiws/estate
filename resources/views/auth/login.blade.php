<x-guest-layout title="Login - plyform">

    <div class="w-full max-w-6xl grid lg:grid-cols-2 gap-8 items-center animate-fadeIn">

        {{-- LEFT SIDE - Brand Information --}}
        <div class="hidden lg:block space-y-8 p-12">
            <!-- Logo -->
            <a href="{{ route('homepage') }}" class="flex items-center space-x-3 mb-12 cursor-pointer group">
                <img src="{{ asset('assets/images/logo-yellow.png') }}" alt="plyform" class="h-12 w-auto transition-transform duration-300 group-hover:scale-105">
            </a>
            
            <div class="space-y-6">
                <h1 class="text-4xl lg:text-5xl font-bold leading-tight text-plyform-dark">
                    Welcome back to<br>
                    <span class="gradient-text">plyform</span>
                </h1>
                
                <p class="text-xl text-gray-600 leading-relaxed">
                    Manage your properties, tenants, and services all in one place. Your property management made simple.
                </p>
            </div>
            
            <!-- Features List -->
            <div class="space-y-4 pt-8">
                <div class="flex items-center gap-3">
                    <div class="w-6 h-6 bg-plyform-yellow rounded-full flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-plyform-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <span class="text-gray-700">Centralized property management</span>
                </div>
                <div class="flex items-center gap-3">
                    <div class="w-6 h-6 bg-plyform-yellow rounded-full flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-plyform-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <span class="text-gray-700">Real-time notifications & updates</span>
                </div>
                <div class="flex items-center gap-3">
                    <div class="w-6 h-6 bg-plyform-yellow rounded-full flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-plyform-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <span class="text-gray-700">Bank-grade security & encryption</span>
                </div>
            </div>
            
            <!-- Testimonial -->
            <div class="bg-white p-6 rounded-2xl shadow-plyform border border-gray-100 mt-12">
                <div class="flex gap-1 text-plyform-yellow mb-3">
                    <span>⭐</span><span>⭐</span><span>⭐</span><span>⭐</span><span>⭐</span>
                </div>
                <p class="text-gray-700 mb-4">"plyform has completely transformed how I manage my properties. Can't imagine going back!"</p>
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-plyform-yellow rounded-full flex items-center justify-center text-plyform-dark font-bold text-sm">SJ</div>
                    <div>
                        <div class="font-semibold text-plyform-dark text-sm">Sarah Johnson</div>
                        <div class="text-gray-600 text-xs">Property Manager</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- RIGHT SIDE - Login Form --}}
        <div class="w-full max-w-md mx-auto">
            <div class="bg-white rounded-3xl shadow-2xl p-8 sm:p-10">

                <!-- Mobile Logo -->
                <div class="lg:hidden mb-8 flex justify-center">
                    <a href="{{ route('homepage') }}">
                        <img src="{{ asset('assets/images/logo-yellow.png') }}" alt="plyform" class="h-10 w-auto">
                    </a>
                </div>

                <h2 class="text-center text-3xl font-bold mb-6 text-plyform-dark">Welcome back</h2>

                <form method="POST" action="{{ route('login') }}" id="loginForm" class="space-y-6">
                    @csrf

                    <!-- Email Field -->
                    <div>
                        <label for="email" class="block text-sm font-semibold text-plyform-dark mb-2">Email Address</label>
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
                                class="w-full pl-12 pr-4 py-3.5 border-2 border-gray-200 rounded-xl focus:border-plyform-yellow focus:ring-4 focus:ring-plyform-yellow/10 outline-none transition-all"
                                placeholder="you@example.com"
                                value="{{ old('email') }}"
                            >
                        </div>
                        @error('email')
                            <p class="mt-1 text-sm text-plyform-orange">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Password Field -->
                    <div>
                        <label for="password" class="block text-sm font-semibold text-plyform-dark mb-2">Password</label>
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
                                class="w-full pl-12 pr-12 py-3.5 border-2 border-gray-200 rounded-xl focus:border-plyform-yellow focus:ring-4 focus:ring-plyform-yellow/10 outline-none transition-all"
                                placeholder="Enter your password"
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
                    
                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between">
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" name="remember" class="w-4 h-4 text-plyform-yellow border-gray-300 rounded focus:ring-2 focus:ring-plyform-yellow/20">
                            <span class="ml-2 text-sm text-gray-600">Remember me</span>
                        </label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-sm font-semibold text-plyform-purple hover:text-plyform-dark transition-colors">Forgot password?</a>
                        @endif
                    </div>
                    
                    <!-- Submit Button -->
                    <button 
                        type="submit"
                        class="w-full py-4 bg-plyform-yellow hover:bg-plyform-yellow/90 text-plyform-dark font-semibold rounded-xl shadow-lg shadow-plyform-yellow/30 hover:shadow-xl hover:shadow-plyform-yellow/40 transition-all hover:-translate-y-0.5"
                    >
                        Log In
                    </button>
                </form>

                <!-- Divider -->
                <div class="relative my-8">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-200"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-4 bg-white text-gray-500">or</span>
                    </div>
                </div>

                <!-- Sign Up Link -->
                <p class="text-center text-gray-600">
                    Don't have an account? 
                    <a href="{{ route('register') }}" class="font-semibold text-plyform-purple hover:text-plyform-dark transition-colors">Sign Up</a>
                </p>

            </div>

            <!-- Back to Homepage Link -->
            <div class="text-center mt-6">
                <a href="{{ route('homepage') }}" class="text-sm text-gray-600 hover:text-plyform-purple transition-colors inline-flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to Homepage
                </a>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Toggle password visibility
        document.getElementById('togglePassword')?.addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            
            // Toggle eye icon
            this.querySelector('svg').classList.toggle('text-plyform-yellow');
        });
    </script>
    @endpush

</x-guest-layout>