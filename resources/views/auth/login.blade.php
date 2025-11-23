<x-guest-layout title="Login - Sorted Services">

    <div class="w-full max-w-6xl grid lg:grid-cols-2 gap-8 items-center animate-fadeIn">

        {{-- LEFT SIDE SAME AS ORIGINAL --}}
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
                    Welcome back to<br>
                    <span class="gradient-text">Sorted</span>
                </h1>
                
                <p class="text-xl text-gray-600 leading-relaxed">
                    Manage your properties, tenants, and services all in one place. Your property management made simple.
                </p>
            </div>
            
            <!-- Features List -->
            <div class="space-y-4 pt-8">
                <div class="flex items-center gap-3">
                    <div class="w-6 h-6 bg-primary rounded-full flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <span class="text-gray-700">Centralized property management</span>
                </div>
                <div class="flex items-center gap-3">
                    <div class="w-6 h-6 bg-primary rounded-full flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <span class="text-gray-700">Real-time notifications & updates</span>
                </div>
                <div class="flex items-center gap-3">
                    <div class="w-6 h-6 bg-primary rounded-full flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <span class="text-gray-700">Bank-grade security & encryption</span>
                </div>
            </div>
            
            <!-- Testimonial -->
            <div class="bg-white p-6 rounded-2xl shadow-lg border border-gray-100 mt-12">
                <div class="flex gap-1 text-yellow-400 mb-3">
                    <span>⭐</span><span>⭐</span><span>⭐</span><span>⭐</span><span>⭐</span>
                </div>
                <p class="text-gray-700 mb-4">"Sorted has completely transformed how I manage my properties. Can't imagine going back!"</p>
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-primary to-purple-600 rounded-full flex items-center justify-center text-white font-bold text-sm">SJ</div>
                    <div>
                        <div class="font-semibold text-gray-900 text-sm">Sarah Johnson</div>
                        <div class="text-gray-600 text-xs">Property Manager</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- RIGHT SIDE LOGIN FORM --}}
        <div class="w-full max-w-md mx-auto">
            <div class="bg-white rounded-3xl shadow-2xl p-8 sm:p-10">

                <h2 class="text-center text-3xl font-bold mb-6">Welcome back</h2>

                <form method="POST" action="{{ route('login') }}" id="loginForm" class="space-y-6">
                    @csrf

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
                                class="w-full pl-12 pr-4 py-3.5 border-2 border-gray-200 rounded-xl focus:border-primary focus:ring-4 focus:ring-primary/10 outline-none transition-all"
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
                                class="w-full pl-12 pr-12 py-3.5 border-2 border-gray-200 rounded-xl focus:border-primary focus:ring-4 focus:ring-primary/10 outline-none transition-all"
                                placeholder="Enter your password"
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
                    
                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between">
                        <label class="flex items-center">
                            <input type="checkbox" class="w-4 h-4 text-primary border-gray-300 rounded focus:ring-2 focus:ring-primary/20">
                            <span class="ml-2 text-sm text-gray-600">Remember me</span>
                        </label>
                        {{-- <a href="{{ route('forgot-password') }}" class="text-sm font-semibold text-primary hover:text-primary-dark">Forgot password?</a> --}}
                    </div>
                    
                    <!-- Submit Button -->
                    <button 
                        type="submit"
                        class="w-full py-4 bg-primary hover:bg-primary-dark text-white font-semibold rounded-xl shadow-lg shadow-primary/30 hover:shadow-xl hover:shadow-primary/40 transition-all hover:-translate-y-0.5"
                    >
                        Log In
                    </button>
                </form>

                <p class="text-center text-gray-600 mt-8">
                    Don't have an account? 
                    <a href="{{ route('register') }}" class="font-semibold text-primary">Sign Up</a>
                </p>

            </div>
        </div>
    </div>

</x-guest-layout>
