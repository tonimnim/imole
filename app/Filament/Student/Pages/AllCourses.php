<?php

namespace App\Filament\Student\Pages;

use Filament\Pages\Page;

class AllCourses extends Page
{
    protected static ?string $title = 'All Courses';

    public function getView(): string
    {
        return 'filament.student.pages.all-courses';
    }

    public static function getNavigationIcon(): ?string
    {
        return 'heroicon-o-academic-cap';
    }

    public static function getNavigationSort(): ?int
    {
        return 3;
    }

    public function getTitle(): string
    {
        return 'All Courses';
    }

    public static function getNavigationLabel(): string
    {
        return 'All Courses';
    }
}
