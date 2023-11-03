<x-app-layout>
<x-slot name="header">
    <h1 class="font-semibold text-xl text-gray-800 leading-tight">
        Edit wishlist
    </h1>
</x-slot>
<x-form method="patch" action="{{ route('wishlists.update', $wishlist) }}">
    @include('wishlists._fields')
    <x-button-primary class="mt-8">Save changes</x-button-primary>
</x-form>
</x-app-layout>
