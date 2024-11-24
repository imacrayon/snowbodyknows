<x-layout.app title="{{ __('Add to :wishlist', ['wishlist' => $wishlist->name]) }}">
<x-slot name="header">
    <h1 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Add to :wishlist', ['wishlist' => $wishlist->name]) }}
    </h1>
</x-slot>
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="p-4 sm:p-8 bg-white shadow rounded-lg">
        <div class="max-w-xl">
            <x-form method="post" action="{{ route('wishes.store', $wishlist) }}">
                @include('wishes._fields')
                <div class="mt-8 flex items-center gap-4">
                    <x-button-primary>{{ __('Add Wish') }}</x-button-primary>
                    <x-button-secondary href="{{ route('wishlists.show', $wishlist) }}">{{ __('Cancel') }}</x-button-secondary>
                </div>
            </x-form>
        </div>
    </div>
</div>
</x-layout.app>
