<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="w-full max-w-md mx-auto bg-white/80 rounded-lg shadow-lg px-12 py-12 font-sans">
        <!-- Navigation tabs -->
        <div class="flex justify-center mb-6 w-full">
            <a href="{{ route('login') }}" class="px-4 py-2 font-bold {{ request()->routeIs('login') ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-400' }}">LOG IN</a>
            <a href="{{ route('register') }}" class="px-4 py-2 font-bold {{ request()->routeIs('register') ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-400' }}">SIGN UP</a>
        </div>
        
        <form method="POST" action="{{ route('login') }}" class="w-full bg-white/0" autocomplete="off">
            @csrf

            <!-- Email Address -->
            <div class="mb-4">
                <label for="email" class="block text-sm font-semibold text-gray-700">{{ __('Email') }}</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-400 focus:ring-blue-400 font-sans"
                    autocomplete="off" placeholder="name@mail.com">
                @error('email')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>

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

            <!-- Remember Me -->
            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-400" name="remember">
                    <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-between mt-4">
                @if (Route::has('password.request'))
                    <a class="text-sm text-blue-600 hover:underline" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <button type="submit" class="px-8 py-2 bg-gradient-to-r from-blue-500 to-green-400 text-white font-bold rounded-full shadow-lg hover:scale-105 hover:from-blue-600 hover:to-green-500 transition-all duration-300 text-lg">
                    {{ __('Log in') }}
                </button>
            </div>
        </form>

        <div class="mt-4 text-center">
            <p class="text-sm text-gray-600">
                {{ __("Don't have an account?") }}
                <a href="{{ route('register') }}" class="text-blue-600 hover:underline font-semibold">{{ __('Sign Up') }}</a>
            </p>
        </div>
    </div>
</x-guest-layout>

