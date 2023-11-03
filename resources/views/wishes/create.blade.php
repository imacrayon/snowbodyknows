<x-app-layout>
<x-slot name="title">
    {{ __('Add to :wishlist', ['wishlist' => $wishlist->name]) }}
</x-slot>
<x-slot name="header">
    <h1 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Add to :wishlist', ['wishlist' => $wishlist->name]) }}
    </h1>
</x-slot>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="p-4 sm:p-8 bg-white shadow rounded-lg">
        <div class="max-w-xl">
            <x-form method="post" action="{{ route('wishes.store', $wishlist) }}">
                @include('wishes._fields')
                <x-button-primary class="mt-8">{{ __('Add wish') }}</x-button-primary>
            </x-form>
        </div>
    </div>
</div>
</x-app-layout>
