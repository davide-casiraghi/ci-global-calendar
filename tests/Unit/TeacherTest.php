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
        
        // Seeders - /database/seeds
            $this->seed();
        
        // Factories - /database/factories
            $this->teacher = factory(\App\Teacher::class)->create();
    }
    
    /***************************************************************************/
    /**
     * Test that logged user can see teachers index view
     */  
    public function test_logged_user_can_see_teachers_index(){
        // Authenticate the user
            $this->authenticate();
        
        // Access to the page (teacher.index)
            $response = $this->get('/teachers')
                             ->assertStatus(200);
    }
    
    /***************************************************************************/
    /**
     * Test that guest user can see a teacher
     */  
    public function test_guest_user_can_see_single_teacher(){
            
        // Access to the page (teacher.show)
            $response = $this->get('/teachers/'.$this->teacher->id.'/')
                         ->assertStatus(200);
    }
    
    /***************************************************************************/
    /**
     * Test that logged user can create a teacher
     */  
    public function test_a_logged_user_can_create_teacher()
    {
        // Authenticate the user
            $this->authenticate();
        
        // Post datas to create teacher (we don't include created_by and slug becayse are generated by the store method )
            $bio = $this->faker->paragraph;
            $data = [
                'name' => $this->faker->name,
                'bio' => $bio,
                'year_starting_practice' => "2000",
                'year_starting_teach' => "2006",
                'significant_teachers' => $this->faker->paragraph,
                'website' => $this->faker->url,
                'facebook' => "https://www.facebook.com/".$this->faker->word,
                'country_id' => $this->faker->numberBetween($min = 1, $max = 253),
            ];
            $response = $this
                            ->followingRedirects()
                            ->post('/teachers', $data);
            
        // Assert in database
            $data['bio'] = clean($bio);
            $this->assertDatabaseHas('teachers',$data);
            
        // Status
            $response
                    ->assertStatus(200)
                    ->assertSee(__('messages.teacher_added_successfully'));
    }

    /***************************************************************************/
    /**
     * Test that guest user can UPDATE a teacher
     */  
    public function test_guest_user_can_update_teacher(){
        
        // Authenticate the user
            $this->authenticate();
            
        // Update the post
            $this->teacher->name = "New Name";
            $response = $this
                        ->followingRedirects()
                        ->put('/teachers/'.$this->teacher->id, $this->teacher->toArray())
                        ->assertSee("Teacher updated successfully");
                
        // Check the update on DB        
            $this->assertDatabaseHas('teachers',['id'=> $this->teacher->id , 'name' => 'New Name']);
    }
    
    /***************************************************************************/
    /**
     * Test that guest user can DELETE an teacher
     */  
    public function test_guest_user_can_delete_teacher(){
        
        // Authenticate the user
            $this->authenticate();
            
        // Delete the post
            $response = $this
                        ->followingRedirects()
                        ->delete('/teachers/'.$this->teacher->id, $this->teacher->toArray())
                        ->assertSee("Teacher deleted successfully");
                
        // Check the update on DB        
            $this->assertDatabaseMissing('teachers',['id'=> $this->teacher->id]);
    }    
    
    
    
}
