<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CountriesTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;  // empty the test DB

    /***************************************************************************/

    /**
     * Populate test DB with dummy data.
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    /***************************************************************************/

    /**
     * Test that logged user can see countries index view.
     */
    public function test_logged_user_can_see_countries()
    {
        // Authenticate the admin
        $this->authenticateAsAdmin();

        // Access to the page
        $response = $this->get('/countries')
                ->assertStatus(200);
    }
}
