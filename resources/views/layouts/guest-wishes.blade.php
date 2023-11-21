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
                @if (isset($header))
                    <div class="relative max-w-7xl mx-auto pt-12 pb-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                @endif
                {{ $slot }}
                <div class="relative max-w-7xl mx-auto pt-12 pb-6 px-4 sm:px-6 lg:px-8">
                    <p>Want to get all features? <x-button-primary href="{{ route('login') }}">Login</x-button-primary></p>
                </div>
            </main>
        </div>
    </body>
</html>

