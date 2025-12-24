<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CourseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Course::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(4),
            'slug' => fake()->slug(),
            'subtitle' => fake()->regexify('[A-Za-z0-9]{255}'),
            'description' => fake()->text(),
            'objectives' => fake()->text(),
            'requirements' => fake()->text(),
            'level' => fake()->randomElement(['beginner', 'intermediate', 'advanced']),
            'language' => fake()->regexify('[A-Za-z0-9]{10}'),
            'instructor_id' => User::factory(),
            'category_id' => Category::factory(),
            'thumbnail' => fake()->regexify('[A-Za-z0-9]{500}'),
            'preview_video' => fake()->regexify('[A-Za-z0-9]{500}'),
            'price' => fake()->randomFloat(2, 0, 99999999.99),
            'currency' => fake()->regexify('[A-Za-z0-9]{3}'),
            'discount_price' => fake()->randomFloat(2, 0, 99999999.99),
            'status' => fake()->randomElement(['draft', 'pending', 'published', 'archived']),
            'is_published' => fake()->boolean(),
            'published_at' => fake()->dateTime(),
            'duration_minutes' => fake()->numberBetween(-10000, 10000),
            'lessons_count' => fake()->numberBetween(-10000, 10000),
            'students_count' => fake()->numberBetween(-10000, 10000),
            'reviews_count' => fake()->numberBetween(-10000, 10000),
            'average_rating' => fake()->randomFloat(2, 0, 9.99),
            'is_featured' => fake()->boolean(),
            'has_certificate' => fake()->boolean(),
            'allow_reviews' => fake()->boolean(),
            'meta_title' => fake()->regexify('[A-Za-z0-9]{255}'),
            'meta_description' => fake()->text(),
        ];
    }
}
