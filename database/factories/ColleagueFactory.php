<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

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
