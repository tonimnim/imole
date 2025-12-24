<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Course Completed - {{ $course->title }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
</head>
<body class="bg-gray-950 text-white">
    <!-- Confetti will appear here -->
    <canvas id="confetti-canvas" class="fixed inset-0 pointer-events-none z-50"></canvas>

    <div class="min-h-screen py-12 px-4">
        <div class="max-w-6xl mx-auto">
            <!-- Celebration Header -->
            <div class="text-center mb-12">
                <div class="inline-block mb-6">
                    <div class="w-24 h-24 bg-gradient-to-r from-purple-600 to-pink-600 rounded-full flex items-center justify-center mx-auto animate-bounce">
                        <svg class="w-12 h-12 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                            <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm9.707 5.707a1 1 0 00-1.414-1.414L9 12.586l-1.293-1.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                </div>
                <h1 class="text-4xl md:text-5xl font-bold mb-4 bg-gradient-to-r from-purple-400 to-pink-400 bg-clip-text text-transparent">
                    Congratulations! 🎉
                </h1>
                <p class="text-xl text-gray-300 mb-2">You've successfully completed</p>
                <h2 class="text-2xl md:text-3xl font-bold text-white">{{ $course->title }}</h2>
                <p class="text-gray-400 mt-4">Completed on {{ $enrollment->completed_at->format('F j, Y') }}</p>
            </div>

            <!-- Certificate Section -->
            @if($certificate)
                <div class="bg-gradient-to-r from-purple-900/30 to-pink-900/30 border-2 border-purple-600 rounded-xl p-8 mb-12">
                    <div class="flex flex-col md:flex-row items-center gap-6">
                        <div class="flex-shrink-0">
                            <div class="w-24 h-24 bg-gradient-to-br from-purple-600 to-pink-600 rounded-full flex items-center justify-center">
                                <svg class="w-12 h-12 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                                    <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm9.707 5.707a1 1 0 00-1.414-1.414L9 12.586l-1.293-1.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1 text-center md:text-left">
                            <h3 class="text-2xl font-bold text-white mb-2">Your Certificate is Ready! 🎓</h3>
                            <p class="text-purple-200 mb-4">Certificate #{{ $certificate->certificate_number }}</p>
                            <p class="text-gray-300 text-sm">Download and share your achievement with the world</p>
                        </div>
                        <div class="flex-shrink-0">
                            <a href="{{ route('certificate.view', $certificate) }}" target="_blank" class="inline-flex items-center gap-2 px-8 py-4 bg-white hover:bg-gray-100 text-purple-600 font-bold rounded-lg transition shadow-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                View Certificate
                            </a>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Course Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-12">
                <div class="bg-gray-900 rounded-xl p-6 text-center border border-gray-800">
                    <div class="text-3xl font-bold text-purple-400 mb-2">{{ $totalLessons }}</div>
                    <div class="text-sm text-gray-400">Lessons Completed</div>
                </div>
                <div class="bg-gray-900 rounded-xl p-6 text-center border border-gray-800">
                    <div class="text-3xl font-bold text-blue-400 mb-2">{{ gmdate('H:i', $courseDuration) }}</div>
                    <div class="text-sm text-gray-400">Course Duration</div>
                </div>
                <div class="bg-gray-900 rounded-xl p-6 text-center border border-gray-800">
                    <div class="text-3xl font-bold text-green-400 mb-2">{{ gmdate('H:i', $actualTimeSpent) }}</div>
                    <div class="text-sm text-gray-400">Time Spent Learning</div>
                </div>
                <div class="bg-gray-900 rounded-xl p-6 text-center border border-gray-800">
                    <div class="text-3xl font-bold text-indigo-400 mb-2">{{ $quizzesTaken }}</div>
                    <div class="text-sm text-gray-400">Quizzes Taken</div>
                </div>
                <div class="bg-gray-900 rounded-xl p-6 text-center border border-gray-800">
                    <div class="text-3xl font-bold text-yellow-400 mb-2">{{ number_format($averageQuizScore, 1) }}%</div>
                    <div class="text-sm text-gray-400">Avg Quiz Score</div>
                </div>
            </div>

            <!-- Review Form -->
            @if(!$existingReview)
                <div class="bg-gray-900 rounded-xl p-8 mb-12 border border-gray-800">
                    <h3 class="text-2xl font-bold mb-4">Share Your Experience</h3>
                    <p class="text-gray-400 mb-6">Help other students by sharing your thoughts about this course</p>

                    <form action="{{ route('reviews.store') }}" method="POST" id="review-form">
                        @csrf
                        <input type="hidden" name="course_id" value="{{ $course->id }}">

                        <!-- Star Rating -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium mb-3">Your Rating</label>
                            <div class="flex gap-2" id="star-rating">
                                @for($i = 1; $i <= 5; $i++)
                                    <button type="button" onclick="setRating({{ $i }})" class="star-btn text-4xl text-gray-600 hover:text-yellow-400 transition">
                                        ★
                                    </button>
                                @endfor
                            </div>
                            <input type="hidden" name="rating" id="rating-input" required>
                        </div>

                        <!-- Review Text -->
                        <div class="mb-6">
                            <label for="review-content" class="block text-sm font-medium mb-3">Your Review</label>
                            <textarea
                                id="review-content"
                                name="content"
                                rows="4"
                                required
                                class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white focus:ring-2 focus:ring-purple-600 focus:border-transparent"
                                placeholder="What did you think of this course?"></textarea>
                        </div>

                        <button type="submit" class="px-8 py-3 bg-purple-600 hover:bg-purple-700 rounded-lg font-medium transition">
                            Submit Review
                        </button>
                    </form>
                </div>
            @else
                <div class="bg-gray-900 rounded-xl p-8 mb-12 border border-green-800">
                    <h3 class="text-2xl font-bold mb-4 text-green-400">✓ Review Submitted</h3>
                    <p class="text-gray-400">Thank you for your feedback!</p>
                    <div class="mt-4 p-4 bg-gray-800 rounded-lg">
                        <div class="flex items-center gap-2 mb-2">
                            <div class="text-yellow-400">
                                @for($i = 1; $i <= 5; $i++)
                                    <span class="{{ $i <= $existingReview->rating ? 'text-yellow-400' : 'text-gray-600' }}">★</span>
                                @endfor
                            </div>
                            <span class="text-sm text-gray-400">{{ $existingReview->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-gray-300">{{ $existingReview->content }}</p>
                    </div>
                </div>
            @endif

            <!-- Share Options -->
            <div class="bg-gray-900 rounded-xl p-8 mb-12 border border-gray-800">
                <h3 class="text-2xl font-bold mb-4">Share Your Achievement</h3>
                <p class="text-gray-400 mb-6">Let your network know about your accomplishment!</p>
                <div class="flex flex-wrap gap-4">
                    <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(route('courses.show', $course)) }}&title={{ urlencode('I just completed ' . $course->title) }}"
                       target="_blank"
                       class="flex items-center gap-2 px-6 py-3 bg-blue-600 hover:bg-blue-700 rounded-lg font-medium transition">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M19 3a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14m-.5 15.5v-5.3a3.26 3.26 0 0 0-3.26-3.26c-.85 0-1.84.52-2.32 1.3v-1.11h-2.79v8.37h2.79v-4.93c0-.77.62-1.4 1.39-1.4a1.4 1.4 0 0 1 1.4 1.4v4.93h2.79M6.88 8.56a1.68 1.68 0 0 0 1.68-1.68c0-.93-.75-1.69-1.68-1.69a1.69 1.69 0 0 0-1.69 1.69c0 .93.76 1.68 1.69 1.68m1.39 9.94v-8.37H5.5v8.37h2.77z"/>
                        </svg>
                        Share on LinkedIn
                    </a>
                    <a href="https://twitter.com/intent/tweet?text={{ urlencode('I just completed ' . $course->title . '!') }}&url={{ urlencode(route('courses.show', $course)) }}"
                       target="_blank"
                       class="flex items-center gap-2 px-6 py-3 bg-gray-800 hover:bg-gray-700 rounded-lg font-medium transition border border-gray-700">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                        </svg>
                        Share on Twitter
                    </a>
                </div>
            </div>

            <!-- Related Courses -->
            @if($relatedCourses->count() > 0)
                <div class="mb-12">
                    <h3 class="text-2xl font-bold mb-6">Continue Your Learning Journey</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @foreach($relatedCourses as $related)
                            <a href="{{ route('courses.show', $related) }}" class="bg-gray-900 rounded-xl overflow-hidden border border-gray-800 hover:border-purple-600 transition group">
                                <img src="{{ $related->thumbnail }}" alt="{{ $related->title }}" class="w-full aspect-video object-cover">
                                <div class="p-4">
                                    <h4 class="font-bold mb-2 group-hover:text-purple-400 transition">{{ $related->title }}</h4>
                                    <p class="text-sm text-gray-400 mb-3">By {{ $related->instructor->name }}</p>
                                    <div class="flex items-center justify-between text-sm">
                                        <div class="flex items-center gap-1">
                                            <span class="text-yellow-400">★</span>
                                            <span>{{ number_format($related->average_rating, 1) }}</span>
                                        </div>
                                        <span class="text-gray-400">{{ number_format($related->students_count) }} students</span>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Action Buttons -->
            <div class="flex flex-wrap gap-4 justify-center">
                <a href="{{ route('student.my-courses') }}" class="px-8 py-3 bg-purple-600 hover:bg-purple-700 rounded-lg font-medium transition">
                    View My Courses
                </a>
                <a href="{{ route('courses.index') }}" class="px-8 py-3 bg-gray-800 hover:bg-gray-700 rounded-lg font-medium transition border border-gray-700">
                    Browse More Courses
                </a>
            </div>
        </div>
    </div>

    <script>
        // Confetti Animation
        const duration = 5 * 1000;
        const animationEnd = Date.now() + duration;
        const defaults = { startVelocity: 30, spread: 360, ticks: 60, zIndex: 0 };

        function randomInRange(min, max) {
            return Math.random() * (max - min) + min;
        }

        const interval = setInterval(function() {
            const timeLeft = animationEnd - Date.now();

            if (timeLeft <= 0) {
                return clearInterval(interval);
            }

            const particleCount = 50 * (timeLeft / duration);

            confetti({
                ...defaults,
                particleCount,
                origin: { x: randomInRange(0.1, 0.3), y: Math.random() - 0.2 }
            });
            confetti({
                ...defaults,
                particleCount,
                origin: { x: randomInRange(0.7, 0.9), y: Math.random() - 0.2 }
            });
        }, 250);

        // Star Rating
        let selectedRating = 0;

        function setRating(rating) {
            selectedRating = rating;
            document.getElementById('rating-input').value = rating;

            const stars = document.querySelectorAll('.star-btn');
            stars.forEach((star, index) => {
                if (index < rating) {
                    star.classList.remove('text-gray-600');
                    star.classList.add('text-yellow-400');
                } else {
                    star.classList.remove('text-yellow-400');
                    star.classList.add('text-gray-600');
                }
            });
        }

        // Review Form Validation
        document.getElementById('review-form')?.addEventListener('submit', function(e) {
            if (selectedRating === 0) {
                e.preventDefault();
                alert('Please select a rating');
            }
        });
    </script>
</body>
</html>
