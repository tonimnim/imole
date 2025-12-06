<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Online courses for creative professionals - {{ config('app.name') }}</title>
    <meta name="description" content="Browse our extensive catalog of courses taught by industry experts.">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-white dark:bg-gray-900" x-data="{
    searchQuery: '',
    selectedCategory: 'all',
    selectedLevel: 'all',
    courses: {{ json_encode($courses->values()->all()) }},
    get filteredCourses() {
        return this.courses.filter(course => {
            const matchesSearch = course.title.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                                (course.subtitle && course.subtitle.toLowerCase().includes(this.searchQuery.toLowerCase()));
            const matchesCategory = this.selectedCategory === 'all' || (course.category && course.category.slug === this.selectedCategory);
            const matchesLevel = this.selectedLevel === 'all' || course.level === this.selectedLevel;
            return matchesSearch && matchesCategory && matchesLevel;
        });
    },
    get featuredCourses() {
        return this.filteredCourses.filter(course => course.is_featured);
    },
    getCoursesByCategory(categoryId) {
        return this.filteredCourses.filter(course => course.category_id === categoryId);
    }
}">

    <x-header />

    <main class="pt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="lg:grid lg:grid-cols-12 lg:gap-8">

                <!-- Sidebar Navigation -->
                <aside class="lg:col-span-3 mb-8 lg:mb-0">
                    <div class="sticky top-24">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Courses</h2>

                        <nav class="space-y-1">
                            <a href="{{ route('courses.index') }}" class="flex items-center justify-between px-3 py-2 text-sm font-medium text-red-600 border-l-2 border-red-600 bg-red-50 dark:bg-red-900/20">
                                All courses
                            </a>
                            <a href="{{ route('courses.index') }}" class="flex items-center justify-between px-3 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800">
                                Guided courses
                            </a>
                            <a href="{{ route('courses.index') }}" class="flex items-center justify-between px-3 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800">
                                <span class="flex items-center gap-2">
                                    Deep Dive
                                    <span class="px-1.5 py-0.5 text-xs font-bold text-white bg-green-500 rounded">NEW</span>
                                </span>
                            </a>
                            <a href="{{ route('courses.index') }}" class="flex items-center justify-between px-3 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800">
                                Specializations
                            </a>
                            <a href="{{ route('courses.index') }}" class="flex items-center justify-between px-3 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800">
                                Domestika Basics
                            </a>
                            <a href="{{ route('courses.index') }}" class="flex items-center justify-between px-3 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800">
                                New courses
                            </a>
                            <a href="{{ route('courses.index') }}" class="flex items-center justify-between px-3 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800">
                                Top rated
                            </a>
                            <a href="{{ route('courses.index') }}" class="flex items-center justify-between px-3 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800">
                                Popular courses
                            </a>
                            <a href="{{ route('courses.index') }}" class="flex items-center justify-between px-3 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800">
                                <span class="flex items-center gap-2">
                                    Courses free with
                                    <span class="text-red-600">♥ PLUS</span>
                                </span>
                            </a>
                        </nav>

                        <!-- Categories Section -->
                        <div class="mt-8">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Categories</h3>
                            <nav class="space-y-1">
                                @foreach($categories ?? [] as $category)
                                <button @click="selectedCategory = selectedCategory === '{{ $category->slug }}' ? 'all' : '{{ $category->slug }}'" :class="selectedCategory === '{{ $category->slug }}' ? 'bg-yellow-50 dark:bg-yellow-900/20 text-yellow-600 dark:text-yellow-400 font-medium' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800'" class="w-full text-left block px-3 py-2 text-sm transition-colors">
                                    {{ $category->name }}
                                </button>
                                @endforeach
                            </nav>
                        </div>

                        <!-- Areas Section -->
                        <div class="mt-8">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Areas</h3>
                            <nav class="space-y-1">
                                <a href="{{ route('courses.index') }}" class="block px-3 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800">Branding & Identity</a>
                                <a href="{{ route('courses.index') }}" class="block px-3 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800">Graphic Design</a>
                                <a href="{{ route('courses.index') }}" class="block px-3 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800">Social Media Design</a>
                                <a href="{{ route('courses.index') }}" class="block px-3 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800">Web Design</a>
                            </nav>
                        </div>
                    </div>
                </aside>

                <!-- Main Content -->
                <div class="lg:col-span-9">
                    <!-- Page Title -->
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-8">
                        Online courses for creative professionals
                    </h1>

                    <!-- Search and Filter Section -->
                    <div class="mb-8 bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
                        <!-- Search Bar -->
                        <div class="relative mb-4">
                            <svg class="absolute left-4 top-3.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            <input
                                x-model="searchQuery"
                                type="text"
                                placeholder="Search courses by title or keyword..."
                                class="w-full pl-12 pr-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-900 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition-colors"
                            >
                        </div>

                        <!-- Filters Row -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Category Filter -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Category</label>
                                <select x-model="selectedCategory" class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                                    <option value="all">All Categories</option>
                                    @foreach($categories ?? [] as $category)
                                        <option value="{{ $category->slug }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Level Filter -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Level</label>
                                <select x-model="selectedLevel" class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                                    <option value="all">All Levels</option>
                                    <option value="beginner">Beginner</option>
                                    <option value="intermediate">Intermediate</option>
                                    <option value="advanced">Advanced</option>
                                </select>
                            </div>
                        </div>

                        <!-- Active Filters -->
                        <div class="mt-4 flex items-center gap-2 flex-wrap" x-show="searchQuery || selectedCategory !== 'all' || selectedLevel !== 'all'" style="display: none;">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Active filters:</span>
                            <button x-show="searchQuery" @click="searchQuery = ''" class="px-3 py-1 bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-300 rounded-full text-sm flex items-center gap-1 hover:bg-yellow-200 dark:hover:bg-yellow-900/50 transition-colors">
                                <span x-text="'Search: ' + searchQuery"></span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                            <button x-show="selectedCategory !== 'all'" @click="selectedCategory = 'all'" class="px-3 py-1 bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-300 rounded-full text-sm flex items-center gap-1 hover:bg-yellow-200 dark:hover:bg-yellow-900/50 transition-colors">
                                <span x-text="'Category: ' + selectedCategory"></span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                            <button x-show="selectedLevel !== 'all'" @click="selectedLevel = 'all'" class="px-3 py-1 bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-300 rounded-full text-sm flex items-center gap-1 hover:bg-yellow-200 dark:hover:bg-yellow-900/50 transition-colors">
                                <span x-text="'Level: ' + selectedLevel.charAt(0).toUpperCase() + selectedLevel.slice(1)"></span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>

                        <!-- Results Counter -->
                        <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                Showing <span x-text="filteredCourses.length" class="font-semibold text-gray-900 dark:text-white"></span>
                                <span x-text="filteredCourses.length === 1 ? 'course' : 'courses'"></span>
                            </p>
                        </div>
                    </div>

                    <!-- Featured Section -->
                    <template x-if="featuredCourses.length > 0">
                        <section class="mb-12">
                            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Featured</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                <template x-for="course in featuredCourses.slice(0, 3)" :key="course.id">
                                    <div class="group relative">
                                        <a :href="`/courses/${course.slug}`" class="block">
                                            <!-- Course Image -->
                                            <div class="relative overflow-hidden rounded-lg aspect-[4/3] bg-gray-200 dark:bg-gray-700 mb-3">
                                                <template x-if="course.thumbnail">
                                                    <img :src="'/storage/' + course.thumbnail" :alt="course.title" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                                </template>
                                                <template x-if="!course.thumbnail">
                                                    <div class="w-full h-full flex items-center justify-center bg-yellow-100 dark:bg-yellow-900/20">
                                                        <svg class="w-16 h-16 text-yellow-600 dark:text-yellow-400 opacity-50" fill="currentColor" viewBox="0 0 20 20">
                                                            <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/>
                                                        </svg>
                                                    </div>
                                                </template>
                                                <div class="absolute top-3 left-3 bg-yellow-400 text-gray-900 text-xs font-bold px-2.5 py-1 rounded">
                                                    BEST SELLER
                                                </div>
                                            </div>
                                            <!-- Course Details -->
                                            <div>
                                                <template x-if="course.category">
                                                    <div class="mb-2">
                                                        <span class="inline-block px-2 py-0.5 text-xs font-semibold text-gray-600 dark:text-gray-400 bg-gray-100 dark:bg-gray-800 rounded uppercase tracking-wide" x-text="course.category.name"></span>
                                                    </div>
                                                </template>
                                                <h3 class="text-base font-semibold text-gray-900 dark:text-white mb-2 line-clamp-2 group-hover:text-yellow-600 dark:group-hover:text-yellow-400 transition-colors" x-text="course.title"></h3>
                                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-3 line-clamp-1">
                                                    <span x-text="course.instructor ? 'A course by ' + course.instructor.name : course.subtitle"></span>
                                                </p>
                                                <div class="flex items-center gap-4 text-xs text-gray-500 dark:text-gray-400 mb-3">
                                                    <template x-if="course.average_rating > 0">
                                                        <div class="flex items-center gap-1">
                                                            <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                            </svg>
                                                            <span class="font-medium text-gray-900 dark:text-white" x-text="course.average_rating.toFixed(1)"></span>
                                                        </div>
                                                    </template>
                                                    <template x-if="course.students_count > 0">
                                                        <div class="flex items-center gap-1">
                                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                                <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                                                            </svg>
                                                            <span x-text="course.students_count.toLocaleString()"></span>
                                                        </div>
                                                    </template>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </template>
                            </div>
                        </section>
                    </template>

                    <!-- Category Sections -->
                    @foreach($categories ?? [] as $category)
                        <template x-if="getCoursesByCategory({{ $category->id }}).length > 0">
                            <section class="mb-12">
                                <div class="flex items-center justify-between mb-6">
                                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Online {{ $category->name }} courses</h2>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                    <template x-for="course in getCoursesByCategory({{ $category->id }}).slice(0, 3)" :key="course.id">
                                        <div class="group relative">
                                            <a :href="`/courses/${course.slug}`" class="block">
                                                <!-- Course Image -->
                                                <div class="relative overflow-hidden rounded-lg aspect-[4/3] bg-gray-200 dark:bg-gray-700 mb-3">
                                                    <template x-if="course.thumbnail">
                                                        <img :src="'/storage/' + course.thumbnail" :alt="course.title" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                                    </template>
                                                    <template x-if="!course.thumbnail">
                                                        <div class="w-full h-full flex items-center justify-center bg-yellow-100 dark:bg-yellow-900/20">
                                                            <svg class="w-16 h-16 text-yellow-600 dark:text-yellow-400 opacity-50" fill="currentColor" viewBox="0 0 20 20">
                                                                <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/>
                                                            </svg>
                                                        </div>
                                                    </template>
                                                </div>
                                                <!-- Course Details -->
                                                <div>
                                                    <template x-if="course.category">
                                                        <div class="mb-2">
                                                            <span class="inline-block px-2 py-0.5 text-xs font-semibold text-gray-600 dark:text-gray-400 bg-gray-100 dark:bg-gray-800 rounded uppercase tracking-wide" x-text="course.category.name"></span>
                                                        </div>
                                                    </template>
                                                    <h3 class="text-base font-semibold text-gray-900 dark:text-white mb-2 line-clamp-2 group-hover:text-yellow-600 dark:group-hover:text-yellow-400 transition-colors" x-text="course.title"></h3>
                                                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-3 line-clamp-1">
                                                        <span x-text="course.instructor ? 'A course by ' + course.instructor.name : course.subtitle"></span>
                                                    </p>
                                                    <div class="flex items-center gap-4 text-xs text-gray-500 dark:text-gray-400 mb-3">
                                                        <template x-if="course.average_rating > 0">
                                                            <div class="flex items-center gap-1">
                                                                <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                                </svg>
                                                                <span class="font-medium text-gray-900 dark:text-white" x-text="course.average_rating.toFixed(1)"></span>
                                                            </div>
                                                        </template>
                                                        <template x-if="course.students_count > 0">
                                                            <div class="flex items-center gap-1">
                                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                                    <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                                                                </svg>
                                                                <span x-text="course.students_count.toLocaleString()"></span>
                                                            </div>
                                                        </template>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </template>
                                </div>
                            </section>
                        </template>
                    @endforeach

                    <!-- No Results State -->
                    <div x-show="filteredCourses.length === 0" class="text-center py-12" style="display: none;">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <h3 class="mt-2 text-lg font-medium text-gray-900 dark:text-white">No courses found</h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Try adjusting your search or filters.</p>
                        <button @click="searchQuery = ''; selectedCategory = 'all'; selectedLevel = 'all'" class="mt-4 px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition-colors">
                            Clear all filters
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <x-footer />

</body>
</html>
