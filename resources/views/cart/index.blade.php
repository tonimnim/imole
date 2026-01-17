<x-layouts.student>
    <x-slot name="title">Shopping Cart</x-slot>

    <!-- Page Header -->
    <div class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Shopping Cart</h1>
            <p class="mt-2 text-gray-600 dark:text-gray-400">{{ $cartItems->count() }} {{ Str::plural('course', $cartItems->count()) }} in cart</p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8">
        @if(session('success'))
            <x-alert type="success" dismissible class="mb-6">
                {{ session('success') }}
            </x-alert>
        @endif

        @if(session('error'))
            <x-alert type="error" dismissible class="mb-6">
                {{ session('error') }}
            </x-alert>
        @endif

        @if($cartItems->count() > 0)
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Cart Items -->
                <div class="lg:col-span-2">
                    <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden">
                        <!-- Cart Header -->
                        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                            <h2 class="text-lg font-bold text-gray-900 dark:text-white">
                                {{ $cartItems->count() }} {{ Str::plural('Course', $cartItems->count()) }} in Cart
                            </h2>
                        </div>

                        <!-- Cart Items List -->
                        <div class="divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($cartItems as $item)
                                <div class="p-6 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                    <div class="flex gap-4">
                                        <!-- Course Thumbnail -->
                                        <a href="{{ route('courses.show', $item->course) }}" class="flex-shrink-0">
                                            <div class="w-32 aspect-video bg-gray-200 dark:bg-gray-700 rounded overflow-hidden">
                                                @if($item->course->thumbnail)
                                                    <img src="{{ Storage::url($item->course->thumbnail) }}" alt="{{ $item->course->title }}" class="w-full h-full object-cover">
                                                @else
                                                    <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-purple-100 to-indigo-100 dark:from-purple-900/20 dark:to-indigo-900/20">
                                                        <svg class="w-8 h-8 text-purple-600 dark:text-purple-400 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                                        </svg>
                                                    </div>
                                                @endif
                                            </div>
                                        </a>

                                        <!-- Course Details -->
                                        <div class="flex-1 min-w-0">
                                            <a href="{{ route('courses.show', $item->course) }}" class="block group">
                                                <h3 class="font-bold text-gray-900 dark:text-white line-clamp-2 mb-1 group-hover:text-purple-600 dark:group-hover:text-purple-400 transition-colors">
                                                    {{ $item->course->title }}
                                                </h3>
                                            </a>
                                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">
                                                by {{ $item->course->instructor->name }}
                                            </p>

                                            <!-- Course Stats -->
                                            <div class="flex items-center gap-4 mb-2 text-xs text-gray-600 dark:text-gray-400">
                                                @if($item->course->reviews_count > 0)
                                                    <div class="flex items-center gap-1">
                                                        <span class="font-semibold text-gray-900 dark:text-white">{{ number_format($item->course->average_rating, 1) }}</span>
                                                        <x-star-rating :rating="$item->course->average_rating" size="sm" />
                                                        <span>({{ $item->course->reviews_count }})</span>
                                                    </div>
                                                @endif
                                                <div class="flex items-center gap-1">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                    </svg>
                                                    <span>{{ $item->course->lessons_count }} lessons</span>
                                                </div>
                                                <div class="flex items-center gap-1">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                                    </svg>
                                                    <span>{{ $item->course->difficulty_level }}</span>
                                                </div>
                                            </div>

                                            <!-- Actions -->
                                            <div class="flex items-center gap-4 mt-3">
                                                <form method="POST" action="{{ route('cart.remove', $item->course) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-sm text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 font-semibold transition-colors">
                                                        Remove
                                                    </button>
                                                </form>
                                                <form method="POST" action="{{ route('wishlists.store') }}">
                                                    @csrf
                                                    <input type="hidden" name="course_id" value="{{ $item->course_id }}">
                                                    <button type="submit" class="text-sm text-purple-600 dark:text-purple-400 hover:text-purple-700 dark:hover:text-purple-300 font-semibold transition-colors">
                                                        Move to Wishlist
                                                    </button>
                                                </form>
                                            </div>
                                        </div>

                                        <!-- Price -->
                                        <div class="flex-shrink-0 text-right">
                                            @if($item->course->price > 0)
                                                <div class="text-lg font-bold text-gray-900 dark:text-white">
                                                    Ksh{{ number_format($item->course->price, 2) }}
                                                </div>
                                            @else
                                                <div class="text-lg font-bold text-green-600 dark:text-green-400">
                                                    Free
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden sticky top-6">
                        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                            <h2 class="text-lg font-bold text-gray-900 dark:text-white">Order Summary</h2>
                        </div>

                        <div class="p-6 space-y-4">
                            <!-- Subtotal -->
                            <div class="flex items-center justify-between text-gray-700 dark:text-gray-300">
                                <span>Subtotal:</span>
                                <span class="font-semibold">Ksh{{ number_format($subtotal, 2) }}</span>
                            </div>

                            <!-- Discount (if applicable) -->
                            @if($subtotal !== $total)
                                <div class="flex items-center justify-between text-green-600 dark:text-green-400">
                                    <span>Discount:</span>
                                    <span class="font-semibold">-Ksh{{ number_format($subtotal - $total, 2) }}</span>
                                </div>
                            @endif

                            <!-- Divider -->
                            <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                                <div class="flex items-center justify-between text-lg">
                                    <span class="font-bold text-gray-900 dark:text-white">Total:</span>
                                    <span class="font-bold text-gray-900 dark:text-white">Ksh{{ number_format($total, 2) }}</span>
                                </div>
                            </div>

                            <!-- Checkout Button -->
                            <a href="{{ route('checkout.index') }}" class="block w-full px-6 py-3 bg-purple-600 hover:bg-purple-700 text-white text-center font-bold rounded-lg transition-colors">
                                Proceed to Checkout
                            </a>

                            <!-- Coupon Code -->
                            <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                                <form method="POST" action="{{ route('cart.apply-coupon') }}">
                                    @csrf
                                    <label for="coupon_code" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Have a coupon code?
                                    </label>
                                    <div class="flex gap-2">
                                        <input
                                            type="text"
                                            id="coupon_code"
                                            name="coupon_code"
                                            placeholder="Enter code"
                                            class="flex-1 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-purple-500"
                                        >
                                        <button type="submit" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-900 dark:text-white text-sm font-semibold rounded-lg transition-colors">
                                            Apply
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-20">
                <div class="inline-flex items-center justify-center w-24 h-24 bg-purple-100 dark:bg-purple-900/20 rounded-full mb-6">
                    <svg class="w-12 h-12 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-3">Your Cart is Empty</h3>
                <p class="text-gray-600 dark:text-gray-400 mb-8 max-w-md mx-auto">Browse our courses and add them to your cart to start learning</p>
                <div class="flex items-center justify-center gap-4">
                    <a href="{{ route('courses.index') }}" class="inline-flex items-center gap-2 px-8 py-3 bg-purple-600 hover:bg-purple-700 text-white font-bold rounded-lg transition-colors">
                        Browse Courses
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </a>
                    <a href="{{ route('student.wishlist') }}" class="inline-flex items-center gap-2 px-8 py-3 bg-white dark:bg-gray-800 border-2 border-purple-600 dark:border-purple-500 text-purple-600 dark:text-purple-400 hover:bg-purple-50 dark:hover:bg-purple-900/20 font-bold rounded-lg transition-colors">
                        View Wishlist
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                    </a>
                </div>
            </div>
        @endif
    </div>
</x-layouts.student>
