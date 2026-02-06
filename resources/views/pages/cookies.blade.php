<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <x-seo
        title="Cookie Policy"
        description="Read Imole Africa's cookie policy. Learn about the types of cookies we use and how to manage your cookie preferences."
        keywords="cookie policy, cookies, data tracking, browser cookies, Imole Africa cookies"
        :breadcrumbs="[
            ['name' => 'Home', 'url' => url('/')],
            ['name' => 'Cookie Policy', 'url' => route('cookies')],
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
            <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">Cookie Policy</h1>
            <p class="text-gray-600 dark:text-gray-400 mb-8">Last updated: {{ date('F d, Y') }}</p>
            
            <div class="prose dark:prose-invert max-w-none">
                <section class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">What Are Cookies?</h2>
                    <p class="text-gray-700 dark:text-gray-300">Cookies are small text files stored on your device when you visit our website. They help us provide you with a better experience by remembering your preferences and understanding how you use our site.</p>
                </section>

                <section class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Types of Cookies We Use</h2>
                    
                    <div class="mb-6">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Essential Cookies</h3>
                        <p class="text-gray-700 dark:text-gray-300">Required for the website to function properly. These include authentication and security cookies.</p>
                    </div>

                    <div class="mb-6">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Performance Cookies</h3>
                        <p class="text-gray-700 dark:text-gray-300">Help us understand how visitors interact with our website by collecting anonymous information.</p>
                    </div>

                    <div class="mb-6">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Functionality Cookies</h3>
                        <p class="text-gray-700 dark:text-gray-300">Remember your preferences and choices to provide enhanced features.</p>
                    </div>

                    <div class="mb-6">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Targeting Cookies</h3>
                        <p class="text-gray-700 dark:text-gray-300">Used to deliver relevant advertisements and track campaign effectiveness.</p>
                    </div>
                </section>

                <section class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Managing Cookies</h2>
                    <p class="text-gray-700 dark:text-gray-300 mb-4">You can control cookies through your browser settings. Most browsers allow you to:</p>
                    <ul class="list-disc pl-6 text-gray-700 dark:text-gray-300 space-y-2">
                        <li>View and delete cookies</li>
                        <li>Block third-party cookies</li>
                        <li>Block all cookies</li>
                        <li>Delete cookies when you close your browser</li>
                    </ul>
                    <p class="text-gray-700 dark:text-gray-300 mt-4">Note: Blocking cookies may affect your experience on our website.</p>
                </section>

                <section class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Contact Us</h2>
                    <p class="text-gray-700 dark:text-gray-300">If you have questions about our use of cookies, please contact us at <a href="mailto:privacy@imoleafrica.org" class="text-green-600 dark:text-green-400 hover:underline">privacy@imoleafrica.org</a></p>
                </section>
            </div>
        </div>
    </main>
    <x-footer />
</body>
</html>
