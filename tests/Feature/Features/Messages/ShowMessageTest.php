<?php

namespace Tests\Feature\Features\Messages;

use App\Models\Message;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\URL;
use Inertia\Testing\Assert;
use Tests\TestCase;

class ShowMessageTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_view_the_form_for_showing_a_message()
    {
        $message = Message::factory()->create();
        $signedRoute = URL::signedRoute('decrypt-message', compact('message'));

        $response = $this->get(URL::signedRoute('messages.show', compact('message')));

        $response->assertOk();
        $response->assertInertia(fn (Assert $page) => $page->component('Messages/ShowMessage')->where('signedRoute', $signedRoute));
    }

    /** @test */
    public function a_user_cannot_view_the_form_without_signing_the_url()
    {
        $message = Message::factory()->create();

        $response = $this->get(route('messages.show', compact('message')));

        $response->assertForbidden();
    }
}
