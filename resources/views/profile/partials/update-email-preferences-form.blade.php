<section id="email-preferences">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Email Notifications') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Choose what we email you about on wishlists you have joined.') }}
        </p>
    </header>

    <x-form method="patch" action="{{ route('profile.email-preferences.update') }}" class="mt-6 space-y-6">
        <div class="-space-y-px rounded-md bg-white">
            <label class="group relative flex cursor-pointer border border-gray-200 px-4 py-3 first:rounded-t-md last:rounded-b-md focus:outline-hidden has-checked:z-10 has-checked:border-sky-200 has-checked:bg-sky-50">
                <x-checkbox name="receives_wish_emails" :checked="$user->receives_wish_emails" />
                <span class="ml-3 flex flex-col">
                    <span class="block text-sm font-medium text-gray-900 group-has-checked:text-sky-900">{{ __('New wishes') }}</span>
                    <span class="block text-sm text-gray-500 group-has-checked:text-sky-700">{{ __('Wishes added close together arrive in one email.') }}</span>
                </span>
            </label>
            <label class="group relative flex cursor-pointer border border-gray-200 px-4 py-3 first:rounded-t-md last:rounded-b-md focus:outline-hidden has-checked:z-10 has-checked:border-sky-200 has-checked:bg-sky-50">
                <x-checkbox name="receives_comment_emails" :checked="$user->receives_comment_emails" />
                <span class="ml-3 flex flex-col">
                    <span class="block text-sm font-medium text-gray-900 group-has-checked:text-sky-900">{{ __('New comments') }}</span>
                </span>
            </label>
        </div>

        <div class="flex items-center gap-4">
            <x-button-primary>{{ __('Save changes') }}</x-button-primary>

            @if (session('status') === 'email-preferences-updated')
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
