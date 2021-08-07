<?php

namespace Tests\Feature\Features\Messages;

use App\Models\Colleague;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Inertia\Testing\Assert;

class CreateMessageTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_authenticated_user_can_view_the_create_message_page()
    {
        $this->asUser();
        Colleague::factory()->count(2)->create();

        $response = $this->get(route('messages.create'));

        $response->assertOk();
        $response->assertInertia(fn (Assert $page) => $page
            ->component('Messages/CreateMessage')
            ->has('colleagues', 2)
        );
    }

    /** @test */
    public function a_guest_cannot_view_the_create_message_page()
    {
        Colleague::factory()->count(2)->create();

        $response = $this->get(route('messages.create'));

        $response->assertRedirect();
    }
}
