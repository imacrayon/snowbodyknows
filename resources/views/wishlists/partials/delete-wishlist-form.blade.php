<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Delete Wishlist') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Once your wishlist is deleted, all of its resources and data will be permanently deleted. Before deleting your wishlist, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <x-button-danger
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-wishlist-deletion')"
    >{{ __('Delete Wishlist') }}</x-button-danger>

    <x-modal name="confirm-wishlist-deletion" :show="$errors->wishlistDeletion->isNotEmpty()" focusable>
        <x-form method="delete" action="{{ route('wishlists.destroy', $wishlist) }}" class="p-6">
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Are you sure you want to delete your wishlist?') }}
            </h2>
            <p class="mt-1 text-sm text-gray-600">
                {!! __('Once your wishlist is deleted, all of its resources and data will be permanently deleted. Please enter :wishlist to confirm you would like to permanently delete your wishlist.', ['wishlist' => sprintf('<strong>%s</strong>', e($wishlist->name))]) !!}
            </p>

            <input type="hidden" name="original_name" value="{{ $wishlist->name }}">
            <x-field class="mt-6">
                <x-label for="wishlist_name" value="{{ __('Name') }}" class="sr-only" />
                <x-error for="wishlist_name" bag="wishlistDeletion" />
                <x-input type="text" name="wishlist_name" class="mt-1 block w-3/4" placeholder="{{ __('Name') }}" />
            </x-field>

            <div class="mt-6 flex justify-end">
                <x-button-secondary type="button" x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-button-secondary>

                <x-button-danger class="ml-3">
                    {{ __('Delete Wishlist') }}
                </x-button-danger>
            </div>
        </x-form>
    </x-modal>
</section>
