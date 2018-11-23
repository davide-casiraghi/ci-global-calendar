<?php

/*
    https://github.com/spatie/laravel-menu
    https://docs.spatie.be/menu/v2/introduction
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

        // Get the currently authenticated user...
        $user = Auth::user();

        if ($user){
            if($user->isSuperAdmin()){
                //dd("ciao admin");
            }
        }

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

        return $next($request);
    }
}
