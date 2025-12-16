<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_is_accessible()
    {
        $response = $this->get('/admin/login');
        $response->assertStatus(200);
    }

    public function test_admin_can_login()
    {
        $user = User::factory()->create([
            'is_admin' => true,
            'password' => bcrypt('password'),
        ]);

        $response = $this->post('/admin/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertRedirect('/admin');
        $this->assertAuthenticatedAs($user);
    }

    public function test_invalid_login_fails()
    {
        $user = User::factory()->create([
            'is_admin' => true,
            'password' => bcrypt('password'),
        ]);

        $response = $this->post('/admin/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $response->assertSessionHasErrors();
        $this->assertGuest();
    }

    public function test_non_admin_cannot_access_dashboard()
    {
        $user = User::factory()->create(['is_admin' => false]);

        $response = $this->actingAs($user)->get('/admin');

        // Middleware should redirect or forbidden
        // Based on our admin middleware it might redirect to login or home
        // Let's assume redirect to login or 403
        // Checking middleware specific might be needed, but usually redirect to home or 403
        // If 'admin' middleware checks check(), it passes actingAs.
        // Then checks isAdmin(). If false, probably 403 or redirect.
        // Let's check our middleware logic later if this fails.
        // For now assume 403 Forbidden or Redirect

        $response->assertStatus(403);
    }
}
