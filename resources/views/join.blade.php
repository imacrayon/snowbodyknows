<x-layout.base title="{{ __('Join :group', ['wishlist' => $group->name]) }}">
    @include('layouts.snow')
    <div class="mt-6 max-w-lg mx-auto px-4">
        <h1 class="text-lg font-medium text-gray-900">{{ __("You've been invited to a gift exchange!") }}</h1>
        <div class="mt-4 rounded-lg bg-gray-50 ring-1 ring-gray-200/50 p-1 pt-0.5 space-y-1">
            <div class="px-2">
                <h2 class="font-medium text-gray-900 truncate">{{ __(':group Members', ['group' => $group->name]) }}
            </div>
            <ul class="bg-white ring-gray-200/50 rounded-md shadow">
                @foreach($users as $user)
                    <li class="flex items-center px-2 py-2 text-sm font-medium">
                        <img src="{{ $user->avatar_url }}" width="20" height="20" class="mr-2 rounded-full">
                        {{ $user->name }}
                    </li>
                @endforeach
            </ul>
        </div>
        <p class="mt-6 text-sm text-gray-600">{{ __("Create an account to see everyone's wishlist, who has purchased what, and even share a wishlist of your own.") }}</p>
        <div class="mt-6 flex items-center gap-4">
            <x-button-primary href="{{ route('register', ['group' => $group->invite_code]) }}">{{ __('Create an account') }}</x-button-primary>
            <x-button-secondary href="{{ route('login', ['group' => $group->invite_code]) }}">{{ __('Login') }}</x-button-secondary>
        </div>
    </div>
</x-layout.base>
