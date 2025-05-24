<nav class="absolute top-0 left-0 w-full flex flex-row items-center px-0 py-1 z-50 bg-green-100 backdrop-blur-md">
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
                    ? 'bg-gradient-to-r from-blue-500 to-green-400 text-white font-bold drop-shadow rounded-full px-4 py-2 transition' 
                    : 'text-green-700 font-bold drop-shadow bg-white/20 rounded-full px-4 py-2 hover:bg-gradient-to-r hover:from-blue-500 hover:to-green-400 hover:text-white transition' }}">
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
                        ? 'bg-gradient-to-r from-blue-500 to-green-400 text-white font-bold drop-shadow rounded-full px-4 py-2 transition' 
                        : 'text-green-700 font-bold drop-shadow bg-white/20 rounded-full px-4 py-2 hover:bg-gradient-to-r hover:from-blue-500 hover:to-green-400 hover:text-white transition' }}">
                    {{ $category->nama }}
                </x-nav-link>
            @endforeach
        </div>
    </div>
    <div class="flex items-center gap-4 pr-6">
        @auth
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" @click.away="open = false" 
                        class="flex items-center gap-2 px-6 py-2 text-sm font-semibold text-white bg-gradient-to-r from-blue-500 to-green-400 rounded-full drop-shadow hover:from-blue-600 hover:to-green-500 transition">
                    <span class="text-white font-semibold drop-shadow">{{ Auth::user()->name }}</span>
                    <span>▼</span>
                </button>
                <div x-show="open" 
                     class="absolute right-0 top-[110%] w-[180px] rounded-md shadow-lg py-2 z-50 bg-gradient-to-r from-blue-500 to-green-400"
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
            <a href="{{ route('register') }}" class="px-6 py-2 text-sm font-semibold text-white bg-gradient-to-r from-blue-500 to-green-400 rounded-full drop-shadow hover:from-blue-600 hover:to-green-500 transition">Register</a>
            <a href="{{ route('login') }}" class="px-6 py-2 text-sm font-semibold rounded-full drop-shadow transition bg-gradient-to-r from-blue-500 to-green-400 text-white hover:from-blue-600 hover:to-green-500">Login</a>
        @endauth
    </div>
</nav>