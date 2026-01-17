<?php

namespace App\Providers;

use App\Models\Announcement;
use App\Models\UserNotification;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Share unread notifications count with student layout
        View::composer('components.layouts.student', function ($view) {
            $user = auth()->user();
            $unreadNotifications = 0;

            if ($user) {
                // Get all active announcements for students
                $announcements = Announcement::query()
                    ->platformWide()
                    ->active()
                    ->forAudience('students')
                    ->pluck('id');

                // Get read notification IDs
                $readNotifications = UserNotification::query()
                    ->where('user_id', $user->id)
                    ->whereIn('announcement_id', $announcements)
                    ->where('is_read', true)
                    ->pluck('announcement_id');

                // Count unread
                $unreadNotifications = $announcements->diff($readNotifications)->count();
            }

            $view->with('unreadNotifications', $unreadNotifications);
        });
    }
}
