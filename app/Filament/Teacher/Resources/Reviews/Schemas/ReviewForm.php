<?php

namespace App\Filament\Teacher\Resources\Reviews\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ReviewForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                Select::make('course_id')
                    ->relationship('course', 'title')
                    ->required(),
                TextInput::make('rating')
                    ->required()
                    ->numeric(),
                TextInput::make('title'),
                Textarea::make('comment')
                    ->columnSpanFull(),
                Toggle::make('is_approved')
                    ->required(),
                DateTimePicker::make('approved_at'),
                TextInput::make('helpful_count')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }
}
