<?php

namespace App\Filament\Teacher\Resources\Announcements\Pages;

use App\Filament\Teacher\Resources\Announcements\AnnouncementResource;
use Filament\Resources\Pages\CreateRecord;

class CreateAnnouncement extends CreateRecord
{
    protected static string $resource = AnnouncementResource::class;
}
