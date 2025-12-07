<?php

namespace App\Filament\Teacher\Resources\Assignments;

use App\Filament\Teacher\Resources\Assignments\Pages\CreateAssignment;
use App\Filament\Teacher\Resources\Assignments\Pages\EditAssignment;
use App\Filament\Teacher\Resources\Assignments\Pages\ListAssignments;
use App\Filament\Teacher\Resources\Assignments\Schemas\AssignmentForm;
use App\Filament\Teacher\Resources\Assignments\Tables\AssignmentsTable;
use App\Models\Assignment;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class AssignmentResource extends Resource
{
    protected static ?string $model = Assignment::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?int $navigationSort = 10;

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return AssignmentForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AssignmentsTable::configure($table);
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
            'index' => ListAssignments::route('/'),
            'create' => CreateAssignment::route('/create'),
            'edit' => EditAssignment::route('/{record}/edit'),
        ];
    }
}
