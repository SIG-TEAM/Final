<x-guest-layout>
    <!-- Navigasi Atas -->
    <div class="flex justify-end space-x-4 mb-6">
        <span class="text-gray-800 font-bold">LOG IN</span>
        <a href="{{ route('register') }}" class="text-gray-500 hover:text-gray-800">SIGN UP</a>
    </div>

    <!-- Container Form -->
    <div class="max-w-md mx-auto bg-gray-100 p-8 rounded-lg shadow-md">
        <!-- Judul -->
        <h2 class="text-3xl font-bold text-center mb-6">Log In</h2>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4 text-center text-green-600" :status="session('status')" />

        <!-- Form -->
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Username -->
            <div class="mb-4">
                <x-text-input id="username" 
                              class="block w-full p-3 rounded-lg border-gray-300 focus:ring-0 focus:border-gray-500" 
                              type="text" 
                              name="username" 
                              placeholder="USERNAME" 
                              :value="old('username')" 
                              required 
                              autofocus 
                              autocomplete="username" />
                <x-input-error :messages="$errors->get('username')" class="mt-2 text-red-600" />
            </div>

            <!-- Password -->
            <div class="mb-6">
                <x-text-input id="password" 
                              class="block w-full p-3 rounded-lg border-gray-300 focus:ring-0 focus:border-gray-500" 
                              type="password" 
                              name="password" 
                              placeholder="PASSWORD" 
                              required 
                              autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-600" />
            </div>

            <!-- Tombol Login -->
            <div>
                <x-primary-button class="w-full p-3 bg-white text-gray-800 border border-gray-300 rounded-lg hover:bg-gray-200">
                    {{ __('LOGIN') }}
                </x-primary-button>
            </div>

            <!-- Link Lupa Password -->
            @if (Route::has('password.request'))
                <div class="text-center mt-4">
                    <a class="text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                        {{ __('Lupa Password?') }}
                    </a>
                </div>
            @endif
        </form>
    </div>
</x-guest-layout>