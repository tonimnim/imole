<?php

namespace App\Filament\Teacher\Resources\Modules\Pages;

use App\Filament\Teacher\Resources\Modules\ModuleResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewModule extends ViewRecord
{
    protected static string $resource = ModuleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
