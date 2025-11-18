<!-- Hero Section - Rotating Carousel -->
<section class="relative bg-gradient-to-br from-green-50 to-emerald-100 dark:from-gray-800 dark:to-gray-900">
    <div
        x-data="{
            currentSlide: 0,
            slides: [
                {
                    title: 'Africa\'s Premier Learning Platform',
                    subtitle: 'Empowering education through technology, accessible to all.',
                    image: '/african-woman-working-home-wearing-operator-headset-celebrating-achievement-with-happy-smile-winner-expression-with-raised-hand.jpg',
                    cta1: 'Browse Courses',
                    cta2: 'Watch Demo'
                },
                {
                    title: 'Learn Skills That Transform Lives',
                    subtitle: 'From agriculture to technology, gain practical skills for real-world success.',
                    image: '/homepage-banner.svg',
                    cta1: 'Get Started',
                    cta2: 'Explore Topics'
                }
            ],
            autoRotate: null,
            startAutoRotate() {
                this.autoRotate = setInterval(() => {
                    this.currentSlide = (this.currentSlide + 1) % this.slides.length;
                }, 6000);
            },
            stopAutoRotate() {
                if (this.autoRotate) {
                    clearInterval(this.autoRotate);
                }
            },
            goToSlide(index) {
                this.currentSlide = index;
                this.stopAutoRotate();
                this.startAutoRotate();
            }
        }"
        x-init="startAutoRotate()"
        class="relative overflow-hidden"
    >
        <!-- Slides Container -->
        <div class="relative min-h-[600px] lg:min-h-[700px]">
            <template x-for="(slide, index) in slides" :key="index">
                <div
                    x-show="currentSlide === index"
                    x-transition:enter="transition ease-out duration-700"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    x-transition:leave="transition ease-in duration-700"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    class="absolute inset-0"
                    style="display: none;"
                >
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full">
                        <div class="grid lg:grid-cols-2 gap-12 items-center h-full py-20 lg:py-32">

                            <!-- Text Content -->
                            <div class="text-center lg:text-left space-y-8">
                                <div class="space-y-4">
                                    <h1
                                        class="text-4xl sm:text-5xl lg:text-6xl font-bold text-gray-900 dark:text-white leading-tight"
                                        x-text="slide.title"
                                    ></h1>
                                    <p
                                        class="text-xl sm:text-2xl text-gray-600 dark:text-gray-300"
                                        x-text="slide.subtitle"
                                    ></p>
                                </div>

                                <!-- Quick Stats -->
                                <div class="flex flex-wrap justify-center lg:justify-start gap-6 lg:gap-8 text-center lg:text-left">
                                    <div>
                                        <div class="text-3xl font-bold text-green-600">5,000+</div>
                                        <div class="text-sm text-gray-600 dark:text-gray-400">Students</div>
                                    </div>
                                    <div>
                                        <div class="text-3xl font-bold text-green-600">50+</div>
                                        <div class="text-sm text-gray-600 dark:text-gray-400">Courses</div>
                                    </div>
                                    <div>
                                        <div class="text-3xl font-bold text-green-600">20+</div>
                                        <div class="text-sm text-gray-600 dark:text-gray-400">Topics</div>
                                    </div>
                                    <div>
                                        <div class="text-3xl font-bold text-green-600">15</div>
                                        <div class="text-sm text-gray-600 dark:text-gray-400">Countries</div>
                                    </div>
                                </div>

                                <!-- CTA Buttons -->
                                <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                                    <a
                                        href="#all-courses"
                                        class="px-8 py-4 bg-green-600 text-white text-lg font-semibold rounded-lg hover:bg-green-700 shadow-xl hover:shadow-2xl inline-flex items-center justify-center"
                                        x-text="slide.cta1"
                                    ></a>
                                    <a
                                        href="#demo"
                                        class="px-8 py-4 bg-white dark:bg-gray-800 text-gray-900 dark:text-white text-lg font-semibold rounded-lg border-2 border-gray-300 dark:border-gray-600 hover:border-green-600 inline-flex items-center justify-center gap-2"
                                    >
                                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z"/>
                                        </svg>
                                        <span x-text="slide.cta2"></span>
                                    </a>
                                </div>
                            </div>

                            <!-- Image -->
                            <img
                                :src="slide.image"
                                :alt="slide.title"
                                class="w-full h-auto"
                            />

                        </div>
                    </div>
                </div>
            </template>
        </div>

        <!-- Navigation Dots -->
        <div class="absolute bottom-8 left-0 right-0 flex justify-center gap-3 z-10">
            <template x-for="(slide, index) in slides" :key="index">
                <button
                    @click="goToSlide(index)"
                    :class="currentSlide === index ? 'bg-green-600 w-12' : 'bg-white/50 w-3'"
                    class="h-3 rounded-full transition-all duration-300 hover:bg-green-500"
                ></button>
            </template>
        </div>

        <!-- Decorative Wave -->
        <div class="absolute bottom-0 left-0 right-0">
            <svg class="w-full h-16 fill-white dark:fill-gray-900" viewBox="0 0 1440 48" xmlns="http://www.w3.org/2000/svg">
                <path d="M0,32L60,29.3C120,27,240,21,360,21.3C480,21,600,27,720,32C840,37,960,43,1080,42.7C1200,43,1320,37,1380,34.7L1440,32L1440,48L1380,48C1320,48,1200,48,1080,48C960,48,840,48,720,48C600,48,480,48,360,48C240,48,120,48,60,48L0,48Z"></path>
            </svg>
        </div>

    </div>
</section>
