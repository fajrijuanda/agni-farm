<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminProductTest extends TestCase
{
    use RefreshDatabase;

    private $admin;
    private $category;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create(['is_admin' => true]);
        $this->category = Category::factory()->create();
    }

    public function test_index_page_is_accessible()
    {
        $response = $this->actingAs($this->admin)->get(route('admin.catalog.index'));
        $response->assertStatus(200);
    }

    public function test_create_product()
    {
        Storage::fake('public');

        // $this->withoutExceptionHandling();
        $response = $this->actingAs($this->admin)->post(route('admin.catalog.store'), [
            'name' => 'Test Product',
            'category_id' => $this->category->id,
            'price' => 10000,
            'full_description' => 'Test Desc',
            'shopee_link' => 'https://shopee.co.id/test',
            'images' => [UploadedFile::fake()->image('product.jpg')]
        ]);

        $response->assertRedirect(route('admin.catalog.index'));
        $this->assertDatabaseHas('products', ['name' => 'Test Product']);
    }

    public function test_update_product()
    {
        $product = Product::factory()->create(['category_id' => $this->category->id]);

        $response = $this->actingAs($this->admin)->put(route('admin.catalog.update', $product), [
            'name' => 'Updated Product',
            'category_id' => $this->category->id,
            'price' => 20000,
            'full_description' => 'Updated Desc',
            'shopee_link' => 'https://shopee.co.id/test-updated',
        ]);

        $response->assertRedirect(route('admin.catalog.index'));
        $this->assertDatabaseHas('products', ['id' => $product->id, 'name' => 'Updated Product']);
    }

    public function test_delete_product()
    {
        $product = Product::factory()->create(['category_id' => $this->category->id]);

        $response = $this->actingAs($this->admin)->delete(route('admin.catalog.destroy', $product));

        $response->assertRedirect(route('admin.catalog.index'));
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }
}
