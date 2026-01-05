<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class TeacherStudentsController extends Controller
{
    public function index(Request $request): Response
    {
        $user = auth()->user();
        $courseIds = $user->courses()->pluck('id');

        // Get unique students enrolled in teacher's courses
        $studentsQuery = User::whereHas('enrollments', function ($q) use ($courseIds) {
            $q->whereIn('course_id', $courseIds);
        });

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $studentsQuery->where(function ($q) use ($search) {
                $q->where('name', 'ilike', "%{$search}%")
                    ->orWhere('email', 'ilike', "%{$search}%");
            });
        }

        $students = $studentsQuery
            ->withCount(['enrollments' => fn ($q) => $q->whereIn('course_id', $courseIds)])
            ->with(['enrollments' => fn ($q) => $q->whereIn('course_id', $courseIds)->with('course:id,title')])
            ->paginate(20)
            ->through(fn ($student) => [
                'id' => $student->id,
                'name' => $student->name,
                'email' => $student->email,
                'avatar' => $student->avatar,
                'avatarUrl' => $student->avatar ? asset('storage/'.$student->avatar) : null,
                'coursesCount' => $student->enrollments_count,
                'courses' => $student->enrollments->map(fn ($e) => [
                    'id' => $e->course->id,
                    'title' => $e->course->title,
                    'progress' => $e->progress_percentage,
                    'enrolledAt' => $e->enrolled_at?->format('M d, Y'),
                    'lastAccessed' => $e->last_accessed_at?->diffForHumans(),
                ]),
                'avgProgress' => round($student->enrollments->avg('progress_percentage') ?? 0),
                'joinedAt' => $student->created_at->format('M d, Y'),
            ]);

        // Stats
        $totalStudents = User::whereHas('enrollments', fn ($q) => $q->whereIn('course_id', $courseIds))->count();
        $activeStudents = Enrollment::whereIn('course_id', $courseIds)
            ->where('last_accessed_at', '>=', now()->subDays(7))
            ->distinct('user_id')
            ->count('user_id');
        $completedStudents = Enrollment::whereIn('course_id', $courseIds)
            ->where('progress_percentage', 100)
            ->distinct('user_id')
            ->count('user_id');
        $avgProgress = Enrollment::whereIn('course_id', $courseIds)->avg('progress_percentage') ?? 0;

        return Inertia::render('Teacher/Students/Index', [
            'students' => $students,
            'stats' => [
                'total' => $totalStudents,
                'active' => $activeStudents,
                'completed' => $completedStudents,
                'avgProgress' => round($avgProgress),
            ],
            'filters' => $request->only(['search']),
        ]);
    }
}
