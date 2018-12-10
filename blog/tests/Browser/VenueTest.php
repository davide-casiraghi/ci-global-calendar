<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

use App\EventVenue;
use App\User;

class VenueTest extends DuskTestCase
{
    
    public function test_see_venues(){    
        $this->browse(function ($first) {
            $first->loginAs(User::find(1))
                  ->visit('/eventVenues')
                  ->assertSee('Venues management');
        });
    }
    
}
