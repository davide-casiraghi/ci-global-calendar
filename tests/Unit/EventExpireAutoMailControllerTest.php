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
use DavideCasiraghi\LaravelEventsCalendar\Models\Teacher;
use DavideCasiraghi\LaravelEventsCalendar\Models\Organizer;
use DavideCasiraghi\LaravelEventsCalendar\Models\EventCategory;

use Illuminate\Support\Facades\Mail;

use App\Http\Controllers\EventExpireAutoMailController;
use App\Mail\ContactForm;
use App\Mail\ExpiringEvent;
use App\User;
//use App\Notifications\UserRegisteredSuccessfully;
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
        $this->user1 = factory(\App\User::class)->create();
        $this->user2 = factory(\App\User::class)->create();
        $this->venue = factory(EventVenue::class)->create();
        $this->teachers = factory(Teacher::class, 3)->create();
        $this->organizers = factory(Organizer::class, 3)->create();
        $this->eventCategory = factory(EventCategory::class)->create(['id'=>'100']);
        
        // Event one week from now
        $this->event1 = factory(Event::class)->create([
            'created_by' => $this->user1->id,
            'title' => 'event expiring in one week',
            'venue_id'=> $this->venue->id,
            'category_id' => '1',
            //'repeat_until'=> '2020-02-24 00:00:00',
            'repeat_until'=> Carbon::now()->addDays(6)->toDateString(),
        ]);
        $this->eventRepetition1 = factory(EventRepetition::class)->create([
            'event_id'=> $this->event1->id,
        ]);
        
        // Event tomorrow
        $this->event2 = factory(Event::class)->create([
            'created_by' => $this->user2->id,
            'title' => 'event tomorrow',
            'venue_id'=> $this->venue->id,
            'category_id' => '1',
            'repeat_until'=> Carbon::now()->addDay(2)->toDateString(),
        ]);
        $this->eventRepetition2 = factory(EventRepetition::class)->create([
            'event_id'=> $this->event2->id,
            'start_repeat' => Carbon::now()->addDay()->toDateString(),
            'end_repeat' => Carbon::now()->addDay()->addHour()->toDateString(),
        ]);
    }

    /***************************************************************************/
    
    /**
     * Test that it gets the expiring events list (expires at the 7th day from now)
     */
    public function test_it_gets_expiring_events_list()
    {        
        $activeEvents = Event::getActiveEvents();
        $expiringEventsList = EventExpireAutoMailController::getExpiringRepetitiveEventsList($activeEvents);
        
        $this->assertSame(count($expiringEventsList), 1);
        $this->assertSame($expiringEventsList[0]['title'], 'event expiring in one week');
    }
    
    /***************************************************************************/
    
    /**
     * Test that it gets the expiring events list (expires at the 7th day from now)
     */
    public function test_it_gets_expiring_events_title_and_user()
    {   
        $expiringEvents = [];
    
        $expiringEvents[] = [
            "title" => "event expiring in one week",
            "country_name" => "Italy",
            "country_id" => 1,
            "continent_id" => 6,
            "city" => "South Elenor",
            "repeat_until" => "2020-03-06 00:00:00",
            "category_id" => 1,
            "created_by" => $this->user1->id,
        ];

        $expiringEvents[] = [
            "title" => "event tomorrow",
            "country_name" => "Italy",
            "country_id" => 1,
            "continent_id" => 6,
            "city" => "South Elenor",
            "repeat_until" => "2020-03-02 00:00:00",
            "category_id" => 1,
            "created_by" => $this->user2->id,
        ];
        
        $expiringEventsTitleAndUser = EventExpireAutoMailController::getExpiringEventsTitleAndUser($expiringEvents);
        
        $this->assertSame($expiringEventsTitleAndUser[0]['user_name'],$this->user1['name']);
        $this->assertSame($expiringEventsTitleAndUser[0]['user_email'],$this->user1['email']);
        $this->assertSame($expiringEventsTitleAndUser[0]['event_title'],$expiringEvents[0]['title']);
        
        $this->assertSame($expiringEventsTitleAndUser[1]['user_name'],$this->user2['name']);
        $this->assertSame($expiringEventsTitleAndUser[1]['user_email'],$this->user2['email']);
        $this->assertSame($expiringEventsTitleAndUser[1]['event_title'],$expiringEvents[1]['title']);
    }
        
    /***************************************************************************/
    
    /**
     * Test that it sends emails to expiring events organizers
     */
    public function test_it_send_email_to_expiring_events_organizers()
    {
        Mail::fake();

        // Assert that no mailables were sent...
        Mail::assertNothingSent();
        
        // Send emails to expiring events organizers
        $activeEvents = Event::getActiveEvents();
        $expiringEventsList = EventExpireAutoMailController::sendEmailToExpiringEventsOrganizers($activeEvents);
        
        // Assert a mailable was sent twice
        Mail::assertSent(ExpiringEvent::class, 2);

        // Assert that the first message contain the right From and To
        $user = $this->user1;
        Mail::assertSent(ExpiringEvent::class, function ($mail) use ($user) {
            $mail->build();
            //dd($mail);
            $this->assertEquals('CI Global Calendar Administrator', $mail->subject);
            
            return $mail->hasFrom(env('ADMIN_MAIL')) &&
                   $mail->hasReplyTo(env('ADMIN_MAIL')) &&
                   $mail->hasTo($user->email);
        });
    }
    
    /***************************************************************************/
    
    /**
     * Test that it sends emails to expiring events organizers
     */
    /*public function test_it_check_if_finds_expiring_events()
    {
        $message = EventExpireAutoMailController::check();
        dd($message);
    }*/
}
