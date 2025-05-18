<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-gray-900">
        <div class="relative flex flex-col items-center min-h-screen pt-6 bg-gray-900 sm:justify-center sm:pt-0">
            <!-- Background image with overlay -->
            <div class="absolute inset-0 z-0">
                <img src="{{ asset('images/ui/bgdesa.jpg') }}" 
                     class="object-cover w-full h-full"
                     alt="Background">
                <div class="absolute inset-0 bg-gray-900/70"></div>
            </div>

            <!-- Content -->
            <div class="relative z-10 w-full px-6 py-4 mt-6">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>