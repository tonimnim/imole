<?php

namespace Tests\Feature\Http\Controllers;

use App\Events\QuizAttemptStarted;
use App\Jobs\GradeQuizAttempt;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Queue;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\QuizAttemptController
 */
final class QuizAttemptControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\QuizAttemptController::class,
            'store',
            \App\Http\Requests\QuizAttemptStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $quiz = Quiz::factory()->create();
        $user = User::factory()->create();

        Event::fake();

        $response = $this->post(route('quiz-attempts.store'), [
            'quiz_id' => $quiz->id,
            'user_id' => $user->id,
        ]);

        $quizAttempts = QuizAttempt::query()
            ->where('quiz_id', $quiz->id)
            ->where('user_id', $user->id)
            ->get();
        $this->assertCount(1, $quizAttempts);
        $quizAttempt = $quizAttempts->first();

        $response->assertRedirect(route('quizAttempt.show', ['quizAttempt' => $quizAttempt]));

        Event::assertDispatched(QuizAttemptStarted::class, function ($event) use ($quizAttempt) {
            return $event->quizAttempt->is($quizAttempt);
        });
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\QuizAttemptController::class,
            'update',
            \App\Http\Requests\QuizAttemptUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $quizAttempt = QuizAttempt::factory()->create();
        $answers = fake()->;

        Queue::fake();

        $response = $this->put(route('quiz-attempts.update', $quizAttempt), [
            'answers' => $answers,
        ]);

        $quizAttempt->refresh();

        $response->assertRedirect(route('quizAttempt.show', ['quizAttempt' => $quizAttempt]));

        $this->assertEquals($answers, $quizAttempt->answers);

        Queue::assertPushed(GradeQuizAttempt::class, function ($job) use ($quizAttempt) {
            return $job->quizAttempt->is($quizAttempt);
        });
    }
}
