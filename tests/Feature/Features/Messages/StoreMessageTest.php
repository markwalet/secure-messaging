<?php

namespace Tests\Feature\Features\Messages;

use App\Models\Colleague;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StoreMessageTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_authenticated_user_can_view_the_create_message_page()
    {
        $user = $this->asUser();
        $colleague = Colleague::factory()->create();

        $response = $this->post(route('messages.store'), $this->validData([
            'message'   => 'A very secret message',
            'colleague' => $colleague->id,
        ]));

        $response->assertRedirect(route('messages.create'));
        $this->assertDatabaseCount('messages', 1);
        $this->assertDatabaseHas('messages', [
            'colleague_id' => $colleague->id,
            'user_id'      => $user->id,
            'message'      => 'A very secret message',
        ]);
    }

    /** @test */
    public function it_validates_that_the_selected_colleague_must_be_an_existing_colleague()
    {
        $this->asUser();

        $response = $this->post(route('messages.store'), $this->validData([
            'colleague' => 153,
        ]));

        $response->assertSessionHasErrors('colleague');
        $this->assertDatabaseCount('messages', 0);
    }

    /** @test */
    public function a_guest_cannot_store_a_message()
    {
        $response = $this->post(route('messages.store'), $this->validData());

        $response->assertRedirect();
    }

    /**
     * @param array $data
     *
     * @return array
     */
    private function validData(array $data = []): array
    {
        return array_map('value', array_merge([
            'colleague' => fn () => Colleague::factory()->create()->id,
            'message'   => 'Lorem ipsum dolor sit amed',
        ], $data));
    }
}
