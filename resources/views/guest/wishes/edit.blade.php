<x-guest-wishes-layout>
<x-slot name="title">
    {{ __('Edit wish') }}
</x-slot>
<x-slot name="header">
    <x-back href="{{ route('guest.wishlists.show') }}">{{ $wishlist->name }}</x-back>
    <h1 class="font-semibold text-xl text-gray-800 leading-tight inline-flex items-center">
        {{ __('Edit wish') }}
    </h1>
</x-slot>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="p-4 sm:p-8 bg-white shadow rounded-lg">
        <div class="max-w-xl">
            <x-form method="patch" action="{{ route('guest.wishes.update', [$wish->id]) }}">
                @include('wishes._fields')
                <x-button-primary class="mt-8">Save changes</x-button-primary>
            </x-form>
        </div>
    </div>
</div>
</x-guest-wishes-layout>

