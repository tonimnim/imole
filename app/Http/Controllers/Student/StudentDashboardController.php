<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\View\View;

class StudentDashboardController extends Controller
{
    public function dashboard(): View
    {
        $user = auth()->user();

        // Get enrolled courses with progress
        $enrolledCourses = Enrollment::query()
            ->where('user_id', $user->id)
            ->with([
                'course' => function ($query) {
                    $query->with(['instructor', 'category'])
                        ->withCount(['lessons', 'modules']);
                },
            ])
            ->orderBy('enrolled_at', 'desc')
            ->limit(4)
            ->get();

        // Get recommended courses (not enrolled, published, featured)
        $recommendedCourses = Course::query()
            ->where('is_published', true)
            ->where('is_featured', true)
            ->whereDoesntHave('enrollments', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->with(['category', 'instructor'])
            ->withCount(['enrollments', 'reviews'])
            ->withAvg('reviews', 'rating')
            ->orderBy('enrollments_count', 'desc')
            ->limit(4)
            ->get()
            ->map(function ($course) {
                $course->students_count = $course->enrollments_count;
                $course->average_rating = $course->reviews_avg_rating ?? 0;

                return $course;
            });

        // Get statistics
        $stats = [
            'enrolled_courses' => Enrollment::where('user_id', $user->id)->count(),
            'completed_courses' => Enrollment::where('user_id', $user->id)
                ->where('progress_percentage', 100)
                ->count(),
            'certificates' => $user->certificates()->count(),
            'in_progress' => Enrollment::where('user_id', $user->id)
                ->where('progress_percentage', '>', 0)
                ->where('progress_percentage', '<', 100)
                ->count(),
        ];

        return view('student.dashboard', [
            'enrolledCourses' => $enrolledCourses,
            'recommendedCourses' => $recommendedCourses,
            'stats' => $stats,
        ]);
    }

    public function myCourses(): View
    {
        $user = auth()->user();

        $enrollments = Enrollment::query()
            ->where('user_id', $user->id)
            ->with([
                'course' => function ($query) {
                    $query->with(['instructor', 'category'])
                        ->withCount(['lessons', 'modules']);
                },
            ])
            ->orderBy('enrolled_at', 'desc')
            ->paginate(12);

        return view('student.my-courses', [
            'enrollments' => $enrollments,
        ]);
    }

    public function certificates(): View
    {
        $user = auth()->user();

        $certificates = $user->certificates()
            ->with('course')
            ->orderBy('issued_at', 'desc')
            ->paginate(12);

        return view('student.certificates', [
            'certificates' => $certificates,
        ]);
    }
}
