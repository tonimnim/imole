<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Teacher\TeacherDashboardController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Static Pages
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/programs', [PageController::class, 'programs'])->name('programs');
Route::get('/impact', [PageController::class, 'impact'])->name('impact');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact', [PageController::class, 'submitContact'])->name('contact.submit');

// Legal Pages
Route::get('/privacy', [PageController::class, 'privacy'])->name('privacy');
Route::get('/terms', [PageController::class, 'terms'])->name('terms');
Route::get('/cookies', [PageController::class, 'cookies'])->name('cookies');
Route::get('/accessibility', [PageController::class, 'accessibility'])->name('accessibility');

use App\Http\Controllers\Auth\TeacherAuthController;

Route::middleware('guest')->group(function () {
    Route::get('teacher/register', [TeacherAuthController::class, 'create'])->name('teacher.register');
    Route::post('teacher/register', [TeacherAuthController::class, 'store']);

    Route::get('teacher/login', [TeacherAuthController::class, 'createLogin'])->name('teacher.login');
    Route::post('teacher/login', [TeacherAuthController::class, 'storeLogin']);
});

Route::middleware(['auth', 'verified'])->group(function () {
    // Teacher Portal Routes (Inertia + React)
    Route::prefix('teacher')->name('teacher.')->group(function () {

        // Dashboard
        Route::get('/dashboard', [\App\Http\Controllers\Teacher\TeacherDashboardController::class, 'index'])
            ->name('dashboard'); // Result: route('teacher.dashboard')

        // Redirect /teacher to /teacher/dashboard
        Route::get('/', function () {
            return redirect()->route('teacher.dashboard');
        });

    });

    // Old Teacher Dashboard (Commented out for reference or deletion)
    // Route::get('/teacher', [TeacherDashboardController::class, 'index'])->name('teacher.dashboard.old');

    // Teacher Courses (Vue.js)

    // Teacher Courses (Vue.js)
    Route::get('/teacher/courses', [App\Http\Controllers\Teacher\TeacherCoursesController::class, 'index'])
        ->name('teacher.courses');
    Route::get('/teacher/courses/create', [App\Http\Controllers\Teacher\TeacherCourseFormController::class, 'create'])
        ->name('teacher.courses.create');
    Route::post('/teacher/courses', [App\Http\Controllers\Teacher\TeacherCourseFormController::class, 'store'])
        ->name('teacher.courses.store');
    Route::get('/teacher/courses/{course:id}/edit', [App\Http\Controllers\Teacher\TeacherCourseFormController::class, 'edit'])
        ->name('teacher.courses.edit');
    Route::put('/teacher/courses/{course:id}', [App\Http\Controllers\Teacher\TeacherCourseFormController::class, 'update'])
        ->name('teacher.courses.update');

    // Teacher Curriculum Builder
    Route::get('/teacher/courses/{course:id}/curriculum', [App\Http\Controllers\Teacher\CurriculumPageController::class, 'show'])
        ->name('teacher.curriculum');

    // Teacher Content Management Pages
    Route::get('/teacher/modules', [App\Http\Controllers\Teacher\TeacherModulesController::class, 'index'])
        ->name('teacher.modules');
    Route::get('/teacher/lessons', [App\Http\Controllers\Teacher\TeacherLessonsController::class, 'index'])
        ->name('teacher.lessons');
    Route::get('/teacher/assignments', [App\Http\Controllers\Teacher\TeacherAssignmentsController::class, 'index'])
        ->name('teacher.assignments');
    Route::get('/teacher/quizzes', [App\Http\Controllers\Teacher\TeacherQuizzesController::class, 'index'])
        ->name('teacher.quizzes');
    Route::get('/teacher/questions', [App\Http\Controllers\Teacher\TeacherQuestionsController::class, 'index'])
        ->name('teacher.questions');

    // Teacher Student & Engagement Pages
    Route::get('/teacher/students', [App\Http\Controllers\Teacher\TeacherStudentsController::class, 'index'])
        ->name('teacher.students');
    Route::get('/teacher/reviews', [App\Http\Controllers\Teacher\TeacherReviewsController::class, 'index'])
        ->name('teacher.reviews');

    // Teacher Announcements (CRUD)
    Route::get('/teacher/announcements', [App\Http\Controllers\Teacher\TeacherAnnouncementsController::class, 'index'])
        ->name('teacher.announcements');
    Route::post('/teacher/announcements', [App\Http\Controllers\Teacher\TeacherAnnouncementsController::class, 'store'])
        ->name('teacher.announcements.store');
    Route::put('/teacher/announcements/{announcement}', [App\Http\Controllers\Teacher\TeacherAnnouncementsController::class, 'update'])
        ->name('teacher.announcements.update');
    Route::delete('/teacher/announcements/{announcement}', [App\Http\Controllers\Teacher\TeacherAnnouncementsController::class, 'destroy'])
        ->name('teacher.announcements.destroy');

    // Teacher Certificates
    Route::get('/teacher/certificates', [App\Http\Controllers\Teacher\TeacherCertificatesController::class, 'index'])
        ->name('teacher.certificates');

    // Teacher Profile
    Route::get('/teacher/profile', [App\Http\Controllers\Teacher\TeacherProfileController::class, 'index'])
        ->name('teacher.profile');
    Route::put('/teacher/profile', [App\Http\Controllers\Teacher\TeacherProfileController::class, 'update'])
        ->name('teacher.profile.update');
    Route::post('/teacher/profile/avatar', [App\Http\Controllers\Teacher\TeacherProfileController::class, 'updateAvatar'])
        ->name('teacher.profile.avatar');
    Route::delete('/teacher/profile/avatar', [App\Http\Controllers\Teacher\TeacherProfileController::class, 'removeAvatar'])
        ->name('teacher.profile.avatar.remove');

    // Teacher Quiz Builder
    Route::get('/teacher/quiz-builder', [App\Http\Controllers\Teacher\QuizBuilderPageController::class, 'index'])
        ->name('teacher.quiz-builder');

    // --- RESTORED STUDENT ROUTES ---
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
});

// Main dashboard route - redirects based on role
Route::get('/dashboard', function () {
    /** @var \App\Models\User $user */
    $user = auth()->user();

    if ($user->hasRole('admin')) {
        return redirect('/admin');
    } elseif ($user->hasRole('teacher')) {
        return redirect()->route('teacher.dashboard');
    } else {
        return redirect()->route('student.dashboard');
    }
})->middleware('auth')->name('dashboard');

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
