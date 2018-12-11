<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

use App\EventVenue;
use App\User;

use Tests\Browser\Pages\LoginPage;

class VenueTest extends DuskTestCase
{
    
    public function test_venues_list_is_showing(){  
        
        
          
        /*$this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->assertSee('Contact Improvisation');
        });*/
        
        $this->browse(function (Browser $browser) {
            $browser->on(new LoginPage)
                    ->loginUser()
                    ->visit('/eventVenues')
                    ->assertSee('Venues management');
                    //->waitFor('.venuesList');
        });
        
        /*$this->browse(function ($first) {
            $first->loginAs(User::find(1))
                  ->visit('/eventVenues')->dump();
//                  ->assertSee('Venues management');
});*/
        
    }
    
}
