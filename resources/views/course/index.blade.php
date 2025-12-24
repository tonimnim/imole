<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Browse Courses - {{ config('app.name') }}</title>
    <meta name="description" content="Browse thousands of courses taught by expert instructors. Learn new skills and advance your career.">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800|poppins:500,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-50 dark:bg-gray-900" x-data="{ showFilters: false }">

    <x-header />

    <div class="min-h-screen bg-gray-50 my-24 py-12 dark:bg-gray-900">
        <!-- Hero Section -->
        <div class="bg-gradient-to-r from-purple-600 via-purple-700 to-indigo-700">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12 md:py-16">
                <div class="text-center">
                    <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold text-white mb-3 sm:mb-4">
                        Discover Your Next Learning Adventure
                    </h1>
                    <p class="text-base sm:text-lg md:text-xl text-purple-100 mb-6 sm:mb-8 max-w-3xl mx-auto px-4">
                        Browse thousands of courses taught by expert instructors. Learn new skills and advance your career.
                    </p>

                    <!-- Search Bar -->
                    <div class="max-w-3xl mx-auto">
                        <form action="{{ route('courses.index') }}" method="GET" class="relative">
                            <input
                                type="text"
                                name="search"
                                value="{{ $currentFilters['search'] ?? '' }}"
                                placeholder="Search for courses..."
                                class="w-full pl-12 sm:pl-14 pr-24 sm:pr-32 py-3 sm:py-4 rounded-full bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-4 focus:ring-purple-300 dark:focus:ring-purple-800 shadow-xl text-base sm:text-lg"
                            >
                            <svg class="absolute left-4 sm:left-5 top-1/2 transform -translate-y-1/2 w-5 h-5 sm:w-6 sm:h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            <button type="submit" class="absolute right-2 top-1/2 transform -translate-y-1/2 px-4 sm:px-8 py-2 sm:py-2.5 bg-purple-600 hover:bg-purple-700 text-white text-sm sm:text-base font-bold rounded-full transition-colors">
                                Search
                            </button>
                        </form>
                    </div>

                    <!-- Stats -->
                    <div class="mt-6 sm:mt-8 flex flex-wrap items-center justify-center gap-6 sm:gap-8 text-white">
                        <div class="text-center">
                            <div class="text-2xl sm:text-3xl font-bold">{{ number_format($courses->total()) }}</div>
                            <div class="text-xs sm:text-sm text-purple-200">Courses</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl sm:text-3xl font-bold">{{ number_format($categories->count()) }}</div>
                            <div class="text-xs sm:text-sm text-purple-200">Categories</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl sm:text-3xl font-bold">10K+</div>
                            <div class="text-xs sm:text-sm text-purple-200">Students</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <div class="lg:grid lg:grid-cols-12 lg:gap-8">
                <!-- Desktop Sidebar Filters -->
                <aside class="hidden lg:block lg:col-span-3">
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 sticky top-4">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white">Filters</h3>
                            @if($currentFilters['category'] || $currentFilters['level'] || $currentFilters['search'])
                                <a href="{{ route('courses.index') }}" class="text-sm text-purple-600 dark:text-purple-400 hover:text-purple-700 dark:hover:text-purple-300 font-medium">
                                    Clear all
                                </a>
                            @endif
                        </div>

                        <form action="{{ route('courses.index') }}" method="GET" id="filterForm">
                            @if($currentFilters['search'])
                                <input type="hidden" name="search" value="{{ $currentFilters['search'] }}">
                            @endif

                            <!-- Category Filter -->
                            <div class="mb-6">
                                <h4 class="text-sm font-semibold text-gray-900 dark:text-white mb-3">Category</h4>
                                <div class="space-y-2 max-h-64 overflow-y-auto">
                                    <label class="flex items-center p-2 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer transition-colors {{ !$currentFilters['category'] ? 'bg-purple-50 dark:bg-purple-900/20' : '' }}">
                                        <input type="radio" name="category" value="" {{ !$currentFilters['category'] ? 'checked' : '' }} class="text-purple-600 focus:ring-purple-500" onchange="document.getElementById('filterForm').submit()">
                                        <span class="ml-3 text-sm text-gray-700 dark:text-gray-300 font-medium">All Categories</span>
                                    </label>
                                    @foreach($categories as $category)
                                        <label class="flex items-center p-2 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer transition-colors {{ $currentFilters['category'] === $category->slug ? 'bg-purple-50 dark:bg-purple-900/20' : '' }}">
                                            <input type="radio" name="category" value="{{ $category->slug }}" {{ $currentFilters['category'] === $category->slug ? 'checked' : '' }} class="text-purple-600 focus:ring-purple-500" onchange="document.getElementById('filterForm').submit()">
                                            <span class="ml-3 text-sm text-gray-700 dark:text-gray-300">{{ $category->name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Level Filter -->
                            <div class="pt-6 border-t border-gray-200 dark:border-gray-700">
                                <h4 class="text-sm font-semibold text-gray-900 dark:text-white mb-3">Level</h4>
                                <div class="space-y-2">
                                    <label class="flex items-center p-2 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer transition-colors {{ !$currentFilters['level'] ? 'bg-purple-50 dark:bg-purple-900/20' : '' }}">
                                        <input type="radio" name="level" value="" {{ !$currentFilters['level'] ? 'checked' : '' }} class="text-purple-600 focus:ring-purple-500" onchange="document.getElementById('filterForm').submit()">
                                        <span class="ml-3 text-sm text-gray-700 dark:text-gray-300 font-medium">All Levels</span>
                                    </label>
                                    <label class="flex items-center p-2 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer transition-colors {{ $currentFilters['level'] === 'beginner' ? 'bg-purple-50 dark:bg-purple-900/20' : '' }}">
                                        <input type="radio" name="level" value="beginner" {{ $currentFilters['level'] === 'beginner' ? 'checked' : '' }} class="text-purple-600 focus:ring-purple-500" onchange="document.getElementById('filterForm').submit()">
                                        <span class="ml-3 text-sm text-gray-700 dark:text-gray-300">Beginner</span>
                                    </label>
                                    <label class="flex items-center p-2 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer transition-colors {{ $currentFilters['level'] === 'intermediate' ? 'bg-purple-50 dark:bg-purple-900/20' : '' }}">
                                        <input type="radio" name="level" value="intermediate" {{ $currentFilters['level'] === 'intermediate' ? 'checked' : '' }} class="text-purple-600 focus:ring-purple-500" onchange="document.getElementById('filterForm').submit()">
                                        <span class="ml-3 text-sm text-gray-700 dark:text-gray-300">Intermediate</span>
                                    </label>
                                    <label class="flex items-center p-2 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer transition-colors {{ $currentFilters['level'] === 'advanced' ? 'bg-purple-50 dark:bg-purple-900/20' : '' }}">
                                        <input type="radio" name="level" value="advanced" {{ $currentFilters['level'] === 'advanced' ? 'checked' : '' }} class="text-purple-600 focus:ring-purple-500" onchange="document.getElementById('filterForm').submit()">
                                        <span class="ml-3 text-sm text-gray-700 dark:text-gray-300">Advanced</span>
                                    </label>
                                </div>
                            </div>
                        </form>
                    </div>
                </aside>

                <!-- Mobile Filter Modal/Drawer -->
                <div x-show="showFilters"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     class="fixed inset-0 z-50 lg:hidden"
                     style="display: none;">
                    <!-- Backdrop -->
                    <div class="fixed inset-0 bg-black bg-opacity-50" @click="showFilters = false"></div>

                    <!-- Drawer -->
                    <div x-show="showFilters"
                         x-transition:enter="transition ease-out duration-300 transform"
                         x-transition:enter-start="-translate-x-full"
                         x-transition:enter-end="translate-x-0"
                         x-transition:leave="transition ease-in duration-200 transform"
                         x-transition:leave-start="translate-x-0"
                         x-transition:leave-end="-translate-x-full"
                         class="relative w-80 max-w-full h-full bg-white dark:bg-gray-800 shadow-xl overflow-y-auto">

                        <div class="p-6">
                            <!-- Header -->
                            <div class="flex items-center justify-between mb-6">
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Filters</h3>
                                <button @click="showFilters = false" class="p-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors">
                                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>

                            @if($currentFilters['category'] || $currentFilters['level'] || $currentFilters['search'])
                                <a href="{{ route('courses.index') }}" class="block w-full mb-4 px-4 py-2 text-center text-sm text-purple-600 dark:text-purple-400 hover:bg-purple-50 dark:hover:bg-purple-900/20 rounded-lg font-medium transition-colors">
                                    Clear all filters
                                </a>
                            @endif

                            <form action="{{ route('courses.index') }}" method="GET" id="filterFormMobile">
                                @if($currentFilters['search'])
                                    <input type="hidden" name="search" value="{{ $currentFilters['search'] }}">
                                @endif

                                <!-- Category Filter -->
                                <div class="mb-6">
                                    <h4 class="text-sm font-semibold text-gray-900 dark:text-white mb-3">Category</h4>
                                    <div class="space-y-2 max-h-64 overflow-y-auto">
                                        <label class="flex items-center p-3 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer transition-colors {{ !$currentFilters['category'] ? 'bg-purple-50 dark:bg-purple-900/20 ring-2 ring-purple-500' : '' }}">
                                            <input type="radio" name="category" value="" {{ !$currentFilters['category'] ? 'checked' : '' }} class="text-purple-600 focus:ring-purple-500" onchange="document.getElementById('filterFormMobile').submit()">
                                            <span class="ml-3 text-sm text-gray-700 dark:text-gray-300 font-medium">All Categories</span>
                                        </label>
                                        @foreach($categories as $category)
                                            <label class="flex items-center p-3 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer transition-colors {{ $currentFilters['category'] === $category->slug ? 'bg-purple-50 dark:bg-purple-900/20 ring-2 ring-purple-500' : '' }}">
                                                <input type="radio" name="category" value="{{ $category->slug }}" {{ $currentFilters['category'] === $category->slug ? 'checked' : '' }} class="text-purple-600 focus:ring-purple-500" onchange="document.getElementById('filterFormMobile').submit()">
                                                <span class="ml-3 text-sm text-gray-700 dark:text-gray-300">{{ $category->name }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Level Filter -->
                                <div class="pt-6 border-t border-gray-200 dark:border-gray-700">
                                    <h4 class="text-sm font-semibold text-gray-900 dark:text-white mb-3">Level</h4>
                                    <div class="space-y-2">
                                        <label class="flex items-center p-3 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer transition-colors {{ !$currentFilters['level'] ? 'bg-purple-50 dark:bg-purple-900/20 ring-2 ring-purple-500' : '' }}">
                                            <input type="radio" name="level" value="" {{ !$currentFilters['level'] ? 'checked' : '' }} class="text-purple-600 focus:ring-purple-500" onchange="document.getElementById('filterFormMobile').submit()">
                                            <span class="ml-3 text-sm text-gray-700 dark:text-gray-300 font-medium">All Levels</span>
                                        </label>
                                        <label class="flex items-center p-3 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer transition-colors {{ $currentFilters['level'] === 'beginner' ? 'bg-purple-50 dark:bg-purple-900/20 ring-2 ring-purple-500' : '' }}">
                                            <input type="radio" name="level" value="beginner" {{ $currentFilters['level'] === 'beginner' ? 'checked' : '' }} class="text-purple-600 focus:ring-purple-500" onchange="document.getElementById('filterFormMobile').submit()">
                                            <span class="ml-3 text-sm text-gray-700 dark:text-gray-300">Beginner</span>
                                        </label>
                                        <label class="flex items-center p-3 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer transition-colors {{ $currentFilters['level'] === 'intermediate' ? 'bg-purple-50 dark:bg-purple-900/20 ring-2 ring-purple-500' : '' }}">
                                            <input type="radio" name="level" value="intermediate" {{ $currentFilters['level'] === 'intermediate' ? 'checked' : '' }} class="text-purple-600 focus:ring-purple-500" onchange="document.getElementById('filterFormMobile').submit()">
                                            <span class="ml-3 text-sm text-gray-700 dark:text-gray-300">Intermediate</span>
                                        </label>
                                        <label class="flex items-center p-3 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer transition-colors {{ $currentFilters['level'] === 'advanced' ? 'bg-purple-50 dark:bg-purple-900/20 ring-2 ring-purple-500' : '' }}">
                                            <input type="radio" name="level" value="advanced" {{ $currentFilters['level'] === 'advanced' ? 'checked' : '' }} class="text-purple-600 focus:ring-purple-500" onchange="document.getElementById('filterFormMobile').submit()">
                                            <span class="ml-3 text-sm text-gray-700 dark:text-gray-300">Advanced</span>
                                        </label>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Course Listing -->
                <div class="lg:col-span-9">
                    <!-- Mobile Filter Toggle + Sorting -->
                    <div class="flex items-center justify-between gap-4 mb-6">
                        <!-- Mobile Filter Button -->
                        <button @click="showFilters = true" class="lg:hidden flex items-center gap-2 px-4 py-2.5 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md transition-shadow">
                            <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                            </svg>
                            <span class="font-bold text-gray-900 dark:text-white">Filters</span>
                            @if($currentFilters['category'] || $currentFilters['level'])
                                <span class="px-2 py-0.5 bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300 rounded-full text-xs font-bold">
                                    Active
                                </span>
                            @endif
                        </button>

                        <!-- Page Title (Hidden on Mobile when Filter button shows) -->
                        <div class="hidden sm:block flex-1">
                            <h2 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white">
                                @if($currentFilters['search'])
                                    Search results for "{{ $currentFilters['search'] }}"
                                @elseif($currentFilters['category'])
                                    {{ $categories->firstWhere('slug', $currentFilters['category'])->name ?? 'Courses' }}
                                @else
                                    All Courses
                                @endif
                            </h2>
                            <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400 mt-1">
                                {{ number_format($courses->total()) }} {{ Str::plural('course', $courses->total()) }} found
                            </p>
                        </div>

                        <!-- Sort Dropdown -->
                        <form action="{{ route('courses.index') }}" method="GET" class="flex items-center gap-2">
                            @if($currentFilters['search'])
                                <input type="hidden" name="search" value="{{ $currentFilters['search'] }}">
                            @endif
                            @if($currentFilters['category'])
                                <input type="hidden" name="category" value="{{ $currentFilters['category'] }}">
                            @endif
                            @if($currentFilters['level'])
                                <input type="hidden" name="level" value="{{ $currentFilters['level'] }}">
                            @endif

                            <label for="sort" class="hidden sm:inline text-sm text-gray-700 dark:text-gray-300 font-medium whitespace-nowrap">Sort by:</label>
                            <select name="sort" id="sort" onchange="this.form.submit()" class="px-3 sm:px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-purple-500">
                                <option value="featured" {{ $currentFilters['sort'] === 'featured' ? 'selected' : '' }}>Featured</option>
                                <option value="newest" {{ $currentFilters['sort'] === 'newest' ? 'selected' : '' }}>Newest</option>
                                <option value="popular" {{ $currentFilters['sort'] === 'popular' ? 'selected' : '' }}>Most Popular</option>
                                <option value="rated" {{ $currentFilters['sort'] === 'rated' ? 'selected' : '' }}>Highest Rated</option>
                            </select>
                        </form>
                    </div>

                    <!-- Mobile Page Title -->
                    <div class="sm:hidden mb-4">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white">
                            @if($currentFilters['search'])
                                Search results for "{{ $currentFilters['search'] }}"
                            @elseif($currentFilters['category'])
                                {{ $categories->firstWhere('slug', $currentFilters['category'])->name ?? 'Courses' }}
                            @else
                                All Courses
                            @endif
                        </h2>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                            {{ number_format($courses->total()) }} {{ Str::plural('course', $courses->total()) }} found
                        </p>
                    </div>

                    <!-- Active Filters -->
                    @if($currentFilters['search'] || $currentFilters['category'] || $currentFilters['level'])
                        <div class="flex items-center gap-2 flex-wrap mb-6">
                            <span class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">Active filters:</span>

                            @if($currentFilters['search'])
                                <a href="{{ route('courses.index', array_filter(['category' => $currentFilters['category'], 'level' => $currentFilters['level'], 'sort' => $currentFilters['sort']])) }}" class="inline-flex items-center gap-2 px-3 py-1.5 bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300 rounded-full text-xs sm:text-sm hover:bg-purple-200 dark:hover:bg-purple-900/50 transition-colors">
                                    <span>Search: "{{ Str::limit($currentFilters['search'], 20) }}"</span>
                                    <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </a>
                            @endif

                            @if($currentFilters['category'])
                                <a href="{{ route('courses.index', array_filter(['search' => $currentFilters['search'], 'level' => $currentFilters['level'], 'sort' => $currentFilters['sort']])) }}" class="inline-flex items-center gap-2 px-3 py-1.5 bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300 rounded-full text-xs sm:text-sm hover:bg-purple-200 dark:hover:bg-purple-900/50 transition-colors">
                                    <span>Category: {{ $categories->firstWhere('slug', $currentFilters['category'])->name ?? $currentFilters['category'] }}</span>
                                    <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </a>
                            @endif

                            @if($currentFilters['level'])
                                <a href="{{ route('courses.index', array_filter(['search' => $currentFilters['search'], 'category' => $currentFilters['category'], 'sort' => $currentFilters['sort']])) }}" class="inline-flex items-center gap-2 px-3 py-1.5 bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300 rounded-full text-xs sm:text-sm hover:bg-purple-200 dark:hover:bg-purple-900/50 transition-colors">
                                    <span>Level: {{ ucfirst($currentFilters['level']) }}</span>
                                    <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </a>
                            @endif
                        </div>
                    @endif

                    <!-- Courses Grid -->
                    @if($courses->count() > 0)
                        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4 sm:gap-6 mb-8">
                            @foreach($courses as $course)
                                <x-course-card-modern :course="$course" />
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="mt-8">
                            {{ $courses->links() }}
                        </div>
                    @else
                        <!-- Empty State -->
                        <div class="text-center py-12 sm:py-16 bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700">
                            <svg class="mx-auto h-12 w-12 sm:h-16 sm:w-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <h3 class="text-lg sm:text-xl font-bold text-gray-900 dark:text-white mb-2">No courses found</h3>
                            <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400 mb-6 px-4">
                                We couldn't find any courses matching your criteria. Try adjusting your filters.
                            </p>
                            <a href="{{ route('courses.index') }}" class="inline-flex items-center px-4 sm:px-6 py-2 sm:py-3 bg-purple-600 hover:bg-purple-700 text-white text-sm sm:text-base font-bold rounded-lg transition-colors">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                </svg>
                                Reset filters
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Category Showcase Section -->
        @if(!$currentFilters['search'] && !$currentFilters['category'] && $categories->count() > 0)
            <div class="bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 py-12 sm:py-16">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="text-center mb-8 sm:mb-12">
                        <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white mb-2 sm:mb-4">Explore by Category</h2>
                        <p class="text-base sm:text-lg text-gray-600 dark:text-gray-400">Find the perfect course for your learning goals</p>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
                        @foreach($categories->take(8) as $category)
                            <a href="{{ route('courses.index', ['category' => $category->slug]) }}" class="group p-4 sm:p-6 bg-gradient-to-br from-purple-50 to-indigo-50 dark:from-purple-900/20 dark:to-indigo-900/20 rounded-xl border border-purple-100 dark:border-purple-800 hover:border-purple-300 dark:hover:border-purple-600 hover:shadow-lg transition-all">
                                <div class="flex items-center justify-center w-10 h-10 sm:w-12 sm:h-12 bg-purple-600 rounded-lg mb-3 sm:mb-4 group-hover:scale-110 transition-transform">
                                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                </div>
                                <h3 class="text-sm sm:text-base font-bold text-gray-900 dark:text-white mb-1 group-hover:text-purple-600 dark:group-hover:text-purple-400 transition-colors">
                                    {{ $category->name }}
                                </h3>
                                <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">
                                    Explore courses
                                </p>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    </div>

    <x-footer />

</body>
</html>
