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
            .bg-gradient-blue {
                background: linear-gradient(135deg, #e1f0ff 0%, #c8e6ff 100%);
            }
            .card-bg {
                background: rgba(255, 255, 255, 0.95);
                backdrop-filter: blur(10px);
                border: 1px solid rgba(148, 190, 245, 0.3);
            }
            .form-shadow {
                box-shadow: 0 10px 25px -5px rgba(0, 91, 187, 0.1), 
                            0 8px 10px -6px rgba(0, 91, 187, 0.1);
            }
        </style>
    </head>
    <body class="font-sans text-blue-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-blue">
            <div class="mb-8 mt-6">
                <a href="/">
                    <!-- Replace with your custom logo -->
                    <img src="{{ asset('img/logo-removebg-preview (1).png') }}" alt="Company Logo" class="w-40 h-auto">
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-4 px-6 py-8 card-bg shadow-xl rounded-xl form-shadow overflow-hidden">
                {{ $slot }}
            </div>
            
            <div class="mt-8 text-center text-sm text-blue-700">
                &copy; {{ date('Y') }} Laundry Management System - All Rights Reserved
            </div>
        </div>
    </body>
</html>