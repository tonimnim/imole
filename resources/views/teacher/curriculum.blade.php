<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Curriculum - {{ $course->title }} | {{ config('app.name', 'ImoleAfrica') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/curriculum-builder.js'])

    <script>
        window.curriculumData = {
            courseSlug: @json($course->slug),
            backUrl: @json(route('filament.teacher.resources.courses.index')),
        };
    </script>
</head>
<body class="font-sans antialiased">
    <div id="curriculum-builder"></div>
</body>
</html>
