<x-layout.auth>
    <x-slot name="title">{{ __('Unsubscribe') }}</x-slot>
    @if ($subscribed)
        <p class="text-sm text-gray-600">
            {{ __('Stop emailing :email about :topic?', ['email' => $user->email, 'topic' => $topic->label()]) }}
        </p>
        <x-form method="post" action="{{ request()->fullUrl() }}">
            <x-button-primary class="mt-6 w-full">
                {{ __('Unsubscribe') }}
            </x-button-primary>
        </x-form>
    @else
        <p class="font-medium text-sm text-green-600">
            {{ __('You will no longer get emails about :topic.', ['topic' => $topic->label()]) }}
        </p>
    @endif
    <div class="mt-3 text-center">
        <a href="{{ route('profile.edit') }}#email-preferences" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-hidden focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            {{ __('Manage email settings') }}
        </a>
    </div>
</x-layout.auth>
