<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

use App\EventVenue;
use App\User;

use Tests\Browser\Pages\LoginPage;

class VenueTest extends DuskTestCase{
    
    use DatabaseMigrations;

    public function setUp(){
        Parent::setUp();
        
        // Seeders - /database/seeds
            $this->seed(); 
        
    }
    
    /**
     * Verify if the venues list is showing
     *
     * @return void
     */
    public function test_venues_list_is_showing(){
        
        $this->browse(function (Browser $browser) {
            $browser->on(new LoginPage)
                    ->loginUser()
                    ->visit('/eventVenues')
                    ->assertSee('Venues management') // The list is empty because the new user didn't create an event yet
                    ->logoutUser();
        });
    }
    
    /*******************************************************************************/
    
    
    
}
