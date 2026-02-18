<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Already Submitted - {{ config('app.name') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="max-w-md w-full bg-white rounded-lg shadow-lg p-8 text-center">
            <!-- Info Icon -->
            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-[#e6ff4b] mb-4">
                <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>

            <h1 class="text-2xl font-bold text-gray-900 mb-2">Already Submitted</h1>
            <p class="text-gray-600 mb-4">
                This employment reference has already been submitted.
            </p>
            <p class="text-sm text-gray-500">
                Thank you for providing a reference for <strong>{{ $employment->user->name }}</strong>.
            </p>
            
            <div class="mt-8 pt-6 border-t border-gray-200">
                <p class="text-xs text-gray-500">
                    Submitted on {{ $employment->reference_verified_at->format('F j, Y') }}
                </p>
            </div>
        </div>
    </div>
</body>
</html>