<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class QuizBuilderController extends Controller
{
    /**
     * Get all quizzes for the teacher's courses.
     */
    public function index(): JsonResponse
    {
        $quizzes = Quiz::whereHas('course', function ($query) {
            $query->where('instructor_id', auth()->id());
        })
            ->with(['course:id,title', 'lesson:id,title', 'questions'])
            ->withCount('questions')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($quizzes);
    }

    /**
     * Get a single quiz with questions.
     */
    public function show(Quiz $quiz): JsonResponse
    {
        $this->authorizeQuiz($quiz);

        $quiz->load(['course:id,title,slug', 'lesson:id,title', 'questions' => function ($q) {
            $q->orderBy('order');
        }]);

        return response()->json($quiz);
    }

    /**
     * Store a new quiz.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'lesson_id' => 'required|exists:lessons,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration_minutes' => 'nullable|integer|min:1',
            'passing_score' => 'required|integer|min:0|max:100',
            'max_attempts' => 'required|integer|min:1',
            'shuffle_questions' => 'boolean',
            'show_correct_answers' => 'boolean',
            'is_published' => 'boolean',
        ]);

        // Get the lesson and verify ownership
        $lesson = Lesson::with('course')->findOrFail($validated['lesson_id']);

        if ($lesson->course->instructor_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        if ($lesson->type !== 'quiz') {
            return response()->json(['message' => 'Lesson must be of type quiz'], 422);
        }

        $quiz = Quiz::create([
            'course_id' => $lesson->course_id,
            'lesson_id' => $validated['lesson_id'],
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'duration_minutes' => $validated['duration_minutes'] ?? null,
            'passing_score' => $validated['passing_score'],
            'max_attempts' => $validated['max_attempts'],
            'shuffle_questions' => $validated['shuffle_questions'] ?? false,
            'show_correct_answers' => $validated['show_correct_answers'] ?? true,
            'is_published' => $validated['is_published'] ?? false,
            'order' => Quiz::where('lesson_id', $validated['lesson_id'])->max('order') + 1,
        ]);

        return response()->json($quiz->load('questions'), 201);
    }

    /**
     * Update a quiz.
     */
    public function update(Request $request, Quiz $quiz): JsonResponse
    {
        $this->authorizeQuiz($quiz);

        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'duration_minutes' => 'nullable|integer|min:1',
            'passing_score' => 'sometimes|required|integer|min:0|max:100',
            'max_attempts' => 'sometimes|required|integer|min:1',
            'shuffle_questions' => 'boolean',
            'show_correct_answers' => 'boolean',
            'is_published' => 'boolean',
        ]);

        $quiz->update($validated);

        return response()->json($quiz);
    }

    /**
     * Delete a quiz.
     */
    public function destroy(Quiz $quiz): JsonResponse
    {
        $this->authorizeQuiz($quiz);

        $quiz->questions()->delete();
        $quiz->delete();

        return response()->json(['message' => 'Quiz deleted']);
    }

    /**
     * Store a new question.
     */
    public function storeQuestion(Request $request, Quiz $quiz): JsonResponse
    {
        $this->authorizeQuiz($quiz);

        $validated = $request->validate([
            'question_text' => 'required|string',
            'question_type' => 'required|in:multiple_choice,true_false,short_answer',
            'options' => 'nullable|array',
            'options.*' => 'string',
            'correct_answer' => 'required|string',
            'explanation' => 'nullable|string',
            'points' => 'required|integer|min:1',
        ]);

        $maxOrder = $quiz->questions()->max('order') ?? 0;

        $question = $quiz->questions()->create([
            'question_text' => $validated['question_text'],
            'question_type' => $validated['question_type'],
            'options' => $validated['options'] ?? [],
            'correct_answer' => $validated['correct_answer'],
            'explanation' => $validated['explanation'] ?? null,
            'points' => $validated['points'],
            'order' => $maxOrder + 1,
        ]);

        return response()->json($question, 201);
    }

    /**
     * Update a question.
     */
    public function updateQuestion(Request $request, Question $question): JsonResponse
    {
        $this->authorizeQuestion($question);

        $validated = $request->validate([
            'question_text' => 'sometimes|required|string',
            'question_type' => 'sometimes|required|in:multiple_choice,true_false,short_answer',
            'options' => 'nullable|array',
            'options.*' => 'string',
            'correct_answer' => 'sometimes|required|string',
            'explanation' => 'nullable|string',
            'points' => 'sometimes|required|integer|min:1',
        ]);

        $question->update($validated);

        return response()->json($question);
    }

    /**
     * Delete a question.
     */
    public function destroyQuestion(Question $question): JsonResponse
    {
        $this->authorizeQuestion($question);

        $question->delete();

        return response()->json(['message' => 'Question deleted']);
    }

    /**
     * Reorder questions.
     */
    public function reorderQuestions(Request $request, Quiz $quiz): JsonResponse
    {
        $this->authorizeQuiz($quiz);

        $validated = $request->validate([
            'questions' => 'required|array',
            'questions.*.id' => 'required|integer|exists:questions,id',
            'questions.*.order' => 'required|integer',
        ]);

        foreach ($validated['questions'] as $questionData) {
            Question::where('id', $questionData['id'])
                ->where('quiz_id', $quiz->id)
                ->update(['order' => $questionData['order']]);
        }

        return response()->json(['message' => 'Order updated']);
    }

    /**
     * Get quiz lessons for a course (only quiz-type lessons).
     */
    public function getQuizLessons(Course $course): JsonResponse
    {
        if ($course->instructor_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $lessons = Lesson::where('course_id', $course->id)
            ->where('type', 'quiz')
            ->with('module:id,title')
            ->orderBy('order')
            ->get(['id', 'module_id', 'title', 'order']);

        return response()->json($lessons);
    }

    /**
     * Get teacher's courses for dropdown.
     */
    public function getCourses(): JsonResponse
    {
        $courses = Course::where('instructor_id', auth()->id())
            ->orderBy('title')
            ->get(['id', 'title', 'slug']);

        return response()->json($courses);
    }

    /**
     * Authorize quiz access.
     */
    private function authorizeQuiz(Quiz $quiz): void
    {
        if ($quiz->course->instructor_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }
    }

    /**
     * Authorize question access.
     */
    private function authorizeQuestion(Question $question): void
    {
        $this->authorizeQuiz($question->quiz);
    }
}
