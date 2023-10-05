<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Delete Account') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <x-button-danger
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >{{ __('Delete Account') }}</x-button-danger>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <x-form method="delete" action="{{ route('profile.destroy') }}" class="p-6">
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Are you sure you want to delete your account?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            <div class="mt-6">
                <x-label for="password" value="{{ __('Password') }}" class="sr-only" />
                <x-error for="password" bag="userDeletion" />
                <x-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4"
                    placeholder="{{ __('Password') }}"
                />

            </div>

            <div class="mt-6 flex justify-end">
                <x-button-secondary x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-button-secondary>

                <x-button-danger class="ml-3">
                    {{ __('Delete Account') }}
                </x-button-danger>
            </div>
        </x-form>
    </x-modal>
</section>
