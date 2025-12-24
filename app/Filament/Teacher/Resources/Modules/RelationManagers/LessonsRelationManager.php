<?php

namespace App\Filament\Teacher\Resources\Modules\RelationManagers;

use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class LessonsRelationManager extends RelationManager
{
    protected static string $relationship = 'lessons';

    protected static ?string $title = 'Lessons';

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
                    ->sortable()
                    ->limit(50),

                TextColumn::make('type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'video' => 'info',
                        'text' => 'gray',
                        'quiz' => 'warning',
                        'assignment' => 'danger',
                        default => 'gray',
                    }),

                TextColumn::make('duration_minutes')
                    ->label('Duration')
                    ->suffix(' min')
                    ->sortable(),

                IconColumn::make('is_free')
                    ->boolean()
                    ->label('Free Preview'),

                IconColumn::make('is_published')
                    ->boolean()
                    ->label('Published'),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->options([
                        'video' => 'Video',
                        'text' => 'Text/Article',
                        'quiz' => 'Quiz',
                        'assignment' => 'Assignment',
                    ]),

                TernaryFilter::make('is_published')
                    ->label('Published')
                    ->placeholder('All lessons')
                    ->trueLabel('Published only')
                    ->falseLabel('Drafts only'),

                TernaryFilter::make('is_free')
                    ->label('Free Preview')
                    ->placeholder('All lessons')
                    ->trueLabel('Free only')
                    ->falseLabel('Paid only'),
            ])
            ->headerActions([
                CreateAction::make()
                    ->mutateFormDataUsing(function (array $data): array {
                        $module = $this->getOwnerRecord();
                        $data['course_id'] = $module->course_id;

                        return $data;
                    })
                    ->form([
                        \Filament\Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($state, callable $set) {
                                $set('slug', Str::slug($state));
                            }),
                        \Filament\Forms\Components\TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->unique('lessons', 'slug', ignoreRecord: true),
                        \Filament\Forms\Components\Select::make('type')
                            ->options([
                                'video' => 'Video Lesson',
                                'text' => 'Text/Article',
                                'quiz' => 'Quiz',
                                'assignment' => 'Assignment',
                            ])
                            ->required()
                            ->default('video')
                            ->live(),
                        \Filament\Forms\Components\RichEditor::make('content')
                            ->required()
                            ->columnSpanFull(),
                        \Filament\Forms\Components\TextInput::make('video_url')
                            ->label('Video URL')
                            ->url()
                            ->maxLength(500)
                            ->visible(fn ($get) => $get('type') === 'video'),
                        \Filament\Forms\Components\Select::make('video_provider')
                            ->options([
                                'youtube' => 'YouTube',
                                'vimeo' => 'Vimeo',
                                'custom' => 'Custom',
                            ])
                            ->visible(fn ($get) => $get('type') === 'video'),
                        \Filament\Forms\Components\TextInput::make('duration_minutes')
                            ->label('Duration (minutes)')
                            ->numeric()
                            ->required()
                            ->default(0),
                        \Filament\Forms\Components\TextInput::make('order')
                            ->numeric()
                            ->required()
                            ->default(fn () => \App\Models\Lesson::where('module_id', $this->getOwnerRecord()->id)->max('order') + 1),
                        \Filament\Forms\Components\Toggle::make('is_free')
                            ->label('Free Preview')
                            ->default(false),
                        \Filament\Forms\Components\Toggle::make('is_published')
                            ->label('Published')
                            ->default(true),
                    ]),
            ])
            ->actions([
                ViewAction::make()
                    ->url(fn ($record) => \App\Filament\Teacher\Resources\Lessons\LessonResource::getUrl('view', ['record' => $record])),
                EditAction::make()
                    ->form([
                        \Filament\Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(255),
                        \Filament\Forms\Components\TextInput::make('slug')
                            ->required()
                            ->maxLength(255),
                        \Filament\Forms\Components\Select::make('type')
                            ->options([
                                'video' => 'Video Lesson',
                                'text' => 'Text/Article',
                                'quiz' => 'Quiz',
                                'assignment' => 'Assignment',
                            ])
                            ->required()
                            ->live(),
                        \Filament\Forms\Components\RichEditor::make('content')
                            ->required()
                            ->columnSpanFull(),
                        \Filament\Forms\Components\TextInput::make('video_url')
                            ->label('Video URL')
                            ->url()
                            ->maxLength(500)
                            ->visible(fn ($get) => $get('type') === 'video'),
                        \Filament\Forms\Components\Select::make('video_provider')
                            ->options([
                                'youtube' => 'YouTube',
                                'vimeo' => 'Vimeo',
                                'custom' => 'Custom',
                            ])
                            ->visible(fn ($get) => $get('type') === 'video'),
                        \Filament\Forms\Components\TextInput::make('duration_minutes')
                            ->label('Duration (minutes)')
                            ->numeric()
                            ->required(),
                        \Filament\Forms\Components\TextInput::make('order')
                            ->numeric()
                            ->required(),
                        \Filament\Forms\Components\Toggle::make('is_free')
                            ->label('Free Preview'),
                        \Filament\Forms\Components\Toggle::make('is_published')
                            ->label('Published'),
                    ]),
                DeleteAction::make(),
            ])
            ->defaultSort('order');
    }
}
