<?php

namespace Database\Factories;

use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuizAttemptFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = QuizAttempt::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'quiz_id' => Quiz::factory(),
            'started_at' => fake()->dateTime(),
            'completed_at' => fake()->dateTime(),
            'submitted_at' => fake()->dateTime(),
            'score' => fake()->randomFloat(2, 0, 999.99),
            'total_points' => fake()->numberBetween(-10000, 10000),
            'earned_points' => fake()->numberBetween(-10000, 10000),
            'answers' => '{}',
            'status' => fake()->randomElement(['in_progress', 'completed', 'graded']),
            'is_passed' => fake()->boolean(),
            'attempt_number' => fake()->numberBetween(-10000, 10000),
        ];
    }
}
