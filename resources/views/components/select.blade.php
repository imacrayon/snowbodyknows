@if(! $multiple)
  <select {{ $formControlAttributes() }} {{ $attributes->merge(['class' => 'block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-blue-500 sm:text-sm sm:leading-6']) }}>
    @if(! empty($options))
      @foreach($options as $v => $l)
        @if($placeholder)
          <option value hidden>{{ $placeholder }}</option>
        @endif
        <option {{ $isSelected($v) ? 'selected' : '' }} value="{{ $v }}">{{ $l }}</option>
      @endforeach
    @else
      {{ $slot }}
    @endif
  </select>
@else
  <div id="{{ $id }}" {{ $formControlAttributes() }} {{ $attributes->merge(['class' => 'relative bg-gray-50 rounded-md border border-gray-300 overflow-x-hidden divide-y overflow-y-scroll h-36 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500']) }}>
    @if(! empty($options))
      @foreach($options as $v => $l)
        <x-label for="{{ $name }}_{{ $loop->iteration }}" class="flex items-center space-x-2 w-full py-2 px-3 bg-white font-normal hover:bg-gray-50">
          <x-checkbox name="{{ $name }}" id="{{ $name }}_{{ $loop->iteration }}" value="{{ $v }}" :checked="$isSelected($v)" />
          <span>{{ $l }}</span>
        </x-label>
      @endforeach
    @else
      {{ $slot }}
    @endif
  </div>
@endif
