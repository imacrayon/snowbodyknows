<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
    </div>

    <x-form method="post" action="{{ route('password.confirm') }}">
        <div>
            <x-label for="password" :value="__('Password')" />
            <x-error for="password" />
            <x-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />
        </div>

        <div class="flex justify-end mt-4">
            <x-button-primary>
                {{ __('Confirm') }}
            </x-button-primary>
        </div>
    </x-form>
</x-guest-layout>
