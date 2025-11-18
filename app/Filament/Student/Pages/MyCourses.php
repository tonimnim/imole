<?php

namespace App\Filament\Student\Pages;

use Filament\Pages\Page;

class MyCourses extends Page
{
    protected static ?string $title = 'My Courses';

    public function getView(): string
    {
        return 'filament.student.pages.my-courses';
    }

    public static function getNavigationIcon(): ?string
    {
        return 'heroicon-o-book-open';
    }

    public static function getNavigationSort(): ?int
    {
        return 2;
    }

    public function getTitle(): string
    {
        return 'My Courses';
    }

    public static function getNavigationLabel(): string
    {
        return 'My Courses';
    }
}
