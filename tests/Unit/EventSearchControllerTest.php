<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EventSearchControllerTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase; // empty the test DB

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
        $this->eventCategory = factory(\DavideCasiraghi\LaravelEventsCalendar\Models\EventCategory::class)->create(['id' => '100']);
        $this->event = factory(\DavideCasiraghi\LaravelEventsCalendar\Models\Event::class)->create([
            'category_id' => '100',
            'venue_id' => $this->venue->id,
        ]);
    }

    /***************************************************************************/

    /**
     * Test that the general sitemap is reachable.
     */
    public function test_the_italian_events_listed_by_country_are_accessible()
    {
        // Access to the page
        $response = $this->get('/eventSearch/country/IT')
                             ->assertStatus(200);
    }
}
