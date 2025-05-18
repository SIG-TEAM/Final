<x-guest-layout>
    <div class="w-full max-w-md mx-auto bg-white/80 rounded-lg shadow-lg px-12 py-12 font-sans">
        <!-- Navigation tabs -->
        <div class="flex justify-center mb-6 w-full">
            <a href="{{ route('login') }}" class="px-4 py-2 font-bold {{ request()->routeIs('login') ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-400' }}">LOGIN</a>
            <a href="{{ route('register') }}" class="px-4 py-2 font-bold {{ request()->routeIs('register') ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-400' }}">SIGN UP</a>
        </div>
        
        <form method="POST" action="{{ route('register') }}" class="w-full bg-white/0" autocomplete="off">
            @csrf

            <!-- Name -->
            <div class="mb-4">
                <label for="name" class="block text-sm font-semibold text-gray-700">{{ __('Name') }}</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-400 focus:ring-blue-400 font-sans"
                    autocomplete="off" placeholder="full name">
                @error('name')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <!-- Email Address -->
            <div class="mb-4">
                <label for="email" class="block text-sm font-semibold text-gray-700">{{ __('Email') }}</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-400 focus:ring-blue-400 font-sans"
                    autocomplete="off" placeholder="name@mail.com">
                @error('email')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <!-- Hidden Role Input -->
            <input type="hidden" name="role" value="pengguna" id="role">

            <!-- Password -->
            <div class="mb-4">
                <label for="password" class="block text-sm font-semibold text-gray-700">{{ __('Password') }}</label>
                <input id="password" type="password" name="password" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-400 focus:ring-blue-400 font-sans"
                    autocomplete="new-password" placeholder="••••••••">
                @error('password')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div class="mb-4">
                <label for="password_confirmation" class="block text-sm font-semibold text-gray-700">{{ __('Confirm Password') }}</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-400 focus:ring-blue-400 font-sans"
                    autocomplete="new-password" placeholder="••••••••">
            </div>

            <div>
                <button type="submit"
                    class="w-full bg-gradient-to-r from-blue-500 to-green-400 text-white py-2 px-4 rounded-full shadow-lg hover:scale-105 hover:from-blue-600 hover:to-green-500 transition-all duration-300 text-lg font-bold">
                    {{ __('Sign Up') }}
                </button>
            </div>
        </form>
    </div>
</x-guest-layout>
