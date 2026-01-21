<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You - Plyform</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'plyform-mint': '#DDEECD',
                        'plyform-dark': '#1E1C1C',
                        'plyform-yellow': '#E6FF4B',
                        'plyform-purple': '#5E17EB',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50">
    
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl w-full">
            
            <div class="bg-white shadow-2xl rounded-2xl overflow-hidden">
                
                <!-- Success Header -->
                <div class="bg-gradient-to-r from-green-400 to-green-600 p-8 text-center">
                    <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <h1 class="text-3xl font-bold text-white mb-2">Thank You!</h1>
                    <p class="text-green-50">Your reference has been submitted successfully</p>
                </div>
                
                <!-- Content -->
                <div class="p-8">
                    <div class="text-center mb-8">
                        <p class="text-lg text-gray-700 mb-4">
                            We sincerely appreciate you taking the time to provide a reference for 
                            <strong class="text-plyform-purple">{{ $user->name }}</strong>.
                        </p>
                        <p class="text-gray-600">
                            Your feedback will help property managers make an informed decision and 
                            will be kept strictly confidential.
                        </p>
                    </div>
                    
                    <!-- Info Box -->
                    <div class="bg-plyform-mint/30 border border-plyform-mint rounded-xl p-6 mb-6">
                        <div class="flex items-start gap-3">
                            <svg class="w-6 h-6 text-plyform-purple flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div>
                                <h3 class="font-semibold text-plyform-dark mb-2">What Happens Next?</h3>
                                <ul class="space-y-2 text-sm text-gray-700">
                                    <li class="flex items-start gap-2">
                                        <span class="text-green-600 mt-1">✓</span>
                                        <span>Your reference has been recorded and timestamped</span>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <span class="text-green-600 mt-1">✓</span>
                                        <span>Property managers will review your feedback as part of the application</span>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <span class="text-green-600 mt-1">✓</span>
                                        <span>You may be contacted if any clarification is needed</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Submitted Info -->
                    <div class="bg-gray-50 rounded-lg p-4 text-center text-sm text-gray-600">
                        <p>Reference submitted on {{ $reference->reference_submitted_at->format('F j, Y \a\t g:i A') }}</p>
                    </div>
                    
                    <!-- Contact Support -->
                    <div class="mt-8 text-center">
                        <p class="text-sm text-gray-600 mb-3">
                            Have questions or need to update your reference?
                        </p>
                        <a href="mailto:support@plyform.com" class="inline-flex items-center gap-2 text-plyform-purple hover:text-purple-700 font-semibold">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            Contact Support
                        </a>
                    </div>
                </div>
                
            </div>
            
            <!-- Footer -->
            <div class="mt-8 text-center">
                <p class="text-sm text-gray-500">© {{ date('Y') }} Plyform. All rights reserved.</p>
            </div>
            
        </div>
    </div>
    
</body>
</html>