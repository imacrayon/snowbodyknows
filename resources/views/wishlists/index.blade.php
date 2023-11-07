<x-app-layout>
<x-slot name="title">
    {{ __('Wishlists') }}
</x-slot>
<x-slot name="header">
    <h1 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Wishlists') }}
    </h1>
</x-slot>
<div class="max-w-7xl mx-auto px-4 space-y-6 sm:px-6 lg:px-8">
    <x-section>
        <x-slot:title>
            {{ __('Your Wishlists') }}
        </x-slot:title>
        <x-slot:description>
            {{ __('Wishlists that you own. You can add wishes and invite people to view these lists.') }}
        </x-slot:description>
        <ul class="divide-y">
            @foreach($wishlists as $wishlist)
                <li class="block">
                    <a class="flex items-center justify-between gap-6 px-4 py-3 sm:py-4" href="{{ route('wishlists.show', $wishlist) }}">
                        <div>
                            {{ $wishlist->name }}
                            <div class="flex items-center gap-x-2 text-xs leading-5 text-gray-500">
                                {{ $wishlist->wishes_count }} {{ trans_choice('wish|wishes', $wishlist->wishes_count) }}
                                <svg viewBox="0 0 2 2" class="h-0.5 w-0.5 fill-current"><circle cx="1" cy="1" r="1"></circle></svg>
                                {{ $wishlist->viewers_count }} {{ trans_choice('viewer|viewers', $wishlist->viewers_count) }}
                            </div>
                        </div>

                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" class="text-gray-400" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M9 6l6 6l-6 6" />
                        </svg>
                    </a>
                </li>
            @endforeach
        </ul>
        <div class="bg-white px-4 py-5 sm:py-6 border-t">
            <x-button-primary class="w-full" href="{{ route('wishlists.create') }}">Add a wishlist</x-button-primary>
        </div>
    </x-section>

    @if($joinedWishlists->isNotEmpty())
        <x-section>
            <x-slot:title>
                {{ __('Joined Wishlists') }}
            </x-slot:title>
            <x-slot:description class="mt-2 text-xs text-gray-600">
                {{ __('Wishlists that have been shared with you. Grant wishes for your friends and family.') }}
            </x-slot:description>
            <ul class="divide-y">
                @foreach($joinedWishlists as $wishlist)
                    <li class="block">
                        <a class="flex items-center justify-between gap-6 px-4 py-3 sm:py-4" href="{{ route('wishlists.show', $wishlist) }}">
                            <div>
                                {{ $wishlist->name }}
                                <div class="flex items-center gap-x-2 text-xs leading-5 text-gray-500">
                                    {{ $wishlist->wishes_count }} {{ trans_choice('wish|wishes', $wishlist->wishes_count) }}
                                    <svg viewBox="0 0 2 2" class="h-0.5 w-0.5 fill-current"><circle cx="1" cy="1" r="1"></circle></svg>
                                    {{ $wishlist->viewers_count }} {{ trans_choice('viewer|viewers', $wishlist->viewers_count) }}
                                </div>
                            </div>

                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" class="text-gray-400" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M9 6l6 6l-6 6" />
                            </svg>
                        </a>
                    </li>
                @endforeach
            </ul>
        </x-section>
    @endif
</div>
</x-app-layout>
