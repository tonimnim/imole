<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\TeacherDashboardController;
use App\Http\Controllers\StudentDashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Main dashboard route - redirects based on role
Route::get('/dashboard', function () {
    if (auth()->user()->hasRole('admin')) {
        return redirect()->route('admin.dashboard');
    } elseif (auth()->user()->hasRole('teacher')) {
        return redirect()->route('teacher.dashboard');
    } else {
        return redirect()->route('student.dashboard');
    }
})->middleware(['auth', 'verified'])->name('dashboard');

// Role-specific dashboard routes
Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
});

Route::middleware(['auth', 'verified', 'role:teacher'])->group(function () {
    Route::get('/teacher/dashboard', [TeacherDashboardController::class, 'index'])->name('teacher.dashboard');
});

Route::middleware(['auth', 'verified', 'role:student'])->group(function () {
    Route::get('/student/dashboard', [StudentDashboardController::class, 'index'])->name('student.dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
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

Route::resource('comments', App\Http\Controllers\CommentController::class)->only('store');

Route::get('payments/verify', [App\Http\Controllers\PaymentController::class, 'verify']);
Route::get('payments/webhook', [App\Http\Controllers\PaymentController::class, 'webhook']);
Route::resource('payments', App\Http\Controllers\PaymentController::class)->only('store', 'show');

Route::resource('wishlists', App\Http\Controllers\WishlistController::class)->only('store', 'destroy');

Route::resource('categories', App\Http\Controllers\Admin\CategoryController::class)->except('create', 'edit', 'show');


Route::resource('courses', App\Http\Controllers\CourseController::class)->except('create', 'edit');

Route::resource('lessons', App\Http\Controllers\LessonController::class)->except('create', 'edit', 'destroy');

Route::resource('enrollments', App\Http\Controllers\EnrollmentController::class)->only('store', 'show');

Route::resource('lesson-progresses', App\Http\Controllers\LessonProgressController::class)->only('update');

Route::resource('quizzes', App\Http\Controllers\QuizController::class)->only('show', 'store');

Route::resource('quiz-attempts', App\Http\Controllers\QuizAttemptController::class)->only('store', 'update');

Route::resource('assignments', App\Http\Controllers\AssignmentController::class)->only('show', 'store');

Route::resource('assignment-submissions', App\Http\Controllers\AssignmentSubmissionController::class)->only('store', 'update');

Route::resource('reviews', App\Http\Controllers\ReviewController::class)->only('store');

Route::resource('comments', App\Http\Controllers\CommentController::class)->only('store');

Route::get('payments/verify', [App\Http\Controllers\PaymentController::class, 'verify']);
Route::get('payments/webhook', [App\Http\Controllers\PaymentController::class, 'webhook']);
Route::resource('payments', App\Http\Controllers\PaymentController::class)->only('store', 'show');

Route::resource('wishlists', App\Http\Controllers\WishlistController::class)->only('store', 'destroy');

Route::resource('categories', App\Http\Controllers\Admin\CategoryController::class)->except('create', 'edit', 'show');
