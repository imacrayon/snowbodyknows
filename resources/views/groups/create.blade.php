<x-layout.app>
    <x-slot name="title">{{ __('Share :wishlist', ['wishlist' => $wishlist->name]) }}</x-slot>
    <div class="mt-6 max-w-lg mx-auto px-4">
        <h1 class="text-lg font-medium text-gray-900">{{ __('Share :wishlist', ['wishlist' => $wishlist->name]) }}</h1>
        <x-form method="post" action="{{ route('groups.store', $wishlist) }}" class="mt-4">
            <fieldset>
                <legend class="text-sm font-medium text-gray-900">{{ __('Select groups you want to share this wishlist with.') }}</legend>
                <x-error for="groups" />
                <div class="mt-2 -space-y-px rounded-md bg-white">
                    @foreach($yourGroups as $group)
                        <label class="group relative flex cursor-pointer border border-gray-200 px-4 py-3 first:rounded-t-md last:rounded-b-md focus:outline-hidden has-checked:z-10 has-checked:border-sky-200 has-checked:bg-sky-50">
                            <x-checkbox name="groups[]" value="{{ $group->id }}" :checked="$wishlist->groups->contains($group)" />
                            <span class="ml-3 flex flex-col">
                                <span class="block text-sm font-medium text-gray-900 group-has-checked:text-sky-900">{{ $group->name }}</span>
                                <span class="block text-sm text-gray-500 group-has-checked:text-sky-700">
                                    {{ $group->users_count }} {{ trans_choice('member|members', $group->users_count) }}
                                </span>
                            </span>
                        </label>
                    @endforeach
                    <label class="group relative flex cursor-pointer border border-gray-200 px-4 py-3 first:rounded-t-md last:rounded-b-md focus:outline-hidden has-checked:z-10 has-checked:border-sky-200 has-checked:bg-sky-50">
                        <x-checkbox name="groups[]" :value="App\Http\Controllers\GroupController::NEW_GROUP" />
                        <span class="ml-3 flex flex-col">
                            <span class="block text-sm font-medium text-gray-900 group-has-checked:text-sky-900">{{ __('A new group') }}</span>
                            <span class="block text-sm text-gray-500 group-has-checked:text-sky-700">
                                {{ __('Share with a new group you can invite people to.') }}
                            </span>
                        </span>
                    </label>
                </div>
            </fieldset>
            <div class="mt-6 flex items-center gap-4">
                <x-button-primary>{{ __('Share') }}</x-button-primary>
                <x-button-secondary href="{{ route('wishlists.show', $wishlist) }}">{{ __('Cancel') }}</x-button-secondary>
            </div>
        </x-form>
    </div>
</x-layout.app>
