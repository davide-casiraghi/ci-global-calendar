<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Teacher;
use App\User;


class TeacherTest extends TestCase
{
    use WithFaker;
    
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        // Authenticate the user
            $this->authenticate();
        
        // Post a data to create teacher
            $data = [
                //'id' => $this->teachers->id,
                'name' => $this->faker->name,
                'bio' => $this->faker->paragraph,
                'year_starting_practice' => "2000",
                'year_starting_teach' => "2006",
                'significant_teachers' => $this->faker->paragraph,
                'profile_picture' => str_random(10).".jpg",
                'website' => $this->faker->url,
                'facebook' => "https://www.facebook.com/".$this->faker->word,
                'created_by' => 1,
                'slug' => $this->faker->slug,
                'country_id' => $this->faker->numberBetween($min = 1, $max = 253),
            ];
            $response = $this->post('/teachers', $data);
            //$response = $this->json('POST', '/teachers', $data);
            dd($response);
        // Assert in database
            $this->assertDatabaseHas('teachers',$data);
            
        // Status
            $response->assertStatus(201);
    
    }
    
    /*public function a_logged_user_can_create_teacher(){
        
        
    }*/
}
