<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Snowbody Knows</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased p-6">
        @auth
            <x-button-primary href="{{ url('/app') }}">{{ __('Home') }}</x-button-primary>
        @else
            <x-button-secondary href="{{ route('login') }}" >{{ __('Log in') }}</x-button-secondary>

            <x-button-primary href="{{ route('register') }}">{{ __('Register') }}</x-button-primary>
        @endauth
    </body>
</html>
