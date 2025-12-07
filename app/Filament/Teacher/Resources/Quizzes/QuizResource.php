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
use Illuminate\Database\Eloquent\Builder;

class QuizResource extends Resource
{
    protected static ?string $model = Quiz::class;

    /**
     * Only show quizzes for courses owned by the logged-in teacher.
     */
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->whereHas('course', function ($query) {
                $query->where('instructor_id', auth()->id());
            });
    }

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-question-mark-circle';

    protected static ?int $navigationSort = 13;

    protected static ?string $recordTitleAttribute = 'title';

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
