<?php

namespace App\Filament\Teacher\Widgets;

use App\Models\Course;
use App\Models\Enrollment;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Courses', Course::where('instructor_id', auth()->id())->count())
                ->description('The total number of courses you have created')
                ->color('primary'),
            Stat::make('Total Students', Enrollment::whereIn('course_id', Course::where('instructor_id', auth()->id())->pluck('id'))->distinct('user_id')->count())
                ->description('The total number of unique students enrolled in your courses')
                ->color('success'),
            Stat::make('Total Enrollments', Enrollment::whereIn('course_id', Course::where('instructor_id', auth()->id())->pluck('id'))->count())
                ->description('The total number of enrollments in your courses')
                ->color('info'),
        ];
    }
}
