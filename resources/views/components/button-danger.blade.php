@php
$classes = 'inline-flex items-center justify-center rounded-md bg-red-600 py-2 px-3 text-sm font-semibold text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600'
@endphp

@if($attributes->has('href'))
  <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>{{ $slot }}</a>
@else
  <button {{ $attributes->merge(['class' => $classes]) }}>{{ $slot }}</button>
@endif
