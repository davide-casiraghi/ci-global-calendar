<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StatisticTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase; // empty the test DB

    /***************************************************************************/

    /**
     * Populate test DB with dummy data.
     */
    public function setUp(): void
    {
        parent::setUp();

        // Seeders - /database/seeds
        $this->seed();

        // Factories - /database/factories
        $this->statistic = factory(\App\Statistic::class, 50)->create();
    }

    /***************************************************************************/

    /**
     * Test that logged admin can SEE the statistics.
     */
    public function test_a_logged_admin_can_see_statistics_index()
    {
        // Authenticate the admin
        $this->authenticateAsAdmin();

        // Access to the page
        $response = $this->get('/statistics')
                             ->assertStatus(200);
    }
}
