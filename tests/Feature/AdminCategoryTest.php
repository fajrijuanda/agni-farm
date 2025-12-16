<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminCategoryTest extends TestCase
{
    use RefreshDatabase;

    private $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create(['is_admin' => true]);
    }

    public function test_index_page_is_accessible()
    {
        $response = $this->actingAs($this->admin)->get(route('admin.categories.index'));
        $response->assertStatus(200);
    }

    public function test_create_category()
    {
        Storage::fake('public');

        $response = $this->actingAs($this->admin)->post(route('admin.categories.store'), [
            'name' => 'Test Category',
            'description' => 'Test Description',
            'icon' => 'Test Icon',
            'image' => UploadedFile::fake()->image('category.jpg')
        ]);

        $response->assertRedirect(route('admin.categories.index'));
        $this->assertDatabaseHas('categories', ['name' => 'Test Category']);
    }

    public function test_update_category()
    {
        $category = Category::factory()->create();

        $response = $this->actingAs($this->admin)->put(route('admin.categories.update', $category), [
            'name' => 'Updated Name',
            'description' => 'Updated Description',
        ]);

        $response->assertRedirect(route('admin.categories.index'));
        $this->assertDatabaseHas('categories', ['id' => $category->id, 'name' => 'Updated Name']);
    }

    public function test_delete_category()
    {
        $category = Category::factory()->create();

        $response = $this->actingAs($this->admin)->delete(route('admin.categories.destroy', $category));

        $response->assertRedirect(route('admin.categories.index'));
        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }
}
