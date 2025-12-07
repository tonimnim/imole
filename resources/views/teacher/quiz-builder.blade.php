<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Quiz Builder | {{ config('app.name', 'ImoleAfrica') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/quiz-builder.js'])

    <script>
        window.quizBuilderData = {
            backUrl: @json(route('filament.teacher.resources.quizzes.index')),
        };
    </script>
</head>
<body class="font-sans antialiased">
    <div id="quiz-builder"></div>
</body>
</html>
