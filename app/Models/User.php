<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, HasRoles, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'headline',
        'bio',
        'expertise',
        'website',
        'twitter',
        'linkedin',
        'youtube',
        'phone',
        'location',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'expertise' => 'array',
        ];
    }

    /**
     * Determine if the user can access the specified Filament panel.
     */
    public function canAccessPanel(Panel $panel): bool
    {
        // Admin panel - only admin role
        if ($panel->getId() === 'admin') {
            return $this->hasRole('admin');
        }

        // Teacher panel - only teacher role
        if ($panel->getId() === 'teacher') {
            return $this->hasRole('teacher');
        }

        // Student panel - only student role
        if ($panel->getId() === 'student') {
            return $this->hasRole('student');
        }

        return false;
    }

    /**
     * Get courses where the user is the instructor.
     */
    public function courses()
    {
        return $this->hasMany(Course::class, 'instructor_id');
    }

    /**
     * Get enrollments for the user (as a student).
     */
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    /**
     * Get courses the user is enrolled in (as a student).
     */
    public function enrolledCourses()
    {
        return $this->belongsToMany(Course::class, 'enrollments')->withTimestamps();
    }

    /**
     * Get certificates for the user.
     */
    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }
}
