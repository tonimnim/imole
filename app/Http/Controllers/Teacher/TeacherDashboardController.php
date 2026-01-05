<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Enrollment;
use Inertia\Inertia;
use Inertia\Response;

class TeacherDashboardController extends Controller
{
    public function index(): Response
    {
        $user = auth()->user();
        $courseIds = Course::where('instructor_id', $user->id)->pluck('id');

        // Key Metrics
        $totalCourses = Course::where('instructor_id', $user->id)->count();
        $totalStudents = Enrollment::whereIn('course_id', $courseIds)->distinct('user_id')->count('user_id');
        $totalEnrollments = Enrollment::whereIn('course_id', $courseIds)->count();
        $averageRating = Course::where('instructor_id', $user->id)->avg('average_rating') ?? 0;

        // Approximate Revenue (Simple sum of price_paid)
        $totalRevenue = Enrollment::whereIn('course_id', $courseIds)->sum('price_paid');

        // Recent Enrollments
        $recentEnrollments = Enrollment::whereIn('course_id', $courseIds)
            ->with(['user:id,name,email,avatar', 'course:id,title,slug'])
            ->latest()
            ->take(5)
            ->get()
            ->map(fn ($enrollment) => [
                'id' => $enrollment->id,
                'student' => [
                    'name' => $enrollment->user->name,
                    'email' => $enrollment->user->email,
                    'avatar' => $enrollment->user->avatar ? asset('storage/'.$enrollment->user->avatar) : null,
                ],
                'course' => $enrollment->course->title,
                'amount' => $enrollment->price_paid,
                'date' => $enrollment->created_at->diffForHumans(),
            ]);

        // Top Performing Courses
        $topCourses = Course::where('instructor_id', $user->id)
            ->withCount('enrollments')
            ->orderByDesc('enrollments_count')
            ->take(4)
            ->get()
            ->map(fn ($course) => [
                'id' => $course->id,
                'title' => $course->title,
                'status' => $course->is_published ? 'Published' : 'Draft',
                'students' => $course->enrollments_count,
                'rating' => round($course->average_rating, 1),
                'price' => $course->price,
            ]);

        return Inertia::render('Teacher/Dashboard', [
            'stats' => [
                'totalCourses' => $totalCourses,
                'totalStudents' => $totalStudents,
                'totalRevenue' => $totalRevenue,
                'averageRating' => round($averageRating, 1),
            ],
            'recentEnrollments' => $recentEnrollments,
            'topCourses' => $topCourses,
        ]);
    }
}
