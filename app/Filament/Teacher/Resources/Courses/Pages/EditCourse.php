<?php

namespace App\Filament\Teacher\Resources\Courses\Pages;

use App\Filament\Teacher\Resources\Courses\CourseResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditCourse extends EditRecord
{
    protected static string $resource = CourseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getFormActions(): array
    {
        return [
            ...parent::getFormActions(),
            Action::make('publish')
                ->label('Publish Course')
                ->color('success')
                ->icon('heroicon-o-globe-alt')
                ->visible(fn () => $this->hasCurriculum() && ! $this->record->is_published)
                ->requiresConfirmation()
                ->modalHeading('Publish Course')
                ->modalDescription('Are you sure you want to publish this course? It will be visible to students.')
                ->modalSubmitActionLabel('Yes, Publish')
                ->action(function () {
                    $this->record->update([
                        'status' => 'published',
                        'is_published' => true,
                    ]);

                    Notification::make()
                        ->title('Course Published')
                        ->body('Your course is now live and visible to students.')
                        ->success()
                        ->send();
                }),
            Action::make('unpublish')
                ->label('Unpublish')
                ->color('warning')
                ->icon('heroicon-o-eye-slash')
                ->visible(fn () => $this->record->is_published)
                ->requiresConfirmation()
                ->modalHeading('Unpublish Course')
                ->modalDescription('Are you sure you want to unpublish this course? Students will no longer be able to access it.')
                ->modalSubmitActionLabel('Yes, Unpublish')
                ->action(function () {
                    $this->record->update([
                        'status' => 'draft',
                        'is_published' => false,
                    ]);

                    Notification::make()
                        ->title('Course Unpublished')
                        ->body('Your course has been unpublished.')
                        ->warning()
                        ->send();
                }),
        ];
    }

    protected function hasCurriculum(): bool
    {
        return $this->record->lessons()->exists();
    }
}
