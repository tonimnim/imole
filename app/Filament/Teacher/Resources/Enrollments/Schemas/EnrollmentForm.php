<?php

namespace App\Filament\Teacher\Resources\Enrollments\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class EnrollmentForm
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
                DateTimePicker::make('enrolled_at')
                    ->required(),
                DateTimePicker::make('started_at'),
                DateTimePicker::make('completed_at'),
                DateTimePicker::make('expires_at'),
                TextInput::make('progress_percentage')
                    ->required()
                    ->numeric()
                    ->default(0),
                DateTimePicker::make('last_accessed_at'),
                Select::make('payment_id')
                    ->relationship('payment', 'id'),
                TextInput::make('price_paid')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('status')
                    ->required()
                    ->default('active'),
            ]);
    }
}
