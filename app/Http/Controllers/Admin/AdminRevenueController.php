<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class AdminRevenueController extends Controller
{
    public function index(Request $request): Response
    {
        $period = $request->get('period', '30'); // days

        $startDate = now()->subDays((int) $period);
        $endDate = now();

        // Revenue stats (from enrollments price_paid)
        $totalRevenue = Enrollment::sum('price_paid');
        $periodRevenue = Enrollment::whereBetween('created_at', [$startDate, $endDate])
            ->sum('price_paid');

        $previousPeriodStart = $startDate->copy()->subDays((int) $period);
        $previousPeriodRevenue = Enrollment::whereBetween('created_at', [$previousPeriodStart, $startDate])
            ->sum('price_paid');

        $revenueGrowth = $previousPeriodRevenue > 0
            ? round((($periodRevenue - $previousPeriodRevenue) / $previousPeriodRevenue) * 100, 1)
            : 0;

        // Daily revenue for chart
        $dailyRevenue = Enrollment::whereBetween('created_at', [$startDate, $endDate])
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(price_paid) as revenue'),
                DB::raw('COUNT(*) as transactions')
            )
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date')
            ->get()
            ->map(fn ($item) => [
                'date' => Carbon::parse($item->date)->format('M d'),
                'revenue' => (float) $item->revenue,
                'transactions' => $item->transactions,
            ]);

        // Top earning courses (from enrollments)
        $topCourses = Enrollment::whereBetween('created_at', [$startDate, $endDate])
            ->with('course:id,title')
            ->select('course_id', DB::raw('SUM(price_paid) as total'), DB::raw('COUNT(*) as sales'))
            ->groupBy('course_id')
            ->orderByDesc('total')
            ->limit(10)
            ->get()
            ->map(fn ($item) => [
                'course' => $item->course?->title ?? 'Unknown',
                'revenue' => (float) $item->total,
                'sales' => $item->sales,
            ]);

        // Top earning teachers (using enrollments price_paid)
        $topTeachers = User::role('teacher')
            ->with(['courses' => function ($query) use ($startDate, $endDate) {
                $query->withSum(['enrollments as revenue' => function ($q) use ($startDate, $endDate) {
                    $q->whereBetween('created_at', [$startDate, $endDate]);
                }], 'price_paid');
            }])
            ->get()
            ->map(function ($teacher) {
                $revenue = $teacher->courses->sum('revenue') ?? 0;

                return [
                    'id' => $teacher->id,
                    'name' => $teacher->name,
                    'avatar' => $teacher->avatar ? asset('storage/'.$teacher->avatar) : null,
                    'revenue' => $revenue,
                    'courses' => $teacher->courses->count(),
                ];
            })
            ->filter(fn ($t) => $t['revenue'] > 0)
            ->sortByDesc('revenue')
            ->take(10)
            ->values();

        return Inertia::render('Admin/Revenue/Index', [
            'stats' => [
                'total_revenue' => (float) $totalRevenue,
                'period_revenue' => (float) $periodRevenue,
                'revenue_growth' => $revenueGrowth,
                'total_transactions' => Enrollment::count(),
                'period_transactions' => Enrollment::whereBetween('created_at', [$startDate, $endDate])
                    ->count(),
            ],
            'dailyRevenue' => $dailyRevenue,
            'topCourses' => $topCourses,
            'topTeachers' => $topTeachers,
            'period' => $period,
        ]);
    }
}
