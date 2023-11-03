<nav class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <div class="flex space-x-8 sm:-my-px sm:ml-10">
                <x-nav-link :href="route('app')" :active="request()->routeIs('app')">
                    {{ __('Wishlists') }}
                </x-nav-link>
            </div>

            <div class="flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center bg-transparent hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <img src="{{ Auth::user()->avatar_url }}" width="32" height="32" class="rounded-full" alt="">
                            <span class="sr-only">Settings</span>
                            <div class="ml-1">
                                <svg class="text-gray-500" width="16" height="16" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
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
            </div>
        </div>
    </div>
</nav>
