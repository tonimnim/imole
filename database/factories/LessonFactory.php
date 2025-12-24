<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\Module;
use Illuminate\Database\Eloquent\Factories\Factory;

class LessonFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Lesson::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'course_id' => Course::factory(),
            'module_id' => Module::factory(),
            'title' => fake()->sentence(4),
            'slug' => fake()->slug(),
            'content' => fake()->paragraphs(3, true),
            'video_url' => fake()->regexify('[A-Za-z0-9]{500}'),
            'video_provider' => fake()->randomElement(['youtube', 'vimeo', 'custom']),
            'video_duration' => fake()->numberBetween(-10000, 10000),
            'type' => fake()->randomElement(['video', 'text', 'quiz', 'assignment']),
            'duration_minutes' => fake()->numberBetween(-10000, 10000),
            'order' => fake()->numberBetween(-10000, 10000),
            'is_free' => fake()->boolean(),
            'is_published' => fake()->boolean(),
        ];
    }
}
