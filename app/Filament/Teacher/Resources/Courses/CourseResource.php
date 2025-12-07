<?php

namespace App\Filament\Teacher\Resources\Courses;

use App\Filament\Teacher\Resources\Courses\Pages\CreateCourse;
use App\Filament\Teacher\Resources\Courses\Pages\EditCourse;
use App\Filament\Teacher\Resources\Courses\Pages\ListCourses;
use App\Filament\Teacher\Resources\Courses\Schemas\CourseForm;
use App\Filament\Teacher\Resources\Courses\Tables\CoursesTable;
use App\Models\Course;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class CourseResource extends Resource
{
    protected static ?string $model = Course::class;

    /**
     * Only show courses owned by the logged-in teacher.
     */
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('instructor_id', auth()->id());
    }

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-book-open';

    protected static ?int $navigationSort = -1;

    protected static ?string $navigationLabel = 'Courses';

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return $schema->components(CourseForm::getSchema());
    }

    public static function table(Table $table): Table
    {
        return CoursesTable::configure($table);
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
            'index' => ListCourses::route('/'),
            'create' => CreateCourse::route('/create'),
            'edit' => EditCourse::route('/{record}/edit'),
        ];
    }
}
