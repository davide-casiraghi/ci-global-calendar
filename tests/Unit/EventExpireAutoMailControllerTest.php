<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use DavideCasiraghi\LaravelEventsCalendar\Models\EventRepetition;
use DavideCasiraghi\LaravelEventsCalendar\Models\EventVenue;
use DavideCasiraghi\LaravelEventsCalendar\Models\Country;
use DavideCasiraghi\LaravelEventsCalendar\Models\Continent;
use DavideCasiraghi\LaravelEventsCalendar\Models\Event;
use DavideCasiraghi\LaravelEventsCalendar\Models\Region;
use App\Http\Controllers\EventExpireAutoMailController;
use Carbon\Carbon;


class EventExpireAutoMailControllerTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;  // empty the test DB

    /***************************************************************************/

    /**
     * Populate test DB with dummy data.
     */
    public function setUp(): void
    {
        parent::setUp();
        
        // Seeders - /database/seeds
        $this->seed();

        // Factories
        $this->withFactories(base_path('vendor/davide-casiraghi/laravel-events-calendar/database/factories'));
        $this->user = factory(\App\User::class)->create();
        $this->venue = factory(\DavideCasiraghi\LaravelEventsCalendar\Models\EventVenue::class)->create();
        $this->teachers = factory(\DavideCasiraghi\LaravelEventsCalendar\Models\Teacher::class, 3)->create();
        $this->organizers = factory(\DavideCasiraghi\LaravelEventsCalendar\Models\Organizer::class, 3)->create();
        $this->eventCategory = factory(\DavideCasiraghi\LaravelEventsCalendar\Models\EventCategory::class)->create(['id'=>'100']);
        
        // Event one week from now
        $this->event = factory(Event::class)->create([
            'venue_id'=> $this->venue->id,
            'category_id' => '1',
            //'repeat_until'=> '2020-02-24 00:00:00',
            'repeat_until'=> Carbon::now()->subDays(7)->toDateString(),
        ]);
        $this->eventRepetition = factory(EventRepetition::class)->create([
            'event_id'=> $this->event->id,
        ]);
        
        // Event tomorrow
        $this->event = factory(Event::class)->create([
            'venue_id'=> $this->venue->id,
            'category_id' => '1',
            'repeat_until'=> '2020-03-03 00:00:00',
        ]);
        $this->eventRepetition = factory(EventRepetition::class)->create([
            'event_id'=> $this->event->id,
            'start_repeat' => Carbon::now()->addDay()->toDateString(),
            'end_repeat' => Carbon::now()->addDays(2)->toDateString(),
        ]);
        
    }

    /***************************************************************************/

    /**
     * Test that logged user can see continents index view.
     */
    /*public function test_check_event_expire()
    {
        $continent = factory(Continent::class)->create(['name' => 'Europe']);
        $country = factory(Country::class)->create(['name' => 'Italy', 'continent_id' => $continent->id]);
        $region = factory(Region::class)->create(['name' => 'Lombardy', 'country_id' => $country->id]);

        // we need a venue with an event, because the dropdown shows just the active countries
        $eventVenue = factory(EventVenue::class)->create(['country_id' => $country->id, 'region_id' => $region->id]);
        $this->authenticate();
        $eventAttributes = factory(Event::class)->raw([
            'title'=>'event test title',
            'venue_id' => $eventVenue->id,
        ]);
        $response = $this->post('/events', $eventAttributes);
        
        
    }*/
    
    /**
     * Test that it gets the expiring events list (expires at the 7th day from now)
     */
    public function test_it_gets_expiring_events_list()
    {        
        $activeEvents = Event::getActiveEvents();
        $expiringEventsList = EventExpireAutoMailController::getExpiringRepetitiveEventsList($activeEvents);
        
        dd($expiringEventsList);
    }
    
    

}
