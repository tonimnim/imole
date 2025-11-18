<?php

namespace App\Filament\Teacher\Resources\Lessons\Pages;

use App\Filament\Teacher\Resources\Lessons\LessonResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListLessons extends ListRecords
{
    protected static string $resource = LessonResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
