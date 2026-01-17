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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class AdminReportsController extends Controller
{
    public function index(Request $request): Response
    {
        $period = $request->get('period', '30');
        $startDate = now()->subDays((int) $period);

        // User growth
        $userGrowth = User::whereBetween('created_at', [$startDate, now()])
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as count')
            )
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date')
            ->get()
            ->map(fn ($item) => [
                'date' => Carbon::parse($item->date)->format('M d'),
                'count' => $item->count,
            ]);

        // Enrollment trends
        $enrollmentTrends = Enrollment::whereBetween('enrolled_at', [$startDate, now()])
            ->select(
                DB::raw('DATE(enrolled_at) as date'),
                DB::raw('COUNT(*) as count')
            )
            ->groupBy(DB::raw('DATE(enrolled_at)'))
            ->orderBy('date')
            ->get()
            ->map(fn ($item) => [
                'date' => Carbon::parse($item->date)->format('M d'),
                'count' => $item->count,
            ]);

        // Course completion rate
        $totalEnrollments = Enrollment::count();
        $completedEnrollments = Enrollment::where('progress_percentage', 100)->count();
        $completionRate = $totalEnrollments > 0
            ? round(($completedEnrollments / $totalEnrollments) * 100, 1)
            : 0;

        // Average progress by course
        $courseProgress = Course::withAvg('enrollments', 'progress_percentage')
            ->withCount('enrollments')
            ->having('enrollments_count', '>', 0)
            ->orderByDesc('enrollments_avg_progress_percentage')
            ->limit(10)
            ->get()
            ->map(fn ($course) => [
                'title' => $course->title,
                'average_progress' => round($course->enrollments_avg_progress_percentage ?? 0, 1),
                'enrollments' => $course->enrollments_count,
            ]);

        // Review statistics
        $reviewStats = [
            'total' => Review::count(),
            'average_rating' => round(Review::avg('rating') ?? 0, 1),
            'distribution' => [
                5 => Review::where('rating', 5)->count(),
                4 => Review::where('rating', 4)->count(),
                3 => Review::where('rating', 3)->count(),
                2 => Review::where('rating', 2)->count(),
                1 => Review::where('rating', 1)->count(),
            ],
        ];

        // Platform summary
        $summary = [
            'total_users' => User::count(),
            'new_users' => User::whereBetween('created_at', [$startDate, now()])->count(),
            'total_courses' => Course::count(),
            'published_courses' => Course::where('is_published', true)->count(),
            'total_enrollments' => $totalEnrollments,
            'new_enrollments' => Enrollment::whereBetween('enrolled_at', [$startDate, now()])->count(),
            'total_revenue' => Payment::where('status', 'completed')->sum('amount'),
            'period_revenue' => Payment::where('status', 'completed')
                ->whereBetween('created_at', [$startDate, now()])
                ->sum('amount'),
            'certificates_issued' => Certificate::count(),
            'completion_rate' => $completionRate,
        ];

        return Inertia::render('Admin/Reports/Index', [
            'userGrowth' => $userGrowth,
            'enrollmentTrends' => $enrollmentTrends,
            'courseProgress' => $courseProgress,
            'reviewStats' => $reviewStats,
            'summary' => $summary,
            'period' => $period,
        ]);
    }
}
