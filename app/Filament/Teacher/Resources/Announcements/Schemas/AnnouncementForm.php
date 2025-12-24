<?php

namespace App\Filament\Teacher\Resources\Announcements\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class AnnouncementForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('course_id')
                    ->relationship('course', 'title')
                    ->required(),
                Select::make('instructor_id')
                    ->relationship('instructor', 'name')
                    ->required(),
                TextInput::make('title')
                    ->required(),
                Textarea::make('content')
                    ->required()
                    ->columnSpanFull(),
                Toggle::make('is_published')
                    ->required(),
                DateTimePicker::make('published_at'),
            ]);
    }
}
