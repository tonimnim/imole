<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class TeacherProfileController extends Controller
{
    public function index(): Response
    {
        $user = auth()->user();
        $courseIds = $user->courses()->pluck('id');

        // Profile data
        $profile = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'avatar' => $user->avatar,
            'avatarUrl' => $user->avatar ? asset('storage/'.$user->avatar) : null,
            'headline' => $user->headline,
            'bio' => $user->bio,
            'expertise' => $user->expertise ?? [],
            'website' => $user->website,
            'twitter' => $user->twitter,
            'linkedin' => $user->linkedin,
            'youtube' => $user->youtube,
            'phone' => $user->phone,
            'location' => $user->location,
            'joinedAt' => $user->created_at->format('F Y'),
        ];

        // Teaching stats
        $stats = [
            'totalCourses' => $user->courses()->count(),
            'publishedCourses' => $user->courses()->where('is_published', true)->count(),
            'totalStudents' => $user->courses()
                ->withCount('enrollments')
                ->get()
                ->sum('enrollments_count'),
            'totalReviews' => Review::whereIn('course_id', $courseIds)->count(),
            'avgRating' => round(Review::whereIn('course_id', $courseIds)->avg('rating') ?? 0, 1),
        ];

        // Recent courses for preview
        $recentCourses = $user->courses()
            ->where('is_published', true)
            ->withCount(['enrollments', 'reviews'])
            ->withAvg('reviews', 'rating')
            ->latest()
            ->take(4)
            ->get()
            ->map(fn ($course) => [
                'id' => $course->id,
                'title' => $course->title,
                'thumbnail' => $course->thumbnail,
                'thumbnailUrl' => $course->thumbnail ? asset('storage/'.$course->thumbnail) : null,
                'studentsCount' => $course->enrollments_count,
                'reviewsCount' => $course->reviews_count,
                'avgRating' => round($course->reviews_avg_rating ?? 0, 1),
            ]);

        return Inertia::render('Teacher/Profile/Index', [
            'profile' => $profile,
            'stats' => $stats,
            'recentCourses' => $recentCourses,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'headline' => 'nullable|string|max:255',
            'bio' => 'nullable|string|max:2000',
            'expertise' => 'nullable|array',
            'expertise.*' => 'string|max:50',
            'website' => 'nullable|url|max:255',
            'twitter' => 'nullable|string|max:255',
            'linkedin' => 'nullable|string|max:255',
            'youtube' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'location' => 'nullable|string|max:100',
        ]);

        $user = auth()->user();
        $user->update($validated);

        return back()->with('success', 'Profile updated successfully.');
    }

    public function updateAvatar(Request $request): RedirectResponse
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $user = auth()->user();

        // Delete old avatar if exists
        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        // Store new avatar
        $path = $request->file('avatar')->store('avatars', 'public');
        $user->update(['avatar' => $path]);

        return back()->with('success', 'Profile photo updated successfully.');
    }

    public function removeAvatar(): RedirectResponse
    {
        $user = auth()->user();

        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        $user->update(['avatar' => null]);

        return back()->with('success', 'Profile photo removed.');
    }
}
