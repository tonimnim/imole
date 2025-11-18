<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Certificate;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;

class CertificateFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Certificate::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'course_id' => Course::factory(),
            'enrollment_id' => Enrollment::factory(),
            'certificate_number' => fake()->regexify('[A-Za-z0-9]{100}'),
            'issued_at' => fake()->dateTime(),
            'valid_until' => fake()->dateTime(),
            'file_path' => fake()->regexify('[A-Za-z0-9]{500}'),
        ];
    }
}
