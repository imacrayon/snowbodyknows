<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 space-y-6 sm:px-6 lg:px-8">
        <x-slot name="title">
            {{ __('New wishlist') }}
        </x-slot>
        <x-slot name="header">
            <h1 class="font-semibold text-xl text-gray-800 leading-tight inline-flex items-center">
                <a class="pr-2" href="{{ route('wishlists.index') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="18" height="18" class="text-gray-400 hover:text-gray-400">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                    </svg>
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
