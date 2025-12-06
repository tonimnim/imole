@props(['course'])

<div class="group bg-white dark:bg-gray-800 rounded-xl shadow-md hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 dark:border-gray-700">
    <!-- Course Thumbnail -->
    <div class="relative overflow-hidden aspect-video bg-gray-200 dark:bg-gray-700">
        @if($course->thumbnail)
            <img
                src="{{ Storage::url($course->thumbnail) }}"
                alt="{{ $course->title }}"
                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300"
            />
        @else
            <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-green-400 to-emerald-600">
                <svg class="w-16 h-16 text-white opacity-50" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/>
                </svg>
            </div>
        @endif

        <!-- Featured Badge -->
        @if($course->is_featured)
            <div class="absolute top-3 left-3 bg-yellow-400 text-gray-900 text-xs font-bold px-3 py-1 rounded-full">
                Featured
            </div>
        @endif

        <!-- Level Badge -->
        @if($course->level)
            <div class="absolute top-3 right-3 bg-white/90 dark:bg-gray-900/90 text-gray-900 dark:text-white text-xs font-semibold px-3 py-1 rounded-full capitalize">
                {{ $course->level }}
            </div>
        @endif
    </div>

    <!-- Course Content -->
    <div class="p-5 space-y-3">
        <!-- Category -->
        @if($course->category)
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center text-xs font-medium text-green-700 dark:text-green-400 bg-green-50 dark:bg-green-900/30 px-2.5 py-0.5 rounded-full">
                    {{ $course->category->name }}
                </span>
            </div>
        @endif

        <!-- Title -->
        <h3 class="text-lg font-bold text-gray-900 dark:text-white line-clamp-2 group-hover:text-yellow-600 dark:group-hover:text-yellow-400 transition-colors">
            {{ $course->title }}
        </h3>

        <!-- Instructor -->
        @if($course->instructor)
            <p class="text-sm text-gray-600 dark:text-gray-400">
                By {{ $course->instructor->name }}
            </p>
        @endif

        <!-- Rating & Students -->
        <div class="flex items-center gap-4 text-sm">
            @if($course->average_rating > 0)
                <div class="flex items-center gap-1">
                    <span class="font-bold text-yellow-500">{{ number_format($course->average_rating, 1) }}</span>
                    <div class="flex items-center">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= floor($course->average_rating))
                                <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @else
                                <svg class="w-4 h-4 text-gray-300 dark:text-gray-600 fill-current" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @endif
                        @endfor
                    </div>
                    @if($course->reviews_count > 0)
                        <span class="text-gray-500 dark:text-gray-400">({{ number_format($course->reviews_count) }})</span>
                    @endif
                </div>
            @endif

            @if($course->students_count > 0)
                <div class="flex items-center gap-1 text-gray-600 dark:text-gray-400">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                    </svg>
                    <span>{{ number_format($course->students_count) }}</span>
                </div>
            @endif
        </div>

        <!-- Course Stats -->
        <div class="flex items-center gap-4 text-xs text-gray-500 dark:text-gray-400 pt-2 border-t border-gray-100 dark:border-gray-700">
            @if($course->lessons_count)
                <div class="flex items-center gap-1">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"/>
                    </svg>
                    <span>{{ $course->lessons_count }} lessons</span>
                </div>
            @endif

            @if($course->duration_minutes)
                <div class="flex items-center gap-1">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                    </svg>
                    <span>{{ floor($course->duration_minutes / 60) }}h {{ $course->duration_minutes % 60 }}m</span>
                </div>
            @endif
        </div>

        <!-- Description Preview -->
        @if($course->subtitle)
            <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-2 mb-3">
                {{ $course->subtitle }}
            </p>
        @endif

        <!-- Course Level -->
        @if($course->level)
            <div class="mb-3">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                    {{ $course->level === 'beginner' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : '' }}
                    {{ $course->level === 'intermediate' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400' : '' }}
                    {{ $course->level === 'advanced' ? 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400' : '' }}">
                    {{ ucfirst($course->level) }}
                </span>
            </div>
        @endif

        <!-- Price -->
        <div class="flex items-center justify-between pt-3 border-t border-gray-100 dark:border-gray-700">
            @if($course->price > 0)
                <div class="flex items-baseline gap-2">
                    @if($course->discount_price && $course->discount_price < $course->price)
                        <span class="text-2xl font-bold text-gray-900 dark:text-white">
                            {{ $course->currency ?? 'KES' }} {{ number_format($course->discount_price) }}
                        </span>
                        <span class="text-sm text-gray-500 dark:text-gray-400 line-through">
                            {{ number_format($course->price) }}
                        </span>
                        <span class="text-xs font-semibold text-red-600 dark:text-red-400">
                            {{ round((($course->price - $course->discount_price) / $course->price) * 100) }}% OFF
                        </span>
                    @else
                        <span class="text-2xl font-bold text-gray-900 dark:text-white">
                            {{ $course->currency ?? 'KES' }} {{ number_format($course->price) }}
                        </span>
                    @endif
                </div>
            @else
                <span class="text-2xl font-bold text-green-600 dark:text-green-400">Free</span>
            @endif

            <!-- Enroll Button -->
            <button class="px-4 py-2 bg-yellow-600 hover:bg-yellow-700 text-white text-sm font-semibold rounded-lg transition-colors">
                View Course
            </button>
        </div>
    </div>

    <!-- Hover Overlay -->
    <a href="{{ route('courses.show', $course) }}" class="absolute inset-0 z-10">
        <span class="sr-only">View {{ $course->title }}</span>
    </a>
</div>
