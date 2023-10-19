<x-app-layout>
<x-slot name="title">
    {{ $wishlist->name }}
</x-slot>
<x-slot name="header">
    <h1 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ $wishlist->name }}
    </h1>
</x-slot>
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="bg-white divide-y shadow overflow-hidden sm:rounded-lg">
            @if($wishes->isNotEmpty())
                <div id="announcer" aria-live="assertive" class="sr-only"></div>
                <div id="sortable_description" class="sr-only">Press spacebar to grab and re-order</div>
                <ul x-data="sortable('{{ route('wishlists.sort', $wishlist) }}')" role="list" class="bg-white divide-y">
                    @foreach($wishes as $wish)
                        <li data-id="{{ $wish->id }}" class="bg-white flex gap-6 px-4 pl-0 py-3 sm:px-8 sm:py-4">
                            <div class="flex-1 flex sm:gap-4">
                                <button type="button" data-handle
                                    aria-describedby="sortable_description"
                                    x-on:click.prevent.stop=""
                                    x-on:keydown.space.prevent="toggle"
                                    class="flex items-center cursor-move pl-4 pr-2 sm:pr-4"
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
                                    <svg x-cloak x-show="selected === '{{ $wish->id }}'" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" class="text-gray-300" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M8 9l4 -4l4 4" />
                                        <path d="M16 15l-4 4l-4 -4" />
                                    </svg>
                                    <span class="sr-only">Re-order</span>
                                </button>
                                <div>
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
                            </div>
                            <div class="flex gap-2">
                                <a href="{{ route('wishes.edit', [$wishlist, $wish]) }}" class="underline text-gray-600 text-sm" aria-describedby="wish_{{ $wish->id }}_name">Edit</a>
                                <x-form method="delete" action="{{ route('wishes.destroy', [$wishlist, $wish]) }}" class="text-gray-600 text-sm">
                                    <button class="underline" aria-describedby="wish_{{ $wish->id }}_name">Delete</button>
                                </x-form>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="px-4 py-3 text-center text-gray-600 sm:px-8 sm:py-4">{{ __('Nothing has been added to this wishlist (yet).') }}
            @endif
            <div class="bg-white px-4 py-5 sm:px-8 sm:py-6 border-t">
                <x-button-primary class="w-full" href="{{ route('wishes.create', $wishlist) }}">Add a wish</x-button-primary>
            </div>
        </div>

        <section class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <header>
                <h2 class="text-lg font-medium text-gray-900">
                    {{ __('Share') }}
                </h2>
                <p class="mt-1 text-sm text-gray-600">
                    {{ __('Use this link to share your wishlist with others.') }}
                </p>
            </header>
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
            }" class="mt-6 flex rounded-md shadow-sm">
                <label for="share_url" class="sr-only">{{ __('Share URL') }}</label>
                <input type="url" id="share_url" x-ref="input" readonly x-on:focus="select" value="{{ route('wishlists.viewers.create', $wishlist) }}" x-bind:class="canCopy ? '' : 'rounded-r-md'" class="block w-full rounded-none rounded-l-md border-0 py-1.5 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6">
                <button type="button" x-show="canCopy" x-on:click="copy" class="bg-gray-100 relative -ml-px inline-flex items-center gap-x-1.5 rounded-r-md px-3 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-200">
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
        </section>

        <section class="bg-white pt-4 sm:pt-8 divide-y shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 sm:px-8">
                <header>
                    <h2 class="text-lg font-medium text-gray-900">
                        {{ __('Viewers') }}
                    </h2>
                    <p class="mt-1 text-sm text-gray-600">
                        {{ __('These are the people who can view your wishlist.') }}
                    </p>
                </header>
            </div>
            <div class="mt-6">
                <ul class="bg-white divide-y">
                    @foreach($wishlist->viewers as $viewer)
                        <li class="flex gap-6 px-4 py-3 sm:px-8 sm:py-4">
                            {{ $viewer->name }}
                        </li>
                    @endforeach
                </ul>
            </div>
        </section>
    </div>
</div>
</x-app-layout>
