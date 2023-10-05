@error($for, $bag)
  <div id="{{ $id }}_error" {{ $attributes->merge(['class' => 'text-sm text-red-600']) }}>
    @if ($slot->isEmpty())
      {{ $value ?? $message }}
    @else
      {{ $slot }}
    @endif
  </div>
@enderror
