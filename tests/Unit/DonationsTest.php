<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DonationsTest extends TestCase
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
     * Test that logged user can see continents index view.
     */
    public function test_logged_user_can_see_donations()
    {
        // Authenticate the admin
        $this->authenticateAsAdmin();

        // Access to the page
        $response = $this->get('/donationOffers/create')
                ->assertStatus(200);
    }
}
