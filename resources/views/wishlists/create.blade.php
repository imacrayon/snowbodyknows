<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 space-y-6 sm:px-6 lg:px-8">
        <x-slot name="title">
            {{ __('New wishlist') }}
        </x-slot>
        <x-slot name="header">
            <h1 class="font-semibold text-xl text-gray-800 leading-tight inline-flex items-center">
                <a class="pr-2" href="{{ route('wishlists.index') }}">
                    <x-phosphor-arrow-left aria-hidden="true" width="20" height="20" class="text-gray-400 hover:text-gray-500" />
                    <span class="sr-only">Back to wishlists</span>
                </a>
                {{ __('New wishlist') }}
            </h1>
        </x-slot>
        <x-form method="post" action="{{ route('wishlists.store', $wishlist) }}">
            @include('wishlists._fields')
            <x-button-primary class="mt-8">{{ __('Create wishlist') }}</x-button-primary>
        </x-form>
    </div>
</x-app-layout>
