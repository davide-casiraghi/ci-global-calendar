<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

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
        $this->teacher = factory(\App\Statistic::class)->create();
    }

    /***************************************************************************/

    /**
     * Test that logged admin can SEE the statistics
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
