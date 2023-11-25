<x-layout.base title="{{ $title ?? '' }}" class="bg-gray-100">
<div class="relative max-w-4xl mx-auto pt-6 mb-2 px-8">
    <div class="ribbon text-sm text-center">
        <p class="bg-red-300 text-red-900 p-3 sm:px-6 ">
            <a class="underline" href="{{ route('register') }}">{{ __('Create an account') }}</a> {{ __('to save this wishlist & unlock more features.') }}
        </p>
    </div>
</div>
@if (isset($header))
    <div class="relative max-w-5xl mx-auto pt-12 pb-6 px-4 sm:px-6 lg:px-8">
        {{ $header }}
    </div>
@endif
{{ $slot }}
</x-layout>
