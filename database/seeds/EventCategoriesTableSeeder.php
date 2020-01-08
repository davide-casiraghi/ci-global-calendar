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
        $event_categories = [
            ['id' => '1', 'name' => 'Regular Jam', 'slug' => ''],
            ['id' => '2', 'name' => 'Class', 'slug' => ''],
            ['id' => '3', 'name' => 'Workshop', 'slug' => ''],
            ['id' => '6', 'name' => 'Festival', 'slug' => ''],
            ['id' => '10', 'name' => 'Special Jam', 'slug' => ''],
            ['id' => '11', 'name' => 'Underscore', 'slug' => ''],
            ['id' => '12', 'name' => 'Teachers Meeting', 'slug' => ''],
            ['id' => '13', 'name' => 'Performance', 'slug' => ''],
            ['id' => '14', 'name' => 'Lecture / Conference / Film', 'slug' => ''],
            ['id' => '15', 'name' => 'Lab', 'slug' => ''],
            ['id' => '16', 'name' => 'Camp / Journey', 'slug' => ''],
            ['id' => '17', 'name' => 'Other event', 'slug' => ''],
        ];

        foreach ($event_categories as $key => $event_category) {
            DB::table('event_categories')->insert([
                'id' => $event_category['id'],
                'name' => $event_category['name'],
            ]);
        }
    }
}
