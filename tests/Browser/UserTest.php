<?php

namespace Tests\Browser;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Hash;
use Tests\DuskTestCase;

class UserTest extends DuskTestCase
{
    use DatabaseMigrations;

    /***************************************************************************/

    /**
     * Verify that a user can register and login.
     *
     * @return void
     */
    public function test_user_login()
    {
        $user = factory(User::class)->create([
            'password' => Hash::make('sdfas3rt'),  // Save the encrypted - bcrypt($password)
        ]);

        $this->browse(function ($browser) use ($user) {
            $browser->visit('/login')
                    ->type('email', $user->email)
                    ->type('password', 'sdfas3rt')
                    ->press('Login')
                    ->assertPathIs('/');
            //->dump();
        });
    }
}
