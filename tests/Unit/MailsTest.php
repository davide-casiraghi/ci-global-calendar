<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use Illuminate\Support\Facades\Mail;
use App\Mail\ContactForm;


use App\User;


class MailsTest extends TestCase
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

/*
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
        */
    }
    
    
    /***************************************************************************/
    
    /**
     * Test that it sends emails to expiring events organizers
     */
    public function test_it_send_contact_form()
    {
        Mail::fake();

        // Assert that no mailables were sent...
        Mail::assertNothingSent();
        
        // Send emails to expiring events organizers
        $name = $this->faker->name;
        $random_number_1 = $this->faker->randomDigit;
        $random_number_2 = $this->faker->randomDigit;
        $recaptcha_sum = $random_number_1 + $random_number_2;
        $user_email = $this->faker->safeEmail;
        
        $data = [
            'recipient' => 'administrator',
            'name' => $name,
            'email' => $user_email,
            'message' => $this->faker->paragraph,
            'random_number_1' => $random_number_1,
            'random_number_2' => $random_number_2,
            'recaptcha_sum_1' => $recaptcha_sum,
        ];
        $response = $this
            ->followingRedirects()
            ->post('/contactForm/send', $data);
        
        // Assert a mailable was sent 
        Mail::assertSent(ContactForm::class, 1);

        // Assert that the first message contain the right From and To
        //dump($user_email);
        Mail::assertSent(ContactForm::class, function ($mail) use ($user_email) {
            $mail->build();
            //dump($mail);
            $this->assertEquals('Message from the contact form', $mail->subject);
            return $mail->hasFrom($user_email) &&
                   $mail->hasTo(env('ADMIN_MAIL'));
        });
    }
    
    /***************************************************************************/
    
}
