<?php

namespace Tests\Feature\Http\Controllers;

use App\Jobs\UpdateCourseRating;
use App\Models\Course;
use App\Models\Review;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Queue;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\ReviewController
 */
final class ReviewControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ReviewController::class,
            'store',
            \App\Http\Requests\ReviewStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $rating = fake()->numberBetween(-10000, 10000);
        $comment = fake()->text();
        $course = Course::factory()->create();

        Queue::fake();

        $response = $this->post(route('reviews.store'), [
            'rating' => $rating,
            'comment' => $comment,
            'course_id' => $course->id,
        ]);

        $reviews = Review::query()
            ->where('rating', $rating)
            ->where('comment', $comment)
            ->where('course_id', $course->id)
            ->get();
        $this->assertCount(1, $reviews);
        $review = $reviews->first();

        $response->assertRedirect(route('course.show', ['course' => $course]));

        Queue::assertPushed(UpdateCourseRating::class, function ($job) use ($review) {
            return $job->review->is($review);
        });
    }
}
