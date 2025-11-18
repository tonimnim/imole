<?php

namespace Tests\Feature\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\Admin\CategoryController
 */
final class CategoryControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $categories = Category::factory()->count(3)->create();

        $response = $this->get(route('categories.index'));

        $response->assertOk();
        $response->assertViewIs('admin.category.index');
        $response->assertViewHas('categories');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\Admin\CategoryController::class,
            'store',
            \App\Http\Requests\Admin\CategoryStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $name = fake()->name();
        $slug = fake()->slug();

        $response = $this->post(route('categories.store'), [
            'name' => $name,
            'slug' => $slug,
        ]);

        $categories = Category::query()
            ->where('name', $name)
            ->where('slug', $slug)
            ->get();
        $this->assertCount(1, $categories);
        $category = $categories->first();

        $response->assertRedirect(route('admin.category.index'));
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\Admin\CategoryController::class,
            'update',
            \App\Http\Requests\Admin\CategoryUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $category = Category::factory()->create();
        $name = fake()->name();
        $slug = fake()->slug();

        $response = $this->put(route('categories.update', $category), [
            'name' => $name,
            'slug' => $slug,
        ]);

        $category->refresh();

        $response->assertRedirect(route('admin.category.index'));

        $this->assertEquals($name, $category->name);
        $this->assertEquals($slug, $category->slug);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $category = Category::factory()->create();

        $response = $this->delete(route('categories.destroy', $category));

        $response->assertRedirect(route('admin.category.index'));

        $this->assertModelMissing($category);
    }
}
