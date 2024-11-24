<x-layout.base title="{{ $title ?? '' }}" class="bg-gray-100">
<div class="flex-1 flex flex-col sm:absolute sm:inset-0 sm:justify-center sm:items-center px-4">
    <div class="w-full max-w-sm pt-12 sm:pt-0">
        <div class="w-full sm:max-w-md px-6 py-4 bg-white shadow overflow-hidden rounded-lg">
            {{ $slot }}
        </div>
    </div>
</div>
</x-layout>
