<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Course;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StudentHomeController extends Controller
{
    public function categories(): JsonResponse
    {
        $categories = Category::query()
            ->where('is_active', true)
            ->orderBy('order')
            ->get(['id', 'name', 'slug']);

        return response()->json($categories);
    }

    public function courses(Request $request): JsonResponse
    {
        $query = Course::query()
            ->where('is_published', true)
            ->with(['category:id,name', 'instructor:id,name'])
            ->withCount('lessons');

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        $courses = $query->orderBy('created_at', 'desc')->get();

        return response()->json($courses->map(function ($course) {
            return [
                'id' => $course->id,
                'title' => $course->title,
                'slug' => $course->slug,
                'description' => $course->description,
                'thumbnail' => $course->thumbnail,
                'price' => $course->price,
                'level' => $course->level ?? 'beginner',
                'lessons_count' => $course->lessons_count,
                'category' => $course->category ? [
                    'id' => $course->category->id,
                    'name' => $course->category->name,
                ] : null,
                'instructor' => $course->instructor ? [
                    'id' => $course->instructor->id,
                    'name' => $course->instructor->name,
                ] : null,
            ];
        }));
    }
}
