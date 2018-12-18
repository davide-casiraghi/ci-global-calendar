<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase; // empty the test DB
    
    /***************************************************************************/
    /**
     * Populate test DB with dummy data
     */
    function setUp(){
        parent::setUp();
        
        // Seeders - /database/seeds
            $this->seed(); 
        
        // Seeders - /database/factories
            $this->user = factory(\App\User::class)->create();
    }
    /***************************************************************************/
    /**
     * Test that logged user can see teachers index view
     */  
    public function test_logged_user_can_see_posts_index(){
        // Authenticate the user
            $this->authenticate();
        
        // Access to the page
            $response = $this->get('/posts')
                             ->assertStatus(200);
    }
}
