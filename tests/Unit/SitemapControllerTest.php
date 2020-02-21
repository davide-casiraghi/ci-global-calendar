<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SitemapControllerTest extends TestCase
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
        $this->eventCategory = factory(\DavideCasiraghi\LaravelEventsCalendar\Models\EventCategory::class)->create(['id'=>'100']);
        $this->event = factory(\DavideCasiraghi\LaravelEventsCalendar\Models\Event::class)->create([
            'category_id'=>'100',
            'venue_id'=> $this->venue->id,
        ]);
    }

    /***************************************************************************/

    /**
     * Test that the general sitemap is reachable
     */
    public function test_the_general_sitemap_is_accessible()
    {
        // Access to the page
        $response = $this->get('/sitemap')
                             ->assertStatus(200);
    }

    /**
     * Test that the sitemap of the events is reachable
     */
    public function test_the_events_sitemap_is_accessible()
    {
        // Access to the page
        $response = $this->get('/sitemap/events')
                             ->assertStatus(200);
    }
    
    /**
     * Test that the sitemap of the posts is reachable
     */
    public function test_the_posts_sitemap_is_accessible()
    {
        // Access to the page
        $response = $this->get('/sitemap/posts')
                             ->assertStatus(200);
    }
    
    /**
     * Test that the sitemap of the teachers is reachable
     */
    public function test_the_teachers_sitemap_is_accessible()
    {
        // Access to the page
        $response = $this->get('/sitemap/teachers')
                             ->assertStatus(200);
    }
}
