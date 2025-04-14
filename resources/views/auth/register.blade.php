<x-guest-layout>
    <div class="w-full max-w-md mx-auto bg-white rounded-lg">
        <!-- Navigation tabs -->
        <div class="flex justify-center mb-6">
            <a href="{{ route('login') }}" class="px-4 py-2 font-bold {{ request()->routeIs('login') ? 'text-gray-800 border-b-2 border-gray-800' : 'text-gray-400' }}">LOG IN</a>
            <a href="{{ route('register') }}" class="px-4 py-2 font-bold {{ request()->routeIs('register') ? 'text-gray-800 border-b-2 border-gray-800' : 'text-gray-400' }}">SIGN UP</a>
        </div>
        
        <h2 class="text-center text-2xl font-bold text-gray-800 mb-4">{{ __('Sign Up') }}</h2>
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">{{ __('Name') }}</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                @error('name')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <!-- Email Address -->
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">{{ __('Email') }}</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                @error('email')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <!-- Role Selection -->
            <div class="mb-4">
                <label for="role" class="block text-sm font-medium text-gray-700">{{ __('Register as') }}</label>
                <select id="role" name="role" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="penduduk" {{ old('role') == 'penduduk' ? 'selected' : '' }}>Penduduk</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="pengurus" {{ old('role') == 'pengurus' ? 'selected' : '' }}>Pengurus</option>
                </select>
                @error('role')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">{{ __('Password') }}</label>
                <input id="password" type="password" name="password" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                @error('password')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div class="mb-4">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">{{ __('Confirm Password') }}</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>

            <div>
                <button type="submit"
                    class="w-full bg-gray-800 text-white py-2 px-4 rounded-full hover:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 text-sm font-semibold">
                    {{ __('Register') }}
                </button>
            </div>
        </form>

        <div class="mt-4 text-center">
            <p class="text-sm text-gray-600">
                {{ __('Already have an account?') }}
                <a href="{{ route('login') }}" class="text-gray-800 hover:underline">{{ __('Log In') }}</a>
            </p>
        </div>
    </div>
</x-guest-layout>
