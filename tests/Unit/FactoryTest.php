<?php

namespace Tests\Unit;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\LoadsModels;
use Tests\TestCase;

class FactoryTest extends TestCase
{
    use LoadsModels;
    use RefreshDatabase;

    /**
     * @param string $class
     *
     * @test
     * @dataProvider models
     */
    public function it_can_create_a_model_by_using_the_default_factory(string $class)
    {
        /** @var Model $model */
        $model = $class::factory()->create();

        $table = $model->getTable();
        $this->assertDatabaseHas($table, [
            'id' => $model->id,
        ]);
    }
}
