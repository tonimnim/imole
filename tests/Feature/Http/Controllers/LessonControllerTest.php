<?php

namespace Tests\Feature\Http\Controllers;

use App\Jobs\ProcessLessonVideo;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Module;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Queue;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\LessonController
 */
final class LessonControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $lessons = Lesson::factory()->count(3)->create();

        $response = $this->get(route('lessons.index'));

        $response->assertOk();
        $response->assertViewIs('lesson.index');
        $response->assertViewHas('lessons');
    }

    #[Test]
    public function show_displays_view(): void
    {
        $lesson = Lesson::factory()->create();

        $response = $this->get(route('lessons.show', $lesson));

        $response->assertOk();
        $response->assertViewIs('lesson.show');
        $response->assertViewHas('lesson');
    }

    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\LessonController::class,
            'store',
            \App\Http\Requests\LessonStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $title = fake()->sentence(4);
        $content = fake()->paragraphs(3, true);
        $course = Course::factory()->create();
        $module = Module::factory()->create();

        Queue::fake();

        $response = $this->post(route('lessons.store'), [
            'title' => $title,
            'content' => $content,
            'course_id' => $course->id,
            'module_id' => $module->id,
        ]);

        $lessons = Lesson::query()
            ->where('title', $title)
            ->where('content', $content)
            ->where('course_id', $course->id)
            ->where('module_id', $module->id)
            ->get();
        $this->assertCount(1, $lessons);
        $lesson = $lessons->first();

        $response->assertRedirect(route('lesson.show', ['lesson' => $lesson]));

        Queue::assertPushed(ProcessLessonVideo::class, function ($job) use ($lesson) {
            return $job->lesson->is($lesson);
        });
    }

    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\LessonController::class,
            'update',
            \App\Http\Requests\LessonUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $lesson = Lesson::factory()->create();
        $title = fake()->sentence(4);
        $content = fake()->paragraphs(3, true);

        $response = $this->put(route('lessons.update', $lesson), [
            'title' => $title,
            'content' => $content,
        ]);

        $lesson->refresh();

        $response->assertRedirect(route('lesson.show', ['lesson' => $lesson]));

        $this->assertEquals($title, $lesson->title);
        $this->assertEquals($content, $lesson->content);
    }
}
