<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <x-form method="post" action="{{ route('password.email') }}">
        <div>
            <x-label for="email" :value="__('Email')" />
            <x-error for="email" />
            <x-input id="email" class="block mt-1 w-full" type="email" name="email" required autofocus />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-button-primary>
                {{ __('Email Password Reset Link') }}
            </x-button-primary>
        </div>
    </x-form>
</x-guest-layout>
