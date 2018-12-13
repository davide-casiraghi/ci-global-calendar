<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ExampleTest extends DuskTestCase
{
    /**
     * A basic browser test example.
     *
     * @return void
     */
    public function test_access_homepage()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->assertSee('Contact Improvisation');
        });
    }
}
