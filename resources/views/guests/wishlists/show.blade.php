<x-layout.guest title="{{ $wishlist->name }}">
<x-slot name="header">
    <h1 class="flex items-center gap-2 font-semibold text-xl text-gray-800 leading-tight">
        {{ $wishlist->name }}
    </h1>
</x-slot>
<div class="max-w-5xl mx-auto px-4 space-y-6 sm:px-6 lg:px-8">
    <div class="bg-white divide-y shadow overflow-hidden rounded-lg">
        @if($wishes->isNotEmpty())
            <div>
                <div id="announcer" aria-live="assertive" class="sr-only"></div>
                <div id="sortable_description" class="sr-only">Press spacebar to grab and re-order</div>
                <ul x-data="sortable('{{ route('guests.wishlists.sort') }}')" role="list" class="bg-white">
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
                                        <x-dropdown-link href="{{ route('guests.wishes.edit', ['wishId' => $wish->id]) }}">
                                            {{ __('Edit') }}
                                        </x-dropdown-link>
                                        <x-form method="delete" action="{{ route('guests.wishes.destroy', [$wish->id]) }}" class="text-gray-600 text-sm" onsubmit="return confirm('This wish will be removed from your wishlist.')">
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
            <x-button-primary class="w-full" href="{{ route('guests.wishes.create') }}">Add a wish</x-button-primary>
        </div>
    </div>

</div>
</x-layout.guest>
