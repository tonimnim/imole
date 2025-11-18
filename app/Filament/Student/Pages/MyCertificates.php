<?php

namespace App\Filament\Student\Pages;

use Filament\Pages\Page;

class MyCertificates extends Page
{
    protected static ?string $title = 'My Certificates';

    public function getView(): string
    {
        return 'filament.student.pages.my-certificates';
    }

    public static function getNavigationIcon(): ?string
    {
        return 'heroicon-o-trophy';
    }

    public static function getNavigationSort(): ?int
    {
        return 4;
    }

    public function getTitle(): string
    {
        return 'My Certificates';
    }

    public static function getNavigationLabel(): string
    {
        return 'My Certificates';
    }
}
