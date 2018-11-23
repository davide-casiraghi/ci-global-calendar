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

        \Menu::make('MyNavBar', function ($menu) {
            $menu->add('Home')->prepend('<i class="fa fa-home"></i> ');

            $menu->add('About', ['action' => ['PostController@show', 'id' => 8]]);
                $menu->about->prepend('<i class="fa fa fa-info-circle"></i> ');
                $menu->about->add('Terms of use', ['action' => ['PostController@show', 'id' => 19]]);

            $menu->add('Get Involved', ['action' => ['PostController@show', 'id' => 16]]);
                $menu->getInvolved->prepend('<i class="fa fa-users"></i> ');

            $menu->add('How to', ['action' => ['PostController@show', 'id' => 20]]);
                $menu->howTo->prepend('<i class="fa fas fa-question-circle"></i> ');

        });

        \Menu::make('MyNavBarRight', function ($menu) {
            $user = Auth::user();

            if ($user){
                if($user->isSuperAdmin()||$user->isAdmin()){
                    $menu->add('Manager', ['link' => ['#']]);
                        $menu->manager->prepend('<i class="fa fas fa-edit"></i> ');
                        $menu->manager->add('Users', ['action' => ['UserController@index']]);
                            $menu->users->prepend('<i class="fas fa-user-alt"></i> ');
                        $menu->manager->add('Posts', ['action' => ['PostController@index']]);
                            $menu->posts->prepend('<i class="far fa-file-alt"></i> ');
                        $menu->manager->add('Post Categories', ['action' => ['CategoryController@index']]);
                            $menu->postCategories->prepend('<i class="far fa-tags"></i> ');
                        $menu->manager->add('Events', ['action' => ['EventController@index']]);
                            $menu->events->prepend('<i class="far fa-calendar-alt"></i> ');
                        $menu->manager->add('Event Categories', ['action' => ['EventCategoryController@index']]);
                            $menu->eventCategories->prepend('<i class="fas fa-tags"></i> ');
                        $menu->manager->add('Venues', ['action' => ['EventVenueController@index']]);
                            $menu->venues->prepend('<i class="far fa-map-marker-alt"></i> ');
                        $menu->manager->add('Teachers', ['action' => ['TeacherController@index']]);
                            $menu->teachers->prepend('<i class="far fa-users"></i> ');
                        $menu->manager->add('Organizers', ['action' => ['OrganizerController@index']]);
                            $menu->organizers->prepend('<i class="fas fa-users"></i> ');

                }

                if($user->isSuperAdmin()){
                    $menu->add('Settings', ['link' => ['#'],'inactive']);
                        $menu->settings->prepend('<i class="far fa-cog"></i> ');
                        $menu->settings->add('Continents', ['action' => ['ContinentController@index']]);
                            $menu->continents->prepend('<i class="fas fa-globe-americas"></i> ');
                        $menu->settings->add('Countries', ['action' => ['CountryController@index']]);
                            $menu->countries->prepend('<i class="far fa-globe-americas"></i> ');
                        $menu->settings->add('Background images', ['action' => ['BackgroundImageController@index']]);
                            $menu->backgroundImages->prepend('<i class="far fa-images"></i> ');
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
