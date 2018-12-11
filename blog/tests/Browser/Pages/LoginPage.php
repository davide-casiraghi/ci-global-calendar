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
        
        // Create the test user if it doesn't exist 
            if (!User::where('email', '=', "testuser@dusk.com")->exists()) {
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
}
