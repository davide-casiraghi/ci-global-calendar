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
                'body' => "{slider=This is a test accordion} lorem ipsum {/slider}",
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
    
    
    
}
