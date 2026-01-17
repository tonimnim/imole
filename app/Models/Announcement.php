<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Announcement extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'course_id',
        'instructor_id',
        'title',
        'content',
        'type',
        'target_audience',
        'is_published',
        'published_at',
        'expires_at',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'course_id' => 'integer',
            'instructor_id' => 'integer',
            'is_published' => 'boolean',
            'published_at' => 'datetime',
            'expires_at' => 'datetime',
        ];
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function instructor(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function userNotifications(): HasMany
    {
        return $this->hasMany(UserNotification::class);
    }

    /**
     * Scope for platform-wide announcements (no course_id)
     */
    public function scopePlatformWide(Builder $query): Builder
    {
        return $query->whereNull('course_id');
    }

    /**
     * Scope for course-specific announcements
     */
    public function scopeForCourse(Builder $query, int $courseId): Builder
    {
        return $query->where('course_id', $courseId);
    }

    /**
     * Scope for published and active announcements
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_published', true)
            ->where(function ($q) {
                $q->whereNull('published_at')
                    ->orWhere('published_at', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('expires_at')
                    ->orWhere('expires_at', '>', now());
            });
    }

    /**
     * Scope for announcements targeting a specific audience
     */
    public function scopeForAudience(Builder $query, string $role): Builder
    {
        return $query->where(function ($q) use ($role) {
            $q->where('target_audience', 'all')
                ->orWhere('target_audience', $role);
        });
    }

    /**
     * Check if this is a platform-wide announcement
     */
    public function isPlatformWide(): bool
    {
        return is_null($this->course_id);
    }

    /**
     * Get the type badge color
     */
    public function getTypeBadgeColorAttribute(): string
    {
        return match ($this->type) {
            'warning' => 'yellow',
            'urgent' => 'red',
            default => 'blue',
        };
    }
}
