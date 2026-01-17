<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AdminEnrollmentsController extends Controller
{
    public function index(Request $request): Response
    {
        $query = Enrollment::query()
            ->with(['user:id,name,email,avatar', 'course:id,title,slug,thumbnail']);

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($q) use ($search) {
                    $q->where('name', 'ilike', "%{$search}%")
                        ->orWhere('email', 'ilike', "%{$search}%");
                })->orWhereHas('course', function ($q) use ($search) {
                    $q->where('title', 'ilike', "%{$search}%");
                });
            });
        }

        // Progress filter
        if ($request->filled('progress')) {
            if ($request->progress === 'completed') {
                $query->where('progress_percentage', 100);
            } elseif ($request->progress === 'in_progress') {
                $query->where('progress_percentage', '>', 0)->where('progress_percentage', '<', 100);
            } elseif ($request->progress === 'not_started') {
                $query->where('progress_percentage', 0);
            }
        }

        $enrollments = $query->latest('enrolled_at')
            ->paginate(15)
            ->withQueryString()
            ->through(fn ($enrollment) => [
                'id' => $enrollment->id,
                'user' => [
                    'id' => $enrollment->user->id,
                    'name' => $enrollment->user->name,
                    'email' => $enrollment->user->email,
                    'avatar' => $enrollment->user->avatar ? asset('storage/'.$enrollment->user->avatar) : null,
                ],
                'course' => [
                    'id' => $enrollment->course->id,
                    'title' => $enrollment->course->title,
                    'slug' => $enrollment->course->slug,
                    'thumbnail' => $enrollment->course->thumbnail ? asset('storage/'.$enrollment->course->thumbnail) : null,
                ],
                'progress_percentage' => $enrollment->progress_percentage,
                'enrolled_at' => Carbon::parse($enrollment->enrolled_at)->format('M d, Y'),
                'completed_at' => $enrollment->completed_at ? Carbon::parse($enrollment->completed_at)->format('M d, Y') : null,
            ]);

        $stats = [
            'total' => Enrollment::count(),
            'completed' => Enrollment::where('progress_percentage', 100)->count(),
            'in_progress' => Enrollment::where('progress_percentage', '>', 0)->where('progress_percentage', '<', 100)->count(),
            'not_started' => Enrollment::where('progress_percentage', 0)->count(),
        ];

        return Inertia::render('Admin/Enrollments/Index', [
            'enrollments' => $enrollments,
            'stats' => $stats,
            'filters' => $request->only(['search', 'progress']),
        ]);
    }

    public function destroy(Enrollment $enrollment)
    {
        $enrollment->delete();

        return back()->with('success', 'Enrollment deleted successfully.');
    }
}
