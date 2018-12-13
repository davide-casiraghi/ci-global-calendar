<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;


class ContinentsTest extends TestCase
{
    use WithFaker;
    
    /*
        If this test fail run the seeders for countries and continents
        - php artisan db:seed --class=CountriesTableSeeder --env=testing
        - php artisan db:seed --class=ContinentsTableSeeder --env=testing
    */
    public function test_logged_user_can_see_continents(){
        // Authenticate the user
            $this->authenticate();
        
        // Access to the page
            $response = $this->get('/continents')
                ->assertStatus(200);    
    }
    
    
}
