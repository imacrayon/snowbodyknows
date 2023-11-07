<x-app-layout>
    <x-slot name="header">
        <h1 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit wishlist
        </h1>
    </x-slot>
    <div class="max-w-7xl mx-auto px-4 space-y-6 sm:px-6 lg:px-8">
        <div class="p-4 sm:p-8 bg-white shadow rounded-lg">
            <div class="max-w-xl">
                <x-form method="patch" action="{{ route('wishlists.update', $wishlist) }}">
                    @include('wishlists._fields')
                    <x-button-primary class="mt-8">Save changes</x-button-primary>
                </x-form>
            </div>
        </div>
    </div>
</x-app-layout>
