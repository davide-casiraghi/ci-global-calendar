<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

use App\Teacher;
use App\User;

use Tests\Browser\Pages\LoginPage;

class TeachersTest extends DuskTestCase{

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
    public function test_teachers_list_is_showing(){
        $this->browse(function (Browser $browser) {
            $browser->on(new LoginPage)
                    ->loginUser()
                    ->visit('/teachers')
                    ->assertSee('Teachers management') // The list is empty because the new user didn't create an event yet
                    ->logoutUser();
        });
    }
    
    /*******************************************************************************/
    
    /**
     * Open the Create teacher form
     *
     * @return void
     */
      public function test_open_create_teacher(){
          $this->browse(function (Browser $browser) {
              $browser->on(new LoginPage)
                      ->loginUser()
                      ->visit('/teachers')   //dusk don't like to visit page /teachers/create, so let's go there clicking
                      ->clickLink('Add new teacher')
                      ->assertSee('Year of starting to practice')
                      ->logoutUser();
          });
          
      }    
    
      /*******************************************************************************/
      
      /**
      * Create a new teacher.
      *
      * @param  \Laravel\Dusk\Browser  $browser
      * @param  string  $name
      * @return void
      */
     public function test_create_new_teacher(){
         $this->browse(function (Browser $browser) {
             $browser->on(new LoginPage)
                     ->loginUser()
                        ->visit('/teachers')
                          ->clickLink('Add new teacher')
                           ->type('name', 'Test Teacher')
                           ->select('country_id', 5)
                           ->type('bio', 'lorem ipsum dolet')
                           ->type('year_starting_practice', '1999')
                           ->type('year_starting_teach', '1995')
                           ->type('significant_teachers', 'test teachers')
                           ->type('facebook', 'http://www.facebook.com/test')
                           ->type('website', 'http://www.test.it')
                           ->resize(1920, 3000)
                       ->press('Submit')
                       ->assertSee('Teacher created successfully')
                       ->logoutUser();                   
         });
     }
     
}
