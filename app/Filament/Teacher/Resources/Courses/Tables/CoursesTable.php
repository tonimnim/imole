<?php

namespace App\Filament\Teacher\Resources\Courses\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CoursesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable(),
                TextColumn::make('slug')
                    ->searchable(),
                TextColumn::make('subtitle')
                    ->searchable(),
                TextColumn::make('level')
                    ->searchable(),
                TextColumn::make('language')
                    ->searchable(),
                TextColumn::make('instructor.name')
                    ->searchable(),
                TextColumn::make('category.name')
                    ->searchable(),
                TextColumn::make('thumbnail')
                    ->searchable(),
                TextColumn::make('preview_video')
                    ->searchable(),
                TextColumn::make('price')
                    ->money()
                    ->sortable(),
                TextColumn::make('currency')
                    ->searchable(),
                TextColumn::make('discount_price')
                    ->money()
                    ->sortable(),
                TextColumn::make('status')
                    ->searchable(),
                IconColumn::make('is_published')
                    ->boolean(),
                TextColumn::make('published_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('duration_minutes')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('lessons_count')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('students_count')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('reviews_count')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('average_rating')
                    ->numeric()
                    ->sortable(),
                IconColumn::make('is_featured')
                    ->boolean(),
                IconColumn::make('has_certificate')
                    ->boolean(),
                IconColumn::make('allow_reviews')
                    ->boolean(),
                TextColumn::make('meta_title')
                    ->searchable(),
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
