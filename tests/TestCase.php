<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Login as a user.
     *
     * @param array  $attributes
     * @param string $guard
     *
     * @return User
     */
    public function asUser(array $attributes = [], string $guard = 'sanctum'): User
    {
        $user = User::factory()->create($attributes);

        $this->be($user, $guard);

        return $user;
    }
}
