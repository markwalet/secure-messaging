<?php

namespace Database\Factories;

use App\Models\Colleague;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method Colleague|Colleague[] create($attributes = [], ?Model $parent = null)
 * @method Colleague|Colleague[] make($attributes = [], ?Model $parent = null)
 */
class ColleagueFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'name'  => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail(),
        ];
    }
}
