<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }} - Transform Your Future with Quality Education</title>
    <meta name="description" content="Africa's premier learning platform offering world-class courses in agriculture, technology, and vocational skills. Join 5,000+ students learning today.">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-white dark:bg-gray-900">

    <x-header />

    <main class="pt-16">
        <x-hero />

        <!-- Trusted By Section -->
        <section class="py-12 bg-gray-50 dark:bg-gray-800 border-y border-gray-200 dark:border-gray-700">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <p class="text-center text-sm font-semibold text-gray-600 dark:text-gray-400 mb-8">TRUSTED BY LEADING ORGANIZATIONS</p>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8 items-center opacity-50">
                    <div class="text-center text-gray-400 font-bold text-xl">Partner 1</div>
                    <div class="text-center text-gray-400 font-bold text-xl">Partner 2</div>
                    <div class="text-center text-gray-400 font-bold text-xl">Partner 3</div>
                    <div class="text-center text-gray-400 font-bold text-xl">Partner 4</div>
                </div>
            </div>
        </section>

        <!-- Featured Courses Section -->
        <section id="all-courses" class="py-20 bg-gray-50 dark:bg-gray-800" x-data="{
            searchQuery: '',
            selectedCategory: 'all',
            selectedLevel: 'all',
            showFilters: false,
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
                <div class="mb-8">
                    <h2 class="text-4xl font-bold text-gray-900 dark:text-white mb-3">Explore Our Courses</h2>
                    <p class="text-lg text-gray-600 dark:text-gray-400">Discover world-class courses taught by industry experts</p>
                </div>

                <!-- Search and Filter Bar -->
                <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 mb-8">
                    <div class="flex flex-col lg:flex-row gap-4">
                        <!-- Search Input -->
                        <div class="flex-1">
                            <div class="relative">
                                <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                                <input
                                    x-model="searchQuery"
                                    type="text"
                                    placeholder="Search courses by title or keyword..."
                                    class="w-full pl-12 pr-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition-colors"
                                >
                            </div>
                        </div>

                        <!-- Category Filter -->
                        <div class="lg:w-48">
                            <select x-model="selectedCategory" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                                <option value="all">All Categories</option>
                                @foreach($categories ?? [] as $category)
                                    <option value="{{ $category->slug }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Level Filter -->
                        <div class="lg:w-48">
                            <select x-model="selectedLevel" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                                <option value="all">All Levels</option>
                                <option value="beginner">Beginner</option>
                                <option value="intermediate">Intermediate</option>
                                <option value="advanced">Advanced</option>
                            </select>
                        </div>

                        <!-- Filter Toggle (Mobile) -->
                        <button @click="showFilters = !showFilters" class="lg:hidden px-4 py-3 bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-white rounded-lg border border-gray-300 dark:border-gray-600 flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                            </svg>
                            <span>Filters</span>
                        </button>
                    </div>

                    <!-- Active Filters Display -->
                    <div class="mt-4 flex items-center gap-2 flex-wrap" x-show="searchQuery || selectedCategory !== 'all' || selectedLevel !== 'all'">
                        <span class="text-sm text-gray-600 dark:text-gray-400">Active filters:</span>
                        <button x-show="searchQuery" @click="searchQuery = ''" class="px-3 py-1 bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-300 rounded-full text-sm flex items-center gap-1">
                            <span x-text="'Search: ' + searchQuery"></span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                        <button x-show="selectedCategory !== 'all'" @click="selectedCategory = 'all'" class="px-3 py-1 bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-300 rounded-full text-sm flex items-center gap-1">
                            <span x-text="'Category'"></span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                        <button x-show="selectedLevel !== 'all'" @click="selectedLevel = 'all'" class="px-3 py-1 bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-300 rounded-full text-sm flex items-center gap-1">
                            <span x-text="'Level'"></span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                        <button @click="searchQuery = ''; selectedCategory = 'all'; selectedLevel = 'all'" class="px-3 py-1 text-sm text-gray-600 dark:text-gray-400 hover:text-yellow-600 dark:hover:text-yellow-400">
                            Clear all
                        </button>
                    </div>
                </div>

                <!-- Results Count -->
                <div class="flex items-center justify-between mb-6">
                    <p class="text-gray-700 dark:text-gray-300">
                        Showing <span class="font-semibold" x-text="filteredCourses.length"></span>
                        <span x-text="filteredCourses.length === 1 ? 'course' : 'courses'"></span>
                    </p>
                    <a href="{{ route('courses.index') }}" class="text-sm font-medium text-yellow-600 dark:text-yellow-400 hover:text-yellow-700 dark:hover:text-yellow-300 flex items-center gap-1">
                        View all courses
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>

                <!-- Courses Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <template x-for="course in filteredCourses.slice(0, 8)" :key="course.id">
                        <div class="group bg-white dark:bg-gray-900 rounded-xl shadow-sm hover:shadow-xl transition-all border border-gray-200 dark:border-gray-700 overflow-hidden">
                            <!-- Course Image -->
                            <div class="relative overflow-hidden aspect-video bg-gray-200 dark:bg-gray-700">
                                <template x-if="course.thumbnail">
                                    <img :src="'/storage/' + course.thumbnail" :alt="course.title" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                </template>
                                <template x-if="!course.thumbnail">
                                    <div class="w-full h-full flex items-center justify-center bg-yellow-100 dark:bg-yellow-900/20">
                                        <svg class="w-16 h-16 text-yellow-300 dark:text-yellow-700" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3z"/>
                                        </svg>
                                    </div>
                                </template>

                                <!-- Featured Badge -->
                                <template x-if="course.is_featured">
                                    <div class="absolute top-3 left-3 bg-yellow-400 text-gray-900 text-xs font-bold px-2.5 py-1 rounded">
                                        FEATURED
                                    </div>
                                </template>

                                <!-- Level Badge -->
                                <template x-if="course.level">
                                    <div class="absolute top-3 right-3 bg-white/90 dark:bg-gray-900/90 text-gray-900 dark:text-white text-xs font-semibold px-2.5 py-1 rounded capitalize" x-text="course.level"></div>
                                </template>
                            </div>

                            <!-- Course Content -->
                            <div class="p-5 space-y-3">
                                <!-- Category -->
                                <template x-if="course.category">
                                    <span class="inline-block text-xs font-medium text-yellow-600 dark:text-yellow-400 bg-yellow-50 dark:bg-yellow-900/30 px-2.5 py-1 rounded-full" x-text="course.category.name"></span>
                                </template>

                                <!-- Title -->
                                <h3 class="text-base font-bold text-gray-900 dark:text-white line-clamp-2 group-hover:text-yellow-600 dark:group-hover:text-yellow-400 transition-colors" x-text="course.title"></h3>

                                <!-- Instructor -->
                                <template x-if="course.instructor">
                                    <p class="text-sm text-gray-600 dark:text-gray-400" x-text="'By ' + course.instructor.name"></p>
                                </template>

                                <!-- Rating & Students -->
                                <div class="flex items-center gap-4 text-sm">
                                    <template x-if="course.average_rating > 0">
                                        <div class="flex items-center gap-1">
                                            <span class="font-bold text-yellow-500" x-text="course.average_rating.toFixed(1)"></span>
                                            <div class="flex items-center">
                                                <template x-for="i in 5" :key="i">
                                                    <svg class="w-4 h-4" :class="i <= Math.floor(course.average_rating) ? 'text-yellow-400 fill-current' : 'text-gray-300 dark:text-gray-600 fill-current'" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                    </svg>
                                                </template>
                                            </div>
                                        </div>
                                    </template>

                                    <template x-if="course.students_count > 0">
                                        <div class="flex items-center gap-1 text-gray-600 dark:text-gray-400">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                                            </svg>
                                            <span x-text="course.students_count.toLocaleString()"></span>
                                        </div>
                                    </template>
                                </div>

                                <!-- Price -->
                                <div class="flex items-center justify-between pt-2 border-t border-gray-100 dark:border-gray-700">
                                    <template x-if="course.price > 0">
                                        <div class="flex items-baseline gap-2">
                                            <template x-if="course.discount_price && course.discount_price < course.price">
                                                <span>
                                                    <span class="text-xl font-bold text-gray-900 dark:text-white" x-text="course.currency + ' ' + course.discount_price.toLocaleString()"></span>
                                                    <span class="text-sm text-gray-500 dark:text-gray-400 line-through ml-2" x-text="course.price.toLocaleString()"></span>
                                                </span>
                                            </template>
                                            <template x-if="!course.discount_price || course.discount_price >= course.price">
                                                <span class="text-xl font-bold text-gray-900 dark:text-white" x-text="course.currency + ' ' + course.price.toLocaleString()"></span>
                                            </template>
                                        </div>
                                    </template>
                                    <template x-if="course.price == 0">
                                        <span class="text-xl font-bold text-green-600 dark:text-green-400">Free</span>
                                    </template>
                                </div>

                                <!-- CTA Button -->
                                <a :href="'/courses/' + course.slug" class="block w-full mt-3 px-4 py-2.5 bg-yellow-600 hover:bg-yellow-700 text-white text-sm font-semibold rounded-lg transition-colors text-center">
                                    View Course
                                </a>
                            </div>
                        </div>
                    </template>
                </div>

                <!-- No Results -->
                <div x-show="filteredCourses.length === 0" class="text-center py-16">
                    <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No courses found</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-4">Try adjusting your search or filters</p>
                    <button @click="searchQuery = ''; selectedCategory = 'all'; selectedLevel = 'all'" class="px-6 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition-colors">
                        Clear filters
                    </button>
                </div>

                <!-- View All Button -->
                <div class="text-center mt-12">
                    <a href="{{ route('courses.index') }}" class="inline-flex items-center px-8 py-4 bg-yellow-600 text-white font-semibold rounded-lg hover:bg-yellow-700 shadow-lg transition-all">
                        Browse All Courses
                        <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                </div>
            </div>
        </section>

        <!-- Categories Section -->
        <section class="py-20 bg-white dark:bg-gray-900">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">Explore Top Categories</h2>
                    <p class="text-xl text-gray-600 dark:text-gray-400">Choose from over 1,000 courses in 50+ categories</p>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @forelse($categories ?? [] as $category)
                        <a href="{{ route('courses.index', ['category' => $category->slug]) }}" class="group bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm hover:shadow-lg transition-all border border-gray-200 dark:border-gray-700 hover:border-yellow-500">
                            <div class="text-center space-y-3">
                                @if($category->icon)
                                    <div class="text-4xl">{!! $category->icon !!}</div>
                                @else
                                    <div class="w-16 h-16 mx-auto bg-gradient-to-br from-yellow-100 to-pink-100 dark:from-yellow-900/30 dark:to-pink-900/30 rounded-lg flex items-center justify-center">
                                        <svg class="w-8 h-8 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3z"/>
                                        </svg>
                                    </div>
                                @endif
                                <h3 class="font-semibold text-gray-900 dark:text-white group-hover:text-yellow-600 transition-colors">{{ $category->name }}</h3>
                            </div>
                        </a>
                    @empty
                        <!-- Sample Categories -->
                        @php
                            $sampleCategories = [
                                ['name' => 'Agriculture', 'icon' => '🌾'],
                                ['name' => 'Technology', 'icon' => '💻'],
                                ['name' => 'Business', 'icon' => '💼'],
                                ['name' => 'Design', 'icon' => '🎨'],
                                ['name' => 'Marketing', 'icon' => '📈'],
                                ['name' => 'Health', 'icon' => '🏥'],
                                ['name' => 'Finance', 'icon' => '💰'],
                                ['name' => 'Languages', 'icon' => '🗣️'],
                            ];
                        @endphp
                        @foreach($sampleCategories as $cat)
                        <a href="#" class="group bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm hover:shadow-lg transition-all border border-gray-200 dark:border-gray-700 hover:border-yellow-500">
                            <div class="text-center space-y-3">
                                <div class="text-5xl">{{ $cat['icon'] }}</div>
                                <h3 class="font-semibold text-gray-900 dark:text-white group-hover:text-yellow-600 transition-colors">{{ $cat['name'] }}</h3>
                                <p class="text-sm text-gray-500">100+ Courses</p>
                            </div>
                        </a>
                        @endforeach
                    @endforelse
                </div>
            </div>
        </section>

        <!-- About Imole Africa -->
        <section id="about" class="py-20 bg-white dark:bg-gray-900">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid lg:grid-cols-2 gap-16 items-center">
                    <div class="space-y-6">
                        <div class="inline-flex items-center space-x-2 px-4 py-2 bg-green-100 dark:bg-green-900/30 rounded-full">
                            <span class="text-sm font-semibold text-green-700 dark:text-green-300">About Us</span>
                        </div>
                        <h2 class="text-4xl lg:text-5xl font-bold text-gray-900 dark:text-white">Transforming Education Across Africa</h2>
                        <p class="text-lg text-gray-600 dark:text-gray-300">
                            Imole Africa Foundation is a non-profit organization committed to transforming the educational landscape across Africa. Through our digital ecosystem, we empower educators and learners with the skills needed for the 21st century.
                        </p>

                        <div class="grid md:grid-cols-2 gap-6">
                            <div class="flex items-start space-x-4">
                                <div class="flex-shrink-0 w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-900 dark:text-white mb-1">Our Vision</h3>
                                    <p class="text-gray-600 dark:text-gray-400 text-sm">To become a Lighthouse for the development of an All-inclusive and Sustainable Education sector in Africa</p>
                                </div>
                            </div>

                            <div class="flex items-start space-x-4">
                                <div class="flex-shrink-0 w-12 h-12 bg-yellow-100 dark:bg-yellow-900/30 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z" clip-rule="evenodd"/><path d="M2 13.692V16a2 2 0 002 2h12a2 2 0 002-2v-2.308A24.974 24.974 0 0110 15c-2.796 0-5.487-.46-8-1.308z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-900 dark:text-white mb-1">Our Mission</h3>
                                    <p class="text-gray-600 dark:text-gray-400 text-sm">To catalyze reforms in education by enhancing educator capacities through a Digital Ecosystem</p>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-wrap gap-4 pt-4">
                            <a href="#programs" class="inline-flex items-center px-6 py-3 bg-yellow-600 text-white font-semibold rounded-lg hover:bg-yellow-700 transition-colors shadow-lg">
                                Our Programs
                                <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                            </a>
                            <a href="#contact" class="inline-flex items-center px-6 py-3 bg-white dark:bg-gray-800 text-gray-900 dark:text-white font-semibold rounded-lg border-2 border-gray-200 dark:border-gray-700 hover:border-yellow-600 hover:text-yellow-600 dark:hover:text-yellow-400 transition-colors">
                                Get in Touch
                            </a>
                        </div>
                    </div>

                    <div class="relative">
                        <div class="aspect-square bg-gradient-to-br from-green-100 to-yellow-100 dark:from-green-900/20 dark:to-yellow-900/20 rounded-3xl"></div>
                        <div class="absolute inset-8 bg-white dark:bg-gray-800 rounded-3xl shadow-2xl flex items-center justify-center p-8">
                            <img src="{{ asset('images/logo.png') }}" alt="Imole Africa" class="w-full h-full object-contain">
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Programs Section -->
        <section id="programs" class="py-20 bg-gray-50 dark:bg-gray-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">Our Focus Areas</h2>
                    <p class="text-xl text-gray-600 dark:text-gray-400 max-w-3xl mx-auto">Comprehensive programs designed to transform education and empower communities across Africa</p>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @php
                        $programs = [
                            [
                                'title' => 'Inclusive Learning Programs',
                                'description' => 'Supporting marginalized learners—including children with disabilities, girls, and vulnerable groups—to access equitable education.',
                                'icon' => '<svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20"><path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"/></svg>',
                                'color' => 'green'
                            ],
                            [
                                'title' => 'Teacher Empowerment',
                                'description' => 'Equipping teachers with 21st-century skills, digital literacy training, and modern teaching methodologies.',
                                'icon' => '<svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20"><path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3z"/></svg>',
                                'color' => 'yellow'
                            ],
                            [
                                'title' => 'EdTech & Digital Transformation',
                                'description' => 'Promoting digital literacy through computer labs, e-learning platforms, and innovative classroom technologies.',
                                'icon' => '<svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3 5a2 2 0 012-2h10a2 2 0 012 2v8a2 2 0 01-2 2h-2.22l.123.489.804.804A1 1 0 0113 18H7a1 1 0 01-.707-1.707l.804-.804L7.22 15H5a2 2 0 01-2-2V5zm5.771 7H5V5h10v7H8.771z" clip-rule="evenodd"/></svg>',
                                'color' => 'green'
                            ],
                            [
                                'title' => 'School Infrastructure',
                                'description' => 'Renovating classrooms, equipping libraries, and creating safe, conducive learning spaces.',
                                'icon' => '<svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2h-3a1 1 0 01-1-1v-2a1 1 0 00-1-1H9a1 1 0 00-1 1v2a1 1 0 01-1 1H4a1 1 0 110-2V4zm3 1h2v2H7V5zm2 4H7v2h2V9zm2-4h2v2h-2V5zm2 4h-2v2h2V9z" clip-rule="evenodd"/></svg>',
                                'color' => 'yellow'
                            ],
                            [
                                'title' => 'Youth Leadership & Skills',
                                'description' => 'Cultivating empowered youth through mentorship, career guidance, and entrepreneurship support.',
                                'icon' => '<svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20"><path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"/></svg>',
                                'color' => 'green'
                            ],
                            [
                                'title' => 'Community Engagement',
                                'description' => 'Working with stakeholders to champion inclusive, equitable, and sustainable education policies.',
                                'icon' => '<svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd"/></svg>',
                                'color' => 'yellow'
                            ],
                        ];
                    @endphp

                    @foreach($programs as $program)
                    <div class="bg-white dark:bg-gray-900 p-8 rounded-2xl shadow-sm hover:shadow-xl transition-all border border-gray-200 dark:border-gray-700 group">
                        <div class="w-16 h-16 bg-{{ $program['color'] }}-100 dark:bg-{{ $program['color'] }}-900/30 rounded-xl flex items-center justify-center text-{{ $program['color'] }}-600 dark:text-{{ $program['color'] }}-400 mb-6 group-hover:scale-110 transition-transform">
                            {!! $program['icon'] !!}
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">{{ $program['title'] }}</h3>
                        <p class="text-gray-600 dark:text-gray-400 leading-relaxed">{{ $program['description'] }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Impact Stats -->
        <section id="impact" class="py-20 bg-gradient-to-r from-green-600 to-green-700 dark:from-green-700 dark:to-green-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-4xl font-bold text-white mb-4">Our Impact in Numbers</h2>
                    <p class="text-xl text-green-100">Making a measurable difference across Africa</p>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                    <div class="text-center">
                        <div class="text-6xl font-bold text-white mb-2">5,000+</div>
                        <div class="text-green-100 text-lg">Students Reached</div>
                    </div>
                    <div class="text-center">
                        <div class="text-6xl font-bold text-white mb-2">1,200+</div>
                        <div class="text-green-100 text-lg">Teachers Trained</div>
                    </div>
                    <div class="text-center">
                        <div class="text-6xl font-bold text-white mb-2">30+</div>
                        <div class="text-green-100 text-lg">Schools Supported</div>
                    </div>
                    <div class="text-center">
                        <div class="text-6xl font-bold text-white mb-2">15</div>
                        <div class="text-green-100 text-lg">Countries Served</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Testimonials -->
        <section class="py-20 bg-white dark:bg-gray-900">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">What Our Students Say</h2>
                    <p class="text-xl text-gray-600 dark:text-gray-400">Join thousands of satisfied learners</p>
                </div>

                <div class="grid md:grid-cols-3 gap-8">
                    @for($i = 0; $i < 3; $i++)
                    <div class="bg-gray-50 dark:bg-gray-800 p-8 rounded-2xl border border-gray-200 dark:border-gray-700">
                        <div class="flex text-yellow-400 mb-4">
                            @for($j = 0; $j < 5; $j++)
                            <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            @endfor
                        </div>
                        <p class="text-gray-700 dark:text-gray-300 mb-6 italic">"This platform has transformed my farming techniques. The agricultural courses are practical and easy to follow. Highly recommended!"</p>
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-green-200 dark:bg-green-800 rounded-full flex items-center justify-center font-bold text-green-700 dark:text-green-300">JD</div>
                            <div>
                                <div class="font-semibold text-gray-900 dark:text-white">John Doe</div>
                                <div class="text-sm text-gray-600 dark:text-gray-400">Farmer, Kenya</div>
                            </div>
                        </div>
                    </div>
                    @endfor
                </div>
            </div>
        </section>

        <!-- How It Works -->
        <section class="py-20 bg-gray-50 dark:bg-gray-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">How It Works</h2>
                    <p class="text-xl text-gray-600 dark:text-gray-400">Start your learning journey in three simple steps</p>
                </div>

                <div class="grid md:grid-cols-3 gap-12">
                    <div class="text-center">
                        <div class="relative mb-6">
                            <div class="w-24 h-24 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center mx-auto shadow-lg">
                                <span class="text-4xl font-bold text-white">1</span>
                            </div>
                            <div class="hidden md:block absolute top-12 left-full w-full h-1 bg-gradient-to-r from-green-500 to-yellow-500"></div>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Sign Up Free</h3>
                        <p class="text-gray-600 dark:text-gray-400 text-lg">Create your account in seconds and get instant access to our course library</p>
                    </div>

                    <div class="text-center">
                        <div class="relative mb-6">
                            <div class="w-24 h-24 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-full flex items-center justify-center mx-auto shadow-lg">
                                <span class="text-4xl font-bold text-white">2</span>
                            </div>
                            <div class="hidden md:block absolute top-12 left-full w-full h-1 bg-gradient-to-r from-yellow-500 to-green-500"></div>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Choose & Enroll</h3>
                        <p class="text-gray-600 dark:text-gray-400 text-lg">Browse categories and enroll in courses that match your goals</p>
                    </div>

                    <div class="text-center">
                        <div class="relative mb-6">
                            <div class="w-24 h-24 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center mx-auto shadow-lg">
                                <span class="text-4xl font-bold text-white">3</span>
                            </div>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Learn & Earn</h3>
                        <p class="text-gray-600 dark:text-gray-400 text-lg">Complete courses at your pace and earn recognized certificates</p>
                    </div>
                </div>

                <div class="text-center mt-12">
                    <a href="{{ route('register') }}" class="inline-flex items-center px-10 py-4 bg-yellow-600 text-white text-lg font-bold rounded-lg hover:bg-yellow-700 shadow-xl hover:shadow-2xl transition-all">
                        Get Started Now - It's Free!
                        <svg class="ml-2 w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </a>
                </div>
            </div>
        </section>

        <!-- Get Involved -->
        <section class="py-20 bg-gradient-to-br from-green-600 via-green-700 to-yellow-600">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-4xl font-bold text-white mb-4">Get Involved</h2>
                    <p class="text-xl text-green-100">Help us light the future of Africa's education</p>
                </div>

                <div class="grid md:grid-cols-3 gap-8">
                    <div class="bg-white dark:bg-gray-900 p-10 rounded-2xl shadow-2xl text-center transform hover:scale-105 transition-transform">
                        <div class="w-20 h-20 bg-yellow-100 dark:bg-yellow-900/30 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-10 h-10 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Donate</h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-6 text-lg">Support our mission with a contribution to provide learning materials and training</p>
                        <a href="#contact" class="inline-flex items-center px-6 py-3 bg-yellow-600 text-white font-semibold rounded-lg hover:bg-yellow-700 transition-colors shadow-lg">
                            Contact Us
                        </a>
                    </div>

                    <div class="bg-white dark:bg-gray-900 p-10 rounded-2xl shadow-2xl text-center transform hover:scale-105 transition-transform">
                        <div class="w-20 h-20 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-10 h-10 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Volunteer</h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-6 text-lg">Share your skills and time to mentor students and support our programs</p>
                        <a href="#contact" class="inline-flex items-center px-6 py-3 bg-yellow-600 text-white font-semibold rounded-lg hover:bg-yellow-700 transition-colors shadow-lg">
                            Contact Us
                        </a>
                    </div>

                    <div class="bg-white dark:bg-gray-900 p-10 rounded-2xl shadow-2xl text-center transform hover:scale-105 transition-transform">
                        <div class="w-20 h-20 bg-yellow-100 dark:bg-yellow-900/30 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-10 h-10 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z"/>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Partner</h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-6 text-lg">Collaborate with us to expand quality education access across Africa</p>
                        <a href="#contact" class="inline-flex items-center px-6 py-3 bg-yellow-600 text-white font-semibold rounded-lg hover:bg-yellow-700 transition-colors shadow-lg">
                            Contact Us
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Contact Section -->
        <section id="contact" class="py-20 bg-white dark:bg-gray-900">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid lg:grid-cols-2 gap-16">
                    <div>
                        <h2 class="text-4xl font-bold text-gray-900 dark:text-white mb-6">Get in Touch</h2>
                        <p class="text-lg text-gray-600 dark:text-gray-300 mb-8">Have questions? We'd love to hear from you. Send us a message and we'll respond as soon as possible.</p>

                        <div class="space-y-6">
                            <div class="flex items-start space-x-4">
                                <div class="flex-shrink-0 w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/><path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-900 dark:text-white mb-1">Email</h3>
                                    <a href="mailto:info@imoleafrica.org" class="text-green-600 hover:text-green-700 text-lg">info@imoleafrica.org</a>
                                </div>
                            </div>

                            <div class="flex items-start space-x-4">
                                <div class="flex-shrink-0 w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-900 dark:text-white mb-1">Phone</h3>
                                    <a href="tel:+254700000000" class="text-green-600 hover:text-green-700 text-lg">+254 700 000 000</a>
                                </div>
                            </div>

                            <div class="flex items-start space-x-4">
                                <div class="flex-shrink-0 w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-900 dark:text-white mb-1">Address</h3>
                                    <p class="text-gray-600 dark:text-gray-400">Salesian of Don Bosco (MSSC)<br>BF 3, Upper Hill Road<br>P.O. BOX 62322, Nairobi, Kenya</p>
                                </div>
                            </div>
                        </div>

                        <div class="mt-8">
                            <h3 class="font-bold text-gray-900 dark:text-white mb-4">Follow Us</h3>
                            <div class="flex space-x-4">
                                <a href="#" class="w-12 h-12 bg-gray-100 dark:bg-gray-800 rounded-lg flex items-center justify-center hover:bg-green-100 dark:hover:bg-green-900/30 transition-colors">
                                    <svg class="w-6 h-6 text-gray-600 dark:text-gray-400" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                                </a>
                                <a href="#" class="w-12 h-12 bg-gray-100 dark:bg-gray-800 rounded-lg flex items-center justify-center hover:bg-green-100 dark:hover:bg-green-900/30 transition-colors">
                                    <svg class="w-6 h-6 text-gray-600 dark:text-gray-400" fill="currentColor" viewBox="0 0 24 24"><path d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z"/></svg>
                                </a>
                                <a href="#" class="w-12 h-12 bg-gray-100 dark:bg-gray-800 rounded-lg flex items-center justify-center hover:bg-green-100 dark:hover:bg-green-900/30 transition-colors">
                                    <svg class="w-6 h-6 text-gray-600 dark:text-gray-400" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 dark:bg-gray-800 p-8 rounded-2xl border border-gray-200 dark:border-gray-700">
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Send us a message</h3>
                        <form class="space-y-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Full Name</label>
                                <input type="text" id="name" class="w-full px-4 py-3 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" required>
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email Address</label>
                                <input type="email" id="email" class="w-full px-4 py-3 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" required>
                            </div>
                            <div>
                                <label for="subject" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Subject</label>
                                <input type="text" id="subject" class="w-full px-4 py-3 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" required>
                            </div>
                            <div>
                                <label for="message" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Message</label>
                                <textarea id="message" rows="4" class="w-full px-4 py-3 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" required></textarea>
                            </div>
                            <button type="submit" class="w-full px-6 py-4 bg-green-600 text-white font-bold rounded-lg hover:bg-green-700 transition-colors shadow-lg">
                                Send Message
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Enhanced Premium Footer -->
    <footer class="bg-gray-900 dark:bg-black text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <!-- Newsletter Section -->
            <div class="bg-gradient-to-r from-yellow-600 to-yellow-700 rounded-2xl p-8 md:p-12 mb-12">
                <div class="grid md:grid-cols-2 gap-8 items-center">
                    <div>
                        <h3 class="text-2xl md:text-3xl font-bold text-white mb-3">Stay Updated</h3>
                        <p class="text-yellow-100 text-lg">Subscribe to our newsletter for the latest courses, programs, and educational resources.</p>
                    </div>
                    <form class="flex flex-col sm:flex-row gap-3">
                        <input type="email" placeholder="Enter your email address" class="flex-1 px-5 py-3.5 rounded-lg bg-white/10 border border-white/20 text-white placeholder-yellow-200 focus:outline-none focus:ring-2 focus:ring-white/50 focus:border-transparent">
                        <button type="submit" class="px-8 py-3.5 bg-white text-yellow-600 font-semibold rounded-lg hover:bg-gray-100 transition-colors whitespace-nowrap">
                            Subscribe
                        </button>
                    </form>
                </div>
            </div>

            <!-- Footer Links Grid -->
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-8 md:gap-12 mb-12">
                <!-- Brand -->
                <div class="col-span-2 md:col-span-3 lg:col-span-2">
                    <div class="flex items-center space-x-2 mb-4">
                        <img src="{{ asset('images/logo.png') }}" alt="Imole Africa" class="h-10 w-10">
                        <span class="text-xl font-bold">Imole Africa Foundation</span>
                    </div>
                    <p class="text-gray-400 mb-6 max-w-md leading-relaxed">Transforming education across Africa through innovative digital learning solutions. Empowering educators and learners with 21st-century skills.</p>
                    <div class="flex space-x-3">
                        <a href="#" class="w-11 h-11 bg-gray-800 rounded-lg flex items-center justify-center hover:bg-yellow-600 transition-colors group">
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-white transition-colors" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </a>
                        <a href="#" class="w-11 h-11 bg-gray-800 rounded-lg flex items-center justify-center hover:bg-yellow-600 transition-colors group">
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-white transition-colors" fill="currentColor" viewBox="0 0 24 24"><path d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z"/></svg>
                        </a>
                        <a href="#" class="w-11 h-11 bg-gray-800 rounded-lg flex items-center justify-center hover:bg-yellow-600 transition-colors group">
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-white transition-colors" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                        </a>
                        <a href="#" class="w-11 h-11 bg-gray-800 rounded-lg flex items-center justify-center hover:bg-yellow-600 transition-colors group">
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-white transition-colors" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0C8.74 0 8.333.015 7.053.072 5.775.132 4.905.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.905.131 5.775.072 7.053.012 8.333 0 8.74 0 12s.015 3.667.072 4.947c.06 1.277.261 2.148.558 2.913.306.788.717 1.459 1.384 2.126.667.666 1.336 1.079 2.126 1.384.766.296 1.636.499 2.913.558C8.333 23.988 8.74 24 12 24s3.667-.015 4.947-.072c1.277-.06 2.148-.262 2.913-.558.788-.306 1.459-.718 2.126-1.384.666-.667 1.079-1.335 1.384-2.126.296-.765.499-1.636.558-2.913.06-1.28.072-1.687.072-4.947s-.015-3.667-.072-4.947c-.06-1.277-.262-2.149-.558-2.913-.306-.789-.718-1.459-1.384-2.126C21.319 1.347 20.651.935 19.86.63c-.765-.297-1.636-.499-2.913-.558C15.667.012 15.26 0 12 0zm0 2.16c3.203 0 3.585.016 4.85.071 1.17.055 1.805.249 2.227.415.562.217.96.477 1.382.896.419.42.679.819.896 1.381.164.422.36 1.057.413 2.227.057 1.266.07 1.646.07 4.85s-.015 3.585-.074 4.85c-.061 1.17-.256 1.805-.421 2.227-.224.562-.479.96-.899 1.382-.419.419-.824.679-1.38.896-.42.164-1.065.36-2.235.413-1.274.057-1.649.07-4.859.07-3.211 0-3.586-.015-4.859-.074-1.171-.061-1.816-.256-2.236-.421-.569-.224-.96-.479-1.379-.899-.421-.419-.69-.824-.9-1.38-.165-.42-.359-1.065-.42-2.235-.045-1.26-.061-1.649-.061-4.844 0-3.196.016-3.586.061-4.861.061-1.17.255-1.814.42-2.234.21-.57.479-.96.9-1.381.419-.419.81-.689 1.379-.898.42-.166 1.051-.361 2.221-.421 1.275-.045 1.65-.06 4.859-.06l.045.03zm0 3.678c-3.405 0-6.162 2.76-6.162 6.162 0 3.405 2.76 6.162 6.162 6.162 3.405 0 6.162-2.76 6.162-6.162 0-3.405-2.76-6.162-6.162-6.162zM12 16c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm7.846-10.405c0 .795-.646 1.44-1.44 1.44-.795 0-1.44-.646-1.44-1.44 0-.794.646-1.439 1.44-1.439.793-.001 1.44.645 1.44 1.439z"/></svg>
                        </a>
                        <a href="#" class="w-11 h-11 bg-gray-800 rounded-lg flex items-center justify-center hover:bg-yellow-600 transition-colors group">
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-white transition-colors" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                        </a>
                    </div>
                </div>

                <!-- Company -->
                <div>
                    <h4 class="font-bold text-lg mb-4 text-white">Company</h4>
                    <ul class="space-y-3 text-gray-400">
                        <li><a href="#about" class="hover:text-yellow-400 transition-colors flex items-center gap-2 group">
                            <svg class="w-4 h-4 opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            About Us
                        </a></li>
                        <li><a href="#programs" class="hover:text-yellow-400 transition-colors flex items-center gap-2 group">
                            <svg class="w-4 h-4 opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            Our Programs
                        </a></li>
                        <li><a href="#impact" class="hover:text-yellow-400 transition-colors flex items-center gap-2 group">
                            <svg class="w-4 h-4 opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            Our Impact
                        </a></li>
                        <li><a href="#" class="hover:text-yellow-400 transition-colors flex items-center gap-2 group">
                            <svg class="w-4 h-4 opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            Our Team
                        </a></li>
                        <li><a href="#" class="hover:text-yellow-400 transition-colors flex items-center gap-2 group">
                            <svg class="w-4 h-4 opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            Careers
                        </a></li>
                        <li><a href="#contact" class="hover:text-yellow-400 transition-colors flex items-center gap-2 group">
                            <svg class="w-4 h-4 opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            Contact
                        </a></li>
                    </ul>
                </div>

                <!-- Learning -->
                <div>
                    <h4 class="font-bold text-lg mb-4 text-white">Learning</h4>
                    <ul class="space-y-3 text-gray-400">
                        <li><a href="{{ route('courses.index') }}" class="hover:text-yellow-400 transition-colors flex items-center gap-2 group">
                            <svg class="w-4 h-4 opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            Browse Courses
                        </a></li>
                        <li><a href="{{ route('courses.index') }}?category=agriculture" class="hover:text-yellow-400 transition-colors flex items-center gap-2 group">
                            <svg class="w-4 h-4 opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            Agriculture
                        </a></li>
                        <li><a href="{{ route('courses.index') }}?category=technology" class="hover:text-yellow-400 transition-colors flex items-center gap-2 group">
                            <svg class="w-4 h-4 opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            Technology
                        </a></li>
                        <li><a href="{{ route('courses.index') }}?category=vocational" class="hover:text-yellow-400 transition-colors flex items-center gap-2 group">
                            <svg class="w-4 h-4 opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            Vocational Skills
                        </a></li>
                        <li><a href="{{ route('courses.index') }}?category=business" class="hover:text-yellow-400 transition-colors flex items-center gap-2 group">
                            <svg class="w-4 h-4 opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            Business
                        </a></li>
                        <li><a href="{{ route('courses.index') }}" class="hover:text-yellow-400 transition-colors flex items-center gap-2 group">
                            <svg class="w-4 h-4 opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            Free Courses
                        </a></li>
                    </ul>
                </div>

                <!-- Resources -->
                <div>
                    <h4 class="font-bold text-lg mb-4 text-white">Resources</h4>
                    <ul class="space-y-3 text-gray-400">
                        <li><a href="#contact" class="hover:text-yellow-400 transition-colors flex items-center gap-2 group">
                            <svg class="w-4 h-4 opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            Help Center
                        </a></li>
                        <li><a href="#" class="hover:text-yellow-400 transition-colors flex items-center gap-2 group">
                            <svg class="w-4 h-4 opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            Student Resources
                        </a></li>
                        <li><a href="#" class="hover:text-yellow-400 transition-colors flex items-center gap-2 group">
                            <svg class="w-4 h-4 opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            Teacher Resources
                        </a></li>
                        <li><a href="#" class="hover:text-yellow-400 transition-colors flex items-center gap-2 group">
                            <svg class="w-4 h-4 opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            Blog
                        </a></li>
                        <li><a href="#contact" class="hover:text-yellow-400 transition-colors flex items-center gap-2 group">
                            <svg class="w-4 h-4 opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            FAQs
                        </a></li>
                        <li><a href="#" class="hover:text-yellow-400 transition-colors flex items-center gap-2 group">
                            <svg class="w-4 h-4 opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            Downloads
                        </a></li>
                    </ul>
                </div>

                <!-- Get Involved -->
                <div>
                    <h4 class="font-bold text-lg mb-4 text-white">Get Involved</h4>
                    <ul class="space-y-3 text-gray-400">
                        <li><a href="{{ route('teacher.register') }}" class="hover:text-yellow-400 transition-colors flex items-center gap-2 group">
                            <svg class="w-4 h-4 opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            Become a Teacher
                        </a></li>
                        <li><a href="#contact" class="hover:text-yellow-400 transition-colors flex items-center gap-2 group">
                            <svg class="w-4 h-4 opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            Partner With Us
                        </a></li>
                        <li><a href="#contact" class="hover:text-yellow-400 transition-colors flex items-center gap-2 group">
                            <svg class="w-4 h-4 opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            Volunteer
                        </a></li>
                        <li><a href="#contact" class="hover:text-yellow-400 transition-colors flex items-center gap-2 group">
                            <svg class="w-4 h-4 opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            Donate
                        </a></li>
                        <li><a href="#" class="hover:text-yellow-400 transition-colors flex items-center gap-2 group">
                            <svg class="w-4 h-4 opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            Scholarships
                        </a></li>
                        <li><a href="#" class="hover:text-yellow-400 transition-colors flex items-center gap-2 group">
                            <svg class="w-4 h-4 opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            Community
                        </a></li>
                    </ul>
                </div>
            </div>

            <!-- Trust Badges -->
            <div class="border-t border-gray-800 pt-8 pb-8">
                <div class="flex flex-wrap items-center justify-center gap-8 mb-8">
                    <div class="flex items-center gap-3 text-gray-400">
                        <svg class="w-8 h-8 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <div>
                            <div class="font-semibold text-white text-sm">Secure Platform</div>
                            <div class="text-xs">SSL Encrypted</div>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 text-gray-400">
                        <svg class="w-8 h-8 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                            <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>
                        </svg>
                        <div>
                            <div class="font-semibold text-white text-sm">Certified Courses</div>
                            <div class="text-xs">Industry Recognized</div>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 text-gray-400">
                        <svg class="w-8 h-8 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 3.5a1.5 1.5 0 013 0V4a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-.5a1.5 1.5 0 000 3h.5a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-.5a1.5 1.5 0 00-3 0v.5a1 1 0 01-1 1H6a1 1 0 01-1-1v-3a1 1 0 00-1-1h-.5a1.5 1.5 0 010-3H4a1 1 0 001-1V6a1 1 0 011-1h3a1 1 0 001-1v-.5z"/>
                        </svg>
                        <div>
                            <div class="font-semibold text-white text-sm">Expert Instructors</div>
                            <div class="text-xs">Quality Guaranteed</div>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 text-gray-400">
                        <svg class="w-8 h-8 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <div>
                            <div class="font-semibold text-white text-sm">5,000+ Students</div>
                            <div class="text-xs">Join Our Community</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom Bar -->
            <div class="border-t border-gray-800 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-gray-400 text-sm text-center md:text-left">
                    © 2025 Imole Africa Foundation. All rights reserved. | Registered Non-Profit Organization
                </p>
                <div class="flex flex-wrap items-center justify-center gap-4 md:gap-6 text-sm text-gray-400">
                    <a href="#contact" class="hover:text-yellow-400 transition-colors">Privacy Policy</a>
                    <span class="text-gray-700">•</span>
                    <a href="#contact" class="hover:text-yellow-400 transition-colors">Terms of Service</a>
                    <span class="text-gray-700">•</span>
                    <a href="#contact" class="hover:text-yellow-400 transition-colors">Cookie Policy</a>
                    <span class="text-gray-700">•</span>
                    <a href="#contact" class="hover:text-yellow-400 transition-colors">Accessibility</a>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>
