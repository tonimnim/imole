@props(['course', 'showBadge' => false])

<div class="group relative">
    <a href="{{ route('courses.show', $course) }}" class="block">
        <!-- Course Image -->
        <div class="relative overflow-hidden rounded-lg aspect-[4/3] bg-gray-200 dark:bg-gray-700 mb-3">
            @if($course->thumbnail)
                <img
                    src="{{ Storage::url($course->thumbnail) }}"
                    alt="{{ $course->title }}"
                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                />
            @else
                <div class="w-full h-full flex items-center justify-center bg-yellow-100 dark:bg-yellow-900/20">
                    <svg class="w-16 h-16 text-yellow-600 dark:text-yellow-400 opacity-50" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/>
                    </svg>
                </div>
            @endif

            <!-- BEST SELLER Badge -->
            @if($showBadge && $course->is_featured)
                <div class="absolute top-3 left-3 bg-yellow-400 text-gray-900 text-xs font-bold px-2.5 py-1 rounded">
                    BEST SELLER
                </div>
            @endif

            <!-- Specialty Badge (e.g., DEEP DIVE, LEARN AI) -->
            @if($course->level === 'advanced')
                <div class="absolute top-3 right-3 bg-gray-900 text-white text-xs font-bold px-2 py-1 rounded flex items-center gap-1">
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                        <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>
                    </svg>
                    <span>DEEP DIVE</span>
                </div>
            @endif
        </div>

        <!-- Course Details -->
        <div>
            <!-- Specialty Type Badge (if applicable) -->
            @if($course->category)
                <div class="mb-2">
                    <span class="inline-block px-2 py-0.5 text-xs font-semibold text-gray-600 dark:text-gray-400 bg-gray-100 dark:bg-gray-800 rounded uppercase tracking-wide">
                        {{ $course->category->name }}
                    </span>
                    @if($course->duration_minutes >= 600)
                        <span class="inline-block px-2 py-0.5 text-xs font-semibold text-gray-600 dark:text-gray-400 border border-gray-300 dark:border-gray-600 rounded ml-2">
                            {{ floor($course->duration_minutes / 60) }}H
                        </span>
                    @endif
                </div>
            @endif

            <!-- Course Title -->
            <h3 class="text-base font-semibold text-gray-900 dark:text-white mb-2 line-clamp-2 group-hover:text-yellow-600 dark:group-hover:text-yellow-400 transition-colors">
                {{ $course->title }}
            </h3>

            <!-- Course Subtitle/Instructor -->
            <p class="text-sm text-gray-600 dark:text-gray-400 mb-3 line-clamp-1">
                @if($course->instructor)
                    A course by {{ $course->instructor->name }}
                @else
                    {{ $course->subtitle }}
                @endif
            </p>

            <!-- Stats Row -->
            <div class="flex items-center gap-4 text-xs text-gray-500 dark:text-gray-400 mb-3">
                <!-- Rating -->
                @if($course->average_rating > 0)
                    <div class="flex items-center gap-1">
                        <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        <span class="font-medium text-gray-900 dark:text-white">{{ number_format($course->average_rating, 1) }}</span>
                        @if($course->reviews_count > 0)
                            <span>({{ number_format($course->reviews_count) }})</span>
                        @endif
                    </div>
                @endif

                <!-- Students -->
                @if($course->students_count > 0)
                    <div class="flex items-center gap-1">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                        </svg>
                        <span>{{ number_format($course->students_count) }}</span>
                    </div>
                @endif
            </div>

            <!-- Pricing -->
            <div class="flex items-baseline gap-2 mb-3">
                @if($course->price > 0)
                    @if($course->discount_price && $course->discount_price < $course->price)
                        <span class="text-xl font-bold text-gray-900 dark:text-white">
                            {{ $course->currency ?? 'KES' }} {{ number_format($course->discount_price) }}
                        </span>
                        <span class="text-sm text-gray-500 dark:text-gray-400 line-through">
                            {{ $course->currency ?? 'KES' }} {{ number_format($course->price) }}
                        </span>
                        <span class="text-xs font-semibold text-red-600 dark:text-red-400">
                            {{ round((($course->price - $course->discount_price) / $course->price) * 100) }}% OFF
                        </span>
                    @else
                        <span class="text-xl font-bold text-gray-900 dark:text-white">
                            {{ $course->currency ?? 'KES' }} {{ number_format($course->price) }}
                        </span>
                    @endif
                @else
                    <span class="text-xl font-bold text-green-600 dark:text-green-400">Free</span>
                @endif
            </div>

            <!-- Course Level Badge -->
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
        </div>
    </a>
</div>
