<x-app-layout>
<x-slot name="title">
    {{ __('New wishlist') }}
</x-slot>
<x-slot name="header">
    <h1 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('New wishlist') }}
    </h1>
</x-slot>
<div class="py-12">
<x-form method="post" action="{{ route('wishlists.store', $wishlist) }}">
    @include('wishlists._fields')
    <x-button-primary class="mt-8">{{ __('Create wishlist') }}</x-button-primary>
</x-form>
</div>
</x-app-layout>
