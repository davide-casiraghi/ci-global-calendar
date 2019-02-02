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
           array('id' => '1',
                    'name' => 'Home',
                    'menu_id' => '1',
                    'order' => '0',
                    'compact_name' => 'home',
                    'type' => '0',
                    'lang_string' => 'menu.home',
                    'parent_item' => '',
                    'url' => '/',
                    'route' => '',
                    'font_awesome_class' => 'fa fa-home'
                ),
           
           
       );
       
       foreach($menuItems as $key => $menuItem) {
           DB::table('menu_item')->insert([
               'id' => $menuItem['id'],
               'name' => $menuItem['name'],
               'compact_name' => $menuItem['compact_name'],
               'type' => $menuItem['type'],
               'parent_item' => $menuItem['parent_item'],
               'url' => $menuItem['url'],
               'route' => $menuItem['route'],
               'font_awesome_class' => $menuItem['font_awesome_class'],
           ]);
       }
    }
}
