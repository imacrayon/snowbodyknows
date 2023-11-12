<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Delete Party') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Once your party is deleted, all of its resources and data will be permanently deleted. Before deleting your party, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <x-button-danger
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-party-deletion')"
    >{{ __('Delete Party') }}</x-button-danger>

    <x-modal name="confirm-party-deletion" :show="$errors->partyDeletion->isNotEmpty()" focusable>
        <x-form method="delete" action="{{ route('parties.destroy', $party) }}" class="p-6">
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Are you sure you want to delete your party?') }}
            </h2>
            <p class="mt-1 text-sm text-gray-600">
                {{ __('Once your party is deleted, all of its resources and data will be permanently deleted. Please enter the party\'s name to confirm you would like to permanently delete your party.') }}
            </p>

            <input type="hidden" name="original_name" value="{{ $party->name }}">
            <x-field class="mt-6">
                <x-label for="party_name" value="{{ __('Name') }}" class="sr-only" />
                <x-error for="party_name" bag="partyDeletion" />
                <x-input type="text" name="party_name" class="mt-1 block w-3/4" placeholder="{{ __('Name') }}" />
            </x-field>

            <div class="mt-6 flex justify-end">
                <x-button-secondary type="button" x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-button-secondary>

                <x-button-danger class="ml-3">
                    {{ __('Delete Party') }}
                </x-button-danger>
            </div>
        </x-form>
    </x-modal>
</section>

