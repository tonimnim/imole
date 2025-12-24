<?php

namespace App\Filament\Teacher\Resources\Questions\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class QuestionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('quiz_id')
                    ->relationship('quiz', 'title')
                    ->required(),
                Textarea::make('question_text')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('question_type')
                    ->required(),
                TextInput::make('options'),
                Textarea::make('correct_answer')
                    ->required()
                    ->columnSpanFull(),
                Textarea::make('explanation')
                    ->columnSpanFull(),
                TextInput::make('points')
                    ->required()
                    ->numeric()
                    ->default(1),
                TextInput::make('order')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }
}
