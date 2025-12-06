<?php

namespace App\Filament\Teacher\Resources\Courses\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
<<<<<<< HEAD
use Filament\Schemas\Schema;
=======
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Wizard;
use Illuminate\Support\Str;
>>>>>>> ce9ee18 (student+teacher)

class CourseForm
{
    public static function getSchema(): array
    {
<<<<<<< HEAD
        return $schema
            ->components([
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
            ]);
=======
        return [
            Wizard::make([
                Wizard\Step::make('Course Details')
                    ->schema([
                        TextInput::make('title')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (string $operation, $state, callable $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null),
                        TextInput::make('slug')
                            ->required()
                            ->unique(ignoreRecord: true),
                        TextInput::make('subtitle'),
                        Textarea::make('description')
                            ->required()
                            ->columnSpanFull(),
                        Select::make('category_id')
                            ->relationship('category', 'name')
                            ->required(),
                    ]),
                Wizard\Step::make('Media')
                    ->schema([
                        TextInput::make('thumbnail'),
                        TextInput::make('preview_video'),
                    ]),
                Wizard\Step::make('Pricing')
                    ->schema([
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
                    ]),
                Wizard\Step::make('Settings')
                    ->schema([
                        TextInput::make('status')
                            ->required()
                            ->default('draft'),
                        Toggle::make('is_published')
                            ->required(),
                        DateTimePicker::make('published_at'),
                        Toggle::make('is_featured')
                            ->required(),
                        Toggle::make('has_certificate')
                            ->required(),
                        Toggle::make('allow_reviews')
                            ->required(),
                    ]),
            ])->columnSpanFull(),
        ];
>>>>>>> ce9ee18 (student+teacher)
    }
}
