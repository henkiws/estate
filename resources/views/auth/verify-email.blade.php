<x-guest-layout title="Verify Email - Sorted Services">
    <div class="w-full max-w-md mx-auto animate-fadeIn">
        
        <!-- Success Message (if resent) -->
        @if(session('success'))
        <div class="mb-6 bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 rounded-xl p-5 shadow-xl animate-slideDown">
            <div class="flex items-start">
                <div class="flex-shrink-0 w-10 h-10 bg-green-500 rounded-full flex items-center justify-center animate-scaleIn">
                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-green-900 font-bold text-lg mb-1">Email Sent!</h3>
                    <p class="text-green-800">{{ session('success') }}</p>
                </div>
            </div>
        </div>
        @endif

        <!-- Verification Card -->
        <div class="bg-white rounded-3xl shadow-2xl p-8 sm:p-10">
            
            <!-- Logo -->
            <div class="text-center mb-8">
                <a href="{{ route('homepage') }}" class="inline-flex items-center space-x-3 mb-6 transition-transform hover:scale-105">
                    <div class="w-12 h-12 bg-gradient-to-br from-primary to-primary-dark rounded-xl flex items-center justify-center shadow-lg">
                        <span class="text-white font-bold text-2xl">S</span>
                    </div>
                    <span class="text-3xl font-bold text-gray-900">Sorted</span>
                </a>
            </div>

            <!-- Icon -->
            <div class="flex justify-center mb-6">
                <div class="relative">
                    <div class="w-24 h-24 bg-gradient-to-br from-blue-100 to-blue-200 rounded-full flex items-center justify-center animate-bounce-gentle shadow-lg">
                        <svg class="w-12 h-12 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <!-- Notification Badge -->
                    <div class="absolute -top-1 -right-1 w-7 h-7 bg-red-500 rounded-full flex items-center justify-center shadow-lg animate-pulse">
                        <span class="text-white text-xs font-bold">1</span>
                    </div>
                </div>
            </div>

            <!-- Title & Message -->
            <h1 class="text-3xl font-bold text-gray-900 text-center mb-3">
                Verify Your Email Address
            </h1>
            <p class="text-gray-600 text-center mb-2">
                We've sent a verification link to:
            </p>
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border-2 border-blue-200 rounded-xl p-4 mb-8 text-center">
                <p class="font-bold text-gray-900 text-lg break-all">{{ auth()->user()->email }}</p>
            </div>

            <!-- Instructions -->
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 border-2 border-blue-200 rounded-xl p-6 mb-6 shadow-sm">
                <h3 class="font-bold text-blue-900 mb-4 flex items-center text-lg">
                    <svg class="w-6 h-6 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                    What's Next?
                </h3>
                <ol class="space-y-3 text-sm text-blue-900">
                    <li class="flex items-start bg-white rounded-lg p-3 shadow-sm transition-transform hover:scale-105">
                        <span class="flex-shrink-0 w-6 h-6 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold text-xs mr-3 shadow-md">1</span>
                        <span class="pt-0.5"><strong>Check your email inbox</strong> (and spam folder)</span>
                    </li>
                    <li class="flex items-start bg-white rounded-lg p-3 shadow-sm transition-transform hover:scale-105">
                        <span class="flex-shrink-0 w-6 h-6 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold text-xs mr-3 shadow-md">2</span>
                        <span class="pt-0.5"><strong>Click the verification link</strong> in the email</span>
                    </li>
                    <li class="flex items-start bg-white rounded-lg p-3 shadow-sm transition-transform hover:scale-105">
                        <span class="flex-shrink-0 w-6 h-6 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold text-xs mr-3 shadow-md">3</span>
                        <span class="pt-0.5"><strong>Complete your agency profile</strong> step-by-step</span>
                    </li>
                </ol>
            </div>

            <!-- Resend Button -->
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="w-full py-4 bg-gradient-to-r from-primary to-primary-dark hover:from-primary-dark hover:to-primary text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1 mb-4 flex items-center justify-center group">
                    <svg class="w-5 h-5 mr-2 group-hover:rotate-180 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    Resend Verification Email
                </button>
            </form>

            <!-- Help Text -->
            <div class="bg-amber-50 border-2 border-amber-200 rounded-xl p-4 mb-6">
                <p class="text-center text-sm text-amber-900">
                    <strong>Didn't receive the email?</strong><br>
                    <span class="text-amber-800">Check your spam folder or click the button above to resend.</span>
                </p>
            </div>

            <!-- Logout Link -->
            <div class="text-center pt-6 border-t border-gray-200">
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-sm text-gray-600 hover:text-gray-900 font-semibold inline-flex items-center transition-all group">
                        <svg class="w-4 h-4 mr-1 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                        </svg>
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
            animation: fadeIn 0.6s ease-out;
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
            animation: slideDown 0.4s ease-out;
        }

        @keyframes scaleIn {
            from {
                opacity: 0;
                transform: scale(0);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }
        
        .animate-scaleIn {
            animation: scaleIn 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        @keyframes bounce-gentle {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-12px);
            }
        }
        
        .animate-bounce-gentle {
            animation: bounce-gentle 2.5s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% {
                opacity: 1;
                transform: scale(1);
            }
            50% {
                opacity: 0.8;
                transform: scale(1.05);
            }
        }
        
        .animate-pulse {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
    </style>
</x-guest-layout>