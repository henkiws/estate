<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You - Plyform</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <div class="max-w-2xl mx-auto py-16 px-4">
        
        <!-- Logo -->
        <div class="text-center mb-8">
            <img src="{{ asset('images/logo.png') }}" alt="Plyform" class="h-12 mx-auto">
        </div>

        <!-- Thank You Card -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="bg-red-600 text-white p-6">
                <h1 class="text-3xl font-bold">Thank you</h1>
            </div>

            <div class="p-8">
                <p class="text-lg font-semibold text-gray-900 mb-4">Your reference was submitted</p>
                
                <p class="text-gray-700 mb-6">
                    This feedback was sent to agencies processing your application. Your information will only be shared back with rental agencies managing the property.
                </p>

                <div class="text-center mt-8">
                    <svg class="w-20 h-20 text-green-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <p class="text-center text-gray-500 text-sm mt-8">
            &copy; {{ date('Y') }} Plyform. All rights reserved.
        </p>
    </div>
</body>
</html>