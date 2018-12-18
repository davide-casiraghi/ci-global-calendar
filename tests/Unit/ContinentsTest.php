<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;


class ContinentsTest extends TestCase
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
        $this->seed();
    }

    /***************************************************************************/
    /**
     * Test that logged user can see continents index view
     */  
    public function test_logged_user_can_see_continents(){
        // Authenticate the user
            $this->authenticate();
        
        // Access to the page
            $response = $this->get('/continents')
                ->assertStatus(200);    
    }
    
    
}
