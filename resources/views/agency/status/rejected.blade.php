<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Rejected - Plyform</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-gray-50 via-white to-plyform-orange/10">
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="max-w-3xl w-full">
            
            <!-- Rejected Card -->
            <div class="bg-white rounded-2xl shadow-xl p-8 md:p-12 animate-fadeIn">
                
                <!-- Rejected Icon -->
                <div class="mb-6 text-center">
                    <div class="w-20 h-20 bg-plyform-orange/20 rounded-full flex items-center justify-center mx-auto">
                        <svg class="w-10 h-10 text-plyform-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </div>
                </div>

                <!-- Rejected Message -->
                <div class="text-center mb-8">
                    <h1 class="text-3xl font-bold text-plyform-dark mb-4">
                        Application Not Approved
                    </h1>
                    
                    <p class="text-lg text-gray-600">
                        Unfortunately, we're unable to approve your agency registration at this time.
                    </p>
                </div>

                <!-- Rejection Reason -->
                @if($agency->rejection_reason)
                <div class="bg-plyform-orange/10 border-l-4 border-plyform-orange p-6 mb-8 rounded-lg">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="w-6 h-6 text-plyform-orange" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-4 flex-1">
                            <h3 class="text-sm font-semibold text-plyform-orange mb-2">Reason for Rejection:</h3>
                            <p class="text-sm text-gray-700 leading-relaxed">
                                {{ $agency->rejection_reason }}
                            </p>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Timeline -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-plyform-dark mb-4">Application Timeline</h3>
                    <div class="space-y-4">
                        <!-- Submitted -->
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-10 h-10 bg-plyform-mint/30 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-plyform-dark" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-plyform-dark">Application Submitted</p>
                                <p class="text-xs text-gray-500">{{ $agency->created_at->format('d M Y, h:i A') }}</p>
                            </div>
                        </div>
                        
                        <!-- Rejected -->
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-10 h-10 bg-plyform-orange/20 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-plyform-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-plyform-dark">Application Rejected</p>
                                <p class="text-xs text-gray-500">
                                    @if($agency->rejected_at)
                                        {{ $agency->rejected_at->format('d M Y, h:i A') }}
                                    @else
                                        Recently
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Agency Info -->
                <div class="bg-plyform-orange/5 rounded-xl p-6 mb-8 border border-plyform-orange/20">
                    <h3 class="text-sm font-semibold text-plyform-dark uppercase mb-4">Submitted Information</h3>
                    
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Agency Name</p>
                            <p class="text-sm font-medium text-plyform-dark">{{ $agency->agency_name }}</p>
                        </div>
                        
                        <div>
                            <p class="text-xs text-gray-500 mb-1">ABN</p>
                            <p class="text-sm font-medium text-plyform-dark">{{ $agency->abn }}</p>
                        </div>
                        
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Business Email</p>
                            <p class="text-sm font-medium text-plyform-dark">{{ $agency->business_email }}</p>
                        </div>
                        
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Location</p>
                            <p class="text-sm font-medium text-plyform-dark">{{ $agency->state }}, {{ $agency->postcode }}</p>
                        </div>
                    </div>
                </div>

                <!-- Next Steps -->
                <div class="bg-plyform-purple/10 border-2 border-plyform-purple rounded-xl p-6 mb-8">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="w-6 h-6 text-plyform-purple" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-sm font-semibold text-plyform-dark mb-2">What Can You Do?</h3>
                            <ul class="text-sm text-gray-700 space-y-2">
                                <li class="flex items-start">
                                    <svg class="w-5 h-5 text-plyform-purple mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span><strong>Review the rejection reason</strong> carefully above</span>
                                </li>
                                <li class="flex items-start">
                                    <svg class="w-5 h-5 text-plyform-purple mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span><strong>Contact our support team</strong> if you need clarification</span>
                                </li>
                                <li class="flex items-start">
                                    <svg class="w-5 h-5 text-plyform-purple mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span><strong>Address the concerns</strong> mentioned in the rejection reason</span>
                                </li>
                                <li class="flex items-start">
                                    <svg class="w-5 h-5 text-plyform-purple mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span><strong>Submit a new application</strong> once you've resolved the issues</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Common Rejection Reasons -->
                <div class="bg-gray-50 rounded-xl p-6 mb-8">
                    <h3 class="text-sm font-semibold text-plyform-dark mb-3">Common Rejection Reasons</h3>
                    <ul class="text-sm text-gray-600 space-y-2">
                        <li class="flex items-start">
                            <span class="text-plyform-orange mr-2">•</span>
                            <span>Invalid or unverified Australian Business Number (ABN)</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-plyform-orange mr-2">•</span>
                            <span>Expired or invalid Real Estate License</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-plyform-orange mr-2">•</span>
                            <span>Incomplete or incorrect business information</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-plyform-orange mr-2">•</span>
                            <span>Missing required documentation</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-plyform-orange mr-2">•</span>
                            <span>Business not registered in Australia</span>
                        </li>
                    </ul>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="mailto:support@sorted.com?subject=Regarding%20Rejected%20Application%20-%20{{ $agency->agency_name }}" 
                       class="flex-1 inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-plyform-purple to-plyform-dark text-white font-semibold rounded-xl hover:from-plyform-purple/90 hover:to-plyform-dark/90 transition-colors shadow-lg hover:shadow-xl">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        Contact Support
                    </a>
                    <form method="POST" action="{{ route('agency.onboarding.new-application') }}" class="flex-1">
                        @csrf
                        <button type="submit" 
                                class="w-full inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-plyform-yellow to-plyform-mint text-plyform-dark font-semibold rounded-xl hover:from-plyform-yellow/90 hover:to-plyform-mint/90 transition-colors shadow-lg hover:shadow-xl">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            New Application
                        </button>
                    </form>
                    
                    <form method="POST" action="{{ route('logout') }}" class="flex-1">
                        @csrf
                        <button type="submit" 
                                class="w-full inline-flex items-center justify-center px-6 py-3 bg-white border-2 border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            Logout
                        </button>
                    </form>
                </div>

                <!-- Support Info -->
                <div class="mt-8 pt-8 border-t border-gray-200 text-center">
                    <p class="text-sm text-gray-600 mb-3">Need help understanding why your application was rejected?</p>
                    <div class="flex flex-col sm:flex-row items-center justify-center gap-4 text-sm">
                        <a href="mailto:support@sorted.com" class="text-plyform-purple hover:text-plyform-dark font-medium">
                            📧 support@sorted.com
                        </a>
                        <span class="hidden sm:inline text-gray-400">|</span>
                        <a href="tel:1300123456" class="text-plyform-purple hover:text-plyform-dark font-medium">
                            📞 1300 123 456
                        </a>
                    </div>
                    <p class="text-xs text-gray-500 mt-4">
                        Business hours: Monday - Friday, 9:00 AM - 5:00 PM AEST
                    </p>
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