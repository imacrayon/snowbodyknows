<x-guest-layout>
    <x-form method="post" action="{{ route('register') }}">
        <div>
            <x-label for="name" :value="__('Name')" />
            <x-error for="name" />
            <x-input id="name" class="block mt-1 w-full" type="text" name="name" required autofocus autocomplete="name" />
        </div>
        <div class="mt-4">
            <x-label for="email" :value="__('Email')" />
            <x-error for="email" />
            <x-input id="email" class="block mt-1 w-full" type="email" name="email" required autocomplete="username" />
        </div>
        <div class="mt-4">
            <x-label for="password" :value="__('Password')" />
            <x-error for="password" />
            <x-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />
        </div>
        <div class="mt-4">
            <x-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-error for="password_confirmation" />
            <x-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />
        </div>
        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-button-primary class="ml-4">
                {{ __('Register') }}
            </x-button-primary>
        </div>
    </x-form>
</x-guest-layout>
