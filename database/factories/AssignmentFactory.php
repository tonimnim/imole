<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Assignment;
use App\Models\Course;
use App\Models\Lesson;

class AssignmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Assignment::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'course_id' => Course::factory(),
            'lesson_id' => Lesson::factory(),
            'title' => fake()->sentence(4),
            'description' => fake()->text(),
            'instructions' => fake()->text(),
            'attachments' => '{}',
            'max_score' => fake()->numberBetween(-10000, 10000),
            'max_file_size_mb' => fake()->numberBetween(-10000, 10000),
            'allowed_file_types' => fake()->regexify('[A-Za-z0-9]{255}'),
            'due_date' => fake()->dateTime(),
            'late_submission_allowed' => fake()->boolean(),
            'is_published' => fake()->boolean(),
            'order' => fake()->numberBetween(-10000, 10000),
        ];
    }
}
