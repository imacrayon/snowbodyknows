<x-guest-layout>
    <x-form method="post" action="{{ route('password.store') }}">
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div>
            <x-label for="email" :value="__('Email')" />
            <x-error for="email" />
            <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="$request->email" required autofocus autocomplete="username" />
        </div>
        <div class="mt-4">
            <x-label for="password" :value="__('Password')" />
            <x-error for="password" />
            <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
        </div>
        <div class="mt-4">
            <x-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-error for="password_confirmation" />
            <x-input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation" required autocomplete="new-password" />
        </div>
        <div class="flex items-center justify-end mt-4">
            <x-button-primary>
                {{ __('Reset Password') }}
            </x-button-primary>
        </div>
    </x-form>
</x-guest-layout>
