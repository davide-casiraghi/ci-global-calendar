<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Event;
use App\User;

use App\Http\Controllers\Auth\EventController;


class EventTest extends TestCase
{
    use WithFaker;
    
    public function test_logged_user_can_see_events_index(){
        // Authenticate the user
            $this->authenticate();
        
        // Access to the page
            $response = $this->get('/events')
                             ->assertStatus(200);
    }
    
    
    public function test_decode_on_monthly_kind_function(){
        // Authenticate the user
            $this->authenticate();
            
        // Access to the page
            $data = ['day' => '10/01/2019'];
            
            /*$response = $this->get('en/event/monthSelectOptions')
                             ->assertStatus(200);*/
            
            //$response = $this->get('en/event/monthSelectOptions', $data)
            $response = $this->get('en/event/monthSelectOptions?day=10/01/2019')
                 ->assertStatus(200);
            //dd($response->original);
        
        $codeToCompare = "<select name='on_monthly_kind' id='on_monthly_kind' class='selectpicker' title='Select repeat monthly kind'><option value='0|10'>the 10th day of the month</option><option value='1|2|4'>the 2nd Thursday of the month</option><option value='2|20'>the 21th to last day of the month</option><option value='3|3|4'>the 4th to last Thursday of the month</option></select>";
        $this->assertSame($response->original, $codeToCompare);
        
        /*
        // Refresh db
        
        // Populate with dummy data
        
        // Post new events with different of monthly kind occurances
            $title = $this->faker->name;
            $data = [
                'title' => $title,
                'category_id' => "2000",
                'description' => $this->faker->paragraph,
                'created_by' => '1',
                'slug' = str_slug($title, '-').rand(100000, 1000000),
                'venue_id' => '1',
                'website_event_link' => '1',
                'facebook_event_link' => '1',
                'on_monthly_kind' => '1',
                
                
                $event->venue_id = $request->get('venue_id');
                $event->image = $request->get('image');
                $event->website_event_link = $request->get('website_event_link');
                $event->facebook_event_link = $request->get('facebook_event_link');
                $event->status = $request->get('status');
                $event->on_monthly_kind = $request->get('on_monthly_kind');
                
                
                
                
                
                
                'year_starting_teach' => "2006",
                'significant_teachers' => $this->faker->paragraph,
                'website' => $this->faker->url,
                'facebook' => "https://www.facebook.com/".$this->faker->word,
                'country_id' => $this->faker->numberBetween($min = 1, $max = 253),
            ];
            $response = $this->post('/events', $data);
        
    
        
        // Assert in the database i have the right values in the 
            $this->assertDatabaseHas('events', [
                'title' => 'Test event monthly kind 1'
                'repeat_type' => '3'
                'repeat_monthly_on' => 'sally@example.com'
                'on_monthly_kind' => 'sally@example.com'
            ]);
        
            $this->assertDatabaseHas('events', [
                'title' => 'Test event monthly kind 2'
                'repeat_type' => '3'
                'repeat_monthly_on' => 'sally@example.com'
                'on_monthly_kind' => 'sally@example.com'
            ]);
        
        
        
        
        //$event = new Event();
        //dd($this->decodeOnMonthlyKind("0|7"));
        //$this->assertSame("7th day of the month", $event->decodeOnMonthlyKind("0|7"));
        
        // Act
        $aa = $this->call('EventController@decodeOnMonthlyKind', 'GET');
        
        //$bb = $this->action('GET', 'EventController@decodeOnMonthlyKind');
        
        
        dd($aa);
        
        */
    }
}
