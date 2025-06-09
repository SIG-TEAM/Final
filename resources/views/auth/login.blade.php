<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="w-full max-w-md mx-auto bg-white/95 rounded-[16px] shadow-lg px-10 py-10 font-[Poppins,sans-serif] border border-[#E5E7EB]" style="backdrop-filter:blur(10px);">
        <!-- Navigation tabs -->
        <div class="flex justify-center mb-6 w-full">
            <a href="{{ route('login') }}" class="px-4 py-2 font-bold {{ request()->routeIs('login') ? 'text-[#059669] border-b-2 border-[#059669]' : 'text-gray-400' }}">LOGIN</a>
            <a href="{{ route('register') }}" class="px-4 py-2 font-bold {{ request()->routeIs('register') ? 'text-[#059669] border-b-2 border-[#059669]' : 'text-gray-400' }}">SIGN UP</a>
        </div>
        
        <form method="POST" action="{{ route('login') }}" class="w-full bg-white/0" autocomplete="off">
            @csrf

            <!-- Email Address -->
            <div class="mb-4">
                <label for="email" class="block text-sm font-semibold text-[#047857]">{{ __('Email') }}</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                    class="mt-1 block w-full rounded-[12px] border-2 border-[#D1D5DB] bg-[#FAFAFA] shadow-sm focus:border-[#059669] focus:ring-[#059669] font-[Inter,sans-serif] px-4 py-3"
                    autocomplete="off" placeholder="name@mail.com">
                @error('email')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-4">
                <label for="password" class="block text-sm font-semibold text-[#047857]">{{ __('Password') }}</label>
                <input id="password" type="password" name="password" required
                    class="mt-1 block w-full rounded-[12px] border-2 border-[#D1D5DB] bg-[#FAFAFA] shadow-sm focus:border-[#059669] focus:ring-[#059669] font-[Inter,sans-serif] px-4 py-3"
                    autocomplete="new-password" placeholder="••••••••">
                @error('password')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-[#059669] shadow-sm focus:ring-[#059669]" name="remember">
                    <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-between mt-4">
                @if (Route::has('password.request'))
                    <a class="text-sm text-[#0EA5E9] hover:underline" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <button type="submit" class="px-8 py-3 bg-gradient-to-r from-[#059669] to-[#047857] text-white font-bold rounded-[10px] shadow hover:scale-105 hover:shadow-lg transition-all duration-300 text-lg">
                    {{ __('Login') }}
                </button>
            </div>
        </form>
    </div>
</x-guest-layout>

