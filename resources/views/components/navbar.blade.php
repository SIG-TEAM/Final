<nav class="px-4 py-2 bg-white border-b border-gray-200 shadow-sm">
    <div class="flex justify-between items-center h-[60px]">
        <!-- Left side - Logo and Title -->
        <div class="flex items-center">
            <div class="flex items-center">
                <a href="/" class="flex items-center">
                    <x-application-logo class="h-[50px] w-auto mr-3" />
                </a>
                <a href="/" class="text-xl font-semibold text-green-800 whitespace-nowrap">Potensi Desa</a>
            </div>
        </div>
        
        <!-- Category -->
        <div class="flex items-center justify-center px-4 py-2">
            <div class="flex items-center gap-4">
                <x-nav-link :active="request()->is('/')" href="/">All</x-nav-link>
                @foreach($categories as $category)
                    <x-nav-link 
                        :active="request()->is('category/' . strtolower($category->nama))" 
                        href="{{ route('category.show', strtolower($category->nama)) }}"
                    >
                        {{ $category->nama }}
                    </x-nav-link>
                @endforeach
            </div>
        </div>
        
        <!-- Right side - Auth -->
        <div class="flex items-center gap-2.5">
            @auth
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" @click.away="open = false" 
                            class="flex items-center gap-2 bg-white text-green-800 px-4 py-2 border border-green-700 rounded font-semibold text-sm">
                        <span>{{ Auth::user()->name }}</span>
                        <span>▼</span>
                    </button>
                    <div x-show="open" 
                         class="absolute right-0 top-[110%] w-[180px] bg-white rounded-md shadow-lg py-2 z-50"
                         style="display: none;">
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 text-sm">Profile</a>
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Admin Dashboard</a>
                        @elseif(auth()->user()->role === 'pengurus')
                            <a href="{{ route('pengurus.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Pengurus Dashboard</a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100 text-sm">
                                Log Out
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ route('register') }}" class="bg-white text-green-800 px-4 py-2 border border-green-700 rounded font-semibold text-sm hover:bg-gray-50">Register</a>
                <a href="{{ route('login') }}" class="bg-green-800 text-white px-4 py-2 rounded font-semibold text-sm">Login</a>
            @endauth
        </div>
    </div>
</nav>