<?php

namespace Tests\Feature;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminSettingTest extends TestCase
{
    use RefreshDatabase;

    private $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create(['is_admin' => true]);
    }

    public function test_settings_page_is_accessible()
    {
        $response = $this->actingAs($this->admin)->get(route('admin.settings.index'));
        $response->assertStatus(200);
    }

    public function test_update_settings()
    {
        $response = $this->actingAs($this->admin)->put(route('admin.settings.update'), [
            'site_name' => 'New Site Name',
            'contact_email' => 'contact@test.com',
        ]);

        $response->assertRedirect();
        $this->assertEquals('New Site Name', Setting::get('site_name'));
        $this->assertEquals('contact@test.com', Setting::get('contact_email'));
    }

    public function test_upload_logo()
    {
        Storage::fake('public');

        $response = $this->actingAs($this->admin)->put(route('admin.settings.update'), [
            'site_logo' => UploadedFile::fake()->image('logo.png'),
        ]);

        $response->assertRedirect();
        $this->assertNotNull(Setting::get('site_logo'));
    }
}
