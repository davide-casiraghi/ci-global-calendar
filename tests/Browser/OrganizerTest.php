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
    use DatabaseMigrations;
    
    
    public function setUp(){
        Parent::setUp();
        
        // Seeders - /database/seeds
            $this->seed(); 
        
        // Factories - /database/factories
            $this->user = factory(\App\User::class)->create();
            $this->venue = factory(\App\EventVenue::class)->create();
            $this->teachers = factory(\App\Teacher::class,3)->create();
            $this->organizers = factory(\App\Organizer::class,3)->create();
    }
    
    /**
     * Verify if the teachers list is showing
     *
     * @return void
     */
    public function test_organizers_list_is_showing(){
        
        $this->browse(function (Browser $browser) {
            $browser->on(new LoginPage)
                    ->loginUser() 
                    ->visit('/organizers')
                    ->assertSee('Organizers management') // The list is empty because the new user didn't create an event yet
                    ->logoutUser();
        });
    }
    
    /*******************************************************************************/
    
    /**
    * Create a new organizer
    *
    * @param  \Laravel\Dusk\Browser  $browser
    * @param  string  $name
    * @return void
    */
   public function test_create_new_organizer(){
       $this->browse(function (Browser $browser) {
           $browser->on(new LoginPage)
                   ->loginUser()
                      ->visit('/organizers')
                        ->clickLink('Add new organizer')
                         ->type('name', 'Test organizer')
                         ->type('email', 'test@testorganizer.com')
                         ->type('phone', '12312312343')
                         ->type('website', 'http://www.test.com') 
                         ->waitFor('#bodyTextarea_ifr');
                        
            $browser->driver->executeScript('tinyMCE.activeEditor.setContent(\'eeeeee\')');
            
            $browser->resize(1920, 3000)
                    ->press('Submit')
                    ->assertSee('Organizer created successfully')
                    ->logoutUser();                   
       });
   }
   
   /*******************************************************************************/
   
   
    
}
