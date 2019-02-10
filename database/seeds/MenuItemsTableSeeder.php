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
                    'menu_id' => '1',
                    'order' => '1',
                    'access' => '1',
                    'type' => '2',
                    'lang_string' => 'menu.home',
                    'parent_item_id' => '0',
                    'url' => '/',
                    'route' => '',
                    'font_awesome_class' => 'fa fa-home',
                    'hide_name' => '0'
                ),
            array('id' => '2',
                     'name' => 'Manager',
                     'compact_name' => 'manager',
                     'menu_id' => '4',
                     'order' => '1',
                     'access' => '3',
                     'type' => '2',
                     'lang_string' => 'menu.manager',
                     'parent_item_id' => '0',
                     'url' => '#',
                     'route' => '',
                     'font_awesome_class' => 'fa fas fa-edit',
                     'hide_name' => '0'
                 ),
            array('id' => '3',
                    'name' => 'New Event',
                    'compact_name' => 'new-event',
                    'menu_id' => '4',
                    'order' => '1',
                    'access' => '3',
                    'type' => '1',
                    'lang_string' => 'menu.new_event',
                    'parent_item_id' => '2',
                    'url' => '',
                    'route' => 'events.create',
                    'font_awesome_class' => 'fa fas fa-plus-circle',
                    'hide_name' => '0'
                ),
            array('id' => '4',
                    'name' => 'My Events',
                    'compact_name' => 'my-events',
                    'menu_id' => '4',
                    'order' => '2',
                    'access' => '3',
                    'type' => '1',
                    'lang_string' => 'menu.my_events',
                    'parent_item_id' => '2',
                    'url' => '',
                    'route' => 'events.index',
                    'font_awesome_class' => 'far fa-calendar-alt',
                    'hide_name' => '0'
                ),
            array('id' => '5',
                    'name' => 'My Venues',
                    'compact_name' => 'my-venues',
                    'menu_id' => '4',
                    'order' => '3',
                    'access' => '3',
                    'type' => '1',
                    'lang_string' => 'menu.my_venues',
                    'parent_item_id' => '2',
                    'url' => '',
                    'route' => 'eventVenues.index',
                    'font_awesome_class' => 'far fa-map-marker-alt',
                    'hide_name' => '0'
                ),
            array('id' => '6',
                    'name' => 'My Teachers',
                    'compact_name' => 'my-teachers',
                    'menu_id' => '4',
                    'order' => '4',
                    'access' => '3',
                    'type' => '1',
                    'lang_string' => 'menu.my_teachers',
                    'parent_item_id' => '2',
                    'url' => '',
                    'route' => 'teachers.index',
                    'font_awesome_class' => 'far fa-users',
                    'hide_name' => '0'
                ),
            array('id' => '7',
                    'name' => 'My Organizers',
                    'compact_name' => 'my-organizers',
                    'menu_id' => '4',
                    'order' => '5',
                    'access' => '3',
                    'type' => '1',
                    'lang_string' => 'menu.my_organizers',
                    'parent_item_id' => '2',
                    'url' => '',
                    'route' => 'organizers.index',
                    'font_awesome_class' => 'fas fa-users',
                    'hide_name' => '0'
                ),
            array('id' => '8',
                    'name' => 'Admin Tools',
                    'compact_name' => 'admin-tools',
                    'menu_id' => '4',
                    'order' => '2',
                    'access' => '4',
                    'type' => '2',
                    'lang_string' => 'menu.admin_tools',
                    'parent_item_id' => '0',
                    'url' => '#',
                    'route' => '',
                    'font_awesome_class' => 'far fa-cog',
                    'hide_name' => '0'
                ),
            array('id' => '9',
                    'name' => 'Users',
                    'compact_name' => 'users',
                    'menu_id' => '4',
                    'order' => '1',
                    'access' => '4',
                    'type' => '1',
                    'lang_string' => 'menu.users',
                    'parent_item_id' => '8',
                    'url' => '',
                    'route' => 'users.index',
                    'font_awesome_class' => 'fas fa-user-alt',
                    'hide_name' => '0'
                ),
            array('id' => '10',
                    'name' => 'Articles',
                    'compact_name' => 'articles',
                    'menu_id' => '4',
                    'order' => '2',
                    'access' => '4',
                    'type' => '1',
                    'lang_string' => 'menu.posts',
                    'parent_item_id' => '8',
                    'url' => '',
                    'route' => 'posts.index',
                    'font_awesome_class' => 'far fa-file-alt',
                    'hide_name' => '0'
                ),
            array('id' => '11',
                    'name' => 'Events Categories',
                    'compact_name' => 'events-categories',
                    'menu_id' => '4',
                    'order' => '4',
                    'access' => '4',
                    'type' => '1',
                    'lang_string' => 'menu.event_categories',
                    'parent_item_id' => '8',
                    'url' => '',
                    'route' => 'eventCategories.index',
                    'font_awesome_class' => 'fas fa-tags',
                    'hide_name' => '0'
                ),
            array('id' => '12',
                    'name' => 'Background Images',
                    'compact_name' => 'background-images',
                    'menu_id' => '4',
                    'order' => '7',
                    'access' => '4',
                    'type' => '1',
                    'lang_string' => 'menu.background_images',
                    'parent_item_id' => '8',
                    'url' => '',
                    'route' => 'backgroundImages.index',
                    'font_awesome_class' => 'far fa-images',
                    'hide_name' => '0'
                ),
            array('id' => '13',
                    'name' => 'Settings',
                    'compact_name' => 'settings',
                    'menu_id' => '4',
                    'order' => '5',
                    'access' => '5',
                    'type' => '2',
                    'lang_string' => 'menu.settings',
                    'parent_item_id' => '0',
                    'url' => '#',
                    'route' => '',
                    'font_awesome_class' => 'fas fa-cog',
                    'hide_name' => '1'
                ),
            array('id' => '14',
                    'name' => 'Post Categories',
                    'compact_name' => 'post-categories',
                    'menu_id' => '4',
                    'order' => '3',
                    'access' => '4',
                    'type' => '1',
                    'lang_string' => 'menu.posts_categories',
                    'parent_item_id' => '13',
                    'url' => '',
                    'route' => 'categories.index',
                    'font_awesome_class' => 'far fa-tags',
                    'hide_name' => '0'
                ),
            array('id' => '15',
                    'name' => 'Continents',
                    'compact_name' => 'continents',
                    'menu_id' => '4',
                    'order' => '5',
                    'access' => '4',
                    'type' => '1',
                    'lang_string' => 'menu.continents',
                    'parent_item_id' => '13',
                    'url' => '',
                    'route' => 'continents.index',
                    'font_awesome_class' => 'fas fa-globe-americas',
                    'hide_name' => '0'
                ),
            array('id' => '16',
                    'name' => 'Countries',
                    'compact_name' => 'countries',
                    'menu_id' => '4',
                    'order' => '6',
                    'access' => '4',
                    'type' => '1',
                    'lang_string' => 'menu.countries',
                    'parent_item_id' => '13',
                    'url' => '',
                    'route' => 'countries.index',
                    'font_awesome_class' => 'far fa-globe-americas',
                    'hide_name' => '0'
                ),
            array('id' => '17',
                    'name' => 'Menus',
                    'compact_name' => 'menus',
                    'menu_id' => '4',
                    'order' => '8',
                    'access' => '4',
                    'type' => '1',
                    'lang_string' => 'menu.menus',
                    'parent_item_id' => '13',
                    'url' => '',
                    'route' => 'menus.index',
                    'font_awesome_class' => 'fas fa-caret-circle-down',
                    'hide_name' => '0'
                ),
            array('id' => '18',
                    'name' => 'User tools',
                    'compact_name' => 'user-tools',
                    'menu_id' => '4',
                    'order' => '6',
                    'access' => '3',
                    'type' => '2',
                    'lang_string' => '',
                    'parent_item_id' => '0',
                    'url' => '#',
                    'route' => '',
                    'font_awesome_class' => 'fas fa-user-circle',
                    'hide_name' => '1'
                ),
            array('id' => '19',
                    'name' => 'My Profile',
                    'compact_name' => 'my-profile',
                    'menu_id' => '4',
                    'order' => '1',
                    'access' => '3',
                    'type' => '3',
                    'lang_string' => 'menu.my_profile',
                    'parent_item_id' => '18',
                    'url' => '',
                    'route' => '',
                    'font_awesome_class' => 'far fa-user-cog',
                    'hide_name' => '1'
                ),
            array('id' => '20',
                    'name' => 'Logout',
                    'compact_name' => 'logout',
                    'menu_id' => '4',
                    'order' => '2',
                    'access' => '3',
                    'type' => '4',
                    'lang_string' => 'menu.logout',
                    'parent_item_id' => '18',
                    'url' => '',
                    'route' => 'logout',
                    'font_awesome_class' => 'fa fa-sign-out',
                    'hide_name' => '1'
                ),
           
       );
       
       foreach($menuItems as $key => $menuItem) {
           DB::table('menu_items')->insert([
               'id' => $menuItem['id'],
               'name' => $menuItem['name'],
               'compact_name' => $menuItem['compact_name'],
               'menu_id' => $menuItem['menu_id'],
               'order' => $menuItem['order'],
               'access' => $menuItem['access'],
               'type' => $menuItem['type'],
               'lang_string' => $menuItem['lang_string'],
               'parent_item_id' => $menuItem['parent_item_id'],
               'url' => $menuItem['url'],
               'route' => $menuItem['route'],
               'font_awesome_class' => $menuItem['font_awesome_class'],
               'hide_name' => $menuItem['hide_name'],
           ]);
       }
    }
}
