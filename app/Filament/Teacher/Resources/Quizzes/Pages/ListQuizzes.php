<?php

namespace App\Filament\Teacher\Resources\Quizzes\Pages;

use App\Filament\Teacher\Resources\Quizzes\QuizResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;

class ListQuizzes extends ListRecords
{
    protected static string $resource = QuizResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('quiz-builder')
                ->label('Quiz Builder')
                ->icon('heroicon-o-plus')
                ->url(route('teacher.quiz-builder'))
                ->color('primary'),
        ];
    }
}
