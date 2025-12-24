<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LessonNote extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'lesson_id',
        'course_id',
        'content',
        'video_timestamp',
    ];

    protected function casts(): array
    {
        return [
            'video_timestamp' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function lesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function getFormattedTimestampAttribute(): ?string
    {
        if (! $this->video_timestamp) {
            return null;
        }

        $minutes = floor($this->video_timestamp / 60);
        $seconds = $this->video_timestamp % 60;

        return sprintf('%d:%02d', $minutes, $seconds);
    }
}
