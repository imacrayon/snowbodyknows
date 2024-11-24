<x-layout.app title="{{ __('Edit wishlist') }}">
    <x-slot name="header">
        <h1 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit wishlist') }}
        </h1>
    </x-slot>
    <div class="max-w-5xl mx-auto px-4 space-y-6 sm:px-6 lg:px-8">
        <div class="p-4 sm:p-8 bg-white shadow rounded-lg">
            <div class="max-w-xl">
                <x-form method="patch" action="{{ route('wishlists.update', $wishlist) }}">
                    @include('wishlists._fields')
                    <div class="mt-8 flex items-center gap-4">
                        <x-button-primary>{{ __('Save Changes') }}</x-button-primary>
                        <x-button-secondary href="{{ route('wishlists.show', $wishlist) }}">{{ __('Cancel') }}</x-button-secondary>
                    </div>
                </x-form>
            </div>
        </div>
    </div>
    <div class="max-w-5xl mx-auto px-4 space-y-6 mt-6 sm:px-6 lg:px-8">
        <div class="p-4 sm:p-8 bg-white shadow rounded-lg">
            <div class="max-w-xl">
                @include('wishlists.partials.delete-wishlist-form')
            </div>
        </div>
    </div>
</x-layout.app>
