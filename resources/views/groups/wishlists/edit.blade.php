<x-layout.app>
    <x-slot name="title">{{ __('Edit Wishlists') }}</x-slot>
    <div class="mt-6 max-w-lg mx-auto px-4">
        <h1 class="text-lg font-medium text-gray-900">{{ __('Edit Wishlists') }}</h1>
        <x-form method="patch" action="{{ route('groups.wishlists.update', $group) }}">
            <fieldset>
                <legend class="text-sm font-medium text-gray-900">{{ __('Select wishlists you want to share with this group.') }}</legend>
                <x-error for="wishlists" />
                <div class="mt-2 -space-y-px rounded-md bg-white">
                    @foreach($yourWishlists as $wishlist)
                        <label class="group relative flex cursor-pointer border border-gray-200 px-4 py-3 first:rounded-t-md last:rounded-b-md focus:outline-none has-[:checked]:z-10 has-[:checked]:border-sky-200 has-[:checked]:bg-sky-50">
                            <x-checkbox name="wishlists[]" value="{{ $wishlist->id }}" :checked="$wishlists->contains($wishlist)" />
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
                </div>
            </fieldset>
            <div class="mt-6 flex items-center gap-4">
                <x-button-primary>{{ __('Save Changes') }}</x-button-primary>
                <x-button-secondary href="{{ route('groups.show', $group) }}">{{ __('Cancel') }}</x-button-secondary>
            </div>
        </x-form>
    </div>
</x-layout.app>
