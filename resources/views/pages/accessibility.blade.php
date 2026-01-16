<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Accessibility Statement - {{ config('app.name') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-white dark:bg-gray-900">
    <x-header />
    <main class="pt-16">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">Accessibility Statement</h1>
            <p class="text-gray-600 dark:text-gray-400 mb-8">Last updated: {{ date('F d, Y') }}</p>
            
            <div class="prose dark:prose-invert max-w-none">
                <section class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Our Commitment</h2>
                    <p class="text-gray-700 dark:text-gray-300">iMole Africa is committed to ensuring digital accessibility for people with disabilities. We are continually improving the user experience for everyone and applying relevant accessibility standards.</p>
                </section>

                <section class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Accessibility Features</h2>
                    <p class="text-gray-700 dark:text-gray-300 mb-4">Our website includes the following accessibility features:</p>
                    <ul class="list-disc pl-6 text-gray-700 dark:text-gray-300 space-y-2">
                        <li>Keyboard navigation support</li>
                        <li>Screen reader compatibility</li>
                        <li>Adjustable text sizes</li>
                        <li>High contrast mode</li>
                        <li>Alternative text for images</li>
                        <li>Clear and consistent navigation</li>
                        <li>Descriptive link text</li>
                    </ul>
                </section>

                <section class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Standards Compliance</h2>
                    <p class="text-gray-700 dark:text-gray-300">We strive to conform to the Web Content Accessibility Guidelines (WCAG) 2.1 Level AA standards. These guidelines explain how to make web content more accessible for people with disabilities.</p>
                </section>

                <section class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Ongoing Efforts</h2>
                    <p class="text-gray-700 dark:text-gray-300 mb-4">We are continuously working to improve accessibility through:</p>
                    <ul class="list-disc pl-6 text-gray-700 dark:text-gray-300 space-y-2">
                        <li>Regular accessibility audits</li>
                        <li>User testing with assistive technologies</li>
                        <li>Staff training on accessibility best practices</li>
                        <li>Incorporating user feedback</li>
                    </ul>
                </section>

                <section class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Feedback and Contact</h2>
                    <p class="text-gray-700 dark:text-gray-300 mb-4">We welcome your feedback on the accessibility of iMole Africa. If you encounter any accessibility barriers or have suggestions for improvement, please contact us:</p>
                    <ul class="list-none text-gray-700 dark:text-gray-300 space-y-2">
                        <li><strong>Email:</strong> <a href="mailto:accessibility@imoleafrica.org" class="text-green-600 dark:text-green-400 hover:underline">accessibility@imoleafrica.org</a></li>
                        <li><strong>Phone:</strong> <a href="tel:+254700000000" class="text-green-600 dark:text-green-400 hover:underline">+254 700 000 000</a></li>
                    </ul>
                    <p class="text-gray-700 dark:text-gray-300 mt-4">We aim to respond to accessibility feedback within 5 business days.</p>
                </section>

                <section class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Technical Specifications</h2>
                    <p class="text-gray-700 dark:text-gray-300">Our website is designed to be compatible with the following assistive technologies:</p>
                    <ul class="list-disc pl-6 text-gray-700 dark:text-gray-300 space-y-2">
                        <li>Screen readers (JAWS, NVDA, VoiceOver)</li>
                        <li>Screen magnification software</li>
                        <li>Speech recognition software</li>
                        <li>Alternative input devices</li>
                    </ul>
                </section>
            </div>
        </div>
    </main>
    <x-footer />
</body>
</html>
