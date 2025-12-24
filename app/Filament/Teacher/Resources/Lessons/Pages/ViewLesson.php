<?php

namespace App\Filament\Teacher\Resources\Lessons\Pages;

use App\Filament\Teacher\Resources\Lessons\LessonResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewLesson extends ViewRecord
{
    protected static string $resource = LessonResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
