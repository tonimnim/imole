<?php

namespace Tests\Feature\Http\Controllers;

use App\Events\CommentPosted;
use App\Models\Comment;
use App\Models\Lesson;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\CommentController
 */
final class CommentControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\CommentController::class,
            'store',
            \App\Http\Requests\CommentStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $content = fake()->paragraphs(3, true);
        $lesson = Lesson::factory()->create();

        Event::fake();

        $response = $this->post(route('comments.store'), [
            'content' => $content,
            'lesson_id' => $lesson->id,
        ]);

        $comments = Comment::query()
            ->where('content', $content)
            ->where('lesson_id', $lesson->id)
            ->get();
        $this->assertCount(1, $comments);
        $comment = $comments->first();

        $response->assertRedirect(route('lesson.show', ['lesson' => $lesson]));

        Event::assertDispatched(CommentPosted::class, function ($event) use ($comment) {
            return $event->comment->is($comment);
        });
    }
}
