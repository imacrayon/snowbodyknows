<x-layout.auth title="{{ __('Confirm password') }}">
    <div class="mb-4 text-sm text-gray-600">
        {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
    </div>

    <x-form method="post" action="{{ route('password.confirm') }}">
        <x-field>
            <x-label for="password" :value="__('Password')" />
            <x-error for="password" />
            <x-input type="password" name="password" required autocomplete="current-password" />
        </x-field>

        <div class="flex justify-end mt-4">
            <x-button-primary>
                {{ __('Confirm') }}
            </x-button-primary>
        </div>
    </x-form>
</x-layout.auth>
