<?php

namespace App\Filament\Teacher\Resources\Lessons\Pages;

use App\Filament\Teacher\Resources\Lessons\LessonResource;
use Filament\Resources\Pages\CreateRecord;

class CreateLesson extends CreateRecord
{
    protected static string $resource = LessonResource::class;
}
