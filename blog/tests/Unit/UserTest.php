<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use WithFaker;
    
    public function test_see_user_registration(){
        $response =  $this->get('register')
                          ->assertStatus(200);
    }
    
    /**
     * A basic test example.
     *
     * @return void
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
                ->post('register', $data);
                
        // Assert in database
            $this->assertDatabaseHas('users',[
                'email' => $data['email']
            ]);
            
            
         /* $response = $this
                ->followingRedirects()  //Without followingRedirects I get 302 (redirect)
                ->post('register', $data)
                ->assertStatus(200);
                //->assertSee(__('auth.successfully_registered'));  
                //dd($response);*/
        
            
        
        
        
        
        
        
            
            //$response->assertRedirectedTo('/');
        // Assert in database
            //$this->assertDatabaseHas('users',$data);
            /*$this->assertDatabaseHas('users',[
                'name' => $data['name']
            ]);*/
    
    
        /*
        $response
            ->assertStatus(201)
            ->assertJson([
                'created' => true,
            ]);
        */
        
        $this->assertTrue(true);
    }
}
