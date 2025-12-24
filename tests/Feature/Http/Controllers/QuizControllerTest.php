<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Course;
use App\Models\Quiz;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\QuizController
 */
final class QuizControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function show_displays_view(): void
    {
        $quiz = Quiz::factory()->create();

        $response = $this->get(route('quizzes.show', $quiz));

        $response->assertOk();
        $response->assertViewIs('quiz.show');
        $response->assertViewHas('quiz');
    }

    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\QuizController::class,
            'store',
            \App\Http\Requests\QuizStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $title = fake()->sentence(4);
        $course = Course::factory()->create();
        $passing_score = fake()->numberBetween(-10000, 10000);

        $response = $this->post(route('quizzes.store'), [
            'title' => $title,
            'course_id' => $course->id,
            'passing_score' => $passing_score,
        ]);

        $quizzes = Quiz::query()
            ->where('title', $title)
            ->where('course_id', $course->id)
            ->where('passing_score', $passing_score)
            ->get();
        $this->assertCount(1, $quizzes);
        $quiz = $quizzes->first();

        $response->assertRedirect(route('quiz.show', ['quiz' => $quiz]));
    }
}
