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

        \Menu::make('MyNavBar', function($menu) {
            $profile = $menu->add(__('menu.home'))->prepend('<i class="fa fa-home"></i> ');
            $profile = $menu->add(__('menu.about'), ['action' => ['PostController@show', 'id' => 8]]);
                $profile->prepend('<i class="fa fa fa-info-circle"></i> ');
                $profile->add('Terms of use', ['action' => ['PostController@show', 'id' => 19]]);
                $profile->link->builder->items[2]->title = '<i class="far fa-file-alt"></i> '.__('menu.terms_of_use');
                $profile->add('Teachers directory', ['route' => ['teachers.directory']]); 
                $profile->link->builder->items[3]->title = '<i class="far fa-users"></i> '.__('menu.teachers_directory');
            
            $profile = $menu->add(__('menu.get_involved'), ['action' => ['PostController@show', 'id' => 16]]);
                $profile->prepend('<i class="fa fa-users"></i> ');
            $profile = $menu->add(__('menu.help'), ['action' => ['PostController@show', 'id' => 41]]);
                $profile->prepend('<i class="fa fas fa-question-circle"></i> ');
        });

        \Menu::make('MyNavBarRight', function ($menu) {
            $user = Auth::user();

            if ($user){

                    $profile = $menu->add(__('menu.manager'));
                        $profile->prepend('<i class="fa fas fa-edit"></i> ');
                        $profile->link->href('#');

                        $profile->add('New event', ['action' => ['EventController@create']]);
                        $profile->link->builder->items[1]->title = '<i class="fa fas fa-plus-circle "></i> '.__('menu.new_event');
                        $profile->add('My Events', ['action' => ['EventController@index']]);
                        $profile->link->builder->items[2]->title = '<i class="far fa-calendar-alt"></i> '.__('menu.my_events');
                        $profile->add('My Venues', ['action' => ['EventVenueController@index']]);
                        $profile->link->builder->items[3]->title = '<i class="far fa-map-marker-alt"></i> '.__('menu.my_venues');
                        $profile->add('My Teachers', ['route' => ['teachers.index']]); 
                        $profile->link->builder->items[4]->title = '<i class="far fa-users"></i> '.__('menu.my_teachers');
                        $profile->add('My Organizers', ['action' => ['OrganizerController@index']]);
                        $profile->link->builder->items[5]->title = '<i class="fas fa-users"></i> '.__('menu.my_organizers');
                        //$profile->add('My Profile', ['action' => ['UserController@edit', 'id' => $user->id]]);
                        //$profile->link->builder->items[6]->title = '<i class="fa far fa-user"></i> '.__('menu.my_profile');

                if($user->isSuperAdmin()||$user->isAdmin()){

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
