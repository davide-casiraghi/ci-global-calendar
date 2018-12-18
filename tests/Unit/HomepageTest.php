<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HomepageTest extends TestCase
{
    use WithFaker;
    
    /***************************************************************************/
    /**
     * Test that logged user can see the homepage
     */  
    public function test_guest_user_can_see_homepage()
    {
        // Access to the page
            $response = $this->get('/')
                             ->assertStatus(200);
    }
    
    /***************************************************************************/
    /**
     * Test that logged user can search events in the homepage
     * If this test fail try to run -> php artisan cache:clear
     */  
    public function test_guest_user_can_search_events()
    {
        // Access to the page
            $response = $this->get('/eventSearch#dataarea')
                             ->assertStatus(200);
    }    
}
