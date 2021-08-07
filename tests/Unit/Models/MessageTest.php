<?php

namespace Tests\Unit\Models;

use App\Models\Colleague;
use App\Models\Message;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MessageTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_a_colleague_relation()
    {
        $colleague = Colleague::factory()->create();
        $message = Message::factory()->create([
            'colleague_id' => $colleague->id,
        ]);

        $result = $message->refresh()->colleague;

        $this->assertTrue($colleague->is($result));
    }
}
