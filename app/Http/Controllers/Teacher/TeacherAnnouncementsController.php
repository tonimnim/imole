<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class TeacherAnnouncementsController extends Controller
{
    public function index(): Response
    {
        $user = auth()->user();
        $courseIds = $user->courses()->pluck('id');

        $announcements = Announcement::where('instructor_id', $user->id)
            ->with('course:id,title')
            ->latest()
            ->paginate(15)
            ->through(fn ($announcement) => [
                'id' => $announcement->id,
                'title' => $announcement->title,
                'content' => $announcement->content,
                'course' => $announcement->course ? [
                    'id' => $announcement->course->id,
                    'title' => $announcement->course->title,
                ] : null,
                'isPublished' => $announcement->is_published,
                'publishedAt' => $announcement->published_at?->format('M d, Y H:i'),
                'createdAt' => $announcement->created_at->format('M d, Y'),
            ]);

        // Stats
        $stats = [
            'total' => Announcement::where('instructor_id', $user->id)->count(),
            'published' => Announcement::where('instructor_id', $user->id)->where('is_published', true)->count(),
            'drafts' => Announcement::where('instructor_id', $user->id)->where('is_published', false)->count(),
        ];

        // Courses for the form
        $courses = $user->courses()->select('id', 'title')->get();

        return Inertia::render('Teacher/Announcements/Index', [
            'announcements' => $announcements,
            'stats' => $stats,
            'courses' => $courses,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'course_id' => 'nullable|exists:courses,id',
            'is_published' => 'boolean',
        ]);

        $user = auth()->user();

        // Verify course belongs to teacher if provided
        if ($validated['course_id']) {
            $courseExists = $user->courses()->where('id', $validated['course_id'])->exists();
            if (! $courseExists) {
                return back()->withErrors(['course_id' => 'Invalid course selected.']);
            }
        }

        Announcement::create([
            'instructor_id' => $user->id,
            'course_id' => $validated['course_id'],
            'title' => $validated['title'],
            'content' => $validated['content'],
            'is_published' => $validated['is_published'] ?? false,
            'published_at' => ($validated['is_published'] ?? false) ? now() : null,
        ]);

        return back()->with('success', 'Announcement created successfully.');
    }

    public function update(Request $request, Announcement $announcement): RedirectResponse
    {
        $user = auth()->user();

        // Verify ownership
        if ($announcement->instructor_id !== $user->id) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'course_id' => 'nullable|exists:courses,id',
            'is_published' => 'boolean',
        ]);

        // Verify course belongs to teacher if provided
        if ($validated['course_id']) {
            $courseExists = $user->courses()->where('id', $validated['course_id'])->exists();
            if (! $courseExists) {
                return back()->withErrors(['course_id' => 'Invalid course selected.']);
            }
        }

        $wasPublished = $announcement->is_published;
        $isNowPublished = $validated['is_published'] ?? false;

        $announcement->update([
            'course_id' => $validated['course_id'],
            'title' => $validated['title'],
            'content' => $validated['content'],
            'is_published' => $isNowPublished,
            'published_at' => (! $wasPublished && $isNowPublished) ? now() : $announcement->published_at,
        ]);

        return back()->with('success', 'Announcement updated successfully.');
    }

    public function destroy(Announcement $announcement): RedirectResponse
    {
        $user = auth()->user();

        // Verify ownership
        if ($announcement->instructor_id !== $user->id) {
            abort(403);
        }

        $announcement->delete();

        return back()->with('success', 'Announcement deleted successfully.');
    }
}
