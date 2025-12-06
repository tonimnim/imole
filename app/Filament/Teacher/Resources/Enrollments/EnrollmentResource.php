<?php

namespace App\Filament\Teacher\Resources\Enrollments;

use App\Filament\Teacher\Resources\Enrollments\Pages\CreateEnrollment;
use App\Filament\Teacher\Resources\Enrollments\Pages\EditEnrollment;
use App\Filament\Teacher\Resources\Enrollments\Pages\ListEnrollments;
use App\Filament\Teacher\Resources\Enrollments\Schemas\EnrollmentForm;
use App\Filament\Teacher\Resources\Enrollments\Tables\EnrollmentsTable;
use App\Models\Enrollment;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class EnrollmentResource extends Resource
{
    protected static ?string $model = Enrollment::class;

<<<<<<< HEAD
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserGroup;

    protected static ?int $navigationSort = 20;

    protected static ?string $navigationLabel = 'Students';

    protected static ?string $pluralModelLabel = 'Students';
=======
    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static \UnitEnum|string|null $navigationGroup = 'Student Engagement';
>>>>>>> ce9ee18 (student+teacher)

    public static function form(Schema $schema): Schema
    {
        return EnrollmentForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return EnrollmentsTable::configure($table);
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Performance';
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
            'index' => ListEnrollments::route('/'),
            'create' => CreateEnrollment::route('/create'),
            'edit' => EditEnrollment::route('/{record}/edit'),
        ];
    }
}
