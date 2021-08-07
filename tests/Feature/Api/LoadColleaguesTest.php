<?php

namespace Tests\Feature\Api;

use App\Models\Colleague;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoadColleaguesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_authenticated_user_can_load_a_list_of_colleagues()
    {
        $this->asUser();
        [$colleagueA, $colleagueB] = Colleague::factory()->count(2)->create();

        $response = $this->getJson(route('colleagues.index'));

        $response->assertOk();
        $this->assertContains($colleagueA->id, $response->json('data.*.id'));
        $this->assertContains($colleagueB->id, $response->json('data.*.id'));
    }

    /** @test */
    public function a_guest_cannot_load_a_list_of_colleagues()
    {
        $response = $this->getJson(route('colleagues.index'));

        $response->assertUnauthorized();
    }
}
