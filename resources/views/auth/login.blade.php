<x-layout.auth title="{{ __('Login') }}">
    <header>
        <h1 class="text-lg font-medium text-gray-90">{{ __('Login') }}</h1>
        <p class="mt-1 text-sm text-gray-600">
            <strong>{{ __('New here?') }}</strong>
            <a class="underline" href="{{ route('register', ['group' => $group]) }}">{{ __('Create an account') }}</a>.
        </p>
    </header>

    <x-auth-session-status class="mt-6" :status="session('status')" />

    <x-form class="mt-6" method="post" action="{{ route('login', ['group' => $group]) }}">
        <div class="space-y-6">
            <x-field>
                <x-label for="email" :value="__('Email')" />
                <x-error for="email" />
                <x-input type="email" name="email" required autofocus autocomplete="username" />
            </x-field>
            <x-field>
                <x-label for="password" :value="__('Password')" />
                <x-error for="password" />
                <x-input type="password" name="password" required autocomplete="current-password" />
            </x-field>
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-sky-700 shadow-sm focus:ring-blue-500" name="remember">
                <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-6">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-button-primary class="ml-3">
                {{ __('Log in') }}
            </x-button-primary>
        </div>
    </x-form>
</x-layout.auth>
