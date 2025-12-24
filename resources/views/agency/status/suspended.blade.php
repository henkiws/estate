<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Suspended - Plyform</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-gray-50 via-white to-plyform-orange/10">
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="max-w-2xl w-full">
            
            <!-- Suspended Card -->
            <div class="bg-white rounded-2xl shadow-xl p-8 md:p-12 animate-fadeIn">
                
                <!-- Suspended Icon -->
                <div class="mb-6 text-center">
                    <div class="w-20 h-20 bg-plyform-orange/20 rounded-full flex items-center justify-center mx-auto">
                        <svg class="w-10 h-10 text-plyform-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                        </svg>
                    </div>
                </div>

                <!-- Suspended Message -->
                <div class="text-center mb-8">
                    <h1 class="text-3xl font-bold text-plyform-dark mb-4">
                        Account Suspended
                    </h1>
                    
                    <p class="text-lg text-gray-600">
                        Your agency account has been temporarily suspended.
                    </p>
                </div>

                <!-- Agency Info -->
                <div class="bg-plyform-orange/5 rounded-xl p-6 mb-8 border border-plyform-orange/20">
                    <h3 class="text-sm font-semibold text-plyform-dark uppercase mb-4">Agency Information</h3>
                    
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Agency Name:</span>
                            <span class="font-semibold text-plyform-dark">{{ $agency->agency_name }}</span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-gray-600">Status:</span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-plyform-orange/20 text-plyform-orange">
                                Suspended
                            </span>
                        </div>
                        
                        @if($agency->suspended_at)
                        <div class="flex justify-between">
                            <span class="text-gray-600">Suspended Date:</span>
                            <span class="font-medium text-plyform-dark">{{ $agency->suspended_at->format('d M Y, h:i A') }}</span>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- What to Do -->
                <div class="bg-plyform-yellow/20 border-2 border-plyform-yellow rounded-xl p-6 mb-8">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="w-6 h-6 text-plyform-dark" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-sm font-semibold text-plyform-dark mb-2">What This Means</h3>
                            <ul class="text-sm text-gray-700 space-y-1">
                                <li>• Your account access has been temporarily restricted</li>
                                <li>• Your listings and data are safe and preserved</li>
                                <li>• This suspension may be due to payment issues, policy violations, or administrative review</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Next Steps -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-plyform-dark mb-4">Next Steps</h3>
                    
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-8 h-8 bg-plyform-purple/20 rounded-full flex items-center justify-center">
                                <span class="text-plyform-purple font-semibold text-sm">1</span>
                            </div>
                            <div class="ml-4">
                                <p class="text-gray-700">
                                    <strong class="text-plyform-dark">Contact Support:</strong> Reach out to our support team to understand the reason for suspension and required actions.
                                </p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-8 h-8 bg-plyform-mint/30 rounded-full flex items-center justify-center">
                                <span class="text-plyform-dark font-semibold text-sm">2</span>
                            </div>
                            <div class="ml-4">
                                <p class="text-gray-700">
                                    <strong class="text-plyform-dark">Resolve Issues:</strong> Complete any required actions or resolve outstanding issues.
                                </p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-8 h-8 bg-plyform-yellow/30 rounded-full flex items-center justify-center">
                                <span class="text-plyform-dark font-semibold text-sm">3</span>
                            </div>
                            <div class="ml-4">
                                <p class="text-gray-700">
                                    <strong class="text-plyform-dark">Request Reactivation:</strong> Once issues are resolved, request account reactivation.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Support Button -->
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="mailto:support@sorted.com?subject=Account%20Suspended%20-%20{{ $agency->agency_name }}" 
                       class="flex-1 inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-plyform-purple to-plyform-dark text-white font-semibold rounded-xl hover:from-plyform-purple/90 hover:to-plyform-dark/90 transition-colors shadow-lg hover:shadow-xl">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        Contact Support
                    </a>
                    
                    <form method="POST" action="{{ route('logout') }}" class="flex-1">
                        @csrf
                        <button type="submit" 
                                class="w-full inline-flex items-center justify-center px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-xl hover:bg-gray-200 transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            Logout
                        </button>
                    </form>
                </div>

                <!-- Support Info -->
                <div class="mt-8 pt-8 border-t border-gray-200 text-center">
                    <p class="text-sm text-gray-600 mb-2">Need immediate assistance?</p>
                    <div class="flex flex-col sm:flex-row items-center justify-center gap-4 text-sm">
                        <a href="mailto:support@sorted.com" class="text-plyform-purple hover:text-plyform-dark font-medium">
                            📧 support@sorted.com
                        </a>
                        <span class="hidden sm:inline text-gray-400">|</span>
                        <a href="tel:1300123456" class="text-plyform-purple hover:text-plyform-dark font-medium">
                            📞 1300 123 456
                        </a>
                    </div>
                </div>
            </div>
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
    </style>
</body>
</html>