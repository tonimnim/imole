<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\Quiz;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuizFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Quiz::class;

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
            'duration_minutes' => fake()->numberBetween(-10000, 10000),
            'passing_score' => fake()->numberBetween(-10000, 10000),
            'max_attempts' => fake()->numberBetween(-10000, 10000),
            'shuffle_questions' => fake()->boolean(),
            'show_correct_answers' => fake()->boolean(),
            'is_published' => fake()->boolean(),
            'order' => fake()->numberBetween(-10000, 10000),
        ];
    }
}
