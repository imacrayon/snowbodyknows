<nav class="flex divide-x">
    <div class="p-2">
        <div class="relative w-16 h-full">
            <img src="/img/snowman.svg" width="64" height="auto" class="absolute left-0 bottom-0" alt="SnowbodyKnows">
        </div>
    </div>
    <ul class="flex">
        <li class="p-1">
            <x-nav-link :href="route('app')" :active="request()->routeIs('wishlists.index')">
                {{ __('Wishlists') }}
            </x-nav-link>
        </li>
    </ul>
    <x-dropdown align="bottom" width="48" class="flex items-center p-1 pl-2">
        <x-slot name="trigger">
            <button class="rounded-3xl py-1 px-2 flex items-center bg-transparent">
                <img src="{{ Auth::user()->avatar_url }}" width="32" height="32" class="rounded-full" alt="">
                <span class="sr-only">Settings</span>
                <x-phosphor-caret-down aria-hidden="true" class="ml-1 text-gray-400" width="16" height="16" />
            </button>
        </x-slot>

        <x-slot name="content">
            <x-dropdown-link :href="route('profile.edit')">
                {{ __('Profile') }}
            </x-dropdown-link>
            <x-form method="post" action="{{ route('logout') }}">
                <x-dropdown-link :href="route('logout')"
                        onclick="event.preventDefault();
                                    this.closest('form').submit();">
                    {{ __('Log Out') }}
                </x-dropdown-link>
            </x-form>
        </x-slot>
    </x-dropdown>
</nav>
