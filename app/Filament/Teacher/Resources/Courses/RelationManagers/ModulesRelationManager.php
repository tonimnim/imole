<?php

namespace App\Filament\Teacher\Resources\Courses\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class ModulesRelationManager extends RelationManager
{
    protected static string $relationship = 'modules';

    protected static ?string $title = 'Modules';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                TextColumn::make('order')
                    ->sortable()
                    ->badge()
                    ->label('#'),

                TextColumn::make('title')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('lessons_count')
                    ->counts('lessons')
                    ->label('Lessons')
                    ->badge()
                    ->color('info'),

                IconColumn::make('is_published')
                    ->boolean()
                    ->label('Published'),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TernaryFilter::make('is_published')
                    ->label('Published')
                    ->placeholder('All modules')
                    ->trueLabel('Published only')
                    ->falseLabel('Unpublished only'),
            ])
            ->headerActions([
                CreateAction::make()
                    ->form([
                        \Filament\Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(255),
                        \Filament\Forms\Components\Textarea::make('description')
                            ->rows(3),
                        \Filament\Forms\Components\TextInput::make('order')
                            ->numeric()
                            ->required()
                            ->default(fn () => \App\Models\Module::where('course_id', request()->route('record'))->max('order') + 1),
                        \Filament\Forms\Components\Toggle::make('is_published')
                            ->label('Published')
                            ->default(true),
                    ]),
            ])
            ->actions([
                ViewAction::make()
                    ->url(fn ($record) => \App\Filament\Teacher\Resources\Modules\ModuleResource::getUrl('view', ['record' => $record])),
                EditAction::make()
                    ->form([
                        \Filament\Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(255),
                        \Filament\Forms\Components\Textarea::make('description')
                            ->rows(3),
                        \Filament\Forms\Components\TextInput::make('order')
                            ->numeric()
                            ->required(),
                        \Filament\Forms\Components\Toggle::make('is_published')
                            ->label('Published'),
                    ]),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('order');
    }
}
