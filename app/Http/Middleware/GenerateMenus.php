<?php

/*
    https://github.com/lavary/laravel-menu

    evaluate if to change with:
    - https://github.com/spatie/laravel-menu
    - https://docs.spatie.be/menu/v2/introduction
*/

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;


use Closure;

class GenerateMenus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        /* LEFT Menu */
        \Menu::make('MyNavBar', function($menu) {
            
            $profile = $menu->add("home")->link->href('/');
                $profile->builder->items[0]->title = '<i class="fa fa-home"></i> '.__('menu.home');
            $profile = $menu->add("about")->link->href('/post/about');
                $profile->builder->items[1]->title = '<i class="fa fa fa-info-circle"></i> '.__('menu.about');
                $menu->about->add("terms_of_use")->link->href('/post/terms-of-use');
                    $profile->builder->items[2]->title = '<i class="far fa-file-alt"></i> '.__('menu.terms_of_use');
                $menu->about->add('teachers_directory', ['route' => ['teachers.directory']]); 
                    $profile->builder->items[3]->title = '<i class="far fa-users"></i> '.__('menu.teachers_directory');
            $profile = $menu->add("get_involved")->link->href('/post/get-involved');
                $profile->builder->items[4]->title = '<i class="fa fa-users"></i> '.__('menu.get_involved');
            $profile = $menu->add("help")->link->href('/post/how-to-insert-contents');
                $profile->builder->items[5]->title = '<i class="fa fas fa-question-circle"></i> '.__('menu.help');
        });

        /* RIGHT Menu */
        \Menu::make('MyNavBarRight', function ($menu) {
            $user = Auth::user();

            if ($user){
                
                /* Manager */
                $profile = $menu->add("manager")->link->href('#');
                    $profile->builder->items[0]->title = '<i class="fa fas fa-edit"></i> '.__('menu.manager');
                    $menu->manager->add('new_event', ['route' => ['events.create']]); 
                        $profile->builder->items[1]->title = '<i class="fa fas fa-plus-circle"></i> '.__('menu.new_event');
                    $menu->manager->add('my_events', ['route' => ['events.index']]); 
                        $profile->builder->items[2]->title = '<i class="far fa-calendar-alt"></i> '.__('menu.my_events');
                    $menu->manager->add('my_venues', ['route' => ['eventVenues.index']]); 
                        $profile->builder->items[3]->title = '<i class="far fa-map-marker-alt"></i> '.__('menu.my_venues');
                    $menu->manager->add('my_teachers', ['route' => ['teachers.index']]); 
                        $profile->builder->items[4]->title = '<i class="far fa-users"></i> '.__('menu.my_teachers');
                    $menu->manager->add('my_organizers', ['route' => ['organizers.index']]); 
                        $profile->builder->items[5]->title = '<i class="fas fa-users"></i> '.__('menu.my_organizers');
                    
                        

                if($user->isSuperAdmin()||$user->isAdmin()){
                
                    /* Admin tools */
                    $profile = $menu->add(__('menu.admin_tools'));
                        $profile->prepend('<i class="far fa-cog"></i> ');
                        $profile->link->href('#');

                        $profile->add('Users', ['action' => ['UserController@index']]);
                        $profile->link->builder->items[7]->title = '<i class="fas fa-user-alt"></i> '.__('menu.users');
                        $profile->add('Posts', ['action' => ['PostController@index']]);
                        $profile->link->builder->items[8]->title = '<i class="far fa-file-alt"></i> '.__('menu.posts');

                        if($user->isSuperAdmin()){
                            $profile->add('Post Categories', ['action' => ['CategoryController@index']]);
                                $profile->link->builder->items[9]->title = '<i class="far fa-tags"></i> '.__('menu.posts_categories');
                            $profile->add('Event Categories', ['action' => ['EventCategoryController@index']]);
                                $profile->link->builder->items[10]->title = '<i class="fas fa-tags"></i> '.__('menu.event_categories');
                            $profile->add('Continents', ['action' => ['ContinentController@index']]);
                                $profile->link->builder->items[11]->title = '<i class="fas fa-globe-americas"></i> '.__('menu.continents');
                            $profile->add('Countries', ['action' => ['CountryController@index']]);
                                $profile->link->builder->items[12]->title = '<i class="far fa-globe-americas"></i> '.__('menu.countries');
                            $profile->add('Background images', ['action' => ['BackgroundImageController@index']]);
                                $profile->link->builder->items[13]->title = '<i class="far fa-images"></i> '.__('menu.background_images');
                        }
                }
            }
        });

        return $next($request);
    }
}
