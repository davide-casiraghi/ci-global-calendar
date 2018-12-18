<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Event;
use App\User;
use App\Country;
use App\Teacher;
use App\EventVenue;
use App\Organizer;

use App\Http\Controllers\Auth\EventController;


class EventTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase; // empty the test DB
    
    /***************************************************************************/
    /**
     * Populate test DB with dummy data
     */
    function setUp()
    {
        parent::setUp();
        
        // Seeders - /database/seeds
            $this->seed(); 
        
        // Seeders - /database/factories
            $this->user = factory(\App\User::class)->create();
            $this->venue = factory(\App\EventVenue::class)->create();
            $this->teachers = factory(\App\Teacher::class,3)->create();
            $this->organizers = factory(\App\Organizer::class,3)->create();
    }
    
    /***************************************************************************/
    /**
     * Test that logged user can see event index view
     */    
    public function test_logged_user_can_see_events_index(){
        // Authenticate the user
            $this->authenticate();
        
        // Access to the page
            $response = $this->get('/events')
                             ->assertStatus(200);
    }
    
    /***************************************************************************/
    /**
     * Test that the monthSelectOptions function return the right HTML
     * This function is called trough ajax in the view - partial/repeat-event.blade.php 
     * The html contain a select dropdown that change every time that start date is changed in the event create and edit view
     */     
    public function test_decode_on_monthly_kind_function(){
        // Authenticate the user
            $this->authenticate();
            
        // Access to the page
            $response = $this->get('en/event/monthSelectOptions?day=10/01/2019')
                 ->assertStatus(200);
        
        // Assert the value is the one aspected 
            $codeToCompare = "<select name='on_monthly_kind' id='on_monthly_kind' class='selectpicker' title='Select repeat monthly kind'><option value='0|10'>the 10th day of the month</option><option value='1|2|4'>the 2nd Thursday of the month</option><option value='2|20'>the 21th to last day of the month</option><option value='3|3|4'>the 4th to last Thursday of the month</option></select>";
            $this->assertSame($response->original, $codeToCompare);
    }

    /***************************************************************************/
    /**
     * Test that the logged user can create an event
     */  
    public function test_a_logged_user_can_create_event(){
        
        // Authenticate the user
            $this->authenticate();
            
        // Teachers id
            $teachers_id = "";
            $i = 0; $len = count($this->teachers);
            foreach ($this->teachers as $key => $teacher) {
                $teachers_id .= $teacher->id;
                if ($i != $len - 1)  // not last
                    $teachers_id .= ", ";
                $i++;
            }
            
        // Post datas to create event (we don't include created_by and slug becayse are generated by the store method )
            $title = $this->faker->sentence($nbWords = 3);
            $data = [
                'title' => $title,
                'category_id' => '3',
                'description' => $this->faker->paragraph,
                'created_by' => $this->user->id,
                'slug' => str_slug($title, '-').rand(100000, 1000000),
                'multiple_teachers' => $teachers_id,
                'multiple_organizers' => '1,2',
                'venue_id' => $this->venue->id,
                'startDate' => '10/01/2022',
                'endDate' => '12/01/2022',
                'time_start' => '6:00 PM',
                'time_end' => '8:00 PM',
                'repeat_type' => '1',
                'facebook_event_link' => "https://www.facebook.com/".$this->faker->word,
                'website_event_link' => $this->faker->url,
            ];
            $response = $this->post('/events', $data);
            
        // Assert in database
            $this->assertDatabaseHas('events',['title' => $title]);
                
    }
    
}
