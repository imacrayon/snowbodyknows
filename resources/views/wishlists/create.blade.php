<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 space-y-6 sm:px-6 lg:px-8">
        <x-slot name="title">
            {{ __('New wishlist') }}
        </x-slot>
        <x-slot name="header">
            <x-back href="{{ route('wishlists.index') }}">{{ __('Wishlists') }}</x-back>
            <h1 class="font-semibold text-xl text-gray-800 leading-tight inline-flex items-center">
                {{ __('New wishlist') }}
            </h1>
        </x-slot>
        <x-form method="post" action="{{ route('wishlists.store', $wishlist) }}">
            @include('wishlists._fields')
            <x-button-primary class="mt-8">{{ __('Create wishlist') }}</x-button-primary>
        </x-form>
    </div>
</x-app-layout>
