<?php

namespace App\Filament\Teacher\Resources\AssignmentSubmissions\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class AssignmentSubmissionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('assignment_id')
                    ->relationship('assignment', 'title')
                    ->required(),
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                Textarea::make('content')
                    ->columnSpanFull(),
                TextInput::make('file_path'),
                TextInput::make('file_name'),
                TextInput::make('score')
                    ->numeric(),
                TextInput::make('max_score')
                    ->required()
                    ->numeric(),
                Textarea::make('feedback')
                    ->columnSpanFull(),
                TextInput::make('graded_by')
                    ->numeric(),
                DateTimePicker::make('graded_at'),
                DateTimePicker::make('submitted_at')
                    ->required(),
                Toggle::make('is_late')
                    ->required(),
                TextInput::make('status')
                    ->required()
                    ->default('submitted'),
            ]);
    }
}
