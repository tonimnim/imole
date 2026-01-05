<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use Inertia\Inertia;
use Inertia\Response;

class TeacherQuizzesController extends Controller
{
    public function index(): Response
    {
        $user = auth()->user();

        $quizzes = Quiz::whereHas('course', fn ($q) => $q->where('instructor_id', $user->id))
            ->with(['course:id,title,slug', 'lesson:id,title'])
            ->withCount(['questions', 'quizAttempts'])
            ->latest()
            ->get()
            ->map(fn ($q) => [
                'id' => $q->id,
                'title' => $q->title,
                'course' => $q->course->title,
                'courseId' => $q->course->id,
                'lesson' => $q->lesson?->title ?? 'Standalone',
                'questionsCount' => $q->questions_count,
                'attemptsCount' => $q->quiz_attempts_count,
                'passingScore' => $q->passing_score,
                'timeLimit' => $q->time_limit_minutes,
                'isPublished' => $q->is_published,
                'createdAt' => $q->created_at->format('M d, Y'),
            ]);

        // Get recent attempts for review
        $recentAttempts = QuizAttempt::whereHas('quiz.course', fn ($q) => $q->where('instructor_id', $user->id))
            ->with(['quiz:id,title,passing_score', 'user:id,name,email'])
            ->latest()
            ->take(10)
            ->get()
            ->map(fn ($a) => [
                'id' => $a->id,
                'quiz' => $a->quiz->title,
                'quizId' => $a->quiz->id,
                'student' => $a->user->name,
                'score' => $a->score,
                'passingScore' => $a->quiz->passing_score,
                'passed' => $a->passed,
                'completedAt' => $a->completed_at?->diffForHumans() ?? 'In Progress',
            ]);

        return Inertia::render('Teacher/Quizzes/Index', [
            'quizzes' => $quizzes,
            'recentAttempts' => $recentAttempts,
        ]);
    }
}
