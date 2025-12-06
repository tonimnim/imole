<?php

namespace App\Livewire;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Livewire\Component;

class TeacherOnboardingWizard extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Wizard\Step::make('Profile Information')
                        ->schema([
                            TextInput::make('full_name')
                                ->label('Full Name')
                                ->required(),
                            Textarea::make('bio')
                                ->label('Short Bio')
                                ->rows(3)
                                ->required(),
                        ]),
                    Wizard\Step::make('Expertise')
                        ->schema([
                            Textarea::make('expertise')
                                ->label('Areas of Expertise')
                                ->helperText('List your areas of expertise, separated by commas.')
                                ->required(),
                        ]),
                ])->statePath('data'),
            ]);
    }

    public function submit(): void
    {
        $data = $this->form->getState();

        // Here you would save the data to the user's profile or a related model.
        // For now, we'll just display a notification.

        \Filament\Notifications\Notification::make()
            ->title('Onboarding complete!')
            ->success()
            ->send();

        // Redirect to the teacher dashboard after onboarding is complete.
        $this->redirect('/teacher');
    }

    public function render()
    {
        return view('livewire.teacher-onboarding-wizard');
    }
}
