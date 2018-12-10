<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Teacher;

//use Database\Migrations;


class TeacherTest extends TestCase
{
    use WithFaker;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
         
        $data = [
            'name' => $this->faker->name,
            'bio' => $this->faker->paragraph,
            'year_starting_practice' => "2000",
            'year_starting_teach' => "2006",
            'significant_teachers' => $this->faker->paragraph,
            'profile_picture' => str_random(10).".jpg",
            'website' => $this->faker->url,
            'facebook' => "https://www.facebook.com/".$this->faker->word,
            'created_by' => '2',
            'slug' => $this->faker->slug,
            'country_id' => $this->faker->numberBetween($min = 1, $max = 253),
        ];
        
        $response = $this->json('POST', '/teachers/store',$data);
        
        // assumption
        
        // call actual method to tests
        
        // test using assertions
        
        
        
        //$teacher = factory(Teacher::class)->make();
        
        $this->assertTrue(true);
    }
}
