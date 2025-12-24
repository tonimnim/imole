<?php

namespace Database\Factories;

use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use App\Models\GradedBy;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AssignmentSubmissionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AssignmentSubmission::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'assignment_id' => Assignment::factory(),
            'user_id' => User::factory(),
            'content' => fake()->paragraphs(3, true),
            'file_path' => fake()->regexify('[A-Za-z0-9]{500}'),
            'file_name' => fake()->regexify('[A-Za-z0-9]{255}'),
            'score' => fake()->randomFloat(2, 0, 999.99),
            'max_score' => fake()->numberBetween(-10000, 10000),
            'feedback' => fake()->text(),
            'graded_by' => GradedBy::factory(),
            'graded_at' => fake()->dateTime(),
            'submitted_at' => fake()->dateTime(),
            'is_late' => fake()->boolean(),
            'status' => fake()->randomElement(['submitted', 'graded', 'returned', 'resubmitted']),
            'grader_id' => User::factory(),
        ];
    }
}
