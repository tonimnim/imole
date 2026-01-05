<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Inertia\Inertia;
use Inertia\Response;

class TeacherCoursesController extends Controller
{
    public function index(): Response
    {
        $user = auth()->user();

        $courses = Course::where('instructor_id', $user->id)
            ->with(['category:id,name'])
            ->withCount(['enrollments', 'modules', 'lessons'])
            ->withAvg('reviews', 'rating')
            ->latest()
            ->get()
            ->map(fn ($c) => [
                'id' => $c->id,
                'title' => $c->title,
                'slug' => $c->slug,
                'thumbnail' => $c->thumbnail ? asset('storage/'.$c->thumbnail) : null,
                'category' => $c->category?->name ?? 'Uncategorized',
                'status' => $c->status, // draft, pending, published
                'isPublished' => $c->is_published,
                'price' => $c->price,
                'studentsCount' => $c->enrollments_count,
                'lessonsCount' => $c->lessons_count,
                'rating' => round($c->reviews_avg_rating ?? 0, 1),
                'createdAt' => $c->created_at->format('M d, Y'),
            ]);

        $stats = [
            'total' => $courses->count(),
            'published' => $courses->where('isPublished', true)->count(),
            'draft' => $courses->where('status', 'draft')->count(),
            'totalStudents' => $courses->sum('studentsCount'),
        ];

        return Inertia::render('Teacher/Courses/Index', [
            'courses' => $courses,
            'stats' => $stats,
        ]);
    }
}
