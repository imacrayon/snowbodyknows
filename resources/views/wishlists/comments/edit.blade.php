<x-layout.app>
    <x-slot name="title">{{ __('Edit comment | :wishlist', ['wishlist' => $wishlist->name]) }}</x-slot>
    <x-slot name="header">
        <h1 class="font-semibold text-xl text-gray-800 leading-tight">
            <a href="{{ route('wishlists.show', $wishlist) }}" class="underline">{{ $wishlist->name }}</a>
            <span aria-hidden="true">/</span>
            {{ __('Edit comment') }}
        </h1>
    </x-slot>
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="p-4 bg-white shadow-sm rounded-lg">
            <ul role="list">
                <li id="comment_{{ $comment->id }}" class="pb-6">
                    <x-comment-form method="patch" action="{{ route('wishlists.comments.update', [$wishlist, $comment]) }}" :comment="$comment" :anonymous="$comment->isAnonymous()" x-target="comment_{{ $comment->id }}" />
                </li>
            </ul>
        </div>
    </div>
</x-layout.app>
