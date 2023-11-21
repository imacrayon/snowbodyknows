<x-app-layout>
<x-slot name="title">
    {{ $wishlist->name }}
</x-slot>
<x-slot name="header">
    <x-back href="{{ route('wishlists.index') }}">{{ __('Wishlists') }}</x-back>
    <h1 class="flex items-center gap-2 font-semibold text-xl text-gray-800 leading-tight">
        {{ $wishlist->name }}
        <a class="pl-2" href="{{ route('wishlists.edit', $wishlist) }}">
            <x-phosphor-pencil aria-hidden="true" width="24" height="24"  class="text-gray-400 hover:text-gray-500" />
            <span class="sr-only">Edit</span>
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
                                    <x-phosphor-dots-six-vertical x-show="selected !== '{{ $wish->id }}'" aria-hidden="true" width="24" height="24"  class="text-gray-400 hover:text-gray-300" />
                                    <x-phosphor-caret-up-down x-cloak x-show="selected === '{{ $wish->id }}'" aria-hidden="true" width="24" height="24" class="text-gray-400" />
                                    <span class="sr-only">Re-order</span>
                                </button>
                            </div>
                            <div class="flex-1 flex border-t group-first:border-t-0">
                                <div class="flex-1 py-3 sm:py-4">
                                    <div>
                                        @if($wish->url)
                                            <a id="wish_{{ $wish->id }}_name" target="_blank" href="{{ $wish->url }}" class="underline">{{ $wish->name }}</a>
                                        @else
                                            <span id="wish_{{ $wish->id }}_name">{{ $wish->name }}</span>
                                        @endif
                                    </div>
                                    @if($wish->description)
                                        <div class="text-sm text-gray-600">
                                            @if($wish->url)
                                                {{ $wish->urlDomain() }} &middot;
                                            @endif
                                            {{ $wish->description }}
                                        </div>
                                    @elseif($wish->url)
                                        <div class="text-sm text-gray-600">{{ $wish->urlDomain() }}</div>
                                    @endif
                                </div>
                                <x-dropdown align="right" width="48" class="px-2 pt-1 sm:pt-2">
                                    <x-slot name="button" class="block p-2 -mb-2 rounded-full">
                                        <x-phosphor-dots-three-circle aria-hidden="true" width="24" height="24" class="text-gray-400 hover:text-gray-500" />
                                        <span class="sr-only">Actions</span>
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
            <p class="px-4 py-3 text-center text-gray-600 sm:py-4">{{ __('Start by adding your first wish to this wishlist.') }}
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
                    <x-phosphor-copy aria-hidden="true" width="20" height="20" class="-ml-1 mr-2" />
                    Copy
                </span>
                <span x-show="copied" class="flex items-center">
                    <x-phosphor-check aria-hidden="true" width="20" height="20" class="-ml-1 mr-2" />
                    Copied
                </span>
            </button>
        </div>
    </x-section>

    <x-section>
        <x-slot:title>
            {{ __('Comments') }}
        </x-slot:title>
        <x-slot:description>
            {{ __('Communicate with your wishlist viewers. Leave notes or respond to questions that others might leave here.') }}
        </x-slot:description>
        <div class="p-4" x-init id="comments">
            @if ($comments->isNotEmpty())
                <ul role="list" x-init>
                    @foreach($comments as $comment)
                        <x-comment :comment="$comment->setRelation('commentable', $wishlist)" :anonymous="$comment->user->isNot($wishlist->user)" />
                    @endforeach
                </ul>
            @endif
            <x-comment-form action="{{ route('wishlists.comments.store', $wishlist) }}" :anonymous="false" x-target="comments" x-focus="comment" />
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
                                <x-phosphor-x-circle aria-hidden="true" width="24" height="24" class="text-gray-400 hover:text-red-500" />
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
