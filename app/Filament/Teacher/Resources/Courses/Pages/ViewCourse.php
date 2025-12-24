<?php

namespace App\Filament\Teacher\Resources\Courses\Pages;

use App\Filament\Teacher\Resources\Courses\CourseResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewCourse extends ViewRecord
{
    protected static string $resource = CourseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('publish')
                ->label('Publish Course')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->visible(fn ($record): bool => ! $record->is_published)
                ->requiresConfirmation()
                ->modalHeading('Publish Course')
                ->modalDescription('Are you sure you want to publish this course? It will be visible to students.')
                ->modalSubmitActionLabel('Publish')
                ->before(function ($record, Actions\Action $action) {
                    if ($record->lessons()->count() === 0) {
                        \Filament\Notifications\Notification::make()
                            ->danger()
                            ->title('Cannot Publish Course')
                            ->body('You cannot publish a course without any lessons. Please add at least one lesson first.')
                            ->persistent()
                            ->send();

                        $action->halt();
                    }
                })
                ->action(function ($record) {
                    $record->update([
                        'is_published' => true,
                        'published_at' => now(),
                    ]);

                    \Filament\Notifications\Notification::make()
                        ->success()
                        ->title('Course Published')
                        ->body('The course has been published and is now visible to students.')
                        ->send();
                }),

            Actions\Action::make('unpublish')
                ->label('Unpublish Course')
                ->icon('heroicon-o-x-circle')
                ->color('warning')
                ->visible(fn ($record): bool => $record->is_published)
                ->requiresConfirmation()
                ->modalHeading('Unpublish Course')
                ->modalDescription('Are you sure you want to unpublish this course? It will no longer be visible to students.')
                ->modalSubmitActionLabel('Unpublish')
                ->action(function ($record) {
                    $record->update([
                        'is_published' => false,
                    ]);

                    \Filament\Notifications\Notification::make()
                        ->success()
                        ->title('Course Unpublished')
                        ->body('The course has been unpublished and is no longer visible to students.')
                        ->send();
                }),

            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
