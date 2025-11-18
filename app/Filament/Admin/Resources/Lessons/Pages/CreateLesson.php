<?php

namespace App\Filament\Admin\Resources\Lessons\Pages;

use App\Filament\Admin\Resources\Lessons\LessonResource;
use Filament\Resources\Pages\CreateRecord;

class CreateLesson extends CreateRecord
{
    protected static string $resource = LessonResource::class;
}
