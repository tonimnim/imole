<?php

namespace Database\Factories;

use App\Models\Announcement;
use App\Models\Course;
use App\Models\Instructor;
use Illuminate\Database\Eloquent\Factories\Factory;

class AnnouncementFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Announcement::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'course_id' => Course::factory(),
            'instructor_id' => Instructor::factory(),
            'title' => fake()->sentence(4),
            'content' => fake()->paragraphs(3, true),
            'is_published' => fake()->boolean(),
            'published_at' => fake()->dateTime(),
        ];
    }
}
