<?php

namespace App\Filament\Teacher\Resources\Questions\Pages;

use App\Filament\Teacher\Resources\Questions\QuestionResource;
use Filament\Resources\Pages\CreateRecord;

class CreateQuestion extends CreateRecord
{
    protected static string $resource = QuestionResource::class;
}
