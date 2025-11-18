<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Payment;
use App\Models\User;

class EnrollmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Enrollment::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'course_id' => Course::factory(),
            'enrolled_at' => fake()->dateTime(),
            'started_at' => fake()->dateTime(),
            'completed_at' => fake()->dateTime(),
            'expires_at' => fake()->dateTime(),
            'progress_percentage' => fake()->numberBetween(-10000, 10000),
            'last_accessed_at' => fake()->dateTime(),
            'payment_id' => Payment::factory(),
            'price_paid' => fake()->randomFloat(2, 0, 99999999.99),
            'status' => fake()->randomElement(["active","completed","expired","cancelled"]),
        ];
    }
}
