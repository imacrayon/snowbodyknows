<x-layout.base :title="$title ?? null">
    <nav class="bg-sky-200 p-4">
        <div class="max-w-6xl mx-auto sm:flex items-center justify-between">
            <a href="/" class="flex items-center gap-3">
                <img src="/img/snowman.svg" alt="Friendly snowman mascot" width="36" height="36">
                <span class="font-semibold text-sky-700">Snowbody Knows</span>
            </a>
            <div class="mt-4 flex items-center gap-3 sm:mt-0">
                <x-button-secondary href="{{ route('login') }}" class="shrink-0 grow">Login</x-button-primary>
                <x-button-danger href="{{ route('guests.wishlists.show') }}" class="shrink-0 grow">Start Your Wishlist</x-button-danger>
            </div>
        </div>
    </nav>
    <main>
        {{ $slot }}
    </main>
    <footer class="py-12 px-4 bg-sky-50">
        <div class="container mx-auto max-w-6xl">
            <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                <a href="/" class="flex items-center gap-3">
                    <img src="/img/snowman.svg" alt="" width="36" height="36">
                    <span class="text-sm font-semibold text-gray-600">Snowbody Knows</span>
                </a>
                <div class="flex gap-8 text-sm text-gray-600">
                    <a href="/privacy" class="underline text-sky-800 hover:text-sky-500">Privacy Policy</a>
                </div>
                <p class="text-sm text-gray-600">© 2025 Snowbody Knows. All rights reserved.</p>
            </div>
        </div>
    </footer>
</x-layout.base>
