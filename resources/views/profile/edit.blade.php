<x-app-layout>
    @section('content')
    <div class="py-12">
        <div class="mx-auto space-y-6 max-w-7xl sm:px-6 lg:px-8">
            {{-- Update profile information --}}
            <div class="p-4 bg-white shadow sm:p-8 sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>
            {{-- Update password --}}
            <div class="p-4 bg-white shadow sm:p-8 sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>
            {{-- Delete user account --}}
            <div class="p-4 bg-white shadow sm:p-8 sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
            {{-- Request penduduk (khusus pengguna) --}}
            @if (Auth::check() && Auth::user()->role === 'pengguna')
                <div class="p-4 bg-white shadow sm:p-8 sm:rounded-lg">
                    <div class="max-w-xl">
                        @include('profile.partials.request-penduduk-form')
                    </div>
                </div>
            @endif
            {{-- Manage role requests (khusus admin) --}}
            @if (Auth::check() && Auth::user()->role === 'admin')
                <div class="p-4 bg-white shadow sm:p-8 sm:rounded-lg">
                    <div class="max-w-4xl">
                        @include('profile.partials.manage-role-requests', ['requests' => $requests])
                    </div>
                </div>
            @endif
        </div>
    </div>
    @endsection
</x-app-layout>