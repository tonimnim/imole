<x-layouts.student>
    <x-slot name="title">My Courses</x-slot>

    <!-- Page Header -->
    <div class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">My Courses</h1>
            <p class="mt-2 text-gray-600 dark:text-gray-400">Track and manage all your enrolled courses</p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8">
        @if($enrollments->count() > 0)
            <!-- Filter Tabs -->
            <div class="mb-8 border-b border-gray-200 dark:border-gray-700">
                <nav class="flex gap-8 -mb-px">
                    <button class="border-b-2 border-purple-600 px-1 pb-4 text-sm font-semibold text-purple-600 dark:text-purple-400">
                        All Courses ({{ $enrollments->total() }})
                    </button>
                    <button class="border-b-2 border-transparent px-1 pb-4 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-200 transition-colors">
                        In Progress
                    </button>
                    <button class="border-b-2 border-transparent px-1 pb-4 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-200 transition-colors">
                        Completed
                    </button>
                </nav>
            </div>

            <!-- Courses Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                @foreach($enrollments as $enrollment)
                    <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden hover:shadow-xl transition-all group">
                        <!-- Course Thumbnail -->
                        <a href="{{ route('courses.show', $enrollment->course) }}" class="block relative overflow-hidden">
                            <div class="aspect-video bg-gray-200 dark:bg-gray-700">
                                @if($enrollment->course->thumbnail)
                                    <img src="{{ Storage::url($enrollment->course->thumbnail) }}" alt="{{ $enrollment->course->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-purple-100 to-indigo-100 dark:from-purple-900/20 dark:to-indigo-900/20">
                                        <svg class="w-16 h-16 text-purple-600 dark:text-purple-400 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                        </svg>
                                    </div>
                                @endif
                            </div>

                            <!-- Status Badge -->
                            @if($enrollment->progress_percentage == 100)
                                <div class="absolute top-3 left-3 px-2.5 py-1 bg-green-500 text-white text-xs font-bold rounded shadow-lg">
                                    COMPLETED
                                </div>
                            @elseif($enrollment->progress_percentage > 0)
                                <div class="absolute top-3 left-3 px-2.5 py-1 bg-blue-500 text-white text-xs font-bold rounded shadow-lg">
                                    IN PROGRESS
                                </div>
                            @else
                                <div class="absolute top-3 left-3 px-2.5 py-1 bg-gray-700 text-white text-xs font-bold rounded shadow-lg">
                                    NOT STARTED
                                </div>
                            @endif
                        </a>

                        <!-- Course Info -->
                        <div class="p-5">
                            <a href="{{ route('courses.show', $enrollment->course) }}" class="block">
                                <h3 class="font-bold text-lg text-gray-900 dark:text-white line-clamp-2 mb-2 group-hover:text-purple-600 dark:group-hover:text-purple-400 transition-colors">
                                    {{ $enrollment->course->title }}
                                </h3>
                            </a>

                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                                by {{ $enrollment->course->instructor->name }}
                            </p>

                            <!-- Course Stats -->
                            <div class="flex items-center gap-4 mb-4 text-xs text-gray-600 dark:text-gray-400">
                                <div class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span>{{ $enrollment->course->lessons_count }} lessons</span>
                                </div>
                                <div class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                    </svg>
                                    <span>{{ $enrollment->course->modules_count }} modules</span>
                                </div>
                            </div>

                            <!-- Progress Bar -->
                            <div class="mb-4">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-xs font-medium text-gray-700 dark:text-gray-300">Your progress</span>
                                    <span class="text-xs font-bold text-purple-600 dark:text-purple-400">{{ $enrollment->progress_percentage ?? 0 }}%</span>
                                </div>
                                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                    <div class="bg-purple-600 h-2 rounded-full transition-all" style="width: {{ $enrollment->progress_percentage ?? 0 }}%"></div>
                                </div>
                            </div>

                            <!-- Enrolled Date -->
                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-4">
                                Enrolled {{ $enrollment->enrolled_at?->diffForHumans() ?? $enrollment->created_at->diffForHumans() }}
                            </p>

                            <!-- Action Button -->
                            @if($enrollment->progress_percentage == 100)
                                <div class="flex gap-2">
                                    <a href="{{ route('student.learn.completed', $enrollment->course) }}" class="flex-1 px-4 py-2.5 bg-green-600 hover:bg-green-700 text-white text-sm font-bold rounded text-center transition-colors">
                                        View Achievement
                                    </a>
                                    <a href="{{ route('student.learn.start', $enrollment->course) }}" class="flex-1 px-4 py-2.5 bg-purple-600 hover:bg-purple-700 text-white text-sm font-bold rounded text-center transition-colors">
                                        Review Lessons
                                    </a>
                                </div>
                            @else
                                <a href="{{ route('student.learn.start', $enrollment->course) }}" class="block w-full px-4 py-2.5 bg-purple-600 hover:bg-purple-700 text-white text-sm font-bold rounded text-center transition-colors">
                                    @if($enrollment->progress_percentage > 0)
                                        Continue Learning
                                    @else
                                        Start Course
                                    @endif
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $enrollments->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-20">
                <div class="inline-flex items-center justify-center w-24 h-24 bg-purple-100 dark:bg-purple-900/20 rounded-full mb-6">
                    <svg class="w-12 h-12 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-3">No Enrolled Courses Yet</h3>
                <p class="text-gray-600 dark:text-gray-400 mb-8 max-w-md mx-auto">Start your learning journey by enrolling in courses that match your interests</p>
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
