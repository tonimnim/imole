<?php

namespace App\Filament\Teacher\Resources\Courses\Pages;

use App\Filament\Teacher\Resources\Courses\CourseResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCourse extends CreateRecord
{
    protected static string $resource = CourseResource::class;
}
