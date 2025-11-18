<?php

namespace App\Filament\Teacher\Resources\Lessons\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class LessonForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('course_id')
                    ->relationship('course', 'title')
                    ->required(),
                Select::make('module_id')
                    ->relationship('module', 'title'),
                TextInput::make('title')
                    ->required(),
                TextInput::make('slug')
                    ->required(),
                Textarea::make('content')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('video_url')
                    ->url(),
                TextInput::make('video_provider'),
                TextInput::make('video_duration')
                    ->numeric(),
                TextInput::make('type')
                    ->required()
                    ->default('video'),
                TextInput::make('duration_minutes')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('order')
                    ->required()
                    ->numeric()
                    ->default(0),
                Toggle::make('is_free')
                    ->required(),
                Toggle::make('is_published')
                    ->required(),
            ]);
    }
}
