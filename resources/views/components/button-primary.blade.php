@php
$classes = 'inline-flex items-center justify-center rounded-md bg-blue-600 py-2 px-3 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600'
@endphp

@if($attributes->has('href'))
  <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>{{ $slot }}</a>
@else
  <button {{ $attributes->merge(['class' => $classes]) }}>{{ $slot }}</button>
@endif
