<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Settings') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Configure which notifications you want to receive') }}
        </p>
    </header>
    <x-form method="put" action="{{ route('settings.update') }}" class="mt-6 space-y-6">
        <div class="flex flex-row flex-wrap justify-start items-center gap-4">
            <x-field class="flex flex-row justify-start items-center gap-1">
                <x-input name="notification-wish-created" type="checkbox" id="notification-wish-created" value="notification-wish-created" style="width: 1.4rem; height: 1.4rem" 
                :checked="$settings['notification']['wish-created']"
                />
                <x-label for="notification-wish-created" :value="__('Notify on wish created')" class="!mt-0"/>
            </x-field>

            <x-field class="flex flex-row justify-start items-center gap-1">
                <x-input name="notification-wishlist-comment-created" type="checkbox" id="notification-wishlist-comment-created" style="width: 1.4rem; height: 1.4rem" value="notification-wishlist-comment-created" 
                :checked="$settings['notification']['wishlist-comment-created']"
                />
                <x-label for="notification-wishlist-comment-created" :value="__('Notify on wishlist comment')" class="!mt-0"/>
            </x-field>
        </div>

        <div class="flex items-center gap-4">
            <x-button-primary>{{ __('Save changes') }}</x-button-primary>

            @if (session('status') === 'settings-updated')
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

