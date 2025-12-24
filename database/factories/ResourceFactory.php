<?php

namespace Database\Factories;

use App\Models\Lesson;
use App\Models\Resource;
use Illuminate\Database\Eloquent\Factories\Factory;

class ResourceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Resource::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'lesson_id' => Lesson::factory(),
            'title' => fake()->sentence(4),
            'description' => fake()->text(),
            'file_name' => fake()->regexify('[A-Za-z0-9]{255}'),
            'file_path' => fake()->regexify('[A-Za-z0-9]{500}'),
            'file_type' => fake()->regexify('[A-Za-z0-9]{50}'),
            'file_size' => fake()->numberBetween(-10000, 10000),
            'download_count' => fake()->numberBetween(-10000, 10000),
            'order' => fake()->numberBetween(-10000, 10000),
        ];
    }
}
