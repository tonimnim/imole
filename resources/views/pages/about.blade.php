<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>About Us - {{ config('app.name') }}</title>
    <meta name="description" content="Learn about iMole Africa's mission to transform lives through quality education across Africa.">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-white dark:bg-gray-900">

    <x-header />

    <main class="pt-16">
        <!-- Hero Section -->
        <section class="bg-gradient-to-br from-green-700 via-green-600 to-amber-600 text-white py-20 lg:py-28">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-4xl mx-auto">
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold mb-6 leading-tight">
                        Empowering Africa Through <span class="text-yellow-300">Education</span>
                    </h1>
                    <p class="text-xl sm:text-2xl text-green-50 leading-relaxed">
                        We're on a mission to make quality education accessible to every African, transforming lives and building a brighter future for our continent.
                    </p>
                </div>
            </div>
        </section>

        <!-- Mission & Vision -->
        <section class="py-20 bg-white dark:bg-gray-900">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid md:grid-cols-2 gap-12 lg:gap-16">
                    <!-- Mission -->
                    <div class="bg-gradient-to-br from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 rounded-2xl p-8 lg:p-10 border-2 border-green-200 dark:border-green-800">
                        <div class="w-16 h-16 bg-green-600 rounded-xl flex items-center justify-center mb-6">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                        <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">Our Mission</h2>
                        <p class="text-lg text-gray-700 dark:text-gray-300 leading-relaxed">
                            To democratize access to world-class education across Africa by providing affordable, high-quality online courses that empower individuals to achieve their full potential and contribute to their communities.
                        </p>
                    </div>

                    <!-- Vision -->
                    <div class="bg-gradient-to-br from-amber-50 to-yellow-50 dark:from-amber-900/20 dark:to-yellow-900/20 rounded-2xl p-8 lg:p-10 border-2 border-amber-200 dark:border-amber-800">
                        <div class="w-16 h-16 bg-amber-600 rounded-xl flex items-center justify-center mb-6">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </div>
                        <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">Our Vision</h2>
                        <p class="text-lg text-gray-700 dark:text-gray-300 leading-relaxed">
                            To become Africa's leading online learning platform, recognized for excellence in education delivery, innovation in teaching methods, and measurable impact on economic development across the continent.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Core Values -->
        <section class="py-20 bg-gray-50 dark:bg-gray-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 dark:text-white mb-4">Our Core Values</h2>
                    <p class="text-lg text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                        These principles guide everything we do at iMole Africa
                    </p>
                </div>

                <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-8">
                    <!-- Value 1 -->
                    <div class="bg-white dark:bg-gray-900 rounded-xl p-6 border border-gray-200 dark:border-gray-700 hover:border-green-600 dark:hover:border-green-600 transition-all hover:shadow-lg">
                        <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Excellence</h3>
                        <p class="text-gray-600 dark:text-gray-400">
                            We strive for the highest quality in every course, ensuring our students receive world-class education.
                        </p>
                    </div>

                    <!-- Value 2 -->
                    <div class="bg-white dark:bg-gray-900 rounded-xl p-6 border border-gray-200 dark:border-gray-700 hover:border-amber-600 dark:hover:border-amber-600 transition-all hover:shadow-lg">
                        <div class="w-12 h-12 bg-amber-100 dark:bg-amber-900/30 rounded-lg flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-amber-600 dark:text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                                <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Accessibility</h3>
                        <p class="text-gray-600 dark:text-gray-400">
                            Education should be available to everyone, regardless of location or economic status.
                        </p>
                    </div>

                    <!-- Value 3 -->
                    <div class="bg-white dark:bg-gray-900 rounded-xl p-6 border border-gray-200 dark:border-gray-700 hover:border-green-600 dark:hover:border-green-600 transition-all hover:shadow-lg">
                        <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Community</h3>
                        <p class="text-gray-600 dark:text-gray-400">
                            We build strong learning communities where students support and inspire each other.
                        </p>
                    </div>

                    <!-- Value 4 -->
                    <div class="bg-white dark:bg-gray-900 rounded-xl p-6 border border-gray-200 dark:border-gray-700 hover:border-amber-600 dark:hover:border-amber-600 transition-all hover:shadow-lg">
                        <div class="w-12 h-12 bg-amber-100 dark:bg-amber-900/30 rounded-lg flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-amber-600 dark:text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Innovation</h3>
                        <p class="text-gray-600 dark:text-gray-400">
                            We continuously evolve our teaching methods and technology to deliver better learning experiences.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Stats Section -->
        <section class="py-20 bg-gradient-to-r from-green-700 via-green-600 to-amber-600">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl sm:text-4xl font-bold text-white mb-4">Our Impact in Numbers</h2>
                    <p class="text-xl text-green-50">Making a difference across Africa</p>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                    <div class="text-center">
                        <div class="text-5xl sm:text-6xl font-bold text-white mb-2">10K+</div>
                        <div class="text-lg text-green-50 font-semibold">Active Students</div>
                    </div>
                    <div class="text-center">
                        <div class="text-5xl sm:text-6xl font-bold text-white mb-2">500+</div>
                        <div class="text-lg text-green-50 font-semibold">Expert Courses</div>
                    </div>
                    <div class="text-center">
                        <div class="text-5xl sm:text-6xl font-bold text-white mb-2">15+</div>
                        <div class="text-lg text-green-50 font-semibold">Countries</div>
                    </div>
                    <div class="text-center">
                        <div class="text-5xl sm:text-6xl font-bold text-white mb-2">98%</div>
                        <div class="text-lg text-green-50 font-semibold">Success Rate</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="py-20 bg-white dark:bg-gray-900">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 dark:text-white mb-6">
                    Ready to Start Your Learning Journey?
                </h2>
                <p class="text-xl text-gray-600 dark:text-gray-400 mb-8">
                    Join thousands of students transforming their lives through education
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('courses.index') }}" class="inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-bold rounded-xl transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                        Browse Courses
                        <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </a>
                    <a href="{{ route('contact') }}" class="inline-flex items-center justify-center px-8 py-4 border-2 border-gray-900 dark:border-gray-300 text-gray-900 dark:text-white font-bold rounded-xl hover:bg-gray-900 hover:text-white dark:hover:bg-gray-300 dark:hover:text-gray-900 transition-all">
                        Contact Us
                    </a>
                </div>
            </div>
        </section>
    </main>

    <x-footer />

</body>
</html>
