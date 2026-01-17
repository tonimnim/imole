<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
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

        // Revenue stats
        $totalRevenue = Payment::where('status', 'completed')->sum('amount');
        $periodRevenue = Payment::where('status', 'completed')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->sum('amount');

        $previousPeriodStart = $startDate->copy()->subDays((int) $period);
        $previousPeriodRevenue = Payment::where('status', 'completed')
            ->whereBetween('created_at', [$previousPeriodStart, $startDate])
            ->sum('amount');

        $revenueGrowth = $previousPeriodRevenue > 0
            ? round((($periodRevenue - $previousPeriodRevenue) / $previousPeriodRevenue) * 100, 1)
            : 0;

        // Daily revenue for chart
        $dailyRevenue = Payment::where('status', 'completed')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(amount) as revenue'),
                DB::raw('COUNT(*) as transactions')
            )
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date')
            ->get()
            ->map(fn ($item) => [
                'date' => Carbon::parse($item->date)->format('M d'),
                'revenue' => $item->revenue,
                'transactions' => $item->transactions,
            ]);

        // Top earning courses
        $topCourses = Payment::where('status', 'completed')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->whereNotNull('course_id')
            ->with('course:id,title')
            ->select('course_id', DB::raw('SUM(amount) as total'), DB::raw('COUNT(*) as sales'))
            ->groupBy('course_id')
            ->orderByDesc('total')
            ->limit(10)
            ->get()
            ->map(fn ($item) => [
                'course' => $item->course?->title ?? 'Unknown',
                'revenue' => $item->total,
                'sales' => $item->sales,
            ]);

        // Top earning teachers
        $topTeachers = User::role('teacher')
            ->with(['courses' => function ($query) use ($startDate, $endDate) {
                $query->withSum(['payments as revenue' => function ($q) use ($startDate, $endDate) {
                    $q->where('status', 'completed')
                        ->whereBetween('created_at', [$startDate, $endDate]);
                }], 'amount');
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
                'total_revenue' => $totalRevenue,
                'period_revenue' => $periodRevenue,
                'revenue_growth' => $revenueGrowth,
                'total_transactions' => Payment::where('status', 'completed')->count(),
                'period_transactions' => Payment::where('status', 'completed')
                    ->whereBetween('created_at', [$startDate, $endDate])
                    ->count(),
            ],
            'dailyRevenue' => $dailyRevenue,
            'topCourses' => $topCourses,
            'topTeachers' => $topTeachers,
            'period' => $period,
        ]);
    }
}
