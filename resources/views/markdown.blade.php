<x-layout.base title="{{ $title ?? '' }}" class="bg-gray-100">
<div class="relative max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="pt-12 mx-auto max-w-prose prose">
        <x-back href="{{ route('welcome') }}">{{ __('Homepage') }}</x-back>
        {!! $slot !!}
    </div>
</div>
</x-layout>
