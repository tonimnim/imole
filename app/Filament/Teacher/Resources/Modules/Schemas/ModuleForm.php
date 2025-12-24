<?php

namespace App\Filament\Teacher\Resources\Modules\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ModuleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Module Details')
                    ->schema([
                        Select::make('course_id')
                            ->label('Course')
                            ->relationship('course', 'title', fn ($query) => $query->where('instructor_id', auth()->id()))
                            ->required()
                            ->searchable()
                            ->preload()
                            ->helperText('Select the course this module belongs to'),

                        TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->helperText('Module title (e.g., "Introduction to Laravel")'),

                        Textarea::make('description')
                            ->rows(4)
                            ->columnSpanFull()
                            ->helperText('Brief description of what this module covers'),

                        TextInput::make('order')
                            ->label('Order')
                            ->required()
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->helperText('Display order (0 = first, 1 = second, etc.)'),

                        Toggle::make('is_published')
                            ->label('Published')
                            ->helperText('Make this module visible to students')
                            ->default(true),
                    ])
                    ->columns(2),
            ]);
    }
}
