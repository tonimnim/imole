<?php

namespace App\Filament\Teacher\Resources\Announcements;

use App\Filament\Teacher\Resources\Announcements\Pages\CreateAnnouncement;
use App\Filament\Teacher\Resources\Announcements\Pages\EditAnnouncement;
use App\Filament\Teacher\Resources\Announcements\Pages\ListAnnouncements;
use App\Filament\Teacher\Resources\Announcements\Schemas\AnnouncementForm;
use App\Filament\Teacher\Resources\Announcements\Tables\AnnouncementsTable;
use App\Models\Announcement;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class AnnouncementResource extends Resource
{
    protected static ?string $model = Announcement::class;

<<<<<<< HEAD
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedMegaphone;

    protected static ?int $navigationSort = 21;
=======
    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-rectangle-stack';
>>>>>>> ce9ee18 (student+teacher)

    protected static ?string $recordTitleAttribute = 'title';

    protected static \UnitEnum|string|null $navigationGroup = 'Communication';

    public static function form(Schema $schema): Schema
    {
        return AnnouncementForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AnnouncementsTable::configure($table);
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Communication';
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAnnouncements::route('/'),
            'create' => CreateAnnouncement::route('/create'),
            'edit' => EditAnnouncement::route('/{record}/edit'),
        ];
    }
}
