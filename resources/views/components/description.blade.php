<div id="{{ $for }}_description" {{ $attributes->merge(['class' => 'block text-sm leading-6 text-gray-600']) }}>
  {{ $value ?? $slot }}
</div>
