@props(['datetime', 'format' => 'relative'])

<relative-time datetime="{{ $datetime->toW3cString() }}" {{ $attributes->merge(['format' => $format]) }}>{{ $datetime }}</relative-time>
