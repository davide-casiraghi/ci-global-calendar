<?php

namespace App\Http\Middleware;

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




            //$menu->add('search', ['action' => ['EventSearchController@index']]);

            /*$menu->add('About', 'posts/about');
                $menu->about->add('Info', 'info');
                    $menu->info->add('Ciao', 'ciao');*/

            //$menu->add('About',    ['route'  => 'events.index', 'class' => 'eww']);

            //$menu->add('About', ['action' => ['PostController@postdata', 'slug' => 'about-us']]);
            $menu->add('About', ['action' => ['PostController@show', 'id' => 8]]);
                $menu->about->prepend('<i class="fa fa fa-info-circle"></i> ');


                $menu->about->add('Terms of use', ['action' => ['PostController@show', 'id' => 19]]);
            //$menu->add('About',    ['route'  => ['posts', 'id' => 1]]);

            $menu->add('Get Involved', ['action' => ['PostController@show', 'id' => 16]]);
                $menu->getInvolved->prepend('<i class="fa fa-users"></i> ');

            $menu->add('How to', ['action' => ['PostController@show', 'id' => 20]]);
                $menu->howTo->prepend('<i class="fa fas fa-question-circle"></i> ');



            /*$menu->add('Admin', 'admin');
                $menu->admin->add('Posts', 'posts');
                $menu->admin->add('Categories', 'categories');*/

        });

        return $next($request);
    }
}
