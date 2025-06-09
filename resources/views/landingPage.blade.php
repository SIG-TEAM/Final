<x-landing-layout>
    <div class="relative w-full min-h-screen flex flex-col items-center justify-center bg-[#FFFBEB] font-[Poppins,sans-serif] overflow-hidden">
        <!-- Background Image -->
        <img src="/images/landingPage/Village.jpg" alt="Village" class="object-cover w-full h-full absolute inset-0 z-0" style="filter:brightness(0.85);" />
        
        <!-- Navbar -->
        <nav class="sticky top-0 left-0 w-full flex items-center justify-between px-10 py-4 z-50 bg-white/50 backdrop-blur-md shadow"
             style="font-family:Poppins,sans-serif; border-bottom:1.5px solid #D1FAE5;">
            <span class="text-2xl font-bold ml-2 flex items-center">
                <span class="text-[#059669] mr-3 drop-shadow" style="font-family:Poppins,sans-serif;">NUSA</span>
            </span>
            <div class="flex items-center gap-4">
                <a href="{{ route('login') }}" 
                   class="px-6 py-3 rounded-[10px] bg-gradient-to-r from-[#059669] to-[#047857] text-white font-semibold shadow hover:scale-105 hover:shadow-lg transition-all duration-300"
                   style="font-family:Poppins,sans-serif; font-size:1rem;">
                    Login
                </a>
                <a href="{{ route('register') }}"
                   class="px-6 py-3 rounded-[10px] bg-gradient-to-r from-[#059669] to-[#047857] text-white font-semibold shadow hover:scale-105 hover:shadow-lg transition-all duration-300"
                   style="font-family:Poppins,sans-serif; font-size:1rem;">
                    Register
                </a>
            </div>
        </nav>
        
        <!-- Hero Section -->
        <div class="flex-1 flex flex-col items-center justify-center w-full">
            <div class="relative z-30 flex flex-col items-center justify-center px-8 py-10 w-full max-w-md min-h-[220px] bg-white/50 rounded-[16px] shadow-lg border border-[#E5E7EB] mt-16 mb-8"
                 style="backdrop-filter:blur(10px); box-sizing:border-box;">
                <h1 class="text-[2.5rem] font-extrabold mb-2 text-[#047857] drop-shadow-lg leading-tight text-center" style="font-family:Poppins,sans-serif;">
                    Welcome to <span class="text-gradient bg-gradient-to-r from-[#059669] via-[#10B981] to-[#0EA5E9] bg-clip-text text-transparent">Ciwidey</span>
                </h1>
                <a href="{{ route('welcome') }}" 
                   class="px-6 py-3 rounded-[10px] bg-[#92400E] text-white font-semibold mt-2 inline-block no-underline hover:bg-[#7C2D12] transition-all duration-300 text-[1.25rem] hover:scale-105 text-center shadow"
                   style="border-radius:10px;">
                    Start your journey with us!
                </a>
            </div>
        </div>
    </div>
</x-landing-layout>