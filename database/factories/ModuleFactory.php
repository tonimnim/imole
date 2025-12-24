<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\Module;
use Illuminate\Database\Eloquent\Factories\Factory;

class ModuleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Module::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'course_id' => Course::factory(),
            'title' => fake()->sentence(4),
            'description' => fake()->text(),
            'order' => fake()->numberBetween(-10000, 10000),
            'is_published' => fake()->boolean(),
        ];
    }
}
