<?php

namespace App\Http\Controllers;

use App\Http\Requests\CourseStoreRequest;
use App\Http\Requests\CourseUpdateRequest;
use App\Jobs\ProcessCourseThumbnail;
use App\Models\Course;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CourseController extends Controller
{
    public function index(Request $request): View
    {
        $perPage = $request->input('per_page', 12); // 12, 24, or 48
        $sortBy = $request->input('sort', 'featured');
        $category = $request->input('category');
        $level = $request->input('level');
        $search = $request->input('search');

        $query = Course::query()
            ->where('is_published', true)
            ->with(['category:id,name,slug', 'instructor:id,name,email'])
            ->withCount(['enrollments', 'reviews'])
            ->withAvg('reviews', 'rating');

        // Filtering
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('subtitle', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($category) {
            $query->whereHas('category', fn ($q) => $q->where('slug', $category));
        }

        if ($level) {
            $query->where('level', $level);
        }

        // Sorting
        match ($sortBy) {
            'newest' => $query->orderBy('created_at', 'desc'),
            'popular' => $query->orderBy('enrollments_count', 'desc'),
            'rated' => $query->orderBy('reviews_avg_rating', 'desc'),
            default => $query->orderBy('is_featured', 'desc')->orderBy('created_at', 'desc')
        };

        // Paginate with data transformation
        $courses = $query->paginate($perPage)
            ->through(function ($course) {
                $course->students_count = $course->enrollments_count;
                $course->average_rating = $course->reviews_avg_rating ?? 0;

                return $course;
            });

        $categories = \App\Models\Category::query()
            ->where('is_active', true)
            ->whereNull('parent_id')
            ->orderBy('order')
            ->get();

        return view('course.index', [
            'courses' => $courses,
            'categories' => $categories,
            'currentFilters' => [
                'search' => $search,
                'category' => $category,
                'level' => $level,
                'sort' => $sortBy,
                'per_page' => $perPage,
            ],
        ]);
    }

    public function show(Request $request, Course $course): View
    {
        // Load relationships (reviews with user for JSON-LD schema)
        $course->load(['category', 'instructor', 'modules.lessons', 'reviews' => function ($query) {
            $query->where('is_approved', true)->with('user')->latest()->limit(5);
        }]);

        // Load review stats
        $course->loadCount(['enrollments', 'reviews']);
        $course->loadAvg('reviews', 'rating');
        $course->students_count = $course->enrollments_count;
        $course->average_rating = $course->reviews_avg_rating ?? 0;

        // Get modules with lessons
        $modules = $course->modules()
            ->where('is_published', true)
            ->orderBy('order')
            ->with(['lessons' => function ($query) {
                $query->where('is_published', true)->orderBy('order');
            }])
            ->get();

        // Get related courses
        $relatedCourses = Course::query()
            ->where('is_published', true)
            ->where('id', '!=', $course->id)
            ->when($course->category_id, function ($query) use ($course) {
                $query->where('category_id', $course->category_id);
            })
            ->with(['category', 'instructor'])
            ->withCount(['enrollments', 'reviews'])
            ->withAvg('reviews', 'rating')
            ->orderBy('is_featured', 'desc')
            ->limit(4)
            ->get()
            ->map(function ($relatedCourse) {
                $relatedCourse->students_count = $relatedCourse->enrollments_count;
                $relatedCourse->average_rating = $relatedCourse->reviews_avg_rating ?? 0;

                return $relatedCourse;
            });

        // Load reviews with pagination
        $reviews = $course->reviews()
            ->where('is_approved', true)
            ->with('user')
            ->orderBy('helpful_count', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Calculate rating distribution
        $ratingDistribution = $course->reviews()
            ->where('is_approved', true)
            ->selectRaw('rating, COUNT(*) as count')
            ->groupBy('rating')
            ->pluck('count', 'rating')
            ->toArray();

        // Fill missing ratings with 0
        for ($i = 5; $i >= 1; $i--) {
            if (! isset($ratingDistribution[$i])) {
                $ratingDistribution[$i] = 0;
            }
        }

        // Check if user can review (enrolled but hasn't reviewed)
        $canReview = auth()->check() &&
            $course->enrollments()->where('user_id', auth()->id())->exists() &&
            ! $course->reviews()->where('user_id', auth()->id())->exists();

        // Check if user is enrolled
        $isEnrolled = auth()->check() &&
            $course->enrollments()->where('user_id', auth()->id())->exists();

        // Get user's existing review
        $userReview = auth()->check()
            ? $course->reviews()->where('user_id', auth()->id())->first()
            : null;

        return view('course.show', [
            'course' => $course,
            'modules' => $modules,
            'relatedCourses' => $relatedCourses,
            'reviews' => $reviews,
            'ratingDistribution' => $ratingDistribution,
            'canReview' => $canReview,
            'isEnrolled' => $isEnrolled,
            'userReview' => $userReview,
        ]);
    }

    public function store(CourseStoreRequest $request): RedirectResponse
    {
        $course = Course::create($request->validated());

        ProcessCourseThumbnail::dispatch($course);

        $request->session()->flash('course.title', $course->title);

        return redirect()->route('course.show', ['course' => $course]);
    }

    public function update(CourseUpdateRequest $request, Course $course): RedirectResponse
    {
        $course->update($request->validated());

        $request->session()->flash('course.title', $course->title);

        return redirect()->route('course.show', ['course' => $course]);
    }

    public function destroy(Request $request, Course $course): RedirectResponse
    {
        $course->delete();

        return redirect()->route('course.index');
    }
}
