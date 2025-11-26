@extends('layouts.admin')

@section('title', 'Welcome to Sorted - Step 1 of 2')

@section('content')

<div class="max-w-4xl mx-auto">
    <!-- Progress Bar -->
    <div class="mb-8">
        <div class="flex items-center justify-between mb-2">
            <span class="text-sm font-medium text-gray-700">Step {{ $currentStep }} of 2</span>
            <span class="text-sm font-medium text-primary">50% Complete</span>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-3">
            <div class="bg-primary h-3 rounded-full transition-all duration-500" style="width: 50%"></div>
        </div>
    </div>

    <!-- Welcome Card -->
    <div class="bg-white rounded-2xl shadow-xl p-8 sm:p-12">
        
        <!-- Celebration Icon -->
        <div class="flex justify-center mb-6">
            <div class="w-24 h-24 bg-gradient-to-br from-green-400 to-green-600 rounded-full flex items-center justify-center animate-bounce">
                <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>

        <!-- Title -->
        <h1 class="text-4xl font-bold text-gray-900 text-center mb-4">
            🎉 Welcome to Sorted, {{ $agency->agency_name }}!
        </h1>
        
        <p class="text-xl text-gray-600 text-center mb-8">
            Complete these simple steps to get started
        </p>

        <!-- What's Next Section -->
        <div class="bg-blue-50 border border-blue-200 rounded-xl p-6 mb-8">
            <h2 class="text-lg font-bold text-blue-900 mb-4 flex items-center">
                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
                Here's What Happens Next:
            </h2>
            
            <div class="space-y-4">
                <!-- Step 1 -->
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
                    <div class="flex-shrink-0 w-8 h-8 bg-primary text-white rounded-full flex items-center justify-center font-bold text-sm">
                        2
                    </div>
                    <div class="ml-4 flex-1">
                        <h3 class="font-semibold text-gray-900">Step 2: Upload Documents</h3>
                        <p class="text-sm text-gray-600">Upload 5 required documents for verification (Real Estate License, ABN, Insurance, etc.)</p>
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
            <h3 class="font-bold text-gray-900 mb-4">Your Registration Details:</h3>
            <div class="grid md:grid-cols-2 gap-4 text-sm">
                <div>
                    <span class="text-gray-600">Agency Name:</span>
                    <span class="font-medium text-gray-900 ml-2">{{ $agency->agency_name }}</span>
                </div>
                <div>
                    <span class="text-gray-600">ABN:</span>
                    <span class="font-medium text-gray-900 ml-2">{{ $agency->abn }}</span>
                </div>
                <div>
                    <span class="text-gray-600">State:</span>
                    <span class="font-medium text-gray-900 ml-2">{{ $agency->state }}</span>
                </div>
                <div>
                    <span class="text-gray-600">Business Email:</span>
                    <span class="font-medium text-gray-900 ml-2">{{ $agency->business_email }}</span>
                </div>
                <div>
                    <span class="text-gray-600">License Number:</span>
                    <span class="font-medium text-gray-900 ml-2">{{ $agency->license_number }}</span>
                </div>
                <div>
                    <span class="text-gray-600">License Holder:</span>
                    <span class="font-medium text-gray-900 ml-2">{{ $agency->license_holder_name }}</span>
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
        <div class="text-center mb-8">
            <div class="inline-flex items-center px-4 py-2 bg-purple-50 border border-purple-200 rounded-full">
                <svg class="w-5 h-5 text-purple-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="text-sm font-medium text-purple-800">Estimated time: 5-10 minutes</span>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-4">
            <form action="{{ route('agency.onboarding.complete-step1') }}" method="POST" class="flex-1">
                @csrf
                <button type="submit" class="w-full py-4 bg-primary hover:bg-primary-dark text-white font-semibold rounded-xl shadow-lg transition-all hover:-translate-y-0.5 flex items-center justify-center">
                    Get Started - Upload Documents
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                    </svg>
                </button>
            </form>
        </div>

        <!-- Skip Link (Optional) -->
        <div class="text-center mt-6">
            <form action="{{ route('agency.onboarding.skip') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="text-sm text-gray-500 hover:text-gray-700">
                    I'll upload documents later
                </button>
            </form>
        </div>
    </div>

    <!-- Footer Help -->
    <div class="text-center mt-6 text-sm text-gray-500">
        <p>Need help? <a href="#" class="text-primary hover:underline">Contact Support</a></p>
    </div>
</div>

<style>
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

@endsection