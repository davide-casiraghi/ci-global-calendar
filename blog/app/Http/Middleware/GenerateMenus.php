<?php

/*
    https://github.com/spatie/laravel-menu
    https://docs.spatie.be/menu/v2/introduction

    https://github.com/lavary/laravel-menu
*/

namespace App\Http\Middleware;

//use App\User;
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

        /*\Menu::make('MyNavBar', function ($menu) {
            $menu->add('Home')->prepend('<i class="fa fa-home"></i> ');

            $menu->add('About', ['action' => ['PostController@show', 'id' => 8]]);
                $menu->about->prepend('<i class="fa fa fa-info-circle"></i> ');
                $menu->about->add('Terms of use', ['action' => ['PostController@show', 'id' => 19]]);

            $menu->add('Get Involved', ['action' => ['PostController@show', 'id' => 16]]);
                $menu->getInvolved->prepend('<i class="fa fa-users"></i> ');

            $menu->add('How to', ['action' => ['PostController@show', 'id' => 20]]);
                $menu->howTo->prepend('<i class="fa fas fa-question-circle"></i> ');

        });*/

        \Menu::make('MyNavBar', function($menu) {
            $profile = $menu->add('Home')->prepend('<i class="fa fa-home"></i> ');
            $profile = $menu->add(__('menu.about'), ['action' => ['PostController@show', 'id' => 8]]);
                $profile->prepend('<i class="fa fa fa-info-circle"></i> ');
                $profile->add('Terms of use', ['action' => ['PostController@show', 'id' => 19]]);
                $profile->link->builder->items[2]->title = '<i class="far fa-file-alt"></i> '.__('menu.terms_of_use');
            $profile = $menu->add(__('menu.get_involved'), ['action' => ['PostController@show', 'id' => 16]]);
                $profile->prepend('<i class="fa fa-users"></i> ');
            $profile = $menu->add(__('menu.how_to'), ['action' => ['PostController@show', 'id' => 20]]);
                $profile->prepend('<i class="fa fas fa-question-circle"></i> ');
        });

        \Menu::make('MyNavBarRight', function ($menu) {
            $user = Auth::user();

            if ($user){


                /*$menu->add('Manager')->link->href('#');
                    $menu->manager->prepend('<i class="fa fas fa-edit"></i> ');
                    $menu->manager->add('Events', ['action' => ['EventController@index']]);
                        $menu->events->prepend('<i class="far fa-calendar-alt"></i> ');
                    $menu->manager->add('Venues', ['action' => ['EventVenueController@index']]);
                        $menu->venues->prepend('<i class="far fa-map-marker-alt"></i> ');
                    $menu->manager->add('Teachers', ['action' => ['TeacherController@index']]);
                        $menu->teachers->prepend('<i class="far fa-users"></i> ');
                    $menu->manager->add('Organizers', ['action' => ['OrganizerController@index']]);
                        $menu->organizers->prepend('<i class="fas fa-users"></i> ');
*/



                    $profile = $menu->add(__('menu.manager'));
                        $profile->prepend('<i class="fa fas fa-edit"></i> ');
                        $profile->link->href('#');

                        $profile->add('My Events', ['action' => ['EventController@index']]);
                        $profile->link->builder->items[1]->title = '<i class="far fa-calendar-alt"></i> '.__('menu.my_events');
                        $profile->add('My Venues', ['action' => ['EventVenueController@index']]);
                        $profile->link->builder->items[2]->title = '<i class="far fa-map-marker-alt"></i> '.__('menu.my_venues');
                        $profile->add('My Teachers', ['action' => ['TeacherController@index']]);
                        $profile->link->builder->items[3]->title = '<i class="far fa-users"></i> '.__('menu.my_teachers');
                        $profile->add('My Organizers', ['action' => ['OrganizerController@index']]);
                        $profile->link->builder->items[4]->title = '<i class="fas fa-users"></i> '.__('menu.my_organizers');



                if($user->isSuperAdmin()||$user->isAdmin()){
                    /*$menu->add('Admin tools')->link->href('#');
                        $menu->adminTools->prepend('<i class="far fa-cog"></i> ');
                        $menu->adminTools->add('Users', ['action' => ['UserController@index']]);
                            $menu->users->prepend('<i class="fas fa-user-alt"></i> ');
                        $menu->adminTools->add('Posts', ['action' => ['PostController@index']]);
                            $menu->posts->prepend('<i class="far fa-file-alt"></i> ');*/

                    $profile = $menu->add(__('menu.admin_tools'));
                        $profile->prepend('<i class="far fa-cog"></i> ');
                        $profile->link->href('#');

                        $profile->add('Users', ['action' => ['UserController@index']]);
                        $profile->link->builder->items[6]->title = '<i class="fas fa-user-alt"></i> '.__('menu.users');
                        $profile->add('Posts', ['action' => ['PostController@index']]);
                        $profile->link->builder->items[7]->title = '<i class="far fa-file-alt"></i> '.__('menu.posts');

                }

                if($user->isSuperAdmin()){
                    /*$menu->add('Settings')->link->href('#');
                        $menu->settings->prepend('<i class="far fa-cogs"></i> ');
                        $menu->settings->add('Post Categories', ['action' => ['CategoryController@index']]);
                            $menu->postCategories->prepend('<i class="far fa-tags"></i> ');
                        $menu->settings->add('Event Categories', ['action' => ['EventCategoryController@index']]);
                            $menu->eventCategories->prepend('<i class="fas fa-tags"></i> ');
                        $menu->settings->add('Continents', ['action' => ['ContinentController@index']]);
                            $menu->continents->prepend('<i class="fas fa-globe-americas"></i> ');
                        $menu->settings->add('Countries', ['action' => ['CountryController@index']]);
                            $menu->countries->prepend('<i class="far fa-globe-americas"></i> ');
                        $menu->settings->add('Background images', ['action' => ['BackgroundImageController@index']]);
                            $menu->backgroundImages->prepend('<i class="far fa-images"></i> ');
                    */
                    $profile = $menu->add(__('menu.settings'));
                        $profile->prepend('<i class="far fa-cogs"></i> ');
                        $profile->link->href('#');

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

                        //dd($profile);







                }

            }
            else{
                // https://stackoverflow.com/questions/39196968/laravel-5-3-new-authroutes
                // $menu->add('Login', ['action' => ['Auth\LoginController@login']]);
            }


        });

        return $next($request);
    }
}
