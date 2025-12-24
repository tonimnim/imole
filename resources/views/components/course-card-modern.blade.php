@props(['course'])

<div class="group bg-white dark:bg-gray-800 rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden border border-gray-200 dark:border-gray-700 hover:border-green-700 dark:hover:border-green-600 flex flex-col h-full">
    <a href="{{ route('courses.show', $course) }}" class="flex flex-col h-full">
        <!-- Course Thumbnail -->
        <div class="relative overflow-hidden aspect-video bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-900">
            @if($course->thumbnail)
                <img
                    src="{{ Storage::url($course->thumbnail) }}"
                    alt="{{ $course->title }}"
                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                    loading="lazy"
                />
            @else
                <div class="w-full h-full flex items-center justify-center">
                    <div class="w-16 h-16 bg-green-700 rounded-xl flex items-center justify-center">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/>
                        </svg>
                    </div>
                </div>
            @endif

            <!-- Badges -->
            <div class="absolute top-3 left-3 flex flex-col gap-2">
                @if($course->is_featured)
                    <span class="inline-block px-3 py-1 bg-amber-500 text-white text-xs font-bold rounded-lg shadow-lg">
                        FEATURED
                    </span>
                @endif
            </div>

            @if($course->level)
                <div class="absolute top-3 right-3">
                    <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-bold shadow-lg
                        {{ $course->level === 'beginner' ? 'bg-green-600 text-white' : '' }}
                        {{ $course->level === 'intermediate' ? 'bg-amber-500 text-white' : '' }}
                        {{ $course->level === 'advanced' ? 'bg-green-800 text-white' : '' }}">
                        {{ strtoupper($course->level) }}
                    </span>
                </div>
            @endif

        </div>

        <!-- Course Content -->
        <div class="p-4 sm:p-5 flex flex-col flex-1">
            <!-- Category -->
            @if($course->category)
                <div class="mb-2">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-semibold bg-green-50 text-green-800 dark:bg-green-900/30 dark:text-green-400 border border-green-200 dark:border-green-800">
                        {{ $course->category->name }}
                    </span>
                </div>
            @endif

            <!-- Title -->
            <h3 class="text-base sm:text-lg font-bold text-gray-900 dark:text-white mb-3 group-hover:text-green-700 dark:group-hover:text-green-500 transition-colors leading-snug">
                {{ $course->title }}
            </h3>

            <!-- Instructor -->
            @if($course->instructor)
                <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400 mb-4">
                    By <span class="font-medium">{{ $course->instructor->name }}</span>
                </p>
            @elseif($course->subtitle)
                <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400 mb-4">
                    {{ $course->subtitle }}
                </p>
            @endif

            <!-- Stats Row -->
            <div class="flex items-center gap-3 sm:gap-4 mb-3 sm:mb-4">
                <!-- Rating -->
                @if($course->average_rating > 0)
                    <div class="flex items-center gap-1">
                        <span class="text-xs sm:text-sm font-bold text-gray-900 dark:text-white">{{ number_format($course->average_rating, 1) }}</span>
                        <div class="flex items-center">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= round($course->average_rating))
                                    <svg class="w-4 h-4 text-amber-500 fill-current" viewBox="0 0 20 20">
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
                            <span class="text-xs text-gray-500 dark:text-gray-400">({{ number_format($course->reviews_count) }})</span>
                        @endif
                    </div>
                @endif

                <!-- Students -->
                @if($course->students_count > 0)
                    <div class="flex items-center gap-1 text-xs text-gray-600 dark:text-gray-400">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                        </svg>
                        <span class="font-medium">{{ number_format($course->students_count) }}</span>
                    </div>
                @endif
            </div>

            <!-- Additional Info -->
            <div class="flex items-center flex-wrap gap-2 sm:gap-3 text-xs text-gray-500 dark:text-gray-400 mb-3 sm:mb-4 pb-3 sm:pb-4 border-b border-gray-200 dark:border-gray-700">
                @if($course->lessons_count)
                    <div class="flex items-center gap-1">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z"/>
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

            <!-- Price and CTA -->
            <div class="flex items-center justify-between mt-auto">
                <div class="flex-1">
                    @if($course->price > 0)
                        @if($course->discount_price && $course->discount_price < $course->price)
                            <div class="flex flex-col gap-1">
                                <div class="flex items-baseline gap-2 flex-wrap">
                                    <span class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white whitespace-nowrap">
                                        KSh {{ number_format($course->discount_price) }}
                                    </span>
                                    <span class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 line-through whitespace-nowrap">
                                        KSh {{ number_format($course->price) }}
                                    </span>
                                </div>
                                <span class="inline-flex items-center w-fit px-2 py-0.5 bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded text-xs font-bold text-amber-900 dark:text-amber-400">
                                    {{ round((($course->price - $course->discount_price) / $course->price) * 100) }}% OFF
                                </span>
                            </div>
                        @else
                            <span class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white whitespace-nowrap">
                                KSh {{ number_format($course->price) }}
                            </span>
                        @endif
                    @else
                        <span class="text-xl sm:text-2xl font-bold text-green-700 dark:text-green-400">Free</span>
                    @endif
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
