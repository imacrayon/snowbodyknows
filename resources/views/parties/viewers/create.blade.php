<x-guest-layout title="{{ __('Join :party', ['party' => $party->name]) }}">
    <header>
        <h1 class="text-lg font-medium text-gray-90">{{ __('Join Party') }}</h1>
        <p class="mt-1 text-sm text-gray-600">
            {!! __('Would you like to join :party by :user?', ['party' => sprintf('<strong>%s</strong>', e($party->name)), 'user' => sprintf('<strong>%s</strong>', e($party->user->name))]) !!}
        </p>
    </header>

    <x-form class="mt-6" method="post" action="{{ route('parties.viewers.store', $party) }}">
        <div class="flex items-center gap-4">
            <x-button-primary>
                {{ __('Join') }}
            </x-button-primary>
            <x-button-secondary href="{{ route('app') }}">
                {{ __('Cancel') }}
            </x-button-secondary>
        </div>
    </x-form>
</x-guest-layout>
