<?php

namespace Tests\Feature\Http\Controllers;

use App\Jobs\ProcessCourseThumbnail;
use App\Models\Category;
use App\Models\Course;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Queue;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\CourseController
 */
final class CourseControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $courses = Course::factory()->count(3)->create();

        $response = $this->get(route('courses.index'));

        $response->assertOk();
        $response->assertViewIs('course.index');
        $response->assertViewHas('courses');
    }


    #[Test]
    public function show_displays_view(): void
    {
        $course = Course::factory()->create();

        $response = $this->get(route('courses.show', $course));

        $response->assertOk();
        $response->assertViewIs('course.show');
        $response->assertViewHas('course');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\CourseController::class,
            'store',
            \App\Http\Requests\CourseStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $title = fake()->sentence(4);
        $description = fake()->text();
        $category = Category::factory()->create();
        $price = fake()->randomFloat(/** decimal_attributes **/);
        $level = fake()->randomElement(/** enum_attributes **/);

        Queue::fake();

        $response = $this->post(route('courses.store'), [
            'title' => $title,
            'description' => $description,
            'category_id' => $category->id,
            'price' => $price,
            'level' => $level,
        ]);

        $courses = Course::query()
            ->where('title', $title)
            ->where('description', $description)
            ->where('category_id', $category->id)
            ->where('price', $price)
            ->where('level', $level)
            ->get();
        $this->assertCount(1, $courses);
        $course = $courses->first();

        $response->assertRedirect(route('course.show', ['course' => $course]));
        $response->assertSessionHas('course.title', $course->title);

        Queue::assertPushed(ProcessCourseThumbnail::class, function ($job) use ($course) {
            return $job->course->is($course);
        });
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\CourseController::class,
            'update',
            \App\Http\Requests\CourseUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $course = Course::factory()->create();
        $title = fake()->sentence(4);
        $description = fake()->text();
        $price = fake()->randomFloat(/** decimal_attributes **/);

        $response = $this->put(route('courses.update', $course), [
            'title' => $title,
            'description' => $description,
            'price' => $price,
        ]);

        $course->refresh();

        $response->assertRedirect(route('course.show', ['course' => $course]));
        $response->assertSessionHas('course.title', $course->title);

        $this->assertEquals($title, $course->title);
        $this->assertEquals($description, $course->description);
        $this->assertEquals($price, $course->price);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $course = Course::factory()->create();

        $response = $this->delete(route('courses.destroy', $course));

        $response->assertRedirect(route('course.index'));

        $this->assertModelMissing($course);
    }
}
