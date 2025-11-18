<?php

namespace App\Filament\Teacher\Resources\Certificates\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CertificateForm
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
                Select::make('enrollment_id')
                    ->relationship('enrollment', 'id')
                    ->required(),
                TextInput::make('certificate_number')
                    ->required(),
                DateTimePicker::make('issued_at')
                    ->required(),
                DateTimePicker::make('valid_until'),
                TextInput::make('file_path'),
            ]);
    }
}
