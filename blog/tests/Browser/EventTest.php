<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

use App\Event;
use App\User;

use Tests\Browser\Pages\LoginPage;

class EventsTest extends DuskTestCase
{

  /**
   * Verify if the teachers list is showing
   *
   * @return void
   */
    public function test_events_list_is_showing(){
        $this->browse(function (Browser $browser) {
            $browser->on(new LoginPage)
                    ->loginUser()
                    ->visit('/events')
                    ->assertSee('Events management') // The list is empty because the new user didn't create an event yet
                    ->logoutUser();
        });
    }
    
    /*******************************************************************************/
    
    /**
     * Open the Create teacher form
     *
     * @return void
     */
      public function test_open_create_event(){
          $this->browse(function (Browser $browser) {
              $browser->on(new LoginPage)
                      ->loginUser()
                      ->visit('/events')  
                      ->clickLink('Add New event')
                      ->assertSee('Start, End, Duration')
                      ->logoutUser();
          });
          
      }    
    
      /*******************************************************************************/
      
    
     
}
