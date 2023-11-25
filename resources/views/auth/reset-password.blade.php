<x-layout.auth title="{{ __('Password reset') }}">
    <x-form method="post" action="{{ route('password.store') }}">
        <input type="hidden" name="token" value="{{ $request->route('token') }}">
        <div class="space-y-6">
            <x-field>
                <x-label for="email" :value="__('Email')" />
                <x-error for="email" />
                <x-input type="email" name="email" :value="$request->email" required autofocus autocomplete="username" />
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
            <x-button-primary>
                {{ __('Reset Password') }}
            </x-button-primary>
        </div>
    </x-form>
</x-layout.auth>
