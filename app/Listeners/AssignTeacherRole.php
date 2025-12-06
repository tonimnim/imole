<?php

namespace App\Listeners;

use App\Events\Filament\Events\Auth\Registered;

class AssignTeacherRole
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Registered $event): void
    {
        // Check if the registration is for the teacher panel
        if ($event->auth->getProvider()->getModel() === \App\Models\User::class && request()->route()->getPrefix() === 'teacher') {
            $event->user->assignRole('teacher');

            // Redirect to the onboarding page
            redirect()->route('teacher.onboarding')->send();
        }
    }
}
