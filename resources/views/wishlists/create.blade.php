<x-app-layout>
<x-slot name="header">
    <h1 class="font-semibold text-xl text-gray-800 leading-tight">
        Add a wish to {{ $wishlist->name }}
    </h1>
</x-slot>
<div class="py-12">
<x-form method="post" action="{{ route('wishlists.store', $wishlist) }}">
    @include('wishlists._fields')
    <x-button-primary class="mt-8">Save changes</x-button-primary>
</x-form>
</div>
</x-app-layout>
