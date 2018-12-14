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

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = array(
            array('id' => '1','name' => 'Uncategorized','slug' => 'uncategorized'),
            array('id' => '2','name' => 'Global Calendar contents','slug' => 'global-calendar-contents'),
            array('id' => '3','name' => 'News','slug' => 'news'),
        );
        
        foreach($categories as $key => $category) {
            DB::table('categories')->insert([
                'id' => $category['id'],
                'name' => $category['name'],
                'slug' => $category['slug'],
            ]);
        }
    }
}
