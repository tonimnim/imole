<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Course;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class TeacherCourseFormController extends Controller
{
    public function create(): Response
    {
        $categories = Category::where('is_active', true)->orderBy('name')->get(['id', 'name']);

        return Inertia::render('Teacher/Courses/Create', [
            'categories' => $categories,
            'isEdit' => false,
            'course' => null,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'level' => 'required|in:beginner,intermediate,advanced',
            'language' => 'required|string|max:50',
            'objectives' => 'nullable|string',
            'requirements' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'has_certificate' => 'boolean',
            'allow_reviews' => 'boolean',
            'status' => 'required|in:draft,published',
        ]);

        $validated['slug'] = Str::slug($validated['title']).'-'.Str::random(6);
        $validated['instructor_id'] = auth()->id();
        $validated['is_published'] = $validated['status'] === 'published';
        $validated['currency'] = 'USD';
        $validated['price'] = $validated['price'] ?? 0;
        $validated['discount_price'] = $validated['discount_price'] ?? 0;

        Course::create($validated);

        return redirect()->route('teacher.courses')->with('success', 'Course created successfully');
    }

    public function edit(Course $course): Response
    {
        if ($course->instructor_id !== auth()->id()) {
            abort(403);
        }

        $categories = Category::where('is_active', true)->orderBy('name')->get(['id', 'name']);

        $courseData = [
            'id' => $course->id,
            'title' => $course->title,
            'slug' => $course->slug,
            'subtitle' => $course->subtitle,
            'description' => $course->description,
            'category_id' => $course->category_id,
            'level' => $course->level,
            'language' => $course->language,
            'objectives' => $course->objectives,
            'requirements' => $course->requirements,
            'price' => $course->price,
            'discount_price' => $course->discount_price,
            'has_certificate' => $course->has_certificate,
            'allow_reviews' => $course->allow_reviews,
            'status' => $course->status,
            'is_published' => $course->is_published,
            'thumbnail' => $course->thumbnail ? asset('storage/'.$course->thumbnail) : null,
        ];

        return Inertia::render('Teacher/Courses/Edit', [
            'course' => $courseData,
            'categories' => $categories,
        ]);
    }

    public function update(Request $request, Course $course): RedirectResponse
    {
        if ($course->instructor_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'level' => 'required|in:beginner,intermediate,advanced',
            'language' => 'required|string|max:50',
            'objectives' => 'nullable|string',
            'requirements' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'has_certificate' => 'boolean',
            'allow_reviews' => 'boolean',
            'status' => 'required|in:draft,published',
        ]);

        $validated['is_published'] = $validated['status'] === 'published';
        $validated['price'] = $validated['price'] ?? 0;
        $validated['discount_price'] = $validated['discount_price'] ?? 0;

        $course->update($validated);

        return redirect()->route('teacher.courses')->with('success', 'Course updated successfully');
    }
}
