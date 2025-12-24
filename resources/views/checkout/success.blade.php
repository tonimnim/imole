<x-layouts.student>
    <x-slot name="title">Payment Successful</x-slot>

    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl w-full">
            <!-- Success Icon -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-24 h-24 bg-green-100 dark:bg-green-900/20 rounded-full mb-6">
                    <svg class="w-12 h-12 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Payment Successful!</h1>
                <p class="text-lg text-gray-600 dark:text-gray-400">Thank you for your purchase</p>
            </div>

            <!-- Order Details -->
            <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-6 mb-6">
                <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Order Details</h2>
                <div class="space-y-2 mb-4">
                    <div class="flex justify-between">
                        <span class="text-gray-600 dark:text-gray-400">Order Number:</span>
                        <span class="font-semibold text-gray-900 dark:text-white">{{ $order->order_number }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600 dark:text-gray-400">Payment Method:</span>
                        <span class="font-semibold text-gray-900 dark:text-white">{{ strtoupper($order->payment_method) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600 dark:text-gray-400">Total Paid:</span>
                        <span class="font-semibold text-green-600 dark:text-green-400">KSh {{ number_format($order->total, 2) }}</span>
                    </div>
                </div>

                <!-- Enrolled Courses -->
                <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                    <h3 class="font-semibold text-gray-900 dark:text-white mb-3">Enrolled Courses:</h3>
                    <div class="space-y-2">
                        @foreach($order->items as $item)
                            <div class="flex items-center gap-3 p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                                <svg class="w-5 h-5 text-green-600 dark:text-green-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span class="text-gray-900 dark:text-white">{{ $item->course->title }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4">
                <a href="{{ route('student.my-courses') }}" class="flex-1 px-6 py-3 bg-purple-600 hover:bg-purple-700 text-white font-bold rounded-lg text-center transition-colors">
                    View My Courses
                </a>
                <a href="{{ route('courses.index') }}" class="flex-1 px-6 py-3 border-2 border-gray-300 dark:border-gray-600 hover:border-purple-600 dark:hover:border-purple-600 text-gray-700 dark:text-gray-300 hover:text-purple-600 dark:hover:text-purple-400 font-bold rounded-lg text-center transition-colors">
                    Browse More Courses
                </a>
            </div>
        </div>
    </div>
</x-layouts.student>
