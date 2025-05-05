<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Request to Become a Penduduk') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Submit a request to become a registered penduduk. Your request will be reviewed by the administrator.") }}
        </p>
    </header>

    @if (Auth::user()->status_permintaan === 'pending')
        <div class="mt-6 p-4 bg-yellow-100 border border-yellow-300 rounded-md">
            <p class="text-sm text-yellow-800">
                {{ __('Your request is currently pending. Please wait for the administrator to review it.') }}
            </p>
        </div>
    @elseif (Auth::user()->role !== 'pengguna')
        <div class="mt-6 p-4 bg-red-100 border border-red-300 rounded-md">
            <p class="text-sm text-red-800">
                {{ __('You are not eligible to request a role change.') }}
            </p>
        </div>
    @else
        <form method="post" action="{{ route('profile.requestRoleChange') }}" class="mt-6 space-y-6">
            @csrf

            <div>
                <x-input-label for="reason" :value="__('Reason for Request (Optional)')" />
                <textarea id="reason" name="reason" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm"></textarea>
                <x-input-error class="mt-2" :messages="$errors->get('reason')" />
            </div>

            <div class="flex items-center gap-4">
                <x-primary-button>{{ __('Submit Request') }}</x-primary-button>

                @if (session('status') === 'request-sent')
                    <p
                        x-data="{ show: true }"
                        x-show="show"
                        x-transition
                        x-init="setTimeout(() => show = false, 2000)"
                        class="text-sm text-gray-600"
                    >{{ __('Your request has been sent.') }}</p>
                @endif
            </div>
        </form>
    @endif
</section>