<x-layout.auth title="{{ __('Verify email') }}">
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
        </div>
    @endif

    <div class="mt-4 flex items-center justify-between">
        <x-form method="post" action="{{ route('verification.send') }}">
            <div>
                <x-button-primary>
                    {{ __('Resend Verification Email') }}
                </x-button-primary>
            </div>
        </x-form>

        <x-form method="post" action="{{ route('logout') }}">
            <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                {{ __('Log Out') }}
            </button>
        </x-form>
    </div>
</x-layout.auth>
