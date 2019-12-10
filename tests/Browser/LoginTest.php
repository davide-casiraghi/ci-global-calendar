<?php

namespace Tests\Browser;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{
    use DatabaseMigrations;

    /***************************************************************************/

    /**
     * Populate test DB with seeds and dummy data.
     */
    public function setUp(): void
    {
        parent::setUp();

        // Seeders - /database/seeds (continetns, countries, post categories, event categories)
        $this->seed();

        // Factories - /database/factories
        $this->user = factory(\App\User::class)->create();
    }

    /***************************************************************************/

    /**
     * Verify if the user can login.
     *
     * @return void
     */
    public function test_user_can_login()
    {
        if (! User::where('email', '=', 'super_adminuser@dusk.com')->exists()) {
            $user = factory(User::class)->create([
                    'email' => 'super_adminuser@dusk.com',
                    'password' => \Hash::make('gr4TWgr4W'),  // Save the encrypted - bcrypt($password)
                    'group' => 1,
                ]);
        }

        $this->browse(function ($browser) {
            $browser->visit('/login')
            ->type('email', 'super_adminuser@dusk.com')
            ->type('password', 'gr4TWgr4W')
                    ->press('Login')
                    ->assertPathIs('/');
        });
    }
}
