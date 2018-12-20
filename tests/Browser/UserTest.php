<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

use Illuminate\Support\Facades\Hash;

use App\User;

class UserTest extends DuskTestCase{
    
    use DatabaseMigrations;

    public function setUp(){
        Parent::setUp();
        
        // Seeders - /database/seeds
            $this->seed(); 
        
        // Factories - /database/factories
            $this->user = factory(\App\User::class)->create();
            $this->venue = factory(\App\EventVenue::class)->create();
            $this->teachers = factory(\App\Teacher::class,3)->create();
            $this->organizers = factory(\App\Organizer::class,3)->create();
    }
    
    
    
    
    public function test_user_login(){
        //$user = factory(User::class)->create();
        $user = factory(User::class)->create([
            'password' => Hash::make('sdfas3rt'),  // Save the encrypted - bcrypt($password)
            //'password' => Hash::make('testPassword'), 
        ]);
        

        //$this->attributes['password'] = bcrypt($password);

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
