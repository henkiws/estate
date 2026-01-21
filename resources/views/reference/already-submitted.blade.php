<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Already Submitted - Plyform</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    
    <div class="min-h-screen flex items-center justify-center py-12 px-4">
        <div class="max-w-md w-full bg-white shadow-xl rounded-2xl p-8 text-center">
            
            <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-12 h-12 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            
            <h1 class="text-2xl font-bold text-gray-900 mb-3">Already Submitted</h1>
            <p class="text-gray-600 mb-2">You have already submitted your reference for this applicant.</p>
            <p class="text-sm text-gray-500 mb-6">
                Submitted on {{ $submittedAt->format('F j, Y \a\t g:i A') }}
            </p>
            
            <p class="text-sm text-gray-600">
                If you need to make changes, please contact support.
            </p>
            
            <a href="mailto:support@plyform.com" class="mt-4 inline-flex items-center gap-2 text-blue-600 hover:text-blue-700 font-semibold">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                Contact Support
            </a>
        </div>
    </div>
    
</body>
</html>