<x-layout.base class="bg-gray-100">
<x-slot name="title">{{ $title ?? '' }}</x-slot>
<div class="flex-1 flex flex-col sm:absolute sm:inset-0 sm:justify-center sm:items-center px-4">
    <div class="w-full max-w-sm pt-12 sm:pt-0">
        <a href="/">
            <img src="/img/snowman.svg" alt="Friendly snowman mascot" width="88" height="88" class="mx-auto">
        </a>
        <div class="w-full sm:max-w-md px-6 py-4 bg-white shadow-sm overflow-hidden rounded-lg">
            {{ $slot }}
        </div>
    </div>
</div>
</x-layout>
