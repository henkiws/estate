<x-guest-layout title="Reset Password - plyform">
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
                <div class="w-20 h-20 bg-plyform-yellow rounded-full flex items-center justify-center shadow-lg">
                    <svg class="w-10 h-10 text-plyform-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                    </svg>
                </div>
            </div>

            <!-- Title -->
            <h2 class="text-center text-3xl font-bold mb-4 text-plyform-dark">Create New Password</h2>
            
            <!-- Description -->
            <p class="text-center text-gray-600 mb-6">
                Please enter your new password below
            </p>

            <form method="POST" action="{{ route('password.store') }}" class="space-y-5">
                @csrf

                <!-- Password Reset Token -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

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
                            value="{{ old('email', $request->email) }}"
                            required
                            autofocus
                            autocomplete="username"
                            class="w-full pl-12 pr-4 py-3.5 border-2 border-gray-200 rounded-xl focus:border-plyform-yellow focus:ring-4 focus:ring-plyform-yellow/10 outline-none transition-all"
                            placeholder="you@example.com"
                        >
                    </div>
                    @error('email')
                        <p class="mt-1 text-sm text-plyform-orange">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-semibold text-plyform-dark mb-2">
                        New Password <span class="text-plyform-orange">*</span>
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
                            autocomplete="new-password"
                            class="w-full pl-12 pr-12 py-3.5 border-2 border-gray-200 rounded-xl focus:border-plyform-yellow focus:ring-4 focus:ring-plyform-yellow/10 outline-none transition-all"
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

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-semibold text-plyform-dark mb-2">
                        Confirm New Password <span class="text-plyform-orange">*</span>
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
                            autocomplete="new-password"
                            class="w-full pl-12 pr-12 py-3.5 border-2 border-gray-200 rounded-xl focus:border-plyform-yellow focus:ring-4 focus:ring-plyform-yellow/10 outline-none transition-all"
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
                    @error('password_confirmation')
                        <p class="mt-1 text-sm text-plyform-orange">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Requirements -->
                <div class="bg-plyform-mint/30 rounded-xl p-4 border border-plyform-mint">
                    <p class="text-xs text-plyform-dark font-semibold mb-2">Password must contain:</p>
                    <ul class="text-xs text-gray-600 space-y-1">
                        <li class="flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-plyform-yellow"></span>
                            At least 8 characters
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-plyform-yellow"></span>
                            Mix of letters and numbers recommended
                        </li>
                    </ul>
                </div>

                <!-- Submit Button -->
                <button 
                    type="submit"
                    class="w-full py-4 bg-plyform-yellow hover:bg-plyform-yellow/90 text-plyform-dark font-semibold rounded-xl shadow-lg shadow-plyform-yellow/30 hover:shadow-xl hover:shadow-plyform-yellow/40 transition-all hover:-translate-y-0.5"
                >
                    Reset Password
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

    @push('scripts')
    <script>
        // Toggle password visibility
        document.getElementById('togglePassword')?.addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.querySelector('svg').classList.toggle('text-plyform-yellow');
        });

        document.getElementById('togglePasswordConfirmation')?.addEventListener('click', function() {
            const passwordInput = document.getElementById('password_confirmation');
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.querySelector('svg').classList.toggle('text-plyform-yellow');
        });
    </script>
    @endpush
</x-guest-layout>