<?php

namespace Database\Factories;

use App\Models\Colleague;
use App\Models\Message;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method Message|Message[] create($attributes = [], ?Model $parent = null)
 * @method Message|Message[] make($attributes = [], ?Model $parent = null)
 */
class MessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'colleague_id'    => Colleague::factory(),
            'user_id'         => User::factory(),
            'password'        => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'message'         => $this->faker->sentence,
            'available_until' => now()->addHours(Message::KEEPALIVE),
        ];
    }
}
