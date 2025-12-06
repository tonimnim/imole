<?php

namespace App\Filament\Teacher\Resources\Quizzes;

use App\Filament\Teacher\Resources\Quizzes\Pages\CreateQuiz;
use App\Filament\Teacher\Resources\Quizzes\Pages\EditQuiz;
use App\Filament\Teacher\Resources\Quizzes\Pages\ListQuizzes;
use App\Filament\Teacher\Resources\Quizzes\Schemas\QuizForm;
use App\Filament\Teacher\Resources\Quizzes\Tables\QuizzesTable;
use App\Models\Quiz;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class QuizResource extends Resource
{
    protected static ?string $model = Quiz::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 13;

    protected static ?string $recordTitleAttribute = 'title';

    protected static \UnitEnum|string|null $navigationGroup = 'Student Engagement';

    public static function form(Schema $schema): Schema
    {
        return QuizForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return QuizzesTable::configure($table);
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
            'index' => ListQuizzes::route('/'),
            'create' => CreateQuiz::route('/create'),
            'edit' => EditQuiz::route('/{record}/edit'),
        ];
    }
}
