<?php

namespace Tests\Feature\Commands;

use App\Models\Colleague;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Client\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class SynchronizeColleaguesCommandTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_synchronize_colleagues_from_a_pastebin_resource()
    {
        Http::fake([
            'https://pastebin.com/raw/uDzdKzGG' => Http::response([
                ['name' => 'Mark Walet', 'email' => 'mark.walet@gmail.com'],
                ['name' => 'Kevin Pijning', 'email' => 'k.pijning@dij.digital'],
                ['name' => 'Joëlle van Strien', 'email' => 'j.strien@dij.digital'],
            ])
        ]);

        $output = $this->artisan('colleagues:sync')->execute();

        $this->assertEquals(0, $output);
        Http::assertSent(function (Request $request) {
            return $request->url() === 'https://pastebin.com/raw/uDzdKzGG';
        });
        $this->assertDatabaseCount('colleagues', 3);
        $this->assertDatabaseHas('colleagues', ['name' => 'Mark Walet', 'email' => 'mark.walet@gmail.com']);
        $this->assertDatabaseHas('colleagues', ['name' => 'Kevin Pijning', 'email' => 'k.pijning@dij.digital']);
        $this->assertDatabaseHas('colleagues', ['name' => 'Joëlle van Strien', 'email' => 'j.strien@dij.digital']);
    }

    /** @test */
    public function it_updates_the_name_when_a_colleague_with_the_same_email_adress_already_exists()
    {
        Http::fake([
            'https://pastebin.com/raw/uDzdKzGG' => Http::response([
                ['name' => 'Mark Walet', 'email' => 'mark.walet@gmail.com'],
            ])
        ]);
        $colleague = Colleague::factory()->create(['email' => 'mark.walet@gmail.com']);

        $output = $this->artisan('colleagues:sync')->execute();
        $colleague->refresh();

        $this->assertEquals(0, $output);
        $this->assertEquals('Mark Walet', $colleague->name);
        $this->assertDatabaseCount('colleagues', 1);
    }
}
