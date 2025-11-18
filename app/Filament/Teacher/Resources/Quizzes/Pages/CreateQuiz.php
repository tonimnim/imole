<?php

namespace App\Filament\Teacher\Resources\Quizzes\Pages;

use App\Filament\Teacher\Resources\Quizzes\QuizResource;
use Filament\Resources\Pages\CreateRecord;

class CreateQuiz extends CreateRecord
{
    protected static string $resource = QuizResource::class;
}
