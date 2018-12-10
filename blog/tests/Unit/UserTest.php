<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
    
        /*$response = $this->json('POST', '/users', [
            'name' => 'Sally',
            'email' => 'sdfsd@sdfsd.it',
            'password' => 'asdf987as9d87f9',
            'group' => 1,
            'country_id' => 5,
            'description' => 'ciao ciao',
            'accept_terms' => 1,
            'activation_code' => 'sdfasdf8768a6',
            'status' => 1,
        ]);
        $response
            ->assertStatus(201)
            ->assertJson([
                'created' => true,
            ]);
        */
        
        $this->assertTrue(true);
    }
}
