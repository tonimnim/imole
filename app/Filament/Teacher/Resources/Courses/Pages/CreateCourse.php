<?php

namespace App\Filament\Teacher\Resources\Courses\Pages;

use App\Filament\Teacher\Resources\Courses\CourseResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCourse extends CreateRecord
{
    protected static string $resource = CourseResource::class;

    protected function getFormActions(): array
    {
        return [
            $this->getCreateFormAction(),
            $this->getCancelFormAction(),
        ];
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['slug'] = \Illuminate\Support\Str::slug($data['title']);
        $data['instructor_id'] = auth()->id();
        $data['language'] = 'en';
        $data['currency'] = 'USD';
        $data['status'] = 'draft';
        $data['is_published'] = false;

        return $data;
    }
}
