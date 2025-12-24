<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Lesson;
use App\Models\LessonNote;
use App\Models\LessonProgress;
use App\Models\Quiz;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CourseLearningController extends Controller
{
    /**
     * Start or continue learning a course
     * Redirects to the appropriate lesson based on user progress
     */
    public function start(Course $course): RedirectResponse
    {
        $user = auth()->user();

        // Check if user is enrolled
        $enrollment = Enrollment::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->first();

        if (! $enrollment) {
            return redirect()->route('courses.show', $course)
                ->with('error', 'You need to enroll in this course first.');
        }

        // Update enrollment started_at and last_accessed_at if needed
        if (! $enrollment->started_at) {
            $enrollment->update(['started_at' => now()]);
        }
        $enrollment->update(['last_accessed_at' => now()]);

        // Find the next lesson to study
        $nextLesson = $this->findNextLesson($course, $user->id, $enrollment->id);

        if (! $nextLesson) {
            // Course completed - take them to the first lesson to review
            $firstLesson = $course->lessons()
                ->join('modules', 'lessons.module_id', '=', 'modules.id')
                ->where('lessons.is_published', true)
                ->orderBy('modules.order', 'asc')
                ->orderBy('lessons.order', 'asc')
                ->select('lessons.*')
                ->first();

            if ($firstLesson) {
                return redirect()->route('student.learn.lesson', [
                    'course' => $course->slug,
                    'lesson' => $firstLesson->slug,
                ]);
            }

            return redirect()->route('student.my-courses')
                ->with('error', 'No lessons available in this course.');
        }

        return redirect()->route('student.learn.lesson', [
            'course' => $course->slug,
            'lesson' => $nextLesson->slug,
        ]);
    }

    /**
     * Show a specific lesson
     */
    public function lesson(Course $course, Lesson $lesson): View|RedirectResponse
    {
        $user = auth()->user();

        // Verify enrollment
        $enrollment = Enrollment::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->first();

        if (! $enrollment) {
            return redirect()->route('courses.show', $course)
                ->with('error', 'You need to enroll in this course first.');
        }

        // Verify lesson belongs to this course
        if ($lesson->course_id !== $course->id) {
            abort(404);
        }

        // Check if lesson is free or user is enrolled
        if (! $lesson->is_free && ! $enrollment) {
            return redirect()->route('courses.show', $course)
                ->with('error', 'This lesson is not available.');
        }

        // Get or create lesson progress
        $lessonProgress = LessonProgress::firstOrCreate(
            [
                'user_id' => $user->id,
                'lesson_id' => $lesson->id,
            ],
            [
                'enrollment_id' => $enrollment->id,
                'is_completed' => false,
                'time_spent_seconds' => 0,
                'last_position_seconds' => 0,
            ]
        );

        // Update last accessed
        $enrollment->update(['last_accessed_at' => now()]);

        // Get all lessons for navigation
        $allLessons = $course->lessons()
            ->with('module')
            ->orderBy('order')
            ->get();

        // Group lessons by module for sidebar
        $modules = $course->modules()
            ->with(['lessons' => function ($query) {
                $query->orderBy('order');
            }])
            ->orderBy('order')
            ->get();

        // Get previous and next lessons
        $currentIndex = $allLessons->search(fn ($l) => $l->id === $lesson->id);
        $previousLesson = $currentIndex > 0 ? $allLessons[$currentIndex - 1] : null;
        $nextLesson = $currentIndex < $allLessons->count() - 1 ? $allLessons[$currentIndex + 1] : null;

        // Load lesson resources and comments
        $lesson->load(['resources', 'comments' => function ($query) {
            $query->where('is_approved', true)
                ->whereNull('parent_id')
                ->with(['user', 'replies' => function ($q) {
                    $q->where('is_approved', true)->with('user');
                }])
                ->latest();
        }]);

        // Get completed lesson IDs for this user
        $completedLessonIds = LessonProgress::where('user_id', $user->id)
            ->where('enrollment_id', $enrollment->id)
            ->where('is_completed', true)
            ->pluck('lesson_id')
            ->toArray();

        // Calculate course progress
        $totalLessons = $allLessons->count();
        $completedCount = count($completedLessonIds);
        $progressPercentage = $totalLessons > 0 ? round(($completedCount / $totalLessons) * 100) : 0;

        // Get user's notes for this lesson
        $notes = LessonNote::where('user_id', $user->id)
            ->where('lesson_id', $lesson->id)
            ->orderBy('created_at', 'desc')
            ->get();

        // Check if there's a quiz for this lesson
        $quiz = Quiz::where('lesson_id', $lesson->id)
            ->where('is_published', true)
            ->with('questions')
            ->first();

        return view('student.learn.lesson', compact(
            'course',
            'lesson',
            'lessonProgress',
            'modules',
            'previousLesson',
            'nextLesson',
            'completedLessonIds',
            'progressPercentage',
            'enrollment',
            'notes',
            'quiz'
        ));
    }

    /**
     * Mark a lesson as complete
     */
    public function completeLesson(Request $request, Course $course, Lesson $lesson): RedirectResponse
    {
        $user = auth()->user();

        // Verify enrollment
        $enrollment = Enrollment::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->first();

        if (! $enrollment) {
            return back()->with('error', 'You are not enrolled in this course.');
        }

        // Update or create lesson progress
        $lessonProgress = LessonProgress::updateOrCreate(
            [
                'user_id' => $user->id,
                'lesson_id' => $lesson->id,
            ],
            [
                'enrollment_id' => $enrollment->id,
                'is_completed' => true,
                'completed_at' => now(),
                'time_spent_seconds' => $request->input('time_spent', 0),
                'last_position_seconds' => $lesson->duration_minutes * 60,
            ]
        );

        // Update enrollment progress percentage
        $this->updateEnrollmentProgress($enrollment);

        // Find next lesson
        $nextLesson = $this->findNextLesson($course, $user->id, $enrollment->id);

        if ($nextLesson) {
            return redirect()->route('student.learn.lesson', [
                'course' => $course->slug,
                'lesson' => $nextLesson->slug,
            ])->with('success', 'Lesson marked as complete!');
        }

        // Course completed!
        $enrollment->update([
            'status' => 'completed',
            'completed_at' => now(),
            'progress_percentage' => 100,
        ]);

        // Stay on current lesson and show completion modal
        return back()->with('course_completed', true);
    }

    /**
     * Update lesson progress (for video position tracking)
     */
    public function updateProgress(Request $request, Course $course, Lesson $lesson): RedirectResponse
    {
        $user = auth()->user();

        $enrollment = Enrollment::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->first();

        if (! $enrollment) {
            return back()->with('error', 'You are not enrolled in this course.');
        }

        LessonProgress::updateOrCreate(
            [
                'user_id' => $user->id,
                'lesson_id' => $lesson->id,
            ],
            [
                'enrollment_id' => $enrollment->id,
                'last_position_seconds' => $request->input('position', 0),
                'time_spent_seconds' => $request->input('time_spent', 0),
            ]
        );

        return back()->with('success', 'Progress saved!');
    }

    /**
     * Find the next lesson to study based on progress
     */
    protected function findNextLesson(Course $course, int $userId, int $enrollmentId): ?Lesson
    {
        // Get all completed lesson IDs
        $completedLessonIds = LessonProgress::where('user_id', $userId)
            ->where('enrollment_id', $enrollmentId)
            ->where('is_completed', true)
            ->pluck('lesson_id')
            ->toArray();

        // Find the first incomplete lesson (ordered by module order first, then lesson order)
        return $course->lessons()
            ->join('modules', 'lessons.module_id', '=', 'modules.id')
            ->whereNotIn('lessons.id', $completedLessonIds)
            ->where('lessons.is_published', true)
            ->orderBy('modules.order', 'asc')
            ->orderBy('lessons.order', 'asc')
            ->select('lessons.*')
            ->first();
    }

    /**
     * Update enrollment progress percentage
     */
    protected function updateEnrollmentProgress(Enrollment $enrollment): void
    {
        $totalLessons = $enrollment->course->lessons()->where('is_published', true)->count();

        $completedLessons = LessonProgress::where('enrollment_id', $enrollment->id)
            ->where('is_completed', true)
            ->count();

        $progressPercentage = $totalLessons > 0
            ? round(($completedLessons / $totalLessons) * 100)
            : 0;

        $enrollment->update(['progress_percentage' => $progressPercentage]);
    }

    /**
     * Save a note for a lesson
     */
    public function saveNote(Request $request, Course $course, Lesson $lesson): JsonResponse
    {
        $validated = $request->validate([
            'content' => 'required|string|max:5000',
            'video_timestamp' => 'nullable|integer|min:0',
        ]);

        $note = LessonNote::create([
            'user_id' => auth()->id(),
            'lesson_id' => $lesson->id,
            'course_id' => $course->id,
            'content' => $validated['content'],
            'video_timestamp' => $validated['video_timestamp'] ?? null,
        ]);

        return response()->json([
            'success' => true,
            'note' => $note,
            'message' => 'Note saved successfully!',
        ]);
    }

    /**
     * Delete a note
     */
    public function deleteNote(Course $course, Lesson $lesson, LessonNote $note): JsonResponse
    {
        // Verify the note belongs to the authenticated user
        if ($note->user_id !== auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
            ], 403);
        }

        $note->delete();

        return response()->json([
            'success' => true,
            'message' => 'Note deleted successfully!',
        ]);
    }

    /**
     * Show course completion page
     */
    public function completed(Course $course): View|RedirectResponse
    {
        $user = auth()->user();

        // Verify enrollment and completion
        $enrollment = Enrollment::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->first();

        if (! $enrollment) {
            return redirect()->route('courses.show', $course)
                ->with('error', 'You are not enrolled in this course.');
        }

        if ($enrollment->progress_percentage < 100) {
            return redirect()->route('student.learn.start', $course);
        }

        // Generate certificate if the course offers certificates and user has 100% completion
        if ($course->has_certificate) {
            \App\Models\Certificate::firstOrCreate(
                [
                    'user_id' => $user->id,
                    'course_id' => $course->id,
                ],
                [
                    'enrollment_id' => $enrollment->id,
                    'certificate_number' => 'IMOLE-'.strtoupper(uniqid()),
                    'issued_at' => now(),
                ]
            );
        }

        // Get course statistics
        $totalLessons = $course->lessons()->where('is_published', true)->count();
        $completedLessons = LessonProgress::where('enrollment_id', $enrollment->id)
            ->where('is_completed', true)
            ->count();

        // Actual time spent learning
        $actualTimeSpent = LessonProgress::where('enrollment_id', $enrollment->id)
            ->sum('time_spent_seconds');

        // Total course duration (sum of all lesson durations)
        $courseDuration = $course->lessons()
            ->where('is_published', true)
            ->sum('duration_minutes') * 60;

        // Get quiz statistics
        $quizAttempts = \App\Models\QuizAttempt::whereHas('quiz.lesson', function ($query) use ($course) {
            $query->where('course_id', $course->id);
        })->where('user_id', $user->id)->get();

        $averageQuizScore = $quizAttempts->avg('score') ?? 0;
        $quizzesTaken = $quizAttempts->count();

        // Get related courses (same category or same instructor)
        $relatedCourses = Course::where('is_published', true)
            ->where('id', '!=', $course->id)
            ->where(function ($query) use ($course) {
                $query->where('category_id', $course->category_id)
                    ->orWhere('instructor_id', $course->instructor_id);
            })
            ->whereDoesntHave('enrollments', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->with(['instructor', 'category'])
            ->withCount(['enrollments', 'reviews'])
            ->withAvg('reviews', 'rating')
            ->limit(3)
            ->get()
            ->map(function ($c) {
                $c->students_count = $c->enrollments_count;
                $c->average_rating = $c->reviews_avg_rating ?? 0;

                return $c;
            });

        // Check if user has already reviewed
        $existingReview = \App\Models\Review::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->first();

        // Get certificate if exists
        $certificate = \App\Models\Certificate::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->first();

        return view('student.learn.completed', compact(
            'course',
            'enrollment',
            'totalLessons',
            'completedLessons',
            'actualTimeSpent',
            'courseDuration',
            'averageQuizScore',
            'quizzesTaken',
            'relatedCourses',
            'existingReview',
            'certificate'
        ));
    }
}
