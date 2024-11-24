<x-layout.app title="{{ __('Join :group', ['group' => $group->name]) }}">
    <div class="mt-6 max-w-lg mx-auto px-4">
        <h1 class="text-lg font-medium text-gray-900">{{ __('Join :group', ['group' => $group->name]) }}</h1>
        <div class="mt-4 rounded-lg bg-gray-50 ring-1 ring-gray-200/50 p-1 pt-0.5 space-y-1">
            <div class="px-2">
                <h2 class="font-medium text-gray-900 truncate">{{ __(':group Members', ['group' => $group->name]) }}
            </div>
            <ul class="bg-white ring-gray-200/50 rounded-md shadow">
                @foreach($users as $user)
                    <li class="flex items-center px-2 py-2 text-sm font-medium">
                        <img src="{{ $user->avatar_url }}" width="20" height="20" class="mr-2 rounded-full">
                        {{ $user->name }}
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="mt-6">
            <x-form method="post" action="{{ route('groups.users.store', $group) }}">
                <fieldset>
                    <legend class="text-sm font-medium text-gray-900">{{ __('Select a wishlist would you like to share with this group.') }}</legend>
                    <div class="mt-2 -space-y-px rounded-md bg-white">
                        @foreach($wishlists as $wishlist)
                            <label class="group relative flex cursor-pointer border border-gray-200 px-4 py-3 focus:outline-none has-[:checked]:z-10 has-[:checked]:border-sky-200 has-[:checked]:bg-sky-50 {{ $loop->first ? 'rounded-t-md' : '' }}">
                                <input type="radio" name="privacy-setting" value="Public access" class="mt-0.5 size-4 shrink-0 cursor-pointer border-gray-300 text-sky-600 focus:ring-sky-600 active:ring-2 active:ring-sky-600 active:ring-offset-2">
                                <span class="ml-3 flex flex-col">
                                    <span class="block text-sm font-medium text-gray-900 group-has-[:checked]:text-sky-900">{{ $wishlist->name }}</span>
                                    <span class="block text-sm text-gray-500 group-has-[:checked]:text-sky-700">
                                        {{ $wishlist->wishes_count }} {{ trans_choice('wish|wishes', $wishlist->wishes_count) }}
                                        &middot;
                                        {{ $wishlist->groups_count }} {{ trans_choice('group|groups', $wishlist->groups_count) }}
                                    </span>
                                </span>
                            </label>
                        @endforeach
                        <label class="group relative flex cursor-pointer rounded-b-md border px-4 py-3 focus:outline-none has-[:checked]:z-10 has-[:checked]:border-sky-200 has-[:checked]:bg-sky-50 ">
                            <input type="radio" name="privacy-setting" value="Public access" class="mt-0.5 size-4 shrink-0 cursor-pointer border-gray-300 text-sky-600 focus:ring-sky-600 active:ring-2 active:ring-sky-600 active:ring-offset-2">
                            <span class="ml-3 flex flex-col">
                                <span class="block text-sm font-medium text-gray-900 group-has-[:checked]:text-sky-900">{{ __('A new wishlist') }}</span>
                                <span class="block text-sm text-gray-500 group-has-[:checked]:text-sky-700">
                                    {{ __('Share a blank wishlist with this group.') }}
                                </span>
                            </span>
                        </label>
                    </div>
                </fieldset>
                <div class="mt-6 flex items-center gap-4">
                    <x-button-primary>{{ __('Join') }}</x-button-primary>
                    <x-button-secondary href="{{ route('app') }}">{{ __('Cancel') }}</x-button-secondary>
                </div>
            </x-form>
        </div>
    </div>
</x-layout.app>
