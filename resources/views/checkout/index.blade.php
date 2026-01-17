<x-layouts.student>
    <x-slot name="title">Checkout</x-slot>

    <!-- Page Header -->
    <div class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Checkout</h1>
            <p class="mt-2 text-gray-600 dark:text-gray-400">Complete your purchase</p>
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

        @if($errors->any())
            <x-alert type="error" dismissible class="mb-6">
                <ul class="list-disc list-inside space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </x-alert>
        @endif

        @if($cartItems->count() > 0)
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Checkout Form -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Billing Information -->
                    <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                            <h2 class="text-lg font-bold text-gray-900 dark:text-white">Billing Information</h2>
                        </div>
                        <div class="p-6">
                            <form method="POST" action="{{ route('checkout.process') }}" id="checkout-form">
                                @csrf

                                <div class="space-y-4">
                                    <!-- Full Name -->
                                    <div>
                                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Full Name <span class="text-red-500">*</span>
                                        </label>
                                        <input
                                            type="text"
                                            id="name"
                                            name="name"
                                            value="{{ old('name', auth()->user()->name) }}"
                                            required
                                            class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-purple-500"
                                        >
                                    </div>

                                    <!-- Email -->
                                    <div>
                                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Email Address <span class="text-red-500">*</span>
                                        </label>
                                        <input
                                            type="email"
                                            id="email"
                                            name="email"
                                            value="{{ old('email', auth()->user()->email) }}"
                                            required
                                            class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-purple-500"
                                        >
                                    </div>

                                    <!-- Phone -->
                                    <div>
                                        <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Phone Number <span class="text-red-500">*</span>
                                        </label>
                                        <input
                                            type="tel"
                                            id="phone"
                                            name="phone"
                                            value="{{ old('phone') }}"
                                            required
                                            placeholder="+254 700 000 000"
                                            class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-purple-500"
                                        >
                                    </div>

                                    <!-- Country -->
                                    <div>
                                        <label for="country" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Country <span class="text-red-500">*</span>
                                        </label>
                                        <select
                                            id="country"
                                            name="country"
                                            required
                                            class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-purple-500"
                                        >
                                            <option value="">Select Country</option>
                                            <option value="KE" {{ old('country') == 'KE' ? 'selected' : '' }}>Kenya</option>
                                            <option value="NG" {{ old('country') == 'NG' ? 'selected' : '' }}>Nigeria</option>
                                            <option value="GH" {{ old('country') == 'GH' ? 'selected' : '' }}>Ghana</option>
                                            <option value="ZA" {{ old('country') == 'ZA' ? 'selected' : '' }}>South Africa</option>
                                            <option value="OTHER" {{ old('country') == 'OTHER' ? 'selected' : '' }}>Other</option>
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Payment Method -->
                    <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                            <h2 class="text-lg font-bold text-gray-900 dark:text-white">Payment Method</h2>
                        </div>
                        <div class="p-6">
                            <div class="space-y-3" x-data="{ paymentMethod: 'card' }">
                                <!-- Card Payment via Paystack (Primary) -->
                                <label class="flex items-start gap-3 p-4 border-2 rounded-lg cursor-pointer transition-colors" :class="paymentMethod === 'card' ? 'border-purple-600 dark:border-purple-500 bg-purple-50 dark:bg-purple-900/20' : 'border-gray-200 dark:border-gray-700 hover:border-purple-500 dark:hover:border-purple-500'">
                                    <input
                                        type="radio"
                                        name="payment_method"
                                        value="card"
                                        form="checkout-form"
                                        x-model="paymentMethod"
                                        class="mt-1"
                                        checked
                                    >
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2 mb-1">
                                            <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                            </svg>
                                            <span class="font-semibold text-gray-900 dark:text-white">Credit/Debit Card</span>
                                            <span class="ml-2 px-2 py-0.5 bg-purple-600 text-white text-xs font-bold rounded">RECOMMENDED</span>
                                        </div>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">Pay securely with Visa, Mastercard, or Verve via Paystack</p>
                                        <div class="flex items-center gap-2 mt-2">
                                            <img src="https://cdn.paystack.co/assets/img/logos/visa.svg" alt="Visa" class="h-6">
                                            <img src="https://cdn.paystack.co/assets/img/logos/mastercard.svg" alt="Mastercard" class="h-6">
                                            <img src="https://cdn.paystack.co/assets/img/logos/verve.svg" alt="Verve" class="h-6">
                                        </div>
                                    </div>
                                </label>

                                <!-- M-Pesa Payment -->
                                <label class="flex items-start gap-3 p-4 border-2 rounded-lg cursor-pointer transition-colors" :class="paymentMethod === 'mpesa' ? 'border-green-600 dark:border-green-500 bg-green-50 dark:bg-green-900/20' : 'border-gray-200 dark:border-gray-700 hover:border-green-500 dark:hover:border-green-500'">
                                    <input
                                        type="radio"
                                        name="payment_method"
                                        value="mpesa"
                                        form="checkout-form"
                                        x-model="paymentMethod"
                                        class="mt-1"
                                    >
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2 mb-1">
                                            <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                            </svg>
                                            <span class="font-semibold text-gray-900 dark:text-white">M-Pesa</span>
                                        </div>
                                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">Pay instantly with your M-Pesa mobile money</p>

                                        <!-- M-Pesa Phone Number Field -->
                                        <div x-show="paymentMethod === 'mpesa'" x-transition class="mt-3">
                                            <label for="phone_number" class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                                M-Pesa Phone Number <span class="text-red-500">*</span>
                                            </label>
                                            <input
                                                type="tel"
                                                id="phone_number"
                                                name="phone_number"
                                                form="checkout-form"
                                                placeholder="254712345678"
                                                pattern="254[0-9]{9}"
                                                :required="paymentMethod === 'mpesa'"
                                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white text-sm focus:outline-none focus:ring-2 focus:ring-green-500"
                                            >
                                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Enter your M-Pesa number (format: 254XXXXXXXXX)</p>
                                        </div>
                                    </div>
                                </label>

                                <!-- Bank Transfer (Coming Soon) -->
                                <label class="flex items-start gap-3 p-4 border-2 border-gray-200 dark:border-gray-700 rounded-lg cursor-not-allowed opacity-60 relative">
                                    <input
                                        type="radio"
                                        name="payment_method"
                                        value="bank_transfer"
                                        disabled
                                        class="mt-1"
                                    >
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2 mb-1">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"/>
                                            </svg>
                                            <span class="font-semibold text-gray-900 dark:text-white">Bank Transfer</span>
                                            <span class="ml-2 px-2 py-0.5 bg-yellow-500 text-white text-xs font-bold rounded">COMING SOON</span>
                                        </div>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">Transfer directly to our bank account</p>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Terms and Conditions -->
                    <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-6">
                        <label class="flex items-start gap-3 cursor-pointer">
                            <input
                                type="checkbox"
                                name="terms"
                                form="checkout-form"
                                required
                                class="mt-1"
                            >
                            <span class="text-sm text-gray-700 dark:text-gray-300">
                                I agree to the <a href="{{ route('terms') }}" class="text-purple-600 dark:text-purple-400 hover:underline">Terms of Service</a> and <a href="{{ route('privacy') }}" class="text-purple-600 dark:text-purple-400 hover:underline">Privacy Policy</a>
                            </span>
                        </label>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden sticky top-6">
                        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                            <h2 class="text-lg font-bold text-gray-900 dark:text-white">Order Summary</h2>
                        </div>

                        <div class="p-6 space-y-4">
                            <!-- Courses List -->
                            <div class="space-y-3 max-h-64 overflow-y-auto">
                                @foreach($cartItems as $item)
                                    <div class="flex gap-3">
                                        <div class="w-16 aspect-video bg-gray-200 dark:bg-gray-700 rounded overflow-hidden flex-shrink-0">
                                            @if($item->course->thumbnail)
                                                <img src="{{ Storage::url($item->course->thumbnail) }}" alt="{{ $item->course->title }}" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-purple-100 to-indigo-100 dark:from-purple-900/20 dark:to-indigo-900/20">
                                                    <svg class="w-4 h-4 text-purple-600 dark:text-purple-400 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <h4 class="text-sm font-semibold text-gray-900 dark:text-white line-clamp-2">{{ $item->course->title }}</h4>
                                            <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">Ksh{{ number_format($item->course->price, 2) }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="border-t border-gray-200 dark:border-gray-700 pt-4 space-y-3">
                                <!-- Subtotal -->
                                <div class="flex items-center justify-between text-gray-700 dark:text-gray-300">
                                    <span>Subtotal:</span>
                                    <span class="font-semibold">Ksh{{ number_format($subtotal, 2) }}</span>
                                </div>

                                <!-- Tax -->
                                @if($tax > 0)
                                    <div class="flex items-center justify-between text-gray-700 dark:text-gray-300">
                                        <span>Tax (VAT):</span>
                                        <span class="font-semibold">Ksh{{ number_format($tax, 2) }}</span>
                                    </div>
                                @endif

                                <!-- Total -->
                                <div class="flex items-center justify-between text-lg pt-3 border-t border-gray-200 dark:border-gray-700">
                                    <span class="font-bold text-gray-900 dark:text-white">Total:</span>
                                    <span class="font-bold text-purple-600 dark:text-purple-400">Ksh{{ number_format($total, 2) }}</span>
                                </div>
                            </div>

                            <!-- Complete Order Button -->
                            <button
                                type="submit"
                                form="checkout-form"
                                class="block w-full px-6 py-3 bg-purple-600 hover:bg-purple-700 text-white text-center font-bold rounded-lg transition-colors"
                            >
                                Complete Order
                            </button>

                            <!-- Security Notice -->
                            <div class="flex items-start gap-2 text-xs text-gray-600 dark:text-gray-400">
                                <svg class="w-4 h-4 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                                <span>Your payment information is secure and encrypted. Powered by Paystack.</span>
                            </div>

                            <!-- Paystack Badge -->
                            <div class="flex justify-center pt-2">
                                <img src="https://cdn.paystack.co/assets/img/payment/secured-by-paystack.png" alt="Secured by Paystack" class="h-8 opacity-75">
                            </div>
                        </div>
                    </div>

                    <!-- Back to Cart -->
                    <div class="mt-4">
                        <a href="{{ route('cart.index') }}" class="flex items-center justify-center gap-2 text-sm text-purple-600 dark:text-purple-400 hover:text-purple-700 dark:hover:text-purple-300 font-semibold transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Back to Cart
                        </a>
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
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-3">No Items to Checkout</h3>
                <p class="text-gray-600 dark:text-gray-400 mb-8 max-w-md mx-auto">Add courses to your cart before proceeding to checkout</p>
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
