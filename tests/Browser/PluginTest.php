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
    public function setUp(): void{
        Parent::setUp();
        
        // Seeders - /database/seeds (continetns, countries, post categories, event categories)
            $this->seed(); 
            
        // Factories - /database/factories
            $this->post = factory(\App\Post::class)->create();
            $this->post = factory(\App\Post::class)->create([
                'body' => "
                            {slider=This is a test accordion} lorem ipsum {/slider}<br />
                            {# stats_donate coding_hours=[2400] pm_hours=[40] steering_commitee_meetings=[60] languages_number=[8] #}
                            {# columns category_id=[2] show_images=[0] round_images=[0] show_category_title=[1] #}
                            {# card post_id=[1] img_alignment=[right] img_col_size=[3] bkg_color=[#004400] text_color=[#212529] container_wrap=[false] #}
                            {# gallery src=[test_gallery] width=[400] height=[300] #}
                ",
            ]);
            
            $this->postTranslation = factory(\App\PostTranslation::class)->create([
                'post_id' => $this->post->id,
                'locale' => 'it'
            ]);
    }
    
    /***************************************************************************/
    /**
     * Test if the Accordion is rendered
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
     * Test if the Statistics are rendered
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
    
    /***************************************************************************/
    /**
     * Test if the Column plugin is rendered
     *
     * @return void
     */
    public function testColumns()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/post/'.$this->post->slug)
                ->assertPresent('.column-title');
        });
    }
    
    /***************************************************************************/
    /**
     * Test if the Card plugin is rendered
     *
     * @return void
     */
    public function testCard()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/post/'.$this->post->slug)
                ->assertPresent('.featurette');
        });
    }
    
    /***************************************************************************/
    /**
     * Test if the Gallery plugin is rendered
     *
     * @return void
     */
    public function testGallery()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/post/'.$this->post->slug)
                ->assertSee("Image directory not found");
        });
    }    
    
    
}
