<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <x-form method="post" action="{{ route('login') }}">
        <div>
            <x-label for="email" :value="__('Email')" />
            <x-error for="email" />
            <x-input id="email" class="block mt-1 w-full" type="email" name="email" required autofocus autocomplete="username" />
        </div>
        <div class="mt-4">
            <x-label for="password" :value="__('Password')" />
            <x-error for="password" />
            <x-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />
        </div>
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-button-primary class="ml-3">
                {{ __('Log in') }}
            </x-button-primary>
        </div>
    </x-form>
</x-guest-layout>
