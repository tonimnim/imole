<?php

namespace App\Filament\Teacher\Resources\Assignments\Pages;

use App\Filament\Teacher\Resources\Assignments\AssignmentResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditAssignment extends EditRecord
{
    protected static string $resource = AssignmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
