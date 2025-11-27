<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Sorted - Step 1 of 2</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-gray-50 via-white to-blue-50">
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="max-w-4xl w-full">
            
            <!-- Progress Bar -->
            <div class="mb-6">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm font-medium text-gray-700">Step {{ $currentStep }} of 2</span>
                    <span class="text-sm font-medium text-blue-600">50% Complete</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-3">
                    <div class="bg-blue-600 h-3 rounded-full transition-all duration-500" style="width: 50%"></div>
                </div>
            </div>

            <!-- Welcome Card -->
            <div class="bg-white rounded-2xl shadow-xl p-8 md:p-12 animate-fadeIn">
                
                <!-- Celebration Icon -->
                <div class="mb-6 text-center">
                    <div class="w-24 h-24 bg-gradient-to-br from-green-400 to-green-600 rounded-full flex items-center justify-center mx-auto animate-bounce">
                        <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>

                <!-- Title -->
                <div class="text-center mb-8">
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                        🎉 Welcome to Sorted, {{ $agency->agency_name }}!
                    </h1>
                    
                    <p class="text-lg text-gray-600">
                        Complete these simple steps to get started
                    </p>
                </div>

                <!-- What's Next Section -->
                <div class="bg-blue-50 border border-blue-200 rounded-xl p-6 mb-8">
                    <h2 class="text-lg font-bold text-blue-900 mb-4 flex items-center">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        Here's What Happens Next:
                    </h2>
                    
                    <div class="space-y-4">
                        <!-- Step 1 - Current -->
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-8 h-8 bg-green-500 rounded-full flex items-center justify-center text-white font-bold text-sm">
                                ✓
                            </div>
                            <div class="ml-4 flex-1">
                                <h3 class="font-semibold text-gray-900">Step 1: Welcome</h3>
                                <p class="text-sm text-gray-600">You're here! Let's get you set up.</p>
                            </div>
                        </div>

                        <!-- Step 2 -->
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold text-sm">
                                2
                            </div>
                            <div class="ml-4 flex-1">
                                <h3 class="font-semibold text-gray-900">Step 2: Upload Documents</h3>
                                <p class="text-sm text-gray-600">Upload 5 required documents for verification</p>
                            </div>
                        </div>

                        <!-- Divider -->
                        <div class="border-t border-blue-200 my-4"></div>

                        <!-- After Approval -->
                        <div class="bg-white rounded-lg p-4 border border-blue-300">
                            <h3 class="font-semibold text-blue-900 mb-2 flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                After Document Upload:
                            </h3>
                            <ol class="list-decimal list-inside space-y-1 text-sm text-blue-800">
                                <li>Our admin team reviews your documents</li>
                                <li>You receive an approval email (usually within 24-48 hours)</li>
                                <li>Choose your subscription plan</li>
                                <li>Start managing your real estate business! 🚀</li>
                            </ol>
                        </div>
                    </div>
                </div>

                <!-- Agency Info Summary -->
                <div class="bg-gray-50 rounded-xl p-6 mb-8">
                    <h3 class="text-sm font-semibold text-gray-500 uppercase mb-4">Your Registration Details</h3>
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Agency Name</p>
                            <p class="text-sm font-medium text-gray-900">{{ $agency->agency_name }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 mb-1">ABN</p>
                            <p class="text-sm font-medium text-gray-900">{{ $agency->abn }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Business Email</p>
                            <p class="text-sm font-medium text-gray-900">{{ $agency->business_email }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Location</p>
                            <p class="text-sm font-medium text-gray-900">{{ $agency->state }}, {{ $agency->postcode }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 mb-1">License Number</p>
                            <p class="text-sm font-medium text-gray-900">{{ $agency->license_number }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 mb-1">License Holder</p>
                            <p class="text-sm font-medium text-gray-900">{{ $agency->license_holder_name }}</p>
                        </div>
                    </div>
                </div>

                <!-- Required Documents Info -->
                <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-6 mb-8">
                    <h3 class="font-bold text-yellow-900 mb-3 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                        </svg>
                        Documents You'll Need:
                    </h3>
                    <ul class="space-y-2 text-sm text-yellow-800">
                        <li class="flex items-center">
                            <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <span>Real Estate Agency License Certificate</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <span>Proof of Identity (Driver's License or Passport)</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <span>ABN Registration Certificate</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <span>Professional Indemnity Insurance</span>
                        </li>
                        <li class="flex items-center">
                            <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <span>Public Liability Insurance</span>
                        </li>
                    </ul>
                    <p class="text-xs text-yellow-700 mt-3">
                        💡 <strong>Tip:</strong> Have these documents ready in PDF, JPG, or PNG format (max 5MB each) before proceeding.
                    </p>
                </div>

                <!-- Estimated Time -->
                <div class="bg-gradient-to-r from-purple-50 to-pink-50 rounded-xl p-6 mb-8 text-center">
                    <p class="text-sm text-gray-600 mb-2">⏰ Estimated Time</p>
                    <p class="text-2xl font-bold text-gray-900">5 - 10 minutes</p>
                    <p class="text-xs text-gray-500 mt-1">To complete document upload</p>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4">
                    <form action="{{ route('agency.onboarding.complete-step1') }}" method="POST" class="flex-1">
                        @csrf
                        <button type="submit" 
                                class="w-full inline-flex items-center justify-center px-8 py-4 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 transition-all shadow-lg hover:shadow-xl">
                            Get Started - Upload Documents
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </button>
                    </form>
                </div>

                <!-- Skip Link -->
                <div class="text-center mt-6">
                    <form action="{{ route('agency.onboarding.skip') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-sm text-gray-500 hover:text-gray-700">
                            I'll upload documents later
                        </button>
                    </form>
                </div>

                <!-- Logout Button -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center mt-6">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" 
                                class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-3 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            Logout
                        </button>
                    </form>
                </div>

                <!-- Footer Help -->
                <div class="mt-8 pt-8 border-t border-gray-200 text-center">
                    <p class="text-sm text-gray-600 mb-3">
                        Need help getting started?
                    </p>
                    <div class="flex flex-col sm:flex-row items-center justify-center gap-4 text-sm">
                        <a href="mailto:support@sorted.com" class="text-blue-600 hover:text-blue-700 font-medium">
                            📧 support@sorted.com
                        </a>
                        <span class="hidden sm:inline text-gray-400">|</span>
                        <a href="tel:1300123456" class="text-blue-600 hover:text-blue-700 font-medium">
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
</body>
</html>