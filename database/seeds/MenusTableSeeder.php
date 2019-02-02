<?php

use Illuminate\Database\Seeder;

class MenusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $menus = array(
           array('id' => '1','name' => 'Main menu'),
       );
       
       foreach($menus as $key => $menu) {
           DB::table('menus')->insert([
               'id' => $menu['id'],
               'name' => $menu['name'],
           ]);
       }
    }
}
