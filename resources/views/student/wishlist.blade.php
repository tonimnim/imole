<x-layouts.student>
    <x-slot name="title">My Wishlist</x-slot>

    <!-- Page Header -->
    <div class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">My Wishlist</h1>
            <p class="mt-2 text-gray-600 dark:text-gray-400">Courses you've saved for later</p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8">
        @if($wishlists->count() > 0)
            <!-- Wishlist Stats -->
            <div class="mb-6 flex items-center justify-between">
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    {{ $wishlists->total() }} {{ Str::plural('course', $wishlists->total()) }} in your wishlist
                </p>
                <form method="POST" action="{{ route('wishlist.clear') }}" onsubmit="return confirm('Are you sure you want to clear your entire wishlist?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-sm text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 font-semibold transition-colors">
                        Clear Wishlist
                    </button>
                </form>
            </div>

            <!-- Wishlist Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
                @foreach($wishlists as $wishlist)
                    <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden hover:shadow-xl transition-all group">
                        <!-- Course Thumbnail -->
                        <a href="{{ route('courses.show', $wishlist->course) }}" class="block relative overflow-hidden">
                            <div class="aspect-video bg-gray-200 dark:bg-gray-700">
                                @if($wishlist->course->thumbnail)
                                    <img src="{{ Storage::url($wishlist->course->thumbnail) }}" alt="{{ $wishlist->course->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-purple-100 to-indigo-100 dark:from-purple-900/20 dark:to-indigo-900/20">
                                        <svg class="w-16 h-16 text-purple-600 dark:text-purple-400 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                        </svg>
                                    </div>
                                @endif
                                @if($wishlist->course->is_featured)
                                    <span class="absolute top-2 left-2 px-2 py-1 bg-yellow-500 text-white text-xs font-bold rounded">Bestseller</span>
                                @endif
                            </div>

                            <!-- Remove from Wishlist Button -->
                            <form method="POST" action="{{ route('wishlist.remove', $wishlist->course) }}" class="absolute top-2 right-2">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 bg-white dark:bg-gray-800 rounded-full shadow-lg hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors group/btn" title="Remove from wishlist">
                                    <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                    </svg>
                                </button>
                            </form>
                        </a>

                        <!-- Course Info -->
                        <div class="p-4">
                            <a href="{{ route('courses.show', $wishlist->course) }}">
                                <h3 class="font-bold text-gray-900 dark:text-white line-clamp-2 mb-2 group-hover:text-purple-600 dark:group-hover:text-purple-400 transition-colors">
                                    {{ $wishlist->course->title }}
                                </h3>
                            </a>
                            <p class="text-xs text-gray-600 dark:text-gray-400 mb-3">
                                {{ $wishlist->course->instructor->name }}
                            </p>

                            <!-- Rating -->
                            @if($wishlist->course->reviews_count > 0)
                                <div class="flex items-center gap-1 mb-3">
                                    <span class="text-sm font-bold text-gray-900 dark:text-white">{{ number_format($wishlist->course->average_rating, 1) }}</span>
                                    <x-star-rating :rating="$wishlist->course->average_rating" size="sm" />
                                    <span class="text-xs text-gray-500 dark:text-gray-400">({{ $wishlist->course->reviews_count }})</span>
                                </div>
                            @endif

                            <!-- Course Stats -->
                            <div class="flex items-center gap-3 mb-3 text-xs text-gray-600 dark:text-gray-400">
                                <div class="flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span>{{ $wishlist->course->lessons_count }} lessons</span>
                                </div>
                                <div class="flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                    </svg>
                                    <span>{{ $wishlist->course->difficulty_level }}</span>
                                </div>
                            </div>

                            <!-- Price -->
                            @if($wishlist->course->price > 0)
                                <div class="text-lg font-bold text-gray-900 dark:text-white mb-3">
                                    Ksh{{ number_format($wishlist->course->price, 2) }}
                                </div>
                            @else
                                <div class="text-lg font-bold text-green-600 dark:text-green-400 mb-3">
                                    Free
                                </div>
                            @endif

                            <!-- Add to Cart Button -->
                            <form method="POST" action="{{ route('cart.add', $wishlist->course) }}">
                                @csrf
                                <button type="submit" class="block w-full px-4 py-2.5 bg-purple-600 hover:bg-purple-700 text-white text-sm font-bold rounded text-center transition-colors">
                                    Add to Cart
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $wishlists->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-20">
                <div class="inline-flex items-center justify-center w-24 h-24 bg-purple-100 dark:bg-purple-900/20 rounded-full mb-6">
                    <svg class="w-12 h-12 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-3">Your Wishlist is Empty</h3>
                <p class="text-gray-600 dark:text-gray-400 mb-8 max-w-md mx-auto">Start adding courses to your wishlist to keep track of what you want to learn</p>
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
