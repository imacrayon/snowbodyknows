<x-layout.app title="{{ __('Edit wish') }}">
<x-slot name="header">
    <h1 class="font-semibold text-xl text-gray-800 leading-tight inline-flex items-center">
        {{ __('Edit wish') }}
    </h1>
</x-slot>
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="p-4 sm:p-8 bg-white shadow rounded-lg">
        <div class="max-w-xl">
            <x-form method="patch" action="{{ route('wishes.update', [$wishlist, $wish]) }}">
                @include('wishes._fields')
                <div class="mt-8 flex items-center gap-4">
                    <x-button-primary>{{ __('Save Changes') }}</x-button-primary>
                    <x-button-secondary href="{{ route('wishlists.show', $wish->wishlist) }}">{{ __('Cancel') }}</x-button-secondary>
                </div>
            </x-form>
        </div>
    </div>
</div>
</x-layout.app>
