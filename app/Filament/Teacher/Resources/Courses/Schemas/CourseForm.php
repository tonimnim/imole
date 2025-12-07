<?php

namespace App\Filament\Teacher\Resources\Courses\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;

class CourseForm
{
    public static function getSchema(): array
    {
        return [
            TextInput::make('title')
                ->required()
                ->maxLength(255),

            Select::make('category_id')
                ->label('Category')
                ->relationship('category', 'name')
                ->required()
                ->searchable()
                ->preload(),

            Textarea::make('description')
                ->required()
                ->rows(5)
                ->columnSpanFull(),

            Select::make('level')
                ->required()
                ->options([
                    'beginner' => 'Beginner',
                    'intermediate' => 'Intermediate',
                    'advanced' => 'Advanced',
                ])
                ->default('beginner'),

            TextInput::make('price')
                ->required()
                ->numeric()
                ->default(0)
                ->prefix('$')
                ->minValue(0),
        ];
    }
}
