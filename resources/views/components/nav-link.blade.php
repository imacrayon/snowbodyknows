@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center rounded-3xl px-4 py-3 text-sm font-medium leading-5 text-gray-900 bg-sky-50 hover:bg-sky-100'
            : 'inline-flex items-center rounded-3xl px-4 py-3 text-sm font-medium leading-5 text-gray-600 hover:bg-sky-100';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
