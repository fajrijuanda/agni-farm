<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FrontendTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_is_accessible()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function test_about_page_is_accessible()
    {
        $response = $this->get('/tentang-kami');
        $response->assertStatus(200);
    }

    public function test_catalog_page_is_accessible()
    {
        $response = $this->get('/catalog');
        $response->assertStatus(200);
    }

    public function test_contact_page_is_accessible()
    {
        $response = $this->get('/kontak');
        $response->assertStatus(200);
    }

    public function test_contact_form_submission()
    {
        $response = $this->post('/kontak', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'subject' => 'Test Subject',
            'message' => 'Test Message',
        ]);

        $response->assertSessionHas('success');
        $this->assertDatabaseHas('contacts', [
            'email' => 'test@example.com',
        ]);
    }
}
