<?php

namespace App\Filament\Teacher\Resources\Questions;

use App\Filament\Teacher\Resources\Questions\Pages\CreateQuestion;
use App\Filament\Teacher\Resources\Questions\Pages\EditQuestion;
use App\Filament\Teacher\Resources\Questions\Pages\ListQuestions;
use App\Filament\Teacher\Resources\Questions\Schemas\QuestionForm;
use App\Filament\Teacher\Resources\Questions\Tables\QuestionsTable;
use App\Models\Question;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class QuestionResource extends Resource
{
    protected static ?string $model = Question::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $recordTitleAttribute = 'question_text';

    protected static \UnitEnum|string|null $navigationGroup = 'Student Engagement';

    public static function form(Schema $schema): Schema
    {
        return QuestionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return QuestionsTable::configure($table);
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
            'index' => ListQuestions::route('/'),
            'create' => CreateQuestion::route('/create'),
            'edit' => EditQuestion::route('/{record}/edit'),
        ];
    }
}
