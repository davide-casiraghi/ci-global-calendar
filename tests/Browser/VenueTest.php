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

    /***************************************************************************/
    /**
     * Populate test DB with seeds 
     */
    public function setUp(){
        Parent::setUp();
        
        // Seeders - /database/seeds (continetns, countries, post categories, event categories)
            $this->seed(); 
    }
    
    /***************************************************************************/
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
    /**
    * Create a new venues
    *
    * @param  \Laravel\Dusk\Browser  $browser
    * @param  string  $name
    * @return void
    */
   public function test_create_new_venue(){
       $this->browse(function (Browser $browser) {
           $browser->on(new LoginPage)
                   ->loginUser()
                      ->visit('/eventVenues')
                        ->click('a.create-new')
                         ->type('name', 'Test venue name ')
                         ->type('address', 'test venue address')
                         ->type('city', 'test venue city')
                         ->type('state_province', 'test state province')
                         ->select('country_id', 5)
                         ->type('zip_code', '23422')
                         ->type('website', 'http://www.test.com') 
                         ->waitFor('#bodyTextarea_ifr');
                        
            $browser->driver->executeScript('tinyMCE.activeEditor.setContent(\'dummy description\')');
            
            $browser->resize(1920, 3000)
                    ->press('Submit')
                    ->assertSee(__('messages.venue_added_successfully'))
                    ->logoutUser();                   
       });
   }
    
}
