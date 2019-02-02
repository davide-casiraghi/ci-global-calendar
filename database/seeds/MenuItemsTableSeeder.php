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
           array('id' => '1','name' => 'Home','compact_name' => 'home','lang_string' => 'menu.home','parent_item' => '','url' => '/','font_awesome_class' => 'fa fa-home'),
           array('id' => '2','name' => 'About','compact_name' => 'about','lang_string' => 'menu.about','parent_item' => '','url' => '/post/about','font_awesome_class' => 'fa fa-info-circle'),
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
