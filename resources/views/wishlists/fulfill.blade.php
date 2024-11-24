<x-layout.app title="{{ $wishlist->name }}">
<x-slot name="header">
    <h1 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ $wishlist->name }}
    </h1>
</x-slot>
<div class="max-w-5xl mx-auto px-4 space-y-6 sm:px-6 lg:px-8">
    <div class="bg-white divide-y shadow overflow-hidden rounded-lg">
        @if($wishes->isNotEmpty())
            <ul role="list" x-init id="wishlist_{{ $wishlist->id }}" x-merge="morph" class="bg-white">
                @foreach($wishes as $wish)
                    <li class="group bg-white flex items-start">
                        <div class="flex px-3 py-3 sm:py-4">
                            @if($wish->granted())
                                @can('ungrant', $wish)
                                    <x-form class="h-6 flex items-center" x-target="wishlist_{{ $wishlist->id }}" method="delete" action="{{ route('wishes.grants.destroy', $wish) }}">
                                        <button class="w-5 h-5 flex items-center justify-center text-sky-900 bg-sky-200 rounded" aria-pressed="true" aria-describedby="wish_{{ $wish->id }}_name">
                                            <x-phosphor-check-bold aria-hidden="true" width="16" height="16" />
                                            <span class="sr-only">Un-grant</span>
                                        </button>
                                    </x-form>
                                @else
                                    <div class="h-6 flex items-center">
                                        <button class="w-5 h-5 flex items-center justify-center text-sky-900 bg-sky-200 rounded" aria-disabled="true" aria-pressed="true"  aria-describedby="wish_{{ $wish->id }}_name">
                                            <x-phosphor-check-bold aria-hidden="true" width="16" height="16" />
                                            <span class="sr-only">Un-grant</span>
                                        </button>
                                    </div>
                                @endcan
                            @else
                                @can('grant', $wish->setRelation('wishlist', $wishlist))
                                    <x-form class="h-6 flex items-center" x-target="wishlist_{{ $wishlist->id }}" method="post" action="{{ route('wishes.grants.store', $wish) }}">
                                        <button class="w-5 h-5 bg-gray-200 rounded" aria-pressed="false" aria-describedby="wish_{{ $wish->id }}_name">
                                            <span class="sr-only">Grant</span>
                                        </button>
                                    </x-form>
                                @else
                                    <div class="h-6 flex items-center">
                                        <button class="w-5 h-5 bg-gray-200 rounded" aria-disabled="true" aria-pressed="false" aria-describedby="wish_{{ $wish->id }}_name">
                                            <span class="sr-only">Grant</span>
                                        </button>
                                    </div>
                                @endcan
                            @endif
                        </div>
                        <div class="flex-1 pr-4 py-3 sm:pr-8 sm:py-4 border-t group-first:border-t-0">
                            <div class="flex items-center justify-between gap-x-4">
                                <span class="{{ $wish->granted() ? 'text-gray-600 line-through' : '' }}">
                                    @if($wish->url)
                                        <a id="wish_{{ $wish->id }}_name" target="_blank" href="{{ $wish->url }}" class="underline">{{ $wish->name }}</a>
                                    @else
                                        <span id="wish_{{ $wish->id }}_name">{{ $wish->name }}</span>
                                    @endif
                                </span>
                                @if($wish->granted())
                                    <span>
                                        <span class="sr-only">Granted by</span>
                                        <img width="20" height="20" class="rounded-full" title="Granted by {{ $wish->granter->name }}" src="{{ $wish->granter->avatar_url }}" alt="{{ $wish->granter->name }}">
                                    </span>
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
                    </li>
                @endforeach
            </ul>
        @else
            <p class="px-4 py-3 text-sm text-center text-gray-600 sm:py-4">{{ __('Start by adding your first wish to this wishlist.') }}
        @endif
    </div>

    <x-section>
        <x-slot:title>
            {{ __('Comments') }}
        </x-slot:title>
        <x-slot:description>
            {{ __('Leave an anonymous note or ask a question about a wish.', ['user' => $wishlist->user->name]) }}
        </x-slot:description>
        <div class="p-4" x-init id="comments">
            @if ($comments->isNotEmpty())
                <ul role="list" x-init>
                    @foreach($comments as $comment)
                        <x-comment :comment="$comment->setRelation('commentable', $wishlist)" :anonymous="$comment->user->isNot($wishlist->user)" />
                    @endforeach
                </ul>
            @endif
            <x-comment-form action="{{ route('wishlists.comments.store', $wishlist) }}" :anonymous="true" x-target="comments" x-focus="comment" />
        </div>
    </x-section>
</div>
</x-layout.app>
