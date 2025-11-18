<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Question;
use App\Models\Quiz;

class QuestionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Question::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'quiz_id' => Quiz::factory(),
            'question_text' => fake()->text(),
            'question_type' => fake()->randomElement(["multiple_choice","true_false","short_answer","essay"]),
            'options' => '{}',
            'correct_answer' => fake()->text(),
            'explanation' => fake()->text(),
            'points' => fake()->numberBetween(-10000, 10000),
            'order' => fake()->numberBetween(-10000, 10000),
        ];
    }
}
