<?php

namespace Tests;

use App\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * 
     * 
     * @return 
     */
    public function signIn()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);
        return $this;
    }
}
