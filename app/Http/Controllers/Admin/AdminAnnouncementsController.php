<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AdminAnnouncementsController extends Controller
{
    public function index(Request $request): Response
    {
        $query = Announcement::query()
            ->with(['instructor:id,name'])
            ->platformWide();

        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filter by audience
        if ($request->filled('audience')) {
            $query->where('target_audience', $request->audience);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('is_published', $request->status === 'published');
        }

        $announcements = $query->latest()
            ->paginate(15)
            ->withQueryString()
            ->through(fn ($announcement) => [
                'id' => $announcement->id,
                'title' => $announcement->title,
                'content' => $announcement->content,
                'type' => $announcement->type,
                'target_audience' => $announcement->target_audience,
                'is_published' => $announcement->is_published,
                'published_at' => $announcement->published_at?->format('M d, Y H:i'),
                'expires_at' => $announcement->expires_at?->format('M d, Y H:i'),
                'author' => $announcement->instructor?->name ?? 'System',
                'created_at' => $announcement->created_at->format('M d, Y'),
            ]);

        $stats = [
            'total' => Announcement::platformWide()->count(),
            'published' => Announcement::platformWide()->where('is_published', true)->count(),
            'active' => Announcement::platformWide()->active()->count(),
        ];

        return Inertia::render('Admin/Announcements/Index', [
            'announcements' => $announcements,
            'stats' => $stats,
            'filters' => $request->only(['type', 'audience', 'status']),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'type' => ['required', 'in:info,warning,urgent'],
            'target_audience' => ['required', 'in:all,students,teachers'],
            'is_published' => ['boolean'],
            'published_at' => ['nullable', 'date'],
            'expires_at' => ['nullable', 'date', 'after:published_at'],
        ]);

        Announcement::create([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'type' => $validated['type'],
            'target_audience' => $validated['target_audience'],
            'is_published' => $validated['is_published'] ?? true,
            'published_at' => $validated['published_at'] ?? now(),
            'expires_at' => $validated['expires_at'] ?? null,
            'instructor_id' => auth()->id(),
            'course_id' => null,
        ]);

        return back()->with('success', 'Announcement created successfully.');
    }

    public function update(Request $request, Announcement $announcement)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'type' => ['required', 'in:info,warning,urgent'],
            'target_audience' => ['required', 'in:all,students,teachers'],
            'is_published' => ['boolean'],
            'published_at' => ['nullable', 'date'],
            'expires_at' => ['nullable', 'date'],
        ]);

        $announcement->update($validated);

        return back()->with('success', 'Announcement updated successfully.');
    }

    public function togglePublish(Announcement $announcement)
    {
        $announcement->update([
            'is_published' => ! $announcement->is_published,
            'published_at' => ! $announcement->is_published ? now() : $announcement->published_at,
        ]);

        return back()->with('success', $announcement->is_published ? 'Announcement published.' : 'Announcement unpublished.');
    }

    public function destroy(Announcement $announcement)
    {
        $announcement->delete();

        return back()->with('success', 'Announcement deleted successfully.');
    }
}
