<?php

namespace App\Filament\Teacher\Resources\Assignments\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AssignmentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('course.title')
                    ->searchable(),
                TextColumn::make('lesson.title')
                    ->searchable(),
                TextColumn::make('title')
                    ->searchable(),
                TextColumn::make('max_score')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('max_file_size_mb')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('allowed_file_types')
                    ->searchable(),
                TextColumn::make('due_date')
                    ->dateTime()
                    ->sortable(),
                IconColumn::make('late_submission_allowed')
                    ->boolean(),
                IconColumn::make('is_published')
                    ->boolean(),
                TextColumn::make('order')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
