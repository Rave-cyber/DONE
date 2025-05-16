<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            .bg-light-blue {
                background: linear-gradient(135deg, rgba(225, 240, 255, 0.9) 0%, rgba(200, 230, 255, 0.9) 100%);
            }
            .card-bg {
                background: rgba(255, 255, 255, 0.85);
                backdrop-filter: blur(8px);
            }
        </style>
    </head>
    <body class="font-sans text-gray-800 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-light-blue">
            <div class="mb-8">
                <a href="/">
                    <!-- Replace with your custom logo -->
                    <img src="{{ asset('img/logo-removebg-preview (1).png') }}" alt="Company Logo" class="w-32 h-auto">
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-8 py-8 card-bg shadow-xl rounded-2xl border border-blue-100">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>