<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuizAttempt extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'quiz_id',
        'started_at',
        'completed_at',
        'submitted_at',
        'score',
        'total_points',
        'earned_points',
        'answers',
        'status',
        'is_passed',
        'attempt_number',
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
            'user_id' => 'integer',
            'quiz_id' => 'integer',
            'started_at' => 'timestamp',
            'completed_at' => 'timestamp',
            'submitted_at' => 'timestamp',
            'score' => 'decimal:2',
            'answers' => 'array',
            'is_passed' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }
}
