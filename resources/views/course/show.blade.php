<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $course->title }} - {{ config('app.name') }}</title>
    <meta name="description" content="{{ $course->meta_description ?? $course->subtitle }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-white dark:bg-gray-900">

    <x-header />

    <!-- Dark Hero Section -->
    <section class="bg-gray-900 dark:bg-black text-white pt-24 pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Breadcrumb -->
            <nav class="flex flex-wrap items-center gap-2 text-sm mb-6 text-gray-300">
                <a href="{{ url('/') }}" class="hover:text-yellow-400 transition-colors">Home</a>
                <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                </svg>
                <a href="{{ route('courses.index') }}" class="hover:text-yellow-400 transition-colors">Courses</a>
                @if($course->category)
                    <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                    </svg>
                    <a href="{{ route('courses.index', ['category' => $course->category->slug]) }}" class="hover:text-yellow-400 transition-colors">{{ $course->category->name }}</a>
                @endif
            </nav>

            <div class="grid lg:grid-cols-3 gap-8">
                <!-- Left: Course Info -->
                <div class="lg:col-span-2">
                    <h1 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-bold mb-4 leading-tight">{{ $course->title }}</h1>

                    @if($course->subtitle)
                        <p class="text-base sm:text-lg text-gray-300 mb-6">{{ $course->subtitle }}</p>
                    @endif

                    <!-- Meta Info -->
                    <div class="flex flex-wrap items-center gap-3 sm:gap-4 mb-4">
                        @if($course->is_featured)
                            <span class="px-2.5 sm:px-3 py-1 bg-yellow-400 text-gray-900 text-xs font-bold rounded">Bestseller</span>
                        @endif

                        @if($course->average_rating > 0)
                            <div class="flex items-center gap-1.5 sm:gap-2">
                                <span class="text-yellow-400 font-bold text-sm sm:text-base">{{ number_format($course->average_rating, 1) }}</span>
                                <div class="flex items-center gap-0.5 sm:gap-1">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= floor($course->average_rating))
                                            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                                <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                            </svg>
                                        @else
                                            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-gray-600 fill-current" viewBox="0 0 20 20">
                                                <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                            </svg>
                                        @endif
                                    @endfor
                                </div>
                                <a href="#reviews" class="text-yellow-400 hover:underline text-xs sm:text-sm">({{ number_format($course->reviews_count) }} ratings)</a>
                            </div>
                        @endif

                        <span class="text-gray-300 text-xs sm:text-sm">{{ number_format($course->students_count) }} students</span>
                    </div>

                    <!-- Instructor -->
                    @if($course->instructor)
                        <div class="text-xs sm:text-sm text-gray-300 mb-3">
                            Created by <a href="#" class="text-yellow-400 hover:underline font-medium">{{ $course->instructor->name }}</a>
                        </div>
                    @endif

                    <!-- Additional Info -->
                    <div class="flex flex-wrap items-center gap-3 sm:gap-4 text-xs sm:text-sm text-gray-300">
                        <div class="flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>Last updated {{ \Carbon\Carbon::parse($course->published_at ?? $course->created_at)->format('m/Y') }}</span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                            </svg>
                            <span>{{ $course->language }}</span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"/>
                            </svg>
                            <span class="hidden sm:inline">{{ $course->language }} [Auto]</span>
                            <span class="sm:hidden">Subtitles</span>
                        </div>
                    </div>
                </div>

                <!-- Right: Video Preview (Desktop Only) -->
                <div class="hidden lg:block">
                    <!-- Video will be in sidebar -->
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column: Course Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- What you'll learn -->
                @if($course->objectives)
                    <div class="border border-gray-200 dark:border-gray-700 rounded-xl p-4 sm:p-6 bg-white dark:bg-gray-800">
                        <h2 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white mb-4">What you'll learn</h2>
                        <div class="grid sm:grid-cols-2 gap-x-6 gap-y-3">
                            @foreach(json_decode($course->objectives, true) ?? [] as $objective)
                                <div class="flex gap-2 sm:gap-3">
                                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-yellow-600 dark:text-yellow-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    <span class="text-sm text-gray-700 dark:text-gray-300">{{ $objective }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Course Stats Overview -->
                <div class="bg-yellow-50 dark:bg-yellow-900/10 border border-yellow-200 dark:border-yellow-800 rounded-xl p-4 sm:p-6">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Course Overview</h3>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                        <div class="text-center">
                            <div class="text-2xl sm:text-3xl font-bold text-yellow-600 dark:text-yellow-400">
                                {{ $modules->sum(fn($m) => $m->lessons->count()) }}
                            </div>
                            <div class="text-xs sm:text-sm text-gray-600 dark:text-gray-400 mt-1">Lessons</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl sm:text-3xl font-bold text-yellow-600 dark:text-yellow-400">
                                {{ floor($course->duration_minutes / 60) }}h
                            </div>
                            <div class="text-xs sm:text-sm text-gray-600 dark:text-gray-400 mt-1">Duration</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl sm:text-3xl font-bold text-yellow-600 dark:text-yellow-400">
                                {{ number_format($course->students_count) }}
                            </div>
                            <div class="text-xs sm:text-sm text-gray-600 dark:text-gray-400 mt-1">Students</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl sm:text-3xl font-bold text-yellow-600 dark:text-yellow-400">
                                {{ $course->average_rating > 0 ? number_format($course->average_rating, 1) : 'N/A' }}
                            </div>
                            <div class="text-xs sm:text-sm text-gray-600 dark:text-gray-400 mt-1">Rating</div>
                        </div>
                    </div>
                </div>

                <!-- Explore related topics -->
                @if($course->category || $course->tags->count() > 0)
                    <div>
                        <h2 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white mb-3">Explore related topics</h2>
                        <div class="flex flex-wrap gap-2">
                            @if($course->category)
                                <a href="{{ route('courses.index', ['category' => $course->category->slug]) }}" class="px-3 sm:px-4 py-2 border-2 border-yellow-600 dark:border-yellow-400 text-yellow-600 dark:text-yellow-400 hover:bg-yellow-600 hover:text-white dark:hover:bg-yellow-400 dark:hover:text-gray-900 rounded-lg transition-colors text-sm font-semibold">
                                    {{ $course->category->name }}
                                </a>
                            @endif
                            @foreach($course->tags ?? [] as $tag)
                                <a href="{{ route('courses.index', ['tag' => $tag->slug]) }}" class="px-3 sm:px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:border-yellow-600 hover:text-yellow-600 dark:hover:border-yellow-400 dark:hover:text-yellow-400 rounded-lg transition-colors text-sm font-semibold">
                                    {{ $tag->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Course content -->
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white">Course content</h2>
                    </div>
                    <div class="text-xs sm:text-sm text-gray-600 dark:text-gray-400 mb-4">
                        {{ $modules->count() }} sections • {{ $modules->sum(fn($m) => $m->lessons->count()) }} lectures • {{ floor($course->duration_minutes / 60) }}h {{ $course->duration_minutes % 60 }}m total length
                    </div>

                    <div class="space-y-2" x-data="{ openSection: 0 }">
                        @foreach($modules as $index => $module)
                            <div class="border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden">
                                <button
                                    @click="openSection = openSection === {{ $index }} ? null : {{ $index }}"
                                    class="w-full px-3 sm:px-4 py-3 sm:py-4 flex items-center justify-between bg-gray-50 dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors"
                                >
                                    <div class="flex items-center gap-2 sm:gap-3 flex-1 min-w-0">
                                        <svg
                                            :class="openSection === {{ $index }} ? 'rotate-180' : ''"
                                            class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-gray-600 dark:text-gray-400 transition-transform flex-shrink-0"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                        <span class="font-bold text-sm sm:text-base text-gray-900 dark:text-white text-left truncate">{{ $module->title }}</span>
                                    </div>
                                    <span class="text-xs sm:text-sm text-gray-600 dark:text-gray-400 flex-shrink-0">{{ $module->lessons->count() }} lecture{{ $module->lessons->count() !== 1 ? 's' : '' }} • {{ $module->lessons->sum('duration_minutes') }}min</span>
                                </button>
                                <div
                                    x-show="openSection === {{ $index }}"
                                    x-collapse
                                    class="border-t border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900"
                                >
                                    @foreach($module->lessons as $lesson)
                                        <div class="px-3 sm:px-4 py-2.5 sm:py-3 flex items-center justify-between hover:bg-gray-50 dark:hover:bg-gray-800/50 border-b border-gray-100 dark:border-gray-700 last:border-b-0">
                                            <div class="flex items-center gap-2 sm:gap-3 flex-1 min-w-0">
                                                @if($lesson->type === 'video')
                                                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                    </svg>
                                                @elseif($lesson->type === 'quiz')
                                                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                                    </svg>
                                                @else
                                                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                    </svg>
                                                @endif
                                                <span class="text-xs sm:text-sm text-gray-700 dark:text-gray-300 truncate">{{ $lesson->title }}</span>
                                                @if($lesson->is_free)
                                                    <button class="text-xs text-yellow-600 dark:text-yellow-400 font-semibold hover:underline flex-shrink-0">Preview</button>
                                                @endif
                                            </div>
                                            @if($lesson->duration_minutes)
                                                <span class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 flex-shrink-0">{{ $lesson->duration_minutes }}min</span>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Requirements -->
                @if($course->requirements)
                    <div>
                        <h2 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white mb-4">Requirements</h2>
                        <ul class="space-y-2">
                            @foreach(json_decode($course->requirements, true) ?? [] as $requirement)
                                <li class="flex gap-2 sm:gap-3 text-sm sm:text-base text-gray-700 dark:text-gray-300">
                                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-gray-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                        <circle cx="10" cy="10" r="2"/>
                                    </svg>
                                    <span>{{ $requirement }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Description -->
                <div>
                    <h2 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white mb-4">Description</h2>
                    <div class="prose dark:prose-invert max-w-none text-sm sm:text-base text-gray-700 dark:text-gray-300">
                        <p>{{ $course->description }}</p>
                    </div>
                </div>

                <!-- Instructor -->
                @if($course->instructor)
                    <div>
                        <h2 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white mb-4">Instructor</h2>
                        <div class="flex items-start gap-3 sm:gap-4">
                            <div class="w-20 h-20 sm:w-28 sm:h-28 rounded-full bg-yellow-600 dark:bg-yellow-500 flex items-center justify-center text-white text-2xl sm:text-3xl font-bold flex-shrink-0">
                                {{ substr($course->instructor->name, 0, 1) }}
                            </div>
                            <div>
                                <h3 class="text-lg sm:text-xl font-bold text-yellow-600 dark:text-yellow-400 hover:underline cursor-pointer mb-1">{{ $course->instructor->name }}</h3>
                                <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400 mb-2">Instructor</p>
                                <p class="text-xs sm:text-sm text-gray-700 dark:text-gray-300">{{ $course->instructor->email }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Reviews Section -->
                <div id="reviews" class="scroll-mt-20">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white">Student feedback</h2>
                    </div>

                    <!-- Rating Overview Card -->
                    <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-6 mb-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <!-- Left: Overall Rating -->
                            <div class="flex flex-col items-center justify-center">
                                <div class="text-5xl font-bold text-gray-900 dark:text-white mb-2">
                                    {{ number_format($course->average_rating, 1) }}
                                </div>
                                <x-star-rating :rating="$course->average_rating" size="lg" class="mb-2" />
                                <p class="text-sm text-gray-600 dark:text-gray-400">Course Rating</p>
                            </div>

                            <!-- Right: Rating Distribution -->
                            <div class="space-y-2">
                                @foreach([5, 4, 3, 2, 1] as $star)
                                    @php
                                        $count = $ratingDistribution[$star] ?? 0;
                                        $total = array_sum($ratingDistribution);
                                        $percentage = $total > 0 ? ($count / $total) * 100 : 0;
                                    @endphp
                                    <div class="flex items-center gap-3">
                                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300 w-20">{{ $star }} star</span>
                                        <div class="flex-1 h-2 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                                            <div class="h-full bg-yellow-400 rounded-full transition-all duration-300" style="width: {{ $percentage }}%"></div>
                                        </div>
                                        <span class="text-sm text-gray-600 dark:text-gray-400 w-12 text-right">{{ $count }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Review Submission Form -->
                    @if($canReview)
                        <div class="bg-yellow-50 dark:bg-yellow-900/10 border border-yellow-200 dark:border-yellow-800 rounded-xl p-6 mb-6">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Share your experience</h3>
                            <form action="{{ route('reviews.store') }}" method="POST" x-data="{ rating: 0 }">
                                @csrf
                                <input type="hidden" name="course_id" value="{{ $course->id }}">
                                <input type="hidden" name="rating" x-model="rating">

                                <!-- Star Rating Input -->
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Your Rating *
                                    </label>
                                    <div class="flex items-center gap-2">
                                        @for($i = 1; $i <= 5; $i++)
                                            <button
                                                type="button"
                                                @click="rating = {{ $i }}"
                                                class="focus:outline-none transition-transform hover:scale-110"
                                            >
                                                <svg
                                                    :class="rating >= {{ $i }} ? 'text-yellow-400 fill-current' : 'text-gray-300 dark:text-gray-600'"
                                                    class="w-8 h-8 transition-colors cursor-pointer"
                                                    viewBox="0 0 20 20"
                                                >
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                </svg>
                                            </button>
                                        @endfor
                                        <span x-show="rating > 0" class="ml-2 text-sm text-gray-600 dark:text-gray-400">
                                            (<span x-text="rating"></span> / 5)
                                        </span>
                                    </div>
                                    @error('rating')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Review Title -->
                                <div class="mb-4">
                                    <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Review Title (optional)
                                    </label>
                                    <input
                                        type="text"
                                        id="title"
                                        name="title"
                                        placeholder="Sum up your experience in one sentence"
                                        class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition-shadow"
                                        value="{{ old('title') }}"
                                    >
                                    @error('title')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Review Comment -->
                                <div class="mb-4">
                                    <label for="comment" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Your Review (optional)
                                    </label>
                                    <textarea
                                        id="comment"
                                        name="comment"
                                        rows="4"
                                        placeholder="Tell others what you think about this course. What did you learn? What did you like most?"
                                        class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent resize-none transition-shadow"
                                    >{{ old('comment') }}</textarea>
                                    @error('comment')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <button
                                    type="submit"
                                    class="px-6 py-2.5 bg-yellow-600 hover:bg-yellow-700 text-white font-semibold rounded-lg transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                                    :disabled="rating === 0"
                                >
                                    Submit Review
                                </button>
                            </form>
                        </div>
                    @elseif($userReview)
                        <x-alert type="info" class="mb-6">
                            You already reviewed this course on {{ $userReview->created_at->format('M d, Y') }}.
                        </x-alert>
                    @elseif(!auth()->check())
                        <x-alert type="info" class="mb-6">
                            Please <a href="{{ route('login') }}" class="text-yellow-600 dark:text-yellow-400 font-semibold hover:underline">log in</a> to leave a review.
                        </x-alert>
                    @else
                        <x-alert type="info" class="mb-6">
                            You must enroll in this course before you can leave a review.
                        </x-alert>
                    @endif

                    <!-- Reviews List -->
                    <div class="space-y-6">
                        @forelse($reviews as $review)
                            <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-6 hover:shadow-lg transition-shadow">
                                <!-- Review Header -->
                                <div class="flex items-start justify-between mb-3">
                                    <div class="flex items-start gap-3">
                                        <!-- User Avatar -->
                                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-yellow-400 to-yellow-600 flex items-center justify-center text-white font-bold flex-shrink-0 shadow-md">
                                            {{ substr($review->user->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-gray-900 dark:text-white">{{ $review->user->name }}</h4>
                                            <div class="flex items-center gap-2 mt-1">
                                                <x-star-rating :rating="$review->rating" size="sm" />
                                                <span class="text-xs text-gray-500 dark:text-gray-400">
                                                    {{ $review->created_at->diffForHumans() }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Review Title -->
                                @if($review->title)
                                    <h5 class="font-semibold text-gray-900 dark:text-white mb-2">{{ $review->title }}</h5>
                                @endif

                                <!-- Review Comment -->
                                @if($review->comment)
                                    <p class="text-gray-700 dark:text-gray-300 text-sm leading-relaxed mb-4">
                                        {{ $review->comment }}
                                    </p>
                                @endif

                                <!-- Helpful Section -->
                                <div class="flex items-center gap-4 pt-3 border-t border-gray-100 dark:border-gray-700">
                                    <p class="text-sm text-gray-600 dark:text-gray-400">
                                        Was this helpful?
                                    </p>
                                    @auth
                                        <form action="{{ route('reviews.helpful', $review) }}" method="POST" class="inline">
                                            @csrf
                                            <button
                                                type="submit"
                                                class="px-3 py-1.5 text-sm border border-gray-300 dark:border-gray-600 rounded hover:bg-gray-50 dark:hover:bg-gray-700 hover:border-yellow-400 dark:hover:border-yellow-500 transition-all"
                                            >
                                                <span class="mr-1">👍</span> Helpful ({{ $review->helpful_count }})
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-sm text-gray-600 dark:text-gray-400">
                                            <span class="mr-1">👍</span> {{ $review->helpful_count }} found this helpful
                                        </span>
                                    @endauth
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-12 bg-gray-50 dark:bg-gray-800/50 rounded-xl border border-gray-200 dark:border-gray-700">
                                <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                </svg>
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-1">No reviews yet</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    Be the first to review this course!
                                </p>
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    @if($reviews->hasPages())
                        <div class="mt-6">
                            {{ $reviews->links() }}
                        </div>
                    @endif
                </div>
            </div>

            <!-- Right Column: Sticky Sidebar -->
            <div class="lg:col-span-1">
                <div class="sticky top-20">
                    <!-- Video Preview Card -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <!-- Video/Thumbnail -->
                        <div class="relative group">
                            @if($course->preview_video)
                                <div class="aspect-video bg-gray-900">
                                    <video controls class="w-full h-full" poster="{{ $course->thumbnail }}">
                                        <source src="{{ $course->preview_video }}" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                </div>
                            @elseif($course->thumbnail)
                                <div class="aspect-video bg-gray-900 relative">
                                    <img src="{{ $course->thumbnail }}" alt="{{ $course->title }}" class="w-full h-full object-cover">
                                    <div class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-40 group-hover:bg-opacity-50 transition-all">
                                        <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center shadow-lg">
                                            <svg class="w-8 h-8 text-gray-900 ml-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"/>
                                            </svg>
                                        </div>
                                    </div>
                                    <span class="absolute top-4 right-4 px-2 py-1 bg-white text-gray-900 text-xs font-semibold rounded">Preview this course</span>
                                </div>
                            @else
                                <div class="aspect-video bg-yellow-100 dark:bg-yellow-900/20 flex items-center justify-center">
                                    <svg class="w-20 h-20 text-yellow-600 dark:text-yellow-400 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                            @endif
                        </div>

                        <!-- Price and Actions -->
                        <div class="p-6">
                            @if($course->price > 0)
                                <div class="mb-4">
                                    @if($course->discount_price)
                                        <div class="flex items-center gap-3 mb-1">
                                            <span class="text-3xl font-bold text-gray-900 dark:text-white">
                                                {{ $course->currency }}{{ number_format($course->discount_price, 2) }}
                                            </span>
                                            <span class="text-lg text-gray-500 dark:text-gray-400 line-through">
                                                {{ $course->currency }}{{ number_format($course->price, 2) }}
                                            </span>
                                        </div>
                                        <div class="text-sm text-red-600 dark:text-red-400 font-semibold">
                                            {{ round((($course->price - $course->discount_price) / $course->price) * 100) }}% off
                                        </div>
                                    @else
                                        <div class="text-3xl font-bold text-gray-900 dark:text-white mb-1">
                                            {{ $course->currency }}{{ number_format($course->price, 2) }}
                                        </div>
                                    @endif
                                </div>
                            @else
                                <div class="mb-4">
                                    <span class="text-3xl font-bold text-green-600">Free</span>
                                </div>
                            @endif

                            <div class="space-y-3 mb-4">
                                @if($isEnrolled)
                                    {{-- Already Enrolled - Go to Course --}}
                                    <a
                                        href="{{ route('student.dashboard') }}"
                                        class="block w-full px-6 py-3.5 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-bold rounded-lg text-center transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5"
                                    >
                                        <span class="flex items-center justify-center gap-2">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                            </svg>
                                            Continue Learning
                                        </span>
                                    </a>
                                @else
                                    @guest
                                        {{-- Not Authenticated - Login to Enroll --}}
                                        <a
                                            href="{{ route('login', ['redirect' => url()->current()]) }}"
                                            class="block w-full px-6 py-3.5 bg-gradient-to-r from-yellow-600 to-yellow-700 hover:from-yellow-700 hover:to-yellow-800 text-white font-bold rounded-lg text-center transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5"
                                        >
                                            <span class="flex items-center justify-center gap-2">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                                                </svg>
                                                Login to Enroll
                                            </span>
                                        </a>
                                    @else
                                        @if($course->price > 0)
                                            {{-- Paid Course - Add to Cart & Buy Now --}}
                                            <form action="{{ route('cart.add') }}" method="POST" class="w-full">
                                                @csrf
                                                <input type="hidden" name="course_id" value="{{ $course->id }}">
                                                <button
                                                    type="submit"
                                                    class="w-full px-6 py-3.5 bg-gradient-to-r from-yellow-600 to-yellow-700 hover:from-yellow-700 hover:to-yellow-800 text-white font-bold rounded-lg transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5"
                                                >
                                                    <span class="flex items-center justify-center gap-2">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                                                        </svg>
                                                        Add to Cart
                                                    </span>
                                                </button>
                                            </form>
                                            <form action="{{ route('cart.add') }}" method="POST" class="w-full">
                                                @csrf
                                                <input type="hidden" name="course_id" value="{{ $course->id }}">
                                                <input type="hidden" name="buy_now" value="1">
                                                <button
                                                    type="submit"
                                                    class="w-full px-6 py-3.5 border-2 border-gray-900 dark:border-gray-100 hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-900 dark:text-white font-bold rounded-lg transition-all transform hover:-translate-y-0.5"
                                                >
                                                    <span class="flex items-center justify-center gap-2">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                                        </svg>
                                                        Buy Now
                                                    </span>
                                                </button>
                                            </form>
                                        @else
                                            {{-- Free Course - Enroll for Free --}}
                                            <form action="{{ route('enrollments.store') }}" method="POST" class="w-full">
                                                @csrf
                                                <input type="hidden" name="course_id" value="{{ $course->id }}">
                                                <button
                                                    type="submit"
                                                    class="w-full px-6 py-3.5 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-bold rounded-lg transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5"
                                                >
                                                    <span class="flex items-center justify-center gap-2">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                                        </svg>
                                                        Enroll for Free
                                                    </span>
                                                </button>
                                            </form>
                                        @endif
                                    @endguest
                                @endif
                            </div>

                            @if($course->price > 0)
                                <p class="text-center text-xs text-gray-600 dark:text-gray-400 mb-4">30-Day Money-Back Guarantee</p>
                            @endif

                            <!-- This course includes -->
                            <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                                <h3 class="font-bold text-gray-900 dark:text-white mb-3">This course includes:</h3>
                                <ul class="space-y-2">
                                    <li class="flex items-center gap-3 text-sm text-gray-700 dark:text-gray-300">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                        </svg>
                                        <span>{{ floor($course->duration_minutes / 60) }} hours on-demand video</span>
                                    </li>
                                    @if($course->lessons_count > 0 || $modules->sum(fn($m) => $m->lessons->count()) > 0)
                                        <li class="flex items-center gap-3 text-sm text-gray-700 dark:text-gray-300">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                            <span>{{ $course->lessons_count ?? $modules->sum(fn($m) => $m->lessons->count()) }} articles</span>
                                        </li>
                                    @endif
                                    <li class="flex items-center gap-3 text-sm text-gray-700 dark:text-gray-300">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"/>
                                        </svg>
                                        <span>{{ $modules->sum(fn($m) => $m->lessons->count()) }} downloadable resources</span>
                                    </li>
                                    <li class="flex items-center gap-3 text-sm text-gray-700 dark:text-gray-300">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                        </svg>
                                        <span>Access on mobile and TV</span>
                                    </li>
                                    <li class="flex items-center gap-3 text-sm text-gray-700 dark:text-gray-300">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <span>Full lifetime access</span>
                                    </li>
                                    @if($course->has_certificate)
                                        <li class="flex items-center gap-3 text-sm text-gray-700 dark:text-gray-300">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                                            </svg>
                                            <span>Certificate of completion</span>
                                        </li>
                                    @endif
                                </ul>
                            </div>

                            <!-- Share, Gift, Apply Coupon -->
                            <div class="border-t border-gray-200 dark:border-gray-700 pt-4 mt-4">
                                <div class="flex items-center justify-between text-sm">
                                    <button class="text-yellow-600 dark:text-yellow-400 font-semibold hover:underline">Share</button>
                                    <button class="text-yellow-600 dark:text-yellow-400 font-semibold hover:underline">Gift this course</button>
                                    <button class="text-yellow-600 dark:text-yellow-400 font-semibold hover:underline">Apply Coupon</button>
                                </div>
                            </div>

                            <!-- Training 5 or more people -->
                            @if($course->price > 0)
                                <div class="border border-gray-200 dark:border-gray-700 rounded p-4 mt-4">
                                    <h4 class="font-bold text-gray-900 dark:text-white mb-2">Training 5 or more people?</h4>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">Get your team access to 30,000+ top {{ config('app.name') }} courses anytime, anywhere.</p>
                                    <button class="w-full px-4 py-2 border-2 border-yellow-600 text-yellow-600 hover:bg-yellow-50 dark:hover:bg-yellow-900/20 font-bold rounded transition-colors">
                                        Try {{ config('app.name') }} Business
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Courses -->
        @if($relatedCourses->count() > 0)
            <div class="mt-12">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Students also bought</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($relatedCourses as $relatedCourse)
                        <x-course-card :course="$relatedCourse" />
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</body>
</html>
