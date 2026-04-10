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

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-100">

    @auth
        @include('layouts.sidebars.owner')
    @endauth

    <!-- RIGHT SIDE -->
    <div data-content class="min-h-screen flex flex-col">

        <!-- NAVBAR -->
        <div class="bg-white border-b">
            @include('layouts.navigation.owner')
        </div>

        <!-- CONTENT -->
        <main style="padding: 20px; flex: 1;">
            @yield('content')
        </main>

    </div>

</body>

<script src="https://unpkg.com/heroicons@2.0.18/dist/heroicons.min.js"></script>

</html>
