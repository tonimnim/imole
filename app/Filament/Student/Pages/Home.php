<?php

namespace App\Filament\Student\Pages;

use Filament\Pages\Page;

class Home extends Page
{
    protected static string $routePath = '/';

    protected static ?string $title = 'Home';

    public function getHeading(): string
    {
        return '';
    }

    public function getView(): string
    {
        return 'filament.student.pages.home';
    }

    public static function getNavigationIcon(): ?string
    {
        return 'heroicon-o-home';
    }

    public static function getNavigationSort(): ?int
    {
        return 1;
    }

    public function getTitle(): string
    {
        return 'Home';
    }

    public static function getNavigationLabel(): string
    {
        return 'Home';
    }
}
