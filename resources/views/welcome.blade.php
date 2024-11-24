<x-layout.base title="{{ __('A gift wishlist builder') }}">
@include('layouts.snow')
<div class="mx-auto mt-12 px-4 max-w-sm">
    <p class="text-center text-gray-600 text-lg">{{ __('Build a wishlist. Share it. Friends & family can purchase the things you want without you knowing.') }}</p>
</div>
<div class="relative max-w-sm mx-auto py-6 text-center px-4">
    <x-phosphor-snowflake width="24" height="24" class="absolute top-0 right-4 text-blue-100" />
    <x-phosphor-snowflake width="16" height="16" class="absolute top-8 right-4 text-blue-100" />
    <x-phosphor-snowflake width="16" height="16" class="absolute top-2 right-12 text-blue-100" />
    <x-phosphor-snowflake width="24" height="24" class="absolute bottom-0 left-6 text-blue-100" />
    <x-phosphor-snowflake width="16" height="16" class="absolute bottom-8 left-4 text-blue-100" />
    <a class="relative group inline-flex items-center text-sky-700 font-semibold underline hover:text-sky-800" href="{{ route('guests.wishlists.show') }}">
        {{ __('Start a wishlist without an account') }}
    </a>
</div>
<div class="mt-6 text-center w-full">
    <x-button-primary href="{{ route('register') }}">{{ __('Register') }}</x-button-primary>
    <x-button-secondary href="{{ route('login') }}">{{ __('Login') }}</x-button-secondary>
</div>
</x-layout>
