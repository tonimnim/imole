<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }} - Transform Your Future with Quality Education</title>
    <meta name="description" content="Africa's premier learning platform offering world-class courses in agriculture, technology, and vocational skills. Join 10,000+ students learning today.">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-white dark:bg-gray-900">

    <x-header />

    <main class="pt-16">
        <x-hero />

        <!-- Stats Banner - Vibrant with Gradients -->
        <section class="relative py-16 bg-gradient-to-r from-green-700 via-green-600 to-amber-500 overflow-hidden">
            <!-- Animated background pattern -->
            <div class="absolute inset-0 opacity-10">
                <div class="absolute inset-0" style="background-image: radial-gradient(circle at 20px 20px, white 2px, transparent 0); background-size: 50px 50px;"></div>
            </div>

            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                    <div class="group transform hover:scale-110 transition-transform duration-300">
                        <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 border-2 border-white/20 hover:border-white/40 transition-colors">
                            <div class="text-5xl font-bold text-white mb-2 drop-shadow-lg">500+</div>
                            <div class="text-sm font-bold text-white/90 uppercase tracking-wider">Expert Courses</div>
                        </div>
                    </div>
                    <div class="group transform hover:scale-110 transition-transform duration-300">
                        <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 border-2 border-white/20 hover:border-white/40 transition-colors">
                            <div class="text-5xl font-bold text-white mb-2 drop-shadow-lg">10K+</div>
                            <div class="text-sm font-bold text-white/90 uppercase tracking-wider">Active Students</div>
                        </div>
                    </div>
                    <div class="group transform hover:scale-110 transition-transform duration-300">
                        <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 border-2 border-white/20 hover:border-white/40 transition-colors">
                            <div class="text-5xl font-bold text-white mb-2 drop-shadow-lg">15+</div>
                            <div class="text-sm font-bold text-white/90 uppercase tracking-wider">Countries</div>
                        </div>
                    </div>
                    <div class="group transform hover:scale-110 transition-transform duration-300">
                        <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 border-2 border-white/20 hover:border-white/40 transition-colors">
                            <div class="text-5xl font-bold text-white mb-2 drop-shadow-lg">98%</div>
                            <div class="text-sm font-bold text-white/90 uppercase tracking-wider">Success Rate</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Decorative wave -->
            <div class="absolute bottom-0 left-0 right-0">
                <svg viewBox="0 0 1440 120" class="w-full h-16 fill-white dark:fill-gray-900">
                    <path d="M0,64L48,69.3C96,75,192,85,288,80C384,75,480,53,576,48C672,43,768,53,864,58.7C960,64,1056,64,1152,58.7C1248,53,1344,43,1392,37.3L1440,32L1440,120L1392,120C1344,120,1248,120,1152,120C1056,120,960,120,864,120C768,120,672,120,576,120C480,120,384,120,288,120C192,120,96,120,48,120L0,120Z"></path>
                </svg>
            </div>
        </section>

        <!-- Featured Courses Section with Filters -->
        <section id="all-courses" class="py-20 bg-white dark:bg-gray-900" x-data="{
            searchQuery: '',
            selectedCategory: 'all',
            selectedLevel: 'all',
            courses: {{ json_encode($featuredCourses ?? []) }},
            get filteredCourses() {
                return this.courses.filter(course => {
                    const matchesSearch = course.title.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                                        (course.subtitle && course.subtitle.toLowerCase().includes(this.searchQuery.toLowerCase()));
                    const matchesCategory = this.selectedCategory === 'all' || course.category?.slug === this.selectedCategory;
                    const matchesLevel = this.selectedLevel === 'all' || course.level === this.selectedLevel;
                    return matchesSearch && matchesCategory && matchesLevel;
                });
            }
        }">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Header -->
                <div class="text-center mb-12">
                    <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 dark:text-white mb-4 tracking-tight">Explore Our Courses</h2>
                    <p class="text-lg text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">Discover world-class courses taught by industry experts across Africa</p>
                </div>

                <!-- Search and Filter Bar - Professional Design -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 mb-10">
                    <div class="flex flex-col lg:flex-row gap-4">
                        <!-- Search Input with Professional Focus States -->
                        <div class="flex-1">
                            <div class="relative group">
                                <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400 group-focus-within:text-green-700 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                                <input
                                    x-model="searchQuery"
                                    type="text"
                                    placeholder="Search courses by title or keyword..."
                                    class="w-full pl-12 pr-4 py-3.5 border-2 border-gray-200 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-900 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:border-green-700 dark:focus:border-green-600 focus:ring-4 focus:ring-green-100 dark:focus:ring-green-900/30 transition-all"
                                >
                            </div>
                        </div>

                        <!-- Category Filter -->
                        <div class="lg:w-56">
                            <select x-model="selectedCategory" class="w-full px-4 py-3.5 border-2 border-gray-200 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-900 text-gray-900 dark:text-white font-medium focus:outline-none focus:border-green-700 dark:focus:border-green-600 focus:ring-4 focus:ring-green-100 dark:focus:ring-green-900/30 transition-all">
                                <option value="all">All Categories</option>
                                @foreach($categories ?? [] as $category)
                                    <option value="{{ $category->slug }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Level Filter -->
                        <div class="lg:w-48">
                            <select x-model="selectedLevel" class="w-full px-4 py-3.5 border-2 border-gray-200 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-900 text-gray-900 dark:text-white font-medium focus:outline-none focus:border-green-700 dark:focus:border-green-600 focus:ring-4 focus:ring-green-100 dark:focus:ring-green-900/30 transition-all">
                                <option value="all">All Levels</option>
                                <option value="beginner">Beginner</option>
                                <option value="intermediate">Intermediate</option>
                                <option value="advanced">Advanced</option>
                            </select>
                        </div>
                    </div>

                    <!-- Active Filters Display -->
                    <div class="mt-4 flex items-center gap-2 flex-wrap" x-show="searchQuery || selectedCategory !== 'all' || selectedLevel !== 'all'" x-cloak>
                        <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Active filters:</span>
                        <button x-show="searchQuery" @click="searchQuery = ''" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 text-amber-900 dark:text-amber-300 rounded-lg text-sm font-medium hover:bg-amber-100 dark:hover:bg-amber-900/30 transition-colors">
                            <span x-text="'Search: ' + searchQuery.substring(0, 20) + (searchQuery.length > 20 ? '...' : '')"></span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                        <button x-show="selectedCategory !== 'all'" @click="selectedCategory = 'all'" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-900 dark:text-green-300 rounded-lg text-sm font-medium hover:bg-green-100 dark:hover:bg-green-900/30 transition-colors">
                            <span>Category</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                        <button x-show="selectedLevel !== 'all'" @click="selectedLevel = 'all'" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-900 dark:text-green-300 rounded-lg text-sm font-medium hover:bg-green-100 dark:hover:bg-green-900/30 transition-colors">
                            <span>Level</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                        <button @click="searchQuery = ''; selectedCategory = 'all'; selectedLevel = 'all'" class="text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-green-700 dark:hover:text-green-400 transition-colors">
                            Clear all
                        </button>
                    </div>
                </div>

                <!-- Results Count -->
                <div class="flex items-center justify-between mb-8">
                    <p class="text-gray-700 dark:text-gray-300 font-medium">
                        Showing <span class="font-bold text-gray-900 dark:text-white" x-text="filteredCourses.length"></span>
                        <span x-text="filteredCourses.length === 1 ? 'course' : 'courses'"></span>
                    </p>
                    <a href="{{ route('courses.index') }}" class="text-sm font-semibold text-green-700 dark:text-green-500 hover:text-green-800 dark:hover:text-green-400 flex items-center gap-1 group">
                        View all courses
                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>

                <!-- Courses Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
                    <template x-for="course in filteredCourses.slice(0, 8)" :key="course.id">
                        <div class="group bg-white dark:bg-gray-800 rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden border border-gray-200 dark:border-gray-700 hover:border-green-700 dark:hover:border-green-600 flex flex-col h-full">
                            <a :href="'/courses/' + course.slug" class="flex flex-col h-full">
                                <!-- Course Thumbnail -->
                                <div class="relative overflow-hidden aspect-video bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-900">
                                    <template x-if="course.thumbnail">
                                        <img :src="'/storage/' + course.thumbnail" :alt="course.title" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
                                    </template>
                                    <template x-if="!course.thumbnail">
                                        <div class="w-full h-full flex items-center justify-center">
                                            <div class="w-16 h-16 bg-green-700 rounded-xl flex items-center justify-center">
                                                <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/>
                                                </svg>
                                            </div>
                                        </div>
                                    </template>

                                    <!-- Badges -->
                                    <template x-if="course.is_featured">
                                        <div class="absolute top-3 left-3">
                                            <span class="inline-block px-3 py-1 bg-amber-500 text-white text-xs font-bold rounded-lg shadow-lg">
                                                FEATURED
                                            </span>
                                        </div>
                                    </template>

                                    <template x-if="course.level">
                                        <div class="absolute top-3 right-3">
                                            <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-bold shadow-lg text-white"
                                                :class="{
                                                    'bg-green-600': course.level === 'beginner',
                                                    'bg-amber-500': course.level === 'intermediate',
                                                    'bg-green-800': course.level === 'advanced'
                                                }"
                                                x-text="course.level.toUpperCase()">
                                            </span>
                                        </div>
                                    </template>
                                </div>

                                <!-- Course Content -->
                                <div class="p-4 sm:p-5 flex flex-col flex-1">
                                    <!-- Category -->
                                    <template x-if="course.category">
                                        <div class="mb-2">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-semibold bg-green-50 text-green-800 dark:bg-green-900/30 dark:text-green-400 border border-green-200 dark:border-green-800" x-text="course.category.name"></span>
                                        </div>
                                    </template>

                                    <!-- Title -->
                                    <h3 class="text-base sm:text-lg font-bold text-gray-900 dark:text-white mb-3 group-hover:text-green-700 dark:group-hover:text-green-500 transition-colors leading-snug" x-text="course.title"></h3>

                                    <!-- Instructor -->
                                    <template x-if="course.instructor">
                                        <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400 mb-4">
                                            By <span class="font-medium" x-text="course.instructor.name"></span>
                                        </p>
                                    </template>

                                    <!-- Stats Row -->
                                    <div class="flex items-center gap-3 sm:gap-4 mb-3 sm:mb-4">
                                        <!-- Rating -->
                                        <template x-if="course.average_rating > 0">
                                            <div class="flex items-center gap-1">
                                                <span class="text-xs sm:text-sm font-bold text-gray-900 dark:text-white" x-text="course.average_rating.toFixed(1)"></span>
                                                <div class="flex items-center">
                                                    <template x-for="i in 5" :key="i">
                                                        <svg class="w-4 h-4 fill-current" :class="i <= Math.round(course.average_rating) ? 'text-amber-500' : 'text-gray-300 dark:text-gray-600'" viewBox="0 0 20 20">
                                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                        </svg>
                                                    </template>
                                                </div>
                                                <template x-if="course.reviews_count > 0">
                                                    <span class="text-xs text-gray-500 dark:text-gray-400" x-text="'(' + course.reviews_count.toLocaleString() + ')'"></span>
                                                </template>
                                            </div>
                                        </template>

                                        <!-- Students -->
                                        <template x-if="course.students_count > 0">
                                            <div class="flex items-center gap-1 text-xs text-gray-600 dark:text-gray-400">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                                                </svg>
                                                <span class="font-medium" x-text="course.students_count.toLocaleString()"></span>
                                            </div>
                                        </template>
                                    </div>

                                    <!-- Additional Info -->
                                    <div class="flex items-center flex-wrap gap-2 sm:gap-3 text-xs text-gray-500 dark:text-gray-400 mb-3 sm:mb-4 pb-3 sm:pb-4 border-b border-gray-200 dark:border-gray-700">
                                        <template x-if="course.lessons_count">
                                            <div class="flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z"/>
                                                </svg>
                                                <span x-text="course.lessons_count + ' lessons'"></span>
                                            </div>
                                        </template>

                                        <template x-if="course.duration_minutes">
                                            <div class="flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                                </svg>
                                                <span x-text="Math.floor(course.duration_minutes / 60) + 'h ' + (course.duration_minutes % 60) + 'm'"></span>
                                            </div>
                                        </template>
                                    </div>

                                    <!-- Price and CTA -->
                                    <div class="flex items-center justify-between mt-auto">
                                        <div class="flex-1">
                                            <template x-if="course.price > 0">
                                                <div>
                                                    <template x-if="course.discount_price && course.discount_price < course.price">
                                                        <div class="flex flex-col gap-1">
                                                            <div class="flex items-baseline gap-2 flex-wrap">
                                                                <span class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white whitespace-nowrap" x-text="'KSh ' + course.discount_price.toLocaleString()"></span>
                                                                <span class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 line-through whitespace-nowrap" x-text="'KSh ' + course.price.toLocaleString()"></span>
                                                            </div>
                                                            <span class="inline-flex items-center w-fit px-2 py-0.5 bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded text-xs font-bold text-amber-900 dark:text-amber-400" x-text="Math.round(((course.price - course.discount_price) / course.price) * 100) + '% OFF'"></span>
                                                        </div>
                                                    </template>
                                                    <template x-if="!course.discount_price || course.discount_price >= course.price">
                                                        <span class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white whitespace-nowrap" x-text="'KSh ' + course.price.toLocaleString()"></span>
                                                    </template>
                                                </div>
                                            </template>
                                            <template x-if="course.price == 0">
                                                <span class="text-xl sm:text-2xl font-bold text-green-700 dark:text-green-400">Free</span>
                                            </template>
                                        </div>

                                        <!-- Quick Action Button -->
                                        <div class="hidden sm:block sm:opacity-0 sm:group-hover:opacity-100 transition-opacity">
                                            <span class="inline-flex items-center px-3 sm:px-4 py-1.5 sm:py-2 bg-green-700 hover:bg-green-800 text-white text-xs sm:text-sm font-semibold rounded-lg transition-colors whitespace-nowrap shadow-sm">
                                                View
                                                <svg class="w-3 h-3 sm:w-4 sm:h-4 ml-1 sm:ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                                </svg>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </template>
                </div>

                <!-- No Results State -->
                <div x-show="filteredCourses.length === 0" class="text-center py-20" x-cloak>
                    <div class="w-20 h-20 mx-auto mb-6 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center">
                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">No courses found</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-6">Try adjusting your search or filters to find what you're looking for</p>
                    <button @click="searchQuery = ''; selectedCategory = 'all'; selectedLevel = 'all'" class="inline-flex items-center px-6 py-3 bg-green-700 hover:bg-green-800 text-white font-semibold rounded-lg transition-colors shadow-sm hover:shadow-md">
                        Clear all filters
                    </button>
                </div>

                <!-- View All Button -->
                <div class="text-center mt-12" x-show="filteredCourses.length > 0">
                    <a href="{{ route('courses.index') }}" class="inline-flex items-center px-8 py-4 bg-green-700 hover:bg-green-800 active:bg-green-900 text-white font-bold rounded-lg transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                        Browse All Courses
                        <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                </div>
            </div>
        </section>

        <!-- How It Works Section - Vibrant -->
        <section class="relative py-20 bg-gradient-to-br from-white via-amber-50 to-green-50 dark:bg-gray-900 overflow-hidden">
            <!-- Vibrant Background Pattern -->
            <div class="absolute inset-0 opacity-10">
                <div class="absolute inset-0" style="background-image: radial-gradient(circle at 2px 2px, #15803d 1px, transparent 0); background-size: 40px 40px;"></div>
            </div>

            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <div class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-amber-500 to-yellow-500 text-white font-bold rounded-full mb-4 shadow-lg">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd"/>
                        </svg>
                        Simple & Effective
                    </div>
                    <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 dark:text-white mb-4 tracking-tight">How It Works</h2>
                    <p class="text-lg text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">Start your learning journey in three simple steps</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 lg:gap-12">
                    <!-- Step 1 - Vibrant -->
                    <div class="relative group">
                        <div class="flex flex-col items-center text-center">
                            <div class="relative mb-6 transform group-hover:scale-110 transition-transform duration-300">
                                <div class="w-24 h-24 bg-gradient-to-br from-green-500 via-green-600 to-green-700 rounded-3xl flex items-center justify-center shadow-2xl">
                                    <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                    </svg>
                                </div>
                                <div class="absolute -top-3 -right-3 w-10 h-10 bg-gradient-to-br from-amber-400 to-amber-600 rounded-full flex items-center justify-center text-white font-bold text-lg shadow-xl border-4 border-white">
                                    1
                                </div>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">Choose Your Course</h3>
                            <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                                Browse our extensive catalog of courses across technology, business, agriculture, and more. Find the perfect course for your goals.
                            </p>
                        </div>
                        <!-- Vibrant Connecting Line (Desktop) -->
                        <div class="hidden md:block absolute top-12 left-1/2 w-full h-1 bg-gradient-to-r from-green-500 via-amber-300 to-green-400"></div>
                    </div>

                    <!-- Step 2 - Vibrant -->
                    <div class="relative group">
                        <div class="flex flex-col items-center text-center">
                            <div class="relative mb-6 transform group-hover:scale-110 transition-transform duration-300">
                                <div class="w-24 h-24 bg-gradient-to-br from-amber-400 via-amber-500 to-yellow-500 rounded-3xl flex items-center justify-center shadow-2xl">
                                    <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                </div>
                                <div class="absolute -top-3 -right-3 w-10 h-10 bg-gradient-to-br from-green-500 to-green-700 rounded-full flex items-center justify-center text-white font-bold text-lg shadow-xl border-4 border-white">
                                    2
                                </div>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">Learn at Your Pace</h3>
                            <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                                Access video lessons, downloadable resources, and interactive quizzes. Study anytime, anywhere, on any device.
                            </p>
                        </div>
                        <!-- Vibrant Connecting Line (Desktop) -->
                        <div class="hidden md:block absolute top-12 left-1/2 w-full h-1 bg-gradient-to-r from-amber-400 via-green-300 to-green-500"></div>
                    </div>

                    <!-- Step 3 - Vibrant -->
                    <div class="relative group">
                        <div class="flex flex-col items-center text-center">
                            <div class="relative mb-6 transform group-hover:scale-110 transition-transform duration-300">
                                <div class="w-24 h-24 bg-gradient-to-br from-green-600 via-green-700 to-green-800 rounded-3xl flex items-center justify-center shadow-2xl">
                                    <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                                    </svg>
                                </div>
                                <div class="absolute -top-3 -right-3 w-10 h-10 bg-gradient-to-br from-yellow-400 to-amber-500 rounded-full flex items-center justify-center text-white font-bold text-lg shadow-xl border-4 border-white">
                                    3
                                </div>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">Earn Your Certificate</h3>
                            <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                                Complete assignments and assessments to earn a verified certificate. Showcase your new skills to employers.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Why Choose Us Section -->
        <section class="py-20 bg-gray-50 dark:bg-gray-800 border-y border-gray-200 dark:border-gray-700">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 dark:text-white mb-4 tracking-tight">Why Choose {{ config('app.name') }}</h2>
                    <p class="text-lg text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">We're committed to providing quality education that transforms lives across Africa</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Feature 1 -->
                    <div class="bg-white dark:bg-gray-900 rounded-xl p-8 border border-gray-200 dark:border-gray-700 hover:border-green-700 dark:hover:border-green-600 transition-all hover:shadow-lg">
                        <div class="w-14 h-14 bg-green-100 dark:bg-green-900/30 rounded-xl flex items-center justify-center mb-6">
                            <svg class="w-7 h-7 text-green-700 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">Lifetime Access</h3>
                        <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                            Once enrolled, you have unlimited access to course materials. Learn at your own pace, revisit lessons anytime.
                        </p>
                    </div>

                    <!-- Feature 2 -->
                    <div class="bg-white dark:bg-gray-900 rounded-xl p-8 border border-gray-200 dark:border-gray-700 hover:border-green-700 dark:hover:border-green-600 transition-all hover:shadow-lg">
                        <div class="w-14 h-14 bg-amber-100 dark:bg-amber-900/30 rounded-xl flex items-center justify-center mb-6">
                            <svg class="w-7 h-7 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">Verified Certificates</h3>
                        <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                            Earn recognized certificates upon completion. Add them to your resume or LinkedIn profile to stand out.
                        </p>
                    </div>

                    <!-- Feature 3 -->
                    <div class="bg-white dark:bg-gray-900 rounded-xl p-8 border border-gray-200 dark:border-gray-700 hover:border-green-700 dark:hover:border-green-600 transition-all hover:shadow-lg">
                        <div class="w-14 h-14 bg-green-100 dark:bg-green-900/30 rounded-xl flex items-center justify-center mb-6">
                            <svg class="w-7 h-7 text-green-700 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">Expert Instructors</h3>
                        <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                            Learn from verified industry professionals with real-world experience and proven teaching skills.
                        </p>
                    </div>

                    <!-- Feature 4 -->
                    <div class="bg-white dark:bg-gray-900 rounded-xl p-8 border border-gray-200 dark:border-gray-700 hover:border-green-700 dark:hover:border-green-600 transition-all hover:shadow-lg">
                        <div class="w-14 h-14 bg-green-100 dark:bg-green-900/30 rounded-xl flex items-center justify-center mb-6">
                            <svg class="w-7 h-7 text-green-700 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">Mobile Learning</h3>
                        <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                            Study on the go with our mobile-optimized platform. Access courses from any device, anywhere.
                        </p>
                    </div>

                    <!-- Feature 5 -->
                    <div class="bg-white dark:bg-gray-900 rounded-xl p-8 border border-gray-200 dark:border-gray-700 hover:border-green-700 dark:hover:border-green-600 transition-all hover:shadow-lg">
                        <div class="w-14 h-14 bg-amber-100 dark:bg-amber-900/30 rounded-xl flex items-center justify-center mb-6">
                            <svg class="w-7 h-7 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">Community Support</h3>
                        <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                            Join a vibrant community of learners. Get help from instructors and peers throughout your journey.
                        </p>
                    </div>

                    <!-- Feature 6 -->
                    <div class="bg-white dark:bg-gray-900 rounded-xl p-8 border border-gray-200 dark:border-gray-700 hover:border-green-700 dark:hover:border-green-600 transition-all hover:shadow-lg">
                        <div class="w-14 h-14 bg-green-100 dark:bg-green-900/30 rounded-xl flex items-center justify-center mb-6">
                            <svg class="w-7 h-7 text-green-700 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">Affordable Pricing</h3>
                        <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                            Quality education at prices designed for African learners. Special discounts and payment plans available.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Success Stories / Testimonials - Vibrant with African Images -->
        <section class="relative py-20 bg-white dark:bg-gray-900 overflow-hidden">
            <!-- Vibrant Background Accent -->
            <div class="absolute top-0 left-0 w-64 h-64 bg-gradient-to-br from-green-400 to-green-600 opacity-10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 right-0 w-96 h-96 bg-gradient-to-br from-amber-400 to-yellow-500 opacity-10 rounded-full blur-3xl"></div>

            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <div class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-green-500 to-green-700 text-white font-bold rounded-full mb-4 shadow-lg">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        Real Success Stories
                    </div>
                    <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 dark:text-white mb-4 tracking-tight">Success Stories from Africa</h2>
                    <p class="text-lg text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">Join thousands of students who have transformed their careers</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Testimonial 1 - African Woman Farmer -->
                    <div class="group bg-white dark:from-gray-800 dark:to-gray-900 rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl border-2 border-gray-200 dark:border-gray-700 hover:border-green-500 dark:hover:border-green-500 transition-all">
                        <div class="relative h-48 overflow-hidden bg-gradient-to-br from-green-100 to-green-200">
                            <img
                                src="https://images.unsplash.com/photo-1594744803329-e58b31de8bf5?w=800&q=80"
                                alt="African woman farmer"
                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                                onerror="this.parentElement.innerHTML='<div class=\'w-full h-full bg-gradient-to-br from-green-600 to-green-700 flex items-center justify-center\'><div class=\'w-24 h-24 bg-white rounded-full flex items-center justify-center text-green-700 font-bold text-4xl\'>AK</div></div>'"
                            >
                            <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
                        </div>
                        <div class="p-6">
                            <div class="flex items-center gap-1 mb-4">
                                @for($i = 0; $i < 5; $i++)
                                    <svg class="w-5 h-5 text-amber-500 fill-current" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @endfor
                            </div>
                            <p class="text-gray-700 dark:text-gray-300 leading-relaxed mb-6 italic">
                                "The agricultural technology course helped me modernize my farm. I've increased my yield by 40% and now supply to major retailers across Kenya."
                            </p>
                            <div class="flex items-center gap-3 pt-4 border-t-2 border-green-100">
                                <div class="w-12 h-12 rounded-full ring-2 ring-green-500 overflow-hidden bg-gradient-to-br from-green-600 to-green-700 flex items-center justify-center text-white font-bold">
                                    <span class="text-sm">AK</span>
                                </div>
                                <div>
                                    <div class="font-bold text-gray-900 dark:text-white">Amina Kamara</div>
                                    <div class="text-xs text-gray-600 dark:text-gray-400 font-medium">Agricultural Entrepreneur 🇰🇪 Kenya</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Testimonial 2 - African Male Developer -->
                    <div class="group bg-white dark:from-gray-800 dark:to-gray-900 rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl border-2 border-gray-200 dark:border-gray-700 hover:border-amber-500 dark:hover:border-amber-500 transition-all">
                        <div class="relative h-48 overflow-hidden bg-gradient-to-br from-amber-100 to-yellow-200">
                            <img
                                src="https://images.unsplash.com/photo-1507679799987-c73779587ccf?w=800&q=80"
                                alt="African software developer"
                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                                onerror="this.parentElement.innerHTML='<div class=\'w-full h-full bg-gradient-to-br from-amber-500 to-amber-600 flex items-center justify-center\'><div class=\'w-24 h-24 bg-white rounded-full flex items-center justify-center text-amber-700 font-bold text-4xl\'>CO</div></div>'"
                            >
                            <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
                        </div>
                        <div class="p-6">
                            <div class="flex items-center gap-1 mb-4">
                                @for($i = 0; $i < 5; $i++)
                                    <svg class="w-5 h-5 text-amber-500 fill-current" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @endfor
                            </div>
                            <p class="text-gray-700 dark:text-gray-300 leading-relaxed mb-6 italic">
                                "I landed my dream job as a web developer after completing the full-stack development course. The hands-on projects were exactly what I needed."
                            </p>
                            <div class="flex items-center gap-3 pt-4 border-t-2 border-amber-100">
                                <div class="w-12 h-12 rounded-full ring-2 ring-amber-500 overflow-hidden bg-gradient-to-br from-amber-500 to-amber-600 flex items-center justify-center text-white font-bold">
                                    <span class="text-sm">CO</span>
                                </div>
                                <div>
                                    <div class="font-bold text-gray-900 dark:text-white">Chidi Okonkwo</div>
                                    <div class="text-xs text-gray-600 dark:text-gray-400 font-medium">Software Developer 🇳🇬 Nigeria</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Testimonial 3 - African Woman Entrepreneur -->
                    <div class="group bg-white dark:from-gray-800 dark:to-gray-900 rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl border-2 border-gray-200 dark:border-gray-700 hover:border-green-500 dark:hover:border-green-500 transition-all">
                        <div class="relative h-48 overflow-hidden bg-gradient-to-br from-green-100 to-amber-100">
                            <img
                                src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=800&q=80"
                                alt="African business woman"
                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                                onerror="this.parentElement.innerHTML='<div class=\'w-full h-full bg-gradient-to-br from-green-600 to-amber-500 flex items-center justify-center\'><div class=\'w-24 h-24 bg-white rounded-full flex items-center justify-center text-green-700 font-bold text-4xl\'>FN</div></div>'"
                            >
                            <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
                        </div>
                        <div class="p-6">
                            <div class="flex items-center gap-1 mb-4">
                                @for($i = 0; $i < 5; $i++)
                                    <svg class="w-5 h-5 text-amber-500 fill-current" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @endfor
                            </div>
                            <p class="text-gray-700 dark:text-gray-300 leading-relaxed mb-6 italic">
                                "The business management courses gave me the skills to scale my boutique from one shop to five locations. I'm now employing 30 people!"
                            </p>
                            <div class="flex items-center gap-3 pt-4 border-t-2 border-green-100">
                                <div class="w-12 h-12 rounded-full ring-2 ring-green-500 overflow-hidden bg-gradient-to-br from-green-600 to-green-700 flex items-center justify-center text-white font-bold">
                                    <span class="text-sm">FN</span>
                                </div>
                                <div>
                                    <div class="font-bold text-gray-900 dark:text-white">Fatima Ndlovu</div>
                                    <div class="text-xs text-gray-600 dark:text-gray-400 font-medium">Business Owner 🇬🇭 Ghana</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Become an Instructor Section - Vibrant with African Image -->
        <section class="relative py-20 bg-gradient-to-br from-green-50 via-amber-50 to-yellow-50 dark:bg-gray-800 border-y-4 border-amber-400 dark:border-amber-600 overflow-hidden">
            <!-- Vibrant Background Pattern -->
            <div class="absolute inset-0 opacity-5">
                <div class="absolute inset-0" style="background-image: repeating-linear-gradient(45deg, #15803d 0, #15803d 10px, transparent 10px, transparent 20px, #f59e0b 20px, #f59e0b 30px, transparent 30px, transparent 40px);"></div>
            </div>

            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="lg:grid lg:grid-cols-2 lg:gap-16 items-center">
                    <div class="mb-12 lg:mb-0 group">
                        <div class="relative rounded-3xl overflow-hidden shadow-2xl transform group-hover:scale-105 transition-transform duration-500">
                            <!-- Vibrant border gradient -->
                            <div class="absolute inset-0 bg-gradient-to-br from-green-500 via-amber-400 to-green-600 p-1">
                                <div class="h-full w-full bg-white dark:bg-gray-800 rounded-3xl overflow-hidden">
                                    <img
                                        src="https://images.unsplash.com/photo-1573497019940-1c28c88b4f3e?w=800&q=80"
                                        alt="African instructor teaching online course"
                                        class="w-full h-full object-cover aspect-video"
                                        onerror="this.parentElement.innerHTML='<div class=\'w-full h-full bg-gradient-to-br from-green-600 to-amber-500 flex items-center justify-center\'><div class=\'text-center p-8\'><div class=\'w-24 h-24 mx-auto mb-6 bg-white rounded-2xl flex items-center justify-center shadow-lg\'><svg class=\'w-12 h-12 text-green-700\' fill=\'currentColor\' viewBox=\'0 0 20 20\'><path d=\'M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3z\'/></svg></div><p class=\'text-white font-bold text-lg\'>Share Your Expertise</p></div></div>'"
                                    >
                                </div>
                            </div>
                            <!-- Vibrant floating badge -->
                            <div class="absolute top-6 right-6 bg-gradient-to-r from-amber-400 to-yellow-500 text-white px-6 py-3 rounded-full font-bold shadow-xl transform rotate-3 hover:rotate-0 transition-transform">
                                <div class="flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                    <span>Top Rated</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-amber-400 to-yellow-500 text-white font-bold rounded-full mb-6 shadow-lg">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                            </svg>
                            <span class="uppercase tracking-wide">Join Our Team</span>
                        </div>
                        <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 dark:text-white mb-6 tracking-tight">
                            Become an <span class="text-transparent bg-clip-text bg-gradient-to-r from-green-600 to-amber-500">Instructor</span>
                        </h2>
                        <p class="text-lg text-gray-700 dark:text-gray-300 mb-8 leading-relaxed">
                            Share your expertise with thousands of eager learners across Africa. Join our community of expert instructors and make a lasting impact while earning competitive income.
                        </p>
                        <ul class="space-y-4 mb-10">
                            <li class="flex items-start gap-3 group">
                                <div class="w-8 h-8 bg-gradient-to-br from-green-500 to-green-700 rounded-lg flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <span class="text-gray-700 dark:text-gray-300 leading-relaxed font-medium">Earn competitive income from your expertise and experience</span>
                            </li>
                            <li class="flex items-start gap-3 group">
                                <div class="w-8 h-8 bg-gradient-to-br from-amber-400 to-amber-600 rounded-lg flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <span class="text-gray-700 dark:text-gray-300 leading-relaxed font-medium">Reach students across 15+ African countries and beyond</span>
                            </li>
                            <li class="flex items-start gap-3 group">
                                <div class="w-8 h-8 bg-gradient-to-br from-green-500 to-green-700 rounded-lg flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <span class="text-gray-700 dark:text-gray-300 leading-relaxed font-medium">Get full support from our dedicated instructor success team</span>
                            </li>
                            <li class="flex items-start gap-3 group">
                                <div class="w-8 h-8 bg-gradient-to-br from-amber-400 to-amber-600 rounded-lg flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <span class="text-gray-700 dark:text-gray-300 leading-relaxed font-medium">Access powerful teaching tools and analytics dashboard</span>
                            </li>
                        </ul>
                        <a href="{{ route('teacher.register') }}" class="group inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-bold rounded-xl transition-all shadow-xl hover:shadow-2xl transform hover:-translate-y-1 hover:scale-105">
                            <span>Start Teaching Today</span>
                            <svg class="ml-2 w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Categories Section - Professional Grid -->
        <section class="py-20 bg-white dark:bg-gray-900">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 dark:text-white mb-4 tracking-tight">Explore Top Categories</h2>
                    <p class="text-lg text-gray-600 dark:text-gray-400">Choose from over 500 courses across multiple disciplines</p>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @forelse($categories ?? [] as $category)
                        <a href="{{ route('courses.index', ['category' => $category->slug]) }}" class="group bg-white dark:bg-gray-900 p-6 rounded-xl shadow-sm hover:shadow-lg transition-all border border-gray-200 dark:border-gray-700 hover:border-green-700 dark:hover:border-green-600">
                            <div class="flex flex-col items-center text-center space-y-3">
                                @if($category->icon)
                                    <div class="text-4xl">{!! $category->icon !!}</div>
                                @else
                                    <div class="w-14 h-14 bg-green-50 dark:bg-green-900/20 rounded-xl flex items-center justify-center group-hover:bg-green-700 dark:group-hover:bg-green-700 transition-colors">
                                        <svg class="w-7 h-7 text-green-700 dark:text-green-400 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                        </svg>
                                    </div>
                                @endif
                                <div>
                                    <h3 class="font-bold text-gray-900 dark:text-white group-hover:text-green-700 dark:group-hover:text-green-400 transition-colors mb-1">{{ $category->name }}</h3>
                                    @if($category->courses_count)
                                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $category->courses_count }} {{ Str::plural('course', $category->courses_count) }}</p>
                                    @endif
                                </div>
                            </div>
                        </a>
                    @empty
                        <!-- Sample Categories Placeholder -->
                        @php
                            $sampleCategories = [
                                ['name' => 'Agriculture', 'icon' => '🌾'],
                                ['name' => 'Technology', 'icon' => '💻'],
                                ['name' => 'Business', 'icon' => '💼'],
                                ['name' => 'Design', 'icon' => '🎨'],
                                ['name' => 'Marketing', 'icon' => '📈'],
                                ['name' => 'Health', 'icon' => '🏥'],
                                ['name' => 'Finance', 'icon' => '💰'],
                                ['name' => 'Education', 'icon' => '📚'],
                            ];
                        @endphp
                        @foreach($sampleCategories as $sample)
                            <a href="{{ route('courses.index') }}" class="group bg-white dark:bg-gray-900 p-6 rounded-xl shadow-sm hover:shadow-lg transition-all border border-gray-200 dark:border-gray-700 hover:border-green-700 dark:hover:border-green-600">
                                <div class="flex flex-col items-center text-center space-y-3">
                                    <div class="text-4xl">{{ $sample['icon'] }}</div>
                                    <h3 class="font-bold text-gray-900 dark:text-white group-hover:text-green-700 dark:group-hover:text-green-400 transition-colors">{{ $sample['name'] }}</h3>
                                </div>
                            </a>
                        @endforeach
                    @endforelse
                </div>
            </div>
        </section>

        <!-- CTA Section - Vibrant African-Inspired -->
        <section class="relative py-24 bg-gradient-to-br from-green-600 via-green-700 to-amber-600 overflow-hidden">
            <!-- Vibrant African Pattern Background -->
            <div class="absolute inset-0 opacity-10">
                <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <pattern id="cta-pattern" x="0" y="0" width="100" height="100" patternUnits="userSpaceOnUse">
                            <circle cx="25" cy="25" r="20" fill="white" opacity="0.5"/>
                            <circle cx="75" cy="75" r="20" fill="#f59e0b" opacity="0.5"/>
                            <path d="M 0 50 Q 25 25, 50 50 T 100 50" stroke="white" fill="none" stroke-width="3" opacity="0.3"/>
                            <path d="M 50 0 Q 25 25, 0 50 T 0 100" stroke="#f59e0b" fill="none" stroke-width="3" opacity="0.3"/>
                        </pattern>
                    </defs>
                    <rect width="100%" height="100%" fill="url(#cta-pattern)"/>
                </svg>
            </div>

            <!-- Vibrant animated blobs -->
            <div class="absolute top-0 left-0 w-96 h-96 bg-gradient-to-br from-amber-400 to-yellow-500 rounded-full blur-3xl opacity-20 animate-pulse"></div>
            <div class="absolute bottom-0 right-0 w-96 h-96 bg-gradient-to-br from-green-400 to-green-600 rounded-full blur-3xl opacity-20 animate-pulse" style="animation-delay: 1s;"></div>

            <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <div class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-amber-400 via-yellow-400 to-amber-500 rounded-full mb-8 shadow-2xl transform hover:scale-105 transition-transform">
                    <svg class="w-5 h-5 text-white mr-2 animate-pulse" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd"/>
                    </svg>
                    <span class="text-base font-bold text-white uppercase tracking-wider">Start Learning Today</span>
                </div>

                <h2 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-white mb-6 tracking-tight drop-shadow-2xl">
                    Ready to <span class="text-amber-300">transform</span> your future?
                </h2>
                <p class="text-xl sm:text-2xl text-white/95 mb-12 leading-relaxed max-w-3xl mx-auto font-medium drop-shadow-lg">
                    Join thousands of African learners building successful careers with our expert-led courses
                </p>

                <div class="flex flex-col sm:flex-row gap-5 justify-center items-center">
                    <a href="{{ route('register') }}" class="group inline-flex items-center justify-center px-12 py-5 bg-gradient-to-r from-amber-400 to-yellow-500 hover:from-amber-500 hover:to-yellow-600 text-white font-bold text-lg rounded-2xl transition-all shadow-2xl hover:shadow-amber-500/50 transform hover:-translate-y-1 hover:scale-105 border-2 border-white/20">
                        <span>Get Started Free</span>
                        <svg class="ml-3 w-6 h-6 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </a>
                    <a href="{{ route('courses.index') }}" class="group inline-flex items-center justify-center px-12 py-5 bg-white/15 hover:bg-white/25 backdrop-blur-md text-white font-bold text-lg rounded-2xl border-3 border-white/50 hover:border-white/80 transition-all shadow-xl hover:shadow-2xl transform hover:scale-105">
                        <span>Explore Courses</span>
                        <svg class="ml-3 w-6 h-6 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </a>
                </div>

                <!-- Social proof badges -->
                <div class="mt-12 flex flex-wrap justify-center gap-8 items-center">
                    <div class="flex items-center gap-2 text-white/90">
                        <svg class="w-6 h-6 text-amber-300" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        <span class="font-bold">4.8/5 Rating</span>
                    </div>
                    <div class="flex items-center gap-2 text-white/90">
                        <svg class="w-6 h-6 text-amber-300" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                        </svg>
                        <span class="font-bold">10,000+ Students</span>
                    </div>
                    <div class="flex items-center gap-2 text-white/90">
                        <svg class="w-6 h-6 text-amber-300" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3z"/>
                        </svg>
                        <span class="font-bold">500+ Courses</span>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <x-footer />

</body>
</html>
