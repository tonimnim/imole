<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Lesson;
use App\Models\Parent;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Comment::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'lesson_id' => Lesson::factory(),
            'parent_id' => parent::factory(),
            'content' => fake()->paragraphs(3, true),
            'is_approved' => fake()->boolean(),
        ];
    }
}
