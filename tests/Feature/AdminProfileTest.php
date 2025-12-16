<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminProfileTest extends TestCase
{
    use RefreshDatabase;

    private $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create(['is_admin' => true, 'password' => bcrypt('password')]);
    }

    public function test_profile_page_is_accessible()
    {
        $response = $this->actingAs($this->admin)->get(route('admin.profile.index'));
        $response->assertStatus(200);
    }

    public function test_update_profile_info()
    {
        $response = $this->actingAs($this->admin)->put(route('admin.profile.update'), [
            'name' => 'New Name',
            'email' => 'newemail@test.com',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('users', ['id' => $this->admin->id, 'name' => 'New Name', 'email' => 'newemail@test.com']);
    }

    public function test_update_password()
    {
        $response = $this->actingAs($this->admin)->put(route('admin.profile.password'), [
            'current_password' => 'password',
            'password' => 'newpassword',
            'password_confirmation' => 'newpassword',
        ]);

        $response->assertRedirect();
        $this->assertTrue(Hash::check('newpassword', $this->admin->fresh()->password));
    }
}
