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
        $courses = Course::query()
            ->where('is_published', true)
            ->with(['category', 'instructor'])
            ->withCount(['enrollments', 'reviews'])
            ->withAvg('reviews', 'rating')
            ->orderBy('is_featured', 'desc')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($course) {
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
        ]);
    }

    public function show(Request $request, Course $course): View
    {
        // Load relationships
        $course->load(['category', 'instructor', 'modules.lessons']);

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

        return view('course.show', [
            'course' => $course,
            'modules' => $modules,
            'relatedCourses' => $relatedCourses,
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
