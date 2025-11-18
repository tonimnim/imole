<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssignmentSubmission extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'assignment_id',
        'user_id',
        'content',
        'file_path',
        'file_name',
        'score',
        'max_score',
        'feedback',
        'graded_by',
        'graded_at',
        'submitted_at',
        'is_late',
        'status',
        'grader_id',
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
            'assignment_id' => 'integer',
            'user_id' => 'integer',
            'score' => 'decimal:2',
            'graded_by' => 'integer',
            'graded_at' => 'timestamp',
            'submitted_at' => 'timestamp',
            'is_late' => 'boolean',
            'grader_id' => 'integer',
        ];
    }

    public function assignment(): BelongsTo
    {
        return $this->belongsTo(Assignment::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function grader(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function gradedBy(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
