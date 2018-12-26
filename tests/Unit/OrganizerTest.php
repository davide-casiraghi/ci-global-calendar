<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrganizerTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;  // empty the test DB

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
            $this->organizer = factory(\App\Organizer::class)->create();
    }

    /***************************************************************************/
    /**
     * Test that guest user can see organizers index view
     */  
    public function test_logged_user_can_see_organizers(){
        // Authenticate the user
            $this->authenticate();
        
        // Access to the page
            $response = $this->get('/organizers')
                             ->assertStatus(200);
    }
 
    /***************************************************************************/
    /**
     * Test that guest user can see an organizer
     */  
    public function test_guest_user_can_see_single_organizer(){
            
        // Access to the page (teacher.show)
            $response = $this->get('/en/organizers/'.$this->organizer->id.'/')
                         ->assertStatus(200);
    }
    
    /***************************************************************************/
    /**
     * Test that registered user can create an organizer
     */  
    public function test_a_logged_user_can_create_organizer()
    {
        // Authenticate the user
            $this->authenticate();
    
        // Post a data to create teacher (I dont' post created_by and slub becayse are generated by the store method )
            $description = $this->faker->paragraph;
            $data = [
                'name' => $this->faker->name,
                'website' => $this->faker->url,
                'description' => $description,
                'email' => $this->faker->email,
                'phone' => $this->faker->e164PhoneNumber,
            ];
            $response = $this
                        ->followingRedirects()
                        ->post('/organizers', $data);
            
        // Assert in database
            $data['description'] = clean($description);
            $this->assertDatabaseHas('organizers',$data);
            
        // Status
            $response
                    ->assertStatus(200)
                    ->assertSee(__('general.organizer').__('views.created_successfully'));
    }
    
    /***************************************************************************/
    /**
     * Test that guest user can UPDATE an organizer
     */  
    public function test_guest_user_can_update_organizer(){
        
        // Authenticate the user
            $this->authenticate();
            
        // Update the post
            $this->organizer->name = "New Name";
            $response = $this
                        ->followingRedirects()
                        ->put('/en/organizers/'.$this->organizer->id, $this->organizer->toArray())
                        ->assertSee("Organizer updated successfully");
                
        // Check the update on DB        
            $this->assertDatabaseHas('organizers',['id'=> $this->organizer->id , 'name' => 'New Name']);
    }
    
    /***************************************************************************/
    /**
     * Test that guest user can DELETE an organizer
     */  
    public function test_guest_user_can_delete_organizer(){
        
        // Authenticate the user
            $this->authenticate();
            
        // Delete the post
            $response = $this
                        ->followingRedirects()
                        ->delete('/en/organizers/'.$this->organizer->id, $this->organizer->toArray())
                        ->assertSee("Organizer deleted successfully");
                
        // Check the update on DB        
            $this->assertDatabaseMissing('organizers',['id'=> $this->organizer->id]);
    }
    
    

}
