<!-- Header Component - Simple and Clean -->
<header
    x-data="{
        mobileMenuOpen: false,
        coursesDropdownOpen: false
    }"
    class="fixed top-0 left-0 right-0 z-50 bg-white dark:bg-gray-900 shadow-md"
>
    <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">

            <!-- Logo -->
            <div class="flex-shrink-0">
                <a href="/" class="flex items-center space-x-2">
                    <div class="w-10 h-10 bg-green-600 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/>
                        </svg>
                    </div>
                    <span class="text-xl font-bold text-gray-900 dark:text-white">
                        ImoleAfrica
                    </span>
                </a>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden lg:flex lg:items-center lg:space-x-8">
                <!-- Courses Dropdown -->
                <div
                    class="relative"
                    @mouseenter="coursesDropdownOpen = true"
                    @mouseleave="coursesDropdownOpen = false"
                >
                    <button class="text-gray-900 dark:text-white hover:text-green-600 font-medium flex items-center space-x-1">
                        <span>Courses</span>
                        <svg class="w-4 h-4" :class="{ 'rotate-180': coursesDropdownOpen }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    <!-- Courses Dropdown Menu -->
                    <div
                        x-show="coursesDropdownOpen"
                        class="absolute left-0 mt-2 w-56 rounded-lg shadow-lg bg-white dark:bg-gray-800 ring-1 ring-black ring-opacity-5"
                        style="display: none;"
                    >
                        <div class="py-2">
                            <a href="#agriculture" class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-green-50 dark:hover:bg-gray-700">
                                <span class="mr-2">🌾</span> Agriculture
                            </a>
                            <a href="#horticulture" class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-green-50 dark:hover:bg-gray-700">
                                <span class="mr-2">🌸</span> Horticulture
                            </a>
                            <a href="#vocational" class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-green-50 dark:hover:bg-gray-700">
                                <span class="mr-2">🔨</span> Vocational Skills
                            </a>
                            <div class="border-t border-gray-200 dark:border-gray-700 my-2"></div>
                            <a href="#all-courses" class="flex items-center px-4 py-2 text-sm text-green-600 dark:text-green-400 hover:bg-green-50 dark:hover:bg-gray-700 font-medium">
                                View All Courses →
                            </a>
                        </div>
                    </div>
                </div>

                <!-- About Us -->
                <a href="#about" class="text-gray-900 dark:text-white hover:text-green-600 font-medium">
                    About Us
                </a>

                <!-- How It Works -->
                <a href="#how-it-works" class="text-gray-900 dark:text-white hover:text-green-600 font-medium">
                    How It Works
                </a>

                <!-- Contact -->
                <a href="#contact" class="text-gray-900 dark:text-white hover:text-green-600 font-medium">
                    Contact
                </a>

                <!-- Partners -->
                <a href="#partners" class="text-gray-900 dark:text-white hover:text-green-600 font-medium">
                    Partners
                </a>
            </div>

            <!-- Right Side Actions -->
            <div class="hidden lg:flex lg:items-center lg:space-x-4">

                <!-- Login Button -->
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-5 py-2.5 text-gray-900 dark:text-white border border-gray-300 dark:border-gray-600 rounded-lg hover:border-green-600 font-medium">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="px-5 py-2.5 text-gray-900 dark:text-white border border-gray-300 dark:border-gray-600 rounded-lg hover:border-green-600 font-medium">
                            Login
                        </a>

                        <!-- Sign Up Button -->
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="px-5 py-2.5 bg-green-600 text-white rounded-lg hover:bg-green-700 font-medium shadow-lg hover:shadow-xl">
                                Sign Up
                            </a>
                        @endif
                    @endauth
                @endif
            </div>

            <!-- Mobile Menu Button -->
            <div class="lg:hidden">
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="p-2 text-gray-900 dark:text-white rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800">
                    <svg class="w-6 h-6" :class="{ 'hidden': mobileMenuOpen, 'block': !mobileMenuOpen }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg class="w-6 h-6" :class="{ 'block': mobileMenuOpen, 'hidden': !mobileMenuOpen }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </nav>

    <!-- Mobile Menu -->
    <div
        x-show="mobileMenuOpen"
        class="lg:hidden bg-white dark:bg-gray-900 border-t border-gray-200 dark:border-gray-800"
        style="display: none;"
    >
        <div class="px-4 py-6 space-y-4">
            <!-- Mobile Navigation Links -->

            <!-- Mobile Courses Dropdown -->
            <div>
                <button
                    @click="coursesDropdownOpen = !coursesDropdownOpen"
                    class="flex items-center justify-between w-full text-gray-900 dark:text-white hover:text-green-600 font-medium py-2"
                >
                    <span>Courses</span>
                    <svg class="w-4 h-4" :class="{ 'rotate-180': coursesDropdownOpen }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="coursesDropdownOpen" class="ml-4 mt-2 space-y-2" style="display: none;">
                    <a href="#agriculture" class="block text-gray-600 dark:text-gray-400 hover:text-green-600 py-1">
                        🌾 Agriculture
                    </a>
                    <a href="#horticulture" class="block text-gray-600 dark:text-gray-400 hover:text-green-600 py-1">
                        🌸 Horticulture
                    </a>
                    <a href="#vocational" class="block text-gray-600 dark:text-gray-400 hover:text-green-600 py-1">
                        🔨 Vocational Skills
                    </a>
                    <a href="#all-courses" class="block text-green-600 dark:text-green-400 font-medium py-1">
                        View All Courses →
                    </a>
                </div>
            </div>

            <a href="#about" class="block text-gray-900 dark:text-white hover:text-green-600 font-medium py-2">
                About Us
            </a>
            <a href="#how-it-works" class="block text-gray-900 dark:text-white hover:text-green-600 font-medium py-2">
                How It Works
            </a>
            <a href="#contact" class="block text-gray-900 dark:text-white hover:text-green-600 font-medium py-2">
                Contact
            </a>
            <a href="#partners" class="block text-gray-900 dark:text-white hover:text-green-600 font-medium py-2">
                Partners
            </a>

            <!-- Mobile Auth Buttons -->
            @if (Route::has('login'))
                <div class="border-t border-gray-200 dark:border-gray-800 pt-4 mt-4 space-y-3">
                    @auth
                        <a
                            href="{{ url('/dashboard') }}"
                            class="block w-full text-center px-5 py-3 bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-white rounded-lg font-medium hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors"
                        >
                            Dashboard
                        </a>
                    @else
                        <a
                            href="{{ route('login') }}"
                            class="block w-full text-center px-5 py-3 bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-white rounded-lg font-medium hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors"
                        >
                            Login
                        </a>
                        @if (Route::has('register'))
                            <a
                                href="{{ route('register') }}"
                                class="block w-full text-center px-5 py-3 bg-green-600 text-white rounded-lg font-medium hover:bg-green-700 transition-colors shadow-lg"
                            >
                                Sign Up
                            </a>
                        @endif
                    @endauth
                </div>
            @endif
        </div>
    </div>
</header>
