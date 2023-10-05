<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <x-form method="put" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        <div>
            <x-label for="current_password" :value="__('Current Password')" />
            <x-error for="current_password" bag="updatePassword" />
            <x-input id="current_password" name="current_password" type="password" class="mt-1 block w-full" autocomplete="current-password" />
        </div>

        <div>
            <x-label for="password" :value="__('New Password')" />
            <x-error for="password" bag="updatePassword" />
            <x-input id="password" name="password" type="password" class="mt-1 block w-full" autocomplete="new-password" />
        </div>

        <div>
            <x-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-error for="password_confirmation" bag="updatePassword" />
            <x-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" autocomplete="new-password" />
        </div>

        <div class="flex items-center gap-4">
            <x-button-primary>{{ __('Save') }}</x-button-primary>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </x-form>
</section>
