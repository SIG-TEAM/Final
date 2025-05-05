<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- icons -->
        <link rel="icon" type="image/png" href="{{ asset('images/NUSA.png') }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/NUSA.png') }}">
        <link rel="shortcut icon" type="image/png" href="{{ asset('images/NUSA.png') }}">
        
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
            <div class="relative z-10">
                <a href="/">
                    <x-application-logo class="w-20 h-20 text-gray-500 fill-current" />
                </a>
            </div>

            <div class="relative z-10 w-full px-6 py-4 mt-6 overflow-hidden bg-white shadow-md sm:max-w-md sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>