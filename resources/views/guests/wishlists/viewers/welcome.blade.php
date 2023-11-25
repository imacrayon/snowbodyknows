<x-layout.base title="{{ __('Join :wishlist', ['wishlist' => $wishlist->name]) }}">
@include('layouts/snow')
<div class="mx-auto mt-12 px-4 max-w-sm">
    <h1 class="font-semibold text-center text-gray-900 text-xl">{{ __(':name sent you their wishlist!', ['name' => $wishlist->user->name]) }}</h1>
    <p class="mt-4 text-center text-gray-600 text-lg">{{ __('Create an account or login to see their wishes, check items off, or even create a list of your own.') }}</p>
</div>
<div class="mt-12 text-center w-full">
    <x-button-primary href="{{ route('register', ['wishlist' => $wishlist->invite_code]) }}">{{ __('Create an account') }}</x-button-primary>
    <x-button-secondary href="{{ route('login', ['wishlist' => $wishlist->invite_code]) }}">{{ __('Login') }}</x-button-secondary>
</div>
</x-layout>
