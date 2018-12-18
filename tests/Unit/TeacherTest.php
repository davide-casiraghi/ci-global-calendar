<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TeacherTest extends TestCase
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
     * Test that logged user can see teachers index view
     */  
    public function test_logged_user_can_see_teachers_index(){
        // Authenticate the user
            $this->authenticate();
        
        // Access to the page
            $response = $this->get('/teachers')
                             ->assertStatus(200);
    }
    
    /*public function test_logged_user_can_see_single_teacher(){
        // Authenticate the user
            $this->authenticate();
            
        // Access to the page
            $response = $this->get('/teachers/1/')
                         ->assertStatus(200);
        
            //$this->action('GET', 'TeachersController@show', ['id' => 3]);
            
            //$response = $this->get('TeachersController@show', ['id' => 3]);
            //$response = $this->get('/teachers/'.$id.'/');
            //dd($response);
            
            //$response = $this->get('/teachers/'.$id)
                        //     ->assertStatus(200);
    }*/
    
    /***************************************************************************/
    /**
     * Test that logged user can create a teacher
     */  
    public function test_a_logged_user_can_create_teacher()
    {
        // Authenticate the user
            $this->authenticate();
        
        // Post datas to create teacher (we don't include created_by and slug becayse are generated by the store method )
            $data = [
                'name' => $this->faker->name,
                'bio' => $this->faker->paragraph,
                'year_starting_practice' => "2000",
                'year_starting_teach' => "2006",
                'significant_teachers' => $this->faker->paragraph,
                'website' => $this->faker->url,
                'facebook' => "https://www.facebook.com/".$this->faker->word,
                'country_id' => $this->faker->numberBetween($min = 1, $max = 253),
            ];
            $response = $this->post('/teachers', $data);
            
        // Assert in database
            $this->assertDatabaseHas('teachers',$data);
            
        // Status
            $response->assertStatus(302); // I aspect redirect (301 or 302) because after store get redirected to teachers.index
    
    }
    
    
}
