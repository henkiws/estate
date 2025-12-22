<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Auth Page' }} - plyform</title>

    {{-- Vite + Tailwind --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fadeIn {
            animation: fadeIn 0.6s ease-out;
        }

        .gradient-text {
            background: linear-gradient(135deg, #E6FF4B, #5E17EB);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-plyform-mint via-white to-plyform-mint/50 min-h-screen flex items-center justify-center p-4">

    {{ $slot }}

</body>
</html>