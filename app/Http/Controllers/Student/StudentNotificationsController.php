<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\UserNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class StudentNotificationsController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();

        // Get platform-wide announcements targeting students or all users
        $announcements = Announcement::query()
            ->platformWide()
            ->active()
            ->forAudience('students')
            ->with(['instructor:id,name'])
            ->latest()
            ->get();

        // Get existing notification records for read status
        $readNotifications = UserNotification::query()
            ->where('user_id', $user->id)
            ->whereIn('announcement_id', $announcements->pluck('id'))
            ->pluck('announcement_id')
            ->toArray();

        // Map announcements with read status
        $notifications = $announcements->map(fn ($announcement) => [
            'id' => $announcement->id,
            'title' => $announcement->title,
            'content' => $announcement->content,
            'type' => $announcement->type,
            'is_read' => in_array($announcement->id, $readNotifications),
            'author' => $announcement->instructor?->name ?? 'System',
            'created_at' => $announcement->created_at->format('M d, Y'),
            'created_at_diff' => $announcement->created_at->diffForHumans(),
        ]);

        // Count unread notifications
        $unreadCount = $notifications->where('is_read', false)->count();

        return view('student.notifications', [
            'notifications' => $notifications,
            'unreadCount' => $unreadCount,
        ]);
    }

    public function markAsRead(Announcement $announcement): RedirectResponse
    {
        $user = auth()->user();

        UserNotification::updateOrCreate(
            [
                'user_id' => $user->id,
                'announcement_id' => $announcement->id,
            ],
            [
                'is_read' => true,
                'read_at' => now(),
            ]
        );

        return back()->with('success', 'Notification marked as read.');
    }

    public function markAllAsRead(): RedirectResponse
    {
        $user = auth()->user();

        // Get all active announcements for this user
        $announcements = Announcement::query()
            ->platformWide()
            ->active()
            ->forAudience('students')
            ->pluck('id');

        // Mark all as read
        foreach ($announcements as $announcementId) {
            UserNotification::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'announcement_id' => $announcementId,
                ],
                [
                    'is_read' => true,
                    'read_at' => now(),
                ]
            );
        }

        return back()->with('success', 'All notifications marked as read.');
    }
}
