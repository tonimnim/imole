<?php

namespace App\Filament\Teacher\Resources\Questions\Pages;

use App\Filament\Teacher\Resources\Questions\QuestionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListQuestions extends ListRecords
{
    protected static string $resource = QuestionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
