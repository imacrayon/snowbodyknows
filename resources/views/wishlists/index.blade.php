<x-layout.app title="{{ __('Wishlists') }}">
<x-slot name="header">
    <h1 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Wishlists') }}
    </h1>
</x-slot>
<div class="max-w-5xl mx-auto px-4 space-y-6 sm:px-6 lg:px-8">
    <x-section>
        <x-slot:title>
            {{ __('Your Wishlists') }}
        </x-slot:title>
        <x-slot:actions>
            <a href="{{ route('wishlists.create') }}" class="group inline-flex items-center text-sm text-gray-600 font-medium hover:text-sky-600">
                <x-phosphor-plus-circle-fill aria-hidden="true" width="16" height="16" class="mr-1.5 text-gray-400 group-hover:text-sky-400" />
                {{ __('New wishlist') }}
            </a>
        </x-slot:actions>
        <x-slot:description>
            {{ __('Wishlists that you own. You can add wishes and invite people to view these lists.') }}
        </x-slot:description>
        <ul class="divide-y">
            @foreach($wishlists as $wishlist)
                <li class="relative flex items-center justify-between gap-6 px-4 py-3 sm:py-4">
                    <div>
                        <a href="{{ route('wishlists.show', $wishlist) }}">
                            {{ $wishlist->name }}
                            @if ($wishlist->group)
                                (for {{ $wishlist->group->name }})
                            @endif
                            <span class="absolute inset-0" aria-hidden="true"></span>
                        </a>
                        <div class="flex items-center gap-x-2 text-xs leading-5 text-gray-500">
                            {{ $wishlist->wishes_count }} {{ trans_choice('wish|wishes', $wishlist->wishes_count) }}
                            &middot;
                            {{ $wishlist->groups_count }} {{ trans_choice('group|groups', $wishlist->groups_count) }}
                        </div>
                    </div>
                    <x-phosphor-caret-right aria-hidden="true" width="20" height="20"  class="text-gray-400" />
                </li>
            @endforeach
        </ul>
    </x-section>

    @if($groups->isNotEmpty())
        <x-section>
            <x-slot:title>
                {{ __('Groups') }}
            </x-slot:title>
            <x-slot:description class="mt-2 text-xs text-gray-600">
                {{ __('A group of shared wishlists. Everyone in a group can see each other’s wishlist.') }}
            </x-slot:description>
            <ul class="divide-y">
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
        </x-section>
    @endif
</div>
</x-layout.app>
