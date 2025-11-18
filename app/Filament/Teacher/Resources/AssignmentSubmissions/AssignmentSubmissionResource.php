<?php

namespace App\Filament\Teacher\Resources\AssignmentSubmissions;

use App\Filament\Teacher\Resources\AssignmentSubmissions\Pages\CreateAssignmentSubmission;
use App\Filament\Teacher\Resources\AssignmentSubmissions\Pages\EditAssignmentSubmission;
use App\Filament\Teacher\Resources\AssignmentSubmissions\Pages\ListAssignmentSubmissions;
use App\Filament\Teacher\Resources\AssignmentSubmissions\Schemas\AssignmentSubmissionForm;
use App\Filament\Teacher\Resources\AssignmentSubmissions\Tables\AssignmentSubmissionsTable;
use App\Models\AssignmentSubmission;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AssignmentSubmissionResource extends Resource
{
    protected static ?string $model = AssignmentSubmission::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return AssignmentSubmissionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AssignmentSubmissionsTable::configure($table);
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
            'index' => ListAssignmentSubmissions::route('/'),
            'create' => CreateAssignmentSubmission::route('/create'),
            'edit' => EditAssignmentSubmission::route('/{record}/edit'),
        ];
    }
}
