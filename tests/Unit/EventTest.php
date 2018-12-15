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
        
        /*
        // Refresh db
        
        // Populate with dummy data
        
        // Post new events with different of monthly kind occurances
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
        
        
        dd($aa);*/
    }
}
