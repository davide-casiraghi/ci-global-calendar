<?php

use Illuminate\Database\Seeder;

class MenuItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $menuItems = array(
           array('id' => '1','name' => 'Main menu'),
       );
       
       foreach($menuItems as $key => $menuItem) {
           DB::table('menu_item')->insert([
               'id' => $menuItem['id'],
               'name' => $menuItem['name'],
               'compact_name' => $menuItem['compact_name'],
               'parent_item' => $menuItem['parent_item'],
               'url' => $menuItem['url'],
               'font_awesome_class' => $menuItem['font_awesome_class'],
           ]);
       }
    }
}
