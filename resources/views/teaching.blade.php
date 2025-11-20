<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Teach on ImoleAfrica - Become an Instructor</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-white dark:bg-gray-900">

    <!-- Header Component -->
    <x-header />

    <!-- Main Content -->
    <main class="pt-20">

        <!-- Hero Section -->
        <section class="bg-gray-100 dark:bg-gray-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid lg:grid-cols-2 gap-12 items-center py-16 lg:py-24">

                    <!-- Left: Text Content -->
                    <div class="space-y-6">
                        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-gray-900 dark:text-white leading-tight">
                            Come teach<br>with us
                        </h1>
                        <p class="text-xl text-gray-600 dark:text-gray-300">
                            Become an instructor and change lives<br>— including your own
                        </p>
                        <div>
                            <a
                                href="{{ route('register') }}?role=teacher"
                                class="inline-block px-8 py-4 bg-green-600 text-white text-lg font-semibold rounded-lg hover:bg-green-700 shadow-lg hover:shadow-xl transition-all"
                            >
                                Get started
                            </a>
                        </div>
                    </div>

                    <!-- Right: Image -->
                    <div>
                        <img
                            src="/teacher-hero.jpg"
                            alt="Become a teacher on ImoleAfrica"
                            class="w-full h-auto"
                        />
                    </div>

                </div>
            </div>
        </section>

        <!-- Reasons to Start Section -->
        <section class="py-16 lg:py-24 bg-white dark:bg-gray-900">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-center text-gray-900 dark:text-white mb-16">
                    So many reasons to start
                </h2>

                <div class="grid md:grid-cols-3 gap-12">

                    <!-- Reason 1 -->
                    <div class="text-center space-y-4">
                        <div class="flex justify-center">
                            <div class="w-24 h-24 flex items-center justify-center">
                                <svg class="w-20 h-20 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">
                            Teach your way
                        </h3>
                        <p class="text-gray-600 dark:text-gray-400">
                            Create courses on agriculture, vocational skills, or any topic you're passionate about. You have full control over your content.
                        </p>
                    </div>

                    <!-- Reason 2 -->
                    <div class="text-center space-y-4">
                        <div class="flex justify-center">
                            <div class="w-24 h-24 flex items-center justify-center">
                                <svg class="w-20 h-20 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">
                            Inspire learners
                        </h3>
                        <p class="text-gray-600 dark:text-gray-400">
                            Help students across Africa gain skills that transform their lives and communities through practical education.
                        </p>
                    </div>

                    <!-- Reason 3 -->
                    <div class="text-center space-y-4">
                        <div class="flex justify-center">
                            <div class="w-24 h-24 flex items-center justify-center">
                                <svg class="w-20 h-20 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">
                            Get rewarded
                        </h3>
                        <p class="text-gray-600 dark:text-gray-400">
                            Earn income from your expertise while making a meaningful impact on education in Africa.
                        </p>
                    </div>

                </div>
            </div>
        </section>

        <!-- How to Begin Section -->
        <section class="py-16 lg:py-24 bg-gray-50 dark:bg-gray-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                <h2 class="text-3xl sm:text-4xl font-bold text-center text-gray-900 dark:text-white mb-16">
                    How to begin
                </h2>

                <div class="grid md:grid-cols-4 gap-8">

                    <!-- Step 1 -->
                    <div class="text-center space-y-4">
                        <div class="flex justify-center">
                            <div class="w-16 h-16 bg-green-600 rounded-full flex items-center justify-center">
                                <span class="text-2xl font-bold text-white">1</span>
                            </div>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                            Sign up
                        </h3>
                        <p class="text-gray-600 dark:text-gray-400">
                            Create your instructor account and complete your profile
                        </p>
                    </div>

                    <!-- Step 2 -->
                    <div class="text-center space-y-4">
                        <div class="flex justify-center">
                            <div class="w-16 h-16 bg-green-600 rounded-full flex items-center justify-center">
                                <span class="text-2xl font-bold text-white">2</span>
                            </div>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                            Create a course
                        </h3>
                        <p class="text-gray-600 dark:text-gray-400">
                            Build your curriculum with videos, materials, and assessments
                        </p>
                    </div>

                    <!-- Step 3 -->
                    <div class="text-center space-y-4">
                        <div class="flex justify-center">
                            <div class="w-16 h-16 bg-green-600 rounded-full flex items-center justify-center">
                                <span class="text-2xl font-bold text-white">3</span>
                            </div>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                            Publish
                        </h3>
                        <p class="text-gray-600 dark:text-gray-400">
                            Submit for review and go live to reach students across Africa
                        </p>
                    </div>

                    <!-- Step 4 -->
                    <div class="text-center space-y-4">
                        <div class="flex justify-center">
                            <div class="w-16 h-16 bg-green-600 rounded-full flex items-center justify-center">
                                <span class="text-2xl font-bold text-white">4</span>
                            </div>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                            Earn & Impact
                        </h3>
                        <p class="text-gray-600 dark:text-gray-400">
                            Get paid while transforming lives through education
                        </p>
                    </div>

                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="py-16 lg:py-24 bg-gradient-to-br from-green-600 to-emerald-700">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-white mb-6">
                    Become an instructor today
                </h2>
                <p class="text-xl text-green-50 mb-8">
                    Join thousands of teachers empowering Africa through education
                </p>
                <a
                    href="{{ route('register') }}?role=teacher"
                    class="inline-block px-10 py-5 bg-white text-green-600 text-lg font-bold rounded-lg hover:bg-gray-100 shadow-xl hover:shadow-2xl transition-all"
                >
                    Get started now
                </a>
            </div>
        </section>

    </main>

    <!-- Footer will go here -->

</body>
</html>
