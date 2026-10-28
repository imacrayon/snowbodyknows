@props(['value'])

<label {{ $attributes->merge(['class' => 'block text-sm font-medium text-gray-900']) }}>{{ $value ?? $slot }}</label>
