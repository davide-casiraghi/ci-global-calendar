<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VenueTest extends TestCase
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
            $this->venue = factory(\App\EventVenue::class)->create();
    }

    /***************************************************************************/
    /**
     * Test that guest user can see organizers index view
     */  
    public function test_logged_user_can_see_venue(){
        // Authenticate the user
            $this->authenticate();
        
        // Access to the page
            $response = $this->get('/eventVenues')
                             ->assertStatus(200);
    }

    /***************************************************************************/
    /**
     * Test that guest user can see an organizer
     */  
    public function test_guest_user_can_see_single_venue(){
            
        // Access to the page (teacher.show)
            $response = $this->get('/en/eventVenues/'.$this->venue->id.'/')
                         ->assertStatus(200);
    }
    
    /***************************************************************************/
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }
}
