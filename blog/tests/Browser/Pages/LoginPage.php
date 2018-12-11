<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;
use App\User;
use Illuminate\Support\Facades\Hash;

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
        
        $user = factory(User::class)->create([
            'password' => Hash::make('sdfas3rt'),  // Save the encrypted - bcrypt($password)
        ]);
        
        $browser->visit('/login')
                ->type('email', $user->email)
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
}
