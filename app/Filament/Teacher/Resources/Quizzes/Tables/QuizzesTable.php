<?php

namespace App\Filament\Teacher\Resources\Quizzes\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class QuizzesTable
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
                TextColumn::make('duration_minutes')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('passing_score')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('max_attempts')
                    ->numeric()
                    ->sortable(),
                IconColumn::make('shuffle_questions')
                    ->boolean(),
                IconColumn::make('show_correct_answers')
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
