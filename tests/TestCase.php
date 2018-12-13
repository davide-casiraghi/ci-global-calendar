<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

use App\User;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    
    // Authenticate the user
    public function authenticate(){
        $user = factory(User::class)->make();
        $this->actingAs($user); 
    }
    
    
}
