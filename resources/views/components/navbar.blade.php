<nav class="sticky top-0 left-0 w-full flex flex-row items-center px-0 py-1 z-50 bg-white shadow" style="font-family:Poppins,sans-serif;">
    <div class="flex-shrink-0 pl-6">
        <a href="/" class="flex items-center">
            <x-application-logo class="h-12 w-auto" style="max-height:56px; min-width:56px; width:auto; height:auto;" />
        </a>
    </div>
    <div class="flex flex-1 items-center justify-center gap-4">
        <div class="flex items-center gap-4">
            <x-nav-link 
                :active="request()->is('/')" 
                href="/" 
                class="{{ request()->is('/') 
                    ? 'bg-gradient-to-r from-[#059669] to-[#047857] text-white font-bold drop-shadow rounded-full px-4 py-2 transition transform hover:-translate-y-1 hover:scale-105 hover:shadow-lg duration-300'
                    : 'text-[#6B7280] font-bold drop-shadow bg-white/20 rounded-full px-4 py-2 hover:bg-gradient-to-r hover:from-[#059669] hover:to-[#047857] hover:text-white hover:-translate-y-1 hover:scale-105 hover:shadow-lg transition duration-300' }}">
                All
            </x-nav-link>
            @foreach($categories as $category)
                @php
                    $active = request()->is('category/' . strtolower($category->nama));
                @endphp
                <x-nav-link 
                    :active="$active"
                    href="{{ route('category.show', strtolower($category->nama)) }}"
                    class="{{ $active 
                        ? 'bg-gradient-to-r from-[#059669] to-[#047857] text-white font-bold drop-shadow rounded-full px-4 py-2 transition transform hover:-translate-y-1 hover:scale-105 hover:shadow-lg duration-300'
                        : 'text-[#6B7280] font-bold drop-shadow bg-white/20 rounded-full px-4 py-2 hover:bg-gradient-to-r hover:from-[#059669] hover:to-[#047857] hover:text-white hover:-translate-y-1 hover:scale-105 hover:shadow-lg transition duration-300' }}">
                    {{ $category->nama }}
                </x-nav-link>
            @endforeach
        </div>
    </div>
    <div class="flex items-center gap-4 pr-6">
        @auth
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" @click.away="open = false" 
                        class="flex items-center gap-2 px-6 py-2 text-sm font-semibold text-white bg-gradient-to-r from-[#059669] to-[#047857] rounded-full drop-shadow hover:scale-105 hover:shadow-lg transition-all duration-300">
                    <span class="text-white font-semibold drop-shadow">{{ Auth::user()->name }}</span>
                    <span>▼</span>
                </button>
                <div x-show="open" 
                     class="absolute right-0 top-[110%] w-[180px] rounded-md shadow-lg py-2 z-50 bg-gradient-to-r from-[#059669] to-[#047857]"
                     style="display: none;">
                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-white hover:bg-white/20">Profile</a>
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-white hover:bg-white/20">Admin Dashboard</a>
                    @elseif(auth()->user()->role === 'pengurus')
                        <a href="{{ route('pengurus.dashboard') }}" class="block px-4 py-2 text-sm text-white hover:bg-white/20">Pengurus Dashboard</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full px-4 py-2 text-sm text-left text-white hover:bg-white/20">
                            Log Out
                        </button>
                    </form>
                </div>
            </div>
        @else
            <a href="{{ route('register') }}" class="px-6 py-2 text-sm font-semibold text-white bg-gradient-to-r from-[#059669] to-[#047857] rounded-full drop-shadow hover:scale-105 hover:shadow-lg transition-all duration-300">Register</a>
            <a href="{{ route('login') }}" class="px-6 py-2 text-sm font-semibold rounded-full drop-shadow transition bg-gradient-to-r from-[#059669] to-[#047857] text-white hover:scale-105 hover:shadow-lg">Login</a>
        @endauth
    </div>
</nav>