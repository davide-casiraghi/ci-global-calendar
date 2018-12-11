<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;
use App\User;

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

    public function loginUser(Browser $browser){
        //$browser->loginAs(User::where('email','hettie.greenholt@kertzmann.com')->firstOrFail());
        $browser->loginAs(User::find(1));
    }
}
