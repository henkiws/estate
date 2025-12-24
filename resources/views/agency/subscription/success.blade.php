<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subscription Successful</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-plyform-mint/20 via-white to-plyform-purple/10">
<div class="min-h-screen flex items-center justify-center p-4">
    <div class="max-w-2xl w-full">
        <!-- Success Card -->
        <div class="bg-white rounded-2xl shadow-xl p-8 md:p-12 text-center animate-fadeIn">
            
            <!-- Success Icon -->
            <div class="mb-6">
                <div class="w-20 h-20 bg-plyform-mint/30 rounded-full flex items-center justify-center mx-auto">
                    <svg class="w-10 h-10 text-plyform-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
            </div>

            <!-- Success Message -->
            <h1 class="text-3xl md:text-4xl font-bold text-plyform-dark mb-4">
                🎉 Welcome to Plyform!
            </h1>
            
            <p class="text-lg text-gray-600 mb-8">
                Your subscription to the <strong class="text-plyform-purple">{{ $plan->name }} Plan</strong> has been successfully activated!
            </p>

            <!-- Subscription Details -->
            <div class="bg-gradient-to-br from-plyform-purple/10 to-plyform-mint/10 rounded-xl p-6 mb-8 text-left border-2 border-plyform-purple/30">
                <h3 class="text-sm font-semibold text-plyform-dark uppercase mb-4">Subscription Details</h3>
                
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Plan:</span>
                        <span class="font-semibold text-plyform-dark">{{ $plan->name }}</span>
                    </div>
                    
                    <div class="flex justify-between">
                        <span class="text-gray-600">Billing Cycle:</span>
                        <span class="font-semibold text-plyform-dark capitalize">{{ $session->metadata->billing_cycle ?? 'Monthly' }}</span>
                    </div>
                    
                    <div class="flex justify-between">
                        <span class="text-gray-600">Amount:</span>
                        <span class="font-semibold text-plyform-dark">${{ number_format($session->amount_total / 100, 2) }} AUD</span>
                    </div>
                    
                    <div class="flex justify-between">
                        <span class="text-gray-600">Status:</span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-plyform-mint/30 text-plyform-dark">
                            Active
                        </span>
                    </div>
                </div>
            </div>

            <!-- What's Next -->
            <div class="bg-plyform-yellow/20 rounded-xl p-6 mb-8 text-left border border-plyform-yellow">
                <h3 class="text-sm font-semibold text-plyform-dark uppercase mb-4">🚀 What's Next?</h3>
                
                <ul class="space-y-3 text-gray-700">
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-plyform-mint mr-3 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <span><strong class="text-plyform-dark">Add Your Agents:</strong> Invite your team members to join the platform</span>
                    </li>
                    
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-plyform-mint mr-3 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <span><strong class="text-plyform-dark">List Properties:</strong> Start adding your property listings</span>
                    </li>
                    
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-plyform-mint mr-3 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <span><strong class="text-plyform-dark">Customize Profile:</strong> Complete your agency profile and branding</span>
                    </li>
                    
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-plyform-mint mr-3 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <span><strong class="text-plyform-dark">Explore Features:</strong> Discover all the tools available to you</span>
                    </li>
                </ul>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('agency.dashboard') }}" 
                   class="inline-flex items-center justify-center px-8 py-3 bg-gradient-to-r from-plyform-purple to-plyform-dark text-white font-semibold rounded-xl hover:from-plyform-purple/90 hover:to-plyform-dark/90 transition-colors shadow-lg hover:shadow-xl">
                    Go to Dashboard
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                    </svg>
                </a>
                
                <a href="{{ route('agency.documents') }}" 
                   class="inline-flex items-center justify-center px-8 py-3 bg-gradient-to-r from-plyform-yellow to-plyform-mint text-plyform-dark font-semibold rounded-xl hover:from-plyform-yellow/90 hover:to-plyform-mint/90 transition-colors shadow-lg hover:shadow-xl">
                    Upload Documents
                </a>
            </div>

            <!-- Email Confirmation Notice -->
            <p class="text-sm text-gray-600 mt-8">
                📧 A confirmation email with your receipt has been sent to <strong class="text-plyform-dark">{{ $agency->business_email }}</strong>
            </p>
        </div>

        <!-- Help Section -->
        <div class="mt-8 text-center">
            <p class="text-gray-600">
                Need help getting started? 
                <a href="#" class="text-plyform-purple hover:text-plyform-dark font-medium">Contact Support</a> 
                or check out our 
                <a href="#" class="text-plyform-purple hover:text-plyform-dark font-medium">Getting Started Guide</a>
            </p>
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