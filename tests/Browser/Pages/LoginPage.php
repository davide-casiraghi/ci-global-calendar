<?php

namespace Tests\Browser\Pages;

use App\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Dusk\Browser;

class LoginPage extends Page
{
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/login';
    }

    /**
     * Assert that the browser is on the page.
     *
     * @param  Browser  $browser
     * @return void
     */
    public function assert(Browser $browser)
    {
        //
    }

    /**
     * Login as an author user.
     *
     * @return void
     */
    public function loginUser(Browser $browser)
    {

        // Create the test user if it doesn't exist
        if (! User::where('email', '=', 'testuser@dusk.com')->exists()) {
            $user = factory(User::class)->create([
                    'email' => 'testuser@dusk.com',
                    'password' => Hash::make('sdfas3rt'),  // Save the encrypted - bcrypt($password)
                ]);
        }

        // Login trough the login page with the test user
        $browser->visit('/login')
                    ->type('email', 'testuser@dusk.com')
                    ->type('password', 'sdfas3rt')
                    ->press('Login');

        /*
        This should work but it doesn't
        $browser->loginAs($user);
        or
        $browser->loginAs(User::find(91));
        or
        $browser->loginAs(User::where('email','hoeger.jerry@example.net')->firstOrFail());
        */
    }

    /**
     * Login as a super administrator.
     *
     * @return void
     */
    public function loginSuperAdministrator(Browser $browser)
    {

        // Create the test user if it doesn't exist
        if (! User::where('email', '=', 'super_adminuser@dusk.com')->exists()) {
            $user = factory(User::class)->create([
                    'email' => 'super_adminuser@dusk.com',
                    'password' => Hash::make('gr4TWgr4W'),  // Save the encrypted - bcrypt($password)
                    'group' => 1,
                ]);
        }

        // Login trough the login page with the test user
        $browser->visit('/login')
                    ->type('email', 'super_adminuser@dusk.com')
                    ->type('password', 'gr4TWgr4W')
                    ->press('Login');
    }

    /**
     * Login as an administrator.
     *
     * @return void
     */
    public function loginAdministrator(Browser $browser)
    {

        // Create the test user if it doesn't exist
        if (! User::where('email', '=', 'adminuser@dusk.com')->exists()) {
            $user = factory(User::class)->create([
                    'email' => 'adminuser@dusk.com',
                    'password' => Hash::make('rw52Tdfd63g'),  // Save the encrypted - bcrypt($password)
                    'group' => 2,
                ]);
        }

        // Login trough the login page with the test user
        $browser->visit('/login')
                    ->type('email', 'adminuser@dusk.com')
                    ->type('password', 'rw52Tdfd63g')
                    ->press('Login');
    }

    /**
     * Logout user.
     *
     * @return void
     */
    public function logoutUser(Browser $browser)
    {

        //$browser->logout(); // this does't work  - still to get why..
        $browser->visit('/_dusk/logout/'); // so we do that the method logout does
    }
}
