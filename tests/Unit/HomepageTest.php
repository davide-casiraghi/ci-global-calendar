<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HomepageTest extends TestCase
{
    use WithFaker;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_guest_user_can_see_homepage()
    {
        

        // Access to the page
            $response = $this->get('/')
                             ->assertStatus(200);
    }
}
