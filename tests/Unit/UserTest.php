<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase; // empty the test DB
    
    /***************************************************************************/
    /**
     * Populate test DB with dummy data
     */    
    public function setUp()
    {
        parent::setUp();
        $this->seed();
    }
    
    /***************************************************************************/
    /**
     * Test that guest user can see user registration
     */ 
    public function test_see_user_registration(){
        $response =  $this->get('register')
                          ->assertStatus(200);
    }
    
    /***************************************************************************/
    /**
     * Test that guest user can register
     */ 
    public function test_user_registration()
    {
        // Post a data to register a user 
            $password = $this->faker->password;
            $data = [
                'name' => $this->faker->name,
                'email' => $this->faker->email,
                'password' => $password,
                'password_confirmation' => $password,
                'country_id' => $this->faker->numberBetween($min = 1, $max = 253),
                'description' => $this->faker->paragraph,
                'accept_terms' => 1,
            ];
            $response = $this
                ->followingRedirects()
                ->post('register', $data);
                
        // Assert in database
            $this->assertDatabaseHas('users',[
                'email' => $data['email']
            ]);
            
            $response
                ->assertStatus(200)
                ->assertSee(__('auth.successfully_registered'));
    }
}
