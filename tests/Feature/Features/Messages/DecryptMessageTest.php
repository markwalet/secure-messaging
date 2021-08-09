<?php

namespace Tests\Feature\Features\Messages;

use App\Models\Message;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\URL;
use Inertia\Testing\Assert;
use Tests\TestCase;

class DecryptMessageTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_view_a_secure_message()
    {
        $message = Message::factory()->create(['password' => bcrypt('secret'), 'message' => 'Hello world']);

        $response = $this->post(URL::signedRoute('decrypt-message', compact('message')), [
            'password' => 'secret',
        ]);

        $response->assertOk();
        $response->assertInertia(fn (Assert $page) => $page->component('Messages/ShowDecryptedMessage')->where('secureMessage', 'Hello world'));
        $this->assertDatabaseCount('messages', 0);
    }

    /** @test */
    public function a_user_cannot_view_a_secure_message_without_signing_the_url()
    {
        $message = Message::factory()->create(['password' => bcrypt('secret')]);

        $response = $this->post(route('decrypt-message', compact('message')), [
            'password' => 'secret',
        ]);

        $response->assertForbidden();
    }

    /** @test */
    public function a_user_cannot_view_a_secure_message_when_the_password_is_incorrect()
    {
        $message = Message::factory()->create(['password' => bcrypt('secret'), 'message' => 'Hello world']);

        $response = $this->post(URL::signedRoute('decrypt-message', compact('message')), [
            'password' => 'wrong password',
        ]);

        $response->assertSessionHasErrors('password');
    }
}
