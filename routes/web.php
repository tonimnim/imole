<?php

use App\Http\Controllers\Auth\TeacherRegistrationController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $featuredCourses = \App\Models\Course::query()
        ->where('is_published', true)
        ->where('is_featured', true)
        ->with(['category', 'instructor'])
        ->withCount(['enrollments', 'reviews'])
        ->withAvg('reviews', 'rating')
        ->orderBy('enrollments_count', 'desc')
        ->take(8)
        ->get()
        ->map(function ($course) {
            $course->students_count = $course->enrollments_count;
            $course->average_rating = $course->reviews_avg_rating ?? 0;

            return $course;
        });

    $categories = \App\Models\Category::query()
        ->where('is_active', true)
        ->whereNull('parent_id')
        ->orderBy('order')
        ->take(6)
        ->get();

    return view('welcome', compact('featuredCourses', 'categories'));
})->name('home');

Route::get('/teaching', function () {
    return view('teaching');
})->name('teaching');

// Main dashboard route - redirects based on role
Route::get('/dashboard', function () {
    if (auth()->user()->hasRole('admin')) {
        return redirect('/admin');
    } elseif (auth()->user()->hasRole('teacher')) {
        return redirect('/teacher');
    } else {
        return redirect()->route('student.dashboard');
    }
})->middleware('auth')->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Student Portal Routes
    Route::prefix('student')->name('student.')->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\Student\StudentDashboardController::class, 'dashboard'])->name('dashboard');
        Route::get('/my-courses', [App\Http\Controllers\Student\StudentDashboardController::class, 'myCourses'])->name('my-courses');
        Route::get('/certificates', [App\Http\Controllers\Student\StudentDashboardController::class, 'certificates'])->name('certificates');
        Route::get('/wishlist', [App\Http\Controllers\Student\WishlistController::class, 'index'])->name('wishlist');
    });

    // Course Learning Routes
    Route::prefix('learn')->name('student.learn.')->group(function () {
        Route::get('/{course:slug}/start', [App\Http\Controllers\Student\CourseLearningController::class, 'start'])->name('start');
        Route::get('/{course:slug}/completed', [App\Http\Controllers\Student\CourseLearningController::class, 'completed'])->name('completed');
        Route::get('/{course:slug}/{lesson:slug}', [App\Http\Controllers\Student\CourseLearningController::class, 'lesson'])->name('lesson');
        Route::post('/{course:slug}/{lesson:slug}/complete', [App\Http\Controllers\Student\CourseLearningController::class, 'completeLesson'])->name('complete');
        Route::post('/{course:slug}/{lesson:slug}/progress', [App\Http\Controllers\Student\CourseLearningController::class, 'updateProgress'])->name('progress');
        Route::post('/{course:slug}/{lesson:slug}/notes', [App\Http\Controllers\Student\CourseLearningController::class, 'saveNote'])->name('notes.save');
        Route::delete('/{course:slug}/{lesson:slug}/notes/{note}', [App\Http\Controllers\Student\CourseLearningController::class, 'deleteNote'])->name('notes.delete');
    });

    // Certificate Routes
    Route::get('/certificate/{certificate}', function (\App\Models\Certificate $certificate) {
        if ($certificate->user_id !== auth()->id()) {
            abort(403);
        }

        return view('student.certificate', compact('certificate'));
    })->middleware('auth')->name('certificate.view');

    Route::get('/certificate/{certificate}/download', function (\App\Models\Certificate $certificate) {
        if ($certificate->user_id !== auth()->id()) {
            abort(403);
        }

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('student.certificate-pdf', compact('certificate'))
            ->setPaper('a4', 'landscape')
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isRemoteEnabled', true);

        return $pdf->download('certificate-'.$certificate->certificate_number.'.pdf');
    })->middleware('auth')->name('certificate.download');

    // Cart Routes
    Route::get('/cart', [App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
    Route::post('/cart', [App\Http\Controllers\CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/apply-coupon', [App\Http\Controllers\CartController::class, 'applyCoupon'])->name('cart.apply-coupon');
    Route::delete('/cart/{cart}', [App\Http\Controllers\CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/cart', [App\Http\Controllers\CartController::class, 'clear'])->name('cart.clear');

    // Checkout Routes
    Route::get('/checkout', [App\Http\Controllers\CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/process', [App\Http\Controllers\CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/checkout/success/{order}', [App\Http\Controllers\CheckoutController::class, 'success'])->name('checkout.success');
    Route::get('/checkout/failed/{order}', [App\Http\Controllers\CheckoutController::class, 'failed'])->name('checkout.failed');

    // Teacher Curriculum Builder
    Route::get('/teacher/courses/{course}/curriculum', [App\Http\Controllers\Teacher\CurriculumPageController::class, 'show'])
        ->name('teacher.curriculum');

    // Teacher Quiz Builder
    Route::get('/teacher/quiz-builder', [App\Http\Controllers\Teacher\QuizBuilderPageController::class, 'index'])
        ->name('teacher.quiz-builder');
});

Route::middleware('guest')->group(function () {
    Route::get('teacher/register', [TeacherRegistrationController::class, 'create'])->name('teacher.register');
    // {{ ... }}
    Route::post('teacher/register', [TeacherRegistrationController::class, 'store'])->name('teacher.register.store');
});

require __DIR__.'/auth.php';

Route::resource('courses', App\Http\Controllers\CourseController::class)->except('create', 'edit');

Route::resource('lessons', App\Http\Controllers\LessonController::class)->except('create', 'edit', 'destroy');

Route::resource('enrollments', App\Http\Controllers\EnrollmentController::class)->only('store', 'show');

Route::resource('lesson-progresses', App\Http\Controllers\LessonProgressController::class)->only('update');

Route::resource('quizzes', App\Http\Controllers\QuizController::class)->only('show', 'store');

Route::resource('quiz-attempts', App\Http\Controllers\QuizAttemptController::class)->only('store', 'update');

Route::resource('assignments', App\Http\Controllers\AssignmentController::class)->only('show', 'store');

Route::resource('assignment-submissions', App\Http\Controllers\AssignmentSubmissionController::class)->only('store', 'update');

Route::resource('reviews', App\Http\Controllers\ReviewController::class)->only('store');
Route::post('reviews/{review}/helpful', [App\Http\Controllers\ReviewController::class, 'markHelpful'])
    ->middleware('auth')
    ->name('reviews.helpful');

Route::resource('comments', App\Http\Controllers\CommentController::class)->only('store');

Route::get('payments/verify', [App\Http\Controllers\PaymentController::class, 'verify']);
Route::get('payments/webhook', [App\Http\Controllers\PaymentController::class, 'webhook']);
Route::resource('payments', App\Http\Controllers\PaymentController::class)->only('store', 'show');

Route::resource('wishlists', App\Http\Controllers\Student\WishlistController::class)->only('store', 'destroy');

Route::resource('categories', App\Http\Controllers\Admin\CategoryController::class)->except('create', 'edit', 'show');
