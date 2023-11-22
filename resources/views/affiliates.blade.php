<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Affiliates | Snowbody Knows</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 pb-32">
            <main>
                <div class="relative max-w-xl mx-auto pt-12 pb-6 px-4 sm:px-6 lg:px-8">
                    <x-back href="{{ route('welcome') }}">{{ __('Homepage') }}</x-back>
                    <h1 class="flex items-center gap-2 font-semibold text-xl text-gray-800 leading-tight">
                        Affiliate Disclosure
                    </h1>
                    <div class="mt-6 max-w-xl space-y-4">
                        <p>Some links you’ll see on the website are affiliate links. What does that mean? Snowbody Knows may earn a commission for any purchases that you make using this website. Just so you know, none of this will add any cost for you. Revenue from affiliate programs help to cover our costs of maintaining this website.</p>
                        <p>All efforts are made to ensure that affiliate links are disclosed in accordance with the FTC.</p>
                        <p>Let us know if you have any questions.</p>
                    </div>
                </div>
            </main>
        </div>
    </body>
</html>
