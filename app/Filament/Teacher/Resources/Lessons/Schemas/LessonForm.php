<?php

namespace App\Filament\Teacher\Resources\Lessons\Schemas;

use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class LessonForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Basic Information')
                    ->schema([
                        Select::make('course_id')
                            ->label('Course')
                            ->relationship('course', 'title', fn ($query) => $query->where('instructor_id', auth()->id()))
                            ->required()
                            ->searchable()
                            ->preload()
                            ->live()
                            ->helperText('Select the course this lesson belongs to'),

                        Select::make('module_id')
                            ->label('Module')
                            ->relationship('module', 'title', fn ($query, $get) => $query->where('course_id', $get('course_id')))
                            ->searchable()
                            ->preload()
                            ->helperText('Optional: Assign to a specific module'),

                        TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($state, callable $set, $get) {
                                if (! $get('slug')) {
                                    $slug = Str::slug($state);
                                    $originalSlug = $slug;
                                    $counter = 1;

                                    // Check if slug exists and add counter if needed
                                    while (\App\Models\Lesson::where('slug', $slug)->exists()) {
                                        $slug = $originalSlug.'-'.$counter;
                                        $counter++;
                                    }

                                    $set('slug', $slug);
                                }
                            })
                            ->helperText('Lesson title'),

                        TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->helperText('URL-friendly identifier (auto-generated, editable)'),

                        Select::make('type')
                            ->required()
                            ->options([
                                'video' => 'Video Lesson',
                                'text' => 'Text/Article',
                                'quiz' => 'Quiz',
                                'assignment' => 'Assignment',
                            ])
                            ->default('video')
                            ->live()
                            ->helperText('Type of lesson content'),

                        TextInput::make('order')
                            ->label('Order')
                            ->required()
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->helperText('Display order within module/course'),
                    ])
                    ->columns(2),

                Section::make('Lesson Content')
                    ->schema([
                        RichEditor::make('content')
                            ->required()
                            ->columnSpanFull()
                            ->helperText('Lesson description and learning materials')
                            ->toolbarButtons([
                                'bold',
                                'italic',
                                'underline',
                                'link',
                                'bulletList',
                                'orderedList',
                                'h2',
                                'h3',
                                'blockquote',
                                'codeBlock',
                            ]),
                    ]),

                Section::make('Video Settings')
                    ->schema([
                        TextInput::make('video_url')
                            ->label('Video URL')
                            ->url()
                            ->maxLength(500)
                            ->helperText('YouTube, Vimeo, or direct video URL'),

                        Select::make('video_provider')
                            ->label('Video Provider')
                            ->options([
                                'youtube' => 'YouTube',
                                'vimeo' => 'Vimeo',
                                'custom' => 'Custom/Self-hosted',
                            ])
                            ->helperText('Where is the video hosted?'),

                        TextInput::make('video_duration')
                            ->label('Video Duration (seconds)')
                            ->numeric()
                            ->minValue(0)
                            ->helperText('Duration in seconds (e.g., 300 for 5 minutes)'),

                        TextInput::make('duration_minutes')
                            ->label('Estimated Completion Time (minutes)')
                            ->required()
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->helperText('How long will it take to complete this lesson?'),
                    ])
                    ->columns(2)
                    ->visible(fn ($get) => $get('type') === 'video'),

                Section::make('Access & Visibility')
                    ->schema([
                        Toggle::make('is_free')
                            ->label('Free Preview')
                            ->helperText('Allow non-enrolled students to preview this lesson')
                            ->default(false),

                        Toggle::make('is_published')
                            ->label('Published')
                            ->helperText('Make this lesson visible to enrolled students')
                            ->default(true),
                    ])
                    ->columns(2),
            ]);
    }
}
