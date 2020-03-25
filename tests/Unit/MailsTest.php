<?php

namespace Tests\Unit;

use App\Mail\ContactForm;
use App\Mail\UserActivationConfirmation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

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

        // Factories
        $this->withFactories(base_path('vendor/davide-casiraghi/laravel-events-calendar/database/factories'));
        $this->user1 = factory(\App\User::class)->create();
        $this->user2 = factory(\App\User::class)->create();

        $this->post = factory(\App\Post::class)->create([
            'id' => 53,
            'body' => 'If you are a teacher and/or an event organizer, after your registration is approved you need to log in and to create your teachers or organizer profile.
                                Then you can post your events.
                                You can check out the help section here for more details: https://ciglobalcalendar.net/fr/post/help-how-to-insert-contents

                                If you need extra support please write to: admin@ciglobalcalendar.net

                                Thank you for join the Global CI Calendar.
                                CI Global Calendar',
        ]);

        //$this->venue = factory(EventVenue::class)->create();
                //$this->teachers = factory(Teacher::class, 3)->create();
                //$this->organizers = factory(Organizer::class, 3)->create();
                //$this->eventCategory = factory(EventCategory::class)->create(['id'=>'100']);
/*
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
     * Test that it sends emails to expiring events organizers.
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

    /**
     * test_it_sends_activation_confirmation_to_user_after_admin_activate_from_backend.
     */
    public function test_it_sends_activation_confirmation_to_user_after_admin_activate_from_backend()
    {
        Mail::fake();

        // Assert that no mailables were sent...
        Mail::assertNothingSent();

        //dd($this->user1);

        //dd($this->post->body);

        // Send emails when the admin click on activate user link in the backend
        $response = $this
            ->followingRedirects()
            ->get('/activate-user-from-backend/'.$this->user1->id);

        // Assert a mailable was sent
        Mail::assertSent(UserActivationConfirmation::class, 1);

        // Assert that the first message contain the right From and To
        //dump($user_email);
        $user_email = $this->user1->email;
        Mail::assertSent(UserActivationConfirmation::class, function ($mail) use ($user_email) {
            $mail->build();
            //dd($mail->get('mailDatas')); //aaaaaaaaaaaa
            $this->assertEquals('Activation of your Global CI account', $mail->subject);
            //$this->assertContains('If you are a teacher', $mail->body);

            return $mail->hasFrom('noreply@globalcalendar.com') &&
                   $mail->hasTo($user_email);
        });
    }

    /***************************************************************************/

    /**
     * test_it_sends_activation_confirmation_to_user_after_admin_click_mail_activation_link.
     */
    public function test_it_sends_activation_confirmation_to_user_after_admin_click_mail_activation_link()
    {
        Mail::fake();

        // Assert that no mailables were sent...
        Mail::assertNothingSent();

        //dd($this->user1->activation_code);

        // Send emails when the admin click on activate user link in the backend
        $response = $this
            ->followingRedirects()
            ->get('/verify-user/'.$this->user1->activation_code);

        // Assert a mailable was sent
        Mail::assertSent(UserActivationConfirmation::class, 1);

        // Assert that the first message contain the right From and To
        //dump($user_email);
        $user_email = $this->user1->email;
        Mail::assertSent(UserActivationConfirmation::class, function ($mail) use ($user_email) {
            $mail->build();
            //dump($mail);
            $this->assertEquals('Activation of your Global CI account', $mail->subject);

            return $mail->hasFrom('noreply@globalcalendar.com') &&
                   $mail->hasTo($user_email);
        });
    }
}
