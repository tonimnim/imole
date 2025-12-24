<?php

namespace App\Filament\Teacher\Resources\Courses\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class ReviewsRelationManager extends RelationManager
{
    protected static string $relationship = 'reviews';

    protected static ?string $title = 'Reviews';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('user.name')
            ->columns([
                TextColumn::make('user.name')
                    ->searchable()
                    ->sortable()
                    ->label('Student'),

                TextColumn::make('rating')
                    ->badge()
                    ->color(fn (int $state): string => match (true) {
                        $state >= 4 => 'success',
                        $state >= 3 => 'warning',
                        default => 'danger',
                    })
                    ->formatStateUsing(fn ($state) => str_repeat('⭐', $state)),

                TextColumn::make('comment')
                    ->limit(50)
                    ->searchable()
                    ->wrap(),

                IconColumn::make('is_approved')
                    ->boolean()
                    ->label('Approved'),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Posted'),
            ])
            ->filters([
                SelectFilter::make('rating')
                    ->options([
                        5 => '5 Stars',
                        4 => '4 Stars',
                        3 => '3 Stars',
                        2 => '2 Stars',
                        1 => '1 Star',
                    ]),

                TernaryFilter::make('is_approved')
                    ->label('Approved')
                    ->placeholder('All reviews')
                    ->trueLabel('Approved only')
                    ->falseLabel('Pending approval'),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
