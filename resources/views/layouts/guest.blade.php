<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'ERP Production') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased">
    <div class="relative min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 overflow-hidden">

        <!-- Background Image -->
        <div class="absolute inset-0">
            <img src="{{ asset('images/bg.webp') }}" class="w-full h-full object-cover" />
        </div>
        <!-- Overlay Color -->
        <div class="absolute inset-0 bg-[#136566]/80"></div>

        <!-- Content -->
        <div class="relative z-10 w-full flex flex-col sm:justify-center items-center">

            <div>
                <a href="/">
                    <x-application-logo class="w-44 h-auto fill-white" />
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>

        </div>
    </div>
</body>

</html>
