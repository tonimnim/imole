<?php

namespace App\Filament\Teacher\Resources\Assignments\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class AssignmentForm
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
                    ->required()
                    ->columnSpanFull(),
                Textarea::make('instructions')
                    ->columnSpanFull(),
                TextInput::make('attachments'),
                TextInput::make('max_score')
                    ->required()
                    ->numeric()
                    ->default(100),
                TextInput::make('max_file_size_mb')
                    ->required()
                    ->numeric()
                    ->default(10),
                TextInput::make('allowed_file_types'),
                DateTimePicker::make('due_date'),
                Toggle::make('late_submission_allowed')
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
