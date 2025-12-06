<?php

namespace App\Filament\Teacher\Pages;

use App\Filament\Teacher\Widgets;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    // You can add widgets to the dashboard by overriding the getWidgets() method.
    public function getWidgets(): array
    {
        return [
            Widgets\StatsOverview::class,
            Widgets\LatestEnrollments::class,
            Widgets\LatestCourses::class,
        ];
    }
}
