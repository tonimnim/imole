<?php

namespace App\Filament\Teacher\Resources\Courses\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class EnrollmentsRelationManager extends RelationManager
{
    protected static string $relationship = 'enrollments';

    protected static ?string $title = 'Enrollments';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('user.name')
            ->columns([
                TextColumn::make('user.name')
                    ->searchable()
                    ->sortable()
                    ->label('Student'),

                TextColumn::make('user.email')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'info',
                        'completed' => 'success',
                        'expired' => 'warning',
                        'cancelled' => 'danger',
                        default => 'gray',
                    }),

                TextColumn::make('progress_percentage')
                    ->label('Progress')
                    ->suffix('%')
                    ->sortable()
                    ->color(fn ($state) => $state >= 100 ? 'success' : ($state >= 50 ? 'warning' : 'danger')),

                TextColumn::make('enrolled_at')
                    ->dateTime()
                    ->sortable(),

                TextColumn::make('completed_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'active' => 'Active',
                        'completed' => 'Completed',
                        'expired' => 'Expired',
                        'cancelled' => 'Cancelled',
                    ]),
            ])
            ->defaultSort('enrolled_at', 'desc');
    }
}
