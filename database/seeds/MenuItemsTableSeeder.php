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
                    'compact_name' => 'home',
                    'type' => '0',
                    'lang_string' => 'menu.home',
                    'parent_item' => '',
                    'url' => '/',
                    'route' => '',
                    'font_awesome_class' => 'fa fa-home'
                ),
           array('id' => '2',
                   'name' => 'About',
                   'compact_name' => 'about',
                   'type' => '0',
                   'lang_string' => 'menu.about',
                   'parent_item' => '',
                   'url' => '/post/about',
                   'route' => '',
                   'font_awesome_class' => 'fa fa-info-circle'
           ),
           array('id' => '3',
                   'name' => 'Terms of use',
                   'compact_name' => 'terms_of_use',
                   'type' => '0',
                   'lang_string' => 'menu.terms_of_use',
                   'parent_item' => '',
                   'url' => '/post/terms-of-use',
                   'route' => '',
                   'font_awesome_class' => 'far fa-file-alt'
           ),
           array('id' => '4',
                   'name' => 'Teachers directory',
                   'compact_name' => 'teachers_directory',
                   'type' => '1',
                   'lang_string' => 'menu.teachers_directory',
                   'parent_item' => '3',
                   'url' => '',
                   'route' => 'teachers.directory',
                   'font_awesome_class' => 'far fa-file-alt'
           ),
           array('id' => '5',
                   'name' => 'Get Involved',
                   'compact_name' => 'get_involved',
                   'type' => '0',
                   'lang_string' => 'menu.teachers_directory',
                   'parent_item' => '3',
                   'url' => '',
                   'route' => 'teachers.directory',
                   'font_awesome_class' => 'far fa-file-alt'
           ),
           array('id' => '6',
                   'name' => 'Help',
                   'compact_name' => 'help',
                   'type' => '0',
                   'lang_string' => 'menu.teachers_directory',
                   'parent_item' => '3',
                   'url' => '',
                   'route' => 'teachers.directory',
                   'font_awesome_class' => 'far fa-file-alt'
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
