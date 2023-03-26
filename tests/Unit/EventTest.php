<?php

namespace Tests\Unit;

use DavideCasiraghi\LaravelEventsCalendar\Models\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class EventTest extends TestCase
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
        $this->event = factory(Event::class)->create([
            'category_id'=>'100',
            'venue_id'=> $this->venue->id,
        ]);
    }

    /***************************************************************************/

    /**
     * Test that logged user can see events index view.
     */
    public function test_logged_user_can_see_events_index()
    {
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
     * The html contain a select dropdown that change every time that start date is changed in the event create and edit view.
     */
    public function test_decode_on_monthly_kind_function()
    {
        // Authenticate the user
        $this->authenticate();

        // Access to the page
        $response = $this->get('event/monthSelectOptions?day=10/01/2019')
                 ->assertStatus(200);

        // Assert the value is the one aspected
        $codeToCompare = "<select name='on_monthly_kind' id='on_monthly_kind' class='selectpicker' title='Select start date first'><option value='0|10'>the 10th day of the month</option><option value='1|2|4'>the 2nd Thursday of the month</option><option value='2|21'>the 22nd to last day of the month</option><option value='3|3|4'>the 4th to last Thursday of the month</option></select>";
        $this->assertSame($response->original, $codeToCompare);
    }

    /***************************************************************************/

    /**
     * Test that the logged user can create an event.
     */
    public function test_a_logged_user_can_create_event()
    {
        // Authenticate the user
        $this->authenticate();

        // Get the IDs of the 3 Teachers generated with the database factory, eg (3, 4, 5)
        $teachers_id = '';
        $i = 0;
        $len = count($this->teachers);
        foreach ($this->teachers as $key => $teacher) {
            $teachers_id .= $teacher->id;
            if ($i != $len - 1) {  // not last
                $teachers_id .= ',';
            }
            $i++;
        }

        // Post datas to create event (we don't include created_by and slug becayse are generated by the store method )
        $title = $this->faker->sentence($nbWords = 3);
        $data = [
            'title' => $title,
            'category_id' => '100',
            'description' => $this->faker->paragraph,
            'created_by' => $this->user->id,
            'slug' => Str::slug($title, '-').rand(100000, 1000000),
            'multiple_teachers' => $teachers_id,
            'multiple_organizers' => '1,2',
            'venue_id' => $this->venue->id,
            'startDate' => '10/12/2019',
            'endDate' => '12/12/2019',
            'time_start' => '6:00 PM',
            'time_end' => '8:00 PM',
            'repeat_type' => '1',
            'facebook_event_link' => 'https://www.facebook.com/'.$this->faker->word,
            'website_event_link' => $this->faker->url,
        ];

        //$response = $this->followingRedirects()->post('/events', $data)->dump();
        $response = $this->followingRedirects()->post('/events', $data);

        // Assert in database
        $this->assertDatabaseHas('events', ['title' => $title]);

        $response
                ->assertStatus(200)
                ->assertSee(__('laravel-events-calendar::messages.event_added_successfully'));
    }

    /***************************************************************************/

    /**
     * Test that guest user can send a misuse report.
     */
    public function test_a_guest_user_can_send_misuse_report()
    {
        // Post a data to create teacher (I dont' post created_by and slub becayse are generated by the store method )
        $data = [
            'reason' => 1,
            'message' => $this->faker->paragraph,
            'event_title' => $this->faker->sentence($nbWords = 3),
            'event_id' => 3,
            'created_by' => $this->user->id,
        ];
        $response = $this
                        ->followingRedirects()
                        ->post('/misuse', $data);
        // Status
        $response
                    ->assertStatus(200)
                    ->assertSee('Report sent');
    }

    /***************************************************************************/

    /**
     * Test that guest user can send email to all the event organizers.
     */
    public function test_a_guest_user_can_send_mail_for_event_info()
    {
        // Post a data to create teacher (I dont' post created_by and slub becayse are generated by the store method )
        $data = [
            'user_name' => $this->user->name,
            'user_email' => $this->user->email,
            'message' => $this->faker->paragraph,
            'event_title' => $this->faker->sentence($nbWords = 3),
            'event_id' => $this->event->id,
            'contact_email' =>  $this->faker->email(),
        ];
        $response = $this
                        ->followingRedirects()
                        ->post('/mailToOrganizer', $data);

        //dd($response); // I have to create the event factory
        // Status
        $response
                    ->assertStatus(200)
                    ->assertSee('Message sent to the organizers');
    }
}
