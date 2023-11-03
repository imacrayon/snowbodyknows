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
            @if (isset($header))
                <div class="max-w-7xl mx-auto pt-8 pb-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            @endif

            <main>
                {{ $slot }}
            </main>

            <header class="fixed bottom-8 w-full flex justify-center">
                <div class="bg-white shadow-xl rounded-3xl ring-1 ring-black ring-opacity-5 mx-auto">
                    @include('layouts.navigation')
                </div>
            </header>
        </div>
    </body>
</html>
