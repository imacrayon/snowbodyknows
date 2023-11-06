<x-app-layout>
<x-slot name="title">
    {{ $wishlist->name }}
</x-slot>
<x-slot name="header">
    <h1 class="font-semibold text-xl text-gray-800 leading-tight inline-flex items-center">
        {{ $wishlist->name }}
        <a class="pl-2" href="{{ route('wishlists.edit', [$wishlist]) }}">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="18" height="18" class="text-gray-400 hover:text-gray-400">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
            </svg>
        </a>
    </h1>
</x-slot>
<div class="max-w-7xl mx-auto px-4 space-y-6 sm:px-6 lg:px-8">
    <div class="bg-white divide-y shadow overflow-hidden rounded-lg">
        @if($wishes->isNotEmpty())
            <div>
                <div id="announcer" aria-live="assertive" class="sr-only"></div>
                <div id="sortable_description" class="sr-only">Press spacebar to grab and re-order</div>
                <ul x-data="sortable('{{ route('wishlists.sort', $wishlist) }}')" role="list" class="bg-white">
                    @foreach($wishes as $wish)
                        <li data-id="{{ $wish->id }}" class="group bg-white flex">
                            <div class="p-1">
                                <button type="button" data-handle
                                    aria-describedby="sortable_description"
                                    x-on:click.prevent.stop=""
                                    x-on:keydown.space.prevent="toggle"
                                    class="flex items-center px-1 h-full cursor-move rounded-lg"
                                >
                                    <svg x-show="selected !== '{{ $wish->id }}'" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" class="text-gray-300" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M9 5m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                        <path d="M9 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                        <path d="M9 19m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                        <path d="M15 5m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                        <path d="M15 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                        <path d="M15 19m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                    </svg>
                                    <svg x-cloak x-show="selected === '{{ $wish->id }}'" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" class="text-gray-400" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M8 9l4 -4l4 4" />
                                        <path d="M16 15l-4 4l-4 -4" />
                                    </svg>
                                    <span class="sr-only">Re-order</span>
                                </button>
                            </div>
                            <div class="flex-1 flex border-t group-first:border-t-0">
                                <div class="flex-1 py-3 sm:py-4">
                                    <div>
                                        @if($wish->url)
                                            <a id="wish_{{ $wish->id }}_name" class="underline" href="{{ $wish->url }}">{{ $wish->name }}</a>
                                        @else
                                            <span id="wish_{{ $wish->id }}_name">{{ $wish->name }}</span>
                                        @endif
                                    </div>
                                    @if($wish->description)
                                        <div class="text-sm text-gray-600">{{ $wish->description }}</div>
                                    @endif
                                </div>
                                <x-dropdown align="right" width="48" class="px-2 pt-1 sm:pt-2">
                                    <x-slot name="trigger">
                                        <button type="button" class="block p-2 -mb-2 rounded-full">
                                            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="24" height="24" class="text-gray-400 hover:text-gray-400">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <span class="sr-only">Actions</span>
                                        </button>
                                    </x-slot>
                                    <x-slot name="content">
                                        <x-dropdown-link href="{{ route('wishes.edit', [$wishlist, $wish]) }}">
                                            {{ __('Edit') }}
                                        </x-dropdown-link>
                                        <x-form method="delete" action="{{ route('wishes.destroy', [$wishlist, $wish]) }}" class="text-gray-600 text-sm" onsubmit="return confirm('This wish will be removed from your wishlist.')">
                                            <button class="block w-full px-4 py-2 text-left text-sm leading-5 text-gray-700 hover:bg-sky-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out" aria-describedby="wish_{{ $wish->id }}_name">Delete</button>
                                        </x-form>
                                    </x-slot>
                                </x-dropdown>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        @else
            <p class="px-4 py-3 text-center text-gray-600 sm:py-4">{{ __('Nothing has been added to this wishlist (yet).') }}
        @endif
        <div class="bg-white px-4 py-5 sm:py-6 border-t">
            <x-button-primary class="w-full" href="{{ route('wishes.create', $wishlist) }}">Add a wish</x-button-primary>
        </div>
    </div>

    <x-section>
        <x-slot:title>
            {{ __('Share') }}
        </x-slot:title>
        <x-slot:description class="mt-1 text-sm text-gray-600">
            {{ __('Use this link to share your wishlist with others.') }}
        </x-slot:description>
        <div x-data="{
            canCopy: window.navigator.clipboard,
            copied: false,
            select() {
                this.$refs.input.setSelectionRange(0, this.$refs.input.value.length)
            },
            copy() {
                window.navigator.clipboard.writeText(this.$refs.input.value)
                this.copied = true
                window.setTimeout(() => this.copied = false, 2000)
            }
        }" class="p-1 flex space-x-1 rounded-md sm:p-4">
            <div class="flex-1">
                <label for="share_url" class="sr-only">{{ __('Share URL') }}</label>
                <input type="url" id="share_url" x-ref="input" readonly x-on:focus="select" value="{{ route('wishlists.viewers.create', $wishlist) }}" x-bind:class="canCopy ? '' : 'rounded-r-md'" class="block w-full rounded-md border-transparent py-1.5 text-gray-900 bg-gray-50 focus:ring-2 focus:ring-inset focus:ring-sky-600 sm:text-sm sm:leading-6">
            </div>
            <button type="button" x-show="canCopy" x-on:click="copy" class="bg-sky-50 relative -ml-px inline-flex items-center gap-x-1.5 rounded-md px-3 py-2 text-sm font-semibold text-sky-800 hover:bg-sky-200 hover:text-sky-900">
                <span x-show="!copied" class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" class="-ml-1 mr-2" viewBox="0 0 24 24" stroke-width="1.5" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M8 8m0 2a2 2 0 0 1 2 -2h8a2 2 0 0 1 2 2v8a2 2 0 0 1 -2 2h-8a2 2 0 0 1 -2 -2z" />
                        <path d="M16 8v-2a2 2 0 0 0 -2 -2h-8a2 2 0 0 0 -2 2v8a2 2 0 0 0 2 2h2" />
                    </svg>
                    Copy
                </span>
                <span x-show="copied" class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" class="-ml-1 mr-2" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M5 12l5 5l10 -10" />
                    </svg>
                    Copied
                </span>
            </button>
        </div>
    </x-section>

    @if ($wishlist->viewers->isNotEmpty())
        <x-section>
            <x-slot:title>
                {{ __('Viewers') }}
            </x-slot:title>
            <x-slot:description>
                {{ __('These are the people who can view your wishlist.') }}
            </x-slot:descripti>
            <ul id="viewers" x-init class="divide-y">
                @foreach($wishlist->viewers as $viewer)
                    <li class="flex gap-6 px-4 py-3 sm:py-4">
                        <div class="flex-1 flex items-center space-x-2">
                            <img src="{{ $viewer->avatar_url }}" width="32" height="32" class="rounded-full" alt="">
                            <div class="flex-1">{{ $viewer->name }}</div>
                        </div>
                        <x-form class="flex items-center" x-target="viewers" method="delete" action="{{ route('wishlists.viewers.destroy', [$wishlist, $viewer]) }}" x-on:ajax:before="confirm(`{{ __(':viewer will no longer be able to see your wishlist.', ['viewer' => $viewer->name]) }}`) || $event.preventDefault()">
                            <button class="rounded-full">
                                <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="24" height="24" class="text-gray-400 hover:text-red-500">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="sr-only">Remove</span>
                            </button>
                        </x-form>
                    </li>
                @endforeach
            </ul>
        </x-section>
    @endif
</div>
</x-app-layout>
