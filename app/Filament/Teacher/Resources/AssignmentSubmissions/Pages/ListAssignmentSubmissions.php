<?php

namespace App\Filament\Teacher\Resources\AssignmentSubmissions\Pages;

use App\Filament\Teacher\Resources\AssignmentSubmissions\AssignmentSubmissionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAssignmentSubmissions extends ListRecords
{
    protected static string $resource = AssignmentSubmissionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
