<x-app-layout>
<x-slot name="header">
    <h1 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ $wishlist->name }}
    </h1>
</x-slot>
<div class="py-12">
    <ul class="bg-white divide-y">
        @foreach($wishes as $wish)
            <li class="flex gap-6 px-4 py-3">
                <div class="flex-1">
                    <div>
                        {{ $wish->name }}
                        @if ($wish->url)
                            <span class="text-gray-600">[<a href="{{ $wish->url }}" class="underline">{{ parse_url($wish->url, PHP_URL_HOST) }}</a>]</span>
                        @endif
                    </div>
                    <div class="text-sm text-gray-600">{{ $wish->description }}</div>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('wishes.edit', [$wishlist, $wish]) }}" class="underline">Edit <span class="sr-only">{{ $wish->name }}</span></a>
                    <x-form method="delete" action="{{ route('wishes.destroy', [$wishlist, $wish]) }}">
                        <button class="underline">Delete <span class="sr-only">{{ $wish->name }}</span></button>
                    </x-form>
                </div>
            </li>
        @endforeach
    </ul>
    <div class="bg-white p-4 border-t">
        <x-button-primary class="w-full" href="{{ route('wishes.create', $wishlist) }}">Add a wish</x-button-primary>
    </div>
</div>
</x-app-layout>
