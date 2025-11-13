@props(['title' => ''])

<!DOCTYPE html>
<html lang="{{ $locale = str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title = $title ? $title.' | Snowbody Knows' : 'Snowbody Knows - Simple, Social Wishlists' }}</title>

        @stack('js')
        @stack('css')
        <style>[x-cloak] { display: none; }</style>
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <meta name="description" content="Stop guessing, start gifting! Share wishlists with loved ones. No account needed to get started." />
        <meta name="author" content="Snowbody Knows" />
        <meta property="og:type" content="website">
        <meta property="og:site_name" content="Snowbody Knows">
        <meta property="og:title" content="{{ $title }}">
        <meta property="og:description" content="Stop guessing, start gifting! Share wishlists with loved ones. No account needed to get started." />
        <meta property="og:url" content="{{ request()->url() }}" />
        <meta property="og:image" content="{{ url('/img/social.png') }}" />
        <meta name="twitter:card" content="summary_large_image">
    </head>
    <body class="font-sans antialiased">
        <div {{ $attributes->merge(['class' => 'min-h-screen flex flex-col']) }}>
            <main class="relative flex-1">
                {{ $slot }}
            </main>
            @if(isset($header))
                {{ $header ?? '' }}
            @endif
        </div>
    </body>
</html>
