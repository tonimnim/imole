<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Assignment;
use App\Models\Course;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\AssignmentController
 */
final class AssignmentControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function show_displays_view(): void
    {
        $assignment = Assignment::factory()->create();

        $response = $this->get(route('assignments.show', $assignment));

        $response->assertOk();
        $response->assertViewIs('assignment.show');
        $response->assertViewHas('assignment');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AssignmentController::class,
            'store',
            \App\Http\Requests\AssignmentStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $title = fake()->sentence(4);
        $description = fake()->text();
        $course = Course::factory()->create();

        $response = $this->post(route('assignments.store'), [
            'title' => $title,
            'description' => $description,
            'course_id' => $course->id,
        ]);

        $assignments = Assignment::query()
            ->where('title', $title)
            ->where('description', $description)
            ->where('course_id', $course->id)
            ->get();
        $this->assertCount(1, $assignments);
        $assignment = $assignments->first();

        $response->assertRedirect(route('assignment.show', ['assignment' => $assignment]));
    }
}
