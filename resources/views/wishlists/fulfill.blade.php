<x-app-layout>
<x-slot name="header">
    <h1 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ $wishlist->name }}
    </h1>
</x-slot>
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="bg-white divide-y shadow overflow-hidden sm:rounded-lg">
            @if($wishes->isNotEmpty())
                <ul role="list" x-init id="wishlist_{{ $wishlist->id }}" x-merge="morph" class="bg-white">
                    @foreach($wishes as $wish)
                        <li class="group bg-white flex">
                            <div class="flex px-4 py-3 sm:py-4">
                                @if($wish->granted())
                                    @can('ungrant', $wish)
                                        <x-form class="pt-px flex flex-start" x-target="wishlist_{{ $wishlist->id }}" method="delete" action="{{ route('wishes.grants.destroy', $wish) }}">
                                            <button class="w-6 h-6" aria-pressed="true" aria-describedby="wish_{{ $wish->id }}_name">
                                                <svg aria-hidden="true" class="text-blue-600" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                    <path d="M18.333 2c1.96 0 3.56 1.537 3.662 3.472l.005 .195v12.666c0 1.96 -1.537 3.56 -3.472 3.662l-.195 .005h-12.666a3.667 3.667 0 0 1 -3.662 -3.472l-.005 -.195v-12.666c0 -1.96 1.537 -3.56 3.472 -3.662l.195 -.005h12.666zm-2.626 7.293a1 1 0 0 0 -1.414 0l-3.293 3.292l-1.293 -1.292l-.094 -.083a1 1 0 0 0 -1.32 1.497l2 2l.094 .083a1 1 0 0 0 1.32 -.083l4 -4l.083 -.094a1 1 0 0 0 -.083 -1.32z" stroke-width="0" fill="currentColor" />
                                                </svg>
                                                <span class="sr-only">Grant</span>
                                            </button>
                                        </x-form>
                                    @else
                                        <div class="pt-px flex flex-start">
                                            <button class="w-6 h-6" aria-disabled="true" aria-pressed="true"  aria-describedby="wish_{{ $wish->id }}_name">
                                                <svg aria-hidden="true" class="text-blue-600" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                    <path d="M18.333 2c1.96 0 3.56 1.537 3.662 3.472l.005 .195v12.666c0 1.96 -1.537 3.56 -3.472 3.662l-.195 .005h-12.666a3.667 3.667 0 0 1 -3.662 -3.472l-.005 -.195v-12.666c0 -1.96 1.537 -3.56 3.472 -3.662l.195 -.005h12.666zm-2.626 7.293a1 1 0 0 0 -1.414 0l-3.293 3.292l-1.293 -1.292l-.094 -.083a1 1 0 0 0 -1.32 1.497l2 2l.094 .083a1 1 0 0 0 1.32 -.083l4 -4l.083 -.094a1 1 0 0 0 -.083 -1.32z" stroke-width="0" fill="currentColor" />
                                                </svg>
                                                <span class="sr-only">Grant</span>
                                            </button>
                                        </div>
                                    @endcan
                                @else
                                    @can('grant', $wish->setRelation('wishlist', $wishlist))
                                        <x-form class="pt-px flex flex-start" x-target="wishlist_{{ $wishlist->id }}" method="post" action="{{ route('wishes.grants.store', $wish) }}">
                                            <button class="w-6 h-6" aria-pressed="false" aria-describedby="wish_{{ $wish->id }}_name">
                                                <svg aria-hidden="true" class="text-gray-300" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                    <path d="M19 2h-14a3 3 0 0 0 -3 3v14a3 3 0 0 0 3 3h14a3 3 0 0 0 3 -3v-14a3 3 0 0 0 -3 -3z" stroke-width="0" fill="currentColor" />
                                                </svg>
                                                <span class="sr-only">Grant</span>
                                            </button>
                                        </x-form>
                                    @else
                                        <div class="pt-px flex flex-start">
                                            <button class="w-6 h-6" aria-disabled="true" aria-pressed="false" aria-describedby="wish_{{ $wish->id }}_name">
                                                <svg aria-hidden="true" class="text-gray-300" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                    <path d="M19 2h-14a3 3 0 0 0 -3 3v14a3 3 0 0 0 3 3h14a3 3 0 0 0 3 -3v-14a3 3 0 0 0 -3 -3z" stroke-width="0" fill="currentColor" />
                                                </svg>
                                                <span class="sr-only">Grant</span>
                                            </button>
                                        </div>
                                    @endcan
                                @endif
                            </div>
                            <div class="flex-1 flex gap-6 pr-4 py-3 sm:pr-8 sm:py-4 border-t group-first:border-t-0">
                                <div class="flex-1">
                                    <div class="{{ $wish->granted() ? 'text-gray-600 line-through' : '' }}">
                                        <span id="wish_{{ $wish->id }}_name">{{ $wish->name }}</a>
                                    </div>
                                    @if($wish->description)
                                        <div class="text-sm text-gray-600">{{ $wish->description }}</div>
                                    @endif
                                </div>
                                <div class="flex gap-2">
                                    @if($wish->url)
                                        <a href="{{ $wish->url }}" class="underline text-gray-600 text-sm" aria-describedby="wish_{{ $wish->id }}_name">View</a>
                                    @endif
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="px-4 py-3 text-center text-gray-600 sm:px-8 sm:py-4">{{ __('Nothing has been added to this wishlist (yet).') }}
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
</div>
</x-app-layout>
