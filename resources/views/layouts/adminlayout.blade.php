<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title> Sistem Informasi Geografis - {{ $title ?? 'Welcome' }} </title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        
        <!-- Additional styles for each page -->
        @yield('styles')
        
        <!-- Additional head content -->
        @yield('head')
    </head>
    <body class="p-0 m-0 font-sans antialiased bg-gray-100" x-data="{ sidebarOpen: false }" @yield('body_attributes')>
        <div class="relative min-h-screen">
            <!-- Admin Sidebar -->
            <div x-show="sidebarOpen" 
                 x-transition:enter="transition-transform duration-300"
                 x-transition:enter-start="-translate-x-full"
                 x-transition:enter-end="translate-x-0"
                 x-transition:leave="transition-transform duration-300"
                 x-transition:leave-start="translate-x-0"
                 x-transition:leave-end="-translate-x-full"
                 class="fixed left-0 z-30 flex-shrink-0 w-64 h-full text-white bg-gray-800 rounded-r-xl">
                <div class="flex items-center justify-between p-4 text-lg font-bold border-b border-gray-700">
                    <span>Admin Panel</span>
                    <button @click="sidebarOpen = false" class="text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <nav class="mt-4">
                    <ul class="space-y-2">
                        <li class="hover:bg-slate-500">
                            <a href="{{ route('admin.dashboard') }}" class="block py-2.5 px-4 rounded">
                                 Dashboard
                            </a>
                        </li>
                        <li class="hover:bg-slate-500">
                            <a href="{{ route('kategori.index') }}" class="block py-2.5 px-4 rounded">
                                Kategori Potensi
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
            
            <!-- Floating Hamburger Button -->
            <button 
                @click="sidebarOpen = !sidebarOpen" 
                class="fixed left-0 z-40 p-3 text-white transition-all duration-300 -translate-y-1/2 rounded-full top-1/2 hover:shadow-lg hover:bg-gray-700 focus:outline-none"
                :class="{'translate-x-64': sidebarOpen}">
                <svg class="w-5 h-5 text-black hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </button>
            
            <!-- Main Content Area -->
            <div class="flex-1 transition-all duration-300" :class="{ 'ml-64': sidebarOpen }">
                <!-- Include navbar component if needed -->
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
        </div>
        
    </body>
</html>
