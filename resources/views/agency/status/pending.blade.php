<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Under Review - Sorted Services</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-gray-50 via-white to-blue-50">
    <div class="min-h-screen py-8 px-4">
        <div class="max-w-5xl mx-auto">
            
            @php
                // Get all document requirements
                $allDocuments = $agency->documentRequirements ?? collect();
                $rejectedDocuments = $allDocuments->where('status', 'rejected');
                $hasRejectedDocuments = $rejectedDocuments->count() > 0;
            @endphp

            <!-- Rejected Documents Alert (if any) -->
            @if($hasRejectedDocuments)
            <div class="bg-red-50 border-l-4 border-red-500 rounded-xl p-6 mb-6 shadow-lg animate-fadeIn">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                            <svg class="w-7 h-7 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4 flex-1">
                        <h3 class="text-xl font-bold text-red-900 mb-1">⚠️ Action Required: Documents Need Attention</h3>
                        <p class="text-sm text-red-700 mb-3">
                            {{ $rejectedDocuments->count() }} {{ $rejectedDocuments->count() === 1 ? 'document has' : 'documents have' }} been rejected and need to be corrected. Please review the feedback below and reupload the required documents.
                        </p>
                        <a href="#rejected-documents" 
                           class="inline-flex items-center px-4 py-2 bg-red-600 text-white text-sm font-semibold rounded-lg hover:bg-red-700 transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                            View Rejected Documents
                        </a>
                    </div>
                </div>
            </div>
            @endif
            
            <!-- Pending Card -->
            <div class="bg-white rounded-2xl shadow-xl p-8 md:p-12 animate-fadeIn mb-8">
                
                <!-- Pending Icon -->
                <div class="mb-6 text-center">
                    <div class="w-20 h-20 {{ $hasRejectedDocuments ? 'bg-orange-100' : 'bg-blue-100' }} rounded-full flex items-center justify-center mx-auto {{ $hasRejectedDocuments ? '' : 'animate-pulse' }}">
                        <svg class="w-10 h-10 {{ $hasRejectedDocuments ? 'text-orange-600' : 'text-blue-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            @if($hasRejectedDocuments)
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            @else
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            @endif
                        </svg>
                    </div>
                </div>

                <!-- Status Message -->
                <div class="text-center mb-8">
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                        {{ $hasRejectedDocuments ? 'Documents Need Attention' : 'Application Under Review' }}
                    </h1>
                    
                    @if($hasRejectedDocuments)
                    <p class="text-lg text-orange-600 mb-2 font-semibold">
                        Please correct and reupload the rejected documents below
                    </p>
                    @else
                    <p class="text-lg text-gray-600 mb-2">
                        Thank you for registering with Sorted Services!
                    </p>
                    @endif
                    
                    <p class="text-gray-600">
                        {{ $hasRejectedDocuments ? 'Our team has reviewed your documents. Some need corrections before we can proceed.' : 'Our team is currently reviewing your agency application.' }}
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
                            <div class="flex-shrink-0 w-16 h-16 {{ $hasRejectedDocuments ? 'bg-orange-100' : 'bg-blue-100' }} rounded-full flex items-center justify-center z-10 {{ $hasRejectedDocuments ? '' : 'animate-pulse' }}">
                                <svg class="w-8 h-8 {{ $hasRejectedDocuments ? 'text-orange-600' : 'text-blue-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <div class="ml-6 flex-1">
                                <h3 class="text-lg font-semibold text-gray-900">{{ $hasRejectedDocuments ? 'Document Corrections Needed' : 'Under Review' }}</h3>
                                <p class="text-sm text-gray-600 mt-1">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $hasRejectedDocuments ? 'bg-orange-100 text-orange-800' : 'bg-blue-100 text-blue-800' }}">
                                        {{ $hasRejectedDocuments ? 'Action Required' : 'In Progress' }}
                                    </span>
                                </p>
                                <p class="text-sm text-gray-500 mt-2">
                                    {{ $hasRejectedDocuments ? 'Some documents need corrections. Please review and reupload them.' : 'Our team is verifying your information and documents.' }}
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

                @if(!$hasRejectedDocuments)
                <!-- What Happens Next (show only if no rejected docs) -->
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
                @endif

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    @if($hasRejectedDocuments)
                    <a href="{{ route('agency.onboarding.show', ['step' => 2]) }}" 
                       class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors shadow-lg hover:shadow-xl">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                        </svg>
                        Reupload Documents
                    </a>
                    @endif
                    
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

            <!-- Rejected Documents Section -->
            @if($hasRejectedDocuments)
            <div id="rejected-documents" class="bg-white rounded-2xl shadow-xl p-8 animate-fadeIn">
                <div class="mb-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">📋 Documents Requiring Attention</h2>
                    <p class="text-gray-600">Please review the feedback and reupload corrected documents</p>
                </div>

                <div class="space-y-4">
                    @foreach($rejectedDocuments as $doc)
                    <div class="border-2 border-red-200 rounded-xl p-6 bg-red-50">
                        <div class="flex items-start gap-4">
                            <!-- Error Icon -->
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-7 h-7 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </div>
                            </div>

                            <!-- Document Info -->
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-2">
                                    <h3 class="text-lg font-bold text-gray-900">{{ $doc->name }}</h3>
                                    @if($doc->is_required)
                                    <span class="text-xs px-2 py-0.5 bg-red-100 text-red-700 rounded-full font-bold">Required</span>
                                    @endif
                                    <span class="text-xs px-2 py-0.5 bg-red-600 text-white rounded-full font-bold">✗ Rejected</span>
                                </div>

                                <p class="text-sm text-gray-600 mb-4">{{ $doc->description }}</p>

                                <!-- Rejection Reason -->
                                <div class="bg-white border-l-4 border-red-500 rounded-lg p-4 mb-4">
                                    <p class="text-sm font-bold text-red-900 mb-1 flex items-center">
                                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                        </svg>
                                        Reason for Rejection:
                                    </p>
                                    <p class="text-sm text-red-800">{{ $doc->rejection_reason }}</p>
                                </div>

                                @if($doc->reviewed_at)
                                <p class="text-xs text-gray-500 mb-4">
                                    Reviewed {{ $doc->reviewed_at->diffForHumans() }}
                                </p>
                                @endif

                                <!-- Action Button -->
                                <a href="{{ route('agency.onboarding.show', ['step' => 2]) }}#document-{{ $doc->id }}" 
                                   class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-bold rounded-lg hover:bg-blue-700 transition-colors shadow-md hover:shadow-lg">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                                    </svg>
                                    Reupload This Document
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Help Section -->
                <div class="mt-6 bg-blue-50 border border-blue-200 rounded-xl p-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-sm font-bold text-blue-900 mb-2">Tips for Reupload:</h4>
                            <ul class="text-sm text-blue-800 space-y-1">
                                <li>• Ensure documents are clear and legible</li>
                                <li>• Files should be in PDF, JPG, or PNG format</li>
                                <li>• Maximum file size: 5MB per document</li>
                                <li>• Make sure all information is up-to-date</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            @endif
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

        html {
            scroll-behavior: smooth;
        }
    </style>
</body>
</html>