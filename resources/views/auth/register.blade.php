<x-guest-layout>
    <div class="w-full max-w-md mx-auto bg-white/95 rounded-[16px] shadow-lg px-10 py-10 font-[Poppins,sans-serif] border border-[#E5E7EB]" style="backdrop-filter:blur(10px);">
        <!-- Navigation tabs -->
        <div class="flex justify-center mb-6 w-full">
            <a href="{{ route('login') }}" class="px-4 py-2 font-bold {{ request()->routeIs('login') ? 'text-[#059669] border-b-2 border-[#059669]' : 'text-gray-400' }}">LOGIN</a>
            <a href="{{ route('register') }}" class="px-4 py-2 font-bold {{ request()->routeIs('register') ? 'text-[#059669] border-b-2 border-[#059669]' : 'text-gray-400' }}">SIGN UP</a>
        </div>
        
        <form method="POST" action="{{ route('register') }}" class="w-full bg-white/0" autocomplete="off">
            @csrf

            <!-- Name -->
            <div class="mb-4">
                <label for="name" class="block text-sm font-semibold text-[#047857]">{{ __('Name') }}</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                    class="mt-1 block w-full rounded-[12px] border-2 border-[#D1D5DB] bg-[#FAFAFA] shadow-sm focus:border-[#059669] focus:ring-[#059669] font-[Inter,sans-serif] px-4 py-3"
                    autocomplete="off" placeholder="full name">
                @error('name')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <!-- Email Address -->
            <div class="mb-4">
                <label for="email" class="block text-sm font-semibold text-[#047857]">{{ __('Email') }}</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required
                    class="mt-1 block w-full rounded-[12px] border-2 border-[#D1D5DB] bg-[#FAFAFA] shadow-sm focus:border-[#059669] focus:ring-[#059669] font-[Inter,sans-serif] px-4 py-3"
                    autocomplete="off" placeholder="name@mail.com">
                @error('email')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <!-- Hidden Role Input -->
            <input type="hidden" name="role" value="pengguna" id="role">

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

            <!-- Confirm Password -->
            <div class="mb-4">
                <label for="password_confirmation" class="block text-sm font-semibold text-[#047857]">{{ __('Confirm Password') }}</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required
                    class="mt-1 block w-full rounded-[12px] border-2 border-[#D1D5DB] bg-[#FAFAFA] shadow-sm focus:border-[#059669] focus:ring-[#059669] font-[Inter,sans-serif] px-4 py-3"
                    autocomplete="new-password" placeholder="••••••••">
            </div>

            <div>
                <button type="submit"
                    class="w-full bg-gradient-to-r from-[#059669] to-[#047857] text-white py-3 px-4 rounded-[10px] shadow-lg hover:scale-105 hover:shadow-lg transition-all duration-300 text-lg font-bold">
                    {{ __('Sign Up') }}
                </button>
            </div>
        </form>
    </div>
</x-guest-layout>
