<?php

use App\Http\Controllers\Api\CurriculumController;
use App\Http\Controllers\Api\QuizBuilderController;
use App\Http\Controllers\Api\StudentHomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['web', 'auth'])->group(function () {
    // Curriculum Builder API
    Route::prefix('courses/{course}')->group(function () {
        Route::get('curriculum', [CurriculumController::class, 'index']);
        Route::post('modules', [CurriculumController::class, 'storeModule']);
        Route::post('curriculum/reorder', [CurriculumController::class, 'reorder']);
        Route::get('quiz-lessons', [QuizBuilderController::class, 'getQuizLessons']);
    });

    Route::prefix('modules/{module}')->group(function () {
        Route::put('/', [CurriculumController::class, 'updateModule']);
        Route::delete('/', [CurriculumController::class, 'destroyModule']);
        Route::post('lessons', [CurriculumController::class, 'storeLesson']);
    });

    Route::prefix('lessons/{lesson}')->group(function () {
        Route::put('/', [CurriculumController::class, 'updateLesson']);
        Route::delete('/', [CurriculumController::class, 'destroyLesson']);
    });

    // Quiz Builder API
    Route::get('teacher/courses', [QuizBuilderController::class, 'getCourses']);
    Route::get('quizzes', [QuizBuilderController::class, 'index']);
    Route::post('quizzes', [QuizBuilderController::class, 'store']);

    Route::prefix('quizzes/{quiz}')->group(function () {
        Route::get('/', [QuizBuilderController::class, 'show']);
        Route::put('/', [QuizBuilderController::class, 'update']);
        Route::delete('/', [QuizBuilderController::class, 'destroy']);
        Route::post('questions', [QuizBuilderController::class, 'storeQuestion']);
        Route::post('questions/reorder', [QuizBuilderController::class, 'reorderQuestions']);
    });

    Route::prefix('questions/{question}')->group(function () {
        Route::put('/', [QuizBuilderController::class, 'updateQuestion']);
        Route::delete('/', [QuizBuilderController::class, 'destroyQuestion']);
    });

    // Student Home API
    Route::prefix('student')->group(function () {
        Route::get('categories', [StudentHomeController::class, 'categories']);
        Route::get('courses', [StudentHomeController::class, 'courses']);
    });
});
