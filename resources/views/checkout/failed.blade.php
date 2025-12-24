<x-layouts.student>
    <x-slot name="title">Payment Failed</x-slot>

    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl w-full">
            <!-- Error Icon -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-24 h-24 bg-red-100 dark:bg-red-900/20 rounded-full mb-6">
                    <svg class="w-12 h-12 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Payment Failed</h1>
                <p class="text-lg text-gray-600 dark:text-gray-400">We couldn't process your payment</p>
            </div>

            <!-- Order Details -->
            <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-6 mb-6">
                <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Order Information</h2>
                <div class="space-y-2">
                    <div class="flex justify-between">
                        <span class="text-gray-600 dark:text-gray-400">Order Number:</span>
                        <span class="font-semibold text-gray-900 dark:text-white">{{ $order->order_number }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600 dark:text-gray-400">Status:</span>
                        <span class="font-semibold text-red-600 dark:text-red-400">Failed</span>
                    </div>
                </div>
            </div>

            <!-- Help Text -->
            <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-900/50 rounded-lg p-4 mb-6">
                <h3 class="font-semibold text-yellow-800 dark:text-yellow-400 mb-2">What went wrong?</h3>
                <ul class="text-sm text-yellow-700 dark:text-yellow-500 space-y-1 list-disc list-inside">
                    <li>Insufficient funds in your M-Pesa account</li>
                    <li>Transaction was cancelled</li>
                    <li>Network connection issue</li>
                    <li>Incorrect phone number</li>
                </ul>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4">
                <a href="{{ route('checkout.index') }}" class="flex-1 px-6 py-3 bg-purple-600 hover:bg-purple-700 text-white font-bold rounded-lg text-center transition-colors">
                    Try Again
                </a>
                <a href="{{ route('cart.index') }}" class="flex-1 px-6 py-3 border-2 border-gray-300 dark:border-gray-600 hover:border-purple-600 dark:hover:border-purple-600 text-gray-700 dark:text-gray-300 hover:text-purple-600 dark:hover:text-purple-400 font-bold rounded-lg text-center transition-colors">
                    Back to Cart
                </a>
            </div>
        </div>
    </div>
</x-layouts.student>
