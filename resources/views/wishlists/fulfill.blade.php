<x-app-layout>
<x-slot name="title">
    {{ $wishlist->name }}
</x-slot>
<x-slot name="header">
    <h1 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ $wishlist->name }}
    </h1>
</x-slot>
<div class="max-w-7xl mx-auto px-4 space-y-6 sm:px-6 lg:px-8">
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
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                <path d="M5 12l5 5l10 -10" />
                                            </svg>
                                            <span class="sr-only">Grant</span>
                                        </button>
                                    </x-form>
                                @else
                                    <div class="h-6 flex items-center">
                                        <button class="w-5 h-5 flex items-center justify-center text-sky-900 bg-sky-200 rounded" aria-disabled="true" aria-pressed="true"  aria-describedby="wish_{{ $wish->id }}_name">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                <path d="M5 12l5 5l10 -10" />
                                            </svg>
                                            <span class="sr-only">Grant</span>
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
                                        <a href="{{ $wish->url }}" class="underline" aria-describedby="wish_{{ $wish->id }}_name">{{ $wish->name }}</a>
                                    @else
                                        <span id="wish_{{ $wish->id }}_name">{{ $wish->name }}</span>
                                    @endif
                                </span>
                                @if($wish->granted())
                                    <div>
                                        <span class="sr-only">Granted by</span>
                                        <img width="20" height="20" class="rounded-full" title="Granted by {{ $wish->granter->name }}" src="{{ $wish->granter->avatar_url }}" alt="{{ $wish->granter->name }}">
                                    </div>
                                @endif
                            </div>
                            @if($wish->description)
                                <div class="text-sm text-gray-600">{{ $wish->description }}</div>
                            @endif
                        </div>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="px-4 py-3 text-center text-gray-600 sm:py-4">{{ __('Nothing has been added to this wishlist (yet).') }}
        @endif
    </div>

    <section class="pt-4 sm:pt-8 text-center">
        <h2 class="sr-only text-lg font-medium text-gray-900">
            {{ __('Leave :wishlist Wishlist', ['wishlist' => $wishlist->name]) }}
        </h2>
        <x-form x-target="viewers" method="delete" action="{{ route('wishlists.viewers.destroy', [$wishlist, Auth::user()]) }}" onsubmit="return confirm(`{{ __('Once you leave you will no longer be able to see :wishlist.', ['wishlist' => $wishlist->name]) }}`)">
            <button class="underline text-gray-600 text-sm">{{ __('Leave this wishlist') }}</button>
        </x-form>
    </section>
</div>
</x-app-layout>
