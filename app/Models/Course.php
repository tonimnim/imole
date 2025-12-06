<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'slug',
        'subtitle',
        'description',
        'objectives',
        'requirements',
        'level',
        'language',
        'instructor_id',
        'category_id',
        'thumbnail',
        'preview_video',
        'price',
        'currency',
        'discount_price',
        'status',
        'is_published',
        'published_at',
        'duration_minutes',
        'lessons_count',
        'students_count',
        'reviews_count',
        'average_rating',
        'is_featured',
        'has_certificate',
        'allow_reviews',
        'meta_title',
        'meta_description',
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
            'instructor_id' => 'integer',
            'category_id' => 'integer',
            'price' => 'decimal:2',
            'discount_price' => 'decimal:2',
            'is_published' => 'boolean',
            'published_at' => 'timestamp',
            'average_rating' => 'decimal:2',
            'is_featured' => 'boolean',
            'has_certificate' => 'boolean',
            'allow_reviews' => 'boolean',
        ];
    }

    /**
     * Get the route key name for Laravel route model binding.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function instructor(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function modules(): HasMany
    {
        return $this->hasMany(Module::class);
    }

    public function lessons(): HasMany
    {
        return $this->hasMany(Lesson::class);
    }

    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function announcements(): HasMany
    {
        return $this->hasMany(Announcement::class);
    }

    public function quizzes(): HasMany
    {
        return $this->hasMany(Quiz::class);
    }

    public function assignments(): HasMany
    {
        return $this->hasMany(Assignment::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }
}
