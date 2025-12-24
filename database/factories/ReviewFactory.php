<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Review::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'course_id' => Course::factory(),
            'rating' => fake()->numberBetween(-10000, 10000),
            'title' => fake()->sentence(4),
            'comment' => fake()->text(),
            'is_approved' => fake()->boolean(),
            'approved_at' => fake()->dateTime(),
            'helpful_count' => fake()->numberBetween(-10000, 10000),
        ];
    }
}
