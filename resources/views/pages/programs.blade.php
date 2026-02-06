<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <x-seo
        title="Our Programs"
        description="Explore Imole Africa's programs in Agriculture & Farming, Technology & IT, Business & Entrepreneurship, and Vocational Skills. Empowering Africans with skills for the future."
        keywords="education programs, agriculture courses, technology training, business entrepreneurship, vocational skills, Africa programs"
        :faq="[
            ['question' => 'What programs does Imole Africa offer?', 'answer' => 'Imole Africa offers programs in Agriculture & Farming, Technology & IT, Business & Entrepreneurship, and Vocational Skills designed to empower Africans with practical skills.'],
            ['question' => 'Are the programs suitable for beginners?', 'answer' => 'Yes, our programs cater to all levels from beginners to advanced learners, with structured curricula that progress from fundamentals to specialized skills.'],
            ['question' => 'Do I get a certificate after completing a program?', 'answer' => 'Yes, upon successful completion of a program, you receive a certificate that validates your skills and knowledge.'],
        ]"
        :breadcrumbs="[
            ['name' => 'Home', 'url' => url('/')],
            ['name' => 'Programs', 'url' => route('programs')],
        ]"
    />
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
                        Transform Your Future with Our <span class="text-yellow-300">Programs</span>
                    </h1>
                    <p class="text-xl sm:text-2xl text-green-50 leading-relaxed mb-8">
                        Comprehensive courses designed to equip you with in-demand skills across technology, agriculture, business, and vocational training.
                    </p>
                    <a href="{{ route('courses.index') }}" class="inline-flex items-center px-8 py-4 bg-white text-green-700 font-bold rounded-xl hover:bg-green-50 transition-all shadow-xl hover:shadow-2xl transform hover:-translate-y-0.5">
                        Explore All Courses
                        <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </a>
                </div>
            </div>
        </section>

        <!-- Program Categories -->
        <section class="py-20 bg-white dark:bg-gray-900">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 dark:text-white mb-4">Our Program Categories</h2>
                    <p class="text-lg text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                        Choose from our diverse range of programs tailored to African learners
                    </p>
                </div>

                <div class="grid md:grid-cols-2 gap-8">
                    <!-- Agriculture & Farming -->
                    <div class="group bg-gradient-to-br from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 rounded-2xl p-8 border-2 border-green-200 dark:border-green-800 hover:border-green-600 dark:hover:border-green-600 transition-all hover:shadow-xl">
                        <div class="flex items-start gap-6">
                            <div class="w-16 h-16 bg-green-600 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                                <span class="text-3xl">🌾</span>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-3">Agriculture & Farming</h3>
                                <p class="text-gray-700 dark:text-gray-300 mb-4">
                                    Modern farming techniques, agribusiness management, sustainable agriculture, and agricultural technology.
                                </p>
                                <a href="{{ route('courses.index', ['category' => 'agriculture']) }}" class="inline-flex items-center text-green-700 dark:text-green-400 font-semibold hover:text-green-800 dark:hover:text-green-300">
                                    View Courses
                                    <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Technology & IT -->
                    <div class="group bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-2xl p-8 border-2 border-blue-200 dark:border-blue-800 hover:border-blue-600 dark:hover:border-blue-600 transition-all hover:shadow-xl">
                        <div class="flex items-start gap-6">
                            <div class="w-16 h-16 bg-blue-600 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                                <span class="text-3xl">💻</span>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-3">Technology & IT</h3>
                                <p class="text-gray-700 dark:text-gray-300 mb-4">
                                    Web development, mobile apps, data science, cybersecurity, and emerging technologies.
                                </p>
                                <a href="{{ route('courses.index', ['category' => 'technology']) }}" class="inline-flex items-center text-blue-700 dark:text-blue-400 font-semibold hover:text-blue-800 dark:hover:text-blue-300">
                                    View Courses
                                    <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Business & Entrepreneurship -->
                    <div class="group bg-gradient-to-br from-amber-50 to-yellow-50 dark:from-amber-900/20 dark:to-yellow-900/20 rounded-2xl p-8 border-2 border-amber-200 dark:border-amber-800 hover:border-amber-600 dark:hover:border-amber-600 transition-all hover:shadow-xl">
                        <div class="flex items-start gap-6">
                            <div class="w-16 h-16 bg-amber-600 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                                <span class="text-3xl">💼</span>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-3">Business & Entrepreneurship</h3>
                                <p class="text-gray-700 dark:text-gray-300 mb-4">
                                    Business management, marketing, finance, leadership, and startup development.
                                </p>
                                <a href="{{ route('courses.index', ['category' => 'business']) }}" class="inline-flex items-center text-amber-700 dark:text-amber-400 font-semibold hover:text-amber-800 dark:hover:text-amber-300">
                                    View Courses
                                    <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Vocational Skills -->
                    <div class="group bg-gradient-to-br from-purple-50 to-pink-50 dark:from-purple-900/20 dark:to-pink-900/20 rounded-2xl p-8 border-2 border-purple-200 dark:border-purple-800 hover:border-purple-600 dark:hover:border-purple-600 transition-all hover:shadow-xl">
                        <div class="flex items-start gap-6">
                            <div class="w-16 h-16 bg-purple-600 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                                <span class="text-3xl">🔧</span>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-3">Vocational Skills</h3>
                                <p class="text-gray-700 dark:text-gray-300 mb-4">
                                    Practical skills in construction, electrical work, plumbing, tailoring, and other trades.
                                </p>
                                <a href="{{ route('courses.index', ['category' => 'vocational']) }}" class="inline-flex items-center text-purple-700 dark:text-purple-400 font-semibold hover:text-purple-800 dark:hover:text-purple-300">
                                    View Courses
                                    <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Benefits Section -->
        <section class="py-20 bg-gray-50 dark:bg-gray-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 dark:text-white mb-4">Why Choose Our Programs?</h2>
                    <p class="text-lg text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                        Benefits designed specifically for African learners
                    </p>
                </div>

                <div class="grid md:grid-cols-3 gap-8">
                    <div class="bg-white dark:bg-gray-900 rounded-xl p-6 border border-gray-200 dark:border-gray-700">
                        <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Flexible Learning</h3>
                        <p class="text-gray-600 dark:text-gray-400">
                            Study at your own pace, anytime, anywhere. Perfect for working professionals and students.
                        </p>
                    </div>

                    <div class="bg-white dark:bg-gray-900 rounded-xl p-6 border border-gray-200 dark:border-gray-700">
                        <div class="w-12 h-12 bg-amber-100 dark:bg-amber-900/30 rounded-lg flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-amber-600 dark:text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Expert Instructors</h3>
                        <p class="text-gray-600 dark:text-gray-400">
                            Learn from industry professionals with real-world experience in African markets.
                        </p>
                    </div>

                    <div class="bg-white dark:bg-gray-900 rounded-xl p-6 border border-gray-200 dark:border-gray-700">
                        <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Verified Certificates</h3>
                        <p class="text-gray-600 dark:text-gray-400">
                            Earn recognized certificates to boost your career and showcase your skills.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="py-20 bg-gradient-to-r from-green-700 via-green-600 to-amber-600">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="text-3xl sm:text-4xl font-bold text-white mb-6">
                    Ready to Start Learning?
                </h2>
                <p class="text-xl text-green-50 mb-8">
                    Browse our courses and find the perfect program for your goals
                </p>
                <a href="{{ route('courses.index') }}" class="inline-flex items-center px-8 py-4 bg-white text-green-700 font-bold rounded-xl hover:bg-green-50 transition-all shadow-xl hover:shadow-2xl transform hover:-translate-y-0.5">
                    Explore All Courses
                    <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                </a>
            </div>
        </section>
    </main>

    <x-footer />

</body>
</html>
