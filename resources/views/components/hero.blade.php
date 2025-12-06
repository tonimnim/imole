<!-- Premium Hero Section -->
<section class="relative pt-24 pb-12 bg-gradient-to-br from-green-50 via-yellow-50 to-white dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 overflow-hidden">
    <!-- Decorative Elements -->
    <div class="absolute top-0 right-0 w-1/2 h-full opacity-10">
        <svg viewBox="0 0 200 200" class="w-full h-full">
            <circle cx="100" cy="100" r="80" fill="#EAB308"/>
        </svg>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-12 items-center">

            <!-- Left Content -->
            <div class="space-y-8">
                <!-- Badge -->
                <div class="inline-flex items-center space-x-2 px-4 py-2 bg-yellow-100 dark:bg-yellow-900/30 rounded-full border border-yellow-300 dark:border-yellow-700">
                    <svg class="w-5 h-5 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                    <span class="text-sm font-semibold text-yellow-900 dark:text-yellow-200">#1 Education Platform in Africa</span>
                </div>

                <!-- Headline -->
                <h1 class="text-5xl lg:text-6xl xl:text-7xl font-bold leading-tight">
                    <span class="text-gray-900 dark:text-white">Empower Your</span>
                    <span class="block text-green-600">Future with Quality</span>
                    <span class="block text-yellow-600">Education</span>
                </h1>

                <p class="text-xl text-gray-600 dark:text-gray-300 max-w-xl">
                    Join thousands of learners across Africa accessing world-class courses in agriculture, technology, and vocational skills. Learn at your own pace, earn certificates, and transform your career.
                </p>

                <!-- CTA Buttons -->
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-8 py-4 bg-green-600 text-white text-lg font-semibold rounded-lg hover:bg-green-700 shadow-lg hover:shadow-xl transition-all">
                        Start Learning Free
                        <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </a>
                    <a href="#all-courses" class="inline-flex items-center justify-center px-8 py-4 bg-white dark:bg-gray-800 text-gray-900 dark:text-white text-lg font-semibold rounded-lg border-2 border-gray-200 dark:border-gray-700 hover:border-green-600 dark:hover:border-green-600 transition-all">
                        Explore Courses
                    </a>
                </div>

                <!-- Trust Indicators -->
                <div class="flex items-center space-x-8 pt-4">
                    <div class="flex items-center space-x-2">
                        <div class="flex -space-x-2">
                            <div class="w-10 h-10 rounded-full bg-green-200 border-2 border-white flex items-center justify-center text-sm font-bold text-green-700">5K</div>
                            <div class="w-10 h-10 rounded-full bg-yellow-200 border-2 border-white flex items-center justify-center text-sm font-bold text-yellow-700">+</div>
                        </div>
                        <div class="text-sm">
                            <div class="font-semibold text-gray-900 dark:text-white">5,000+ Students</div>
                            <div class="text-gray-600 dark:text-gray-400">Learning Today</div>
                        </div>
                    </div>
                    <div class="text-sm">
                        <div class="flex items-center space-x-1">
                            <span class="text-2xl font-bold text-gray-900 dark:text-white">4.8</span>
                            <div class="flex text-yellow-400">
                                <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            </div>
                        </div>
                        <div class="text-gray-600 dark:text-gray-400">Average Rating</div>
                    </div>
                </div>
            </div>

            <!-- Right Visual -->
            <div class="relative">
                <div class="relative z-10">
                    <!-- Main Image Container -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl p-8">
                        <img src="{{ asset('images/logo.png') }}" alt="Imole Africa" class="w-full h-auto">
                    </div>

                    <!-- Floating Card 1 -->
                    <div class="absolute -left-4 top-20 bg-white dark:bg-gray-800 rounded-lg shadow-xl p-4 max-w-xs">
                        <div class="flex items-center space-x-3">
                            <div class="flex-shrink-0 w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"/>
                                </svg>
                            </div>
                            <div>
                                <div class="text-2xl font-bold text-gray-900 dark:text-white">1,200+</div>
                                <div class="text-sm text-gray-600 dark:text-gray-400">Courses Available</div>
                            </div>
                        </div>
                    </div>

                    <!-- Floating Card 2 -->
                    <div class="absolute -right-4 bottom-20 bg-white dark:bg-gray-800 rounded-lg shadow-xl p-4">
                        <div class="flex items-center space-x-3">
                            <div class="flex-shrink-0 w-12 h-12 bg-yellow-100 dark:bg-yellow-900/30 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3z"/>
                                </svg>
                            </div>
                            <div>
                                <div class="text-2xl font-bold text-gray-900 dark:text-white">15</div>
                                <div class="text-sm text-gray-600 dark:text-gray-400">Countries</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Wave Divider -->
    <div class="absolute bottom-0 left-0 right-0">
        <svg viewBox="0 0 1440 120" class="w-full h-20 fill-white dark:fill-gray-900">
            <path d="M0,64L48,69.3C96,75,192,85,288,80C384,75,480,53,576,48C672,43,768,53,864,58.7C960,64,1056,64,1152,58.7C1248,53,1344,43,1392,37.3L1440,32L1440,120L1392,120C1344,120,1248,120,1152,120C1056,120,960,120,864,120C768,120,672,120,576,120C480,120,384,120,288,120C192,120,96,120,48,120L0,120Z"></path>
        </svg>
    </div>
</section>
