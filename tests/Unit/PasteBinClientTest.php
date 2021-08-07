<?php

namespace Tests\Unit;

use App\Support\PasteBinClient;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class PasteBinClientTest extends TestCase
{
    /** @test */
    public function the_client_can_make_an_url_without_double_slashes()
    {
        $clientA = new PasteBinClient(['url' => 'example.org']);
        $clientB = new PasteBinClient(['url' => 'with-forward-slash.org/']);

        $this->assertEquals('example.org/resource', $clientA->makeUrl('resource'));
        $this->assertEquals('example.org/resource', $clientA->makeUrl('/resource'));
        $this->assertEquals('with-forward-slash.org/resource', $clientB->makeUrl('resource'));
        $this->assertEquals('with-forward-slash.org/resource', $clientB->makeUrl('/resource'));
    }

    /** @test */
    public function it_can_get_data_from_a_pastebin_resource()
    {
        Http::fake([
            'https://pastebin.org/s9Dam0d' => Http::response('Lorem ipsum'),
        ]);
        $client = new PasteBinClient(['url' => 'https://pastebin.org']);
        $result = $client->get('s9Dam0d');

        Http::assertSent(function (Request $request) {
            return $request->url() === 'https://pastebin.org/s9Dam0d';
        });
        $this->assertEquals('Lorem ipsum', $result);
    }

    /** @test */
    public function it_can_get_parsed_json_from_a_pastebin_resource()
    {
        Http::fake([
            'https://pastebin.org/s0Dh7H' => Http::response(['data' => 'lorem ipsum']),
        ]);
        $client = new PasteBinClient(['url' => 'https://pastebin.org']);
        $result = $client->json('s0Dh7H');

        Http::assertSent(function (Request $request) {
            return $request->url() === 'https://pastebin.org/s0Dh7H';
        });
        $this->assertEquals(['data' => 'lorem ipsum'], $result);
    }
}
