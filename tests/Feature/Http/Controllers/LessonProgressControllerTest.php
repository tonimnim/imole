<?php

namespace Tests\Feature\Http\Controllers;

use App\Jobs\UpdateCourseProgress;
use App\Models\LessonProgress;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Queue;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\LessonProgressController
 */
final class LessonProgressControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\LessonProgressController::class,
            'update',
            \App\Http\Requests\LessonProgressUpdateRequest::class
        );
    }

    #[Test]
    public function update_responds_with(): void
    {
        $lessonProgress = LessonProgress::factory()->create();
        $is_completed = fake()->boolean();
        $time_spent_seconds = fake()->numberBetween(-10000, 10000);

        Queue::fake();

        $response = $this->put(route('lesson-progresses.update', $lessonProgress), [
            'is_completed' => $is_completed,
            'time_spent_seconds' => $time_spent_seconds,
        ]);

        $lessonProgress->refresh();

        $response->assertOk();
        $response->assertJson($lessonProgress, 200);

        $this->assertEquals($is_completed, $lessonProgress->is_completed);
        $this->assertEquals($time_spent_seconds, $lessonProgress->time_spent_seconds);

        Queue::assertPushed(UpdateCourseProgress::class, function ($job) use ($lessonProgress) {
            return $job->lessonProgress->is($lessonProgress);
        });
    }
}
