<?php

namespace App\Filament\Teacher\Resources\Quizzes\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class QuizForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('course_id')
                    ->relationship('course', 'title')
                    ->required(),
                Select::make('lesson_id')
                    ->relationship('lesson', 'title'),
                TextInput::make('title')
                    ->required(),
                Textarea::make('description')
                    ->columnSpanFull(),
                TextInput::make('duration_minutes')
                    ->numeric(),
                TextInput::make('passing_score')
                    ->required()
                    ->numeric()
                    ->default(70),
                TextInput::make('max_attempts')
                    ->required()
                    ->numeric()
                    ->default(3),
                Toggle::make('shuffle_questions')
                    ->required(),
                Toggle::make('show_correct_answers')
                    ->required(),
                Toggle::make('is_published')
                    ->required(),
                TextInput::make('order')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }
}
