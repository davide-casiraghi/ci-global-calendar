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
    use DatabaseMigrations;
    
    /***************************************************************************/
    /**
     * Populate test DB with seeds and dummy data 
     */
    public function setUp(){
        Parent::setUp();
        
        // Seeders - /database/seeds (continetns, countries, post categories, event categories)
            $this->seed(); 
        
        // Factories - /database/factories
            $this->user = factory(\App\User::class)->create();
            $this->venue = factory(\App\EventVenue::class)->create();
            $this->teachers = factory(\App\Teacher::class,3)->create();
            $this->organizers = factory(\App\Organizer::class,3)->create();
    }

    /***************************************************************************/
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
      /**
      * Create a new event
      *
      * @param  \Laravel\Dusk\Browser  $browser
      * @param  string  $name
      * @return void
      */
     public function test_create_new_event(){
         $this->browse(function (Browser $browser) {
             $browser->on(new LoginPage)
                     ->loginUser()
                        ->visit('/events')
                          ->clickLink('Add New event')
                           ->type('title', 'Test event')
                           ->select('category_id', 3)
                           ->waitFor('#bodyTextarea_ifr');
                           
             $browser->driver->executeScript('tinyMCE.activeEditor.setContent(\'test event description\')');
             $browser->driver->executeScript("document.getElementById('multiple_teachers').value = '1';");
             $browser->driver->executeScript("document.getElementById('multiple_organizers').value = '1';");
             $browser->select('venue_id', 1);
             $browser->driver->executeScript("document.getElementsByName('startDate').value = '10/10/2023';");
             $browser->driver->executeScript("document.getElementsByName('endDate').value = '12/10/2023';");
            
             $browser->type('facebook_event_link', 'http://www.facebook.com/2342fsdfadc')
                     ->type('website_event_link', 'http://www.testwebsite.com');
            
              $browser->resize(1920, 3000)
                      ->press('Submit')
                      ->assertSee('Event created successfully')
                      ->logoutUser();   
         });
     }
    
     
     /*public function initDatabase(){
         // Seeders - /database/seeds
             $this->seed(); 
         
         // Factories - /database/factories
             $this->user = factory(\App\User::class)->create();
             $this->venue = factory(\App\EventVenue::class)->create();
             $this->teachers = factory(\App\Teacher::class,3)->create();
             $this->organizers = factory(\App\Organizer::class,3)->create();
     }*/
}
