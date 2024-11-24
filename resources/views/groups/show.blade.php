<x-layout.app title="{{ $group->name }}">
    <x-slot name="header">
        <h1 class="flex items-center gap-2 font-semibold text-xl text-gray-800 leading-tight">
            {{ $group->name }}
            <a class="pl-2" href="{{ route('groups.edit', $group) }}">
                <x-phosphor-pencil aria-hidden="true" width="24" height="24"  class="text-gray-400 hover:text-gray-500" />
                <span class="sr-only">Edit</span>
            </a>
        </h1>
        @if($group->description)
        <p class="text-gray-700 leading-tight pt-3">
            {{ $group->description }}
        </p>
        @else
        <p class="text-gray-700 leading-tight pt-3">
            {{ __('Everyone in this group will share wishlists with each other. Invite loved ones to this group using the link below.') }}
        </p>
        @endif
    </x-slot>
    <div class="max-w-5xl mx-auto px-4 space-y-6 sm:px-6 lg:px-8">
        <x-section>
            <x-slot:title>
                {{ __('Your Wishlist') }}
            </x-slot:title>
            <x-slot:description>
                {{ __('The wishlist you are sharing with this group.') }}
            </x-slot:description>
            <div>
                <ul class="divide-y">
                    @foreach($yourWishlists as $wishlist)
                        <li class="relative flex items-center justify-between gap-6 px-4 py-3 sm:py-4">
                            <div>
                                <a href="{{ route('wishlists.show', $wishlist) }}">
                                    {{ $wishlist->name }}
                                    <span class="absolute inset-0" aria-hidden="true"></span>
                                </a>
                                <div class="flex items-center gap-x-2 text-xs leading-5 text-gray-500">
                                    {{ $wishlist->wishes_count }} {{ trans_choice('wish|wishes', $wishlist->wishes_count) }}
                                </div>
                            </div>
                            <x-phosphor-caret-right aria-hidden="true" width="20" height="20"  class="text-gray-400" />
                        </li>
                    @endforeach
                </ul>
            </div>
        </x-section>

        @if($otherWishlists->isNotEmpty())
            <x-section>
                <x-slot:title>
                    {{ __('Other Wishlists') }}
                </x-slot:title>
                <x-slot:description>
                    {{ __('Everyone in this group can view these wishlists.') }}
                </x-slot:description>
                <div>
                    <ul id="other_wishlists" class="divide-y">
                        @foreach($otherWishlists as $wishlist)
                            <li class="relative flex items-center justify-between gap-6 px-4 py-3 sm:py-4">
                                <div>
                                    <a href="{{ route('wishlists.show', $wishlist) }}">
                                        {{ $wishlist->name }}
                                        <span class="absolute inset-0" aria-hidden="true"></span>
                                    </a>
                                    <div class="flex items-center gap-x-2 text-xs leading-5 text-gray-500">
                                        {{ $wishlist->wishes_count }} {{ trans_choice('wish|wishes', $wishlist->wishes_count) }}
                                    </div>
                                </div>
                                <x-phosphor-caret-right aria-hidden="true" width="20" height="20"  class="text-gray-400" />
                            </li>
                        @endforeach
                    </ul>
                </div>
            </x-section>
        @endif

        <x-section>
            <x-slot:title>
                {{ __('Share Link') }}
            </x-slot:title>
            <x-slot:description class="mt-1 text-sm text-gray-600">
                {{ __('Use this link to share your group with others.') }}
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
                    <input type="url" id="share_url" x-ref="input" readonly x-on:focus="select" value="{{ route('join', $group) }}" x-bind:class="canCopy ? '' : 'rounded-r-md'" class="block w-full rounded-md border-transparent py-1.5 text-gray-900 bg-gray-50 focus:ring-2 focus:ring-inset focus:ring-sky-600 sm:text-sm sm:leading-6">
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

        <section class="pt-4 sm:pt-8 text-center">
            <h2 class="sr-only text-lg font-medium text-gray-900">
                {{ __('Leave group') }}
            </h2>
            <x-form method="delete" action="{{ route('groups.users.destroy', [$group, Auth::user()]) }}" onsubmit="return confirm(`{{ __('You will lose access to the other\'s wishlists in :group.', ['group' => $group->name]) }}`)">
                <button class="underline text-gray-600 text-sm">{{ __('Leave this group') }}</button>
            </x-form>
        </section>
    </div>
</x-layout.app>
