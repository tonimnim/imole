<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Privacy Policy - {{ config('app.name') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-white dark:bg-gray-900">
    <x-header />
    <main class="pt-16">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">Privacy Policy</h1>
            <p class="text-gray-600 dark:text-gray-400 mb-8">Last updated: {{ date('F d, Y') }}</p>
            
            <div class="prose dark:prose-invert max-w-none">
                <section class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">1. Information We Collect</h2>
                    <p class="text-gray-700 dark:text-gray-300 mb-4">We collect information that you provide directly to us, including:</p>
                    <ul class="list-disc pl-6 text-gray-700 dark:text-gray-300 space-y-2">
                        <li>Name, email address, and contact information</li>
                        <li>Account credentials and profile information</li>
                        <li>Course enrollment and progress data</li>
                        <li>Payment and billing information</li>
                        <li>Communications with us</li>
                    </ul>
                </section>

                <section class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">2. How We Use Your Information</h2>
                    <p class="text-gray-700 dark:text-gray-300 mb-4">We use the information we collect to:</p>
                    <ul class="list-disc pl-6 text-gray-700 dark:text-gray-300 space-y-2">
                        <li>Provide, maintain, and improve our services</li>
                        <li>Process transactions and send related information</li>
                        <li>Send you technical notices and support messages</li>
                        <li>Respond to your comments and questions</li>
                        <li>Monitor and analyze trends and usage</li>
                    </ul>
                </section>

                <section class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">3. Information Sharing</h2>
                    <p class="text-gray-700 dark:text-gray-300 mb-4">We do not sell your personal information. We may share your information with:</p>
                    <ul class="list-disc pl-6 text-gray-700 dark:text-gray-300 space-y-2">
                        <li>Service providers who assist in our operations</li>
                        <li>Instructors for courses you're enrolled in</li>
                        <li>Legal authorities when required by law</li>
                    </ul>
                </section>

                <section class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">4. Data Security</h2>
                    <p class="text-gray-700 dark:text-gray-300">We implement appropriate security measures to protect your personal information from unauthorized access, alteration, disclosure, or destruction.</p>
                </section>

                <section class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">5. Your Rights</h2>
                    <p class="text-gray-700 dark:text-gray-300 mb-4">You have the right to:</p>
                    <ul class="list-disc pl-6 text-gray-700 dark:text-gray-300 space-y-2">
                        <li>Access and update your personal information</li>
                        <li>Request deletion of your data</li>
                        <li>Opt-out of marketing communications</li>
                        <li>Export your data</li>
                    </ul>
                </section>

                <section class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">6. Contact Us</h2>
                    <p class="text-gray-700 dark:text-gray-300">If you have questions about this Privacy Policy, please contact us at <a href="mailto:privacy@imoleafrica.org" class="text-green-600 dark:text-green-400 hover:underline">privacy@imoleafrica.org</a></p>
                </section>
            </div>
        </div>
    </main>
    <x-footer />
</body>
</html>
