<?php

namespace App\Filament\Teacher\Resources\Courses\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class AnnouncementsRelationManager extends RelationManager
{
    protected static string $relationship = 'announcements';

    protected static ?string $title = 'Announcements';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->limit(50),

                TextColumn::make('content')
                    ->html()
                    ->limit(100)
                    ->searchable()
                    ->wrap(),

                IconColumn::make('is_published')
                    ->boolean()
                    ->label('Published'),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Posted'),
            ])
            ->filters([
                TernaryFilter::make('is_published')
                    ->label('Published')
                    ->placeholder('All announcements')
                    ->trueLabel('Published only')
                    ->falseLabel('Drafts only'),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
