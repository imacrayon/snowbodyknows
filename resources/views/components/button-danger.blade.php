@php
$classes = 'inline-flex items-center justify-center rounded-md px-3 py-2 text-sm font-semibold text-red-900 bg-red-200 shadow-sm ring-1 ring-inset ring-red-900/10 hover:bg-red-100'
@endphp

@if($attributes->has('href'))
  <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>{{ $slot }}</a>
@else
  <button {{ $attributes->merge(['class' => $classes]) }}>{{ $slot }}</button>
@endif
