<?php

namespace App\Filament\Teacher\Resources\Comments\Schemas;

use Filament\Schemas\Components\RichEditor;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CommentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Response')
                    ->schema([
                        RichEditor::make('content')
                            ->label('Your Response')
                            ->required()
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
