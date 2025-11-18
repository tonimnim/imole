<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Course;

class CouponFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Coupon::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'code' => fake()->regexify('[A-Za-z0-9]{50}'),
            'description' => fake()->text(),
            'discount_type' => fake()->randomElement(["percentage","fixed"]),
            'discount_value' => fake()->randomFloat(2, 0, 99999999.99),
            'max_discount' => fake()->randomFloat(2, 0, 99999999.99),
            'course_id' => Course::factory(),
            'category_id' => Category::factory(),
            'usage_limit' => fake()->numberBetween(-10000, 10000),
            'usage_count' => fake()->numberBetween(-10000, 10000),
            'per_user_limit' => fake()->numberBetween(-10000, 10000),
            'valid_from' => fake()->dateTime(),
            'valid_until' => fake()->dateTime(),
            'is_active' => fake()->boolean(),
        ];
    }
}
