<x-layout.base title="{{ $title ?? '' }}" class="bg-gray-100 pb-32">
<x-slot:header>
    <header class="fixed bottom-8 w-full flex justify-center">
        <div class="bg-white shadow-xl rounded-3xl ring-1 ring-black ring-opacity-5 mx-auto">
            @include('layouts.navigation')
        </div>
    </header>
</x-slot:header>
@if (isset($header))
    <div class="relative max-w-5xl mx-auto pt-12 pb-6 px-4 sm:px-6 lg:px-8">
        {{ $header }}
    </div>
@endif
{{ $slot }}
</x-layout>
