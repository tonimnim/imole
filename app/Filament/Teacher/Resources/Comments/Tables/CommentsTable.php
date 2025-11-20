<?php

namespace App\Filament\Teacher\Resources\Comments\Tables;

use Filament\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class CommentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('lesson.title')
                    ->label('Lesson')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('user.name')
                    ->label('Student')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('content')
                    ->label('Question')
                    ->limit(50)
                    ->searchable()
                    ->html(),

                TextColumn::make('parent')
                    ->label('Has Answer')
                    ->badge()
                    ->getStateUsing(fn ($record) => $record->children()->exists() ? 'Answered' : 'No Answer')
                    ->color(fn (string $state): string => match ($state) {
                        'Answered' => 'success',
                        'No Answer' => 'warning',
                    }),

                TextColumn::make('created_at')
                    ->label('Asked On')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('lesson')
                    ->relationship('lesson', 'title')
                    ->searchable()
                    ->preload(),

                SelectFilter::make('answered')
                    ->options([
                        'answered' => 'Answered',
                        'unanswered' => 'Unanswered',
                    ])
                    ->query(function ($query, $state) {
                        if ($state['value'] === 'answered') {
                            $query->has('children');
                        } elseif ($state['value'] === 'unanswered') {
                            $query->doesntHave('children');
                        }
                    }),
            ])
            ->actions([
                Action::make('view')
                    ->label('View')
                    ->icon('heroicon-o-eye')
                    ->modalHeading(fn ($record) => 'Question from ' . $record->user->name)
                    ->modalContent(fn ($record) => view('components.comment-view', ['record' => $record])),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
