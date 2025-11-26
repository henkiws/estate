<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Under Review - Sorted Services</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-gray-50 via-white to-blue-50">
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="max-w-4xl w-full">
            
            <!-- Pending Card -->
            <div class="bg-white rounded-2xl shadow-xl p-8 md:p-12 animate-fadeIn">
                
                <!-- Pending Icon -->
                <div class="mb-6 text-center">
                    <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mx-auto animate-pulse">
                        <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>

                <!-- Status Message -->
                <div class="text-center mb-8">
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                        Application Under Review
                    </h1>
                    
                    <p class="text-lg text-gray-600 mb-2">
                        Thank you for registering with Sorted Services!
                    </p>
                    
                    <p class="text-gray-600">
                        Our team is currently reviewing your agency application.
                    </p>
                </div>

                <!-- Timeline -->
                <div class="max-w-2xl mx-auto mb-8">
                    <div class="relative">
                        <!-- Progress Line -->
                        <div class="absolute left-8 top-0 h-full w-0.5 bg-gray-200"></div>
                        
                        <!-- Step 1 - Completed -->
                        <div class="relative flex items-start mb-8">
                            <div class="flex-shrink-0 w-16 h-16 bg-green-100 rounded-full flex items-center justify-center z-10">
                                <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div class="ml-6 flex-1">
                                <h3 class="text-lg font-semibold text-gray-900">Application Submitted</h3>
                                <p class="text-sm text-gray-600 mt-1">
                                    {{ $agency->created_at->format('d M Y, h:i A') }}
                                </p>
                                <p class="text-sm text-gray-500 mt-2">
                                    Your registration has been successfully submitted.
                                </p>
                            </div>
                        </div>
                        
                        <!-- Step 2 - Current -->
                        <div class="relative flex items-start mb-8">
                            <div class="flex-shrink-0 w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center z-10 animate-pulse">
                                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <div class="ml-6 flex-1">
                                <h3 class="text-lg font-semibold text-gray-900">Under Review</h3>
                                <p class="text-sm text-gray-600 mt-1">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        In Progress
                                    </span>
                                </p>
                                <p class="text-sm text-gray-500 mt-2">
                                    Our team is verifying your information and documents.
                                </p>
                            </div>
                        </div>
                        
                        <!-- Step 3 - Upcoming -->
                        <div class="relative flex items-start">
                            <div class="flex-shrink-0 w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center z-10">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-6 flex-1">
                                <h3 class="text-lg font-semibold text-gray-400">Approval & Activation</h3>
                                <p class="text-sm text-gray-400 mt-1">
                                    Pending
                                </p>
                                <p class="text-sm text-gray-400 mt-2">
                                    Once approved, you'll choose a subscription plan.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Agency Info Card -->
                <div class="bg-gray-50 rounded-xl p-6 mb-8">
                    <h3 class="text-sm font-semibold text-gray-500 uppercase mb-4">Submitted Information</h3>
                    
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
                            <p class="text-xs text-gray-500 mb-1">Submitted</p>
                            <p class="text-sm font-medium text-gray-900">{{ $agency->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                </div>

                <!-- What Happens Next -->
                <div class="bg-blue-50 border border-blue-200 rounded-xl p-6 mb-8">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-sm font-semibold text-blue-900 mb-2">What Happens Next?</h3>
                            <ul class="text-sm text-blue-800 space-y-2">
                                <li class="flex items-start">
                                    <svg class="w-5 h-5 text-blue-600 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span>Our team will review your agency information within <strong>24-48 hours</strong></span>
                                </li>
                                <li class="flex items-start">
                                    <svg class="w-5 h-5 text-blue-600 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span>You'll receive an email notification once your application is reviewed</span>
                                </li>
                                <li class="flex items-start">
                                    <svg class="w-5 h-5 text-blue-600 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span>Once approved, you can choose a subscription plan and start using the platform</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Expected Timeline -->
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-6 mb-8 text-center">
                    <p class="text-sm text-gray-600 mb-2">⏰ Expected Review Time</p>
                    <p class="text-2xl font-bold text-gray-900">24 - 48 hours</p>
                    <p class="text-xs text-gray-500 mt-1">Business days only</p>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
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

                <!-- Contact Support -->
                <div class="mt-8 pt-8 border-t border-gray-200 text-center">
                    <p class="text-sm text-gray-600 mb-3">
                        Have questions about your application?
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
    </style>
</body>
</html>