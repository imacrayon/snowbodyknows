<x-guest-layout>
    <x-form method="post" action="{{ route('register') }}">
        <div class="space-y-6">
            <x-field>
                <x-label for="name" :value="__('Name')" />
                <x-error for="name" />
                <x-input name="name" required autofocus autocomplete="name" />
            </x-field>
            <x-field>
                <x-label for="email" :value="__('Email')" />
                <x-error for="email" />
                <x-input type="email" name="email" required autocomplete="username" />
            </x-field>
            <x-field>
                <x-label for="password" :value="__('Password')" />
                <x-error for="password" />
                <x-input type="password" name="password" required autocomplete="new-password" />
            </x-field>
            <x-field>
                <x-label for="password_confirmation" :value="__('Confirm Password')" />
                <x-error for="password_confirmation" />
                <x-input type="password" name="password_confirmation" required autocomplete="new-password" />
            </x-field>
        </div>
        <div class="flex items-center justify-end mt-6">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-button-primary class="ml-4">
                {{ __('Register') }}
            </x-button-primary>
        </div>
    </x-form>
</x-guest-layout>
