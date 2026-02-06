<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <x-seo
        title="Our Impact"
        description="See how Imole Africa is transforming lives through education. 10,000+ students trained, 15+ countries reached, 5,000+ certificates issued, 98% success rate."
        keywords="education impact, Africa development, student success stories, social impact, education transformation"
        :breadcrumbs="[
            ['name' => 'Home', 'url' => url('/')],
            ['name' => 'Our Impact', 'url' => route('impact')],
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
                        Our <span class="text-yellow-300">Impact</span> Across Africa
                    </h1>
                    <p class="text-xl sm:text-2xl text-green-50 leading-relaxed">
                        Real stories of transformation, growth, and success from our students across the continent.
                    </p>
                </div>
            </div>
        </section>

        <!-- Impact Stats -->
        <section class="py-20 bg-white dark:bg-gray-900">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8 lg:gap-12">
                    <div class="text-center">
                        <div class="text-5xl sm:text-6xl font-bold bg-gradient-to-r from-green-600 to-green-700 bg-clip-text text-transparent mb-3">10,000+</div>
                        <div class="text-lg font-semibold text-gray-900 dark:text-white">Lives Transformed</div>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Active students learning</p>
                    </div>
                    <div class="text-center">
                        <div class="text-5xl sm:text-6xl font-bold bg-gradient-to-r from-amber-600 to-amber-700 bg-clip-text text-transparent mb-3">15+</div>
                        <div class="text-lg font-semibold text-gray-900 dark:text-white">Countries Reached</div>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Across Africa</p>
                    </div>
                    <div class="text-center">
                        <div class="text-5xl sm:text-6xl font-bold bg-gradient-to-r from-green-600 to-green-700 bg-clip-text text-transparent mb-3">5,000+</div>
                        <div class="text-lg font-semibold text-gray-900 dark:text-white">Certificates Earned</div>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Skills validated</p>
                    </div>
                    <div class="text-center">
                        <div class="text-5xl sm:text-6xl font-bold bg-gradient-to-r from-amber-600 to-amber-700 bg-clip-text text-transparent mb-3">98%</div>
                        <div class="text-lg font-semibold text-gray-900 dark:text-white">Success Rate</div>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Course completion</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Success Stories -->
        <section class="py-20 bg-gray-50 dark:bg-gray-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 dark:text-white mb-4">Success Stories</h2>
                    <p class="text-lg text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                        Real transformations from students across Africa
                    </p>
                </div>

                <div class="grid md:grid-cols-3 gap-8">
                    <!-- Story 1 -->
                    <div class="bg-white dark:bg-gray-900 rounded-2xl overflow-hidden shadow-lg border-2 border-gray-200 dark:border-gray-700 hover:border-green-600 dark:hover:border-green-600 transition-all">
                        <div class="h-48 bg-gradient-to-br from-green-100 to-green-200 dark:from-green-900/30 dark:to-green-800/30 flex items-center justify-center">
                            <div class="w-24 h-24 bg-green-600 rounded-full flex items-center justify-center text-white font-bold text-4xl">
                                AK
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="flex items-center gap-1 mb-4">
                                @for($i = 0; $i < 5; $i++)
                                    <svg class="w-5 h-5 text-amber-500 fill-current" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @endfor
                            </div>
                            <p class="text-gray-700 dark:text-gray-300 mb-6 italic">
                                "The agricultural technology course helped me modernize my farm. I've increased my yield by 40% and now supply to major retailers."
                            </p>
                            <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                                <div class="font-bold text-gray-900 dark:text-white">Amina Kamara</div>
                                <div class="text-sm text-gray-600 dark:text-gray-400">Agricultural Entrepreneur 🇰🇪</div>
                            </div>
                        </div>
                    </div>

                    <!-- Story 2 -->
                    <div class="bg-white dark:bg-gray-900 rounded-2xl overflow-hidden shadow-lg border-2 border-gray-200 dark:border-gray-700 hover:border-amber-600 dark:hover:border-amber-600 transition-all">
                        <div class="h-48 bg-gradient-to-br from-amber-100 to-yellow-200 dark:from-amber-900/30 dark:to-yellow-800/30 flex items-center justify-center">
                            <div class="w-24 h-24 bg-amber-600 rounded-full flex items-center justify-center text-white font-bold text-4xl">
                                CO
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="flex items-center gap-1 mb-4">
                                @for($i = 0; $i < 5; $i++)
                                    <svg class="w-5 h-5 text-amber-500 fill-current" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @endfor
                            </div>
                            <p class="text-gray-700 dark:text-gray-300 mb-6 italic">
                                "I landed my dream job as a web developer after completing the full-stack development course. The hands-on projects were exactly what I needed."
                            </p>
                            <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                                <div class="font-bold text-gray-900 dark:text-white">Chidi Okonkwo</div>
                                <div class="text-sm text-gray-600 dark:text-gray-400">Software Developer 🇳🇬</div>
                            </div>
                        </div>
                    </div>

                    <!-- Story 3 -->
                    <div class="bg-white dark:bg-gray-900 rounded-2xl overflow-hidden shadow-lg border-2 border-gray-200 dark:border-gray-700 hover:border-green-600 dark:hover:border-green-600 transition-all">
                        <div class="h-48 bg-gradient-to-br from-green-100 to-amber-100 dark:from-green-900/30 dark:to-amber-800/30 flex items-center justify-center">
                            <div class="w-24 h-24 bg-green-600 rounded-full flex items-center justify-center text-white font-bold text-4xl">
                                FN
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="flex items-center gap-1 mb-4">
                                @for($i = 0; $i < 5; $i++)
                                    <svg class="w-5 h-5 text-amber-500 fill-current" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @endfor
                            </div>
                            <p class="text-gray-700 dark:text-gray-300 mb-6 italic">
                                "The business management courses gave me the skills to scale my boutique from one shop to five locations. I'm now employing 30 people!"
                            </p>
                            <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                                <div class="font-bold text-gray-900 dark:text-white">Fatima Ndlovu</div>
                                <div class="text-sm text-gray-600 dark:text-gray-400">Business Owner 🇬🇭</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="py-20 bg-gradient-to-r from-green-700 via-green-600 to-amber-600">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="text-3xl sm:text-4xl font-bold text-white mb-6">
                    Be Part of Our Success Story
                </h2>
                <p class="text-xl text-green-50 mb-8">
                    Join thousands of students transforming their lives through education
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('courses.index') }}" class="inline-flex items-center justify-center px-8 py-4 bg-white text-green-700 font-bold rounded-xl hover:bg-green-50 transition-all shadow-xl hover:shadow-2xl transform hover:-translate-y-0.5">
                        Start Learning Today
                        <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </a>
                    <a href="{{ route('contact') }}" class="inline-flex items-center justify-center px-8 py-4 border-2 border-white text-white font-bold rounded-xl hover:bg-white hover:text-green-700 transition-all">
                        Share Your Story
                    </a>
                </div>
            </div>
        </section>
    </main>

    <x-footer />

</body>
</html>
