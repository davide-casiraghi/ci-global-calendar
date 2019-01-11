<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

use App\Post;
use App\PostTranslation;

class PluginTest extends DuskTestCase
{
    use DatabaseMigrations;
    
    /***************************************************************************/
    /**
     * Populate test DB with seeds and dummy data 
     */
    public function setUp(){
        Parent::setUp();
        
        // Seeders - /database/seeds (continetns, countries, post categories, event categories)
            $this->seed(); 
            
        // Factories - /database/factories
            $this->post = factory(\App\Post::class)->create([
                'body' => "
                            {slider=This is a test accordion} lorem ipsum {/slider}<br />
                            {# stats_donate coding_hours=[2400] pm_hours=[40] steering_commitee_meetings=[60] languages_number=[8] #}
                ",
            ]);
            
            $this->postTranslation = factory(\App\PostTranslation::class)->create([
                'post_id' => $this->post->id,
                'locale' => 'it'
            ]);
    }
    
    /***************************************************************************/
    /**
     * Test if the accordion is rendered
     *
     * @return void
     */
    public function testAccordion()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/post/'.$this->post->slug)
                ->assertPresent('.ui-accordion');
        });
    }
    
    /***************************************************************************/
    /**
     * Test if the statistics are rendered
     *
     * @return void
     */
    public function testStatistics()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/post/'.$this->post->slug)
                ->assertPresent('.statisticsDonate');
        });
    }
    
    
    
}
