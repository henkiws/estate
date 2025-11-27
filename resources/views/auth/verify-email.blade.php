<x-guest-layout title="Verify Email - Sorted Services">
    <div class="w-full max-w-md mx-auto animate-fadeIn">
        
        <!-- Success Message (if resent) -->
        @if(session('success'))
        <div class="mb-6 bg-green-50 border-l-4 border-green-500 rounded-xl p-4 shadow-lg animate-slideDown">
            <div class="flex items-start">
                <svg class="w-6 h-6 text-green-500 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                <div>
                    <h3 class="text-green-800 font-semibold mb-1">Email Sent!</h3>
                    <p class="text-green-700 text-sm">{{ session('success') }}</p>
                </div>
            </div>
        </div>
        @endif

        <!-- Verification Card -->
        <div class="bg-white rounded-3xl shadow-2xl p-8 sm:p-10">
            
            <!-- Logo -->
            <div class="text-center mb-8">
                <a href="{{ route('homepage') }}" class="inline-flex items-center space-x-3 mb-6">
                    <div class="w-12 h-12 bg-gradient-to-br from-primary to-primary-dark rounded-xl flex items-center justify-center">
                        <span class="text-white font-bold text-2xl">S</span>
                    </div>
                    <span class="text-3xl font-bold text-gray-900">Sorted</span>
                </a>
            </div>

            <!-- Icon -->
            <div class="flex justify-center mb-6">
                <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center animate-bounce">
                    <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>

            <!-- Title & Message -->
            <h1 class="text-3xl font-bold text-gray-900 text-center mb-3">
                Verify Your Email Address
            </h1>
            <p class="text-gray-600 text-center mb-8">
                We've sent a verification link to:<br>
                <span class="font-semibold text-gray-900">{{ auth()->user()->email }}</span>
            </p>

            <!-- Instructions -->
            <div class="bg-blue-50 border border-blue-200 rounded-xl p-6 mb-6">
                <h3 class="font-semibold text-blue-900 mb-3 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                    What's Next?
                </h3>
                <ol class="space-y-2 text-sm text-blue-900">
                    <li class="flex items-start">
                        <span class="font-bold mr-2">1.</span>
                        <span>Check your email inbox (and spam folder)</span>
                    </li>
                    <li class="flex items-start">
                        <span class="font-bold mr-2">2.</span>
                        <span>Click the verification link in the email</span>
                    </li>
                    <li class="flex items-start">
                        <span class="font-bold mr-2">3.</span>
                        <span>Complete your agency profile step-by-step</span>
                    </li>
                </ol>
            </div>

            <!-- Resend Button -->
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="w-full py-4 bg-primary hover:bg-primary-dark text-white font-semibold rounded-xl shadow-lg transition-all hover:-translate-y-0.5 mb-4">
                    Resend Verification Email
                </button>
            </form>

            <!-- Help Text -->
            <p class="text-center text-sm text-gray-500 mb-6">
                Didn't receive the email? Check your spam folder or click the button above to resend.
            </p>

            <!-- Logout Link -->
            <div class="text-center pt-6 border-t border-gray-200">
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-sm text-gray-600 hover:text-gray-900 font-medium">
                        Logout
                    </button>
                </form>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center mt-6 text-sm text-gray-500">
            <p>&copy; 2024 Sorted Services. All rights reserved.</p>
        </div>
    </div>

    <style>
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

        @keyframes bounce {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-10px);
            }
        }
        
        .animate-bounce {
            animation: bounce 2s infinite;
        }
    </style>
</x-guest-layout>