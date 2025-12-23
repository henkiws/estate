<x-guest-layout title="Forgot Password - plyform">
    <div class="w-full max-w-md mx-auto animate-fadeIn">
        <div class="bg-white rounded-3xl shadow-2xl p-8 sm:p-10">
            
            <!-- Logo -->
            <div class="text-center mb-8">
                <a href="{{ route('homepage') }}" class="inline-flex items-center group">
                    <img src="{{ asset('assets/images/logo-yellow.png') }}" alt="plyform" class="h-10 w-auto transition-transform duration-300 group-hover:scale-105">
                </a>
            </div>

            <!-- Icon -->
            <div class="flex justify-center mb-6">
                <div class="w-20 h-20 bg-plyform-purple/20 rounded-full flex items-center justify-center shadow-lg">
                    <svg class="w-10 h-10 text-plyform-purple" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                    </svg>
                </div>
            </div>

            <!-- Title -->
            <h2 class="text-center text-3xl font-bold mb-4 text-plyform-dark">Reset Password</h2>
            
            <!-- Description -->
            <div class="mb-6 text-center text-gray-600 bg-plyform-mint/30 rounded-xl p-4 border border-plyform-mint">
                <p class="text-sm">
                    Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.
                </p>
            </div>

            <!-- Session Status -->
            @if (session('status'))
                <div class="mb-6 bg-green-50 border-l-4 border-green-500 rounded-xl p-4 shadow-lg">
                    <div class="flex items-start">
                        <svg class="w-6 h-6 text-green-500 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <div>
                            <h3 class="text-green-800 font-semibold mb-1">Success!</h3>
                            <p class="text-green-700 text-sm">{{ session('status') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
                @csrf

                <!-- Email Address -->
                <div>
                    <label for="email" class="block text-sm font-semibold text-plyform-dark mb-2">
                        Email Address <span class="text-plyform-orange">*</span>
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
                            autofocus
                            class="w-full pl-12 pr-4 py-3.5 border-2 border-gray-200 rounded-xl focus:border-plyform-yellow focus:ring-4 focus:ring-plyform-yellow/10 outline-none transition-all"
                            placeholder="you@example.com"
                        >
                    </div>
                    @error('email')
                        <p class="mt-1 text-sm text-plyform-orange">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button 
                    type="submit"
                    class="w-full py-4 bg-plyform-yellow hover:bg-plyform-yellow/90 text-plyform-dark font-semibold rounded-xl shadow-lg shadow-plyform-yellow/30 hover:shadow-xl hover:shadow-plyform-yellow/40 transition-all hover:-translate-y-0.5"
                >
                    Email Password Reset Link
                </button>
            </form>

            <!-- Back to Login -->
            <div class="mt-6 text-center">
                <a href="{{ route('login') }}" class="text-sm font-semibold text-plyform-purple hover:text-plyform-dark transition-colors inline-flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to Login
                </a>
            </div>
        </div>
    </div>
</x-guest-layout>