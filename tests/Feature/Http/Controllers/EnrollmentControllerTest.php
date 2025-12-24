<?php

namespace Tests\Feature\Http\Controllers;

use App\Events\StudentEnrolled;
use App\Jobs\SendEnrollmentConfirmation;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Queue;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\EnrollmentController
 */
final class EnrollmentControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\EnrollmentController::class,
            'store',
            \App\Http\Requests\EnrollmentStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $user = User::factory()->create();
        $course = Course::factory()->create();

        Queue::fake();
        Event::fake();

        $response = $this->post(route('enrollments.store'), [
            'user_id' => $user->id,
            'course_id' => $course->id,
        ]);

        $enrollments = Enrollment::query()
            ->where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->get();
        $this->assertCount(1, $enrollments);
        $enrollment = $enrollments->first();

        $response->assertRedirect(route('course.show', ['course' => $course]));

        Queue::assertPushed(SendEnrollmentConfirmation::class, function ($job) use ($enrollment) {
            return $job->enrollment->is($enrollment);
        });
        Event::assertDispatched(StudentEnrolled::class, function ($event) use ($enrollment) {
            return $event->enrollment->is($enrollment);
        });
    }

    #[Test]
    public function show_displays_view(): void
    {
        $enrollment = Enrollment::factory()->create();

        $response = $this->get(route('enrollments.show', $enrollment));

        $response->assertOk();
        $response->assertViewIs('enrollment.show');
        $response->assertViewHas('enrollment');
    }
}
