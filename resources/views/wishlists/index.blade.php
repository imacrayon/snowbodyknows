<x-layout.app title="{{ __('Wishlists') }}">
<x-slot name="header">
    <h1 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Wishlists') }}
    </h1>
</x-slot>
<div class="max-w-5xl mx-auto px-4 space-y-6 sm:px-6 lg:px-8">
    <x-section>
        <x-slot:title>
            {{ __('Your Wishlists') }}
        </x-slot:title>
        <x-slot:actions>
            <a href="{{ route('wishlists.create') }}" class="group inline-flex items-center text-sm text-gray-600 font-medium hover:text-sky-600">
                <x-phosphor-plus-circle-fill aria-hidden="true" width="16" height="16" class="mr-1.5 text-gray-400 group-hover:text-sky-400" />
                {{ __('New wishlist') }}
            </a>
        </x-slot:actions>
        <x-slot:description>
            {{ __('Wishlists that you own. You can add wishes and invite people to view these lists.') }}
        </x-slot:description>
        <ul class="divide-y">
            @foreach($wishlists as $wishlist)
                <li class="relative flex items-center justify-between gap-6 px-4 py-3 sm:py-4">
                    <div>
                        <a href="{{ route('wishlists.show', $wishlist) }}">
                            {{ $wishlist->name }}
                            <span class="absolute inset-0" aria-hidden="true"></span>
                        </a>
                        <div class="flex items-center gap-x-2 text-xs leading-5 text-gray-500">
                            {{ $wishlist->wishes_count }} {{ trans_choice('wish|wishes', $wishlist->wishes_count) }}
                            <svg viewBox="0 0 2 2" aria-hidden="true" class="h-0.5 w-0.5 fill-current"><circle cx="1" cy="1" r="1"></circle></svg>
                            {{ $wishlist->viewers_count }} {{ trans_choice('viewer|viewers', $wishlist->viewers_count) }}
                        </div>
                    </div>
                    <x-phosphor-caret-right aria-hidden="true" width="20" height="20"  class="text-gray-400" />
                </li>
            @endforeach
        </ul>
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
                    <li class="relative flex items-center justify-between gap-6 px-4 py-3 sm:py-4">
                        <div>
                            <a href="{{ route('wishlists.show', $wishlist) }}">
                                {{ $wishlist->name }}
                                <span class="absolute inset-0" aria-hidden="true"></span>
                            </a>
                            <div class="flex items-center gap-x-2 text-xs leading-5 text-gray-500">
                                {{ $wishlist->wishes_count }} {{ trans_choice('wish|wishes', $wishlist->wishes_count) }}
                                <svg viewBox="0 0 2 2" aria-hidden="true" class="h-0.5 w-0.5 fill-current"><circle cx="1" cy="1" r="1"></circle></svg>
                                {{ $wishlist->viewers_count }} {{ trans_choice('viewer|viewers', $wishlist->viewers_count) }}
                            </div>
                        </div>
                        <x-phosphor-caret-right aria-hidden="true" width="20" height="20"  class="text-gray-400" />
                    </li>
                @endforeach
            </ul>
        </x-section>
    @endif
</div>
</x-layout.app>
