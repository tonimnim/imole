<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 dark:text-gray-100 antialiased">
        <div class="min-h-screen flex flex-col bg-gray-50 dark:bg-gray-900">
            <div class="flex-1 flex flex-col sm:justify-center items-center pt-6 sm:pt-0 px-4">
                <div class="mb-8">
                    <a href="/" class="flex flex-col items-center gap-2">
                        <x-application-logo class="w-20 h-20 fill-current text-yellow-600 dark:text-yellow-400" />
                        <span class="text-xl font-bold text-gray-900 dark:text-white">{{ config('app.name') }}</span>
                    </a>
                </div>

                <div class="w-full sm:max-w-lg px-6 py-8 bg-white dark:bg-gray-800 shadow-xl overflow-hidden sm:rounded-2xl border border-gray-200 dark:border-gray-700">
                    {{ $slot }}
                </div>
            </div>

            <!-- Footer -->
            <footer class="py-8 px-4 border-t border-gray-200 dark:border-gray-700">
                <div class="max-w-7xl mx-auto">
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                        <div class="text-sm text-gray-600 dark:text-gray-400">
                            © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
                        </div>
                        <div class="flex flex-wrap items-center justify-center gap-4 sm:gap-6 text-sm">
                            <a href="/#about" class="text-gray-600 dark:text-gray-400 hover:text-yellow-600 dark:hover:text-yellow-400 transition-colors">About</a>
                            <a href="/#contact" class="text-gray-600 dark:text-gray-400 hover:text-yellow-600 dark:hover:text-yellow-400 transition-colors">Contact</a>
                            <a href="/courses" class="text-gray-600 dark:text-gray-400 hover:text-yellow-600 dark:hover:text-yellow-400 transition-colors">Courses</a>
                            <a href="/#" class="text-gray-600 dark:text-gray-400 hover:text-yellow-600 dark:hover:text-yellow-400 transition-colors">Privacy</a>
                            <a href="/#" class="text-gray-600 dark:text-gray-400 hover:text-yellow-600 dark:hover:text-yellow-400 transition-colors">Terms</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </body>
</html>
