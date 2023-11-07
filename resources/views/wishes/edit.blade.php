<x-app-layout>
<x-slot name="title">
    {{ __('Edit wish') }}
</x-slot>
<x-slot name="header">
    <h1 class="font-semibold text-xl text-gray-800 leading-tight inline-flex items-center">
        <a class="pr-2" href="{{ route('wishlists.show', $wish->wishlist) }}">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="18" height="18" class="text-gray-400 hover:text-gray-400">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
            </svg>
        </a>
        {{ __('Edit wish') }}
    </h1>
</x-slot>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="p-4 sm:p-8 bg-white shadow rounded-lg">
        <div class="max-w-xl">
            <x-form method="patch" action="{{ route('wishes.update', [$wishlist, $wish]) }}">
                @include('wishes._fields')
                <x-button-primary class="mt-8">Save changes</x-button-primary>
            </x-form>
        </div>
    </div>
</div>
</x-app-layout>
