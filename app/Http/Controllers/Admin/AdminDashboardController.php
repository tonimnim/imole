<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Payment;
use App\Models\Review;
use App\Models\User;
use Carbon\Carbon;
use Inertia\Inertia;
use Inertia\Response;

class AdminDashboardController extends Controller
{
    public function index(): Response
    {
        $user = auth()->user();

        // Platform Overview Stats
        $stats = [
            'total_users' => User::count(),
            'total_teachers' => User::role('teacher')->count(),
            'total_students' => User::role('student')->count(),
            'total_courses' => Course::count(),
            'published_courses' => Course::where('is_published', true)->count(),
            'total_enrollments' => Enrollment::count(),
            'total_revenue' => Payment::where('status', 'completed')->sum('amount'),
            'total_certificates' => Certificate::count(),
        ];

        // Monthly Stats (last 6 months)
        $monthlyStats = $this->getMonthlyStats();

        // Recent Users
        $recentUsers = User::query()
            ->latest()
            ->limit(10)
            ->get()
            ->map(fn ($user) => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'avatar' => $user->avatar ? asset('storage/'.$user->avatar) : null,
                'roles' => $user->getRoleNames(),
                'created_at' => $user->created_at->diffForHumans(),
            ]);

        // Recent Enrollments
        $recentEnrollments = Enrollment::query()
            ->with(['user:id,name,email,avatar', 'course:id,title,slug'])
            ->latest('enrolled_at')
            ->limit(10)
            ->get()
            ->map(fn ($enrollment) => [
                'id' => $enrollment->id,
                'user' => [
                    'name' => $enrollment->user->name,
                    'email' => $enrollment->user->email,
                    'avatar' => $enrollment->user->avatar ? asset('storage/'.$enrollment->user->avatar) : null,
                ],
                'course' => [
                    'title' => $enrollment->course->title,
                    'slug' => $enrollment->course->slug,
                ],
                'progress' => $enrollment->progress_percentage,
                'enrolled_at' => Carbon::parse($enrollment->enrolled_at)->diffForHumans(),
            ]);

        // Recent Payments
        $recentPayments = Payment::query()
            ->with(['user:id,name,email'])
            ->latest()
            ->limit(10)
            ->get()
            ->map(fn ($payment) => [
                'id' => $payment->id,
                'user' => $payment->user ? [
                    'name' => $payment->user->name,
                    'email' => $payment->user->email,
                ] : null,
                'amount' => $payment->amount,
                'currency' => $payment->currency ?? 'KES',
                'status' => $payment->status,
                'created_at' => $payment->created_at->diffForHumans(),
            ]);

        // Top Courses by Enrollments
        $topCourses = Course::query()
            ->withCount('enrollments')
            ->withAvg('reviews', 'rating')
            ->orderByDesc('enrollments_count')
            ->limit(5)
            ->get()
            ->map(fn ($course) => [
                'id' => $course->id,
                'title' => $course->title,
                'slug' => $course->slug,
                'enrollments_count' => $course->enrollments_count,
                'average_rating' => round($course->reviews_avg_rating ?? 0, 1),
                'is_published' => $course->is_published,
            ]);

        // Top Teachers by Revenue
        $topTeachers = User::role('teacher')
            ->withCount('courses')
            ->with(['courses' => function ($query) {
                $query->withCount('enrollments');
            }])
            ->get()
            ->map(function ($teacher) {
                $totalEnrollments = $teacher->courses->sum('enrollments_count');

                return [
                    'id' => $teacher->id,
                    'name' => $teacher->name,
                    'email' => $teacher->email,
                    'avatar' => $teacher->avatar ? asset('storage/'.$teacher->avatar) : null,
                    'courses_count' => $teacher->courses_count,
                    'total_enrollments' => $totalEnrollments,
                ];
            })
            ->sortByDesc('total_enrollments')
            ->take(5)
            ->values();

        // Pending Reviews
        $pendingReviews = Review::query()
            ->where('is_approved', false)
            ->with(['user:id,name', 'course:id,title'])
            ->latest()
            ->limit(5)
            ->get()
            ->map(fn ($review) => [
                'id' => $review->id,
                'user' => $review->user->name,
                'course' => $review->course->title,
                'rating' => $review->rating,
                'comment' => $review->comment,
                'created_at' => $review->created_at->diffForHumans(),
            ]);

        return Inertia::render('Admin/Dashboard', [
            'stats' => $stats,
            'monthlyStats' => $monthlyStats,
            'recentUsers' => $recentUsers,
            'recentEnrollments' => $recentEnrollments,
            'recentPayments' => $recentPayments,
            'topCourses' => $topCourses,
            'topTeachers' => $topTeachers,
            'pendingReviews' => $pendingReviews,
        ]);
    }

    private function getMonthlyStats(): array
    {
        $months = collect();
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $months->push([
                'month' => $date->format('M'),
                'year' => $date->format('Y'),
                'start' => $date->startOfMonth()->toDateString(),
                'end' => $date->endOfMonth()->toDateString(),
            ]);
        }

        return $months->map(function ($month) {
            return [
                'month' => $month['month'],
                'users' => User::whereBetween('created_at', [$month['start'], $month['end']])->count(),
                'enrollments' => Enrollment::whereBetween('enrolled_at', [$month['start'], $month['end']])->count(),
                'revenue' => Payment::where('status', 'completed')
                    ->whereBetween('created_at', [$month['start'], $month['end']])
                    ->sum('amount'),
            ];
        })->toArray();
    }
}
