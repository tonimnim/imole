<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class TeacherReviewsController extends Controller
{
    public function index(Request $request): Response
    {
        $user = auth()->user();
        $courseIds = $user->courses()->pluck('id');

        $reviewsQuery = Review::whereIn('course_id', $courseIds)
            ->with(['user:id,name,avatar', 'course:id,title,slug']);

        // Filter by course
        if ($request->filled('course_id')) {
            $reviewsQuery->where('course_id', $request->course_id);
        }

        // Filter by rating
        if ($request->filled('rating')) {
            $reviewsQuery->where('rating', $request->rating);
        }

        $reviews = $reviewsQuery
            ->latest()
            ->paginate(15)
            ->through(fn ($review) => [
                'id' => $review->id,
                'rating' => $review->rating,
                'title' => $review->title,
                'comment' => $review->comment,
                'isApproved' => $review->is_approved,
                'helpfulCount' => $review->helpful_count,
                'student' => [
                    'id' => $review->user->id,
                    'name' => $review->user->name,
                    'avatar' => $review->user->avatar,
                    'avatarUrl' => $review->user->avatar ? asset('storage/'.$review->user->avatar) : null,
                ],
                'course' => [
                    'id' => $review->course->id,
                    'title' => $review->course->title,
                ],
                'createdAt' => $review->created_at->format('M d, Y'),
                'timeAgo' => $review->created_at->diffForHumans(),
            ]);

        // Stats
        $totalReviews = Review::whereIn('course_id', $courseIds)->count();
        $avgRating = Review::whereIn('course_id', $courseIds)->avg('rating') ?? 0;
        $ratingDistribution = Review::whereIn('course_id', $courseIds)
            ->selectRaw('rating, count(*) as count')
            ->groupBy('rating')
            ->pluck('count', 'rating')
            ->toArray();

        // Courses for filter
        $courses = $user->courses()->select('id', 'title')->get();

        return Inertia::render('Teacher/Reviews/Index', [
            'reviews' => $reviews,
            'stats' => [
                'total' => $totalReviews,
                'avgRating' => round($avgRating, 1),
                'distribution' => [
                    5 => $ratingDistribution[5] ?? 0,
                    4 => $ratingDistribution[4] ?? 0,
                    3 => $ratingDistribution[3] ?? 0,
                    2 => $ratingDistribution[2] ?? 0,
                    1 => $ratingDistribution[1] ?? 0,
                ],
            ],
            'courses' => $courses,
            'filters' => $request->only(['course_id', 'rating']),
        ]);
    }
}
