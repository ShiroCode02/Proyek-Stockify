<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Stockify') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-900 text-gray-100 flex items-center justify-center min-h-screen">

    <!-- Wrapper Border -->
    <div class="border border-gray-700 rounded-2xl p-6 sm:p-8 shadow-lg bg-gray-900 w-full max-w-md mx-4 flex flex-col items-center">

        <!-- Slot Konten (Form Login) -->
        <div class="w-full mt-2">
            {{ $slot }}
        </div>

    </div>

</body>
</html>
