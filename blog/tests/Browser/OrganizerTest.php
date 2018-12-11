<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

use App\EventVenue;
use App\User;

use Tests\Browser\Pages\LoginPage;

class OrganizerTest extends DuskTestCase
{
    
    public function test_organizers_list_is_showing(){  
        
        $this->browse(function (Browser $browser) {
            $browser->on(new LoginPage)
                    ->loginUser() 
                    ->visit('/organizers')
                    ->assertSee('Organizers management'); // The list is empty because the new user didn't create an event yet
                    //->dump();
        });
        
    }
    
}
