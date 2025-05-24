<x-landing-layout>
    <div class="relative w-full h-screen flex items-center justify-center bg-white overflow-hidden">
        <img src="/images/landingPage/Village.jpg" alt="Village" class="object-cover w-full h-full absolute inset-0 z-0" />
        <div class="absolute inset-0 bg-black bg-opacity-50 z-10"></div>
        
        <!-- Navbar -->
        <nav class="absolute top-0 left-0 w-full flex items-center justify-between px-8 py-4 z-50 bg-white/10 backdrop-blur-md">
            <span class="text-2xl font-bold text-white drop-shadow ml-8">NUSA</span>
            <a href="{{ route('login') }}" 
               class="px-6 py-2 rounded-full bg-gradient-to-r from-blue-500 to-green-400 text-white font-semibold shadow hover:from-blue-600 hover:to-green-500 transition mr-8">
                Login
            </a>
        </nav>
        
        <div class="relative z-30 flex flex-col items-center justify-center px-12 py-12 w-auto max-w-lg bg-white/80 rounded-lg shadow-lg">
            <h1 class="text-5xl font-extrabold mb-4 text-gray-800 drop-shadow-lg">
                Welcome to <span class="text-blue-400">Cileunyi Kulon</span>
            </h1>
            <p class="text-xl text-gray-600 mb-8 drop-shadow">
                Discover amazing features and join our community today.<br>
                <span class="text-blue-500">Start your journey with us!</span>
            </p>
        </div>
    </div>
</x-landing-layout>