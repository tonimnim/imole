<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Inertia\Inertia;
use Inertia\Response;

class TeacherQuestionsController extends Controller
{
    public function index(): Response
    {
        $user = auth()->user();

        $questions = Question::whereHas('quiz.course', fn ($q) => $q->where('instructor_id', $user->id))
            ->with(['quiz:id,title', 'quiz.course:id,title'])
            ->latest()
            ->get()
            ->map(fn ($q) => [
                'id' => $q->id,
                'question' => $q->question,
                'type' => $q->type,
                'quiz' => $q->quiz->title,
                'quizId' => $q->quiz->id,
                'course' => $q->quiz->course->title,
                'points' => $q->points,
                'createdAt' => $q->created_at->format('M d, Y'),
            ]);

        // Group by type for stats
        $stats = [
            'total' => $questions->count(),
            'multipleChoice' => $questions->where('type', 'multiple_choice')->count(),
            'trueFalse' => $questions->where('type', 'true_false')->count(),
            'shortAnswer' => $questions->where('type', 'short_answer')->count(),
        ];

        return Inertia::render('Teacher/Questions/Index', [
            'questions' => $questions,
            'stats' => $stats,
        ]);
    }
}
