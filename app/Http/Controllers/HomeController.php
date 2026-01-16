<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Fetch featured courses (published, with relationships)
        $featuredCourses = Course::query()
            ->where('is_published', true)
            ->with(['category:id,name,slug', 'instructor:id,name,email'])
            ->withCount(['enrollments', 'reviews'])
            ->withAvg('reviews', 'rating')
            ->orderBy('is_featured', 'desc')
            ->orderBy('created_at', 'desc')
            ->limit(8)
            ->get()
            ->map(function ($course) {
                return [
                    'id' => $course->id,
                    'slug' => $course->slug,
                    'title' => $course->title,
                    'subtitle' => $course->subtitle,
                    'thumbnail' => $course->thumbnail,
                    'price' => $course->price,
                    'discount_price' => $course->discount_price,
                    'currency' => $course->currency ?? 'KES',
                    'level' => $course->level,
                    'is_featured' => $course->is_featured,
                    'average_rating' => round($course->reviews_avg_rating ?? 0, 1),
                    'reviews_count' => $course->reviews_count ?? 0,
                    'students_count' => $course->enrollments_count ?? 0,
                    'lessons_count' => $course->lessons_count ?? 0,
                    'duration_minutes' => $course->duration_minutes ?? 0,
                    'category' => $course->category ? [
                        'id' => $course->category->id,
                        'name' => $course->category->name,
                        'slug' => $course->category->slug,
                    ] : null,
                    'instructor' => $course->instructor ? [
                        'id' => $course->instructor->id,
                        'name' => $course->instructor->name,
                    ] : null,
                ];
            });

        // Fetch categories with course count
        $categories = Category::query()
            ->withCount('courses')
            ->orderBy('name')
            ->get();

        return view('welcome', [
            'featuredCourses' => $featuredCourses,
            'categories' => $categories,
        ]);
    }
}
