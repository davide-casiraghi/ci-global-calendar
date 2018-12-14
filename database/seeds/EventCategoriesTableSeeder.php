<?php

use Illuminate\Database\Seeder;

/*
|--------------------------------------------------------------------------
| Seeders
|--------------------------------------------------------------------------
|
| Seders are used to generate datas to populate the database of the test environment.
|
*/

class EventCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $event_categories = array(
           array('id' => '1','name' => 'Regular Jam','slug' => ''),
           array('id' => '2','name' => 'Class','slug' => ''),
           array('id' => '3','name' => 'Workshop','slug' => ''),
           array('id' => '6','name' => 'Festival','slug' => ''),
           array('id' => '10','name' => 'Special Jam','slug' => ''),
           array('id' => '11','name' => 'Underscore','slug' => ''),
           array('id' => '12','name' => 'Teachers Meeting','slug' => ''),
           array('id' => '13','name' => 'Performance','slug' => ''),
           array('id' => '14','name' => 'Lecture / Conference / Film','slug' => ''),
           array('id' => '15','name' => 'Lab','slug' => ''),
           array('id' => '16','name' => 'Camp / Journey','slug' => ''),
           array('id' => '17','name' => 'Other event','slug' => '')
       );
       
       foreach($event_categories as $key => $event_category) {
           DB::table('event_categories')->insert([
               'id' => $event_category['id'],
               'name' => $event_category['name'],
           ]);
       }
    }
}
