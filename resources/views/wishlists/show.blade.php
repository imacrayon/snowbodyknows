<x-layout.app title="{{ $wishlist->name }}">
<x-slot name="header">
    <h1 class="flex items-center gap-2 font-semibold text-xl text-gray-800 leading-tight">
        {{ $wishlist->name }}
        <a class="pl-2" href="{{ route('wishlists.edit', $wishlist) }}">
            <x-phosphor-pencil aria-hidden="true" width="24" height="24"  class="text-gray-400 hover:text-gray-500" />
            <span class="sr-only">Edit</span>
        </a>
    </h1>
</x-slot>
<div class="max-w-5xl mx-auto px-4 space-y-6 sm:px-6 lg:px-8">
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
            <p class="px-4 py-3 text-sm text-center text-gray-600 sm:py-4">{{ __('Start by adding your first wish to this wishlist.') }}
        @endif
        <div class="bg-white px-4 py-5 sm:py-6 border-t">
            <x-button-primary class="w-full" href="{{ route('wishes.create', $wishlist) }}">Add a wish</x-button-primary>
        </div>
    </div>

    <x-section>
        <x-slot:title>
            {{ __('Sharing') }}
        </x-slot:title>
        <x-slot:description>
            {{ __('These are the groups of people that can view your wishlist.') }}
        </x-slot:description>
        @if ($groups->isNotEmpty())
            <ul id="groups" x-init class="divide-y">
                @foreach($groups as $group)
                    <li class="relative flex items-center justify-between gap-6 px-4 py-3 sm:py-4">
                        <div>
                            <a href="{{ route('groups.show', $group) }}">
                                {{ $group->name }}
                                <span class="absolute inset-0" aria-hidden="true"></span>
                            </a>
                            <div class="flex items-center gap-x-2 text-xs leading-5 text-gray-500">
                                {{ $group->users_count }} {{ trans_choice('member|members', $group->users_count) }}
                            </div>
                        </div>
                        <x-phosphor-caret-right aria-hidden="true" width="20" height="20"  class="text-gray-400" />
                    </li>
                @endforeach
            </ul>
        @endif
        <div class="bg-white px-4 py-5 sm:py-6 border-t">
            <x-form method="post" action="{{ route('groups.store', $wishlist) }}">
                <x-button-secondary class="w-full">
                    Share
                </x-button-secondary>
            </x-form>
        </div>
    </x-section>

    <x-section>
        <x-slot:title>
            {{ __('Comments') }}
        </x-slot:title>
        <x-slot:description>
            {{ __('Communicate with your wishlist groups. Leave notes or respond to questions that others might leave here.') }}
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


</div>
</x-layout.app>
