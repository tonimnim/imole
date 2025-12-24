<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Course;
use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\Student\WishlistController
 */
final class WishlistControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\Student\WishlistController::class,
            'store',
            \App\Http\Requests\WishlistStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $user = User::factory()->create();
        $course = Course::factory()->create();

        $response = $this->actingAs($user)->post(route('wishlists.store'), [
            'course_id' => $course->id,
        ]);

        $wishlists = Wishlist::query()
            ->where('course_id', $course->id)
            ->get();
        $this->assertCount(1, $wishlists);
        $wishlist = $wishlists->first();

        $response->assertRedirect(route('courses.show', ['course' => $course]));
        $response->assertSessionHas('wishlist.course.title', $wishlist->course->title);
    }

    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $user = User::factory()->create();
        $wishlist = Wishlist::factory()->create();

        $response = $this->actingAs($user)->delete(route('wishlists.destroy', $wishlist));

        $response->assertRedirect(route('student.wishlist'));

        $this->assertModelMissing($wishlist);
    }
}
