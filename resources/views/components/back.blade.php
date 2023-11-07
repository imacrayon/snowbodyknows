@props(['href'])

<a href="{{ $href }}" class="absolute -mt-8 group inline-flex items-center gap-1.5 text-xs leading-4 text-gray-600">
    <x-phosphor-arrow-left aria-hidden="true" width="16" height="16" class="text-gray-400 group-hover:text-gray-500" />
    <span class="sr-only">{{ __('Back to') }}</span> {{ $slot }}
</a>
