<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'ImoleAfrica LMS') }} - Agricultural & Vocational Training</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-50 dark:bg-gray-900">

    <!-- Header Component -->
    <x-header />

    <!-- Main Content -->
    <main class="pt-20">
        <!-- Hero Section -->
        <x-hero />

        <!-- Future sections will go here -->
    </main>

    <!-- Footer will go here -->

</body>
</html>
