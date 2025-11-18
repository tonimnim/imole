<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use App\Notification\AssignmentGradedNotification;
use App\Notification\AssignmentSubmittedNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\AssignmentSubmissionController
 */
final class AssignmentSubmissionControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AssignmentSubmissionController::class,
            'store',
            \App\Http\Requests\AssignmentSubmissionStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $assignment = Assignment::factory()->create();
        $content = fake()->paragraphs(3, true);

        Notification::fake();

        $response = $this->post(route('assignment-submissions.store'), [
            'assignment_id' => $assignment->id,
            'content' => $content,
        ]);

        $assignmentSubmissions = AssignmentSubmission::query()
            ->where('assignment_id', $assignment->id)
            ->where('content', $content)
            ->get();
        $this->assertCount(1, $assignmentSubmissions);
        $assignmentSubmission = $assignmentSubmissions->first();

        $response->assertRedirect(route('assignment.show', ['assignment' => $assignment]));
        $response->assertSessionHas('assignmentSubmission.assignment.title', $assignmentSubmission->assignment->title);

        Notification::assertSentTo($assignment->course->instructor, AssignmentSubmittedNotification::class, function ($notification) use ($assignmentSubmission) {
            return $notification->assignmentSubmission->is($assignmentSubmission);
        });
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AssignmentSubmissionController::class,
            'update',
            \App\Http\Requests\AssignmentSubmissionUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $assignmentSubmission = AssignmentSubmission::factory()->create();
        $score = fake()->randomFloat(/** decimal_attributes **/);
        $feedback = fake()->text();

        Notification::fake();

        $response = $this->put(route('assignment-submissions.update', $assignmentSubmission), [
            'score' => $score,
            'feedback' => $feedback,
        ]);

        $assignmentSubmission->refresh();

        $response->assertRedirect(route('assignment.show', ['assignment' => $assignment]));

        $this->assertEquals($score, $assignmentSubmission->score);
        $this->assertEquals($feedback, $assignmentSubmission->feedback);

        Notification::assertSentTo($assignmentSubmission->user, AssignmentGradedNotification::class, function ($notification) use ($assignmentSubmission) {
            return $notification->assignmentSubmission->is($assignmentSubmission);
        });
    }
}
