<?php

namespace App\Filament\Teacher\Resources\Lessons;

use App\Filament\Teacher\Resources\Lessons\Pages\CreateLesson;
use App\Filament\Teacher\Resources\Lessons\Pages\EditLesson;
use App\Filament\Teacher\Resources\Lessons\Pages\ListLessons;
use App\Filament\Teacher\Resources\Lessons\Pages\ViewLesson;
use App\Filament\Teacher\Resources\Lessons\Schemas\LessonForm;
use App\Filament\Teacher\Resources\Lessons\Tables\LessonsTable;
use App\Models\Lesson;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class LessonResource extends Resource
{
    protected static ?string $model = Lesson::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 3;

    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return LessonForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return LessonsTable::configure($table);
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
            'index' => ListLessons::route('/'),
            'create' => CreateLesson::route('/create'),
            'view' => ViewLesson::route('/{record}'),
            'edit' => EditLesson::route('/{record}/edit'),
        ];
    }
}
