<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <x-seo
        title="Terms of Service"
        description="Read Imole Africa's terms of service. Understand the rules and guidelines for using our online learning platform and courses."
        keywords="terms of service, user agreement, course access, Imole Africa terms"
        :breadcrumbs="[
            ['name' => 'Home', 'url' => url('/')],
            ['name' => 'Terms of Service', 'url' => route('terms')],
        ]"
    />
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-white dark:bg-gray-900">
    <x-header />
    <main class="pt-16">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">Terms of Service</h1>
            <p class="text-gray-600 dark:text-gray-400 mb-8">Last updated: {{ date('F d, Y') }}</p>
            
            <div class="prose dark:prose-invert max-w-none">
                <section class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">1. Acceptance of Terms</h2>
                    <p class="text-gray-700 dark:text-gray-300">By accessing and using iMole Africa's services, you accept and agree to be bound by these Terms of Service.</p>
                </section>

                <section class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">2. User Accounts</h2>
                    <p class="text-gray-700 dark:text-gray-300 mb-4">When you create an account, you must:</p>
                    <ul class="list-disc pl-6 text-gray-700 dark:text-gray-300 space-y-2">
                        <li>Provide accurate and complete information</li>
                        <li>Maintain the security of your account</li>
                        <li>Notify us immediately of any unauthorized use</li>
                        <li>Be responsible for all activities under your account</li>
                    </ul>
                </section>

                <section class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">3. Course Access and Content</h2>
                    <p class="text-gray-700 dark:text-gray-300 mb-4">Upon enrollment:</p>
                    <ul class="list-disc pl-6 text-gray-700 dark:text-gray-300 space-y-2">
                        <li>You receive a limited, non-exclusive license to access course content</li>
                        <li>Content is for personal, non-commercial use only</li>
                        <li>You may not share, distribute, or reproduce course materials</li>
                        <li>Access may be revoked for violation of terms</li>
                    </ul>
                </section>

                <section class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">4. Payment and Refunds</h2>
                    <p class="text-gray-700 dark:text-gray-300 mb-4">All payments are processed securely. Our refund policy:</p>
                    <ul class="list-disc pl-6 text-gray-700 dark:text-gray-300 space-y-2">
                        <li>30-day money-back guarantee for most courses</li>
                        <li>Refunds processed within 7-10 business days</li>
                        <li>Some courses may have different refund policies</li>
                    </ul>
                </section>

                <section class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">5. Prohibited Conduct</h2>
                    <p class="text-gray-700 dark:text-gray-300 mb-4">You agree not to:</p>
                    <ul class="list-disc pl-6 text-gray-700 dark:text-gray-300 space-y-2">
                        <li>Violate any laws or regulations</li>
                        <li>Infringe on intellectual property rights</li>
                        <li>Harass or harm other users</li>
                        <li>Attempt to gain unauthorized access to our systems</li>
                        <li>Use our services for any illegal purpose</li>
                    </ul>
                </section>

                <section class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">6. Limitation of Liability</h2>
                    <p class="text-gray-700 dark:text-gray-300">iMole Africa is not liable for any indirect, incidental, special, or consequential damages arising from your use of our services.</p>
                </section>

                <section class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">7. Changes to Terms</h2>
                    <p class="text-gray-700 dark:text-gray-300">We reserve the right to modify these terms at any time. Continued use of our services constitutes acceptance of modified terms.</p>
                </section>

                <section class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">8. Contact</h2>
                    <p class="text-gray-700 dark:text-gray-300">For questions about these Terms, contact us at <a href="mailto:legal@imoleafrica.org" class="text-green-600 dark:text-green-400 hover:underline">legal@imoleafrica.org</a></p>
                </section>
            </div>
        </div>
    </main>
    <x-footer />
</body>
</html>
