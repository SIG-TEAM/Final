<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Manage Role Change Requests') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Review and approve requests to change user roles.") }}
        </p>
    </header>

    <div class="mt-6 space-y-6">
        @forelse ($requests as $request)
            <div class="p-4 bg-white shadow sm:rounded-lg">
                <p class="text-sm text-gray-800">
                    <strong>{{ __('User:') }}</strong> {{ $request->name }} ({{ $request->email }})
                </p>
                <p class="text-sm text-gray-800">
                    <strong>{{ __('Current Role:') }}</strong> {{ $request->role }}
                </p>
                <p class="text-sm text-gray-800">
                    <strong>{{ __('Request Status:') }}</strong> {{ $request->status_permintaan }}
                </p>

                <div class="mt-4 flex items-center gap-4">
                    <form method="post" action="{{ route('profile.approveRoleChange', $request->id) }}">
                        @csrf
                        @method('post')
                        <x-primary-button>{{ __('Approve') }}</x-primary-button>
                    </form>
                </div>
            </div>
        @empty
            <p class="text-sm text-gray-600">
                {{ __('No role change requests at the moment.') }}
            </p>
        @endforelse
    </div>
</section>