<?php

namespace App\Filament\Teacher\Resources\Courses\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Illuminate\Support\Str;

class CourseForm
{
    public static function getSchema(): array
    {
        return [
            Section::make('Basic Information')
                ->schema([
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
                                while (\App\Models\Course::where('slug', $slug)->exists()) {
                                    $slug = $originalSlug.'-'.$counter;
                                    $counter++;
                                }

                                $set('slug', $slug);
                            }
                        }),

                    TextInput::make('slug')
                        ->required()
                        ->maxLength(255)
                        ->unique(ignoreRecord: true)
                        ->helperText('URL-friendly version of the title (auto-generated, editable)'),

                    TextInput::make('subtitle')
                        ->maxLength(255)
                        ->helperText('A short subtitle for the course'),

                    Select::make('category_id')
                        ->label('Category')
                        ->relationship('category', 'name')
                        ->required()
                        ->searchable()
                        ->preload(),

                    Select::make('level')
                        ->required()
                        ->options([
                            'beginner' => 'Beginner',
                            'intermediate' => 'Intermediate',
                            'advanced' => 'Advanced',
                        ])
                        ->default('beginner'),

                    Select::make('language')
                        ->required()
                        ->options([
                            'en' => 'English',
                            'es' => 'Spanish',
                            'fr' => 'French',
                            'de' => 'German',
                            'pt' => 'Portuguese',
                        ])
                        ->default('en'),
                ])
                ->columns(2),

            Section::make('Course Content')
                ->schema([
                    Textarea::make('description')
                        ->required()
                        ->rows(5)
                        ->columnSpanFull()
                        ->helperText('Detailed description of the course'),

                    Textarea::make('objectives')
                        ->rows(4)
                        ->columnSpanFull()
                        ->helperText('What students will learn (one per line)'),

                    Textarea::make('requirements')
                        ->rows(4)
                        ->columnSpanFull()
                        ->helperText('Prerequisites for this course (one per line)'),
                ]),

            Section::make('Media')
                ->schema([
                    FileUpload::make('thumbnail')
                        ->image()
                        ->directory('course-thumbnails')
                        ->maxSize(2048)
                        ->helperText('Course thumbnail image (max 2MB)'),

                    TextInput::make('preview_video')
                        ->url()
                        ->maxLength(500)
                        ->helperText('YouTube or Vimeo preview video URL'),
                ])
                ->columns(2),

            Section::make('Pricing')
                ->schema([
                    TextInput::make('price')
                        ->required()
                        ->numeric()
                        ->default(0)
                        ->prefix('$')
                        ->minValue(0),

                    TextInput::make('discount_price')
                        ->numeric()
                        ->prefix('$')
                        ->minValue(0)
                        ->helperText('Optional discounted price'),
                ])
                ->columns(2),

            Section::make('Settings')
                ->schema([
                    Toggle::make('is_published')
                        ->label('Published')
                        ->helperText('Make this course visible to students')
                        ->default(false),

                    Toggle::make('is_featured')
                        ->label('Featured')
                        ->helperText('Show on homepage as a featured course')
                        ->default(false),

                    Toggle::make('has_certificate')
                        ->label('Award Certificate')
                        ->helperText('Generate certificate upon course completion')
                        ->default(true),

                    Toggle::make('allow_reviews')
                        ->label('Allow Reviews')
                        ->helperText('Allow students to leave reviews')
                        ->default(true),
                ])
                ->columns(2),

            Section::make('SEO (Optional)')
                ->schema([
                    TextInput::make('meta_title')
                        ->maxLength(255)
                        ->helperText('SEO meta title (leave empty to use course title)'),

                    Textarea::make('meta_description')
                        ->rows(3)
                        ->helperText('SEO meta description (leave empty to use course description)'),
                ])
                ->collapsed()
                ->columns(1),

            Section::make('Course Curriculum')
                ->schema([
                    Repeater::make('modules')
                        ->relationship()
                        ->schema([
                            TextInput::make('course_id')
                                ->default(fn ($get) => $get('../../id'))
                                ->hidden()
                                ->dehydrated(),

                            TextInput::make('title')
                                ->required()
                                ->maxLength(255)
                                ->columnSpanFull()
                                ->placeholder('e.g., Module 1: Laravel Fundamentals'),

                            Textarea::make('description')
                                ->rows(3)
                                ->columnSpanFull()
                                ->placeholder('Brief description of what this module covers'),

                            TextInput::make('order')
                                ->numeric()
                                ->default(fn ($get) => count($get('../../modules') ?? []) + 1)
                                ->required()
                                ->helperText('Display order'),

                            Toggle::make('is_published')
                                ->label('Published')
                                ->default(true),

                            Repeater::make('lessons')
                                ->relationship()
                                ->schema([
                                    TextInput::make('course_id')
                                        ->default(fn ($get) => $get('../../../id'))
                                        ->hidden()
                                        ->dehydrated(),

                                    TextInput::make('title')
                                        ->required()
                                        ->maxLength(255)
                                        ->live(onBlur: true)
                                        ->afterStateUpdated(function ($state, callable $set, $get) {
                                            if (! $get('slug')) {
                                                $slug = Str::slug($state);
                                                $originalSlug = $slug;
                                                $counter = 1;

                                                while (\App\Models\Lesson::where('slug', $slug)->exists()) {
                                                    $slug = $originalSlug.'-'.$counter;
                                                    $counter++;
                                                }

                                                $set('slug', $slug);
                                            }
                                        })
                                        ->columnSpan(2),

                                    TextInput::make('slug')
                                        ->required()
                                        ->maxLength(255)
                                        ->unique(\App\Models\Lesson::class, 'slug', ignoreRecord: true)
                                        ->columnSpan(2),

                                    Select::make('type')
                                        ->options([
                                            'video' => 'Video Lesson',
                                            'text' => 'Text/Article',
                                            'quiz' => 'Quiz',
                                            'assignment' => 'Assignment',
                                        ])
                                        ->default('video')
                                        ->required()
                                        ->live()
                                        ->columnSpan(1),

                                    TextInput::make('order')
                                        ->numeric()
                                        ->default(fn ($get) => count($get('../../lessons') ?? []) + 1)
                                        ->required()
                                        ->columnSpan(1),

                                    RichEditor::make('content')
                                        ->required()
                                        ->columnSpanFull()
                                        ->toolbarButtons([
                                            'bold',
                                            'italic',
                                            'link',
                                            'bulletList',
                                            'orderedList',
                                            'h2',
                                            'h3',
                                        ]),

                                    TextInput::make('video_url')
                                        ->label('Video URL')
                                        ->url()
                                        ->maxLength(500)
                                        ->visible(fn ($get) => $get('type') === 'video')
                                        ->columnSpan(2),

                                    Select::make('video_provider')
                                        ->options([
                                            'youtube' => 'YouTube',
                                            'vimeo' => 'Vimeo',
                                            'custom' => 'Custom',
                                        ])
                                        ->visible(fn ($get) => $get('type') === 'video')
                                        ->columnSpan(1),

                                    TextInput::make('duration_minutes')
                                        ->label('Duration (minutes)')
                                        ->numeric()
                                        ->default(0)
                                        ->required()
                                        ->columnSpan(1),

                                    Toggle::make('is_free')
                                        ->label('Free Preview')
                                        ->default(false)
                                        ->columnSpan(1),

                                    Toggle::make('is_published')
                                        ->label('Published')
                                        ->default(true)
                                        ->columnSpan(1),
                                ])
                                ->columns(4)
                                ->collapsible()
                                ->itemLabel(fn (array $state): ?string => $state['title'] ?? 'New Lesson')
                                ->defaultItems(0)
                                ->addActionLabel('Add Lesson')
                                ->reorderable()
                                ->orderColumn('order'),
                        ])
                        ->columns(2)
                        ->collapsible()
                        ->itemLabel(fn (array $state): ?string => $state['title'] ?? 'New Module')
                        ->defaultItems(0)
                        ->addActionLabel('Add Module')
                        ->reorderable()
                        ->orderColumn('order')
                        ->columnSpanFull(),
                ])
                ->description('Build your course curriculum by adding modules and lessons. You can drag to reorder them.')
                ->collapsible(),
        ];
    }
}
