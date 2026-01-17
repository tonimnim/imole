<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Course;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AdminCoursesController extends Controller
{
    public function index(Request $request): Response
    {
        $query = Course::query()
            ->with(['instructor:id,name,email,avatar', 'category:id,name'])
            ->withCount(['enrollments', 'modules', 'lessons', 'reviews'])
            ->withAvg('reviews', 'rating');

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'ilike', "%{$search}%")
                    ->orWhere('description', 'ilike', "%{$search}%");
            });
        }

        // Status filter
        if ($request->filled('status')) {
            if ($request->status === 'published') {
                $query->where('is_published', true);
            } elseif ($request->status === 'draft') {
                $query->where('is_published', false);
            } elseif ($request->status === 'featured') {
                $query->where('is_featured', true);
            }
        }

        // Category filter
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        $courses = $query->latest()
            ->paginate(15)
            ->withQueryString()
            ->through(fn ($course) => [
                'id' => $course->id,
                'title' => $course->title,
                'slug' => $course->slug,
                'thumbnail' => $course->thumbnail ? asset('storage/'.$course->thumbnail) : null,
                'price' => $course->price,
                'instructor' => [
                    'id' => $course->instructor->id,
                    'name' => $course->instructor->name,
                    'avatar' => $course->instructor->avatar ? asset('storage/'.$course->instructor->avatar) : null,
                ],
                'category' => $course->category?->name,
                'is_published' => $course->is_published,
                'is_featured' => $course->is_featured,
                'enrollments_count' => $course->enrollments_count,
                'modules_count' => $course->modules_count,
                'lessons_count' => $course->lessons_count,
                'average_rating' => round($course->reviews_avg_rating ?? 0, 1),
                'created_at' => $course->created_at->format('M d, Y'),
            ]);

        $categories = Category::pluck('name', 'id');

        $stats = [
            'total' => Course::count(),
            'published' => Course::where('is_published', true)->count(),
            'draft' => Course::where('is_published', false)->count(),
            'featured' => Course::where('is_featured', true)->count(),
        ];

        return Inertia::render('Admin/Courses/Index', [
            'courses' => $courses,
            'categories' => $categories,
            'stats' => $stats,
            'filters' => $request->only(['search', 'status', 'category']),
        ]);
    }

    public function togglePublish(Course $course)
    {
        $course->update(['is_published' => ! $course->is_published]);

        return back()->with('success', $course->is_published ? 'Course published.' : 'Course unpublished.');
    }

    public function toggleFeatured(Course $course)
    {
        $course->update(['is_featured' => ! $course->is_featured]);

        return back()->with('success', $course->is_featured ? 'Course featured.' : 'Course unfeatured.');
    }

    public function destroy(Course $course)
    {
        $course->delete();

        return redirect()->route('admin.courses.index')
            ->with('success', 'Course deleted successfully.');
    }
}
