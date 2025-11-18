<?php

namespace App\Filament\Teacher\Resources\AssignmentSubmissions\Pages;

use App\Filament\Teacher\Resources\AssignmentSubmissions\AssignmentSubmissionResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditAssignmentSubmission extends EditRecord
{
    protected static string $resource = AssignmentSubmissionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
