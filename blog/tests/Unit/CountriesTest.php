<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Teacher;
use App\User;


class CountriesTest extends TestCase
{
    use WithFaker;
    
    /*
        If this test fail run the seeders for countries and continents
        - php artisan db:seed --class=CountriesTableSeeder --env=testing
        - php artisan db:seed --class=ContinentsTableSeeder --env=testing
    */
    public function test_logged_user_can_see_countries(){
        // Authenticate the user
            $this->authenticate();
        
        // Access to the page
            $response = $this->get('/countries')
                ->assertStatus(200);    
    }
    
    
}
