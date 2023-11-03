<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <x-form id="send-verification" method="post" action="{{ route('verification.send') }}"></x-form>

    <x-form method="patch" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        <x-field>
            <x-label for="name" :value="__('Name')" />
            <x-error for="name" />
            <x-input name="name" :value="$user->name" required autofocus autocomplete="name" />
        </x-field>
        <x-field>
            <x-label for="email" :value="__('Email')" />
            <x-error for="email" />
            <x-input name="email" type="email" :value="$user->email" required autocomplete="username" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </x-field>

        <div class="flex items-center gap-4">
            <x-button-primary>{{ __('Save changes') }}</x-button-primary>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </x-form>
</section>
