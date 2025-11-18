<?php

namespace App\Filament\Teacher\Resources\Certificates\Pages;

use App\Filament\Teacher\Resources\Certificates\CertificateResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCertificate extends EditRecord
{
    protected static string $resource = CertificateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
