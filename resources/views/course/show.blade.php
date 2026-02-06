<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <x-seo
        :title="$course->meta_title ?? $course->title"
        :description="$course->meta_description ?? $course->subtitle ?? $course->description"
        :image="$course->thumbnail ? asset('storage/' . $course->thumbnail) : null"
        type="website"
        :keywords="($course->category ? $course->category->name . ', ' : '') . $course->title . ', online course, Africa education, ' . ($course->level ?? 'beginner') . ' course'"
        :author="$course->instructor?->name"
        :publishedTime="$course->created_at?->toIso8601String()"
        :modifiedTime="$course->updated_at?->toIso8601String()"
        :course="$course"
        :breadcrumbs="array_filter([
            ['name' => 'Home', 'url' => url('/')],
            ['name' => 'Courses', 'url' => route('courses.index')],
            $course->category ? ['name' => $course->category->name, 'url' => route('courses.index', ['category' => $course->category->slug])] : null,
            ['name' => $course->title, 'url' => url()->current()],
        ])"
    />
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-50 dark:bg-gray-900" x-data="{
    expandedModule: null,
    activeTab: 'overview',
    showMobileMenu: false,
    scrolled: false
}" @scroll.window="scrolled = window.scrollY > 100">

    <x-header />

    <!-- Course Hero Section -->
    <section class="bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 dark:from-black dark:via-gray-900 dark:to-black text-white pt-24 pb-16 lg:pb-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Breadcrumb -->
            <nav class="flex items-center gap-2 text-sm mb-6 text-gray-400">
                <a href="/" class="hover:text-green-400 transition-colors">Home</a>
                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                </svg>
                <a href="{{ route('courses.index') }}" class="hover:text-green-400 transition-colors">Courses</a>
                @if($course->category)
                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                </svg>
                <a href="{{ route('courses.index', ['category' => $course->category->slug]) }}" class="hover:text-green-400 transition-colors">{{ $course->category->name }}</a>
                @endif
            </nav>

            <div class="grid lg:grid-cols-3 gap-8 lg:gap-12">
                <!-- Left: Course Info -->
                <div class="lg:col-span-2">
                    @if($course->category)
                    <div class="mb-3">
                        <span class="inline-flex items-center px-3 py-1 bg-green-600/20 border border-green-500 text-green-400 text-xs font-bold rounded-full">
                            {{ $course->category->name }}
                        </span>
                    </div>
                    @endif

                    <h1 class="text-2xl sm:text-3xl lg:text-4xl xl:text-5xl font-bold mb-4 leading-tight">{{ $course->title }}</h1>

                    @if($course->subtitle)
                    <p class="text-lg sm:text-xl text-gray-300 mb-6 leading-relaxed">{{ $course->subtitle }}</p>
                    @endif

                    <!-- Stats Row -->
                    <div class="flex flex-wrap items-center gap-4 sm:gap-6 text-sm mb-8">
                        @if($course->is_featured)
                        <span class="inline-flex items-center px-3 py-1.5 bg-yellow-500 text-gray-900 text-xs font-bold rounded shadow-lg">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            Bestseller
                        </span>
                        @endif

                        @if($course->average_rating > 0)
                        <div class="flex items-center gap-2 bg-white/10 px-3 py-1.5 rounded-lg">
                            <span class="text-yellow-400 font-bold text-base">{{ number_format($course->average_rating, 1) }}</span>
                            <div class="flex">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-4 h-4 {{ $i <= floor($course->average_rating) ? 'text-yellow-400' : 'text-gray-600' }} fill-current" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @endfor
                            </div>
                            @if($course->reviews_count > 0)
                            <span class="text-green-400 hover:underline cursor-pointer">({{ number_format($course->reviews_count) }})</span>
                            @endif
                        </div>
                        @endif

                        @if($course->students_count > 0)
                        <div class="flex items-center gap-2 text-gray-300">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                            </svg>
                            <span class="font-semibold">{{ number_format($course->students_count) }}</span>
                            <span class="hidden sm:inline">students enrolled</span>
                        </div>
                        @endif
                    </div>

                    <!-- Instructor & Meta -->
                    <div class="flex flex-wrap items-center gap-4 sm:gap-6 text-sm text-gray-300">
                        @if($course->instructor)
                        <div class="flex items-center gap-2">
                            <span class="text-gray-400">Created by</span>
                            <a href="#instructor" class="text-green-400 hover:text-green-300 font-semibold flex items-center gap-2">
                                <div class="w-6 h-6 bg-green-600 rounded-full flex items-center justify-center text-xs font-bold text-white">
                                    {{ substr($course->instructor->name, 0, 1) }}
                                </div>
                                {{ $course->instructor->name }}
                            </a>
                        </div>
                        @endif

                        @if($course->updated_at)
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                            </svg>
                            <span>Updated {{ $course->updated_at->format('M Y') }}</span>
                        </div>
                        @endif

                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7 2a1 1 0 011 1v1h3a1 1 0 110 2H9.578a18.87 18.87 0 01-1.724 4.78c.29.354.596.696.914 1.026a1 1 0 11-1.44 1.389c-.188-.196-.373-.396-.554-.6a19.098 19.098 0 01-3.107 3.567 1 1 0 01-1.334-1.49 17.087 17.087 0 003.13-3.733 18.992 18.992 0 01-1.487-2.494 1 1 0 111.79-.89c.234.47.489.928.764 1.372.417-.934.752-1.913.997-2.927H3a1 1 0 110-2h3V3a1 1 0 011-1zm6 6a1 1 0 01.894.553l2.991 5.982a.869.869 0 01.02.037l.99 1.98a1 1 0 11-1.79.895L15.383 16h-4.764l-.724 1.447a1 1 0 11-1.788-.894l.99-1.98.019-.038 2.99-5.982A1 1 0 0113 8zm-1.382 6h2.764L13 11.236 11.618 14z" clip-rule="evenodd"/>
                            </svg>
                            <span>{{ $course->language ?? 'English' }}</span>
                        </div>
                    </div>

                    <!-- Key Highlights - Mobile -->
                    <div class="lg:hidden mt-8 bg-white/10 backdrop-blur-sm rounded-xl p-5 grid grid-cols-3 gap-4 border border-white/20 shadow-xl">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-white">{{ floor($course->duration_minutes / 60) }}h</div>
                            <div class="text-xs text-gray-400 mt-1">Video</div>
                        </div>
                        <div class="text-center border-x border-white/20">
                            <div class="text-2xl font-bold text-white">{{ $course->lessons_count ?? 0 }}</div>
                            <div class="text-xs text-gray-400 mt-1">Lessons</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-white capitalize">{{ $course->level }}</div>
                            <div class="text-xs text-gray-400 mt-1">Level</div>
                        </div>
                    </div>
                </div>

                <!-- Right: Preview Card (Desktop) -->
                <div class="hidden lg:block lg:col-span-1">
                    <div class="sticky top-24">
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl overflow-hidden border border-gray-200 dark:border-gray-700">
                            <!-- Preview -->
                            <div class="relative aspect-video bg-gradient-to-br from-green-400 to-emerald-600 group cursor-pointer">
                                @if($course->thumbnail)
                                <img src="{{ Storage::url($course->thumbnail) }}" alt="{{ $course->title }}" class="w-full h-full object-cover">
                                @else
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <svg class="w-20 h-20 text-white opacity-50" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3z"/>
                                    </svg>
                                </div>
                                @endif
                                <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-300">
                                    <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center shadow-2xl transform group-hover:scale-110 transition-transform">
                                        <svg class="w-10 h-10 text-gray-900 ml-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"/>
                                        </svg>
                                    </div>
                                </div>
                                <div class="absolute top-4 left-4 text-white text-sm font-semibold drop-shadow-lg">
                                    Preview this course
                                </div>
                            </div>

                            <div class="p-6">
                                <!-- Price -->
                                <div class="mb-6">
                                    @if($course->price > 0)
                                        @if($course->discount_price && $course->discount_price < $course->price)
                                        <div class="flex items-baseline gap-3 flex-wrap mb-2">
                                            <span class="text-4xl font-bold text-gray-900 dark:text-white">
                                                {{ $course->currency ?? 'KES' }} {{ number_format($course->discount_price) }}
                                            </span>
                                            <span class="text-xl text-gray-500 dark:text-gray-400 line-through">
                                                {{ $course->currency ?? 'KES' }} {{ number_format($course->price) }}
                                            </span>
                                        </div>
                                        <div class="inline-flex items-center px-3 py-1 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 text-sm font-bold rounded">
                                            {{ round((($course->price - $course->discount_price) / $course->price) * 100) }}% OFF - Limited time!
                                        </div>
                                        @else
                                        <div class="text-4xl font-bold text-gray-900 dark:text-white mb-2">
                                            {{ $course->currency ?? 'KES' }} {{ number_format($course->price) }}
                                        </div>
                                        @endif
                                    @else
                                    <div class="text-4xl font-bold text-green-600 dark:text-green-400 mb-2">Free Course</div>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Start learning now at no cost</p>
                                    @endif
                                </div>

                                <!-- CTA Buttons -->
                                <div class="space-y-3 mb-6">
                                    @if($isEnrolled)
                                        {{-- Already Enrolled - Continue Learning --}}
                                        <a
                                            href="{{ route('student.dashboard') }}"
                                            class="block w-full px-6 py-4 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white text-lg font-bold rounded-lg transition-all transform hover:scale-105 shadow-lg hover:shadow-xl text-center"
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
                                                class="block w-full px-6 py-4 bg-yellow-600 hover:bg-yellow-700 text-white text-lg font-bold rounded-lg transition-all transform hover:scale-105 shadow-lg hover:shadow-xl text-center"
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
                                                        class="w-full px-6 py-4 bg-yellow-600 hover:bg-yellow-700 text-white text-lg font-bold rounded-lg transition-all transform hover:scale-105 shadow-lg hover:shadow-xl"
                                                    >
                                                        <span class="flex items-center justify-center gap-2">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                                                            </svg>
                                                            Add to cart
                                                        </span>
                                                    </button>
                                                </form>
                                                <form action="{{ route('cart.add') }}" method="POST" class="w-full">
                                                    @csrf
                                                    <input type="hidden" name="course_id" value="{{ $course->id }}">
                                                    <input type="hidden" name="buy_now" value="1">
                                                    <button
                                                        type="submit"
                                                        class="w-full px-6 py-4 bg-white dark:bg-gray-900 hover:bg-gray-50 dark:hover:bg-gray-800 text-gray-900 dark:text-white text-lg font-semibold border-2 border-gray-900 dark:border-gray-300 rounded-lg transition-all"
                                                    >
                                                        <span class="flex items-center justify-center gap-2">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                                            </svg>
                                                            Buy now
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
                                                        class="w-full px-6 py-4 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white text-lg font-bold rounded-lg transition-all transform hover:scale-105 shadow-lg hover:shadow-xl"
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

                                <p class="text-center text-xs text-gray-600 dark:text-gray-400 mb-6 py-2 border-y border-gray-200 dark:border-gray-700">
                                    30-Day Money-Back Guarantee
                                </p>

                                <!-- This course includes -->
                                <div>
                                    <h4 class="font-bold text-gray-900 dark:text-white mb-4 text-lg">This course includes:</h4>
                                    <ul class="space-y-3 text-sm">
                                        @if($course->duration_minutes)
                                        <li class="flex items-center gap-3 text-gray-700 dark:text-gray-300">
                                            <svg class="w-5 h-5 flex-shrink-0 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"/>
                                            </svg>
                                            <span><strong>{{ floor($course->duration_minutes / 60) }} hours</strong> on-demand video</span>
                                        </li>
                                        @endif
                                        @if($course->lessons_count)
                                        <li class="flex items-center gap-3 text-gray-700 dark:text-gray-300">
                                            <svg class="w-5 h-5 flex-shrink-0 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"/>
                                            </svg>
                                            <span><strong>{{ $course->lessons_count }}</strong> downloadable resources</span>
                                        </li>
                                        @endif
                                        <li class="flex items-center gap-3 text-gray-700 dark:text-gray-300">
                                            <svg class="w-5 h-5 flex-shrink-0 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z"/>
                                            </svg>
                                            <span>Access on mobile and TV</span>
                                        </li>
                                        <li class="flex items-center gap-3 text-gray-700 dark:text-gray-300">
                                            <svg class="w-5 h-5 flex-shrink-0 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M5 2a1 1 0 011 1v1h1a1 1 0 010 2H6v1a1 1 0 01-2 0V6H3a1 1 0 010-2h1V3a1 1 0 011-1zm0 10a1 1 0 011 1v1h1a1 1 0 110 2H6v1a1 1 0 11-2 0v-1H3a1 1 0 110-2h1v-1a1 1 0 011-1zM12 2a1 1 0 01.967.744L14.146 7.2 17.5 9.134a1 1 0 010 1.732l-3.354 1.935-1.18 4.455a1 1 0 01-1.933 0L9.854 12.8 6.5 10.866a1 1 0 010-1.732l3.354-1.935 1.18-4.455A1 1 0 0112 2z" clip-rule="evenodd"/>
                                            </svg>
                                            <span>Full lifetime access</span>
                                        </li>
                                        @if($course->has_certificate)
                                        <li class="flex items-center gap-3 text-gray-700 dark:text-gray-300">
                                            <svg class="w-5 h-5 flex-shrink-0 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                            </svg>
                                            <span>Certificate of completion</span>
                                        </li>
                                        @endif
                                    </ul>
                                </div>

                                <!-- Additional Actions -->
                                <div class="pt-6 mt-6 border-t border-gray-200 dark:border-gray-700 flex flex-col gap-3">
                                    <button class="text-sm font-semibold text-gray-900 dark:text-white hover:text-yellow-600 dark:hover:text-yellow-400 transition-colors text-center py-2">
                                        Share
                                    </button>
                                    <button class="text-sm font-semibold text-gray-900 dark:text-white hover:text-yellow-600 dark:hover:text-yellow-400 transition-colors text-center py-2">
                                        Gift this course
                                    </button>
                                    <button class="text-sm font-semibold text-gray-900 dark:text-white hover:text-yellow-600 dark:hover:text-yellow-400 transition-colors text-center py-2">
                                        Apply Coupon
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Training callout -->
                        <div class="mt-6 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-6">
                            <h4 class="font-bold text-gray-900 dark:text-white mb-2">Training 5 or more people?</h4>
                            <p class="text-sm text-gray-700 dark:text-gray-300 mb-4">Get your team access to 30,000+ top Imole courses anytime, anywhere.</p>
                            <button class="w-full px-6 py-3 border-2 border-gray-900 dark:border-gray-300 text-gray-900 dark:text-white font-semibold rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                Try Imole Business
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-12 lg:py-16 bg-gray-50 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-3 gap-8 lg:gap-12">
                <!-- Left Column - Main Content -->
                <div class="lg:col-span-2 pb-24 lg:pb-0">

                    <!-- Tabs Navigation -->
                    <div class="sticky top-16 lg:top-20 bg-gray-50 dark:bg-gray-900 z-20 -mx-4 px-4 sm:-mx-6 sm:px-6 lg:mx-0 lg:px-0 border-b-2 border-gray-200 dark:border-gray-700 shadow-sm mb-8">
                        <nav class="flex gap-8 overflow-x-auto scrollbar-hide">
                            <button
                                @click="activeTab = 'overview'"
                                :class="activeTab === 'overview' ? 'border-green-600 text-green-600' : 'border-transparent text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:border-gray-300'"
                                class="py-4 px-2 border-b-3 font-semibold text-base whitespace-nowrap transition-all"
                            >
                                Overview
                            </button>
                            <button
                                @click="activeTab = 'curriculum'"
                                :class="activeTab === 'curriculum' ? 'border-green-600 text-green-600' : 'border-transparent text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:border-gray-300'"
                                class="py-4 px-1 border-b-2 font-semibold text-sm whitespace-nowrap transition-colors"
                            >
                                Curriculum
                            </button>
                            <button
                                @click="activeTab = 'instructor'"
                                :class="activeTab === 'instructor' ? 'border-green-600 text-green-600' : 'border-transparent text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:border-gray-300'"
                                class="py-4 px-1 border-b-2 font-semibold text-sm whitespace-nowrap transition-colors"
                            >
                                Instructor
                            </button>
                            <button
                                @click="activeTab = 'reviews'"
                                :class="activeTab === 'reviews' ? 'border-green-600 text-green-600' : 'border-transparent text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:border-gray-300'"
                                class="py-4 px-1 border-b-2 font-semibold text-sm whitespace-nowrap transition-colors"
                            >
                                Reviews
                            </button>
                        </nav>
                    </div>

                    <!-- Tab Content -->
                    <div class="space-y-8">
                        <!-- Overview Tab -->
                        <div x-show="activeTab === 'overview'" class="space-y-8">
                            <!-- What You'll Learn -->
                            @if($course->objectives)
                            <div class="bg-white dark:bg-gray-800 border-2 border-green-100 dark:border-green-900/30 rounded-2xl p-6 sm:p-8 shadow-lg">
                                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">What you'll learn</h2>
                                <div class="grid sm:grid-cols-2 gap-4">
                                    @foreach(json_decode($course->objectives) as $objective)
                                    <div class="flex items-start gap-3">
                                        <svg class="w-5 h-5 text-green-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                        <span class="text-sm text-gray-700 dark:text-gray-300">{{ $objective }}</span>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif

                            <!-- Requirements -->
                            @if($course->requirements)
                            <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl p-6 sm:p-8 shadow-md">
                                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Requirements</h2>
                                <ul class="space-y-3">
                                    @foreach(json_decode($course->requirements) as $requirement)
                                    <li class="flex items-start gap-3 text-gray-700 dark:text-gray-300">
                                        <span class="text-gray-900 dark:text-white mt-1 text-xl">•</span>
                                        <span>{{ $requirement }}</span>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif

                            <!-- Description -->
                            <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl p-6 sm:p-8 shadow-md">
                                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Description</h2>
                                <div class="prose dark:prose-invert max-w-none">
                                    <p class="text-gray-700 dark:text-gray-300 leading-relaxed">{{ $course->description }}</p>
                                </div>
                            </div>

                            <!-- Explore Related Topics -->
                            @if($course->category)
                            <div class="bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/10 dark:to-emerald-900/10 border border-green-200 dark:border-green-800 rounded-2xl p-6 sm:p-8">
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Explore related topics</h3>
                                <div class="flex flex-wrap gap-3">
                                    <a href="{{ route('courses.index', ['category' => $course->category->slug]) }}" class="px-4 py-2 border-2 border-gray-900 dark:border-gray-300 text-gray-900 dark:text-white text-sm font-semibold rounded-lg hover:bg-gray-900 hover:text-white dark:hover:bg-gray-300 dark:hover:text-gray-900 transition-all">
                                        {{ $course->category->name }}
                                    </a>
                                </div>
                            </div>
                            @endif
                        </div>

                        <!-- Curriculum Tab -->
                        <div x-show="activeTab === 'curriculum'" class="space-y-6">
                            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Course content</h2>
                            @if($modules->count() > 0)
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-6">
                                <span class="font-semibold">{{ $modules->count() }}</span> sections •
                                <span class="font-semibold">{{ $modules->sum(fn($m) => $m->lessons->count()) }}</span> lectures •
                                <span class="font-semibold">{{ floor($course->duration_minutes / 60) }}h {{ $course->duration_minutes % 60 }}m</span> total length
                            </p>

                            <!-- Modules Accordion -->
                            <div class="bg-white dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700 rounded-2xl overflow-hidden shadow-lg">
                                @foreach($modules as $module)
                                <div class="border-b border-gray-200 dark:border-gray-700 last:border-b-0">
                                    <button
                                        @click="expandedModule = expandedModule === {{ $module->id }} ? null : {{ $module->id }}"
                                        class="w-full px-4 sm:px-6 py-5 flex items-center justify-between bg-gray-50 dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700 transition-all duration-200"
                                    >
                                        <div class="flex items-center gap-3 flex-1 min-w-0">
                                            <svg
                                                class="w-4 h-4 text-gray-900 dark:text-white transition-transform flex-shrink-0"
                                                :class="expandedModule === {{ $module->id }} ? 'rotate-90' : ''"
                                                fill="currentColor"
                                                viewBox="0 0 20 20"
                                            >
                                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                                            </svg>
                                            <span class="font-semibold text-gray-900 dark:text-white text-left truncate">{{ $module->title }}</span>
                                        </div>
                                        <div class="text-xs sm:text-sm text-gray-600 dark:text-gray-400 ml-4 flex-shrink-0">
                                            {{ $module->lessons->count() }} {{ $module->lessons->count() === 1 ? 'lecture' : 'lectures' }}
                                        </div>
                                    </button>

                                    <!-- Lessons -->
                                    <div
                                        x-show="expandedModule === {{ $module->id }}"
                                        x-collapse
                                        class="bg-white dark:bg-gray-900"
                                    >
                                        @foreach($module->lessons as $lesson)
                                        <div class="px-4 sm:px-6 py-4 flex items-center justify-between hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors border-t border-gray-100 dark:border-gray-700">
                                            <div class="flex items-center gap-3 flex-1 min-w-0">
                                                <svg class="w-5 h-5 text-gray-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"/>
                                                </svg>
                                                <span class="text-sm text-gray-700 dark:text-gray-300 truncate">{{ $lesson->title }}</span>
                                                @if($lesson->is_free)
                                                <button class="text-xs text-green-600 dark:text-green-400 font-semibold hover:underline flex-shrink-0">Preview</button>
                                                @endif
                                            </div>
                                            @if($lesson->duration_minutes)
                                            <span class="text-sm text-gray-500 dark:text-gray-400 ml-4 flex-shrink-0">{{ $lesson->duration_minutes }}min</span>
                                            @endif
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @else
                            <div class="bg-gray-50 dark:bg-gray-800 rounded-2xl p-8 text-center border-2 border-dashed border-gray-300 dark:border-gray-700">
                                <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                                <p class="text-gray-600 dark:text-gray-400 font-medium">Course curriculum is being prepared</p>
                                <p class="text-sm text-gray-500 dark:text-gray-500 mt-2">Check back soon for detailed lesson content</p>
                            </div>
                            @endif
                        </div>

                        <!-- Instructor Tab -->
                        <div x-show="activeTab === 'instructor'" id="instructor">
                            @if($course->instructor)
                            <div class="bg-white dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700 rounded-2xl p-6 sm:p-10 shadow-xl">
                                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Instructor</h2>
                                <div class="flex flex-col sm:flex-row items-start gap-6 sm:gap-8">
                                    <div class="w-32 h-32 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center font-bold text-5xl text-white flex-shrink-0 shadow-2xl ring-4 ring-green-200 dark:ring-green-900/50">
                                        {{ substr($course->instructor->name, 0, 1) }}
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
                                            <a href="#" class="hover:text-green-600 dark:hover:text-green-400">{{ $course->instructor->name }}</a>
                                        </h3>
                                        <p class="text-gray-600 dark:text-gray-400 mb-4">Expert Instructor</p>
                                        <p class="text-gray-700 dark:text-gray-300 leading-relaxed mb-6">
                                            Experienced educator passionate about sharing knowledge and empowering students across Africa. With years of expertise in the field, committed to transforming education through innovative teaching methods.
                                        </p>
                                        <div class="flex flex-wrap gap-4 text-sm">
                                            <div class="flex items-center gap-2">
                                                <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3z"/>
                                                </svg>
                                                <span class="text-gray-700 dark:text-gray-300"><strong>{{ $course->students_count ?? 0 }}</strong> Students</span>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                </svg>
                                                <span class="text-gray-700 dark:text-gray-300"><strong>{{ number_format($course->average_rating, 1) }}</strong> Rating</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>

                        <!-- Reviews Tab -->
                        <div x-show="activeTab === 'reviews'">
                            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Student Reviews</h2>
                            <div class="bg-gray-50 dark:bg-gray-800 rounded-2xl p-12 text-center border-2 border-dashed border-gray-300 dark:border-gray-700">
                                <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                                </svg>
                                <p class="text-gray-600 dark:text-gray-400 font-medium mb-2">No reviews yet</p>
                                <p class="text-sm text-gray-500 dark:text-gray-500">Be the first to review this course!</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Desktop Placeholder -->
                <div class="hidden lg:block lg:col-span-1">
                    <!-- Sticky sidebar space reserved -->
                </div>
            </div>
        </div>
    </section>

    <!-- Mobile Fixed Bottom Bar -->
    <div class="lg:hidden fixed bottom-0 left-0 right-0 bg-white/95 dark:bg-gray-800/95 backdrop-blur-xl border-t-2 border-gray-200 dark:border-gray-700 z-50 shadow-2xl">
        <div class="px-4 py-3">
            <div class="flex items-center justify-between gap-4">
                <div class="flex-1 min-w-0">
                    @if($course->price > 0)
                        @if($course->discount_price && $course->discount_price < $course->price)
                        <div class="flex items-baseline gap-2">
                            <span class="text-2xl font-bold text-gray-900 dark:text-white">
                                {{ $course->currency ?? 'KES' }} {{ number_format($course->discount_price) }}
                            </span>
                            <span class="text-sm text-gray-500 dark:text-gray-400 line-through">
                                {{ number_format($course->price) }}
                            </span>
                        </div>
                        @else
                        <div class="text-2xl font-bold text-gray-900 dark:text-white">
                            {{ $course->currency ?? 'KES' }} {{ number_format($course->price) }}
                        </div>
                        @endif
                    @else
                    <div class="text-2xl font-bold text-green-600 dark:text-green-400">Free</div>
                    @endif
                </div>
                @if($isEnrolled)
                    {{-- Already Enrolled --}}
                    <a
                        href="{{ route('student.dashboard') }}"
                        class="px-6 py-3 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white text-base font-bold rounded-lg transition-colors shadow-lg flex-shrink-0"
                    >
                        Continue Learning
                    </a>
                @else
                    @guest
                        {{-- Not Authenticated --}}
                        <a
                            href="{{ route('login', ['redirect' => url()->current()]) }}"
                            class="px-6 py-3 bg-yellow-600 hover:bg-yellow-700 text-white text-base font-bold rounded-lg transition-colors shadow-lg flex-shrink-0"
                        >
                            Login to Enroll
                        </a>
                    @else
                        @if($course->price > 0)
                            {{-- Paid Course - Buy Now --}}
                            <form action="{{ route('cart.add') }}" method="POST" class="flex-shrink-0">
                                @csrf
                                <input type="hidden" name="course_id" value="{{ $course->id }}">
                                <input type="hidden" name="buy_now" value="1">
                                <button
                                    type="submit"
                                    class="px-6 py-3 bg-yellow-600 hover:bg-yellow-700 text-white text-base font-bold rounded-lg transition-colors shadow-lg"
                                >
                                    Buy Now
                                </button>
                            </form>
                        @else
                            {{-- Free Course --}}
                            <form action="{{ route('enrollments.store') }}" method="POST" class="flex-shrink-0">
                                @csrf
                                <input type="hidden" name="course_id" value="{{ $course->id }}">
                                <button
                                    type="submit"
                                    class="px-6 py-3 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white text-base font-bold rounded-lg transition-colors shadow-lg"
                                >
                                    Enroll for Free
                                </button>
                            </form>
                        @endif
                    @endguest
                @endif
            </div>
        </div>
    </div>

    <!-- Footer -->
        <x-footer />


</body>
</html>
