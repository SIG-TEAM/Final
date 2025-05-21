<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title> Sistem Informasi Geografis - {{ $title ?? 'Welcome' }} </title>

        <!-- icon -->
        <link rel="icon" type="image/png" href="{{ asset('images/NUSA.png') }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/NUSA.png') }}">
        <link rel="shortcut icon" type="image/png" href="{{ asset('images/NUSA.png') }}">
        
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        
        <!-- Leaflet.js -->
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
        
        <style>
            html, body {
                height: 100%;
                width: 100%;
                margin: 0;
                padding: 0;
                overflow: hidden;
            }
            #map {
                height: 100dvh;
                width: 100vw;
                min-height: 100dvh;
                min-width: 100vw;
                position: relative;
                z-index: 1;
            }
            #sidebar {
                overflow-y: auto;
                max-height: 100dvh;
                transition: width 0.3s;
                position: absolute;
                right: 0;
                top: 0;
                z-index: 50;
                background: white;
                height: 100dvh;
            }
        </style>
        
        <!-- Additional styles for each page -->
        @yield('styles')
        
        <!-- Additional head content -->
        @yield('head')
    </head>
    <body class="p-0 m-0 font-sans antialiased bg-gray-100" @yield('body_attributes')>
        <div class="min-h-screen">
            <!-- Include navbar component -->
            <x-navbar />

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                @yield('content')
            </main>
        </div>
    </body>
</html>
