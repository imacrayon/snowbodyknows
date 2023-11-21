<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ isset($title) ? $title . ' | ' : '' }} Snowbody Knows</title>

        <style>[x-cloak] { display: none; }</style>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 pb-32">
            <main>
                <div class="relative max-w-4xl mx-auto pt-6 mb-2 px-8">
                    <div class="ribbon text-sm text-center">
                        <p class="bg-red-300 text-red-900 p-3 sm:px-6 ">
                            <a class="underline" href="{{ route('register') }}">Create an account</a> to save this wishlist & unlock more features.
                        </p>
                    </div>
                </div>
                @if (isset($header))
                    <div class="relative max-w-7xl mx-auto pt-12 pb-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                @endif
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
