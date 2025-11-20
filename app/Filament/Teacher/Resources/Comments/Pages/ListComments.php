<?php

namespace App\Filament\Teacher\Resources\Comments\Pages;

use App\Filament\Teacher\Resources\Comments\CommentResource;
use Filament\Resources\Pages\ListRecords;

class ListComments extends ListRecords
{
    protected static string $resource = CommentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //
        ];
    }
}
