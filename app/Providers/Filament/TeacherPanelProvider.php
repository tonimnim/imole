<?php

namespace App\Providers\Filament;

use App\Filament\Teacher\Resources\Announcements\AnnouncementResource;
use App\Filament\Teacher\Resources\Assignments\AssignmentResource;
// use App\Filament\Teacher\Resources\AssignmentSubmissions\AssignmentSubmissionResource;
use App\Filament\Teacher\Resources\Certificates\CertificateResource;
use App\Filament\Teacher\Resources\Courses\CourseResource;
use App\Filament\Teacher\Resources\Enrollments\EnrollmentResource;
use App\Filament\Teacher\Resources\Lessons\LessonResource;
use App\Filament\Teacher\Resources\Modules\ModuleResource;
use App\Filament\Teacher\Resources\Questions\QuestionResource;
use App\Filament\Teacher\Resources\Quizzes\QuizResource;
use App\Filament\Teacher\Resources\Reviews\ReviewResource;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationGroup;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class TeacherPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('teacher')
            ->path('teacher-filament')
            ->login()
            ->spa()
            ->colors([
                'primary' => Color::Green,
            ])
            ->navigationGroups([
                NavigationGroup::make('Course Management'),
                NavigationGroup::make('Student Engagement'),
                NavigationGroup::make('Communication'),
                NavigationGroup::make('Rewards'),
            ])
            ->resources([
                CourseResource::class,
                ModuleResource::class,
                LessonResource::class,
                EnrollmentResource::class,
                AssignmentResource::class,
                // AssignmentSubmissionResource::class, // Not yet created
                QuizResource::class,
                QuestionResource::class,
                AnnouncementResource::class,
                ReviewResource::class,
                CertificateResource::class,
            ])
            ->pages([])
            ->homeUrl('/teacher')
            ->discoverWidgets(in: app_path('Filament/Teacher/Widgets'), for: 'App\Filament\Teacher\Widgets')
            ->widgets([
                // Custom widgets only - AccountWidget and FilamentInfoWidget removed
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
