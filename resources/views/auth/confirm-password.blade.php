<x-guest-layout title="Confirm Password - plyform">
    <div class="w-full max-w-md mx-auto animate-fadeIn">
        <div class="bg-white rounded-3xl shadow-2xl p-8 sm:p-10">
            
            <!-- Logo -->
            <div class="text-center mb-8">
                <a href="{{ route('homepage') }}" class="inline-flex items-center group">
                    <img src="{{ asset('assets/images/logo-dark.png') }}" alt="plyform" class="h-10 w-auto transition-transform duration-300 group-hover:scale-105">
                </a>
            </div>

            <!-- Icon -->
            <div class="flex justify-center mb-6">
                <div class="w-20 h-20 bg-plyform-mint rounded-full flex items-center justify-center shadow-lg">
                    <svg class="w-10 h-10 text-plyform-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
            </div>

            <!-- Title -->
            <h2 class="text-center text-3xl font-bold mb-4 text-plyform-dark">Confirm Password</h2>
            
            <!-- Description -->
            <div class="mb-6 text-center text-gray-600 bg-plyform-mint/30 rounded-xl p-4 border border-plyform-mint">
                <p class="text-sm">
                    This is a secure area of the application. Please confirm your password before continuing.
                </p>
            </div>

            <form method="POST" action="{{ route('password.confirm') }}" class="space-y-6">
                @csrf

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-semibold text-plyform-dark mb-2">
                        Password <span class="text-plyform-orange">*</span>
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
                            autocomplete="current-password"
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

                <!-- Submit Button -->
                <div class="flex justify-end pt-2">
                    <button 
                        type="submit"
                        class="px-8 py-3.5 bg-plyform-yellow hover:bg-plyform-yellow/90 text-plyform-dark font-semibold rounded-xl shadow-lg shadow-plyform-yellow/30 hover:shadow-xl hover:shadow-plyform-yellow/40 transition-all hover:-translate-y-0.5"
                    >
                        Confirm
                    </button>
                </div>
            </form>
        </div>

        <!-- Back Link -->
        <div class="text-center mt-6">
            <a href="{{ route('homepage') }}" class="text-sm text-gray-600 hover:text-plyform-purple transition-colors inline-flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Homepage
            </a>
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
    </script>
    @endpush
</x-guest-layout>