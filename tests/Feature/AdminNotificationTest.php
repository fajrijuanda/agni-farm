<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Contact;
use App\Models\Category; // Required if Product factory relies on it
use App\Notifications\NewContactMessage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class AdminNotificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_contact_submission_triggers_notification()
    {
        Notification::fake();

        $admin = User::factory()->create(['is_admin' => true]);

        $response = $this->post('/kontak', [
            'name' => 'Visitor',
            'email' => 'visitor@example.com',
            'subject' => 'Help',
            'message' => 'I need help',
        ]);

        Notification::assertSentTo(
            [$admin],
            NewContactMessage::class
        );
    }
}
