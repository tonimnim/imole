<?php

namespace App\Filament\Teacher\Resources\Courses;

use App\Filament\Teacher\Resources\Courses\Pages\CreateCourse;
use App\Filament\Teacher\Resources\Courses\Pages\EditCourse;
use App\Filament\Teacher\Resources\Courses\Pages\ListCourses;
use App\Filament\Teacher\Resources\Courses\Schemas\CourseForm;
use App\Filament\Teacher\Resources\Courses\Tables\CoursesTable;
use App\Models\Course;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CourseResource extends Resource
{
    protected static ?string $model = Course::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?int $navigationSort = -1;

    protected static ?string $navigationLabel = 'Courses';

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return CourseForm::configure($schema);
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
