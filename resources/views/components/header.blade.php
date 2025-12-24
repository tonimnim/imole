<!-- Modern Responsive Header -->
<header x-data="{
    mobileMenuOpen: false,
    searchOpen: false,
    scrolled: false
}"
@scroll.window="scrolled = (window.pageYOffset > 20)"
:class="scrolled ? 'shadow-lg bg-white/95 dark:bg-gray-900/95 backdrop-blur-md' : 'bg-white dark:bg-gray-900'"
class="fixed top-0 left-0 right-0 z-50 transition-all duration-300 border-b border-gray-200 dark:border-gray-800">

    <!-- Top Bar -->
    <div class="bg-gradient-to-r from-yellow-600 to-yellow-700 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-10 text-xs sm:text-sm">
                <div class="flex items-center gap-4">
                    <a href="tel:+254700000000" class="flex items-center gap-1.5 hover:text-yellow-200 transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        <span class="hidden sm:inline">+254 700 000 000</span>
                    </a>
                    <span class="hidden md:inline text-yellow-200">|</span>
                    <a href="mailto:info@imoleafrica.org" class="hidden md:flex items-center gap-1.5 hover:text-yellow-200 transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        info@imoleafrica.org
                    </a>
                </div>
                <div class="flex items-center gap-3">
                    @if (Route::has('teacher.register'))
                        <a href="{{ route('teacher.register') }}" class="hidden sm:flex items-center gap-1.5 hover:text-yellow-200 transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                            Become a Teacher
                        </a>
                    @endif
                    <div class="flex items-center gap-2">
                        <a href="#" class="hover:text-yellow-200 transition-colors">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </a>
                        <a href="#" class="hover:text-yellow-200 transition-colors">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z"/>
                            </svg>
                        </a>
                        <a href="#" class="hover:text-yellow-200 transition-colors">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 0C8.74 0 8.333.015 7.053.072 5.775.132 4.905.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.905.131 5.775.072 7.053.012 8.333 0 8.74 0 12s.015 3.667.072 4.947c.06 1.277.261 2.148.558 2.913.306.788.717 1.459 1.384 2.126.667.666 1.336 1.079 2.126 1.384.766.296 1.636.499 2.913.558C8.333 23.988 8.74 24 12 24s3.667-.015 4.947-.072c1.277-.06 2.148-.262 2.913-.558.788-.306 1.459-.718 2.126-1.384.666-.667 1.079-1.335 1.384-2.126.296-.765.499-1.636.558-2.913.06-1.28.072-1.687.072-4.947s-.015-3.667-.072-4.947c-.06-1.277-.262-2.149-.558-2.913-.306-.789-.718-1.459-1.384-2.126C21.319 1.347 20.651.935 19.86.63c-.765-.297-1.636-.499-2.913-.558C15.667.012 15.26 0 12 0zm0 2.16c3.203 0 3.585.016 4.85.071 1.17.055 1.805.249 2.227.415.562.217.96.477 1.382.896.419.42.679.819.896 1.381.164.422.36 1.057.413 2.227.057 1.266.07 1.646.07 4.85s-.015 3.585-.074 4.85c-.061 1.17-.256 1.805-.421 2.227-.224.562-.479.96-.899 1.382-.419.419-.824.679-1.38.896-.42.164-1.065.36-2.235.413-1.274.057-1.649.07-4.859.07-3.211 0-3.586-.015-4.859-.074-1.171-.061-1.816-.256-2.236-.421-.569-.224-.96-.479-1.379-.899-.421-.419-.69-.824-.9-1.38-.165-.42-.359-1.065-.42-2.235-.045-1.26-.061-1.649-.061-4.844 0-3.196.016-3.586.061-4.861.061-1.17.255-1.814.42-2.234.21-.57.479-.96.9-1.381.419-.419.81-.689 1.379-.898.42-.166 1.051-.361 2.221-.421 1.275-.045 1.65-.06 4.859-.06l.045.03zm0 3.678c-3.405 0-6.162 2.76-6.162 6.162 0 3.405 2.76 6.162 6.162 6.162 3.405 0 6.162-2.76 6.162-6.162 0-3.405-2.76-6.162-6.162-6.162zM12 16c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm7.846-10.405c0 .795-.646 1.44-1.44 1.44-.795 0-1.44-.646-1.44-1.44 0-.794.646-1.439 1.44-1.439.793-.001 1.44.645 1.44 1.439z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Navigation -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 lg:h-20">

            <!-- Logo -->
            <div class="flex-shrink-0">
                <a href="/" class="flex items-center gap-3 group">
                    <div class="relative">
                        <div class="absolute inset-0 bg-yellow-600 rounded-xl blur-sm group-hover:blur-md transition-all opacity-50"></div>
                        <img src="{{ asset('images/image.jpeg') }}" alt="Imole Africa" class="relative h-12 w-12 lg:h-12 lg:w-12">
                    </div>
                    <div class="hidden sm:flex flex-col">
                        <span class="text-xl lg:text-2xl font-bold text-gray-900 dark:text-white leading-tight">Imole Africa</span>
                        <span class="text-xs text-yellow-600 dark:text-yellow-400 font-medium">Lighting the Future</span>
                    </div>
                </a>
            </div>

            <!-- Desktop Navigation -->
            <nav class="hidden lg:flex items-center space-x-1">
                <a href="/" class="px-4 py-2 text-sm font-semibold text-gray-700 dark:text-gray-300 hover:text-yellow-600 dark:hover:text-yellow-400 hover:bg-yellow-50 dark:hover:bg-yellow-900/20 rounded-lg transition-all relative group">
                    <span>Home</span>
                    <span class="absolute bottom-0 left-1/2 -translate-x-1/2 w-0 h-0.5 bg-yellow-600 group-hover:w-3/4 transition-all duration-300"></span>
                </a>

                <!-- Courses Mega Menu -->
                <div x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false" class="relative">
                    <button class="px-4 py-2 text-sm font-semibold text-gray-700 dark:text-gray-300 hover:text-yellow-600 dark:hover:text-yellow-400 hover:bg-yellow-50 dark:hover:bg-yellow-900/20 rounded-lg transition-all flex items-center gap-1.5 group">
                        <span>Courses</span>
                        <svg class="w-4 h-4 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    <!-- Mega Menu Dropdown -->
                    <div x-show="open"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-1"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 translate-y-1"
                         class="absolute left-0 mt-2 w-[600px] bg-white dark:bg-gray-800 rounded-2xl shadow-2xl border border-gray-200 dark:border-gray-700 overflow-hidden"
                         style="display: none;">
                        <div class="grid grid-cols-2">
                            <!-- Left Column -->
                            <div class="p-6 bg-gradient-to-br from-yellow-50 to-white dark:from-yellow-900/20 dark:to-gray-800 border-r border-gray-200 dark:border-gray-700">
                                <h3 class="text-sm font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                    </svg>
                                    Browse by Category
                                </h3>
                                <div class="space-y-1">
                                    <a href="{{ route('courses.index') }}?category=agriculture" class="flex items-center gap-3 px-3 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-white dark:hover:bg-gray-700/50 hover:text-yellow-600 dark:hover:text-yellow-400 rounded-lg transition-colors group">
                                        <div class="w-8 h-8 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                                            <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="font-medium">Agriculture</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">Farming & Sustainability</div>
                                        </div>
                                    </a>
                                    <a href="{{ route('courses.index') }}?category=technology" class="flex items-center gap-3 px-3 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-white dark:hover:bg-gray-700/50 hover:text-yellow-600 dark:hover:text-yellow-400 rounded-lg transition-colors group">
                                        <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                                            <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="font-medium">Technology</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">Coding & Digital Skills</div>
                                        </div>
                                    </a>
                                    <a href="{{ route('courses.index') }}?category=vocational" class="flex items-center gap-3 px-3 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-white dark:hover:bg-gray-700/50 hover:text-yellow-600 dark:hover:text-yellow-400 rounded-lg transition-colors group">
                                        <div class="w-8 h-8 bg-orange-100 dark:bg-orange-900/30 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                                            <svg class="w-4 h-4 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="font-medium">Vocational Skills</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">Trade & Crafts</div>
                                        </div>
                                    </a>
                                    <a href="{{ route('courses.index') }}?category=business" class="flex items-center gap-3 px-3 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-white dark:hover:bg-gray-700/50 hover:text-yellow-600 dark:hover:text-yellow-400 rounded-lg transition-colors group">
                                        <div class="w-8 h-8 bg-yellow-100 dark:bg-yellow-900/30 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                                            <svg class="w-4 h-4 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="font-medium">Business</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">Entrepreneurship</div>
                                        </div>
                                    </a>
                                </div>
                            </div>

                            <!-- Right Column -->
                            <div class="p-6">
                                <h3 class="text-sm font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                    </svg>
                                    Quick Links
                                </h3>
                                <div class="space-y-1">
                                    <a href="{{ route('courses.index') }}" class="flex items-center gap-3 px-3 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-yellow-50 dark:hover:bg-yellow-900/20 hover:text-yellow-600 dark:hover:text-yellow-400 rounded-lg transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                        </svg>
                                        All Courses
                                    </a>
                                    <a href="{{ route('courses.index') }}?filter=free" class="flex items-center gap-3 px-3 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-yellow-50 dark:hover:bg-yellow-900/20 hover:text-yellow-600 dark:hover:text-yellow-400 rounded-lg transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        Free Courses
                                    </a>
                                    <a href="{{ route('courses.index') }}?filter=featured" class="flex items-center gap-3 px-3 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-yellow-50 dark:hover:bg-yellow-900/20 hover:text-yellow-600 dark:hover:text-yellow-400 rounded-lg transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                                        </svg>
                                        Featured Courses
                                    </a>
                                    <a href="{{ route('courses.index') }}?filter=popular" class="flex items-center gap-3 px-3 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-yellow-50 dark:hover:bg-yellow-900/20 hover:text-yellow-600 dark:hover:text-yellow-400 rounded-lg transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                                        </svg>
                                        Popular Courses
                                    </a>
                                </div>

                                <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                                    <a href="{{ route('courses.index') }}" class="flex items-center justify-between px-4 py-3 bg-gradient-to-r from-yellow-600 to-yellow-700 text-white rounded-lg hover:from-yellow-700 hover:to-yellow-800 transition-all group">
                                        <span class="font-semibold">Browse All Courses</span>
                                        <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <a href="/#programs" class="px-4 py-2 text-sm font-semibold text-gray-700 dark:text-gray-300 hover:text-yellow-600 dark:hover:text-yellow-400 hover:bg-yellow-50 dark:hover:bg-yellow-900/20 rounded-lg transition-all relative group">
                    <span>Programs</span>
                    <span class="absolute bottom-0 left-1/2 -translate-x-1/2 w-0 h-0.5 bg-yellow-600 group-hover:w-3/4 transition-all duration-300"></span>
                </a>
                <a href="/#about" class="px-4 py-2 text-sm font-semibold text-gray-700 dark:text-gray-300 hover:text-yellow-600 dark:hover:text-yellow-400 hover:bg-yellow-50 dark:hover:bg-yellow-900/20 rounded-lg transition-all relative group">
                    <span>About</span>
                    <span class="absolute bottom-0 left-1/2 -translate-x-1/2 w-0 h-0.5 bg-yellow-600 group-hover:w-3/4 transition-all duration-300"></span>
                </a>
                <a href="/#impact" class="px-4 py-2 text-sm font-semibold text-gray-700 dark:text-gray-300 hover:text-yellow-600 dark:hover:text-yellow-400 hover:bg-yellow-50 dark:hover:bg-yellow-900/20 rounded-lg transition-all relative group">
                    <span>Impact</span>
                    <span class="absolute bottom-0 left-1/2 -translate-x-1/2 w-0 h-0.5 bg-yellow-600 group-hover:w-3/4 transition-all duration-300"></span>
                </a>
                <a href="/#contact" class="px-4 py-2 text-sm font-semibold text-gray-700 dark:text-gray-300 hover:text-yellow-600 dark:hover:text-yellow-400 hover:bg-yellow-50 dark:hover:bg-yellow-900/20 rounded-lg transition-all relative group">
                    <span>Contact</span>
                    <span class="absolute bottom-0 left-1/2 -translate-x-1/2 w-0 h-0.5 bg-yellow-600 group-hover:w-3/4 transition-all duration-300"></span>
                </a>
            </nav>

            <!-- Right Actions -->
            <div class="flex items-center gap-2">
                <!-- Search Button -->
                <button @click="searchOpen = !searchOpen" class="p-2.5 text-gray-700 dark:text-gray-300 hover:bg-yellow-50 dark:hover:bg-yellow-900/20 hover:text-yellow-600 dark:hover:text-yellow-400 rounded-lg transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </button>

                <!-- Desktop Auth -->
                <div class="hidden lg:flex items-center gap-2">
                    @if (Route::has('login'))
                        @auth
                            <!-- User Dropdown -->
                            <div x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false" class="relative">
                                <button class="flex items-center gap-2 px-3 py-2 hover:bg-yellow-50 dark:hover:bg-yellow-900/20 rounded-lg transition-all">
                                    <div class="w-9 h-9 bg-gradient-to-br from-yellow-600 to-yellow-700 rounded-full flex items-center justify-center ring-2 ring-yellow-200 dark:ring-yellow-800">
                                        <span class="text-white text-sm font-bold">{{ substr(auth()->user()->name, 0, 1) }}</span>
                                    </div>
                                    <span class="hidden xl:block text-sm font-semibold text-gray-700 dark:text-gray-300">{{ auth()->user()->name }}</span>
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </button>

                                <div x-show="open"
                                     x-transition:enter="transition ease-out duration-200"
                                     x-transition:enter-start="opacity-0 scale-95"
                                     x-transition:enter-end="opacity-100 scale-100"
                                     x-transition:leave="transition ease-in duration-150"
                                     x-transition:leave-start="opacity-100 scale-100"
                                     x-transition:leave-end="opacity-0 scale-95"
                                     class="absolute right-0 mt-2 w-56 bg-white dark:bg-gray-800 rounded-xl shadow-2xl border border-gray-200 dark:border-gray-700 py-2 overflow-hidden"
                                     style="display: none;">
                                    <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-700">
                                        <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ auth()->user()->name }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ auth()->user()->email }}</p>
                                    </div>
                                    <a href="{{ url('/dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-yellow-50 dark:hover:bg-yellow-900/20 hover:text-yellow-600 dark:hover:text-yellow-400 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                        </svg>
                                        Dashboard
                                    </a>
                                    <a href="#" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-yellow-50 dark:hover:bg-yellow-900/20 hover:text-yellow-600 dark:hover:text-yellow-400 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                        My Profile
                                    </a>
                                    <a href="#" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-yellow-50 dark:hover:bg-yellow-900/20 hover:text-yellow-600 dark:hover:text-yellow-400 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                        Settings
                                    </a>
                                    <div class="border-t border-gray-200 dark:border-gray-700 my-2"></div>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="w-full text-left flex items-center gap-3 px-4 py-2.5 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                            </svg>
                                            Logout
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @else
                            <a href="{{ route('login') }}" class="px-5 py-2.5 text-sm font-semibold text-gray-700 dark:text-gray-300 hover:text-yellow-600 dark:hover:text-yellow-400 hover:bg-yellow-50 dark:hover:bg-yellow-900/20 rounded-lg transition-all">
                                Log in
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="px-5 py-2.5 bg-gradient-to-r from-yellow-600 to-yellow-700 text-white text-sm font-semibold rounded-lg hover:from-yellow-700 hover:to-yellow-800 transition-all shadow-lg hover:shadow-xl flex items-center gap-2">
                                    <span>Get Started</span>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                    </svg>
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>

                <!-- Mobile Menu Button -->
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="lg:hidden p-2.5 text-gray-700 dark:text-gray-300 hover:bg-yellow-50 dark:hover:bg-yellow-900/20 hover:text-yellow-600 dark:hover:text-yellow-400 rounded-lg transition-all">
                    <svg class="w-6 h-6" :class="mobileMenuOpen ? 'hidden' : 'block'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg class="w-6 h-6" :class="mobileMenuOpen ? 'block' : 'hidden'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Search Bar (Full Width) -->
    <div x-show="searchOpen"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         class="border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50"
         style="display: none;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="relative max-w-3xl mx-auto">
                <input type="text" placeholder="Search for courses, programs, or topics..." class="w-full px-5 py-4 pl-12 pr-12 border-2 border-yellow-200 dark:border-yellow-800 rounded-xl bg-white dark:bg-gray-900 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition-all text-lg" autofocus>
                <svg class="absolute left-4 top-4.5 w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <button @click="searchOpen = false" class="absolute right-3 top-3 p-1.5 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <p class="text-center text-sm text-gray-500 dark:text-gray-400 mt-3">
                Press <kbd class="px-2 py-1 text-xs font-semibold text-gray-800 dark:text-gray-200 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded">ESC</kbd> to close
            </p>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="mobileMenuOpen"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="lg:hidden border-t border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900"
         style="display: none;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-6 space-y-4 max-h-[calc(100vh-80px)] overflow-y-auto">
            <!-- Mobile Navigation Links -->
            <nav class="space-y-1">
                <a href="/" class="flex items-center gap-3 px-4 py-3 text-gray-700 dark:text-gray-300 hover:bg-yellow-50 dark:hover:bg-yellow-900/20 hover:text-yellow-600 dark:hover:text-yellow-400 rounded-lg font-semibold transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    Home
                </a>
                <a href="{{ route('courses.index') }}" class="flex items-center gap-3 px-4 py-3 text-gray-700 dark:text-gray-300 hover:bg-yellow-50 dark:hover:bg-yellow-900/20 hover:text-yellow-600 dark:hover:text-yellow-400 rounded-lg font-semibold transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M12 14l9-5-9-5-9 5 9 5z"/>
                        <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"/>
                    </svg>
                    Courses
                </a>
                <a href="/#programs" class="flex items-center gap-3 px-4 py-3 text-gray-700 dark:text-gray-300 hover:bg-yellow-50 dark:hover:bg-yellow-900/20 hover:text-yellow-600 dark:hover:text-yellow-400 rounded-lg font-semibold transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                    Programs
                </a>
                <a href="/#about" class="flex items-center gap-3 px-4 py-3 text-gray-700 dark:text-gray-300 hover:bg-yellow-50 dark:hover:bg-yellow-900/20 hover:text-yellow-600 dark:hover:text-yellow-400 rounded-lg font-semibold transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    About
                </a>
                <a href="/#impact" class="flex items-center gap-3 px-4 py-3 text-gray-700 dark:text-gray-300 hover:bg-yellow-50 dark:hover:bg-yellow-900/20 hover:text-yellow-600 dark:hover:text-yellow-400 rounded-lg font-semibold transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    Impact
                </a>
                <a href="/#contact" class="flex items-center gap-3 px-4 py-3 text-gray-700 dark:text-gray-300 hover:bg-yellow-50 dark:hover:bg-yellow-900/20 hover:text-yellow-600 dark:hover:text-yellow-400 rounded-lg font-semibold transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    Contact
                </a>
            </nav>

            <!-- Mobile Auth Actions -->
            @if (Route::has('login'))
                <div class="border-t border-gray-200 dark:border-gray-700 pt-4 space-y-2">
                    @auth
                        <div class="px-4 py-3 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg">
                            <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ auth()->user()->email }}</p>
                        </div>
                        <a href="{{ url('/dashboard') }}" class="flex items-center justify-center gap-2 w-full px-4 py-3 bg-gradient-to-r from-yellow-600 to-yellow-700 text-white rounded-lg font-semibold hover:from-yellow-700 hover:to-yellow-800 transition-all shadow-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                            Go to Dashboard
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full px-4 py-3 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg font-semibold transition-all">
                                Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="flex items-center justify-center w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300 rounded-lg font-semibold hover:border-yellow-600 dark:hover:border-yellow-400 hover:text-yellow-600 dark:hover:text-yellow-400 transition-all">
                            Log in
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="flex items-center justify-center gap-2 w-full px-4 py-3 bg-gradient-to-r from-yellow-600 to-yellow-700 text-white rounded-lg font-semibold hover:from-yellow-700 hover:to-yellow-800 transition-all shadow-lg">
                                <span>Get Started Free</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                </svg>
                            </a>
                        @endif
                    @endauth
                </div>
            @endif
        </div>
    </div>
</header>
