<x-layouts.student>
    <x-slot name="title">My Learning</x-slot>

    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-purple-600 via-purple-700 to-indigo-700">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12">
            <h1 class="text-3xl md:text-4xl font-bold text-white mb-2">Welcome back, {{ auth()->user()->name }}!</h1>
            <p class="text-purple-100 text-lg">Continue learning and achieve your goals</p>
        </div>
    </div>

    <!-- Stats Bar -->
    <div class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 py-6">
                <div class="text-center">
                    <div class="text-3xl font-bold text-gray-900 dark:text-white">{{ $stats['enrolled_courses'] }}</div>
                    <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">Courses Enrolled</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-gray-900 dark:text-white">{{ $stats['in_progress'] }}</div>
                    <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">In Progress</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-gray-900 dark:text-white">{{ $stats['completed_courses'] }}</div>
                    <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">Completed</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-gray-900 dark:text-white">{{ $stats['certificates'] }}</div>
                    <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">Certificates</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8">
        <!-- Continue Learning Section -->
        @if($enrolledCourses->count() > 0)
            <div class="mb-12">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Continue Learning</h2>
                    <a href="{{ route('student.my-courses') }}" class="text-purple-600 dark:text-purple-400 hover:text-purple-700 dark:hover:text-purple-300 font-semibold text-sm flex items-center gap-2">
                        View all courses
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    @foreach($enrolledCourses as $enrollment)
                        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden hover:shadow-lg transition-all group">
                            <div class="flex">
                                <!-- Course Thumbnail -->
                                <div class="w-40 flex-shrink-0 relative">
                                    @if($enrollment->course->thumbnail)
                                        <img src="{{ Storage::url($enrollment->course->thumbnail) }}" alt="{{ $enrollment->course->title }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-purple-100 to-indigo-100 dark:from-purple-900/20 dark:to-indigo-900/20">
                                            <svg class="w-12 h-12 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                            </svg>
                                        </div>
                                    @endif
                                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-10 transition-all flex items-center justify-center">
                                        <svg class="w-12 h-12 text-white opacity-0 group-hover:opacity-90 transition-opacity" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M8 5v14l11-7z"/>
                                        </svg>
                                    </div>
                                </div>

                                <!-- Course Info -->
                                <div class="flex-1 p-4">
                                    <div class="mb-2">
                                        <h3 class="font-bold text-gray-900 dark:text-white line-clamp-2 mb-1 group-hover:text-purple-600 dark:group-hover:text-purple-400 transition-colors">
                                            {{ $enrollment->course->title }}
                                        </h3>
                                        <p class="text-xs text-gray-600 dark:text-gray-400">
                                            by {{ $enrollment->course->instructor->name }}
                                        </p>
                                    </div>

                                    <!-- Progress Bar -->
                                    <div class="mt-3">
                                        <div class="flex items-center justify-between mb-1">
                                            <span class="text-xs font-medium text-gray-700 dark:text-gray-300">{{ $enrollment->progress_percentage ?? 0 }}% complete</span>
                                        </div>
                                        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-1.5">
                                            <div class="bg-purple-600 h-1.5 rounded-full transition-all" style="width: {{ $enrollment->progress_percentage ?? 0 }}%"></div>
                                        </div>
                                    </div>

                                    <!-- Continue Button -->
                                    <a href="{{ route('courses.show', $enrollment->course) }}" class="mt-3 inline-flex items-center gap-2 text-sm font-semibold text-purple-600 dark:text-purple-400 hover:text-purple-700 dark:hover:text-purple-300">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M8 5v14l11-7z"/>
                                        </svg>
                                        Continue Course
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Recommended Courses -->
        @if($recommendedCourses->count() > 0)
            <div class="mb-12">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Recommended for You</h2>
                    <a href="{{ route('courses.index') }}" class="text-purple-600 dark:text-purple-400 hover:text-purple-700 dark:hover:text-purple-300 font-semibold text-sm flex items-center gap-2">
                        Explore all courses
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($recommendedCourses as $course)
                        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden hover:shadow-lg transition-all group">
                            <!-- Course Thumbnail -->
                            <div class="aspect-video bg-gray-200 dark:bg-gray-700 relative overflow-hidden">
                                @if($course->thumbnail)
                                    <img src="{{ Storage::url($course->thumbnail) }}" alt="{{ $course->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-purple-100 to-indigo-100 dark:from-purple-900/20 dark:to-indigo-900/20">
                                        <svg class="w-16 h-16 text-purple-600 dark:text-purple-400 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                        </svg>
                                    </div>
                                @endif
                                @if($course->is_featured)
                                    <span class="absolute top-2 left-2 px-2 py-1 bg-yellow-500 text-white text-xs font-bold rounded">Bestseller</span>
                                @endif
                            </div>

                            <!-- Course Info -->
                            <div class="p-4">
                                <h3 class="font-bold text-gray-900 dark:text-white line-clamp-2 mb-2 group-hover:text-purple-600 dark:group-hover:text-purple-400 transition-colors">
                                    {{ $course->title }}
                                </h3>
                                <p class="text-xs text-gray-600 dark:text-gray-400 mb-3">
                                    {{ $course->instructor->name }}
                                </p>

                                <div class="flex items-center justify-between mb-3">
                                    <div class="flex items-center gap-1">
                                        <span class="text-sm font-bold text-gray-900 dark:text-white">{{ number_format($course->average_rating, 1) }}</span>
                                        <x-star-rating :rating="$course->average_rating" size="sm" />
                                        <span class="text-xs text-gray-500 dark:text-gray-400">({{ $course->reviews_count }})</span>
                                    </div>
                                </div>

                                @if($course->price > 0)
                                    <div class="text-lg font-bold text-gray-900 dark:text-white mb-3">
                                        Ksh{{ number_format($course->price, 2) }}
                                    </div>
                                @else
                                    <div class="text-lg font-bold text-green-600 dark:text-green-400 mb-3">
                                        Free
                                    </div>
                                @endif

                                <a href="{{ route('courses.show', $course) }}" class="block w-full px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white text-sm font-bold rounded text-center transition-colors">
                                    View Course
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Empty State -->
        @if($enrolledCourses->count() === 0 && $recommendedCourses->count() === 0)
            <div class="text-center py-16">
                <div class="inline-flex items-center justify-center w-24 h-24 bg-purple-100 dark:bg-purple-900/20 rounded-full mb-6">
                    <svg class="w-12 h-12 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-3">Start Your Learning Journey</h3>
                <p class="text-gray-600 dark:text-gray-400 mb-8 max-w-md mx-auto">Explore thousands of courses and start learning new skills today</p>
                <a href="{{ route('courses.index') }}" class="inline-flex items-center gap-2 px-8 py-3 bg-purple-600 hover:bg-purple-700 text-white font-bold rounded-lg transition-colors">
                    Browse Courses
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </a>
            </div>
        @endif
    </div>
</x-layouts.student>
