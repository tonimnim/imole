<?php

namespace App\Filament\Teacher\Resources\Courses\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class CourseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required(),
                TextInput::make('slug')
                    ->required(),
                TextInput::make('subtitle'),
                Textarea::make('description')
                    ->required()
                    ->columnSpanFull(),
                Textarea::make('objectives')
                    ->columnSpanFull(),
                Textarea::make('requirements')
                    ->columnSpanFull(),
                TextInput::make('level')
                    ->required()
                    ->default('beginner'),
                TextInput::make('language')
                    ->required()
                    ->default('en'),
                Select::make('instructor_id')
                    ->relationship('instructor', 'name')
                    ->required(),
                Select::make('category_id')
                    ->relationship('category', 'name')
                    ->required(),
                TextInput::make('thumbnail'),
                TextInput::make('preview_video'),
                TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->default(0)
                    ->prefix('$'),
                TextInput::make('currency')
                    ->required()
                    ->default('USD'),
                TextInput::make('discount_price')
                    ->numeric()
                    ->prefix('$'),
                TextInput::make('status')
                    ->required()
                    ->default('draft'),
                Toggle::make('is_published')
                    ->required(),
                DateTimePicker::make('published_at'),
                TextInput::make('duration_minutes')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('lessons_count')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('students_count')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('reviews_count')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('average_rating')
                    ->required()
                    ->numeric()
                    ->default(0),
                Toggle::make('is_featured')
                    ->required(),
                Toggle::make('has_certificate')
                    ->required(),
                Toggle::make('allow_reviews')
                    ->required(),
                TextInput::make('meta_title'),
                Textarea::make('meta_description')
                    ->columnSpanFull(),
            ]);
    }
}
