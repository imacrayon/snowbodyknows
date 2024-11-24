<x-layout.auth title="{{ __('Create an account') }}">
    <header>
        <h1 class="text-lg font-medium text-gray-90">{{ __('Create an account') }}</h1>
        <p class="mt-1 text-sm text-gray-600">
            <strong>{{ __('Already have an account?') }}</strong>
            <a class="underline" href="{{ route('login',  ['group' => $group]) }}">{{ __('Log in') }}</a>.
        </p>
    </header>

    <x-form class="mt-6" method="post" action="{{ route('register', ['group' => $group]) }}">
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
            <x-button-primary class="ml-4">
                {{ __('Register') }}
            </x-button-primary>
        </div>
    </x-form>
</x-layout.auth>
